-- Simplified Database Structure - Categories and Tags as Columns
-- This removes the separate tables and adds columns directly to book tables

-- Step 1: Drop the separate tables
DROP TABLE IF EXISTS `book_tags`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `tags`;

-- Step 2: Add category and tag columns directly to buy_items table
ALTER TABLE `buy_items` 
ADD COLUMN `category_name` varchar(50) DEFAULT NULL AFTER `category_id`,
ADD COLUMN `tag_list` text DEFAULT NULL AFTER `tags`;

-- Step 3: Add category and tag columns to rent_items table  
ALTER TABLE `rent_items`
ADD COLUMN `category_name` varchar(50) DEFAULT NULL AFTER `category_id`,
ADD COLUMN `tag_list` text DEFAULT NULL AFTER `tags`;

-- Step 4: Add category and tag columns to ebooks table
ALTER TABLE `ebooks`
ADD COLUMN `category_name` varchar(50) DEFAULT NULL AFTER `category_id`,
ADD COLUMN `tag_list` text DEFAULT NULL AFTER `tags`;

-- Step 5: Add category and tag columns to audio_books table
ALTER TABLE `audio_books`
ADD COLUMN `category_name` varchar(50) DEFAULT NULL AFTER `category_id`,
ADD COLUMN `tag_list` text DEFAULT NULL AFTER `tags`;

-- Step 6: Update buy_items with categories and tags
UPDATE buy_items SET category_id = 1, category_name = 'Fiction', tag_list = 'bestseller,classic,recommended', rating = 4.0 WHERE id >= 1 AND id <= 5;
UPDATE buy_items SET category_id = 2, category_name = 'Fantasy', tag_list = 'fantasy,popular,young-adult', rating = 4.2 WHERE id >= 6 AND id <= 10;
UPDATE buy_items SET category_id = 3, category_name = 'Adventure', tag_list = 'adventure,popular,recommended', rating = 4.0 WHERE id >= 11 AND id <= 15;
UPDATE buy_items SET category_id = 4, category_name = 'Classic', tag_list = 'classic,award-winning,recommended', rating = 4.5 WHERE id >= 16 AND id <= 20;
UPDATE buy_items SET category_id = 1, category_name = 'Fiction', tag_list = 'general,recommended', rating = 4.0 WHERE id >= 21 AND id <= 25;

-- Step 7: Update rent_items with categories and tags
UPDATE rent_items SET category_id = 1, category_name = 'Fiction', tag_list = 'bestseller,classic,recommended', rating = 4.0 WHERE id >= 1 AND id <= 5;
UPDATE rent_items SET category_id = 2, category_name = 'Fantasy', tag_list = 'fantasy,popular,young-adult', rating = 4.2 WHERE id >= 6 AND id <= 10;
UPDATE rent_items SET category_id = 3, category_name = 'Adventure', tag_list = 'adventure,popular,recommended', rating = 4.0 WHERE id >= 11 AND id <= 15;
UPDATE rent_items SET category_id = 4, category_name = 'Classic', tag_list = 'classic,award-winning,recommended', rating = 4.5 WHERE id >= 16 AND id <= 20;
UPDATE rent_items SET category_id = 1, category_name = 'Fiction', tag_list = 'general,recommended', rating = 4.0 WHERE id >= 21 AND id <= 25;

-- Step 8: Update ebooks with categories and tags (using srno as primary key)
UPDATE ebooks SET category_id = 1, category_name = 'Fiction', tag_list = 'general,recommended', rating = 4.0 WHERE srno >= 1 AND srno <= 3;
UPDATE ebooks SET category_id = 12, category_name = 'Non-Fiction', tag_list = 'non-fiction,educational', rating = 4.0 WHERE srno >= 4 AND srno <= 6;
UPDATE ebooks SET category_id = 1, category_name = 'Fiction', tag_list = 'general,recommended', rating = 4.0 WHERE srno >= 7 AND srno <= 9;

-- Step 9: Update audio_books with categories and tags (using srno as primary key)
UPDATE audio_books SET category_id = 1, category_name = 'Fiction', tag_list = 'general,recommended', rating = 4.0 WHERE srno >= 1 AND srno <= 2;
UPDATE audio_books SET category_id = 3, category_name = 'Adventure', tag_list = 'adventure,recommended', rating = 4.0 WHERE srno >= 3 AND srno <= 4;
UPDATE audio_books SET category_id = 2, category_name = 'Fantasy', tag_list = 'fantasy,popular', rating = 4.2 WHERE srno >= 5 AND srno <= 6;

-- Step 10: Create indexes for better performance
-- Use ALTER TABLE to add indexes (safer approach)
ALTER TABLE `buy_items` ADD INDEX `idx_buy_items_category` (`category_name`);
ALTER TABLE `rent_items` ADD INDEX `idx_rent_items_category` (`category_name`);  
ALTER TABLE `ebooks` ADD INDEX `idx_ebooks_category` (`category_name`);
ALTER TABLE `audio_books` ADD INDEX `idx_audio_books_category` (`category_name`);

-- Completed! Now you have:
-- 1. No separate tables for categories/tags
-- 2. Direct category_name and tag_list columns in each book table
-- 3. All books assigned to appropriate categories
-- 4. Performance indexes for filtering
