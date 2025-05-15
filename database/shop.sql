-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 08:18 PM
-- Server version: 9.0.1
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int NOT NULL,
  `UserID` int NOT NULL,
  `Item_ID` int NOT NULL,
  `Quantity` int NOT NULL DEFAULT '1',
  `Date_Added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int NOT NULL,
  `Ordering` int DEFAULT NULL,
  `Visibility` tinyint NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(17, 'Hand Made', 'Hand Made Items', 0, 1, 1, 1, 1),
(18, 'Computers', 'Computer Items', 0, 2, 1, 0, 0),
(19, 'Cell Phones', 'Cell Phones', 0, 3, 1, 0, 0),
(20, 'Clothing', 'Clothes and Fashion', 0, 4, 1, 0, 0),
(21, 'Tools', 'Home Tools', 0, 5, 1, 0, 0),
(23, 'Blackberry', 'Blackberry Phones', 19, 2, 0, 0, 0),
(24, 'Hammers', 'Hammers Description test', 21, 1, 0, 0, 0),
(25, 'Boxes', 'Boxes Hand made', 21, 1, 0, 0, 0),
(26, 'Wool', 'Hand Made wool', 17, 3, 0, 0, 0),
(27, 'Games', '', 0, 1, 1, 0, 0),
(28, 'Cars', 'Luxurious cars', 0, 6, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(10, 'Awesome!\r\n', 0, '2023-05-23', 16, 29),
(11, 'Cool!\r\n', 1, '2023-05-23', 23, 29),
(12, 'Comfortable!\r\n', 0, '2023-05-23', 22, 29),
(13, 'test comment\r\n', 0, '2023-06-09', 17, 29);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Cat_ID` int NOT NULL,
  `Member_ID` int NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(12, 'Network Cable', 'The Cat 9 Network Cable is engineered for ultra-high-speed internet and data connectivity. Designed with precision for modern digital infrastructure, this cable supports data transfer rates of up to 40 Gbps and bandwidths exceeding 2000 MHz, making it ideal for professional environments, 4K/8K video streaming, online gaming, server communication, and cloud computing. It features shielded twisted pairs (STP) to reduce electromagnetic interference and crosstalk, with gold-plated connectors to ensure optimal conductivity and corrosion resistance. Encased in a durable, flexible jacket, the Cat 9 cable is built to last in both home and industrial network setups. Plug-and-play compatibility with routers, switches, modems, and PCs makes this an essential upgrade for stable and future-proof connectivity.\n\n', '100', '2018-03-10', 'USA', 'networkcable.jpg', 18, 14, 'TEC,network,cable,internet'),
