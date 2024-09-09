-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 06:10 AM
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
  `u_car_distance` decimal(10,0) NOT NULL,
  `u_car_hire` int(100) NOT NULL,
  `u_car_book_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tms_user`
--

INSERT INTO `tms_user` (`u_id`, `u_fname`, `u_lname`, `u_phone`, `u_license_or_ID`, `u_addr`, `u_category`, `u_email`, `u_pwd`, `u_car_type`, `u_car_regno`, `u_car_driver`, `u_car_driver_contact`, `u_car_bookdate`, `u_car_pickup`, `u_car_drop`, `u_car_distance`, `u_car_hire`, `u_car_book_status`) VALUES
(57, 'Dunith', 'Wellalage', '0776789098', '3456789999V', 'Colombo', 'Operator', 'dunith@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(62, 'Menisha', 'Silva', '0774981233', '2758552734V', 'Kadana', 'Operator', 'menisha@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(64, 'Yomal', 'Weerathunga', '0753456783', '55566677788V', 'Colombo', 'User', 'yomal@gmail.com', '202cb962ac59075b964b07152d234b70', 'Sedan', 'KV - 8829', 'Thimedha Viraj', 774565432, '2024-09-08', 'ESOFT Metro Campus (Head Office), De Fonseka Place, Colombo, Sri Lanka', 'ESOFT Metro College - Wattala, Church Road, Wattala, Sri Lanka', 13, 2011, 'Hire Ended'),
(65, 'Minuka', 'Hansaka', '0767896341', '2008356V', 'Wattala', 'User', 'minuka@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(66, 'Thimedha', 'Viraj', '0774565432', 'D4373884', 'Homagama', 'Driver', 'viraj@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, 'Canceled'),
(67, 'Rusiru', 'Dilhara', '0776567789', 'D0006654', 'Negambo', 'Driver', 'rusiru@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(68, 'Nihal', 'Ranasinghe', '0771212346', 'D774200', 'Kandana', 'Driver', 'nihal@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(69, 'Dinal', 'Induwara', '0775489765', 'D947562', 'Horana', 'Driver', 'dinal@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(70, 'Denuwan', 'Chamara', '0768908787', 'D006241', 'Colombo', 'Driver', 'denuwan@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', 0, '', '', '', 0, 0, ''),
(71, 'Binada', 'Mandiw', '0789876569', '20016846V', 'Horana', 'User', 'binada@gmail.com', '202cb962ac59075b964b07152d234b70', 'Sedan', 'CBA - 3553', 'Denuwan Chamara', 768908787, '2024-09-08', 'Wattala, Sri Lanka', 'Homagama, Sri Lanka', 37, 7369, 'Hire Ended'),
(72, 'Suneth', 'Gayan', '0776545678', '4327829V', 'Pannipitiya', 'User', 'suneth@gmail.com', '202cb962ac59075b964b07152d234b70', 'Sedan', 'KQ - 5707', 'Nihal Ranasinghe', 771212346, '2024-09-09', 'Wattala, Sri Lanka', 'Homagama, Sri Lanka', 37, 5343, 'Paid');

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
(13, 'BMW 520D', 'KV - 8829', '5', 'Thimedha Viraj', 774565432, 'Sedan', 150, 'bmw.jpg', 'Available'),
(14, 'GT-R', 'KO - 2777', '5', 'Rusiru Dilhara', 776567789, 'Sedan', 190, 'gtr.jpg', 'Available'),
(15, 'BMW 320D', 'KQ - 5707', '5', 'Nihal Ranasinghe', 771212346, 'Sedan', 145, 'bmw320d.jpg', 'Busy'),
(16, 'Benz C-200', 'CBJ - 2604', '5', 'Dinal Induwara', 775489765, 'Sedan', 150, 'c200.jpg', 'Available'),
(17, 'BMW 7 Series', 'CBA - 3553', '5', 'Denuwan Chamara', 768908787, 'Sedan', 200, 'bmw740le.jpg', 'Busy');

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
-- AUTO_INCREMENT for table `tms_feedback`
--
ALTER TABLE `tms_feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tms_trip_feedback`
--
ALTER TABLE `tms_trip_feedback`
  MODIFY `tf_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tms_user`
--
ALTER TABLE `tms_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tms_vehicle`
--
ALTER TABLE `tms_vehicle`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
