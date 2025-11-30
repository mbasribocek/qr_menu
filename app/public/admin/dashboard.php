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
    <style>
    .language-switcher {
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 1050;
        background: rgba(17, 24, 39, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 4px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .language-switcher .btn {
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
        padding: 6px 10px;
        margin: 2px;
        min-width: 40px;
        border: none;
        background: transparent;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.2s ease;
        line-height: 1.2;
    }
    
    .language-switcher .btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.9);
        transform: translateY(-1px);
    }
    
    .language-switcher .btn.active {
        background: #10b981;
        color: #022c22;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    /* Mobile Navigation Bar */
    @media (max-width: 768px) {
        /* Hide desktop elements */
        .language-switcher.d-none.d-md-block {
            display: none !important;
        }
        
        /* Mobile Top Navigation */
        .mobile-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #111827, #1f2937);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1060;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .mobile-menu-toggle {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .mobile-logo {
            flex: 1;
            text-align: center;
            margin: 0 1rem;
        }
        
        .mobile-logo img {
            max-height: 35px;
            max-width: 120px;
            object-fit: contain;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
        }
        
        .mobile-logo-text {
            color: #10f2c5;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            display: inline-block;
        }
        
        .mobile-language-switcher {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2px;
            display: flex;
        }
        
        .mobile-language-switcher .btn {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
            min-width: 32px !important;
            border-radius: 8px !important;
            color: rgba(255, 255, 255, 0.7) !important;
            background: transparent !important;
            border: none !important;
            transition: all 0.2s ease !important;
            margin: 1px !important;
        }
        
        .mobile-language-switcher .btn:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .mobile-language-switcher .btn.active {
            background: #10b981 !important;
            color: #022c22 !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 4px rgba(16, 185, 129, 0.3) !important;
        }
        
        /* Sidebar adjustments */
        .admin-layout {
            padding-top: 65px !important;
        }
        
        .admin-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            position: fixed;
            top: 65px;
            left: 0;
            width: 280px;
            height: calc(100vh - 65px);
            background: linear-gradient(135deg, #111827, #1f2937) !important;
            z-index: 1050;
            overflow-y: auto;
            padding: 1rem !important;
        }
        
        .admin-sidebar.mobile-sidebar-open {
            transform: translateX(0);
        }
        
        .mobile-sidebar-overlay {
            display: none;
            position: fixed;
            top: 65px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
        
        .mobile-sidebar-overlay.active {
            display: block;
        }
        
        /* Hide sidebar elements that are now in navbar */
        .admin-sidebar .d-md-none {
            display: none !important;
        }
        
        .admin-sidebar-logo {
            display: none !important;
        }
        
        .admin-sidebar-brand {
            display: none !important;
        }
        
        .admin-content {
            margin-left: 0 !important;
            padding: 1rem !important;
        }
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

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="closeSidebar()"></div>

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
                    <button class="admin-menu-toggle" onclick="toggleSidebar()">
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
    <script>
    // Sidebar toggle functions
    function toggleSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const toggle = document.querySelector('.admin-menu-toggle');
        
        sidebar.classList.toggle('is-open');
        overlay.classList.toggle('active');
        toggle.classList.toggle('active');
    }
    
    function closeSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const toggle = document.querySelector('.admin-menu-toggle');
        
        sidebar.classList.remove('is-open');
        overlay.classList.remove('active');
        toggle.classList.remove('active');
    }
    
    // Close sidebar when clicking on a menu item (mobile)
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.admin-sidebar-nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991.98) {
                    closeSidebar();
                }
            });
        });
        
        // Close sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991.98) {
                closeSidebar();
            }
        });
    });
    </script>
</body>
</html>