<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/includes/db.php';
require_once __DIR__ . '/../../app/includes/auth.php';

requireLogin();

$pdo = getDb();
$activePage = 'settings';

// Handle form submission
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $instagram_url = trim($_POST['instagram_url'] ?? '');
        $show_instagram = isset($_POST['show_instagram']) ? 1 : 0;
        $logo_path = '';
        
        // Handle logo upload/removal
        if (isset($_POST['remove_logo'])) {
            // Remove existing logo
            $stmt = $pdo->prepare("SELECT logo_path FROM restaurants WHERE id = 1 LIMIT 1");
            $stmt->execute();
            $current = $stmt->fetch();
            
            if ($current && !empty($current['logo_path'])) {
                $logoFilePath = __DIR__ . '/..' . $current['logo_path'];
                if (file_exists($logoFilePath)) {
                    unlink($logoFilePath);
                }
            }
            $logo_path = ''; // Clear logo path
            
        } elseif (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            // Handle logo upload
            $uploadedFile = $_FILES['logo'];
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($uploadedFile['type'], $allowedTypes)) {
                throw new Exception(t('settings.invalid_file_type'));
            }
            
            // Validate file size (max 5MB)
            if ($uploadedFile['size'] > 5 * 1024 * 1024) {
                throw new Exception(t('settings.file_too_large'));
            }
            
            // Generate unique filename
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $extension;
            $uploadPath = __DIR__ . '/../uploads/logo/' . $filename;
            
            // Remove old logo if exists
            $stmt = $pdo->prepare("SELECT logo_path FROM restaurants WHERE id = 1 LIMIT 1");
            $stmt->execute();
            $current = $stmt->fetch();
            
            if ($current && !empty($current['logo_path'])) {
                $oldLogoPath = __DIR__ . '/..' . $current['logo_path'];
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }
            
            // Move uploaded file
            if (move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
                $logo_path = '/uploads/logo/' . $filename;
            } else {
                throw new Exception(t('settings.upload_failed'));
            }
        } else {
            // Keep existing logo path
            $stmt = $pdo->prepare("SELECT logo_path FROM restaurants WHERE id = 1 LIMIT 1");
            $stmt->execute();
            $current = $stmt->fetch();
            $logo_path = $current['logo_path'] ?? '';
        }
        
        // Validate Instagram URL if provided
        if (!empty($instagram_url)) {
            if (!filter_var($instagram_url, FILTER_VALIDATE_URL)) {
                throw new Exception(t('settings.invalid_url'));
            }
        }
        
        // Check if required columns exist before updating
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                               WHERE TABLE_SCHEMA = DATABASE() 
                               AND TABLE_NAME = 'restaurants' 
                               AND COLUMN_NAME IN ('instagram_url', 'show_instagram', 'logo_path')");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] < 3) {
            throw new Exception(t('settings.columns_missing'));
        }
        
        // Update restaurant settings
        $stmt = $pdo->prepare("UPDATE restaurants SET instagram_url = :instagram_url, show_instagram = :show_instagram, logo_path = :logo_path WHERE id = 1");
        $stmt->bindParam(':instagram_url', $instagram_url);
        $stmt->bindParam(':show_instagram', $show_instagram);
        $stmt->bindParam(':logo_path', $logo_path);
        $stmt->execute();
        
        $success = t('settings.saved_successfully');
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    } catch (PDOException $e) {
        $error = t('settings.database_error') . ': ' . $e->getMessage();
    }
}

