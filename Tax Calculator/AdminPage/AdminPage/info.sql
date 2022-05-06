-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2021 at 01:05 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `title`, `description`, `image`) VALUES
(26, 'Tax Policy of nepAL', '    The COVID-19 pandemic has created opportunities for a fairer, more robust and more efficient tax revenue and spending system.Governments worldwide have responded to the COV- ID-19 crisis by ramping up public spending and rolling out emergency fiscal response measures in an effort to bolster healthcare systems, strengthen social protection, and boost the economy. By November 2020, more than $25 trillion in financial support was announced by Asian countries to combat the pandemic. At the same time, tax collections are declining everywhere.Even prior to the pandemic, tax revenues in many Asian countries were below the level needed to achieve the Sustainable Development Goals (SDGs).The COVID-19 pandemic has driven these revenues further down, and brought socio-economic hardship on a scale not seen before.This is expected to push tens of millions of people in the region into extreme poverty, sharpen pre-existing inequalities. How can governments finance the response to these challenges?A version of this article appears in the print on March 1, 2021, of The Himalayan Times.', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
