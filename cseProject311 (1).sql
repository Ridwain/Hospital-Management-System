-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 27, 2024 at 06:34 PM
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
-- Database: `cseProject311`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `ID` int(11) NOT NULL,
  `Phone_Number` varchar(12) NOT NULL,
  `Password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`ID`, `Phone_Number`, `Password`) VALUES
(1, '01841261325', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `Appointment`
--

CREATE TABLE `Appointment` (
  `ID` int(11) NOT NULL,
  `Patient_id` int(11) NOT NULL,
  `Doctor_id` int(11) NOT NULL,
  `Appointment_date` date NOT NULL,
  `Time_slot` varchar(20) NOT NULL,
  `status` enum('Scheduled','Confirmed','Canceled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Appointment`
--

INSERT INTO `Appointment` (`ID`, `Patient_id`, `Doctor_id`, `Appointment_date`, `Time_slot`, `status`) VALUES
(13, 17, 25, '2024-11-27', '10:00 AM - 01:00 PM', 'Confirmed'),
(14, 17, 26, '2024-11-27', '11:00 AM - 12:30 PM', 'Confirmed'),
(15, 18, 32, '2024-11-28', '10:00 AM - 11:30 PM', 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `Doctor`
--

CREATE TABLE `Doctor` (
  `ID` int(11) NOT NULL,
  `Full_name` varchar(30) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Birth_date` date NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Specialities` varchar(30) NOT NULL,
  `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Doctor`
--

INSERT INTO `Doctor` (`ID`, `Full_name`, `Email`, `Birth_date`, `Gender`, `Address`, `Specialities`, `User_id`) VALUES
(25, '  John Doe', 'john.doe@hospital.com', '1975-03-25', 'Male', '456 Oak Lane, Chittagong', 'Cardiology', 62),
(26, 'Ridwain Islam', 'ridwainislam@gmail.com', '2001-12-02', 'Male', 'Bashundhara ,Dhaka', 'Medicine Specialist', 67),
(32, 'Sarah Connor', 'sarah.connor@gmail.com', '1982-08-14', 'Female', '789 Pine Ave, Sylhet', 'Dermatology And Venerology', 98);

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `ID` int(11) NOT NULL,
  `Full_name` varchar(40) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Birth_date` date NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Blood_Grp` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Patient`
--

INSERT INTO `Patient` (`ID`, `Full_name`, `Email`, `Birth_date`, `Gender`, `Address`, `Blood_Grp`, `user_id`) VALUES
(17, 'Torsa Tasnim', 'torsatasnim34@gmail.com', '2002-11-05', 'Female', 'Bashundhara,Dhaka', 'O+', 97),
(18, 'Aouam Al Yaman', 'yaman123@gmail.com', '2013-08-19', 'Male', 'Bogura,Bangladesh', 'AB+', 99);

-- --------------------------------------------------------

--
-- Table structure for table `Specialities`
--

CREATE TABLE `Specialities` (
  `ID` int(11) NOT NULL,
  `Specialities` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Specialities`
--

INSERT INTO `Specialities` (`ID`, `Specialities`) VALUES
(1, 'Cardiology'),
(2, 'Medicine Specialist'),
(4, 'Dermatology And Venerology'),
(11, 'Neurology'),
(12, 'Orthopedics');

-- --------------------------------------------------------

--
-- Table structure for table `Time_slots`
--

CREATE TABLE `Time_slots` (
  `ID` int(11) NOT NULL,
  `Doctor_id` int(11) NOT NULL,
  `Time_slot` varchar(40) NOT NULL,
  `Max_patient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Time_slots`
--

INSERT INTO `Time_slots` (`ID`, `Doctor_id`, `Time_slot`, `Max_patient`) VALUES
(6, 25, '10:00 AM - 01:00 PM', 2),
(7, 26, '11:00 AM - 12:30 PM', 2),
(9, 32, '10:00 AM - 11:30 PM', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `UserType` enum('Doctor','Patient','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `Phone_Number`, `Password`, `UserType`) VALUES
(62, '01912345678', '$2y$10$MIFcpoDxXldpGFwchIfvy.uQnjRMhbyj6Tzmt5iVJAWwNLJ0UPqO2', 'Doctor'),
(67, '01841261325', '$2y$10$q.V4jKppVsNWuOXLax1zSOss6Nv6ilBXk1hqKjxEYTPiDWKJkz2.K', 'Doctor'),
(97, '01912010046', '$2y$10$0hXDOLZHuTtskjyqVNsj1.AqOnUx/vnBVhHEFMVBTz.OS/j.akDwq', 'Patient'),
(98, '01812345678', '$2y$10$zftPyf/iIzQM7PV/J/c8ZuMKu6J/bWc01sE/fZhVGBH6FtHwNJdaO', 'Doctor'),
(99, '01912010047', '$2y$10$2gPXbgTk71h60mt0OD4xAOYMFH28xJiFY8fte/Neu/gTlsfgRSXn.', 'Patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `doctor_id` (`Doctor_id`),
  ADD KEY `patient_id` (`Patient_id`);

--
-- Indexes for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `doc_foreign_key` (`User_id`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `patient_user_id` (`user_id`);

--
-- Indexes for table `Specialities`
--
ALTER TABLE `Specialities`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Time_slots`
--
ALTER TABLE `Time_slots`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `doc_id_slots` (`Doctor_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Appointment`
--
ALTER TABLE `Appointment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Doctor`
--
ALTER TABLE `Doctor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `Patient`
--
ALTER TABLE `Patient`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Specialities`
--
ALTER TABLE `Specialities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Time_slots`
--
ALTER TABLE `Time_slots`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD CONSTRAINT `doctor_id` FOREIGN KEY (`Doctor_id`) REFERENCES `Doctor` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_id` FOREIGN KEY (`Patient_id`) REFERENCES `Patient` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD CONSTRAINT `doc_foreign_key` FOREIGN KEY (`User_id`) REFERENCES `Users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `patient_user_id` FOREIGN KEY (`user_id`) REFERENCES `Users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `Time_slots`
--
ALTER TABLE `Time_slots`
  ADD CONSTRAINT `doc_id_slots` FOREIGN KEY (`Doctor_id`) REFERENCES `Doctor` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
