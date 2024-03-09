-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 12:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enterprisepro`
--

-- --------------------------------------------------------

--
-- Table structure for table `allotmentlist2017`
--

CREATE TABLE `allotmentlist2017` (
  `Allotment` varchar(46) NOT NULL,
  `Street` varchar(18) DEFAULT NULL,
  `Locality` varchar(15) DEFAULT NULL,
  `Latitude` varchar(8) DEFAULT NULL,
  `Longitude` varchar(9) DEFAULT NULL,
  `Postcode` varchar(8) DEFAULT NULL,
  `Town` varchar(8) DEFAULT NULL,
  `Total plots` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `allotmentlist2017`
--

INSERT INTO `allotmentlist2017` (`Allotment`, `Street`, `Locality`, `Latitude`, `Longitude`, `Postcode`, `Town`, `Total plots`) VALUES
('Abb Scott Lane Allotments', 'Abb Scott Lane', 'Woodside', '53.75496', '-1.775655', 'BD12 0HA', 'Bradford', '25'),
('Avenue Road Allotments', 'Avenue Road', 'West Bowling', '53.77584', '-1.746116', 'BD5', 'Bradford', '21'),
('Beck Lane Allotments', 'Beck Lane', ' ', '53.85554', '-1.835094', 'BD16', 'Bingley', '43'),
('Bowling Park Allotments', 'Bowling Park Drive', ' ', '53.77922', '-1.744319', 'BD4', 'Bradford', '152'),
('Bullroyd Allotments', 'Bull Royd Lane', 'Four Lane Ends', '53.77922', '-1.744319', 'BD8', 'Bradford', '88'),
('Carlton Avenue Allotments', 'Carlton Avenue', ' ', '53.83707', '-1.795474', 'BD18', 'Shipley', '4'),
('Caroline Street Allotments', 'Caroline Street', 'Saltaire', '53.83758', '-1.789524', 'BD18', 'Shipley', '20'),
('Cecil Avenue Allotments', 'Cecil Avenue', ' ', '53.78356', '-1.776645', 'BD7', 'Bradford', '61'),
('Chapel Lane Allotments (Charitable Trust Land)', 'Chapel Lane', 'Allerton', '53.76894', '-1.846704', 'BD15', 'Bradford', '43'),
('Commercial Inn Allotments', 'Pullan Lane', 'Esholt', '53.85892', '-1.724263', 'BD17', 'Shipley', '11'),
('Common Road Allotments', 'Common Road', 'Low Moor', '53.75477', '-1.768426', 'BD12', 'Bradford', '13'),
('Derby Road Allotments', 'Derby Road', ' ', '53.79453', '-1.711155', 'BD3', 'Bradford', '74'),
('Esholt Lane Allotments', 'Esholt Lane', 'Esholt', '53.85396', '-1.737033', 'BD17', 'Shipley', '10'),
('Greengates Allotments', 'The Drive', 'Greengates', '53.82849', '-1.715706', 'BD10', 'Bradford', '29'),
('Harewood Street Allotments', 'Harewood Street', 'Bradford Moor', '53.79493', '-1.730137', 'BD3', 'Bradford', '46'),
('Haycliffe Lane Allotments', 'Haycliffe Lane', ' ', '53.77408', '-1.779098', 'BD5', 'Bradford', '21'),
('Heaton Allotments', 'Nog Lane', 'Heaton', '53.81682', '-1.787979', 'BD9', 'Bradford', '102'),
('Highfield Terrace Allotments', 'Highfield Terrace', 'Queensbury', '53.74924', '-1.819112', 'BD13', 'Bradford', '19'),
('Legrams Lane Allotments', 'Legrams Lane', ' ', '53.79103', '-1.780875', 'BD7', 'Bradford', '39'),
('Little London Allotments', 'Apperley Lane', 'Apperley Bridge', '53.84195', '-1.703677', 'BD10', 'Bradford', '30'),
('New House Lane Allotments', 'New House Lane', 'Queensbury', '53.76792', '-1.825093', 'BD13', 'Bradford', '22'),
('Northcliffe Allotments', 'Bradford Road', ' ', '53.82736', '-1.780027', 'BD18', 'Shipley', '156'),
('Park Road Allotments', 'Park Road', 'Thackley', '53.84489', '-1.732205', 'BD10', 'Bradford', '29'),
('Queen`s Road B Allotments', 'Queen`s Road', ' ', '53.80958', '-1.755792', 'BD2', 'Bradford', '66'),
('Red Beck Allotments', 'Otley Road', ' ', '53.84298', '-1.762281', 'BD18', 'Shipley', '47'),
('Scotchman Road Allotments', 'Scothman Road', 'Heaton', '53.80989', '-1.785971', 'BD9', 'Bradford', '119'),
('Speeton Avenue Allotments', 'Speeton Avenue', ' ', '53.77326', '-1.804101', 'BD7', 'Bradford', '16'),
('Stanacre Allotments', 'Northallerton Road', ' ', '53.80376', '-1.746384', 'BD3 0JD', 'Bradford', '46'),
('Stanley Street Bingley Allotments', 'Stanley Street', ' ', '53.84930', '-1.829591', 'BD16', 'Bingley', '2'),
('Stanley Street Greengates Allotments', 'Stanley Street', 'Greengates', '53.83072', '-1.713238', 'BD10', 'Bradford', '12'),
('Sunny Bank Road Allotments', 'Sunny Bank Road', ' ', '53.76790', '-1.759193', 'BD5', 'Bradford', '22'),
('Top Royd Street Allotments', 'Royd Street', 'Thornton', '53.79113', '-1.857643', 'BD13 3PR', 'Bradford', '34'),
('Undercliffe Allotments', 'Northcote Road', ' ', '53.80826', '-1.730708', 'BD2 4QH', 'Bradford', '41'),
('Valley Allotments', 'Queen`s Road', ' ', '53.80958', '-1.755792', 'BD2', 'Bradford', '38'),
('Whetley Grove Allotments', 'Whetley Grove', ' ', '53.80220', '-1.781752', 'BD8 9ED', 'Bradford', '15'),
('Worthing Head Road Allotments', 'Fairfield Road', 'Wyke', '53.74036', '-1.763748', 'BD12 9PP', 'Bradford', '30');

-- --------------------------------------------------------

--
-- Table structure for table `csv_20240307_161459`
--

CREATE TABLE `csv_20240307_161459` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `csv_20240307_161927`
--

CREATE TABLE `csv_20240307_161927` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `csv_20240307_162146`
--

CREATE TABLE `csv_20240307_162146` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `csv_20240307_163217`
--

CREATE TABLE `csv_20240307_163217` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `forename` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','General User') NOT NULL DEFAULT 'General User',
  `department` enum('Housing','Education and Skills','Transport and Roads') NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allotmentlist2017`
--
ALTER TABLE `allotmentlist2017`
  ADD PRIMARY KEY (`Allotment`);

--
-- Indexes for table `csv_20240307_161459`
--
ALTER TABLE `csv_20240307_161459`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `csv_20240307_161927`
--
ALTER TABLE `csv_20240307_161927`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `csv_20240307_162146`
--
ALTER TABLE `csv_20240307_162146`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `csv_20240307_163217`
--
ALTER TABLE `csv_20240307_163217`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `csv_20240307_161459`
--
ALTER TABLE `csv_20240307_161459`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `csv_20240307_161927`
--
ALTER TABLE `csv_20240307_161927`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `csv_20240307_162146`
--
ALTER TABLE `csv_20240307_162146`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `csv_20240307_163217`
--
ALTER TABLE `csv_20240307_163217`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
