-- Database Updates for Enhanced Book Categorization and Filtering
-- Run these SQL commands in phpMyAdmin or MySQL command line

-- Disable safe update mode temporarily (for MySQL Workbench)
SET SQL_SAFE_UPDATES = 0;

-- 1. Create categories table for predefined book categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `color` varchar(7) DEFAULT '#4a90e2',
  `icon` varchar(50) DEFAULT 'fa-book',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert predefined categories
INSERT INTO `categories` (`name`, `description`, `color`, `icon`) VALUES
('Fiction', 'Novels, stories, and imaginative literature', '#4a90e2', 'fa-book-open'),
('Fantasy', 'Fantasy novels with magical elements', '#9b59b6', 'fa-magic'),
('Adventure', 'Action-packed adventure stories', '#e74c3c', 'fa-map'),
('Classic', 'Timeless literary classics', '#2c3e50', 'fa-crown'),
('Romance', 'Love stories and romantic novels', '#e91e63', 'fa-heart'),
('Mystery', 'Mystery and detective stories', '#795548', 'fa-search'),
('Children', 'Books for young readers', '#ff9800', 'fa-child'),
('Biography', 'Life stories and memoirs', '#607d8b', 'fa-user'),
('Education', 'Educational and academic books', '#4caf50', 'fa-graduation-cap'),
('Horror', 'Horror and thriller stories', '#424242', 'fa-ghost'),
('Science Fiction', 'Sci-fi and futuristic stories', '#00bcd4', 'fa-rocket'),
('Non-Fiction', 'Factual and informational books', '#8bc34a', 'fa-info-circle');

-- 2. Create tags table for book tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(7) DEFAULT '#4a90e2',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert predefined tags
INSERT INTO `tags` (`name`, `color`) VALUES
('bestseller', '#e74c3c'),
('new-arrival', '#2ecc71'),
('popular', '#f39c12'),
('award-winning', '#9b59b6'),
('trending', '#e91e63'),
('classic', '#34495e'),
('young-adult', '#3498db'),
('series', '#1abc9c'),
('illustrated', '#f1c40f'),
('hardcover', '#95a5a6'),
('paperback', '#7f8c8d'),
('limited-edition', '#8e44ad'),
('recommended', '#16a085'),
('staff-pick', '#d35400');