(14, 'Assassin\'s Creed', 'Assassin’s Creed is an award-winning open-world action-adventure video game franchise developed by Ubisoft. Set across various historical timelines—from the Crusades and the Renaissance to Ancient Egypt and beyond—the series immerses players in beautifully reconstructed worlds where they assume the role of a skilled assassin. Combining parkour, stealth mechanics, dynamic combat, and rich storytelling, each installment explores the ancient conflict between the Assassins, who fight for freedom, and the Templars, who seek control. With detailed environments, realistic NPCs, and deeply emotional narratives, Assassin’s Creed offers an unforgettable experience that blurs the lines between history and fantasy. A must-play for fans of history, mystery, and immersive single-player adventures.\n\n', '150', '2018-03-26', 'Turkey', 'AssassinsCreed.jpg', 27, 21, 'Game,Action'),
(16, 'Chess Wooden Game', 'This premium handcrafted wooden chess set is the perfect blend of tradition, elegance, and gameplay. Crafted from high-quality hardwoods like Sheesham and Maple, the set features finely carved Staunton-style pieces with a polished finish that makes every match a pleasure to play and behold. The folding wooden board doubles as a storage box, lined with felt compartments to protect your pieces. Ideal for both beginners and professional players, this chess set elevates strategy and cognitive development while serving as a beautiful decorative piece in any home or office. Whether it’s for casual play, club competition, or gifting, this classic wooden chess game promises timeless enjoyment.\n\n', '100', '2018-03-29', 'Egypt', 'ChessWoodenGame.jpg', 17, 21, 'Hand, Discount, Guarantee'),
(17, 'Battlefield V', 'Enter the most immersive and dynamic World War II combat experience with Battlefield V, a high-intensity first-person shooter designed for PlayStation 4. Developed by DICE and published by EA, the game redefines large-scale multiplayer warfare with destructible environments, massive 64-player battles, and tactical team gameplay. Players can choose from various soldier classes, vehicles, and weapons across historically inspired European and North African theaters of war. The single-player campaign, “War Stories,” offers emotionally engaging narratives from different perspectives of the war. Featuring breathtaking visuals powered by the Frostbite engine and a constantly evolving online community, Battlefield V delivers endless adrenaline-filled action for FPS enthusiasts.', '70', '2018-03-30', 'USA', 'battlefieldv.png', 27, 21, 'RPG, Online, Game'),
(18, 'Resident Evil 4', 'Resident Evil 4 reimagines the iconic survival horror classic with state-of-the-art visuals, intense atmosphere, and modernized gameplay for today’s generation. Step into the shoes of special agent Leon S. Kennedy as he ventures into a remote European village to rescue the U.S. President’s daughter, only to uncover a horrific bio-terror conspiracy. The remake features realistic graphics, overhauled controls, improved AI, and a more immersive combat system while staying true to the gripping narrative that defined the original. With terrifying enemy encounters, puzzle-solving elements, and resource management challenges, this game is perfect for fans of horror, thrillers, and tactical shooters on the PlayStation platform.', '100', '2018-03-30', 'Japan', 'residentevil4.jpg', 27, 21, 'Online, RPG, Game'),
(21, 'Macbook Pro m2', 'The new Apple MacBook Pro 16\" with M2 Pro chip is a revolutionary powerhouse designed for creators, developers, and professionals demanding extreme performance. Featuring Apple’s latest M2 Pro SoC, it delivers lightning-fast performance with a 12-core CPU and up to a 19-core GPU, capable of handling 8K video editing, high-end 3D rendering, machine learning, and intense multitasking effortlessly. Its Liquid Retina XDR display offers incredible brightness, color accuracy, and a 120Hz ProMotion refresh rate. Equipped with an all-day battery (up to 22 hours), 1TB+ SSD options, advanced thermal systems, a 1080p FaceTime HD camera, and macOS ecosystem integration, the MacBook Pro M2 is the gold standard for productivity and creativity on the go.', '31571', '2023-04-14', 'USA', 'macbookprom2.jpg', 18, 21, 'Macbook,Pro,m2,laptop'),
(22, 'Nike Men Air Force', 'The Nike Air Force 1 Men’s Sneakers are a timeless streetwear icon that blends classic design with modern comfort. Originally introduced in 1982, this shoe remains one of Nike’s most enduring silhouettes thanks to its versatile aesthetic and performance-driven features. Crafted from premium leather with reinforced stitching, it offers exceptional durability and a clean finish. The full-length Air-Sole unit provides superior cushioning and impact absorption, while the padded collar ensures maximum ankle support. Whether you’re pairing them with casual outfits or urban streetwear, these sneakers deliver unmatched style, comfort, and legacy. A must-have for sneakerheads and fashion-forward individuals.', '450', '2023-05-20', 'USA', 'NikeMenAirForce.jpg', 20, 29, 'Nike,Men,Air,Force'),
(23, 'Apple iPhone 16 Pro Max', 'The Apple iPhone 16 Pro Max represents the pinnacle of smartphone innovation, luxury, and performance. Built with aerospace-grade titanium, this flagship device features an edge-to-edge 6.9-inch ProMotion OLED display with ultra-smooth 120Hz refresh rate. Powered by the all-new A18 Bionic chip, it delivers groundbreaking AI performance, lightning-fast processing, and improved energy efficiency. Its quad-camera system includes an advanced telephoto lens, LiDAR scanner, and cinematic 8K video recording capabilities. With enhanced privacy features, Face ID, MagSafe compatibility, satellite connectivity, and iOS 18 enhancements, the iPhone 16 Pro Max sets a new standard for productivity, photography, and mobile computing.', '41999', '2023-05-20', 'USA', 'AppleiPhone16ProMax.webp', 18, 29, 'Apple,iPhone,16,ProMax'),
(24, 'Vintage Leather Backpack', 'Discover the perfect balance between elegance, practicality, and durability with our Vintage Leather Backpack. Crafted from premium full-grain leather, this bag exudes timeless charm and is designed to age beautifully over time. Whether you\'re heading to work, school, or embarking on a weekend getaway, this backpack offers ample storage space with multiple compartments to keep your belongings organized — including a padded laptop sleeve, zippered front pocket, and interior slots for accessories.\r\n\r\nThe adjustable shoulder straps ensure a comfortable fit for all-day use, while the reinforced stitching and high-quality metal zippers provide long-lasting performance. Ideal for both men and women, it’s not just a bag — it’s a statement piece that reflects your taste and lifestyle.\r\n\r\nElevate your everyday carry with a bag that combines modern functionality with classic design. Perfect as a gift or a personal upgrade, this leather backpack will become your go-to companion for years to come.', '499', '2025-05-12', 'Morocco', 'VintageLeatherBackpack.jpg', 20, 30, 'Bags,Electronics,Clothing,Home,Decor,Accessories'),
(25, 'Pure Moroccan Argan Oil – 50ml', 'Experience the power of nature with our 100% Pure Moroccan Argan Oil, cold-pressed from the finest argan kernels grown in the heart of Morocco. Rich in vitamin E, antioxidants, and essential fatty acids, this multi-purpose oil deeply nourishes your skin, strengthens your hair, and restores a natural glow. Perfect for use as a facial moisturizer, hair serum, nail treatment, or body oil, its non-greasy texture absorbs quickly without clogging pores. Ideal for all skin types — including sensitive or acne-prone skin — this vegan and cruelty-free product comes in a dark glass bottle to preserve freshness. No additives, no chemicals, just pure goodness from Moroccan tradition.', '129', '2025-05-12', 'Morocco', 'arganoil.webp', 17, 30, 'Beauty,Wellness,Pure,Moroccan,Argan,Oil'),
(27, 'AuriX T9 Wireless Earbuds', 'Enjoy crisp sound and true wireless freedom with the AuriX T9 Bluetooth Earbuds. Engineered with high-fidelity stereo sound, deep bass, and noise reduction technology, these earbuds are perfect for music lovers, athletes, and remote workers. With a battery life of up to 6 hours on a single charge and an additional 24 hours via the compact charging case, you can enjoy your favorite tracks all day long. The earbuds feature intuitive touch controls, a built-in mic for hands-free calls, and IPX5 water resistance for worry-free use during workouts or rainy commutes. Lightweight and ergonomic, the AuriX T9 delivers comfort and performance in a sleek, minimalist design.', '349', '2025-05-12', 'USA', 'AuriXT9WirelessEarbuds.jpg', 18, 30, 'Electronics,AuriX,T9,Wireless,Earbuds');

