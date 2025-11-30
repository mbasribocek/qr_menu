<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.title') ?> - QR Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/public.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body>

    <!-- Mobile Top Navigation -->
    <div class="public-topbar d-lg-none">
        <div class="public-topbar-left">
            <button class="menu-toggle">
                <span></span>
            </button>
        </div>
        <div class="public-topbar-center">
            <?php
            // This is a simplified version to get the logo. 
            // In a real app, this might come from a global config.
            try {
                $pdo_header = getDb();
                $stmt_header = $pdo_header->prepare("SELECT logo_path, name FROM restaurants WHERE id = 1 LIMIT 1");
                $stmt_header->execute();
                $restaurant_header = $stmt_header->fetch();
                if ($restaurant_header && !empty($restaurant_header['logo_path'])) {
                    echo '<img src="' . htmlspecialchars($restaurant_header['logo_path']) . '" alt="' . htmlspecialchars($restaurant_header['name']) . '" class="public-logo">';
                } else {
                    echo '<span class="public-logo-text">' . t('menu.title') . '</span>';
                }
            } catch (Exception $e) {
                // Ignore
            }
            ?>
        </div>
        <div class="public-topbar-right">
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
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="public-sidebar d-lg-none" id="publicSidebar">
        <nav class="public-sidebar-nav">
            <!-- Sidebar content will be populated by the specific page -->
        </nav>
    </div>
    <div class="sidebar-overlay d-lg-none"></div>
    
    <div class="container py-4">