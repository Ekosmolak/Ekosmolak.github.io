-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 08:15 PM
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
-- Database: `campkosmolak`
--
CREATE DATABASE IF NOT EXISTS `campkosmolak` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `campkosmolak`;

-- --------------------------------------------------------

--
-- Table structure for table `catchlog`
--

DROP TABLE IF EXISTS `catchlog`;
CREATE TABLE `catchlog` (
  `Catch_Id` int(11) NOT NULL,
  `Fish_Id` int(11) DEFAULT NULL,
  `Catch_Size` decimal(11,2) DEFAULT NULL,
  `Client_Id` int(11) DEFAULT NULL,
  `Date_Caught` date DEFAULT NULL,
  `fish_pic` varchar(255) DEFAULT NULL,
  `Fish_Type` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catchlog`
--

INSERT INTO `catchlog` (`Catch_Id`, `Fish_Id`, `Catch_Size`, `Client_Id`, `Date_Caught`, `fish_pic`, `Fish_Type`) VALUES
(1, 4, 15.00, 2, '2024-06-12', 'images/largemouth.png', 'Largemouth Bass'),
(2, 2, 52.00, 8, '2024-06-05', 'images/master.jpg', 'Pike'),
(5, 1, 28.00, 1, '2024-06-18', 'uploads/walleye.png', 'Walleye'),
(6, 3, 18.00, 7, '2024-06-20', 'uploads/smallmouth.png', 'Smallmouth Bass'),
(7, 1, 14.00, 7, '2024-06-20', 'uploads/smallmouth2.png', 'Smallmouth Bass'),
(8, 6, 45.00, 8, '2024-06-19', 'uploads/musky.png', 'Musky'),
(9, 2, 35.00, 1, '2024-06-18', 'uploads/pike.png', 'Pike');

--
-- Triggers `catchlog`
--
DROP TRIGGER IF EXISTS `after_catchlog_insert`;
DELIMITER $$
CREATE TRIGGER `after_catchlog_insert` AFTER INSERT ON `catchlog` FOR EACH ROW BEGIN
    DECLARE reg_size DECIMAL(10, 2);
    DECLARE f_name VARCHAR(40);
    DECLARE l_name VARCHAR(40);

    SELECT Regulation_Size INTO reg_size
    FROM fish
    WHERE Fish_Id = NEW.Fish_Id;

    SELECT First_Name, Last_Name INTO f_name, l_name
    FROM client
    WHERE Client_Id = NEW.Client_Id;

    IF NEW.Catch_Size > reg_size THEN
        INSERT INTO masterangler (Client_Id, Catch_Id, Catch_Size, fish_pic, Fish_Type, First_Name, Last_Name, Date_Caught)
        VALUES (NEW.Client_Id, NEW.Catch_Id, NEW.Catch_Size, NEW.fish_pic, NEW.Fish_Type, f_name, l_name, NEW.Date_Caught);
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_catchlog_update`;
DELIMITER $$
CREATE TRIGGER `after_catchlog_update` AFTER UPDATE ON `catchlog` FOR EACH ROW BEGIN
    DECLARE first_name VARCHAR(255);
    DECLARE last_name VARCHAR(255);

    SELECT First_Name, Last_Name
    INTO first_name, last_name
    FROM client
    WHERE Client_Id = NEW.Client_Id;

    UPDATE masterangler
    SET 
        Client_Id = NEW.Client_Id,
        Catch_Size = NEW.Catch_Size,
        Date_Caught = NEW.Date_Caught,
        fish_pic = NEW.fish_pic,
        Fish_Type = NEW.Fish_Type,
        First_Name = first_name,
        Last_Name = last_name
    WHERE Catch_Id = NEW.Catch_Id;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_catchlog_update_masterangler`;
DELIMITER $$
CREATE TRIGGER `after_catchlog_update_masterangler` AFTER UPDATE ON `catchlog` FOR EACH ROW BEGIN
    UPDATE masterangler
    SET 
        Client_Id = NEW.Client_Id,
        Catch_Size = NEW.Catch_Size,
        fish_pic = NEW.fish_pic,
        Fish_Type = NEW.Fish_Type,
        Date_Caught = NEW.Date_Caught
    WHERE Catch_Id = NEW.Catch_Id;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_catchlog_insert`;
DELIMITER $$
CREATE TRIGGER `before_catchlog_insert` BEFORE INSERT ON `catchlog` FOR EACH ROW BEGIN
    DECLARE fish_type_value VARCHAR(255);

    SELECT Fish_Type INTO fish_type_value
    FROM fish
    WHERE Fish_Id = NEW.Fish_Id;

    SET NEW.Fish_Type = fish_type_value;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `Client_Id` int(11) NOT NULL,
  `First_Name` varchar(255) DEFAULT NULL,
  `Last_Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Client_Id`, `First_Name`, `Last_Name`) VALUES
(1, 'Peter', 'Griffen'),
(2, 'Homer', 'Simpson'),
(5, 'Ron', 'Burgundy'),
(7, 'Dale', 'Doback'),
(8, 'John', 'Cena');

-- --------------------------------------------------------

--
-- Table structure for table `fish`
--

