-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 03:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sem4`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `srno` int(10) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`srno`, `admin_name`, `password`) VALUES
(1, 'Shweta', 'shweta'),
(2, 'Raj', 'raj');

-- --------------------------------------------------------

--
-- Table structure for table `audio_books`
--

CREATE TABLE `audio_books` (
  `srno` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `audio_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audio_books`
--

INSERT INTO `audio_books` (`srno`, `title`, `author`, `description`, `image_path`, `audio_path`) VALUES
(2, 'Daady Lonng Legs', 'Jean Webster', 'Daddy-Long-Legs is a classic coming-of-age novel told in the form of letters written by an orphan named Jerusha \"Judy\" Abbott to her benefactor, whom she has never met. The story follows Judy as she embarks on a journey to find herself, education, and independence, all while being financially supported by a mysterious man known only as \"Daddy-Long-Legs.\" The novel explores themes of self-discovery, freedom, and the challenges of growing up.', 'audio_uploads/images/book_1.jpeg', 'audio_uploads/audio/audio_1.mp3'),
(3, ' Twilight Land', 'William J. Locke', 'Twilight Land is a novel that explores themes of adventure, fantasy, and the pursuit of happiness. Set in a fantastical world, it tells the story of a group of characters who journey through a land where the boundaries between reality and dreams blur. The protagonist embarks on a quest filled with intriguing challenges and encounters, facing personal dilemmas, moral questions, and the ultimate search for peace and fulfillment. The book is known for its vivid descriptions, enchanting settings, an', 'audio_uploads/images/book_2.jpeg', 'audio_uploads/audio/audio_2.mp3'),
(7, 'The Jungle Book', 'Rudyard Kipling', '\"The Jungle Book\" is a collection of stories by Rudyard Kipling, set in the Indian jungle. The story follows Mowgli, a boy raised by wolves, as he learns about the natural world and the laws of the jungle, while encountering various animal characters like the wise panther Bagheera and the lovable bear Baloo. The book explores themes of survival, identity, and the bond between humans and nature.', 'audio_uploads/images/book_5.jpeg', 'audio_uploads/audio/audio_4.mp3'),
(8, 'The Book of Dragons', 'E. Nesbit', '\"The Book of Dragons\" is a charming collection of dragon-themed stories by E. Nesbit. The book features a variety of imaginative and magical tales where dragons play central roles, often as both fearsome and friendly creatures. Through these stories, readers are transported into fantastical worlds where dragons breathe fire, fly, and interact with humans in both humorous and heartwarming ways. The collection explores themes of adventure, friendship, and the enchantment of the mythical world.', 'audio_uploads/images/book_6.jpg', 'audio_uploads/audio/audio_5.mp3'),
(9, 'The Golden Fleece', 'Apollonius of Rhodes', '\"The Golden Fleece\" is an ancient Greek myth that tells the story of Jason and the Argonauts on their quest to retrieve the legendary Golden Fleece. This myth is filled with thrilling adventures, encounters with gods, mythical creatures, and dangerous trials. The Golden Fleece is a symbol of kingship and authority, and the journey to claim it involves a series of heroic deeds, including battling enemies and navigating through enchanted lands. The tale is a rich blend of adventure, heroism, and t', 'audio_uploads/images/book_9.jpeg', 'audio_uploads/audio/audio_6.mp3'),
(13, 'The Princess and the Goblin', ' George MacDonald ', 'The story follows Princess Irene, a brave and curious girl who discovers a hidden world beneath her castle, inhabited by mischievous goblins. These goblins, led by the sinister Goblin King, plot to kidnap her and disrupt her peaceful life. Fortunately, Irene is aided by her magical, invisible friend', 'audio_uploads/images/book_10.jpeg', 'audio_uploads/audio/audio_6.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `buy_items`
--

CREATE TABLE `buy_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buy_items`
--

INSERT INTO `buy_items` (`id`, `item_name`, `category`, `description`, `price`, `photo`, `created_at`, `qty`) VALUES
(83, 'Daddy-Long-Legs', 'New', '&quot;Daddy-Long-Legs&quot; is a novel by Jean Webster, first published in 1912. The story follows Judy Abbott, an orphan who receives a scholarship to attend college from an anonymous benefactor whom she nicknames &quot;Daddy-Long-Legs&quot; due to his long legs that she glimpses as he leaves her orphanage. The novel is told through a series of charming and humorous letters from Judy to her mysterious sponsor. As she navigates her college life, friendships, and romantic interests, Judy&#039;s independent spirit and determination shine through. The book explores themes of social class, personal growth, and the importance of education.', 300.00, '670a12b925ba7_book_1.jpeg', '2024-10-12 06:10:01', 9),
(84, 'Twilight Land', 'New', '&quot;Twilight Land&quot; is a fantasy novel by Mabel H. McFarlane, published in 1916. The story follows a young girl named Maud who, feeling disconnected from the world around her, discovers a magical realm called Twilight Land. In this enchanting place, she encounters various whimsical characters and experiences adventures that challenge her understanding of reality and imagination.', 250.00, '670a13115d1b8_book_2.jpeg', '2024-10-12 06:11:29', 7),
(85, 'The Phonix and the Carpet', 'New', '&quot;The Phoenix and the Carpet&quot; is a children&#039;s novel by E. Nesbit, published in 1904. The story follows the adventures of the Bastable children—Dora, Ivan, Cyril, and Anthea—who discover a magical carpet that has the power to fly. Alongside the carpet, they encounter a phoenix, a mythical bird that is reborn from its ashes.', 450.00, '670a134622072_book_3.jpg', '2024-10-12 06:12:22', 7),
(86, 'Five Childern and IT', 'New', '&quot;Five Children and It&quot; is a children&#039;s novel by E. Nesbit, first published in 1902. The story follows five siblings—Anthea, Cyril, Robert, Jane, and the baby brother known as the Lamb—who discover a magical creature known as a Psammead (a sand fairy) while playing on a beach.', 250.00, '670a137d15fc7_book_4.jpg', '2024-10-12 06:13:17', 5),
(87, 'The Jungle Book', 'New', '&quot;The Jungle Book&quot; is a collection of stories by Rudyard Kipling, first published in 1894. The most famous tale is that of Mowgli, a human boy raised by wolves in the Indian jungle. The book explores themes of belonging, identity, and the struggle between civilization and nature.', 180.00, '670a139ead1ae_book_5.jpeg', '2024-10-12 06:13:50', 9),
(88, 'The Book of Dragons', 'New', '&quot;The Book of Dragons&quot; is a charming collection of children&#039;s stories by E. Nesbit, published in 1900. The book features a series of delightful tales centered around dragons, each with its unique plot and moral lessons.', 500.00, '670a13c4a2eb9_book_6.jpg', '2024-10-12 06:14:28', 9),
(89, 'Through the looking glass', 'New', '&quot;Through the Looking-Glass, and What Alice Found There&quot; is a novel by Lewis Carroll, published in 1871 as the sequel to the beloved &quot;Alice&#039;s Adventures in Wonderland.&quot; In this fantastical tale, Alice enters a whimsical world by stepping through a looking glass (a mirror) and finds herself in a realm where everything is reversed and behaves in curious ways.', 700.00, '670a1409e1545_book_7.jpg', '2024-10-12 06:15:37', 9),
(90, 'Alice through the looking glass', 'New', 'Alice Through the Looking-Glass, and What Alice Found There&quot; is a novel by Lewis Carroll, published in 1871 as the sequel to &quot;Alice&#039;s Adventures in Wonderland.&quot; In this enchanting story, Alice steps through a looking glass (a mirror) and enters a fantastical world that is a reflection of her own.', 600.00, '670a146174eba_book_8.jpg', '2024-10-12 06:17:05', 9),
(91, 'The golden flee', 'New', '&quot;The Golden Fleece&quot; is a classic Greek myth centered on the hero Jason and his quest to retrieve the Golden Fleece, a symbol of authority and kingship. Tasked by King Pelias, Jason assembles a group of heroes known as the Argonauts and embarks on a perilous journey aboard the ship Argo. They encounter various challenges, including hostile creatures and treacherous seas, before reaching the land of Colchis, where the fleece is guarded by a dragon.', 750.00, '670a14a8a80fa_book_9.jpeg', '2024-10-12 06:18:16', 10),
(92, 'The Princess and the goblin', 'New', '&quot;The Princess and the Goblin&quot; is a children&#039;s fantasy novel by George MacDonald. It follows the adventures of Princess Irene, a brave and curious girl who discovers that her kingdom is threatened by mischievous goblins living underground. With the help of her magical, invisible friend a mysterious grandmother, and a young miner named Curdie, Irene learns to navigate the dangers posed by the goblins.', 350.00, '670a14dccfa9a_book_10.jpeg', '2024-10-12 06:19:08', 10),
(93, 'Harry potter', 'New', '&quot;Harry Potter&quot; is a series of fantasy novels by J.K. Rowling that follows the life of a young wizard, Harry Potter, and his friends Hermione Granger and Ron Weasley. The story begins with Harry discovering he is a wizard on his 11th birthday and attending Hogwarts School of Witchcraft and Wizardry.', 600.00, '670a1518e5187_book_11.jpeg', '2024-10-12 06:20:08', 10),
(94, 'The Odyssey', 'New', '&quot;The Odyssey&quot; is an ancient Greek epic poem attributed to Homer, narrating the adventurous journey of Odysseus, the king of Ithaca, as he attempts to return home after the Trojan War. The poem explores themes of heroism, loyalty, and the struggle against divine and natural obstacles.', 150.00, '670a154bcc392_book_12.jpeg', '2024-10-12 06:20:59', 10),
(95, 'Dear Enemy-Jean Webester', 'New', '&quot;Dear Enemy&quot; by Jean Webster is a novel that follows the correspondence between Judy Abbott, a spirited young woman, and Mr. John Smith, the new benefactor of Judy&#039;s orphanage. The story unfolds through a series of letters in which Judy shares her humorous and insightful experiences at the orphanage while seeking to reform its management.', 750.00, '670a1577e0004_book_13.jpg', '2024-10-12 06:21:43', 10),
(96, 'Draculla-Holy Blacke', 'New', '&quot;Dracula&quot; by Holly Black is a modern reimagining of Bram Stoker&#039;s classic tale. This version delves into the themes of obsession and the complexities of desire through the eyes of its young protagonist. As the story unfolds, the boundaries between horror and romance blur, bringing forth a dark and seductive atmosphere.', 230.00, '670a15c391c58_book_14.jpeg', '2024-10-12 06:22:59', 10),
(97, 'Oliver Twist', 'New', '&quot;Oliver Twist&quot; by Charles Dickens follows the life of a young orphan named Oliver, who endures a harsh upbringing in a workhouse and later escapes to London. There, he encounters a host of characters, both benevolent and villainous, including the Artful Dodger and the infamous Fagin, who leads a gang of juvenile thieves.', 400.00, '670a160490122_book_15.jpeg', '2024-10-12 06:24:04', 10),
(98, 'Don Quixote', 'New', '&quot;Don Quixote&quot; by Miguel de Cervantes tells the story of an aging nobleman, Alonso Quixano, who becomes obsessed with chivalric tales and decides to become a knight-errant, adopting the name Don Quixote. Armed with outdated armor and accompanied by his loyal squire, Sancho Panza, he embarks on a series of misadventures, mistaking windmills for giants and inns for castles.', 450.00, '670a164593e99_book_16.jpg', '2024-10-12 06:25:09', 10),
(99, 'Huckelberry finn', 'New', '&quot;The Adventures of Huckleberry Finn&quot; by Mark Twain follows the journey of a young boy, Huck Finn, who escapes his abusive father and embarks on a raft trip down the Mississippi River with Jim, an escaped slave. The novel explores themes of friendship, freedom, and the moral dilemmas surrounding slavery and racism in pre-Civil War America.', 750.00, '670a166e33d9d_book_17.jpg', '2024-10-12 06:25:50', 10),
(100, 'TOM Sawyer', 'New', '&quot;The Adventures of Tom Sawyer&quot; by Mark Twain follows the mischievous young boy Tom Sawyer, who lives in a small town along the Mississippi River. Tom enjoys a carefree life filled with adventures, pranks, and exploring with his friends, particularly Huckleberry Finn. The novel captures Tom&#039;s escapades, including his romance with Becky Thatcher, his adventures in a haunted house, and a dramatic trip to an island with Huck.', 150.00, '670a16db6dd31_book_18.jpg', '2024-10-12 06:27:39', 10),
(101, 'Pride and prejudice', 'Used', '&quot;Pride and Prejudice&quot; by Jane Austen centers around Elizabeth Bennet, one of five sisters in early 19th-century England, as she navigates issues of class, marriage, and morality. The novel explores Elizabeth&#039;s evolving relationship with the wealthy and aloof Mr. Darcy, initially characterized by misunderstandings and prejudice.', 80.00, '670a17120a58d_book_20.jpg', '2024-10-12 06:28:34', 5),
(102, 'Emily bronte - Wuthering heights', 'Used', '&quot;Wuthering Heights&quot; by Emily Brontë is a tale of intense passion and revenge set on the Yorkshire moors. It follows the tumultuous relationship between Heathcliff, a brooding orphan, and Catherine Earnshaw, the spirited daughter of his adoptive father. After Catherine&#039;s marriage to Edgar Linton, Heathcliff&#039;s obsession leads him to seek revenge on those he believes have wronged him.', 120.00, '670a174063c23_book_21.jpg', '2024-10-12 06:29:20', 5),
(103, 'The Elias Network', 'Used', '&quot;The Elias Network&quot; is a gripping thriller that delves into the world of espionage and surveillance. It follows a former intelligence operative who is drawn back into a dangerous web of secrets and conspiracies when a mysterious organization, known as the Elias Network, threatens global stability.', 70.00, '670a18858a090_book_22.jpg', '2024-10-12 06:34:45', 5),
(104, 'When you were mine', 'Used', '&quot;When You Were Mine&quot; is a poignant novel that explores the themes of love, loss, and the complexity of relationships. It tells the story of a girl who grapples with the heartache of unrequited love after her best friend begins dating the boy she secretly loves. As she navigates her feelings and the shifting dynamics of friendship and romance, the narrative delves into the emotional turmoil of adolescence, highlighting the challenges of growing up and the bittersweet nature of love.', 130.00, '670a18b779af4_book_23.jpg', '2024-10-12 06:35:35', 10),
(105, 'Bitter Sweet', 'New', '&quot;Bitter Sweet&quot; is a compelling narrative that intertwines themes of love, loss, and the complexity of human emotions. The story follows characters who navigate the intricate balance between joy and sorrow in their lives, exploring the impact of past choices on their present.', 270.00, '670a18e717e51_book_24.jpg', '2024-10-12 06:36:23', 10),
(106, 'Robert louis steveson', 'New', 'Robert Louis Stevenson was a master storyteller whose works often explore the themes of adventure, duality, and morality. In &quot;Treasure Island,&quot; young Jim Hawkins embarks on a thrilling journey to find buried treasure, confronting the treacherous pirate Long John Silver along the way.', 270.00, '670a1a253ea07_book_19.jpg', '2024-10-12 06:41:41', 10);

-- --------------------------------------------------------

--
-- Table structure for table `custom_orders`
--

CREATE TABLE `custom_orders` (
  `srno` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `authors` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(10) NOT NULL,
  `publisher_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `total_amt` int(10) NOT NULL,
  `shipping_address` varchar(300) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_orders`
--

INSERT INTO `custom_orders` (`srno`, `username`, `book_name`, `authors`, `category`, `quantity`, `publisher_name`, `name`, `contact`, `payment_method`, `total_amt`, `shipping_address`, `order_date`) VALUES
(9, 'yashzii', 'Daddy Long Legs', 'Jean Webester', 'New', 2, 'NULL', 'Yash Padwal', '9175442260', 'debit_card', 20, 'Wagholi,Pune', '2024-10-12 15:04:14'),
(11, 'yashzii', 'Daddy Long Legs', 'Jean Webester', 'New', 2, 'NULL', 'Yash Padwal', '9175442260', 'credit_card', 20, 'Wagholi,Pune', '2024-10-12 16:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `ebooks`
--

CREATE TABLE `ebooks` (
  `srno` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `pdf_link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ebooks`
--

INSERT INTO `ebooks` (`srno`, `title`, `image`, `pdf_link`) VALUES
(2, 'Welcome to Nowhere, Ohio', 'ebook_images/book_1.jpg', 'ebooks/book_1.pdf'),
(3, 'The Page of the Sea', 'ebook_images/book_2.jpg', 'ebooks/book_2.pdf'),
(4, 'The Islanders', 'ebook_images/book_3.jpg', 'ebooks/book_3.pdf'),
(5, 'Dreams- Mark Blake', 'ebook_images/book_4.jpg', 'ebooks/book_4.pdf'),
(6, 'Apple Vision Pro ', 'ebook_images/book_5.jpg', 'ebooks/book_5.pdf'),
(7, 'Bitter Sweet', 'ebook_images/book_6.jpg', 'ebooks/book_6.pdf'),
(8, 'Within You Withou You', 'ebook_images/book_7.jpg', 'ebooks/book_7.pdf'),
(9, 'The Usual Silence', 'ebook_images/book_8.jpg', 'ebooks/book_8.pdf'),
(10, 'When You Were Mine', 'ebook_images/book_10.jpg', 'ebooks/book_10.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `srno` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `total_amount` int(10) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `profit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`srno`, `username`, `name`, `contact`, `address`, `payment_method`, `total_amount`, `item_name`, `qty`, `profit`) VALUES
(19, 'rajsaa', 'Rapal', '9175442260', 'makrana rajasthan', 'upi', 620, 'Twilight Land, Five Childern and IT', '1, 1', 20),
(20, 'rajsaa', 'rajsaa', '9175442260', 'makrana rajasthan', 'upi', 770, 'The Phonix and the Carpet, Five Childern and IT', '1, 1', 20),
(21, 'shwetazii', 'shwetazii', '9175442260', 'makrana rajasthan', 'debit_card', 510, 'The Phonix and the Carpet', '1', 10),
(22, 'yashzii', 'Yash Padwal', '9175442260', 'wagholi, Pune', 'upi', 520, 'Twilight Land, Five Childern and IT', '1, 1', 20),
(25, 'rajsaa', 'rajsaa', '9175442260', 'wagholi, Pune', 'upi', 970, 'Through the looking glass, Five Childern and IT', '1, 1', 20),
(26, 'shwetazii', 'shwetazii', '9175442260', 'Dheri, Rohatas, Bihar', 'debit_card', 510, 'The Book of Dragons', '1', 10),
(27, 'yashzii', 'yashzii', '9175442260', 'Dheri, Rohatas, Bihar', 'upi', 720, 'The Phonix and the Carpet, Five Childern and IT', '1, 1', 20),
(28, 'yashzii', 'yashzii', '9175442260', 'makrana rajasthan', 'upi', 720, 'Five Childern and IT, The Phonix and the Carpet', '1, 1', 20),
(29, 'yashzii', 'yashzii', '9175442260', 'Dheri, Rohatas, Bihar', 'upi', 800, 'Alice through the looking glass, The Jungle Book', '1, 1', 20),
(30, 'rajsaa', 'rajsaa', '9175442260', 'makrana rajasthan', 'upi', 460, 'The Phonix and the Carpet', '1', 10),
(31, 'yashzii', 'yashzii', '9175442260', 'Dheri, Rohatas, Bihar', 'upi', 520, 'Twilight Land, Five Childern and IT', '1, 1', 20);

