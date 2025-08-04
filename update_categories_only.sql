-- Update buy_items with categories and tags (columns already exist)

-- Fiction Books
UPDATE buy_items SET category_name = 'Fiction', tag_list = 'classic,bestseller,recommended', rating = 4.5 WHERE id = 83; -- Daddy-Long-Legs
UPDATE buy_items SET category_name = 'Fiction', tag_list = 'fantasy,classic,recommended', rating = 4.2 WHERE id = 84; -- Twilight Land
UPDATE buy_items SET category_name = 'Fiction', tag_list = 'classic,bestseller,recommended', rating = 4.6 WHERE id = 95; -- Dear Enemy-Jean Webster

-- Children's Fantasy
UPDATE buy_items SET category_name = 'Children', tag_list = 'fantasy,children,adventure,popular', rating = 4.3 WHERE id = 85; -- The Phoenix and the Carpet
UPDATE buy_items SET category_name = 'Children', tag_list = 'fantasy,children,adventure,classic', rating = 4.2 WHERE id = 86; -- Five Children and IT
UPDATE buy_items SET category_name = 'Children', tag_list = 'fantasy,children,dragons,adventure', rating = 4.4 WHERE id = 88; -- The Book of Dragons

-- Adventure
UPDATE buy_items SET category_name = 'Adventure', tag_list = 'adventure,classic,animals,children', rating = 4.5 WHERE id = 87; -- The Jungle Book
UPDATE buy_items SET category_name = 'Adventure', tag_list = 'adventure,classic,mythology,epic', rating = 4.3 WHERE id = 91; -- The golden fleece
UPDATE buy_items SET category_name = 'Adventure', tag_list = 'adventure,classic,american,river', rating = 4.4 WHERE id = 99; -- Huckleberry finn
UPDATE buy_items SET category_name = 'Adventure', tag_list = 'adventure,classic,american,childhood', rating = 4.2 WHERE id = 100; -- TOM Sawyer

-- Classic Literature
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,fantasy,children,lewis-carroll', rating = 4.6 WHERE id = 89; -- Through the looking glass
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,fantasy,children,lewis-carroll', rating = 4.6 WHERE id = 90; -- Alice through the looking glass
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,epic,greek,mythology', rating = 4.7 WHERE id = 94; -- The Odyssey
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,epic,greek,mythology', rating = 4.7 WHERE id = 121; -- The Odyssey (duplicate)
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,social,dickens,orphan', rating = 4.4 WHERE id = 97; -- Oliver Twist
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,spanish,satire,knight', rating = 4.5 WHERE id = 98; -- Don Quixote
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,romance,austen,regency', rating = 4.8 WHERE id = 101; -- Pride and prejudice
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,gothic,romance,bronte', rating = 4.6 WHERE id = 102; -- Emily bronte - Wuthering heights
UPDATE buy_items SET category_name = 'Classic', tag_list = 'classic,adventure,treasure,stevenson', rating = 4.5 WHERE id = 106; -- Robert louis stevenson

-- Fantasy
UPDATE buy_items SET category_name = 'Fantasy', tag_list = 'fantasy,children,princess,goblin', rating = 4.3 WHERE id = 92; -- The Princess and the goblin
UPDATE buy_items SET category_name = 'Fantasy', tag_list = 'fantasy,bestseller,magic,young-adult', rating = 4.9 WHERE id = 93; -- Harry potter

-- Horror
UPDATE buy_items SET category_name = 'Horror', tag_list = 'horror,vampire,gothic,dark', rating = 4.1 WHERE id = 96; -- Dracula-Holly Black

-- Non-Fiction
UPDATE buy_items SET category_name = 'Non-Fiction', tag_list = 'non-fiction,thriller,espionage,mystery', rating = 4.0 WHERE id = 103; -- The Elias Network

-- Romance
UPDATE buy_items SET category_name = 'Romance', tag_list = 'romance,young-adult,heartbreak,contemporary', rating = 4.2 WHERE id = 104; -- When you were mine
UPDATE buy_items SET category_name = 'Romance', tag_list = 'romance,drama,emotional,contemporary', rating = 4.1 WHERE id = 105; -- Bitter Sweet

-- Set default values for any remaining books that might not be covered
UPDATE buy_items SET 
    category_name = 'General', 
    tag_list = 'general,recommended', 
    rating = 4.0 
WHERE id > 0 AND category_name IS NULL;
