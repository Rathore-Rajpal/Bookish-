-- First, let's find the actual IDs of books in your database
-- Run these SELECT statements to see what books you have and their IDs

SELECT id, item_name FROM buy_items ORDER BY id;
SELECT id, item_name FROM rent_items ORDER BY id;
SELECT id, title FROM ebooks ORDER BY id;
SELECT id, title FROM audio_books ORDER BY id;
