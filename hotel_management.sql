-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2020 at 08:31 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `Bill_id` int(11) NOT NULL,
  `Amount` int(11) DEFAULT NULL,
  `Payment_type` varchar(20) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`Bill_id`, `Amount`, `Payment_type`, `cust_id`) VALUES
(164213, 75000, 'Cash', 3),
(261472, 80000, 'Net Banking', 6),
(309808, 50000, 'Cash', 10),
(330458, 15000, 'Card', 4),
(591417, 120000, 'Card', 9),
(598328, 10000, 'Card', 7),
(641069, 70000, 'Net Banking', 2),
(643305, 60000, 'Card', 4),
(807517, 30000, 'Cash', 5),
(918964, 30000, 'Card', 1),
(987147, 50000, 'Net Banking', 8);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_id` int(11) NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_id`, `cust_id`, `room_id`, `branch_id`) VALUES
(14048, 1, 1, 1),
(30903, 4, 13, 4),
(34526, 6, 2, 1),
(48482, 3, 11, 3),
(59026, 10, 14, 4),
(79455, 8, 6, 2),
(79664, 2, 6, 2),
(85712, 7, 17, 5),
(87317, 9, 11, 3),
(87430, 4, 4, 1),
(93467, 5, 17, 5);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(11) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `cust_email` varchar(32) NOT NULL,
  `cust_phone` varchar(10) NOT NULL,
  `passport_no` int(11) NOT NULL,
  `dob` date NOT NULL,
  `country` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `f_name`, `l_name`, `cust_email`, `cust_phone`, `passport_no`, `dob`, `country`) VALUES
(1, 'Cust', 'One', 'cust1@example.com', '9472539316', 28613062, '1976-08-17', 'India'),
(2, 'Cust', 'Two', 'cust2@example.com', '9247133882', 65251961, '1995-09-17', 'Germany'),
(3, 'Cust', 'Three', 'cust3@example.com', '9815855215', 88212946, '1983-06-09', 'France'),
(4, 'Cust', 'Four', 'cust4@example.com', '9195734365', 95803646, '1972-09-12', 'USA'),
(5, 'Cust', 'Five', 'cust5@example.com', '9691651979', 35602713, '1990-09-18', 'England'),
(6, 'Cust', 'Six', 'cust6@example.com', '9539121989', 91038490, '1996-03-02', 'India'),
(7, 'Cust', 'Seven', 'cust7@example.com', '9944060300', 57189991, '1873-03-30', 'Japan'),
(8, 'Cust', 'Eight', 'cust8@example.com', '9585155161', 74358552, '1988-06-15', 'Canada'),
(9, 'Cust', 'Nine', 'cust9@example.com', '9419409140', 63576209, '1987-07-05', 'Mexico'),
(10, 'Cust', 'Ten', 'cust10@example.com', '9256405680', 25649177, '1979-09-19', 'Singapore');

-- --------------------------------------------------------

--
-- Table structure for table `deluxe`
--

