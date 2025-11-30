<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/includes/db.php';

$pdo = getDb();
$restaurantId = 1; // Hard-coded for now
$restaurant = null;
$categoriesData = [];

// Get category_id from URL parameter
$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$currentCategory = null;
$currentCategoryProducts = [];

// If category_id is provided, validate it exists and belongs to our restaurant
if ($categoryId) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id AND restaurant_id = :restaurant_id LIMIT 1");
        $stmt->bindParam(':id', $categoryId);
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();
        $currentCategory = $stmt->fetch();
        
        // If category exists, load its products
        if ($currentCategory) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = :category_id AND is_active = 1 ORDER BY sort_order, id");
            $stmt->bindParam(':category_id', $categoryId);
            $stmt->execute();
            $currentCategoryProducts = $stmt->fetchAll();
        } else {
            // Category doesn't exist or doesn't belong to this restaurant, reset categoryId
            $categoryId = null;
        }
    } catch (PDOException $e) {
        // Error occurred, treat as if no category_id was provided
        $categoryId = null;
        $currentCategory = null;
        $currentCategoryProducts = [];
    }
}

// Load restaurant information
try {
    // Always try to load all data, fall back gracefully if columns don't exist
    $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $restaurantId);
    $stmt->execute();
    $restaurant = $stmt->fetch();
    
    // Ensure missing columns have default values
    if ($restaurant) {
        if (!isset($restaurant['instagram_url'])) {
            $restaurant['instagram_url'] = '';
        }
        if (!isset($restaurant['show_instagram'])) {
            $restaurant['show_instagram'] = 0;
        }
        if (!isset($restaurant['logo_path'])) {
            $restaurant['logo_path'] = '';
        }
    }
} catch (PDOException $e) {
    // If error (e.g., column doesn't exist), try basic query
    try {
        $stmt = $pdo->prepare("SELECT id, name, slug FROM restaurants WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $restaurantId);
        $stmt->execute();
        $restaurant = $stmt->fetch();
        
        // Add default values for missing columns
        if ($restaurant) {
            $restaurant['instagram_url'] = '';
            $restaurant['show_instagram'] = 0;
            $restaurant['logo_path'] = '';
        }
    } catch (PDOException $e2) {
        // Handle error silently for public page
        $restaurant = null;
    }
}

// Load categories for the restaurant only if we're in category list mode (no specific category selected)
if (!$categoryId) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE restaurant_id = :restaurant_id ORDER BY sort_order, id");
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
        // For each category, load its active products count and cover image
        foreach ($categories as $category) {
            try {
                // Get active products for this category
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = :category_id AND is_active = 1 ORDER BY sort_order, id");
                $stmt->bindParam(':category_id', $category['id']);
                $stmt->execute();
                $products = $stmt->fetchAll();
                
                // Only include categories that have active products
                if (!empty($products)) {
                    // Get product count
                    $productCount = count($products);
                    
                    // Get cover image (first product with an image)
                    $coverImage = null;
                    foreach ($products as $product) {
                        if (!empty($product['image'])) {
                            $coverImage = $product['image'];
                            break;
                        }
                    }
                    
                    $categoriesData[] = [
                        'category' => $category,
                        'productCount' => $productCount,
                        'coverImage' => $coverImage
                    ];
                }
            } catch (PDOException $e) {
                // Skip this category if there's an error
                continue;
            }
        }
    } catch (PDOException $e) {
        // Handle error silently for public page
        $categoriesData = [];
    }
}

include __DIR__ . '/../app/views/header.php';
?>

