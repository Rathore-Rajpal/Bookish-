-- Add missing columns to buy_items table
ALTER TABLE `buy_items` ADD COLUMN `category_name` varchar(50) DEFAULT NULL;
ALTER TABLE `buy_items` ADD COLUMN `tag_list` text DEFAULT NULL;
ALTER TABLE `buy_items` ADD COLUMN `rating` decimal(2,1) DEFAULT 4.0;

-- Add missing columns to rent_items table  
ALTER TABLE `rent_items` ADD COLUMN `category_name` varchar(50) DEFAULT NULL;
ALTER TABLE `rent_items` ADD COLUMN `tag_list` text DEFAULT NULL;
ALTER TABLE `rent_items` ADD COLUMN `rating` decimal(2,1) DEFAULT 4.0;

-- Set default values for buy_items
UPDATE buy_items SET 
    category_name = 'General', 
    tag_list = 'general,recommended', 
    rating = 4.0 
WHERE category_name IS NULL;

-- Set default values for rent_items
UPDATE rent_items SET 
    category_name = 'General', 
    tag_list = 'general,recommended', 
    rating = 4.0 
WHERE category_name IS NULL;