// Load current settings
$restaurant = null;
$columnsExist = false;
try {
    // Check if required columns exist
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                           WHERE TABLE_SCHEMA = DATABASE() 
                           AND TABLE_NAME = 'restaurants' 
                           AND COLUMN_NAME IN ('instagram_url', 'show_instagram', 'logo_path')");
    $stmt->execute();
    $result = $stmt->fetch();
    $columnsExist = ($result['count'] == 3);
    
    if ($columnsExist) {
        $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = 1 LIMIT 1");
        $stmt->execute();
        $restaurant = $stmt->fetch();
    } else {
        // If columns don't exist, load basic restaurant info
        $stmt = $pdo->prepare("SELECT id, name, slug FROM restaurants WHERE id = 1 LIMIT 1");
        $stmt->execute();
        $restaurant = $stmt->fetch();
        if ($restaurant) {
            $restaurant['instagram_url'] = '';
            $restaurant['show_instagram'] = 0;
            $restaurant['logo_path'] = '';
        }
    }
} catch (PDOException $e) {
    $error = t('settings.load_error') . ': ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('settings.title') ?> - QR Menu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/admin.css?v=123456" rel="stylesheet">
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

    <!-- Mobile Navigation Bar -->
    <div class="mobile-navbar d-md-none">
        <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()"><i class="fas fa-bars"></i></button>
        <div class="mobile-logo"><a href="/admin/dashboard.php" class="mobile-logo-text"><?= t('admin.title') ?></a></div>
        <div class="mobile-language-switcher">
            <?php 
            $supportedLangs = getSupportedLanguages();
            $currentLang = getCurrentLangCode();
            foreach ($supportedLangs as $langCode => $langInfo): ?>
                <a href="<?= buildLanguageUrl($langCode) ?>" class="btn btn-sm <?= $currentLang === $langCode ? 'active' : '' ?>"><?= strtoupper($langCode) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="mobile-sidebar-overlay" onclick="closeMobileSidebar()"></div>

    <div class="admin-layout">
        <div class="admin-sidebar" id="mobileSidebar">
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
                <a href="/admin/categories.php"><?= t('admin.categories') ?></a>
                <a href="/admin/products.php"><?= t('admin.products') ?></a>
                <a href="/admin/tables.php"><?= t('admin.tables') ?></a>
                <a href="/admin/settings.php" class="active"><?= t('admin.settings') ?></a>
            </nav>
            
            <div class="admin-sidebar-footer">
                <a href="/admin/logout.php"><?= t('admin.logout') ?></a>
            </div>
        </div>
        
        <div class="admin-content">
            <div class="admin-topbar">
                <h1 class="admin-page-title"><?= t('settings.title') ?></h1>
                <div class="admin-user-info">Welcome, <?= htmlspecialchars($_SESSION['user_email']) ?></div>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (!$columnsExist): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading"><?= t('settings.migration_required') ?></h6>
                    <p class="mb-2"><?= t('settings.migration_message') ?></p>
                    <small><?= t('settings.migration_help') ?></small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-lg-8">
                    <form method="POST" enctype="multipart/form-data">
                        
                        <!-- Logo Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?= t('settings.logo_section') ?></h5>
                            </div>
                            <div class="card-body">
                                
                                <!-- Current Logo Display -->
                                <?php if (!empty($restaurant['logo_path']) && file_exists(__DIR__ . '/..' . $restaurant['logo_path'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label"><?= t('settings.current_logo') ?></label>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= htmlspecialchars($restaurant['logo_path']) ?>" 
                                                 alt="Current Logo" 
                                                 style="max-height: 80px; max-width: 200px;" 
                                                 class="border rounded me-3">
                                            <div>
                                                <button type="submit" name="remove_logo" class="btn btn-outline-danger btn-sm">
                                                    <?= t('settings.remove_logo') ?>
                                                </button>
                                                <small class="text-muted d-block"><?= t('settings.remove_logo_help') ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Logo Upload -->
                                <div class="mb-3">
                                    <label for="logo" class="form-label">
                                        <?= !empty($restaurant['logo_path']) ? t('settings.change_logo') : t('settings.upload_logo') ?>
                                    </label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="logo" 
                                           name="logo" 
                                           accept="image/*">
                                    <div class="form-text"><?= t('settings.logo_help') ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Instagram Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?= t('settings.instagram_section') ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label"><?= t('settings.instagram_url') ?></label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="instagram_url" 
                                           name="instagram_url" 
                                           value="<?= htmlspecialchars($restaurant['instagram_url'] ?? '') ?>"
                                           placeholder="https://instagram.com/your_account">
                                    <div class="form-text"><?= t('settings.instagram_url_help') ?></div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="show_instagram" 
                                               name="show_instagram"
                                               <?= !empty($restaurant['show_instagram']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="show_instagram">
                                            <?= t('settings.show_instagram') ?>
                                        </label>
                                    </div>
                                    <div class="form-text"><?= t('settings.show_instagram_help') ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Save Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4"><?= t('settings.save') ?></button>
                        </div>
                        
                    </form>
                </div>
                    
                    <!-- Preview Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?= t('settings.preview') ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3"><?= t('settings.preview_help') ?></p>
                            
                            <div class="border rounded p-3 bg-light">
                                <div class="text-center">
                                    <!-- Logo Preview -->
                                    <?php if (!empty($restaurant['logo_path']) && file_exists(__DIR__ . '/..' . $restaurant['logo_path'])): ?>
                                        <img src="<?= htmlspecialchars($restaurant['logo_path']) ?>" 
                                             alt="Restaurant Logo" 
                                             style="max-height: 60px; max-width: 150px; margin-bottom: 10px;" 
                                             class="d-block mx-auto">
                                    <?php endif; ?>
                                    
                                    <h6 class="fw-bold"><?= htmlspecialchars($restaurant['name'] ?? 'Restaurant Name') ?></h6>
                                    <small class="text-muted d-block mb-2"><?= t('menu.digital_menu') ?></small>
                                    
                                    <?php if (!empty($restaurant['show_instagram']) && !empty($restaurant['instagram_url'])): ?>
                                        <a href="<?= htmlspecialchars($restaurant['instagram_url']) ?>" 
                                           target="_blank" 
                                           class="btn btn-sm" 
                                           style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); color: white; border: none;">
                                            <i class="fab fa-instagram"></i> Instagram
                                        </a>
                                    <?php else: ?>
                                        <small class="text-muted"><?= t('settings.instagram_hidden') ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?= t('settings.help') ?></h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong><?= t('settings.help_url') ?>:</strong><br>
                                    <small class="text-muted"><?= t('settings.help_url_desc') ?></small>
                                </li>
                                <li class="mb-2">
                                    <strong><?= t('settings.help_visibility') ?>:</strong><br>
                                    <small class="text-muted"><?= t('settings.help_visibility_desc') ?></small>
                                </li>
                                <li>
                                    <strong><?= t('settings.help_preview') ?>:</strong><br>
                                    <small class="text-muted"><?= t('settings.help_preview_desc') ?></small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
function toggleMobileSidebar(){const a=document.getElementById("mobileSidebar"),b=document.querySelector(".mobile-sidebar-overlay");a.classList.toggle("mobile-sidebar-open"),b.classList.toggle("active")}
function closeMobileSidebar(){const a=document.getElementById("mobileSidebar"),b=document.querySelector(".mobile-sidebar-overlay");a.classList.remove("mobile-sidebar-open"),b.classList.remove("active")}
document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll(".admin-sidebar-nav a").forEach(a=>{a.addEventListener("click",function(){window.innerWidth<=768&&closeMobileSidebar()})}),window.addEventListener("resize",function(){window.innerWidth>768&&closeMobileSidebar()})});
</script>
