<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/includes/db.php';
require_once __DIR__ . '/../../app/includes/auth.php';

$error = '';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    header('Location: /admin/dashboard.php');
    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        try {
            $pdo = getDb();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                header('Location: /admin/dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            $error = 'Database error occurred';
        }
    } else {
        $error = 'Please fill in all fields';
    }
}

?>
<!DOCTYPE html>
<html lang="<?= getCurrentLangCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('admin.login_title') ?> - QR Menu App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/admin.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body class="admin-login-page">
    <!-- Language Switcher -->
    <div class="login-language-switcher">
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

    <div class="admin-login-card">
        <div class="admin-login-title"><?= t('admin.login_title') ?></div>
        <div class="admin-login-subtitle"><?= t('admin.login_subtitle') ?></div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label"><?= t('admin.email') ?></label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><?= t('admin.password') ?></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary"><?= t('admin.login_button') ?></button>
            </div>
        </form>
        
        <div class="text-center">
            <a href="/" class="admin-login-back-link"><?= t('menu.back_to_menu') ?></a>
        </div>
    </div>
</body>
</html>