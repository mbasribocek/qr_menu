<?php
require_once __DIR__ . '/../config.php';

function getDb(): PDO
{
    static $pdo = null;
    
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Run automatic migrations
        runMigrations($pdo);
    }
    
    return $pdo;
}

function runMigrations(PDO $pdo): void
{
    try {
        // Check if migrations table exists, create if not
        $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id VARCHAR(255) PRIMARY KEY,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Instagram columns migration
        $instagramMigrationId = 'add_instagram_columns_2024';
        $stmt = $pdo->prepare("SELECT id FROM migrations WHERE id = :id");
        $stmt->bindParam(':id', $instagramMigrationId);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            // Run Instagram migration
            runInstagramMigration($pdo);
            
            // Mark migration as completed
            $stmt = $pdo->prepare("INSERT INTO migrations (id) VALUES (:id)");
            $stmt->bindParam(':id', $instagramMigrationId);
            $stmt->execute();
        }
        
        // Logo column migration (separate migration)
        $logoMigrationId = 'add_logo_column_2024';
        $stmt = $pdo->prepare("SELECT id FROM migrations WHERE id = :id");
        $stmt->bindParam(':id', $logoMigrationId);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            // Run Logo migration
            runLogoMigration($pdo);
            
            // Mark migration as completed
            $stmt = $pdo->prepare("INSERT INTO migrations (id) VALUES (:id)");
            $stmt->bindParam(':id', $logoMigrationId);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        // Migration failed - log error but don't break the app
        error_log("Migration error: " . $e->getMessage());
    }
}

function runInstagramMigration(PDO $pdo): void
{
    try {
        // Check if instagram_url column exists
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                               WHERE TABLE_SCHEMA = DATABASE() 
                               AND TABLE_NAME = 'restaurants' 
                               AND COLUMN_NAME = 'instagram_url'");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $pdo->exec("ALTER TABLE restaurants ADD COLUMN instagram_url VARCHAR(255) NULL AFTER name");
        }
        
        // Check if show_instagram column exists
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                               WHERE TABLE_SCHEMA = DATABASE() 
                               AND TABLE_NAME = 'restaurants' 
                               AND COLUMN_NAME = 'show_instagram'");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $pdo->exec("ALTER TABLE restaurants ADD COLUMN show_instagram TINYINT(1) NOT NULL DEFAULT 0 AFTER instagram_url");
        }
        
    } catch (PDOException $e) {
        throw new Exception("Instagram migration failed: " . $e->getMessage());
    }
}

function runLogoMigration(PDO $pdo): void
{
    try {
        // Check if logo_path column exists
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                               WHERE TABLE_SCHEMA = DATABASE() 
                               AND TABLE_NAME = 'restaurants' 
                               AND COLUMN_NAME = 'logo_path'");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $pdo->exec("ALTER TABLE restaurants ADD COLUMN logo_path VARCHAR(255) NULL AFTER name");
        }
        
    } catch (PDOException $e) {
        throw new Exception("Logo migration failed: " . $e->getMessage());
    }
}
?>