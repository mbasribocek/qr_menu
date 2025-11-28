<?php

function getSupportedLanguages(): array {
    return [
        'tr' => ['code' => 'tr', 'name' => 'Türkçe'],
        'en' => ['code' => 'en', 'name' => 'English'],
        'de' => ['code' => 'de', 'name' => 'Deutsch'],
    ];
}

function getDefaultLanguage(): string {
    return 'tr';
}

function getCurrentLanguage(): string {
    // Check URL parameter first
    if (isset($_GET['lang'])) {
        $requestedLang = trim($_GET['lang']);
        if (array_key_exists($requestedLang, getSupportedLanguages())) {
            // Store in session and return
            $_SESSION['lang'] = $requestedLang;
            return $requestedLang;
        }
    }
    
    // Check session
    if (isset($_SESSION['lang']) && array_key_exists($_SESSION['lang'], getSupportedLanguages())) {
        return $_SESSION['lang'];
    }
    
    // Check browser language
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browserLangs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($browserLangs as $browserLang) {
            $lang = substr(trim(explode(';', $browserLang)[0]), 0, 2);
            if (array_key_exists($lang, getSupportedLanguages())) {
                $_SESSION['lang'] = $lang;
                return $lang;
            }
        }
    }
    
    // Fall back to default
    $defaultLang = getDefaultLanguage();
    $_SESSION['lang'] = $defaultLang;
    return $defaultLang;
}

function loadTranslations(string $langCode): array {
    $langFile = __DIR__ . '/../../lang/' . $langCode . '.php';
    if (file_exists($langFile)) {
        return include $langFile;
    }
    
    // Fallback to default language
    $defaultFile = __DIR__ . '/../../lang/' . getDefaultLanguage() . '.php';
    if (file_exists($defaultFile)) {
        return include $defaultFile;
    }
    
    // Last resort fallback
    return [];
}

// Global translation array
$GLOBALS['translations'] = [];
$GLOBALS['current_lang'] = '';

function initializeLanguage(): void {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $currentLang = getCurrentLanguage();
    $GLOBALS['current_lang'] = $currentLang;
    $GLOBALS['translations'] = loadTranslations($currentLang);
}

function t(string $key, array $replacements = []): string {
    if (empty($GLOBALS['translations'])) {
        initializeLanguage();
    }
    
    $translation = $GLOBALS['translations'][$key] ?? $key;
    
    // Handle replacements like %count%
    foreach ($replacements as $placeholder => $value) {
        $translation = str_replace('%' . $placeholder . '%', $value, $translation);
    }
    
    return $translation;
}

function getCurrentLangCode(): string {
    if (empty($GLOBALS['current_lang'])) {
        initializeLanguage();
    }
    return $GLOBALS['current_lang'];
}

function getLocalizedCategoryName($category): string {
    $currentLang = getCurrentLangCode();
    
    switch ($currentLang) {
        case 'en':
            return !empty($category['name_en']) ? $category['name_en'] : $category['name'];
        case 'de':
            return !empty($category['name_de']) ? $category['name_de'] : $category['name'];
        case 'tr':
        default:
            return $category['name'];
    }
}

function getLocalizedProductName($product): string {
    $currentLang = getCurrentLangCode();
    
    switch ($currentLang) {
        case 'en':
            return !empty($product['name_en']) ? $product['name_en'] : $product['name'];
        case 'de':
            return !empty($product['name_de']) ? $product['name_de'] : $product['name'];
        case 'tr':
        default:
            return $product['name'];
    }
}

function getLocalizedProductDescription($product): string {
    $currentLang = getCurrentLangCode();
    
    switch ($currentLang) {
        case 'en':
            return !empty($product['description_en']) ? $product['description_en'] : $product['description'];
        case 'de':
            return !empty($product['description_de']) ? $product['description_de'] : $product['description'];
        case 'tr':
        default:
            return $product['description'] ?? '';
    }
}

function buildLanguageUrl(string $langCode): string {
    $currentUrl = $_SERVER['REQUEST_URI'];
    $urlParts = parse_url($currentUrl);
    
    // Parse existing query parameters
    $queryParams = [];
    if (isset($urlParts['query'])) {
        parse_str($urlParts['query'], $queryParams);
    }
    
    // Update or add language parameter
    $queryParams['lang'] = $langCode;
    
    // Build new URL
    $newQuery = http_build_query($queryParams);
    $newUrl = $urlParts['path'] . ($newQuery ? '?' . $newQuery : '');
    
    return $newUrl;
}

// Initialize language on include
initializeLanguage();

?>