-- 3. Create book_tags junction table for many-to-many relationship
CREATE TABLE IF NOT EXISTS `book_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `book_type` enum('buy','rent','ebook','audio') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_book_tag` (`book_id`, `tag_id`, `book_type`),
  KEY `book_id` (`book_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. Create wishlist table
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_type` enum('buy','rent','ebook','audio') NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_wishlist_item` (`user_id`, `book_id`, `book_type`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. Add new columns to existing tables

-- Add category_id and tags columns to buy_items table
ALTER TABLE `buy_items` 
ADD COLUMN `category_id` int(11) DEFAULT NULL AFTER `category`,
ADD COLUMN `author` varchar(255) DEFAULT NULL AFTER `item_name`,
ADD COLUMN `publisher` varchar(255) DEFAULT NULL AFTER `author`,
ADD COLUMN `publication_year` year DEFAULT NULL AFTER `publisher`,
ADD COLUMN `isbn` varchar(20) DEFAULT NULL AFTER `publication_year`,
ADD COLUMN `rating` decimal(2,1) DEFAULT 0.0 AFTER `isbn`,
ADD COLUMN `tags` text DEFAULT NULL AFTER `rating`,
ADD INDEX `idx_category_id` (`category_id`);

-- Add category_id and tags columns to rent_items table
ALTER TABLE `rent_items` 
ADD COLUMN `category_id` int(11) DEFAULT NULL AFTER `category`,
ADD COLUMN `author` varchar(255) DEFAULT NULL AFTER `item_name`,
ADD COLUMN `publisher` varchar(255) DEFAULT NULL AFTER `author`,
ADD COLUMN `publication_year` year DEFAULT NULL AFTER `publisher`,
ADD COLUMN `isbn` varchar(20) DEFAULT NULL AFTER `publication_year`,
ADD COLUMN `rating` decimal(2,1) DEFAULT 0.0 AFTER `isbn`,
ADD COLUMN `tags` text DEFAULT NULL AFTER `rating`,
ADD INDEX `idx_category_id` (`category_id`);

-- Add category_id and tags columns to ebooks table
ALTER TABLE `ebooks` 
ADD COLUMN `category_id` int(11) DEFAULT NULL AFTER `title`,
ADD COLUMN `author` varchar(255) DEFAULT NULL AFTER `category_id`,
ADD COLUMN `publisher` varchar(255) DEFAULT NULL AFTER `author`,
ADD COLUMN `publication_year` year DEFAULT NULL AFTER `publisher`,
ADD COLUMN `isbn` varchar(20) DEFAULT NULL AFTER `publication_year`,
ADD COLUMN `rating` decimal(2,1) DEFAULT 0.0 AFTER `isbn`,
ADD COLUMN `description` text DEFAULT NULL AFTER `rating`,
ADD COLUMN `tags` text DEFAULT NULL AFTER `description`,
ADD INDEX `idx_category_id` (`category_id`);

-- Add category_id and tags columns to audio_books table
ALTER TABLE `audio_books` 
ADD COLUMN `category_id` int(11) DEFAULT NULL AFTER `author`,
ADD COLUMN `publisher` varchar(255) DEFAULT NULL AFTER `category_id`,
ADD COLUMN `publication_year` year DEFAULT NULL AFTER `publisher`,
ADD COLUMN `isbn` varchar(20) DEFAULT NULL AFTER `publication_year`,
ADD COLUMN `rating` decimal(2,1) DEFAULT 0.0 AFTER `isbn`,
ADD COLUMN `duration` time DEFAULT NULL AFTER `rating`,
ADD COLUMN `narrator` varchar(255) DEFAULT NULL AFTER `duration`,
ADD COLUMN `tags` text DEFAULT NULL AFTER `narrator`,
ADD INDEX `idx_category_id` (`category_id`);

-- 6. Update existing records with appropriate categories

-- Update buy_items with category_id based on existing category and item names
UPDATE `buy_items` SET `category_id` = 1 WHERE `item_name` LIKE '%Daddy-Long-Legs%' OR `item_name` LIKE '%Twilight Land%';
UPDATE `buy_items` SET `category_id` = 2 WHERE `item_name` LIKE '%Phoenix%' OR `item_name` LIKE '%Dragons%' OR `item_name` LIKE '%Princess%';
UPDATE `buy_items` SET `category_id` = 3 WHERE `item_name` LIKE '%Jungle Book%' OR `item_name` LIKE '%golden flee%' OR `item_name` LIKE '%Huckelberry%' OR `item_name` LIKE '%TOM Sawyer%';
UPDATE `buy_items` SET `category_id` = 4 WHERE `item_name` LIKE '%Alice%' OR `item_name` LIKE '%looking glass%' OR `item_name` LIKE '%Pride and prejudice%' OR `item_name` LIKE '%Wuthering%' OR `item_name` LIKE '%Oliver Twist%' OR `item_name` LIKE '%Don Quixote%';
UPDATE `buy_items` SET `category_id` = 2 WHERE `item_name` LIKE '%Harry potter%';
UPDATE `buy_items` SET `category_id` = 4 WHERE `item_name` LIKE '%Odyssey%';
UPDATE `buy_items` SET `category_id` = 10 WHERE `item_name` LIKE '%Draculla%';
UPDATE `buy_items` SET `category_id` = 1 WHERE `item_name` LIKE '%Dear Enemy%';
UPDATE `buy_items` SET `category_id` = 5 WHERE `item_name` LIKE '%Bitter Sweet%' OR `item_name` LIKE '%When you were mine%';
UPDATE `buy_items` SET `category_id` = 4 WHERE `item_name` LIKE '%Robert louis%';
UPDATE `buy_items` SET `category_id` = 12 WHERE `item_name` LIKE '%Elias Network%';
UPDATE `buy_items` SET `category_id` = 7 WHERE `item_name` LIKE '%Five Children%';

-- Update rent_items with category_id
UPDATE `rent_items` SET `category_id` = 1 WHERE `item_name` LIKE '%Daddy-Long-Legs%' OR `item_name` LIKE '%Twilight Land%';
UPDATE `rent_items` SET `category_id` = 2 WHERE `item_name` LIKE '%Phoenix%' OR `item_name` LIKE '%Dragons%' OR `item_name` LIKE '%Princess%';
UPDATE `rent_items` SET `category_id` = 3 WHERE `item_name` LIKE '%Jungle Book%' OR `item_name` LIKE '%golden flee%' OR `item_name` LIKE '%Huckelberry%' OR `item_name` LIKE '%TOM Sawyer%';
UPDATE `rent_items` SET `category_id` = 4 WHERE `item_name` LIKE '%Alice%' OR `item_name` LIKE '%looking glass%' OR `item_name` LIKE '%Pride and prejudice%' OR `item_name` LIKE '%Wuthering%' OR `item_name` LIKE '%Oliver Twist%' OR `item_name` LIKE '%Don Quixote%';
UPDATE `rent_items` SET `category_id` = 2 WHERE `item_name` LIKE '%Harry potter%';
UPDATE `rent_items` SET `category_id` = 4 WHERE `item_name` LIKE '%Odyssey%';
UPDATE `rent_items` SET `category_id` = 10 WHERE `item_name` LIKE '%Draculla%';
UPDATE `rent_items` SET `category_id` = 1 WHERE `item_name` LIKE '%Dear Enemy%';
UPDATE `rent_items` SET `category_id` = 7 WHERE `item_name` LIKE '%Five Children%';

-- Update ebooks with category_id
UPDATE `ebooks` SET `category_id` = 1 WHERE `title` LIKE '%Welcome to Nowhere%' OR `title` LIKE '%Page of the Sea%' OR `title` LIKE '%Islanders%';
UPDATE `ebooks` SET `category_id` = 12 WHERE `title` LIKE '%Apple Vision Pro%';
UPDATE `ebooks` SET `category_id` = 1 WHERE `title` LIKE '%Dreams%' OR `title` LIKE '%Bitter Sweet%' OR `title` LIKE '%Within You%' OR `title` LIKE '%Usual Silence%' OR `title` LIKE '%When You Were Mine%';

-- Update audio_books with category_id
UPDATE `audio_books` SET `category_id` = 1 WHERE `title` LIKE '%Daddy%' OR `title` LIKE '%Twilight%';
UPDATE `audio_books` SET `category_id` = 3 WHERE `title` LIKE '%Jungle Book%';
UPDATE `audio_books` SET `category_id` = 2 WHERE `title` LIKE '%Dragons%' OR `title` LIKE '%Princess%';
UPDATE `audio_books` SET `category_id` = 4 WHERE `title` LIKE '%Golden Fleece%';

-- 7. Add some sample authors and other details

-- Update buy_items with authors
UPDATE `buy_items` SET `author` = 'Jean Webster' WHERE `item_name` LIKE '%Daddy-Long-Legs%';
UPDATE `buy_items` SET `author` = 'Mabel H. McFarlane' WHERE `item_name` LIKE '%Twilight Land%';
UPDATE `buy_items` SET `author` = 'E. Nesbit' WHERE `item_name` LIKE '%Phoenix%' OR `item_name` LIKE '%Dragons%' OR `item_name` LIKE '%Five Children%';
UPDATE `buy_items` SET `author` = 'Rudyard Kipling' WHERE `item_name` LIKE '%Jungle Book%';
UPDATE `buy_items` SET `author` = 'Lewis Carroll' WHERE `item_name` LIKE '%Alice%' OR `item_name` LIKE '%looking glass%';
UPDATE `buy_items` SET `author` = 'George MacDonald' WHERE `item_name` LIKE '%Princess%';
UPDATE `buy_items` SET `author` = 'J.K. Rowling' WHERE `item_name` LIKE '%Harry potter%';
UPDATE `buy_items` SET `author` = 'Homer' WHERE `item_name` LIKE '%Odyssey%';
UPDATE `buy_items` SET `author` = 'Jean Webster' WHERE `item_name` LIKE '%Dear Enemy%';
UPDATE `buy_items` SET `author` = 'Holly Black' WHERE `item_name` LIKE '%Draculla%';
UPDATE `buy_items` SET `author` = 'Charles Dickens' WHERE `item_name` LIKE '%Oliver Twist%';
UPDATE `buy_items` SET `author` = 'Miguel de Cervantes' WHERE `item_name` LIKE '%Don Quixote%';
UPDATE `buy_items` SET `author` = 'Mark Twain' WHERE `item_name` LIKE '%Huckelberry%' OR `item_name` LIKE '%TOM Sawyer%';
UPDATE `buy_items` SET `author` = 'Jane Austen' WHERE `item_name` LIKE '%Pride and prejudice%';
UPDATE `buy_items` SET `author` = 'Emily Brontë' WHERE `item_name` LIKE '%Wuthering%';
UPDATE `buy_items` SET `author` = 'Robert Louis Stevenson' WHERE `item_name` LIKE '%Robert louis%';

-- Update rent_items with authors (same as buy_items)
UPDATE `rent_items` SET `author` = 'Jean Webster' WHERE `item_name` LIKE '%Daddy-Long-Legs%';
UPDATE `rent_items` SET `author` = 'Mabel H. McFarlane' WHERE `item_name` LIKE '%Twilight Land%';
UPDATE `rent_items` SET `author` = 'E. Nesbit' WHERE `item_name` LIKE '%Phoenix%' OR `item_name` LIKE '%Dragons%' OR `item_name` LIKE '%Five Children%';
UPDATE `rent_items` SET `author` = 'Rudyard Kipling' WHERE `item_name` LIKE '%Jungle Book%';
UPDATE `rent_items` SET `author` = 'Lewis Carroll' WHERE `item_name` LIKE '%Alice%' OR `item_name` LIKE '%looking glass%';
UPDATE `rent_items` SET `author` = 'George MacDonald' WHERE `item_name` LIKE '%Princess%';
UPDATE `rent_items` SET `author` = 'J.K. Rowling' WHERE `item_name` LIKE '%Harry potter%';
UPDATE `rent_items` SET `author` = 'Homer' WHERE `item_name` LIKE '%Odyssey%';
UPDATE `rent_items` SET `author` = 'Jean Webster' WHERE `item_name` LIKE '%Dear Enemy%';
UPDATE `rent_items` SET `author` = 'Holly Black' WHERE `item_name` LIKE '%Draculla%';
UPDATE `rent_items` SET `author` = 'Charles Dickens' WHERE `item_name` LIKE '%Oliver Twist%';
UPDATE `rent_items` SET `author` = 'Miguel de Cervantes' WHERE `item_name` LIKE '%Don Quixote%';
UPDATE `rent_items` SET `author` = 'Mark Twain' WHERE `item_name` LIKE '%Huckelberry%' OR `item_name` LIKE '%TOM Sawyer%';
UPDATE `rent_items` SET `author` = 'Jane Austen' WHERE `item_name` LIKE '%Pride and prejudice%';
UPDATE `rent_items` SET `author` = 'Emily Brontë' WHERE `item_name` LIKE '%Wuthering%';

-- Update ebooks with authors
UPDATE `ebooks` SET `author` = 'Mark Blake' WHERE `title` LIKE '%Dreams%';

-- Update audio_books with authors (already have authors)

-- 8. Add some sample tags to books
-- Add tags using comma-separated values for now (will be processed by PHP later)

-- Fiction books get fiction-related tags
UPDATE `buy_items` SET `tags` = 'bestseller,classic,recommended' WHERE `category_id` = 1;
UPDATE `buy_items` SET `tags` = 'fantasy,popular,young-adult' WHERE `category_id` = 2;
UPDATE `buy_items` SET `tags` = 'adventure,popular,recommended' WHERE `category_id` = 3;
UPDATE `buy_items` SET `tags` = 'classic,award-winning,recommended' WHERE `category_id` = 4;
UPDATE `buy_items` SET `tags` = 'romance,popular,trending' WHERE `category_id` = 5;
UPDATE `buy_items` SET `tags` = 'children,illustrated,popular' WHERE `category_id` = 7;
UPDATE `buy_items` SET `tags` = 'horror,trending,adult' WHERE `category_id` = 10;
UPDATE `buy_items` SET `tags` = 'non-fiction,educational' WHERE `category_id` = 12;

-- Same for rent_items
UPDATE `rent_items` SET `tags` = 'bestseller,classic,recommended' WHERE `category_id` = 1;
UPDATE `rent_items` SET `tags` = 'fantasy,popular,young-adult' WHERE `category_id` = 2;
UPDATE `rent_items` SET `tags` = 'adventure,popular,recommended' WHERE `category_id` = 3;
UPDATE `rent_items` SET `tags` = 'classic,award-winning,recommended' WHERE `category_id` = 4;
UPDATE `rent_items` SET `tags` = 'romance,popular,trending' WHERE `category_id` = 5;
UPDATE `rent_items` SET `tags` = 'children,illustrated,popular' WHERE `category_id` = 7;
UPDATE `rent_items` SET `tags` = 'horror,trending,adult' WHERE `category_id` = 10;

-- Add some ratings
UPDATE `buy_items` SET `rating` = 4.5 WHERE `category_id` IN (1, 4);
UPDATE `buy_items` SET `rating` = 4.2 WHERE `category_id` = 2;
UPDATE `buy_items` SET `rating` = 4.0 WHERE `category_id` = 3;
UPDATE `buy_items` SET `rating` = 4.8 WHERE `item_name` LIKE '%Harry potter%';
UPDATE `buy_items` SET `rating` = 3.8 WHERE `category_id` = 10;

UPDATE `rent_items` SET `rating` = 4.5 WHERE `category_id` IN (1, 4);
UPDATE `rent_items` SET `rating` = 4.2 WHERE `category_id` = 2;
UPDATE `rent_items` SET `rating` = 4.0 WHERE `category_id` = 3;
UPDATE `rent_items` SET `rating` = 4.8 WHERE `item_name` LIKE '%Harry potter%';

-- 9. Create indexes for better performance
CREATE INDEX `idx_buy_items_category_rating` ON `buy_items` (`category_id`, `rating`);
CREATE INDEX `idx_rent_items_category_rating` ON `rent_items` (`category_id`, `rating`);
CREATE INDEX `idx_buy_items_author` ON `buy_items` (`author`);
CREATE INDEX `idx_rent_items_author` ON `rent_items` (`author`);

-- Completed! 
-- Your database now has:
-- 1. Categories table with predefined book categories
-- 2. Tags table with predefined tags
-- 3. Book_tags junction table for many-to-many relationships
-- 4. Wishlist table for user wishlists
-- 5. Enhanced book tables with author, publisher, rating, and tag information
-- 6. Updated existing records with appropriate categories and metadata

-- Re-enable safe update mode
SET SQL_SAFE_UPDATES = 1;