<!-- Main Content Container with custom background -->
<div>
    <div class="container">
        
        <!-- Restaurant Logo -->
        <?php if ($restaurant && !empty($restaurant['logo_path'])): ?>
            <div class="text-center mb-4 restaurant-logo-container">
                <img src="<?= htmlspecialchars($restaurant['logo_path']) ?>" 
                     alt="<?= htmlspecialchars($restaurant['name'] ?? 'Restaurant Logo') ?>" 
                     class="img-fluid restaurant-logo"
                     onerror="this.style.display='none';">
            </div>
        <?php endif; ?>
        
        <?php if (!$categoryId): ?>
            <!-- CATEGORY LIST MODE -->
            
            <!-- Search Bar -->
            <div class="search-wrapper my-4">
                <div class="rounded-pill bg-white shadow-sm px-4 py-3 d-flex align-items-center" style="border:2px solid #145c46;">
                    <span class="me-3 primary-green fs-5">🔍</span>
                    <input type="text" id="categorySearch" class="form-control border-0 shadow-0" placeholder="<?= t('menu.search_placeholder') ?>" />
                </div>
            </div>

            <!-- Menu Title Section -->
            <div class="text-center my-5">
                <h2 class="fw-bold fs-1 primary-green mb-3"><?= t('menu.title') ?></h2>
                <div class="menu-underline mt-2"></div>
            </div>

            <?php if (empty($categoriesData)): ?>
                <!-- Empty State -->
                <div class="text-center my-5">
                    <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width:420px; background:#fff;">
                        <div class="card-body py-5">
                            <div class="mb-3">
                                <span style="font-size: 3rem;">🍽️</span>
                            </div>
                            <h5 class="fw-bold mb-3 primary-green"><?= t('menu.no_categories') ?></h5>
                            <p class="text-muted mb-0"><?= t('menu.no_categories_desc') ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Category Cards Section -->
                <div class="row g-4 mb-5">
                    <?php foreach ($categoriesData as $categoryDataItem): ?>
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2-4 category-item" data-name="<?= htmlspecialchars(strtolower(getLocalizedCategoryName($categoryDataItem['category']))) ?>">
                            <a href="/menu.php?category_id=<?= (int)$categoryDataItem['category']['id'] ?>" class="text-decoration-none text-dark">
                                <div class="card border-0 shadow-sm rounded-4 h-100 category-card" style="overflow: hidden;">
                                    <?php if (!empty($categoryDataItem['coverImage'])): ?>
                                        <img src="<?= htmlspecialchars($categoryDataItem['coverImage']) ?>" 
                                             class="card-img-top" 
                                             style="height:180px; object-fit:cover;" 
                                             alt="<?= htmlspecialchars(getLocalizedCategoryName($categoryDataItem['category'])) ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center" style="height:180px; background:linear-gradient(135deg, #e0ddd7, #d4d1cb);">
                                            <span style="font-size: 3rem; opacity: 0.6;">🍽️</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body d-flex flex-column justify-content-between p-4">
                                        <h5 class="card-title fw-bold mb-3 primary-green">
                                            <?= htmlspecialchars(getLocalizedCategoryName($categoryDataItem['category'])) ?>
                                        </h5>
                                        <span class="badge rounded-pill px-3 py-2 badge-custom align-self-start">
                                            <?= t('menu.items_count', ['count' => (int)$categoryDataItem['productCount']]) ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- CATEGORY DETAIL MODE -->
            
            <?php if (!$currentCategory): ?>
                <!-- Category not found -->
                <div class="text-center my-5">
                    <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width:420px; background:#fff;">
                        <div class="card-body py-5">
                            <div class="mb-3">
                                <span style="font-size: 3rem;">❌</span>
                            </div>
                            <h5 class="fw-bold mb-3 primary-green"><?= t('menu.category_not_found') ?></h5>
                            <p class="text-muted mb-3"><?= t('menu.category_not_found_desc') ?></p>
                            <a href="/menu.php" class="btn back-button bg-primary-green text-white">
                                <i class="fas fa-arrow-left me-2"></i><?= t('menu.back_to_categories') ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Category Header with Back Button -->
                <div class="d-flex align-items-center justify-content-between mb-4 back-button-container">
                    <a href="/menu.php" class="btn back-button">
                        <i class="fas fa-arrow-left me-2"></i><?= t('menu.back_to_categories') ?>
                    </a>
                </div>
                
                <!-- Category Title -->
                <div class="text-center my-5">
                    <h2 class="fw-bold fs-1 primary-green mb-3"><?= htmlspecialchars(getLocalizedCategoryName($currentCategory)) ?></h2>
                    <div class="menu-underline mt-2"></div>
                </div>
                
                <!-- Search Bar for Products -->
                <div class="search-wrapper my-4">
                    <div class="rounded-pill bg-white shadow-sm px-4 py-3 d-flex align-items-center" style="border:2px solid #145c46;">
                        <span class="me-3 primary-green fs-5">🔍</span>
                        <input type="text" id="productSearch" class="form-control border-0 shadow-0" placeholder="<?= t('menu.search_placeholder_products') ?>" />
                    </div>
                </div>
                
                <?php if (empty($currentCategoryProducts)): ?>
                    <!-- No products in this category -->
                    <div class="text-center my-5">
                        <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width:420px; background:#fff;">
                            <div class="card-body py-5">
                                <div class="mb-3">
                                    <span style="font-size: 3rem;">🍽️</span>
                                </div>
                                <h5 class="fw-bold mb-3 primary-green"><?= t('menu.no_products') ?></h5>
                                <p class="text-muted mb-0"><?= t('menu.no_products_desc') ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Products Grid -->
                    <div class="row g-4 product-grid mb-5">
                        <?php foreach ($currentCategoryProducts as $product): ?>
                            <div class="col-6 col-md-4 col-lg-3 product-item" data-name="<?= htmlspecialchars(strtolower(getLocalizedProductName($product))) ?>" data-description="<?= htmlspecialchars(strtolower(getLocalizedProductDescription($product))) ?>">
                                <div class="card h-100 border-0 shadow-sm rounded-4 product-card">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>" 
                                             class="card-img-top rounded-4" 
                                             style="height:200px; object-fit:cover;" 
                                             alt="<?= htmlspecialchars(getLocalizedProductName($product)) ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center rounded-4" style="height:200px; background:linear-gradient(135deg, #f1f5f3, #e8ede9);">
                                            <span style="font-size: 2rem; opacity: 0.6;">🍽️</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body d-flex flex-column p-4">
                                        <h5 class="card-title fw-bold mb-2 primary-green">
                                            <?= htmlspecialchars(getLocalizedProductName($product)) ?>
                                        </h5>
                                        <?php $localizedDescription = getLocalizedProductDescription($product); ?>
                                        <?php if (!empty(trim($localizedDescription))): ?>
                                            <p class="card-text text-muted small mb-3 flex-grow-1">
                                                <?= nl2br(htmlspecialchars($localizedDescription)) ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <span class="fw-bold fs-5 primary-green">
                                                <?= number_format((float)$product['price'], 2) ?> TL
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Footer Info -->
        <div class="text-center mt-5 mb-4 pt-5">
            <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width: 400px; background: #fff;">
                <div class="card-body py-4">
                    <p class="text-muted mb-3">
                        <i class="fas fa-heart text-danger me-2"></i>
                        <strong class="primary-green">
                            <?= $restaurant ? htmlspecialchars($restaurant['name']) : 'Restaurant' ?>
                        </strong>
                        <br>
                        <small><?= t('menu.digital_menu') ?></small>
                    </p>
                    
                    <?php if ($restaurant && !empty($restaurant['show_instagram']) && !empty($restaurant['instagram_url'])): ?>
                        <div class="d-flex justify-content-center">
                            <a href="<?= htmlspecialchars($restaurant['instagram_url']) ?>" 
                               target="_blank" 
                               class="btn btn-sm rounded-pill px-4 py-2 fw-bold text-white shadow-sm"
                               style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); border: none; transition: transform 0.2s ease;"
                               onmouseover="this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.transform='translateY(0)'">
                                <i class="fab fa-instagram me-2"></i>
                                <?= t('menu.follow_instagram') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Sidebar Population Script ---
    const sidebarNav = document.querySelector('.public-sidebar-nav');
    if (sidebarNav) {
        // Clear any existing items
        sidebarNav.innerHTML = '';

        // Add a "Home" or "All Categories" link
        const homeLink = document.createElement('a');
        homeLink.href = '/menu.php';
        homeLink.textContent = '<?= t('menu.all_categories') ?>';
        if (!<?= isset($_GET['category_id']) ? 'true' : 'false' ?>) {
            homeLink.classList.add('active');
        }
        sidebarNav.appendChild(homeLink);

        // Add a divider
        const divider = document.createElement('hr');
        divider.style.borderColor = 'rgba(255,255,255,0.1)';
        sidebarNav.appendChild(divider);

        // Populate with categories from the page
        const categoryItems = document.querySelectorAll('.category-item');
        
        if (categoryItems.length > 0) {
            categoryItems.forEach(function(item) {
                const link = item.querySelector('a');
                const titleEl = item.querySelector('.card-title');
                
                if(link && titleEl) {
                    const newLink = document.createElement('a');
                    newLink.href = link.href;
                    newLink.textContent = titleEl.textContent.trim();

                    // Check if this category is the currently active one
                    const urlParams = new URLSearchParams(new URL(link.href).search);
                    const catId = urlParams.get('category_id');
                    if (catId && catId === '<?= $categoryId ?? "null" ?>') {
                        newLink.classList.add('active');
                    }

                    sidebarNav.appendChild(newLink);
                }
            });
        }
    }
});
</script>

<?php include __DIR__ . '/../app/views/footer.php'; ?>