-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 07:57 AM
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
(1, 'Dineth', 'dineth@gmail.com', '123');

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
(3, 'Nisanka', 'Alwis', 2147483647, 'D849422', 'Kandy', 'nisanka@gmail.com', '202cb962ac59075b964b07152d234b70');

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
(2, 'Menisha', 'Silva', 774538789, '200265457594V', 'Matara', 'menisha@gmail.com', '202cb962ac59075b964b07152d234b70'),
(3, 'Janith', 'Kesara', 776567890, '52729839V', 'Colombo', 'janith@gmail.com', '202cb962ac59075b964b07152d234b70'),
(4, 'wfrfrvev', 'rvevrvre', 0, 'vervre', 'vrevev', 'dewfewc@gmail.com', '202cb962ac59075b964b07152d234b70'),
(5, 'wfrfrvev', 'rvevrvre', 0, 'vervre', 'vrevev', 'dewfewc@gmail.com', '202cb962ac59075b964b07152d234b70'),
(6, 'Janith', 'Kesara', 776567890, '52729839V', 'Colombo', 'janith@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `tms_trip_feedback`
--

CREATE TABLE `tms_trip_feedback` (
  `tf_id` int(10) NOT NULL,
  `tf_cname` varchar(100) NOT NULL,
  `tf_dname` varchar(100) NOT NULL,
  `tf_vname` varchar(50) NOT NULL,
  `tf_date` date NOT NULL,
  `tf_from` varchar(100) NOT NULL,
  `tf_to` varchar(100) NOT NULL,
  `tf_feedback_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tms_trip_feedback`
--

INSERT INTO `tms_trip_feedback` (`tf_id`, `tf_cname`, `tf_dname`, `tf_vname`, `tf_date`, `tf_from`, `tf_to`, `tf_feedback_text`) VALUES
(1, 'Yomal Weerathunga', 'Thiwanka Werahara', 'Sedan', '2024-09-07', 'Wattala', 'Kandana', 'It was a good trip'),
(2, 'Binada Mandiw', 'Denuwan Chamara', 'Sedan', '2024-09-08', 'Wattala, Sri Lanka', 'Homagama, Sri Lanka', 'Good driver');

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
(72, 'Menaka', 'Nuwan', '0776545678', '', 'Wattala', 'menaka@gmail.com', '202cb962ac59075b964b07152d234b70');

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
(13, 0, 'BMW 520D', 'KV - 8829', '5', 'Sedan', 150, 'bmw.jpg', 'Available'),
(14, 0, 'GT-R', 'KO - 2777', '5', 'Sedan', 190, 'gtr.jpg', 'Available'),
(15, 0, 'BMW 320D', 'KQ - 5707', '5', 'Sedan', 145, 'bmw320d.jpg', 'Available'),
(16, 0, 'Benz C-200', 'CBJ - 2604', '5', 'Sedan', 150, 'c200.jpg', 'Available'),
(17, 0, 'BMW 7 Series', 'CBA - 3553', '5', 'Sedan', 200, 'bmw740le.jpg', 'Busy');

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
  MODIFY `b_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tms_driver`
--
ALTER TABLE `tms_driver`
  MODIFY `d_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tms_operator`
--
ALTER TABLE `tms_operator`
  MODIFY `o_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tms_trip_feedback`
--
ALTER TABLE `tms_trip_feedback`
  MODIFY `tf_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tms_user`
--
ALTER TABLE `tms_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
