<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/includes/db.php';
require_once __DIR__ . '/../../app/includes/auth.php';

requireLogin();

$pdo = getDb();
$message = '';
$error = '';
$editProduct = null;

// Load categories for restaurant_id = 1
try {
    $stmt = $pdo->prepare("SELECT id, name FROM categories WHERE restaurant_id = 1 ORDER BY sort_order, id");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Error loading categories: ' . $e->getMessage();
    $categories = [];
}

// Get filter category_id if provided
$filterCategoryId = $_GET['category_id'] ?? '';
if ($filterCategoryId && !is_numeric($filterCategoryId)) {
    $filterCategoryId = '';
}

// Validate filter category belongs to restaurant
if ($filterCategoryId) {
    $validCategory = false;
    foreach ($categories as $cat) {
        if ($cat['id'] == $filterCategoryId) {
            $validCategory = true;
            break;
        }
    }
    if (!$validCategory) {
        $filterCategoryId = '';
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $name_en = trim($_POST['name_en'] ?? '');
        $name_de = trim($_POST['name_de'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $description_en = trim($_POST['description_en'] ?? '');
        $description_de = trim($_POST['description_de'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $imagePath = null;
        
        // Handle image upload
        if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $originalName = basename($_FILES['image']['name']);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $safeExtension = strtolower($extension);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (in_array($safeExtension, $allowedExtensions)) {
                $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $safeExtension;
                $uploadDir = __DIR__ . '/../uploads/products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = '/uploads/products/' . $fileName;
                }
            }
        }
        
        // Validate
        if (empty($name)) {
            $error = 'Product name is required';
        } else {
            // Validate category belongs to restaurant
            $validCategory = false;
            foreach ($categories as $cat) {
                if ($cat['id'] == $categoryId) {
                    $validCategory = true;
                    break;
                }
            }
            
            if (!$validCategory) {
                $error = 'Please select a valid category';
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, name_en, name_de, image, description, description_en, description_de, price, is_active, sort_order) VALUES (:category_id, :name, :name_en, :name_de, :image, :description, :description_en, :description_de, :price, :is_active, :sort_order)");
                    $stmt->bindParam(':category_id', $categoryId);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':name_en', $name_en);
                    $stmt->bindParam(':name_de', $name_de);
                    $stmt->bindParam(':image', $imagePath);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':description_en', $description_en);
                    $stmt->bindParam(':description_de', $description_de);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':is_active', $isActive);
                    $stmt->bindParam(':sort_order', $sortOrder);
                    $stmt->execute();
                    
                    $redirectUrl = '/admin/products.php';
                    if ($filterCategoryId) {
                        $redirectUrl .= '?category_id=' . $filterCategoryId;
                    }
                    header('Location: ' . $redirectUrl);
                    exit;
                } catch (PDOException $e) {
                    $error = 'Error adding product: ' . $e->getMessage();
                }
            }
        }
    } elseif ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $name_en = trim($_POST['name_en'] ?? '');
        $name_de = trim($_POST['name_de'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $description_en = trim($_POST['description_en'] ?? '');
        $description_de = trim($_POST['description_de'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        
        // Get existing product data for current image
        $existingProduct = null;
        try {
            $stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $existingProduct = $stmt->fetch();
        } catch (PDOException $e) {
            // Continue with null existing product
        }
        
        $imagePath = $existingProduct['image'] ?? null;
        
        // Handle image upload
        if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $originalName = basename($_FILES['image']['name']);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $safeExtension = strtolower($extension);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (in_array($safeExtension, $allowedExtensions)) {
                $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $safeExtension;
                $uploadDir = __DIR__ . '/../uploads/products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = '/uploads/products/' . $fileName;
                }
            }
        }
        
        if (empty($name)) {
            $error = 'Product name is required';
        } else {
            // Validate category
            $validCategory = false;
            foreach ($categories as $cat) {
                if ($cat['id'] == $categoryId) {
                    $validCategory = true;
                    break;
                }
            }
            
            if (!$validCategory) {
                $error = 'Please select a valid category';
            } else {
                try {
                    $stmt = $pdo->prepare("UPDATE products SET category_id = :category_id, name = :name, name_en = :name_en, name_de = :name_de, image = :image, description = :description, description_en = :description_en, description_de = :description_de, price = :price, is_active = :is_active, sort_order = :sort_order WHERE id = :id");
                    $stmt->bindParam(':category_id', $categoryId);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':name_en', $name_en);
                    $stmt->bindParam(':name_de', $name_de);
                    $stmt->bindParam(':image', $imagePath);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':description_en', $description_en);
                    $stmt->bindParam(':description_de', $description_de);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':is_active', $isActive);
                    $stmt->bindParam(':sort_order', $sortOrder);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    
                    $redirectUrl = '/admin/products.php';
                    if ($filterCategoryId) {
                        $redirectUrl .= '?category_id=' . $filterCategoryId;
                    }
                    header('Location: ' . $redirectUrl);
                    exit;
                } catch (PDOException $e) {
                    $error = 'Error updating product: ' . $e->getMessage();
                }
            }
        }
    }
}

