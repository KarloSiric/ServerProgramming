-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 25, 2025 at 09:52 PM
-- Server version: 8.0.41
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_horizon`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE `attendee` (
  `attendee_id` smallint UNSIGNED NOT NULL,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`attendee_id`, `first_name`, `last_name`, `email`, `username`, `password`, `role_id`) VALUES
(1, 'Kristina', 'Marasović', 'kristina.marasovic@croatia.rit.edu', 'km', '$2y$10$pdb9ubrwk26x8ldH06VP1uKXyAMm9D2F3O7XY8IkIsNW2g.DdsRs.', 1),
(2, 'Kristina', 'Marasović', 'kxmzgr@rit.edu', 'kmu', '$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS', 2),
(12, 'Admin', 'User', 'admin@example.com', 'admin', '$2y$10$.tqtGw2JgG10XNWRanHC6OiBwnmrbnRiPN49MTQquD/dTRNNXeQHi', 1),
(13, 'John', 'Doe', 'john@example.com', 'john', '$2y$10$.tqtGw2JgG10XNWRanHC6OiBwnmrbnRiPN49MTQquD/dTRNNXeQHi', 2),
(14, 'John', 'Doe', 'john@example.com', 'jdoe', '$2y$10$.tqtGw2JgG10XNWRanHC6OiBwnmrbnRiPN49MTQquD/dTRNNXeQHi', 2),
(15, 'Admin', 'Tester', 'admin2@example.com', 'admintest', '$2y$10$0s7aC7oSRxTZp0uMyvnmYOcN0iI.HaHTcsRZkFznx7CAWQGeFHpiq', 1),
(17, 'Alice', 'Doe', 'alice@example.com', 'alice', '$2y$10$0s7aC7oSRxTZp0uMyvnmYOcN0iI.HaHTcsRZkFznx7CAWQGeFHpiq', 2);

-- --------------------------------------------------------

--
-- Table structure for table `attendee_event`
--

CREATE TABLE `attendee_event` (
  `attendee_id` smallint UNSIGNED NOT NULL,
  `event_id` smallint UNSIGNED NOT NULL,
  `paid` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendee_event`
--

INSERT INTO `attendee_event` (`attendee_id`, `event_id`, `paid`) VALUES
(1, 1, 1),
(1, 2, 0),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` smallint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `allowed_number` int NOT NULL,
  `venue_id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `name`, `start_date`, `end_date`, `allowed_number`, `venue_id`) VALUES
(1, 'Tech Conference 2025', '2025-10-10 09:00:00', '2025-10-12 18:00:00', 200, 1),
(2, 'AI Workshop', '2025-11-05 10:00:00', '2025-11-05 16:00:00', 50, 2),
(3, 'Music Festival', '2025-12-20 14:00:00', '2025-12-20 23:00:00', 500, 3),
(4, 'Cybersecurity Forum', '2026-01-15 09:00:00', '2026-01-15 17:00:00', 150, 4),
(5, 'StartUp Pitch Night', '2026-02-10 18:00:00', '2026-02-10 21:00:00', 120, 6),
(6, 'Developer Meetup 2026', '2026-03-05 10:00:00', '2026-03-05 16:00:00', 200, 5),
(7, 'Global Science Expo', '2026-04-12 09:00:00', '2026-04-14 18:00:00', 1000, 7),
(8, 'Spring Jazz Concert', '2026-05-08 19:30:00', '2026-05-08 23:00:00', 300, 5),
(9, 'Robotics Challenge', '2026-06-20 08:00:00', '2026-06-20 20:00:00', 500, 1),
(10, 'Art & Culture Fest', '2026-07-15 12:00:00', '2026-07-17 22:00:00', 800, 7);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `date` date NOT NULL,
  `capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` smallint UNSIGNED NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`) VALUES
(1, 'admin'),
(2, 'attendee');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','attendee') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'attendee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$qvW85rtK6Yv8JqP9pyHfvefNz3zM4VxlheSV1jQp07O6z7aTeqKhm', 'admin'),
(2, 'john', '$2y$10$eB6r02gF7O4Bf6eSGY8I..MWlME8fXZZIbF7YCCZXeFbZzZ0lOHr2', 'attendee');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `venue_id` smallint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venue_id`, `name`, `capacity`) VALUES
(1, 'Main Hall', 200),
(2, 'Conference Room A', 50),
(3, 'Outdoor Stage', 500),
(4, 'Innovation Hub', 150),
(5, 'Auditorium B', 300),
(6, 'Rooftop Terrace', 120),
(7, 'City Expo Center', 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`attendee_id`),
  ADD KEY `idx_fk_role_id` (`role_id`);

--
-- Indexes for table `attendee_event`
--
ALTER TABLE `attendee_event`
  ADD PRIMARY KEY (`attendee_id`,`event_id`),
  ADD KEY `idx_fk_attendee_id` (`attendee_id`),
  ADD KEY `idx_fk_event_id` (`event_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `unique_name` (`name`),
  ADD KEY `idx_fk_venue_id` (`venue_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `unique_name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`venue_id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `attendee_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `venue_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendee`
--
ALTER TABLE `attendee`
  ADD CONSTRAINT `fk_attendee_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `attendee_event`
--
ALTER TABLE `attendee_event`
  ADD CONSTRAINT `fk_attendee_event_attendee` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`attendee_id`),
  ADD CONSTRAINT `fk_attendee_event_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`venue_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