-- --------------------------------------------------------

--
-- Table structure for table `rented`
--

CREATE TABLE `rented` (
  `srno` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `total` int(10) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `rent_days` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `return_date` date NOT NULL,
  `profit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented`
--

INSERT INTO `rented` (`srno`, `username`, `name`, `contact`, `address`, `payment_method`, `total`, `item_name`, `rent_days`, `start_date`, `return_date`, `profit`) VALUES
(10, 'rajsaa', 'Rajpal Singh', '9175442260', 'makrana rajasthan', 'debit_card', 12, 'Twilight Land', '2', '2024-10-10', '2024-10-12', 5),
(11, 'rajsaa', 'Rajpal Singh', '9175442260', 'makrana rajasthan', 'debit_card', 12, 'Twilight Land', '2', '2024-10-10', '2024-10-12', 5),
(12, 'rajsaa', 'Rajpal Singh', '9175442260', 'makrana rajasthan', 'cod', 25, 'Twilight Land, Five Childern and IT', '2, 3', '2024-10-11', '2024-10-16', 10),
(13, 'shwetazii', 'Shweta ', '9175442260', 'Dheri, Rohatas, Bihar', 'debit_card', 20, 'The Phonix and the Carpet', '3', '2024-10-12', '2024-10-15', 5),
(14, 'yashzii', 'Yash Padwal', '9175442260', 'Waghole Pune', 'debit_card', 30, 'Daddy-Long-Legs, The Phonix and the Carpet', '2, 3', '2024-10-12', '2024-10-17', 10),
(15, 'yashzii', 'Rajpal Singh', '9175442260', 'makrana rajasthan', 'debit_card', 10, 'Twilight Land', '2', '2024-10-12', '2024-10-14', 5),
(20, 'shwetazii', 'Shweta ', '9175442260', 'Dheri, Rohatas, Bihar', 'upi', 38, 'The Phonix and the Carpet, Twilight Land', '5, 2', '2024-10-14', '2024-10-21', 10),
(21, 'yashzii', 'Rajpal Singh', '9175442260', 'Dheri, Rohatas, Bihar', 'upi', 14, 'The Phonix and the Carpet', '2', '2024-10-14', '2024-10-16', 5),
(22, 'yashzii', 'Rajpal Singh', '9175442260', 'makrana rajasthan', 'debit_card', 14, 'The Phonix and the Carpet', '2', '2024-10-14', '2024-10-16', 5),
(23, 'rajsaa', 'Yash Padwal', '9175442260', 'wagholi, Pune', 'debit_card', 10, 'Twilight Land', '2', '2024-10-14', '2024-10-16', 5),
(24, 'rajsaa', 'Rajpal Singh', '9175442260', 'helllooooooo', 'upi', 28, 'The golden flee', '3', '2024-10-14', '2024-10-17', 5);

-- --------------------------------------------------------

--
-- Table structure for table `rent_items`
--

CREATE TABLE `rent_items` (
  `id` int(10) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent_items`
--

INSERT INTO `rent_items` (`id`, `item_name`, `category`, `description`, `price`, `photo`, `created_at`, `qty`) VALUES
(29, 'Daddy-Long-Legs', 'New', '&quot;Daddy-Long-Legs&quot; is a novel by Jean Webster, first published in 1912. The story follows Judy Abbott, an orphan who receives a scholarship to attend college from an anonymous benefactor whom she nicknames &quot;Daddy-Long-Legs&quot; due to his long legs that she glimpses as he leaves her orphanage. The novel is told through a series of charming and humorous letters from Judy to her mysterious sponsor. As she navigates her college life, friendships, and romantic interests, Judy&#039;s i', 300, '670a12b925ba7_book_1.jpeg', '2024-10-12 06:10:01', '8'),
(30, 'Twilight Land', 'New', '&quot;Twilight Land&quot; is a fantasy novel by Mabel H. McFarlane, published in 1916. The story follows a young girl named Maud who, feeling disconnected from the world around her, discovers a magical realm called Twilight Land. In this enchanting place, she encounters various whimsical characters and experiences adventures that challenge her understanding of reality and imagination.', 250, '670a13115d1b8_book_2.jpeg', '2024-10-12 06:11:29', '6'),
(31, 'The Phonix and the Carpet', 'New', '&quot;The Phoenix and the Carpet&quot; is a children&#039;s novel by E. Nesbit, published in 1904. The story follows the adventures of the Bastable children—Dora, Ivan, Cyril, and Anthea—who discover a magical carpet that has the power to fly. Alongside the carpet, they encounter a phoenix, a mythical bird that is reborn from its ashes.', 450, '670a134622072_book_3.jpg', '2024-10-12 06:12:22', '4'),
(32, 'Five Childern and IT', 'New', '&quot;Five Children and It&quot; is a children&#039;s novel by E. Nesbit, first published in 1902. The story follows five siblings—Anthea, Cyril, Robert, Jane, and the baby brother known as the Lamb—who discover a magical creature known as a Psammead (a sand fairy) while playing on a beach.', 250, '670a137d15fc7_book_4.jpg', '2024-10-12 06:13:17', '10'),
(33, 'The Jungle Book', 'New', '&quot;The Jungle Book&quot; is a collection of stories by Rudyard Kipling, first published in 1894. The most famous tale is that of Mowgli, a human boy raised by wolves in the Indian jungle. The book explores themes of belonging, identity, and the struggle between civilization and nature.', 180, '670a139ead1ae_book_5.jpeg', '2024-10-12 06:13:50', '10'),
(34, 'The Book of Dragons', 'New', '&quot;The Book of Dragons&quot; is a charming collection of children&#039;s stories by E. Nesbit, published in 1900. The book features a series of delightful tales centered around dragons, each with its unique plot and moral lessons.', 500, '670a13c4a2eb9_book_6.jpg', '2024-10-12 06:14:28', '10'),
(35, 'Through the looking glass', 'New', '&quot;Through the Looking-Glass, and What Alice Found There&quot; is a novel by Lewis Carroll, published in 1871 as the sequel to the beloved &quot;Alice&#039;s Adventures in Wonderland.&quot; In this fantastical tale, Alice enters a whimsical world by stepping through a looking glass (a mirror) and finds herself in a realm where everything is reversed and behaves in curious ways. The story is structured like a chess game, with Alice moving from square to square, meeting a host of peculiar chara', 700, '670a1409e1545_book_7.jpg', '2024-10-12 06:15:37', '10'),
(36, 'Alice through the looking glass', 'New', 'Alice Through the Looking-Glass, and What Alice Found There&quot; is a novel by Lewis Carroll, published in 1871 as the sequel to &quot;Alice&#039;s Adventures in Wonderland.&quot; In this enchanting story, Alice steps through a looking glass (a mirror) and enters a fantastical world that is a reflection of her own, where everything is reversed and behaves in peculiar ways. The narrative is structured like a chess game, with Alice moving from square to square, encountering various whimsical char', 600, '670a146174eba_book_8.jpg', '2024-10-12 06:17:05', '10'),
(37, 'The golden flee', 'New', '&quot;The Golden Fleece&quot; is a classic Greek myth centered on the hero Jason and his quest to retrieve the Golden Fleece, a symbol of authority and kingship. Tasked by King Pelias, Jason assembles a group of heroes known as the Argonauts and embarks on a perilous journey aboard the ship Argo. They encounter various challenges, including hostile creatures and treacherous seas, before reaching the land of Colchis, where the fleece is guarded by a dragon.', 750, '670a14a8a80fa_book_9.jpeg', '2024-10-12 06:18:16', '9'),
(38, 'The Princess and the goblin', 'New', '&quot;The Princess and the Goblin&quot; is a children&#039;s fantasy novel by George MacDonald. It follows the adventures of Princess Irene, a brave and curious girl who discovers that her kingdom is threatened by mischievous goblins living underground. With the help of her magical, invisible friend a mysterious grandmother, and a young miner named Curdie, Irene learns to navigate the dangers posed by the goblins.', 350, '670a14dccfa9a_book_10.jpeg', '2024-10-12 06:19:08', '9'),
(39, 'Harry potter', 'New', '&quot;Harry Potter&quot; is a series of fantasy novels by J.K. Rowling that follows the life of a young wizard, Harry Potter, and his friends Hermione Granger and Ron Weasley. The story begins with Harry discovering he is a wizard on his 11th birthday and attending Hogwarts School of Witchcraft and Wizardry.', 600, '670a1518e5187_book_11.jpeg', '2024-10-12 06:20:08', '10'),
(40, 'The Odyssey', 'New', '&quot;The Odyssey&quot; is an ancient Greek epic poem attributed to Homer, narrating the adventurous journey of Odysseus, the king of Ithaca, as he attempts to return home after the Trojan War. The poem explores themes of heroism, loyalty, and the struggle against divine and natural obstacles.', 150, '670a154bcc392_book_12.jpeg', '2024-10-12 06:20:59', '10'),
(41, 'Dear Enemy-Jean Webester', 'New', '&quot;Dear Enemy&quot; by Jean Webster is a novel that follows the correspondence between Judy Abbott, a spirited young woman, and Mr. John Smith, the new benefactor of Judy&#039;s orphanage. The story unfolds through a series of letters in which Judy shares her humorous and insightful experiences at the orphanage while seeking to reform its management.', 750, '670a1577e0004_book_13.jpg', '2024-10-12 06:21:43', '10'),
(42, 'Draculla-Holy Blacke', 'New', '&quot;Dracula&quot; by Holly Black is a modern reimagining of Bram Stoker&#039;s classic tale. This version delves into the themes of obsession and the complexities of desire through the eyes of its young protagonist. As the story unfolds, the boundaries between horror and romance blur, bringing forth a dark and seductive atmosphere.', 230, '670a15c391c58_book_14.jpeg', '2024-10-12 06:22:59', '10'),
(43, 'Oliver Twist', 'New', '&quot;Oliver Twist&quot; by Charles Dickens follows the life of a young orphan named Oliver, who endures a harsh upbringing in a workhouse and later escapes to London. There, he encounters a host of characters, both benevolent and villainous, including the Artful Dodger and the infamous Fagin, who leads a gang of juvenile thieves.', 400, '670a160490122_book_15.jpeg', '2024-10-12 06:24:04', '10'),
(44, 'Don Quixote', 'New', '&quot;Don Quixote&quot; by Miguel de Cervantes tells the story of an aging nobleman, Alonso Quixano, who becomes obsessed with chivalric tales and decides to become a knight-errant, adopting the name Don Quixote. Armed with outdated armor and accompanied by his loyal squire, Sancho Panza, he embarks on a series of misadventures, mistaking windmills for giants and inns for castles.', 450, '670a164593e99_book_16.jpg', '2024-10-12 06:25:09', '10'),
(45, 'Huckelberry finn', 'New', '&quot;The Adventures of Huckleberry Finn&quot; by Mark Twain follows the journey of a young boy, Huck Finn, who escapes his abusive father and embarks on a raft trip down the Mississippi River with Jim, an escaped slave. The novel explores themes of friendship, freedom, and the moral dilemmas surrounding slavery and racism in pre-Civil War America.', 750, '670a166e33d9d_book_17.jpg', '2024-10-12 06:25:50', '10'),
(46, 'TOM Sawyer', 'New', '&quot;The Adventures of Tom Sawyer&quot; by Mark Twain follows the mischievous young boy Tom Sawyer, who lives in a small town along the Mississippi River. Tom enjoys a carefree life filled with adventures, pranks, and exploring with his friends, particularly Huckleberry Finn. The novel captures Tom&#039;s escapades, including his romance with Becky Thatcher, his adventures in a haunted house, and a dramatic trip to an island with Huck.', 150, '670a16db6dd31_book_18.jpg', '2024-10-12 06:27:39', '10'),
(47, 'Pride and prejudice', 'Used', '&quot;Pride and Prejudice&quot; by Jane Austen centers around Elizabeth Bennet, one of five sisters in early 19th-century England, as she navigates issues of class, marriage, and morality. The novel explores Elizabeth&#039;s evolving relationship with the wealthy and aloof Mr. Darcy, initially characterized by misunderstandings and prejudice.', 80, '670a17120a58d_book_20.jpg', '2024-10-12 06:28:34', '5'),
(48, 'Emily bronte - Wuthering heights', 'Used', '&quot;Wuthering Heights&quot; by Emily Brontë is a tale of intense passion and revenge set on the Yorkshire moors. It follows the tumultuous relationship between Heathcliff, a brooding orphan, and Catherine Earnshaw, the spirited daughter of his adoptive father. After Catherine&#039;s marriage to Edgar Linton, Heathcliff&#039;s obsession leads him to seek revenge on those he believes have wronged him.', 120, '670a174063c23_book_21.jpg', '2024-10-12 06:29:20', '5'),
(79, 'The Jungle Book', 'New', 'hiiiiiiii', 200, '670cc24401f14_WhatsApp Image 2024-04-21 at 15.23.42_f980d279.jpg', '2024-10-14 07:03:48', '2'),
(80, 'Daddy-Long-Legs', 'New', 'gds', 121, '670cd947c2b95_WhatsApp Image 2024-04-21 at 15.24.29_69454f2e.jpg', '2024-10-14 08:42:00', '2');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `srno` int(5) NOT NULL,
  `username` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `sell_rent_option` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `platform_fee` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`srno`, `username`, `item_name`, `category`, `description`, `price`, `quantity`, `photo`, `sell_rent_option`, `name`, `contact_no`, `payment_method`, `platform_fee`, `date`) VALUES
(10, 'rajsaa', 'Twilight', 'Education', 'hii', 200, 3, '670890d87b97b_book_15.jpeg', 'both', 'Rajpal Singh', '9175442260', 'Debit Card', 60, '2024-10-11 02:43:47'),
(11, 'rajsaa', 'Twilight', 'Education', 'hii', 250, 2, '6708ae3b00de5_book_15.jpeg', 'both', 'Rajpal Singh', '9175442260', 'PayPal', 40, '2024-10-11 04:49:55'),
(20, 'shwetazii', 'The Jungle Book', 'New', 'hiii', 20, 1, '670cb7659ffe6_WhatsApp Image 2024-04-21 at 15.23.42_f980d279.jpg', 'both', 'Rajpal Singh', '9175442260', 'Debit Card', 20, '2024-10-14 06:17:25'),
(21, 'yashzii', 'The Jungle Book', 'New', 'hiiiiiiii', 200, 2, '670cc24401f14_WhatsApp Image 2024-04-21 at 15.23.42_f980d279.jpg', 'both', 'Yash Padwal', '9175442260', 'PayPal', 40, '2024-10-14 07:03:48'),
(22, 'rajsaa', 'Daddy-Long-Legs', 'New', 'gds', 121, 2, '670cd947c2b95_WhatsApp Image 2024-04-21 at 15.24.29_69454f2e.jpg', 'both', 'Rajpal Singh', '9175442260', 'Debit Card', 40, '2024-10-14 08:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `email`, `password`, `dt`, `image`) VALUES
(22, 'Rajpal', 'Singh', 'rajsaa', 'rajpalrathore4455@gmail.com', '$2y$10$v6Rsngb7DnNk0EgD5mzk/u1jFfsMHr/4xTy6LOWUA58ZrxPwGtRV2', '2024-10-10 15:04:33', 'profile_1359846947.png'),
(24, 'Shweta', 'Verma', 'shwetazii', 'shweta@gmail.com', '$2y$10$ynqEYOKCharFYYuGfq9jquN/E28UTAu2LbwFpjxd13VcJDBhbPZQ6', '2024-10-12 05:43:17', 'profile_1096507620.jpg'),
(25, 'Yash', 'Padwal', 'yashzii', 'yash@gmail.com', '$2y$10$Zv3sEWZZqExGCFFRlHwBfeC7oaZ/MTO90o3Bd2Fju3DM/KgWgV5W2', '2024-10-12 07:17:13', 'profile_2037589042.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `audio_books`
--
ALTER TABLE `audio_books`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `buy_items`
--
ALTER TABLE `buy_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_orders`
--
ALTER TABLE `custom_orders`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `ebooks`
--
ALTER TABLE `ebooks`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `rented`
--
ALTER TABLE `rented`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `rent_items`
--
ALTER TABLE `rent_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `srno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audio_books`
--
ALTER TABLE `audio_books`
  MODIFY `srno` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `buy_items`
--
ALTER TABLE `buy_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `custom_orders`
--
ALTER TABLE `custom_orders`
  MODIFY `srno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ebooks`
--
ALTER TABLE `ebooks`
  MODIFY `srno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `srno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `rented`
--
ALTER TABLE `rented`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rent_items`
--
ALTER TABLE `rent_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `srno` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
