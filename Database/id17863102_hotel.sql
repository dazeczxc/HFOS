-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2022 at 02:46 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id17863102_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `accommodationid` int(255) NOT NULL,
  `accommodationtype` varchar(255) DEFAULT NULL,
  `accommodationdescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `AmenID` int(11) NOT NULL,
  `AmenName` varchar(255) DEFAULT NULL,
  `AmenQuantity` varchar(99) DEFAULT NULL,
  `AmenRates` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`AmenID`, `AmenName`, `AmenQuantity`, `AmenRates`) VALUES
(3, 'Parking ', 'Day', 200),
(8, 'laundry', 'Service', 100);

-- --------------------------------------------------------

--
-- Table structure for table `amen_transaction`
--

CREATE TABLE `amen_transaction` (
  `id` int(11) NOT NULL,
  `TransactionCode` varchar(255) NOT NULL,
  `AmenID` int(11) NOT NULL,
  `AmenName` varchar(255) NOT NULL,
  `AmenQuantity` int(11) NOT NULL,
  `AmenRates` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `GuestID` int(255) NOT NULL,
  `GuestNumber` varchar(99) DEFAULT NULL,
  `GuestNumber2` varchar(99) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Nationality` varchar(255) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `PNumber` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Company` varchar(255) DEFAULT NULL,
  `CompanyAddress` varchar(255) DEFAULT NULL,
  `Origin` varchar(255) DEFAULT NULL,
  `Passport` varchar(255) DEFAULT NULL,
  `IssuedAt` varchar(255) DEFAULT NULL,
  `Discount` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TransactionCode` varchar(255) DEFAULT NULL,
  `wID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `RateID` int(99) NOT NULL,
  `RoomID` int(99) NOT NULL,
  `TransactionCode` varchar(250) NOT NULL,
  `Star` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recent_guest`
--