-- --------------------------------------------------------

--
-- Table structure for table `sold_items`
--

CREATE TABLE `sold_items` (
  `SaleID` int NOT NULL,
  `UserID` int NOT NULL,
  `Item_ID` int NOT NULL,
  `Quantity` int NOT NULL DEFAULT '1',
  `UnitPrice` decimal(10,2) NOT NULL,
  `SoldAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sold_items`
--

INSERT INTO `sold_items` (`SaleID`, `UserID`, `Item_ID`, `Quantity`, `UnitPrice`, `SoldAt`) VALUES
(1, 12, 18, 3, 100.00, '2025-05-11 18:47:17'),
(2, 12, 12, 1, 100.00, '2025-05-11 18:47:35'),
(3, 12, 12, 1, 100.00, '2025-05-11 18:48:27'),
(4, 12, 14, 5, 150.00, '2025-05-11 18:49:00'),
(5, 12, 12, 1, 100.00, '2025-05-11 19:09:11'),
(6, 12, 22, 1, 450.00, '2025-05-11 19:09:11'),
(7, 30, 12, 2, 100.00, '2025-05-12 01:59:11'),
(8, 30, 14, 2, 150.00, '2025-05-12 01:59:11'),
(9, 30, 25, 33, 129.00, '2025-05-12 01:59:11'),
(10, 30, 12, 5, 100.00, '2025-05-12 10:31:28'),
(11, 30, 25, 5, 129.00, '2025-05-12 10:31:28'),
(12, 30, 17, 1, 70.00, '2025-05-14 14:57:02'),
(13, 30, 18, 1, 100.00, '2025-05-14 14:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int NOT NULL COMMENT 'To identify user',
  `Username` varchar(255) NOT NULL COMMENT 'Username to login',
  `Password` varchar(255) NOT NULL COMMENT 'Password to login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `admin` int NOT NULL DEFAULT '0' COMMENT 'Identifies Group ID (Admin or Normal User or Moderator)',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `admin`, `Date`) VALUES
(12, 'Hind', 'hind@123', 'hind@gmail.com', 'Hind Ahmed', 1, '2025-02-25'),
(14, 'Fathy', '03785d4e638cd09cea620fd0939bf06825be88df', 'fathy@fathy.com', 'Fathy Shady', 0, '2025-02-25'),
(16, 'Ramy', '59f7c8818803a2f0d7946e160dc2a63b88c0ee28', 'ramy@ramy.com', 'Ramy Rabie', 0, '2025-02-25'),
(17, 'Adel', 'e5594062f0a0a362abbb022a6fb0c36dcd9a1bd1', 'adel@yahoo.com', 'Adel Sameh', 0, '2025-02-25'),
(21, 'Mazen', '601f1889667efaebb33b8c12572835da3f027f78', 'mazen@mazen.com', 'Mazen Naeem', 0, '2025-03-02'),
(27, 'Abu Gamal', '601f1889667efaebb33b8c12572835da3f027f78', 'abugamal@hotmail.com', 'Abu Gamal Mahmoud Shanawany', 0, '2025-03-31'),
(29, 'Ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ahmed@gmail.com', 'Ahmed Yahya', 1, '2025-05-20'),
(30, 'AyoubEnnaciri', '1234', 'buoyairi@gmail.com', 'ENNACIRI AYOUB', 0, '2025-05-10'),
(32, 'ZAINB BELKHOU', 'Ayoub@123', 'zainabbelkhou@gmail.com', 'ZAINB BELKHOU', 0, '2025-05-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD UNIQUE KEY `user_item` (`UserID`,`Item_ID`),
  ADD KEY `cart_item_fk` (`Item_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `My_items_comments` (`item_id`),
  ADD KEY `My_users_comment` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `hamada` (`Member_ID`),
  ADD KEY `hazem` (`Cat_ID`);

--
-- Indexes for table `sold_items`
--
ALTER TABLE `sold_items`
  ADD PRIMARY KEY (`SaleID`),
  ADD KEY `idx_user` (`UserID`),
  ADD KEY `idx_item` (`Item_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sold_items`
--
ALTER TABLE `sold_items`
  MODIFY `SaleID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT COMMENT 'To identify user', AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_item_fk` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_user_fk` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `My_items_comments` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `My_users_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `hamada` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hazem` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sold_items`
--
ALTER TABLE `sold_items`
  ADD CONSTRAINT `fk_sold_item` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sold_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
