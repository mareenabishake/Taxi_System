-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 08:15 AM
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
-- Database: `citytaxy`
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
(1, 'Dineth', 'dineth@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `tms_bookings`
--

CREATE TABLE `tms_bookings` (
  `b_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `v_id` int(100) NOT NULL,
  `d_id` int(100) NOT NULL,
  `b_date` date NOT NULL,
  `pickup_location` text NOT NULL,
  `return_location` text NOT NULL,
  `distance` decimal(10,0) NOT NULL,
  `hire` decimal(10,0) NOT NULL,
  `b_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_bookings`
--

INSERT INTO `tms_bookings` (`b_id`, `u_id`, `v_id`, `d_id`, `b_date`, `pickup_location`, `return_location`, `distance`, `hire`, `b_status`) VALUES
(1, 72, 19, 1, '2024-09-09', 'Wattala, Sri Lanka', 'Colombo, Sri Lanka', 9, 1782, 'Approved'),
(2, 76, 23, 7, '2024-09-10', 'Wattala, Sri Lanka', 'Kandana, Sri Lanka', 7, 1344, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tms_driver`
--

CREATE TABLE `tms_driver` (
  `d_id` int(100) NOT NULL,
  `d_fname` varchar(100) NOT NULL,
  `d_lname` varchar(100) NOT NULL,
  `d_phone` int(10) NOT NULL,
  `d_license` varchar(10) NOT NULL,
  `d_addr` varchar(100) NOT NULL,
  `d_email` text NOT NULL,
  `d_pwd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_driver`
--

INSERT INTO `tms_driver` (`d_id`, `d_fname`, `d_lname`, `d_phone`, `d_license`, `d_addr`, `d_email`, `d_pwd`) VALUES
(1, 'Minsara', 'Silva', 773428870, 'D326384', 'Wattala', 'minsara@gmail.com', '202cb962ac59075b964b07152d234b70'),
(4, 'Nishantha', 'Ranathunga', 774125963, 'D5379393', 'Nagoda', 'nishantha@gmail.com', '202cb962ac59075b964b07152d234b70'),
(5, 'Thimedha', 'Viraj', 773211294, 'D008465', 'Ja-Ela', 'viraj@gmail.com', '202cb962ac59075b964b07152d234b70'),
(6, 'Garuka', 'Sanketh', 767898767, 'D888885342', 'Galle', 'garuka@gmail.com', '202cb962ac59075b964b07152d234b70'),
(7, 'Isiwara', 'Dilhara', 773439217, 'D994632', 'Kaluthara', 'isiwara@gmail.com', '202cb962ac59075b964b07152d234b70');

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
(3, 'Liam Moore ', 'test number 3', 'Published'),
(4, 'Ranjan Ramanayaka ', 'Good driver.', 'Published');

-- --------------------------------------------------------

--
-- Table structure for table `tms_operator`
--

CREATE TABLE `tms_operator` (
  `o_id` int(100) NOT NULL,
  `o_fname` varchar(100) NOT NULL,
  `o_lname` varchar(100) NOT NULL,
  `o_phone` int(10) NOT NULL,
  `o_nic` varchar(15) NOT NULL,
  `o_addr` varchar(100) NOT NULL,
  `o_email` text NOT NULL,
  `o_pwd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_operator`
--

INSERT INTO `tms_operator` (`o_id`, `o_fname`, `o_lname`, `o_phone`, `o_nic`, `o_addr`, `o_email`, `o_pwd`) VALUES
(1, 'Menisha', 'Silva', 774538789, '200265457594V', 'Matara', 'menisha@gmail.com', '202cb962ac59075b964b07152d234b70'),
(6, 'Janith', 'Kesara', 776567890, '52729839V', 'Colombo', 'janith@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `tms_trip_feedback`
--

CREATE TABLE `tms_trip_feedback` (
  `tf_id` int(10) NOT NULL,
  `b_id` int(100) NOT NULL,
  `tf_feedback_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_trip_feedback`
--

INSERT INTO `tms_trip_feedback` (`tf_id`, `b_id`, `tf_feedback_text`) VALUES
(1, 0, 'It was a good trip'),
(2, 0, 'Good driver'),
(3, 2, 'Excellent driver.');

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
  `u_email` varchar(200) NOT NULL,
  `u_pwd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_user`
--

INSERT INTO `tms_user` (`u_id`, `u_fname`, `u_lname`, `u_phone`, `u_license_or_ID`, `u_addr`, `u_email`, `u_pwd`) VALUES
(57, 'Dunith', 'Wellalage', '0776789098', '3456789999V', 'Colombo', 'dunith@gmail.com', '202cb962ac59075b964b07152d234b70'),
(62, 'Menisha', 'Silva', '0774981233', '2758552734V', 'Kadana', 'menisha@gmail.com', '202cb962ac59075b964b07152d234b70'),
(64, 'Yomal', 'Weerathunga', '0753456783', '55566677788V', 'Colombo', 'yomal@gmail.com', '202cb962ac59075b964b07152d234b70'),
(65, 'Minuka', 'Hansaka', '0767896341', '2008356V', 'Wattala', 'minuka@gmail.com', '202cb962ac59075b964b07152d234b70'),
(66, 'Thimedha', 'Viraj', '0774565432', 'D4373884', 'Homagama', 'viraj@gmail.com', '202cb962ac59075b964b07152d234b70'),
(67, 'Rusiru', 'Dilhara', '0776567789', 'D0006654', 'Negambo', 'rusiru@gmail.com', '202cb962ac59075b964b07152d234b70'),
(68, 'Nihal', 'Ranasinghe', '0771212346', 'D774200', 'Kandana', 'nihal@gmail.com', '202cb962ac59075b964b07152d234b70'),
(69, 'Dinal', 'Induwara', '0775489765', 'D947562', 'Horana', 'dinal@gmail.com', '202cb962ac59075b964b07152d234b70'),
(70, 'Denuwan', 'Chamara', '0768908787', 'D006241', 'Colombo', 'denuwan@gmail.com', '202cb962ac59075b964b07152d234b70'),
(71, 'Binada', 'Mandiw', '0789876569', '20016846V', 'Horana', 'binada@gmail.com', '202cb962ac59075b964b07152d234b70'),
(72, 'Menaka', 'Nuwan', '0776545678', '', 'Wattala', 'menaka@gmail.com', '202cb962ac59075b964b07152d234b70'),
(76, 'Shevon', 'Daniel', '0778989890', '', 'Colombo', 'shevon@gmail.com', '202cb962ac59075b964b07152d234b70'),
(77, 'Tharun', 'Ranjith', '0777410237', '', 'Wattala', 'ranjiththarun57@gmail.com', '202cb962ac59075b964b07152d234b70'),
(79, 'Nimal', 'Randika', '0774123698', '', 'Balangoda', 'nimal@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `tms_vehicle`
--

CREATE TABLE `tms_vehicle` (
  `v_id` int(11) NOT NULL,
  `d_id` int(100) NOT NULL,
  `v_name` varchar(200) NOT NULL,
  `v_reg_no` varchar(200) NOT NULL,
  `v_pass_no` varchar(200) NOT NULL,
  `v_category` varchar(200) NOT NULL,
  `v_cost` int(20) NOT NULL,
  `v_dpic` varchar(200) NOT NULL,
  `v_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_vehicle`
--

INSERT INTO `tms_vehicle` (`v_id`, `d_id`, `v_name`, `v_reg_no`, `v_pass_no`, `v_category`, `v_cost`, `v_dpic`, `v_status`) VALUES
(18, 3, 'BMW 520D', 'KV - 8829', '5', 'Sedan', 150, 'bmw.jpg', 'Available'),
(19, 1, 'BMW 320D', 'CBB - 5543', '5', 'Sedan', 200, 'bmw320d.jpg', 'Busy'),
(20, 4, 'BMW 740Ie', 'CBG - 2455', '5', 'Sedan', 150, 'bmw740le.jpg', 'Available'),
(21, 5, 'Benz C-180', 'CAS - 6828', '5', 'Sedan', 145, 'benzc180.jpg', 'Available'),
(22, 6, 'BMW 520D', 'KX - 5858', '5', 'Sedan', 150, '520d.jpg', 'Available'),
(23, 7, 'Mustang', 'CBK - 1986', '5', 'Sedan', 200, 'mustang.jpg', 'Busy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tms_admin`
--
ALTER TABLE `tms_admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tms_bookings`
--
ALTER TABLE `tms_bookings`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `tms_driver`
--
ALTER TABLE `tms_driver`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tms_operator`
--
ALTER TABLE `tms_operator`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `tms_trip_feedback`
--
ALTER TABLE `tms_trip_feedback`
  ADD PRIMARY KEY (`tf_id`);

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
-- AUTO_INCREMENT for table `tms_bookings`
--
ALTER TABLE `tms_bookings`
  MODIFY `b_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tms_driver`
--
ALTER TABLE `tms_driver`
  MODIFY `d_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tms_operator`
--
ALTER TABLE `tms_operator`
  MODIFY `o_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tms_trip_feedback`
--
ALTER TABLE `tms_trip_feedback`
  MODIFY `tf_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tms_user`
--
ALTER TABLE `tms_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
