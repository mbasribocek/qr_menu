<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/includes/db.php';

include __DIR__ . '/../app/views/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="card-title">QR Menu App</h1>
                <p class="card-text">Home page</p>
                <a href="/admin/login.php" class="btn btn-primary">Admin Login</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../app/views/footer.php'; ?>