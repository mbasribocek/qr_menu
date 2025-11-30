<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/includes/db.php';
require_once __DIR__ . '/../../app/includes/auth.php';

requireLogin();

?>
<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.dashboard') ?> - QR Menu Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/admin.css?v=<?= time() ?>" rel="stylesheet">
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

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

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
                <a href="/admin/dashboard.php" class="active"><?= t('admin.dashboard') ?></a>
                <a href="/admin/categories.php"><?= t('admin.categories') ?></a>
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
                <div class="admin-topbar-left">
                    <button class="admin-menu-toggle">
                        <span></span>
                    </button>
                </div>
                <div class="admin-topbar-center">
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
                        <img src="<?= htmlspecialchars($restaurant['logo_path']) ?>" 
                             alt="<?= htmlspecialchars($restaurant['name'] ?? 'Restaurant Logo') ?>" 
                             style="height: 32px; max-width: 120px; object-fit: contain;">
                    <?php else: ?>
                        <span class="admin-topbar-logo"><?= t('admin.title') ?></span>
                    <?php endif; ?>
                </div>
                <div class="admin-topbar-right">
                    <div class="dropdown">
                        <button class="admin-lang-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <?= strtoupper(getCurrentLangCode()) ?>
                        </button>
                        <ul class="dropdown-menu">
                            <?php 
                            $supportedLangs = getSupportedLanguages();
                            $currentLang = getCurrentLangCode();
                            ?>
                            <?php foreach ($supportedLangs as $langCode => $langInfo): ?>
                                <li>
                                    <a class="dropdown-item <?= $currentLang === $langCode ? 'active' : '' ?>" 
                                       href="<?= buildLanguageUrl($langCode) ?>">
                                        <?= htmlspecialchars($langInfo['name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="admin-page-header">
                <h1 class="admin-page-title"><?= t('admin.dashboard') ?></h1>
                <div class="admin-user-info">Welcome, <?= htmlspecialchars($_SESSION['user_email']) ?></div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.categories') ?></h5>
                            <p class="card-text"><?= t('admin.manage_categories_desc') ?></p>
                            <a href="/admin/categories.php" class="btn btn-primary"><?= t('admin.categories') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.products') ?></h5>
                            <p class="card-text"><?= t('admin.manage_products_desc') ?></p>
                            <a href="/admin/products.php" class="btn btn-primary"><?= t('admin.products') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.tables') ?></h5>
                            <p class="card-text"><?= t('admin.manage_tables_desc') ?></p>
                            <a href="/admin/tables.php" class="btn btn-primary"><?= t('admin.tables') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.settings') ?></h5>
                            <p class="card-text"><?= t('admin.configure_settings_desc') ?></p>
                            <a href="/admin/settings.php" class="btn btn-primary"><?= t('admin.settings') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><?= t('admin.logout') ?></h5>
                            <p class="card-text"><?= t('admin.end_session_desc') ?></p>
                            <a href="/admin/logout.php" class="btn btn-outline-danger"><?= t('admin.logout') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin.js?v=<?= time() ?>"></script>
</body>
</html>