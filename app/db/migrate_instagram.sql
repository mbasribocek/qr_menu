-- Migration to add Instagram integration columns
-- Run this if you already have an existing database

-- Add Instagram columns to restaurants table if they don't exist
SET @sql = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
     WHERE TABLE_SCHEMA = DATABASE() 
     AND TABLE_NAME = 'restaurants' 
     AND COLUMN_NAME = 'instagram_url') = 0,
    'ALTER TABLE restaurants ADD COLUMN instagram_url VARCHAR(255) NULL AFTER name',
    'SELECT "Column instagram_url already exists" AS message'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
     WHERE TABLE_SCHEMA = DATABASE() 
     AND TABLE_NAME = 'restaurants' 
     AND COLUMN_NAME = 'show_instagram') = 0,
    'ALTER TABLE restaurants ADD COLUMN show_instagram TINYINT(1) NOT NULL DEFAULT 0 AFTER instagram_url',
    'SELECT "Column show_instagram already exists" AS message'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;