DROP TABLE IF EXISTS `fish`;
CREATE TABLE `fish` (
  `Fish_Id` int(11) NOT NULL,
  `Fish_Type` varchar(255) NOT NULL,
  `Regulation_Size` int(11) NOT NULL,
  `Fish_Description` varchar(600) NOT NULL,
  `fish_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fish`
--

INSERT INTO `fish` (`Fish_Id`, `Fish_Type`, `Regulation_Size`, `Fish_Description`, `fish_pic`) VALUES
(1, 'Walleye', 26, 'The walleye is a freshwater fish native to North America, known for its distinctive olive and gold coloring, and large, glassy eyes. \r\n                        It is highly prized both as a game fish and for its delicious, flaky white meat. Walleyes inhabi', 'images/walleye.png'),
(2, 'Pike', 38, 'The pike is a predatory freshwater fish widely distributed across the Northern Hemisphere, including North America, Europe, and Asia. \r\n                Recognizable by its elongated body, sharp teeth, and distinctive, duckbill-like snout, the pike is an a', 'images/pike.png'),
(3, 'Smallmouth Bass', 16, 'The smallmouth bass is a freshwater fish native to North America, particularly found in clear, cool rivers and lakes. \r\n                    It is easily identifiable by its bronze to greenish-brown coloration and the vertical bars along its sides. \r\n     ', 'images/smallmouth.png'),
(4, 'Largemouth Bass', 18, 'The largemouth bass is a prominent freshwater fish native to North America, characterized by its olive-green body with a series of dark blotches forming a horizontal stripe along each flank. \r\n                    Unlike the smallmouth bass, largemouth bas', 'images/largemouth.png'),
(5, 'Perch', 13, 'The perch, commonly known as the yellow perch, is a freshwater fish native to North America. \r\n                    It is easily recognizable by its golden-yellow body with distinct dark vertical stripes and its spiny dorsal fin.\r\n                    Yello', 'images/perch.png'),
(6, 'Musky', 40, 'The muskellunge, commonly known as the musky, is a large, freshwater fish native to North America. Renowned for its impressive size and predatory nature, it can grow over 50 inches long and weigh more than 30 pounds. \r\n                    Muskies have elo', 'images/musky.png');

-- --------------------------------------------------------

--
-- Table structure for table `masterangler`
--

DROP TABLE IF EXISTS `masterangler`;
CREATE TABLE `masterangler` (
  `Master_Id` int(11) NOT NULL,
  `Client_Id` int(11) DEFAULT NULL,
  `Catch_Id` int(11) DEFAULT NULL,
  `Catch_Size` int(11) DEFAULT NULL,
  `fish_pic` varchar(255) DEFAULT NULL,
  `Fish_Type` varchar(40) DEFAULT NULL,
  `First_Name` varchar(40) DEFAULT NULL,
  `Last_Name` varchar(40) DEFAULT NULL,
  `Date_Caught` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masterangler`
--

INSERT INTO `masterangler` (`Master_Id`, `Client_Id`, `Catch_Id`, `Catch_Size`, `fish_pic`, `Fish_Type`, `First_Name`, `Last_Name`, `Date_Caught`) VALUES
(1, 8, 2, 52, 'images/master.jpg', 'Pike', NULL, NULL, NULL),
(2, 1, 5, 28, 'uploads/walleye.png', 'Walleye', 'Peter', 'Griffen', '2024-06-18'),
(3, 7, 6, 18, 'uploads/smallmouth.png', 'Smallmouth Bass', 'Dale', 'Doback', '2024-06-20'),
(4, 7, 7, 14, 'uploads/smallmouth2.png', 'Smallmouth Bass', NULL, NULL, '2024-06-20'),
(5, 8, 8, 45, 'uploads/musky.png', 'Musky', 'John', 'Cena', '2024-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `Review_Id` int(11) NOT NULL,
  `Client_Id` int(11) DEFAULT NULL,
  `Review_Content` varchar(1000) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `Review_Title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Review_Id`, `Client_Id`, `Review_Content`, `date_posted`, `Review_Title`) VALUES
(1, 7, 'To celebrate the launch of my company Prestige World Wide, I brought my team here for a week and it did not disappoint!', '2024-06-14 03:55:35', 'Best Week of My Life'),
(2, 2, 'I had the best time here.', '2024-06-17 16:58:43', 'Home Run Time'),
(3, 5, 'I brought my news team here and Rick caught a master walleye, Stay Classy LOTW.', '2024-06-17 21:13:26', 'Channel 4 News Crew'),
(12, 1, 'I want to come back already', '2024-06-21 16:59:31', 'Great');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catchlog`
--
ALTER TABLE `catchlog`
  ADD PRIMARY KEY (`Catch_Id`),
  ADD KEY `Fish_Id` (`Fish_Id`),
  ADD KEY `Client_Id` (`Client_Id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Client_Id`);

--
-- Indexes for table `fish`
--
ALTER TABLE `fish`
  ADD PRIMARY KEY (`Fish_Id`);

--
-- Indexes for table `masterangler`
--
ALTER TABLE `masterangler`
  ADD PRIMARY KEY (`Master_Id`),
  ADD KEY `Client_Id` (`Client_Id`),
  ADD KEY `Catch_Id` (`Catch_Id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_Id`),
  ADD KEY `Client_Id` (`Client_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catchlog`
--
ALTER TABLE `catchlog`
  MODIFY `Catch_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `Client_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fish`
--
ALTER TABLE `fish`
  MODIFY `Fish_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `masterangler`
--
ALTER TABLE `masterangler`
  MODIFY `Master_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catchlog`
--
ALTER TABLE `catchlog`
  ADD CONSTRAINT `catchlog_ibfk_1` FOREIGN KEY (`Fish_Id`) REFERENCES `fish` (`Fish_Id`),
  ADD CONSTRAINT `catchlog_ibfk_2` FOREIGN KEY (`Client_Id`) REFERENCES `client` (`Client_ID`);

--
-- Constraints for table `masterangler`
--
ALTER TABLE `masterangler`
  ADD CONSTRAINT `masterangler_ibfk_1` FOREIGN KEY (`Client_Id`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `masterangler_ibfk_2` FOREIGN KEY (`Catch_Id`) REFERENCES `catchlog` (`Catch_Id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Client_Id`) REFERENCES `client` (`Client_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
