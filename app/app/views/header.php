<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.title') ?> - QR Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    /* Language Switcher - Desktop & Mobile Optimized */
    .language-switcher {
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 1050;
        background: rgba(20, 92, 70, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 6px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .language-switcher .btn {
        border-radius: 14px;
        font-size: 0.8rem;
        font-weight: 500;
        padding: 8px 12px;
        margin: 2px;
        min-width: 45px;
        border: none;
        background: transparent;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.2s ease;
        line-height: 1.2;
    }
    
    .language-switcher .btn:hover {
        background: rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.95);
        transform: translateY(-1px);
    }
    
    .language-switcher .btn.active {
        background: #10b981;
        color: #022c22;
        font-weight: 600;
        box-shadow: 0 3px 12px rgba(16, 185, 129, 0.4);
    }
    
    /* Mobile Optimizations */
    @media (max-width: 768px) {
        .language-switcher {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(20, 92, 70, 0.98);
            border-radius: 16px;
            padding: 4px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
        
        .language-switcher .btn {
            font-size: 0.75rem;
            padding: 6px 10px;
            min-width: 40px;
            border-radius: 12px;
        }
        
        /* Ensure logo doesn't overlap with language switcher */
        .container {
            padding-top: 4rem !important;
        }
        
        /* Better spacing for mobile */
        .text-center.mb-4 {
            margin-bottom: 2rem !important;
            margin-top: 1rem !important;
        }
    }
    
    /* Better mobile logo styling */
    @media (max-width: 576px) {
        .language-switcher {
            top: 8px;
            right: 8px;
            padding: 3px;
        }
        
        .language-switcher .btn {
            font-size: 0.7rem;
            padding: 5px 8px;
            min-width: 35px;
            margin: 1px;
        }
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