CREATE TABLE `deluxe` (
  `wifi` varchar(10) NOT NULL,
  `room_id` int(11) NOT NULL,
  `balcony` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deluxe`
--

INSERT INTO `deluxe` (`wifi`, `room_id`, `balcony`) VALUES
('75006', 2, 1),
('25964', 6, 1),
('74962', 7, 1),
('15606', 10, 1),
('77672', 14, 0),
('94621', 15, 1),
('15328', 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dependents`
--

CREATE TABLE `dependents` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(20) NOT NULL,
  `passport_no` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dependents`
--

INSERT INTO `dependents` (`dep_id`, `dep_name`, `passport_no`, `cust_id`) VALUES
(21, 'Dep One', 76532591, 1),
(22, 'Dep Two', 42907680, 3),
(23, 'Dep Three', 46529314, 5),
(24, 'Dep Four', 2147483647, 7),
(25, 'Dep Five', 67767299, 9);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `l_name` varchar(20) DEFAULT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `emp_email` varchar(32) DEFAULT NULL,
  `emp_phone` varchar(20) DEFAULT NULL,
  `emp_dob` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `l_name`, `f_name`, `emp_email`, `emp_phone`, `emp_dob`, `branch_id`) VALUES
(5, '1', 'Emp', 'emp1@example.com', '9428267803', '1997-10-22', 1),
(6, '2', 'Emp', 'emp2@example.com', '9862398547', '1994-10-22', 2),
(7, '3', 'Emp', 'emp3@example.com', '9707219245', '1993-10-08', 1),
(8, '4', 'Emp', 'emp4@example.com', '9123815830', '1987-03-12', 1),
(9, '5', 'Emp', 'emp5@example.com', '9299213278', '1973-04-18', 2),
(27, '6', 'Emp', 'emp6@example.com', '9426666527', '1983-07-20', 3),
(28, '7', 'Emp', 'emp7@example.com', '9846422072', '1980-10-14', 4),
(29, '8', 'Emp', 'emp8@example.com', '9674400102', '1976-01-13', 5),
(30, '9', 'Emp', 'emp9@example.com', '9420814767', '1984-06-14', 5),
(31, '10', 'Emp', 'emp10@example.com', '9016777844', '1986-11-17', 4);

-- --------------------------------------------------------

--
-- Table structure for table `forr`
--

CREATE TABLE `forr` (
  `Booking_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forr`
--

INSERT INTO `forr` (`Booking_id`, `room_id`, `check_in_date`, `check_out_date`) VALUES
(14048, 1, '2020-11-13', '2020-11-19'),
(79664, 6, '2020-11-11', '2020-11-18'),
(48482, 11, '2020-11-19', '2020-11-24'),
(30903, 13, '2020-11-17', '2020-11-20'),
(93467, 17, '2020-11-24', '2020-11-30'),
(34526, 2, '2020-11-10', '2020-11-18'),
(85712, 17, '2020-11-18', '2020-11-20'),
(79455, 6, '2020-11-25', '2020-11-30'),
(87317, 11, '2020-11-17', '2020-11-25'),
(59026, 14, '2020-11-26', '2020-12-01'),
(87430, 4, '2020-11-18', '2020-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `generates`
--

CREATE TABLE `generates` (
  `Booking_id` int(11) DEFAULT NULL,
  `Bill_id` int(11) DEFAULT NULL,
  `booking_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `generates`
--

INSERT INTO `generates` (`Booking_id`, `Bill_id`, `booking_date`) VALUES
(14048, 918964, '2020-11-06 19:54:24'),
(79664, 641069, '2020-11-06 19:55:32'),
(48482, 164213, '2020-11-06 19:57:40'),
(30903, 330458, '2020-11-06 19:59:14'),
(93467, 807517, '2020-11-06 20:00:48'),
(34526, 261472, '2020-11-06 20:02:06'),
(85712, 598328, '2020-11-06 20:03:53'),
(79455, 987147, '2020-11-06 20:05:42'),
(87317, 591417, '2020-11-06 20:07:16'),
(59026, 309808, '2020-11-06 20:09:06'),
(87430, 643305, '2020-11-06 20:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `branch_phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`branch_id`, `branch_name`, `location`, `branch_phone`) VALUES
(1, 'Mumbai', 'Mumbai', '9321398682'),
(2, 'Bangalore', 'Bangalore', '9595671915'),
(3, 'New Delhi', 'New Delhi', '9835459247'),
(4, 'Guwahati', 'Guwahati', '9244453602'),
(5, 'Kolkata', 'Kolkata', '9917056680');

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_staff`
--

CREATE TABLE `kitchen_staff` (
  `salary` int(11) NOT NULL,
  `expertise` varchar(10) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kitchen_staff`
--

INSERT INTO `kitchen_staff` (`salary`, `expertise`, `emp_id`) VALUES
(785628, 'Chef', 5),
(896113, 'Waiter', 7),
(640570, 'Assistant', 30);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_firstname` varchar(20) NOT NULL,
  `user_lastname` varchar(20) NOT NULL,
  `user_email` varchar(20) NOT NULL,
  `user_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`) VALUES
(1, 'Admin', '1234', 'User', '1', 'user1@example.com', '0_Screen-Shot-2020-09-02-at-190424.jpg'),
(3, 'User', '1234', 'User', '2', 'user2@example.com', 'deathly_hallows_by_ipat7-d4nnl3n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `dept_name` varchar(10) NOT NULL,
  `salary` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`dept_name`, `salary`, `emp_id`) VALUES
('Technical', 764384, 6),
('Accounts', 310918, 8);

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `salary` int(11) NOT NULL,
  `counter_no` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`salary`, `counter_no`, `emp_id`) VALUES
(895109, 1, 9),
(475483, 3, 29);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `room_no` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `branch_id`, `room_no`) VALUES
(1, 1, '1A'),
(2, 1, '2A'),
(3, 1, '1B'),
(4, 1, '3A'),
(5, 2, '1A'),
(6, 2, '2A'),
(7, 2, '2B'),
(8, 2, '3A'),
(9, 3, '1A'),
(10, 3, '2A'),
(11, 3, '3A'),
(12, 3, '3B'),
(13, 4, '1A'),
(14, 4, '2A'),
(15, 4, '2B'),
(16, 4, '3A'),
(17, 5, '1A'),
(18, 5, '1B'),
(19, 5, '2A'),
(20, 5, '3A');

-- --------------------------------------------------------

--
-- Table structure for table `room_service`
--

CREATE TABLE `room_service` (
  `salary` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_service`
--

INSERT INTO `room_service` (`salary`, `floor`, `emp_id`) VALUES
(275148, 2, 27),
(249126, 3, 28),
(592475, 1, 31);

-- --------------------------------------------------------

--
-- Table structure for table `simple`
--

CREATE TABLE `simple` (
  `room_id` int(11) NOT NULL,
  `wifi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `simple`
--

INSERT INTO `simple` (`room_id`, `wifi`) VALUES
(1, '16867'),
(3, '11610'),
(5, '38718'),
(9, '61591'),
(13, '79081'),
(17, '99467'),
(18, '11848');

-- --------------------------------------------------------

--
-- Table structure for table `suite`
--

CREATE TABLE `suite` (
  `wifi` varchar(10) NOT NULL,
  `room_id` int(11) NOT NULL,
  `jacuzzi` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suite`
--

INSERT INTO `suite` (`wifi`, `room_id`, `jacuzzi`) VALUES
('18141', 4, 1),
('32698', 8, 1),
('74325', 11, 1),
('14704', 12, 0),
('79042', 16, 1),
('43685', 20, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`Bill_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`),
  ADD UNIQUE KEY `email_unique` (`cust_email`),
  ADD UNIQUE KEY `custphone_uni` (`cust_phone`),
  ADD UNIQUE KEY `custpass` (`passport_no`);

--
-- Indexes for table `deluxe`
--
ALTER TABLE `deluxe`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `dependents`
--
ALTER TABLE `dependents`
  ADD PRIMARY KEY (`dep_id`),
  ADD UNIQUE KEY `passdep` (`passport_no`),
  ADD UNIQUE KEY `custid` (`cust_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `emp_email` (`emp_email`),
  ADD UNIQUE KEY `emp_phone` (`emp_phone`),
  ADD KEY `branchid` (`branch_id`);

--
-- Indexes for table `forr`
--
ALTER TABLE `forr`
  ADD KEY `Booking_id` (`Booking_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `generates`
--
ALTER TABLE `generates`
  ADD KEY `Booking_id` (`Booking_id`),
  ADD KEY `Bill_id` (`Bill_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`branch_id`),
  ADD UNIQUE KEY `branch_name` (`branch_name`);

--
-- Indexes for table `kitchen_staff`
--
ALTER TABLE `kitchen_staff`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD UNIQUE KEY `empid` (`emp_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `room_service`
--
ALTER TABLE `room_service`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `simple`
--
ALTER TABLE `simple`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `suite`
--
ALTER TABLE `suite`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dependents`
--
ALTER TABLE `dependents`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `hotel` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deluxe`
--
ALTER TABLE `deluxe`
  ADD CONSTRAINT `deluxe_fk` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dependents`
--
ALTER TABLE `dependents`
  ADD CONSTRAINT `custid` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `branchid` FOREIGN KEY (`branch_id`) REFERENCES `hotel` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forr`
--
ALTER TABLE `forr`
  ADD CONSTRAINT `forr_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `booking` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forr_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `generates`
--
ALTER TABLE `generates`
  ADD CONSTRAINT `generates_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `booking` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generates_ibfk_2` FOREIGN KEY (`Bill_id`) REFERENCES `bill` (`Bill_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kitchen_staff`
--
ALTER TABLE `kitchen_staff`
  ADD CONSTRAINT `ksid_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manid_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD CONSTRAINT `empid_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `hotel` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room_service`
--
ALTER TABLE `room_service`
  ADD CONSTRAINT `rsid_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simple`
--
ALTER TABLE `simple`
  ADD CONSTRAINT `simple_fk` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suite`
--
ALTER TABLE `suite`
  ADD CONSTRAINT `suite_fk` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
