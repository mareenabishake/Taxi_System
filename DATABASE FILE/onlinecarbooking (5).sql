-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 05:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinecarbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `tms_admin`
--

CREATE TABLE `tms_admin` (
  `a_id` int(100) NOT NULL,
  `a_name` varchar(30) NOT NULL,
  `a_email` varchar(30) NOT NULL,
  `a_pwd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_admin`
--

INSERT INTO `tms_admin` (`a_id`, `a_name`, `a_email`, `a_pwd`) VALUES
(1, 'Dineth', 'dineth@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `tms_feedback`
--

CREATE TABLE `tms_feedback` (
  `f_id` int(11) NOT NULL,
  `f_uname` varchar(200) NOT NULL,
  `f_content` longtext NOT NULL,
  `f_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_feedback`
--

INSERT INTO `tms_feedback` (`f_id`, `f_uname`, `f_content`, `f_status`) VALUES
(1, 'Elliot Gape', 'This is a demo feedback text. This is a demo feedback text. This is a demo feedback text.', 'Published'),
(2, 'Mark L. Anderson', 'Sample Feedback Text for testing! Sample Feedback Text for testing! Sample Feedback Text for testing!', 'Published'),
(3, 'Liam Moore ', 'test number 3', 'Published');

-- --------------------------------------------------------

--
-- Table structure for table `tms_pwd_resets`
--

CREATE TABLE `tms_pwd_resets` (
  `r_id` int(11) NOT NULL,
  `r_email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_pwd_resets`
--

INSERT INTO `tms_pwd_resets` (`r_id`, `r_email`) VALUES
(2, 'admin@gmail.com'),
(3, 'admin@gmail.com'),
(4, 'mareen.abishake@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tms_syslogs`
--

CREATE TABLE `tms_syslogs` (
  `l_id` int(11) NOT NULL,
  `u_id` varchar(200) NOT NULL,
  `u_email` varchar(200) NOT NULL,
  `u_ip` varbinary(200) NOT NULL,
  `u_city` varchar(200) NOT NULL,
  `u_country` varchar(200) NOT NULL,
  `u_logintime` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tms_user`
--

CREATE TABLE `tms_user` (
  `u_id` int(11) NOT NULL,
  `u_fname` varchar(200) NOT NULL,
  `u_lname` varchar(200) NOT NULL,
  `u_phone` varchar(200) NOT NULL,
  `u_license_or_ID` varchar(20) NOT NULL,
  `u_addr` varchar(200) NOT NULL,
  `u_category` varchar(200) NOT NULL,
  `u_email` varchar(200) NOT NULL,
  `u_pwd` varchar(50) NOT NULL,
  `u_car_type` varchar(200) NOT NULL,
  `u_car_regno` varchar(200) NOT NULL,
  `u_car_driver` varchar(20) NOT NULL,
  `u_car_driver_contact` int(10) NOT NULL,
  `u_car_bookdate` varchar(200) NOT NULL,
  `u_car_pickup` text NOT NULL,
  `u_car_drop` text NOT NULL,
  `u_car_hire` int(100) NOT NULL,
  `u_car_book_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_user`
--

INSERT INTO `tms_user` (`u_id`, `u_fname`, `u_lname`, `u_phone`, `u_license_or_ID`, `u_addr`, `u_category`, `u_email`, `u_pwd`, `u_car_type`, `u_car_regno`, `u_car_driver`, `u_car_driver_contact`, `u_car_bookdate`, `u_car_pickup`, `u_car_drop`, `u_car_hire`, `u_car_book_status`) VALUES
(15, 'Binath', 'Hettiarachchi', '0776354097', '', 'Wattala', 'User', 'binath@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(18, 'Binada', 'Mandiw', '0764567431', '278946532V', 'Colombo', 'User', 'binada@gmail.com', '123', 'Sedan', 'CBD - 8953', 'Nihil Hesara', 763452341, '2024-08-22', 'Homagama', 'Kottawa', 300, 'Approved'),
(19, 'Senaka', 'Batagoda', '0776354097', '', 'Wattala', 'User', 'senaka@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(22, 'Thenuka', 'Silva', '0776520098', '', 'Wattala', 'User', 'thenuka@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(24, 'Isuru', 'Dilhara', '0776520098', '', 'Balangoda', 'Driver', 'isuru@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(27, 'Koshal', 'Bandara', '0776354097', '', 'Colombo', 'Operator', 'koshal@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(31, 'Menisha', 'Silva', '0776520098', '', 'Wattala', 'Operator', 'menisha@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(32, 'Chanuka', 'Nisal', '0776354097', '', 'Wattala', 'User', 'chanuka@gmail.com', '123', 'Sedan', 'CAS - 6828', '', 0, '2024-08-15', 'Kandy', 'Kottawa', 10000, 'Approved'),
(33, 'Thimedha', 'Viraj', '0776354097', '2354678D', 'Colombo', 'Driver', 'viraj@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(34, 'Jude', 'Silva', '0776354097', '34567890D', 'Balangoda', 'Driver', 'jude@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(36, 'Harith', 'Harshana', '0776354097', '200837465V', 'Colombo', 'User', 'harith@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(38, 'Rusiru', 'Dilhara', '0773437650', '5467835D', 'Homagama', 'Driver', 'rusiru@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(39, 'Dineth', 'Bandara', '0770691800', '299064324V', 'Homagama', 'User', 'dineth@gmail.com', '123', 'Sedan', 'CBD - 5856', 'Janul Akash', 773456783, '2024-08-22', 'Kandy', 'Ella', 20000, 'Pending'),
(40, 'Janul', 'Akash', '0773456783', '645789342D', 'Nrammala', 'Driver', 'janul@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(41, 'Nihil', 'Hesara', '0763452341', '5467895D', 'Negambo', 'Driver', 'nihil@gmail.com', '123', '', '', '', 0, '', '', '', 0, ''),
(42, 'Nihal', 'Weerathunga', '0776354342', '3456784321D', 'Bandarawela', 'Driver', 'nihal@gmail.com', '123', '', '', '', 0, '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tms_vehicle`
--

CREATE TABLE `tms_vehicle` (
  `v_id` int(11) NOT NULL,
  `v_name` varchar(200) NOT NULL,
  `v_reg_no` varchar(200) NOT NULL,
  `v_pass_no` varchar(200) NOT NULL,
  `v_driver` varchar(200) NOT NULL,
  `v_driver_contact` int(10) NOT NULL,
  `v_category` varchar(200) NOT NULL,
  `v_cost` int(20) NOT NULL,
  `v_dpic` varchar(200) NOT NULL,
  `v_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_vehicle`
--

INSERT INTO `tms_vehicle` (`v_id`, `v_name`, `v_reg_no`, `v_pass_no`, `v_driver`, `v_driver_contact`, `v_category`, `v_cost`, `v_dpic`, `v_status`) VALUES
(5, 'BMW - 320D', 'KQ - 5707', '5', 'Nihal Weerathunga', 776354342, 'Sedan', 130, 'bmw320d.jpg', 'Available'),
(6, 'Audi A5', 'CBD - 5856', '5', 'Janul Akash', 773456783, 'Sedan', 170, 'audi.jpg', 'Available'),
(7, 'BMW 520D', 'CBD - 8953', '5', 'Nihil Hesara', 763452341, 'Sedan', 150, 'bmw520d.jpg', 'Busy'),
(10, 'BMW 520D', 'KV - 8829', '5', 'Thimedha Viraj', 776354097, 'Sedan', 160, 'bmw.jpg', 'Available'),
(11, 'BMW 740Ie', 'CBA - 3553', '5', 'Rusiru Dilhara', 773437650, 'Sedan', 200, 'bmw740le.jpg', 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tms_admin`
--
ALTER TABLE `tms_admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tms_pwd_resets`
--
ALTER TABLE `tms_pwd_resets`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `tms_syslogs`
--
ALTER TABLE `tms_syslogs`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `tms_user`
--
ALTER TABLE `tms_user`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  ADD PRIMARY KEY (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tms_pwd_resets`
--
ALTER TABLE `tms_pwd_resets`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tms_syslogs`
--
ALTER TABLE `tms_syslogs`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tms_user`
--
ALTER TABLE `tms_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
