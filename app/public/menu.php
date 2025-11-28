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
    $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $restaurantId);
    $stmt->execute();
    $restaurant = $stmt->fetch();
} catch (PDOException $e) {
    // Handle error silently for public page
    $restaurant = null;
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

<style>
/* Custom Styling for Modern Light Theme */
body {
    background: #f6f3ee;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.primary-green {
    color: #145c46;
}

.bg-primary-green {
    background-color: #145c46;
}

.border-primary-green {
    border-color: #145c46;
}

.search-wrapper input {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
}

.search-wrapper input:focus {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
}

.category-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .75rem 1.5rem rgba(0, 0, 0, .15) !important;
}

.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .12) !important;
}

.rounded-4 {
    border-radius: 1rem !important;
}

.category-card img {
    transition: transform 0.3s ease-in-out;
}

.category-card:hover img {
    transform: scale(1.05);
}

.badge-custom {
    background: #f1f5f3;
    color: #145c46;
    border: 1px solid #c9d7cf;
    font-weight: 500;
}

.menu-underline {
    width: 80px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(to right, #145c46, #3bb273);
    margin: 0 auto;
}

.category-card-active .card {
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    border: 2px solid #145c46;
    transform: translateY(-2px);
}
</style>

<!-- Main Content Container with custom background -->
<div style="background: #f6f3ee; min-height: 100vh; padding-top: 2rem;">
    <div class="container">
        
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
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 category-item" data-name="<?= htmlspecialchars(strtolower(getLocalizedCategoryName($categoryDataItem['category']))) ?>"
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
                            <a href="/menu.php" class="btn bg-primary-green text-white rounded-pill px-4"><?= t('menu.back_to_categories') ?></a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Category Header with Back Button -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <a href="/menu.php" class="btn btn-outline-success rounded-pill px-4">
                        <?= t('menu.back_to_categories') ?>
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
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 product-item" data-name="<?= htmlspecialchars(strtolower(getLocalizedProductName($product))) ?>" data-description="<?= htmlspecialchars(strtolower(getLocalizedProductDescription($product))) ?>">
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
                    <p class="text-muted mb-0">
                        <i class="fas fa-heart text-danger me-2"></i>
                        <strong class="primary-green">
                            <?= $restaurant ? htmlspecialchars($restaurant['name']) : 'Restaurant' ?>
                        </strong>
                        <br>
                        <small><?= t('menu.digital_menu') ?></small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category search functionality (category list mode)
    const categorySearch = document.getElementById('categorySearch');
    if (categorySearch) {
        categorySearch.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const categoryItems = document.querySelectorAll('.category-item');
            
            categoryItems.forEach(function(item) {
                const categoryName = item.getAttribute('data-name') || '';
                const isMatch = categoryName.includes(searchTerm);
                
                if (searchTerm === '' || isMatch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    // Product search functionality (category detail mode)
    const productSearch = document.getElementById('productSearch');
    if (productSearch) {
        productSearch.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const productItems = document.querySelectorAll('.product-item');
            
            productItems.forEach(function(item) {
                const productName = item.getAttribute('data-name') || '';
                const productDescription = item.getAttribute('data-description') || '';
                
                const isMatch = productName.includes(searchTerm) || productDescription.includes(searchTerm);
                
                if (searchTerm === '' || isMatch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    // Smooth scrolling for category pills
    const categoryPills = document.querySelector('.category-pills');
    if (categoryPills) {
        categoryPills.style.scrollBehavior = 'smooth';
    }
});
</script>

<?php include __DIR__ . '/../app/views/footer.php'; ?>