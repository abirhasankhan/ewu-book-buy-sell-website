-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 08:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ewu_book_buy_sell`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(15) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `role` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `pass`, `role`) VALUES
('admin', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booksell`
--

CREATE TABLE `booksell` (
  `sell_id` int(11) NOT NULL,
  `book_name` varchar(400) NOT NULL,
  `writer_name` varchar(400) NOT NULL,
  `book_overview` varchar(4000) NOT NULL,
  `language` varchar(50) NOT NULL,
  `book_con` varchar(15) NOT NULL,
  `price` varchar(50) NOT NULL,
  `book_img` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `pick_loc` varchar(400) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booksell`
--

INSERT INTO `booksell` (`sell_id`, `book_name`, `writer_name`, `book_overview`, `language`, `book_con`, `price`, `book_img`, `date`, `pick_loc`, `student_id`, `status`) VALUES
(8, 'Vintage', 'Regina Phalange', 'Vintage, in winemaking, is the process of picking grapes and creating the finished product—wine. A vintage wine is one made from grapes that were all, or primarily, grown and harvested in a single specified year.', 'English', 'used', '240tk', '../images/f08134919f4c86cdbook-4.jpg', '2023-05-07 20:05:21', 'University underground', 'S01', 0),
(15, 'Vintage', 'Regina Phalange', 'Vintage, in winemaking, is the process of picking grapes and creating the finished product—wine. A vintage wine is one made from grapes that were all, or primarily, grown and harvested in a single specified year.', 'English', 'brand', '230tk', '../images/31af66e4e2ddf3571675029320885.png', '2023-05-09 03:16:29', 'University underground', 'S01', 1),
(18, 'Hidden', 'K.M. Wray', 'This is horror story', 'English', 'used', '200tk', '../images/f75429b6bcdaef52book-2.jpg', '2023-05-21 00:59:00', 'University Cafeteria', 'S01', 1),
(19, 'Vintage Book', 'Regina Phalange', 'Limited edition', 'English', 'used', '185', '../images/fe097c2b4749a8cabook-3.jpg', '2023-05-22 11:42:27', 'University Ground', 'S08', 1),
(20, 'Ride The Dragon', 'John Premade', 'Novel', 'English', 'brand new', '300', '../images/85d7692a42b5c3a3book-16.jpg', '2023-05-22 11:44:18', 'University ground', 'S08', 1),
(21, 'The Dragon Gate ', 'Randy Ellefson', 'vol.1-3', 'English', 'used', '175', '../images/925257a5598f5ee8book-15.jpeg', '2023-05-22 11:47:27', 'University parking', 'S26', 1),
(22, 'Our Last Summer', 'Claudia Wilson', 'A novel', 'English', 'used', '225', '../images/96fd5ff14b5a94acbook-5.jpg', '2023-05-22 11:49:50', 'university parking', 'S26', 1),
(23, 'Sky Lovers', 'Claudia Alves', 'A novel', 'English', 'used', '150', '../images/f44ca7886e513babbook-8.jpg', '2023-05-22 11:51:40', 'University Rooftop', 'S05', 1),
(24, 'An Unkindness of Ravens', 'Jeanette Battista', 'A novel', 'English', 'used', '190', '../images/d65996b20298fc7ebook-10.jpg', '2023-05-22 11:55:57', 'University Rooftop', 'S05', 1),
(25, 'Here Be Dragons', 'Jane Baker', 'A novel', 'English', 'used', '165', '../images/88e957161e5fae12book-14.jpg', '2023-05-22 11:58:40', 'University ICS lab ', 'S70', 1),
(26, 'অদৃশ্য প্রযুক্তি', 'Dr. Sazzad Hossen', 'Science Fiction', 'Bangla', 'used', '200', '../images/5ae74341b7f12c18600e5e728b28e.jpg', '2023-05-22 12:03:03', 'University faculty lounge', 'S85', 1),
(27, 'King Of Wrath', 'Ana Huang', 'The side of the book is a bit bad but apart from that the inside of the book is brand new and unused.', 'English', 'used', '220', '../images/8fa6b7ead25899ba63d60fd6c0125.jpg', '2023-05-22 12:07:39', 'University Circuit Lab', 'S85', 1);

-- --------------------------------------------------------

--
-- Table structure for table `req_book`
--

CREATE TABLE `req_book` (
  `req_id` int(11) NOT NULL,
  `book_name` varchar(400) NOT NULL,
  `writer_name` varchar(400) NOT NULL,
  `book_detail` varchar(4000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `req_student_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `req_book`
--

INSERT INTO `req_book` (`req_id`, `book_name`, `writer_name`, `book_detail`, `date`, `req_student_id`) VALUES
(8, 'wind of change', 'abir hasan', 'Kalkei laagbe', '2023-05-22 03:44:50', 'S07'),
(9, 'Ride the Dragon', 'John Premade', '', '2023-05-22 12:09:43', 'S78'),
(10, 'Our last summer', 'Claudia Wilson', '', '2023-05-22 12:10:13', 'S78'),
(11, 'Here Be Dragons', 'Jane Baker', '', '2023-05-22 12:11:47', 'S07'),
(12, 'king of wrath', 'Ana Huang', '', '2023-05-22 12:13:04', 'S07');

-- --------------------------------------------------------

--
-- Table structure for table `req_fulfill`
--

CREATE TABLE `req_fulfill` (
  `fulfill_id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL,
  `fill_by_student_id` varchar(15) NOT NULL,
  `fill_date` datetime NOT NULL DEFAULT current_timestamp(),
  `link` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `req_fulfill`
--

INSERT INTO `req_fulfill` (`fulfill_id`, `req_id`, `fill_by_student_id`, `fill_date`, `link`) VALUES
(30, 8, 'S01', '2023-05-22 03:49:12', 'http://localhost/www/userView/bookDetail.php?sell_id=18'),
(31, 10, 'S26', '2023-05-22 12:14:50', 'http://localhost/www/userView/bookDetail.php?sell_id=22');

--
-- Triggers `req_fulfill`
--
DELIMITER $$
CREATE TRIGGER `insert_notifi` AFTER INSERT ON `req_fulfill` FOR EACH ROW insert into req_notifi(req_id, fill_id) values(NEW.req_id, NEW.fulfill_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `req_notifi`
--

CREATE TABLE `req_notifi` (
  `id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL DEFAULT 'Your request has been filled',
  `req_id` int(11) NOT NULL,
  `fill_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `req_notifi`
--

INSERT INTO `req_notifi` (`id`, `text`, `req_id`, `fill_id`, `date`, `status`) VALUES
(4, 'Your request has been filled', 8, 30, '2023-05-22 03:49:12', 1),
(5, 'Your request has been filled', 10, 31, '2023-05-22 12:14:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(15) NOT NULL,
  `s_firstName` varchar(255) NOT NULL,
  `s_lastName` varchar(255) NOT NULL,
  `s_phoneNo` int(16) NOT NULL,
  `s_email` varchar(255) NOT NULL,
  `s_password` varchar(200) NOT NULL,
  `ver_code` varchar(255) NOT NULL,
  `is_verified` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `s_firstName`, `s_lastName`, `s_phoneNo`, `s_email`, `s_password`, `ver_code`, `is_verified`) VALUES
('S01', 'Abir', 'Khan', 12856, '2019-1-60-013@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', '89e31753a6ee5f2c5f10f5bb78c0b07e', 1),
('S05', 'Tanzirul', 'Islam', 741852963, '2019-1-60-090@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', '484c5f899bf9b964bb20d563c4529b90', 1),
('S07', 'Rezwan', 'Rahat', 123456789, '2019-1-60-007@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', 'e17c873ec85c50d066bfaba9a1c49af3', 1),
('S08', 'Ahnaf', 'Sidrat', 741852963, '2019-1-60-008@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', '1d308a0dc41d6e64985ad0dce87f49f7', 1),
('S10', 'Amlan', 'Ahmed', 741852963, '2019-1-60-125@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', 'da423a47659eb84bea69bdd36bb9a64e', 1),
('S25', 'Hasibul Hasem', 'Shanto', 123456789, '2019-1-60-025@std.ewubd.edu', 'c8ffe9a587b126f152ed3d89a146b445', 'dd4f8fc2927dac037f6390956560ef28', 1),
('S26', 'Anik', 'Saha', 369258147, '2019-1-60-040@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', 'f2c0d828171cbad1ef202f7a137d83ee', 1),
('S70', 'Rishu ', 'Raj', 2147483647, '2019-1-60-045@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', 'fef9a568037ab9edfdd2be0f94506ad7', 1),
('S78', 'Sabbir', 'Ahmed', 789456123, '2019-1-60-085@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', '1f230cb0cb03cf3c1210d577e768fe6e', 1),
('S85', 'Adnan ', 'Rahman', 2147483647, '2019-1-60-083@std.ewubd.edu', '202cb962ac59075b964b07152d234b70', '42b6c17abb8e69a6084f6573b87634c8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `sup_id` int(11) NOT NULL,
  `std_id` varchar(15) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `detail` varchar(4000) NOT NULL,
  `link` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booksell`
--
ALTER TABLE `booksell`
  ADD PRIMARY KEY (`sell_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `req_book`
--
ALTER TABLE `req_book`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `req_student_id` (`req_student_id`);

--
-- Indexes for table `req_fulfill`
--
ALTER TABLE `req_fulfill`
  ADD PRIMARY KEY (`fulfill_id`),
  ADD KEY `request_id` (`req_id`),
  ADD KEY `fill_by_student_id` (`fill_by_student_id`);

--
-- Indexes for table `req_notifi`
--
ALTER TABLE `req_notifi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reqID` (`req_id`),
  ADD KEY `fill_id` (`fill_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `s_email` (`s_email`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`sup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booksell`
--
ALTER TABLE `booksell`
  MODIFY `sell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `req_book`
--
ALTER TABLE `req_book`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `req_fulfill`
--
ALTER TABLE `req_fulfill`
  MODIFY `fulfill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `req_notifi`
--
ALTER TABLE `req_notifi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `sup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booksell`
--
ALTER TABLE `booksell`
  ADD CONSTRAINT `student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `req_book`
--
ALTER TABLE `req_book`
  ADD CONSTRAINT `req_student_id` FOREIGN KEY (`req_student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `req_fulfill`
--
ALTER TABLE `req_fulfill`
  ADD CONSTRAINT `fill_by_student_id` FOREIGN KEY (`fill_by_student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `request_id` FOREIGN KEY (`req_id`) REFERENCES `req_book` (`req_id`);

--
-- Constraints for table `req_notifi`
--
ALTER TABLE `req_notifi`
  ADD CONSTRAINT `fill_id` FOREIGN KEY (`fill_id`) REFERENCES `req_fulfill` (`fulfill_id`),
  ADD CONSTRAINT `reqID` FOREIGN KEY (`req_id`) REFERENCES `req_book` (`req_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
