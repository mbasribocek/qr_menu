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
                <a href="/admin/dashboard.php" class="active"><?= t('admin.dashboard') ?></a>
                <a href="/admin/categories.php"><?= t('admin.categories') ?></a>
                <a href="/admin/products.php"><?= t('admin.products') ?></a>
                <a href="/admin/tables.php"><?= t('admin.tables') ?></a>
            </nav>
            
            <div class="admin-sidebar-footer">
                <a href="/admin/logout.php"><?= t('admin.logout') ?></a>
            </div>
        </div>
        
        <div class="admin-content">
            <div class="admin-topbar">
                <h1 class="admin-page-title"><?= t('admin.dashboard') ?></h1>
                <div class="admin-user-info">Welcome, <?= htmlspecialchars($_SESSION['user_email']) ?></div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.categories') ?></h5>
                            <p class="card-text">Manage menu categories</p>
                            <a href="/admin/categories.php" class="btn btn-primary"><?= t('admin.categories') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.products') ?></h5>
                            <p class="card-text">Manage menu items</p>
                            <a href="/admin/products.php" class="btn btn-primary"><?= t('admin.products') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= t('admin.tables') ?></h5>
                            <p class="card-text">Manage tables & QR codes</p>
                            <a href="/admin/tables.php" class="btn btn-primary"><?= t('admin.tables') ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><?= t('admin.logout') ?></h5>
                            <p class="card-text">End your session</p>
                            <a href="/admin/logout.php" class="btn btn-outline-danger"><?= t('admin.logout') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>