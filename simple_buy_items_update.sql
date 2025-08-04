-- Simple direct updates using specific IDs
-- Replace the ID numbers with the actual IDs from your database
-- This approach will work with safe update mode

-- STEP 1: Run find_book_ids.sql first to get the actual IDs
-- STEP 2: Replace the ID numbers below with your actual book IDs
-- STEP 3: Run these updates

-- Example updates (replace with your actual IDs):
-- UPDATE buy_items SET category_id = 1, author = 'Jean Webster', tags = 'bestseller,classic,recommended', rating = 4.5 WHERE id = 1;
-- UPDATE buy_items SET category_id = 2, author = 'J.K. Rowling', tags = 'fantasy,popular,young-adult', rating = 4.8 WHERE id = 2;

-- Template for buy_items updates:
-- Fiction (category_id = 1)
UPDATE buy_items SET category_id = 1, author = 'Jean Webster', tags = 'bestseller,classic,recommended', rating = 4.5 WHERE id = 1; -- Replace 1 with actual ID of Daddy-Long-Legs
UPDATE buy_items SET category_id = 1, author = 'Mabel H. McFarlane', tags = 'bestseller,classic,recommended', rating = 4.5 WHERE id = 2; -- Replace 2 with actual ID of Twilight Land
UPDATE buy_items SET category_id = 1, author = 'Jean Webster', tags = 'bestseller,classic,recommended', rating = 4.5 WHERE id = 3; -- Replace 3 with actual ID of Dear Enemy

-- Fantasy (category_id = 2)
UPDATE buy_items SET category_id = 2, author = 'E. Nesbit', tags = 'fantasy,popular,young-adult', rating = 4.2 WHERE id = 4; -- Replace 4 with actual ID of Phoenix book
UPDATE buy_items SET category_id = 2, author = 'E. Nesbit', tags = 'fantasy,popular,young-adult', rating = 4.2 WHERE id = 5; -- Replace 5 with actual ID of Dragons book
UPDATE buy_items SET category_id = 2, author = 'George MacDonald', tags = 'fantasy,popular,young-adult', rating = 4.2 WHERE id = 6; -- Replace 6 with actual ID of Princess book
UPDATE buy_items SET category_id = 2, author = 'J.K. Rowling', tags = 'fantasy,popular,young-adult', rating = 4.8 WHERE id = 7; -- Replace 7 with actual ID of Harry Potter

-- Adventure (category_id = 3)
UPDATE buy_items SET category_id = 3, author = 'Rudyard Kipling', tags = 'adventure,popular,recommended', rating = 4.0 WHERE id = 8; -- Replace 8 with actual ID of Jungle Book
UPDATE buy_items SET category_id = 3, author = 'Mark Twain', tags = 'adventure,popular,recommended', rating = 4.0 WHERE id = 9; -- Replace 9 with actual ID of Huckleberry Finn
UPDATE buy_items SET category_id = 3, author = 'Mark Twain', tags = 'adventure,popular,recommended', rating = 4.0 WHERE id = 10; -- Replace 10 with actual ID of Tom Sawyer

-- Classic (category_id = 4)
UPDATE buy_items SET category_id = 4, author = 'Lewis Carroll', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 11; -- Replace 11 with actual ID of Alice book
UPDATE buy_items SET category_id = 4, author = 'Lewis Carroll', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 12; -- Replace 12 with actual ID of Looking Glass
UPDATE buy_items SET category_id = 4, author = 'Jane Austen', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 13; -- Replace 13 with actual ID of Pride and Prejudice
UPDATE buy_items SET category_id = 4, author = 'Emily Brontë', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 14; -- Replace 14 with actual ID of Wuthering Heights
UPDATE buy_items SET category_id = 4, author = 'Charles Dickens', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 15; -- Replace 15 with actual ID of Oliver Twist
UPDATE buy_items SET category_id = 4, author = 'Miguel de Cervantes', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 16; -- Replace 16 with actual ID of Don Quixote
UPDATE buy_items SET category_id = 4, author = 'Homer', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 17; -- Replace 17 with actual ID of Odyssey
UPDATE buy_items SET category_id = 4, author = 'Robert Louis Stevenson', tags = 'classic,award-winning,recommended', rating = 4.5 WHERE id = 18; -- Replace 18 with actual ID of Robert Louis book

-- Romance (category_id = 5)
UPDATE buy_items SET category_id = 5, tags = 'romance,popular,trending', rating = 4.3 WHERE id = 19; -- Replace 19 with actual ID of Bitter Sweet
UPDATE buy_items SET category_id = 5, tags = 'romance,popular,trending', rating = 4.3 WHERE id = 20; -- Replace 20 with actual ID of When You Were Mine

-- Children (category_id = 7)
UPDATE buy_items SET category_id = 7, author = 'E. Nesbit', tags = 'children,illustrated,popular', rating = 4.1 WHERE id = 21; -- Replace 21 with actual ID of Five Children

-- Horror (category_id = 10)
UPDATE buy_items SET category_id = 10, author = 'Holly Black', tags = 'horror,trending,adult', rating = 3.8 WHERE id = 22; -- Replace 22 with actual ID of Dracula

-- Non-Fiction (category_id = 12)
UPDATE buy_items SET category_id = 12, tags = 'non-fiction,educational', rating = 4.0 WHERE id = 23; -- Replace 23 with actual ID of Elias Network

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS `idx_buy_items_category_rating` ON `buy_items` (`category_id`, `rating`);
CREATE INDEX IF NOT EXISTS `idx_buy_items_author` ON `buy_items` (`author`);