// Handle GET actions
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $deleteId);
        $stmt->execute();
        
        $redirectUrl = '/admin/products.php';
        if ($filterCategoryId) {
            $redirectUrl .= '?category_id=' . $filterCategoryId;
        }
        header('Location: ' . $redirectUrl);
        exit;
    } catch (PDOException $e) {
        $error = 'Error deleting product: ' . $e->getMessage();
    }
}

// Handle edit form
if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.restaurant_id FROM products p JOIN categories c ON c.id = p.category_id WHERE p.id = :id AND c.restaurant_id = 1");
        $stmt->bindParam(':id', $editId);
        $stmt->execute();
        $editProduct = $stmt->fetch();
        
        if (!$editProduct) {
            $error = 'Product not found';
        }
    } catch (PDOException $e) {
        $error = 'Error fetching product: ' . $e->getMessage();
    }
}

// Fetch products
try {
    $sql = "SELECT p.*, c.name AS category_name 
            FROM products p 
            JOIN categories c ON c.id = p.category_id 
            WHERE c.restaurant_id = 1";
    
    if ($filterCategoryId) {
        $sql .= " AND p.category_id = :category_id";
    }
    
    $sql .= " ORDER BY c.sort_order, c.id, p.sort_order, p.id";
    
    $stmt = $pdo->prepare($sql);
    if ($filterCategoryId) {
        $stmt->bindParam(':category_id', $filterCategoryId);
    }
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Error fetching products: ' . $e->getMessage();
    $products = [];
}

