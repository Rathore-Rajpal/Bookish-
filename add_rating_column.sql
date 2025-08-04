-- Add missing rating column
ALTER TABLE `buy_items` ADD COLUMN `rating` decimal(2,1) DEFAULT 4.0;
ALTER TABLE `rent_items` ADD COLUMN `rating` decimal(2,1) DEFAULT 4.0;
