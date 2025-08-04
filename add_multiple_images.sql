-- Add multiple image columns to buy_items table
-- This script adds 3 additional image columns to support multiple product images

ALTER TABLE `buy_items` 
ADD COLUMN `photo2` varchar(255) DEFAULT 'placeholder.jpg',
ADD COLUMN `photo3` varchar(255) DEFAULT 'placeholder.jpg',
ADD COLUMN `photo4` varchar(255) DEFAULT 'placeholder.jpg';

-- Update existing records to have placeholder images for the new columns
UPDATE `buy_items` 
SET 
    `photo2` = 'placeholder.jpg',
    `photo3` = 'placeholder.jpg', 
    `photo4` = 'placeholder.jpg'
WHERE 
    `photo2` IS NULL OR `photo3` IS NULL OR `photo4` IS NULL;

-- Create placeholder image references
-- Note: You'll need to add actual placeholder.jpg to your image folders