CREATE TABLE `recent_guest` (
  `GuestID` int(255) NOT NULL,
  `GuestNumber` varchar(99) DEFAULT NULL,
  `GuestNumber2` varchar(99) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Nationality` varchar(255) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `PNumber` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Company` varchar(255) DEFAULT NULL,
  `CompanyAddress` varchar(255) DEFAULT NULL,
  `Origin` varchar(255) DEFAULT NULL,
  `Passport` varchar(255) DEFAULT NULL,
  `IssuedAt` varchar(255) DEFAULT NULL,
  `Discount` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `TransactionCode` varchar(255) DEFAULT NULL,
  `wID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recent_transaction`
--

CREATE TABLE `recent_transaction` (
  `TransactionID` int(11) NOT NULL,
  `TransactionDate` date DEFAULT NULL,
  `TransactionTime` time DEFAULT NULL,
  `TransactionCode` varchar(255) DEFAULT NULL,
  `TransactBy` varchar(255) DEFAULT NULL,
  `GuestID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `Accommodationtype` varchar(255) DEFAULT NULL,
  `Arrival` date DEFAULT NULL,
  `Departure` date DEFAULT NULL,
  `TotalRates` double DEFAULT NULL,
  `Downpayment` varchar(999) DEFAULT NULL,
  `Requests` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `TransactionID` int(11) NOT NULL,
  `TransactionDate` date DEFAULT NULL,
  `TransactionTime` varchar(255) DEFAULT NULL,
  `TransactionCode` varchar(255) DEFAULT NULL,
  `TransactBy` varchar(255) DEFAULT NULL,
  `GuestID` int(255) DEFAULT NULL,
  `RoomID` int(255) DEFAULT NULL,
  `Accommodationtype` varchar(255) DEFAULT NULL,
  `Arrival` date DEFAULT NULL,
  `Departure` date DEFAULT NULL,
  `TotalRates` double DEFAULT NULL,
  `Downpayment` varchar(999) DEFAULT NULL,
  `ReservationStatus` varchar(255) DEFAULT NULL,
  `Requests` text DEFAULT NULL,
  `Reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `RoomID` int(11) NOT NULL,
  `RoomNumber` varchar(255) DEFAULT NULL,
  `RoomName` text DEFAULT NULL,
  `RoomDescription` varchar(255) DEFAULT NULL,
  `RoomType` varchar(255) DEFAULT NULL,
  `RoomImage` varchar(255) DEFAULT NULL,
  `RoomStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNumber`, `RoomName`, `RoomDescription`, `RoomType`, `RoomImage`, `RoomStatus`) VALUES
(1, '101', NULL, NULL, '1', 'IMG_20210913_095137.jpg', 'Vacant'),
(2, '102', NULL, NULL, '1', 'IMG_20210913_095137.jpg', 'Vacant'),
(3, '103', NULL, NULL, '2', 'IMG_20210913_095107.jpg', 'Vacant'),
(4, '104', NULL, NULL, '2', 'IMG_20210913_095122.jpg', 'Vacant'),
(5, '105', NULL, NULL, '3', 'IMG_20210913_094158.jpg', 'Vacant'),
(7, '107', NULL, NULL, '5', 'IMG_20210913_095015.jpg', 'Vacant');

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `roomtypeid` int(255) NOT NULL,
  `roomtype` varchar(255) DEFAULT NULL,
  `roomtypedescription` varchar(255) NOT NULL,
  `roomprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`roomtypeid`, `roomtype`, `roomtypedescription`, `roomprice`) VALUES
(1, 'Standard Room', '1 Bed, Airconditioned', 5000),
(2, 'Double Room', '2 Beds', 500),
(3, 'Deluxe Room', '1 TV, Private Room', 1000),
(5, 'Presidential', '1 person\r\n5 Aircon', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactionID` int(255) NOT NULL,
  `TransactionDate` date DEFAULT NULL,
  `TransactionTime` varchar(255) DEFAULT NULL,
  `TransactionCode` varchar(255) DEFAULT NULL,
  `TransactBy` varchar(255) DEFAULT NULL,
  `GuestID` int(255) DEFAULT NULL,
  `RoomID` int(255) DEFAULT NULL,
  `Accommodationtype` varchar(255) DEFAULT NULL,
  `Arrival` date DEFAULT NULL,
  `Departure` date DEFAULT NULL,
  `TotalRates` double DEFAULT NULL,
  `Downpayment` varchar(999) DEFAULT NULL,
  `Requests` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `staffname` varchar(255) DEFAULT NULL,
  `pnumber` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `access` varchar(255) DEFAULT NULL,
  `pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `staffname`, `pnumber`, `username`, `password`, `access`, `pic`) VALUES
(40, 'Admin', '09613333544', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'images (75).jpeg'),
(58, 'Front Office Staff', '0969999', 'staff', '1253208465b1efa876f982d8a9e73eef', 'Staff', 'images (78).jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `web_user`
--

CREATE TABLE `web_user` (
  `wID` int(11) NOT NULL,
  `wName` varchar(255) DEFAULT NULL,
  `wPNumber` varchar(255) DEFAULT NULL,
  `wEmail` varchar(255) DEFAULT NULL,
  `wUName` varchar(255) DEFAULT NULL,
  `wPWord` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `web_user`
--

INSERT INTO `web_user` (`wID`, `wName`, `wPNumber`, `wEmail`, `wUName`, `wPWord`) VALUES
(4, 'xxx', '1995959', 'dasecojoshua@gmail.com', 'xxx', 'f561aaf6ef0bf14d4208bb46a4ccb3ad'),
(5, 'aaa', '1212', 'aaa@gmail.com', 'aaa', '47bce5c74f589f4867dbd57e9ca9f808'),
(6, 'zz', '2121', 'a@A', 'zz', '25ed1bcb423b0b7200f485fc5ff71c8e'),
(7, 'Joshua Daseco', '09613730689', 'daseco@gmail.com', 'joshua', 'd1133275ee2118be63a577af759fc052');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`accommodationid`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`AmenID`);

--
-- Indexes for table `amen_transaction`
--
ALTER TABLE `amen_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`GuestID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`RateID`);

--
-- Indexes for table `recent_guest`
--
ALTER TABLE `recent_guest`
  ADD PRIMARY KEY (`GuestID`);

--
-- Indexes for table `recent_transaction`
--
ALTER TABLE `recent_transaction`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`roomtypeid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_user`
--
ALTER TABLE `web_user`
  ADD PRIMARY KEY (`wID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `accommodationid` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `AmenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `amen_transaction`
--
ALTER TABLE `amen_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `GuestID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `RateID` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recent_guest`
--
ALTER TABLE `recent_guest`
  MODIFY `GuestID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roomtype`
--
ALTER TABLE `roomtype`
  MODIFY `roomtypeid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `web_user`
--
ALTER TABLE `web_user`
  MODIFY `wID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
