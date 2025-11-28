<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.title') ?> - QR Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body>
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
    
    <div class="container py-4">