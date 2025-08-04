-- Update rent_items with safer approach using primary key
-- These updates should work with safe mode enabled

-- Fiction books (category_id = 1)
UPDATE `rent_items` SET `category_id` = 1, `author` = 'Jean Webster', `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Daddy-Long-Legs%') AS temp);

UPDATE `rent_items` SET `category_id` = 1, `author` = 'Mabel H. McFarlane', `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Twilight Land%') AS temp);

UPDATE `rent_items` SET `category_id` = 1, `author` = 'Jean Webster', `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Dear Enemy%') AS temp);

-- Fantasy books (category_id = 2)
UPDATE `rent_items` SET `category_id` = 2, `author` = 'E. Nesbit', `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Phoenix%') AS temp);

UPDATE `rent_items` SET `category_id` = 2, `author` = 'E. Nesbit', `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Dragons%') AS temp);

UPDATE `rent_items` SET `category_id` = 2, `author` = 'George MacDonald', `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Princess%') AS temp);

UPDATE `rent_items` SET `category_id` = 2, `author` = 'J.K. Rowling', `tags` = 'fantasy,popular,young-adult', `rating` = 4.8 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Harry potter%') AS temp);

-- Adventure books (category_id = 3)
UPDATE `rent_items` SET `category_id` = 3, `author` = 'Rudyard Kipling', `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Jungle Book%') AS temp);

UPDATE `rent_items` SET `category_id` = 3, `author` = 'Mark Twain', `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Huckelberry%') AS temp);

UPDATE `rent_items` SET `category_id` = 3, `author` = 'Mark Twain', `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%TOM Sawyer%') AS temp);

-- Classic books (category_id = 4)
UPDATE `rent_items` SET `category_id` = 4, `author` = 'Lewis Carroll', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Alice%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Lewis Carroll', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%looking glass%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Jane Austen', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Pride and prejudice%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Emily Brontë', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Wuthering%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Charles Dickens', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Oliver Twist%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Miguel de Cervantes', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Don Quixote%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Homer', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Odyssey%') AS temp);

UPDATE `rent_items` SET `category_id` = 4, `author` = 'Emily Brontë', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Wuthering%') AS temp);

-- Children books (category_id = 7)
UPDATE `rent_items` SET `category_id` = 7, `author` = 'E. Nesbit', `tags` = 'children,illustrated,popular', `rating` = 4.1 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Five Children%') AS temp);

-- Horror books (category_id = 10)
UPDATE `rent_items` SET `category_id` = 10, `author` = 'Holly Black', `tags` = 'horror,trending,adult', `rating` = 3.8 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `rent_items` WHERE `item_name` LIKE '%Draculla%') AS temp);

-- Update ebooks
UPDATE `ebooks` SET `category_id` = 1, `author` = 'Mark Blake', `tags` = 'bestseller,classic,recommended', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `ebooks` WHERE `title` LIKE '%Dreams%') AS temp);

UPDATE `ebooks` SET `category_id` = 1, `tags` = 'bestseller,classic,recommended', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `ebooks` WHERE `title` LIKE '%Welcome to Nowhere%') AS temp);

UPDATE `ebooks` SET `category_id` = 1, `tags` = 'bestseller,classic,recommended', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `ebooks` WHERE `title` LIKE '%Page of the Sea%') AS temp);

UPDATE `ebooks` SET `category_id` = 1, `tags` = 'bestseller,classic,recommended', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `ebooks` WHERE `title` LIKE '%Islanders%') AS temp);

UPDATE `ebooks` SET `category_id` = 12, `tags` = 'non-fiction,educational', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `ebooks` WHERE `title` LIKE '%Apple Vision Pro%') AS temp);

-- Update audio_books
UPDATE `audio_books` SET `category_id` = 1, `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `audio_books` WHERE `title` LIKE '%Daddy%') AS temp);

UPDATE `audio_books` SET `category_id` = 1, `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `audio_books` WHERE `title` LIKE '%Twilight%') AS temp);

UPDATE `audio_books` SET `category_id` = 3, `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `audio_books` WHERE `title` LIKE '%Jungle Book%') AS temp);

UPDATE `audio_books` SET `category_id` = 2, `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `audio_books` WHERE `title` LIKE '%Dragons%') AS temp);

UPDATE `audio_books` SET `category_id` = 2, `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `audio_books` WHERE `title` LIKE '%Princess%') AS temp);

UPDATE `audio_books` SET `category_id` = 4, `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `audio_books` WHERE `title` LIKE '%Golden Fleece%') AS temp);

-- Create indexes for better performance
CREATE INDEX `idx_buy_items_category_rating` ON `buy_items` (`category_id`, `rating`);
CREATE INDEX `idx_rent_items_category_rating` ON `rent_items` (`category_id`, `rating`);
CREATE INDEX `idx_buy_items_author` ON `buy_items` (`author`);
CREATE INDEX `idx_rent_items_author` ON `rent_items` (`author`);