?>
<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.products') ?> - QR Menu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/admin.css" rel="stylesheet">
    <style>
    .language-switcher {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .language-switcher .btn {
        border-radius: 20px;
        font-size: 0.85em;
        padding: 5px 12px;
        margin: 2px;
        min-width: 45px;
        border: none;
        background: transparent;
        color: #666;
        transition: all 0.2s ease;
    }
    
    .language-switcher .btn:hover {
        background: #f8f9fa;
        color: #333;
        transform: translateY(-1px);
    }
    
    .language-switcher .btn.active {
        background: #145c46;
        color: white;
        font-weight: 500;
    }
    </style>
</head>
<body class="admin-body">
    <!-- Language Switcher -->
    <div class="language-switcher">
        <?php 
        $supportedLangs = getSupportedLanguages();
        $currentLang = getCurrentLangCode();
        ?>
        <?php foreach ($supportedLangs as $langCode => $langInfo): ?>
            <a href="<?= buildLanguageUrl($langCode) ?>" 
               class="btn btn-sm <?= $currentLang === $langCode ? 'active' : '' ?>"
               title="<?= htmlspecialchars($langInfo['name']) ?>">
                <?= strtoupper($langCode) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="admin-layout">
        <div class="admin-sidebar">
            <a href="/admin/dashboard.php" class="admin-sidebar-brand"><?= t('admin.title') ?></a>
            
            <nav class="admin-sidebar-nav">
                <a href="/admin/dashboard.php"><?= t('admin.dashboard') ?></a>
                <a href="/admin/categories.php"><?= t('admin.categories') ?></a>
                <a href="/admin/products.php" class="active"><?= t('admin.products') ?></a>
                <a href="/admin/tables.php"><?= t('admin.tables') ?></a>
            </nav>
            
            <div class="admin-sidebar-footer">
                <a href="/admin/logout.php"><?= t('admin.logout') ?></a>
            </div>
        </div>
        
        <div class="admin-content">
            <div class="admin-topbar">
                <h1 class="admin-page-title">Products</h1>
                <a href="/admin/dashboard.php" class="btn btn-primary-soft">← Dashboard</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Sidebar with Filter and Add Product Form -->
                <div class="col-lg-4">
                    <!-- Filter Form -->
                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h6 class="admin-card-title">Filter Products</h6>
                        </div>
                        <form method="GET">
                            <div class="mb-3">
                                <label for="filter_category" class="form-label">Category</label>
                                <select class="form-select" id="filter_category" name="category_id">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" 
                                            <?= $filterCategoryId == $category['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary-soft btn-sm">Filter</button>
                            <?php if ($filterCategoryId): ?>
                                <a href="/admin/products.php" class="btn btn-outline-secondary btn-sm">Clear</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <!-- Add/Edit Product Form -->
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6 class="admin-card-title"><?= $editProduct ? t('admin.edit_product') : t('admin.add_product') ?></h6>
                        </div>
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($editProduct): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label"><?= t('admin.category') ?></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" 
                                    <?= ($editProduct && $editProduct['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label"><?= t('admin.product_name_tr') ?></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name_en" class="form-label"><?= t('admin.product_name_en') ?></label>
                        <input type="text" class="form-control" id="name_en" name="name_en" 
                               value="<?= htmlspecialchars($editProduct['name_en'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="name_de" class="form-label"><?= t('admin.product_name_de') ?></label>
                        <input type="text" class="form-control" id="name_de" name="name_de" 
                               value="<?= htmlspecialchars($editProduct['name_de'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label"><?= t('admin.product_description_tr') ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description_en" class="form-label"><?= t('admin.product_description_en') ?></label>
                        <textarea class="form-control" id="description_en" name="description_en" rows="3"><?= htmlspecialchars($editProduct['description_en'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description_de" class="form-label"><?= t('admin.product_description_de') ?></label>
                        <textarea class="form-control" id="description_de" name="description_de" rows="3"><?= htmlspecialchars($editProduct['description_de'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label"><?= t('admin.price') ?></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="price" name="price" 
                                   step="0.01" min="0" value="<?= $editProduct['price'] ?? '' ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label"><?= t('admin.sort_order') ?></label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" 
                               value="<?= $editProduct['sort_order'] ?? 0 ?>" min="0">
                        <div class="form-text">Lower numbers appear first</div>
                    </div>
                    
                    <?php if ($editProduct && !empty($editProduct['image'])): ?>
                        <div class="mb-2">
                            <img src="<?= htmlspecialchars($editProduct['image']) ?>" alt="Ürün fotoğrafı" class="img-fluid rounded" style="max-height: 120px;">
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label"><?= t('admin.image') ?></label>
                        <input type="file" name="image" class="form-control">
                        <div class="form-text">Opsiyonel. JPG/PNG önerilir.</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                <?= (!$editProduct || $editProduct['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                <?= t('admin.active') ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?= $editProduct ? t('admin.edit_product') : t('admin.add_product') ?>
                        </button>
                        <?php if ($editProduct): ?>
                            <?php 
                            $cancelUrl = '/admin/products.php';
                            if ($filterCategoryId) {
                                $cancelUrl .= '?category_id=' . $filterCategoryId;
                            }
                            ?>
                            <a href="<?= $cancelUrl ?>" class="btn btn-primary-soft"><?= t('admin.cancel') ?></a>
                        <?php endif; ?>
                    </div>
                        </form>
                    </div>
                </div>
                
                <!-- Products List -->
                <div class="col-lg-8">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h6 class="admin-card-title">
                                Products List
                                <?php if ($filterCategoryId): ?>
                                    <?php 
                                    $filterCategoryName = '';
                                    foreach ($categories as $cat) {
                                        if ($cat['id'] == $filterCategoryId) {
                                            $filterCategoryName = $cat['name'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <small class="text-muted">- <?= htmlspecialchars($filterCategoryName) ?></small>
                                <?php endif; ?>
                            </h6>
                            <span class="badge bg-secondary"><?= count($products) ?> items</span>
                        </div>
                <?php if (empty($products)): ?>
                    <div class="text-center py-4">
                        <p class="text-muted">
                            <?php if ($filterCategoryId): ?>
                                No products found in the selected category.
                            <?php else: ?>
                                No products found. Add your first product using the form on the left.
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-rounded">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Price</th>
                                    <th>Active</th>
                                    <th>Sort Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <?php
                                    $editUrl = '?edit_id=' . $product['id'];
                                    $deleteUrl = '?delete_id=' . $product['id'];
                                    if ($filterCategoryId) {
                                        $editUrl .= '&category_id=' . $filterCategoryId;
                                        $deleteUrl .= '&category_id=' . $filterCategoryId;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $product['id'] ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <?= htmlspecialchars($product['category_name']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($product['name']) ?></strong>
                                            <?php if (!empty($product['description'])): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars(substr($product['description'], 0, 60)) ?><?= strlen($product['description']) > 60 ? '...' : '' ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Fotoğraf" style="max-height: 50px;">
                                            <?php else: ?>
                                                <span class="text-muted small">Yok</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>$<?= number_format($product['price'], 2) ?></td>
                                        <td>
                                            <?php if ($product['is_active']): ?>
                                                <span class="badge bg-success">Yes</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $product['sort_order'] ?></td>
                                        <td>
                                            <a href="<?= $editUrl ?>" class="btn btn-sm btn-primary-soft">Edit</a>
                                            <a href="<?= $deleteUrl ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>