-- Alternative: Manual assignment for buy_items
-- If you want to quickly assign categories without knowing exact book names:

-- Set all remaining buy_items to have some category and basic data
UPDATE buy_items SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 1 AND id <= 5;
UPDATE buy_items SET category_id = 2, rating = 4.2, tags = 'fantasy,popular' WHERE category_id IS NULL AND id >= 6 AND id <= 10;
UPDATE buy_items SET category_id = 3, rating = 4.0, tags = 'adventure,recommended' WHERE category_id IS NULL AND id >= 11 AND id <= 15;
UPDATE buy_items SET category_id = 4, rating = 4.5, tags = 'classic,award-winning' WHERE category_id IS NULL AND id >= 16 AND id <= 20;
UPDATE buy_items SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 21 AND id <= 25;

-- Set all remaining rent_items
UPDATE rent_items SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 1 AND id <= 5;
UPDATE rent_items SET category_id = 2, rating = 4.2, tags = 'fantasy,popular' WHERE category_id IS NULL AND id >= 6 AND id <= 10;
UPDATE rent_items SET category_id = 3, rating = 4.0, tags = 'adventure,recommended' WHERE category_id IS NULL AND id >= 11 AND id <= 15;
UPDATE rent_items SET category_id = 4, rating = 4.5, tags = 'classic,award-winning' WHERE category_id IS NULL AND id >= 16 AND id <= 20;
UPDATE rent_items SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 21 AND id <= 25;

-- Set all remaining ebooks
UPDATE ebooks SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 1 AND id <= 3;
UPDATE ebooks SET category_id = 12, rating = 4.0, tags = 'non-fiction,educational' WHERE category_id IS NULL AND id >= 4 AND id <= 6;
UPDATE ebooks SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 7 AND id <= 9;

-- Set all remaining audio_books
UPDATE audio_books SET category_id = 1, rating = 4.0, tags = 'general,recommended' WHERE category_id IS NULL AND id >= 1 AND id <= 2;
UPDATE audio_books SET category_id = 3, rating = 4.0, tags = 'adventure,recommended' WHERE category_id IS NULL AND id >= 3 AND id <= 4;
UPDATE audio_books SET category_id = 2, rating = 4.2, tags = 'fantasy,popular' WHERE category_id IS NULL AND id >= 5 AND id <= 6;

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS `idx_buy_items_category_rating` ON `buy_items` (`category_id`, `rating`);
CREATE INDEX IF NOT EXISTS `idx_rent_items_category_rating` ON `rent_items` (`category_id`, `rating`);
CREATE INDEX IF NOT EXISTS `idx_buy_items_author` ON `buy_items` (`author`);
CREATE INDEX IF NOT EXISTS `idx_rent_items_author` ON `rent_items` (`author`);
