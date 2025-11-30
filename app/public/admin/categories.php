<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/includes/db.php';
require_once __DIR__ . '/../../app/includes/auth.php';

requireLogin();

$pdo = getDb();
$message = '';
$error = '';
$editCategory = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $name_en = trim($_POST['name_en'] ?? '');
        $name_de = trim($_POST['name_de'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        
        if (empty($name)) {
            $error = 'Category name is required';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (restaurant_id, name, name_en, name_de, sort_order) VALUES (1, :name, :name_en, :name_de, :sort_order)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':name_en', $name_en);
                $stmt->bindParam(':name_de', $name_de);
                $stmt->bindParam(':sort_order', $sortOrder);
                $stmt->execute();
                
                header('Location: /admin/categories.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Error adding category: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $name_en = trim($_POST['name_en'] ?? '');
        $name_de = trim($_POST['name_de'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        
        if (empty($name)) {
            $error = 'Category name is required';
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE categories SET name = :name, name_en = :name_en, name_de = :name_de, sort_order = :sort_order WHERE id = :id AND restaurant_id = 1");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':name_en', $name_en);
                $stmt->bindParam(':name_de', $name_de);
                $stmt->bindParam(':sort_order', $sortOrder);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                header('Location: /admin/categories.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Error updating category: ' . $e->getMessage();
            }
        }
    }
}

// Handle GET actions
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id AND restaurant_id = 1");
        $stmt->bindParam(':id', $deleteId);
        $stmt->execute();
        
        header('Location: /admin/categories.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error deleting category: ' . $e->getMessage();
    }
}

// Handle edit form
if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id AND restaurant_id = 1");
        $stmt->bindParam(':id', $editId);
        $stmt->execute();
        $editCategory = $stmt->fetch();
        
        if (!$editCategory) {
            $error = 'Category not found';
        }
    } catch (PDOException $e) {
        $error = 'Error fetching category: ' . $e->getMessage();
    }
}

// Fetch all categories
try {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE restaurant_id = 1 ORDER BY sort_order, id");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Error fetching categories: ' . $e->getMessage();
    $categories = [];
}

