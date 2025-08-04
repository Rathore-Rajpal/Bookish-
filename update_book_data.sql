-- Alternative approach for updating book data
-- This uses safer UPDATE statements that reference the primary key

-- First, let's see what records exist and update them by ID
-- You'll need to run these one by one or check your data first

-- For buy_items table updates
-- Update category_id based on item names using the id column

-- Fiction books (category_id = 1)
UPDATE `buy_items` SET `category_id` = 1, `author` = 'Jean Webster', `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Daddy-Long-Legs%') AS temp);

UPDATE `buy_items` SET `category_id` = 1, `author` = 'Mabel H. McFarlane', `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Twilight Land%') AS temp);

UPDATE `buy_items` SET `category_id` = 1, `author` = 'Jean Webster', `tags` = 'bestseller,classic,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Dear Enemy%') AS temp);

-- Fantasy books (category_id = 2)
UPDATE `buy_items` SET `category_id` = 2, `author` = 'E. Nesbit', `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Phoenix%') AS temp);

UPDATE `buy_items` SET `category_id` = 2, `author` = 'E. Nesbit', `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Dragons%') AS temp);

UPDATE `buy_items` SET `category_id` = 2, `author` = 'George MacDonald', `tags` = 'fantasy,popular,young-adult', `rating` = 4.2 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Princess%') AS temp);

UPDATE `buy_items` SET `category_id` = 2, `author` = 'J.K. Rowling', `tags` = 'fantasy,popular,young-adult', `rating` = 4.8 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Harry potter%') AS temp);

-- Adventure books (category_id = 3)
UPDATE `buy_items` SET `category_id` = 3, `author` = 'Rudyard Kipling', `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Jungle Book%') AS temp);

UPDATE `buy_items` SET `category_id` = 3, `author` = 'Mark Twain', `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Huckelberry%') AS temp);

UPDATE `buy_items` SET `category_id` = 3, `author` = 'Mark Twain', `tags` = 'adventure,popular,recommended', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%TOM Sawyer%') AS temp);

-- Classic books (category_id = 4)
UPDATE `buy_items` SET `category_id` = 4, `author` = 'Lewis Carroll', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Alice%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Lewis Carroll', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%looking glass%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Jane Austen', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Pride and prejudice%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Emily Brontë', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Wuthering%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Charles Dickens', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Oliver Twist%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Miguel de Cervantes', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Don Quixote%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Homer', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Odyssey%') AS temp);

UPDATE `buy_items` SET `category_id` = 4, `author` = 'Robert Louis Stevenson', `tags` = 'classic,award-winning,recommended', `rating` = 4.5 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Robert louis%') AS temp);

-- Romance books (category_id = 5)
UPDATE `buy_items` SET `category_id` = 5, `tags` = 'romance,popular,trending', `rating` = 4.3 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Bitter Sweet%') AS temp);

UPDATE `buy_items` SET `category_id` = 5, `tags` = 'romance,popular,trending', `rating` = 4.3 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%When you were mine%') AS temp);

-- Children books (category_id = 7)
UPDATE `buy_items` SET `category_id` = 7, `author` = 'E. Nesbit', `tags` = 'children,illustrated,popular', `rating` = 4.1 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Five Children%') AS temp);

-- Horror books (category_id = 10)
UPDATE `buy_items` SET `category_id` = 10, `author` = 'Holly Black', `tags` = 'horror,trending,adult', `rating` = 3.8 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Draculla%') AS temp);

-- Non-Fiction books (category_id = 12)
UPDATE `buy_items` SET `category_id` = 12, `tags` = 'non-fiction,educational', `rating` = 4.0 
WHERE `id` IN (SELECT `id` FROM (SELECT `id` FROM `buy_items` WHERE `item_name` LIKE '%Elias Network%') AS temp);