?>
<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.categories') ?> - QR Menu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/admin.css?v=<?= time() ?>" rel="stylesheet">
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
    <!-- Language Switcher for Desktop -->
    <div class="language-switcher d-none d-md-block">
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

    <!-- Mobile Navigation Bar -->
    <div class="mobile-navbar d-md-none">
        <!-- Hamburger Menu Toggle -->
        <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Logo/Brand -->
        <div class="mobile-logo">
            <?php
            // Load restaurant info for mobile logo
            try {
                $pdo = getDb();
                $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = 1 LIMIT 1");
                $stmt->execute();
                $mobileRestaurant = $stmt->fetch();
            } catch (Exception $e) {
                $mobileRestaurant = null;
            }
            ?>
            <?php if ($mobileRestaurant && !empty($mobileRestaurant['logo_path'])): ?>
                <img src="<?= htmlspecialchars($mobileRestaurant['logo_path']) ?>" 
                     alt="<?= htmlspecialchars($mobileRestaurant['name'] ?? 'Restaurant Logo') ?>" 
                     onerror="this.style.display='none';">
            <?php else: ?>
                <a href="/admin/dashboard.php" class="mobile-logo-text"><?= t('admin.title') ?></a>
            <?php endif; ?>
        </div>
        
        <!-- Language Switcher -->
        <div class="mobile-language-switcher">
            <?php foreach ($supportedLangs as $langCode => $langInfo): ?>
                <a href="<?= buildLanguageUrl($langCode) ?>" 
                   class="btn btn-sm <?= $currentLang === $langCode ? 'active' : '' ?>"
                   title="<?= htmlspecialchars($langInfo['name']) ?>">
                    <?= strtoupper($langCode) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="mobile-sidebar-overlay" onclick="closeMobileSidebar()"></div>

    <div class="admin-layout">
        <div class="admin-sidebar" id="mobileSidebar">
            <!-- Language Switcher in Sidebar for Mobile - Hidden -->
            <div class="d-md-none" style="display: none !important;">
                <div class="language-switcher">
                    <?php foreach ($supportedLangs as $langCode => $langInfo): ?>
                        <a href="<?= buildLanguageUrl($langCode) ?>" 
                           class="btn btn-sm <?= $currentLang === $langCode ? 'active' : '' ?>"
                           title="<?= htmlspecialchars($langInfo['name']) ?>">
                            <?= strtoupper($langCode) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Restaurant Logo in Sidebar -->
            <?php
            // Load restaurant info for logo
            try {
                $pdo = getDb();
                $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = 1 LIMIT 1");
                $stmt->execute();
                $restaurant = $stmt->fetch();
            } catch (Exception $e) {
                $restaurant = null;
            }
            ?>
            <?php if ($restaurant && !empty($restaurant['logo_path'])): ?>
                <div class="admin-sidebar-logo text-center mb-3">
                    <img src="<?= htmlspecialchars($restaurant['logo_path']) ?>" 
                         alt="<?= htmlspecialchars($restaurant['name'] ?? 'Restaurant Logo') ?>" 
                         class="img-fluid"
                         style="max-height: 60px; max-width: 180px; object-fit: contain; border-radius: 8px;"
                         onerror="this.style.display='none';">
                </div>
            <?php endif; ?>
            
            <a href="/admin/dashboard.php" class="admin-sidebar-brand"><?= t('admin.title') ?></a>
            
            <nav class="admin-sidebar-nav">
                <a href="/admin/dashboard.php"><?= t('admin.dashboard') ?></a>
                <a href="/admin/categories.php" class="active"><?= t('admin.categories') ?></a>
                <a href="/admin/products.php"><?= t('admin.products') ?></a>
                <a href="/admin/tables.php"><?= t('admin.tables') ?></a>
                <a href="/admin/settings.php"><?= t('admin.settings') ?></a>
            </nav>
            
            <div class="admin-sidebar-footer">
                <a href="/admin/logout.php"><?= t('admin.logout') ?></a>
            </div>
        </div>
        
        <div class="admin-content">
            <div class="admin-topbar">
                <h1 class="admin-page-title"><?= t('admin.categories') ?></h1>
                <a href="/admin/dashboard.php" class="btn btn-primary-soft">← <?= t('admin.dashboard') ?></a>
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
                <!-- Add/Edit Category Form -->
                <div class="col-md-4">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h5 class="admin-card-title"><?= $editCategory ? t('admin.edit_category') : t('admin.add_category') ?></h5>
                        </div>
                        <form method="POST">
                            <?php if ($editCategory): ?>
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
                            <?php else: ?>
                                <input type="hidden" name="action" value="add">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label"><?= t('admin.category_name_tr') ?></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="name_en" class="form-label"><?= t('admin.category_name_en') ?></label>
                                <input type="text" class="form-control" id="name_en" name="name_en" 
                                       value="<?= htmlspecialchars($editCategory['name_en'] ?? '') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="name_de" class="form-label"><?= t('admin.category_name_de') ?></label>
                                <input type="text" class="form-control" id="name_de" name="name_de" 
                                       value="<?= htmlspecialchars($editCategory['name_de'] ?? '') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="sort_order" class="form-label"><?= t('admin.sort_order') ?></label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                       value="<?= $editCategory['sort_order'] ?? 0 ?>" min="0">
                                <div class="form-text">Lower numbers appear first</div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <?= $editCategory ? t('admin.edit_category') : t('admin.add_category') ?>
                                </button>
                                <?php if ($editCategory): ?>
                                    <a href="/admin/categories.php" class="btn btn-primary-soft"><?= t('admin.cancel') ?></a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Categories List -->
                <div class="col-md-8">
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h5 class="admin-card-title"><?= t('admin.categories') ?></h5>
                        </div>
                        <?php if (empty($categories)): ?>
                            <div class="text-center py-4">
                                <p class="text-muted">No categories found. Add your first category using the form on the left.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-rounded">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th><?= t('admin.category_name') ?> (TR)</th>
                                            <th><?= t('admin.category_name') ?> (EN)</th>
                                            <th><?= t('admin.category_name') ?> (DE)</th>
                                            <th><?= t('admin.sort_order') ?></th>
                                            <th>Created At</th>
                                            <th><?= t('admin.actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td><?= $category['id'] ?></td>
                                                <td><?= htmlspecialchars($category['name']) ?></td>
                                                <td><?= htmlspecialchars($category['name_en'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($category['name_de'] ?? '') ?></td>
                                                <td><?= $category['sort_order'] ?></td>
                                                <td><?= date('Y-m-d H:i', strtotime($category['created_at'])) ?></td>
                                                <td>
                                                    <a href="?edit_id=<?= $category['id'] ?>" class="btn btn-sm btn-primary-soft"><?= t('admin.edit') ?></a>
                                                    <a href="?delete_id=<?= $category['id'] ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this category?');"><?= t('admin.delete') ?></a>
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
    </div>

    <script>
    // Mobile sidebar toggle functions
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.querySelector('.mobile-sidebar-overlay');
        
        sidebar.classList.toggle('mobile-sidebar-open');
        overlay.classList.toggle('active');
    }
    
    function closeMobileSidebar() {
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.querySelector('.mobile-sidebar-overlay');
        
        sidebar.classList.remove('mobile-sidebar-open');
        overlay.classList.remove('active');
    }
    
    // Close sidebar when clicking on a menu item (mobile)
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.admin-sidebar-nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeMobileSidebar();
                }
            });
        });
        
        // Close sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMobileSidebar();
            }
        });
    });
    </script>
</body>
</html>