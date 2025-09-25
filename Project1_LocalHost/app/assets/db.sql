--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `role` WRITE;
INSERT INTO `role` VALUES (1,'admin'),(2,'attendee');
UNLOCK TABLES;


--
-- Table structure for table `attendee`
--

DROP TABLE IF EXISTS `attendee`;

CREATE TABLE `attendee` (
  `attendee_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role_id` smallint unsigned NOT NULL,
  PRIMARY KEY (`attendee_id`),
  KEY `idx_fk_role_id` (`role_id`),
  CONSTRAINT `fk_attendee_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


LOCK TABLES `attendee` WRITE;
INSERT INTO `attendee` VALUES (1,'Kristina','Marasović','kristina.marasovic@croatia.rit.edu','km','$2y$10$pdb9ubrwk26x8ldH06VP1uKXyAMm9D2F3O7XY8IkIsNW2g.DdsRs.',1),(2,'Kristina','Marasović','kxmzgr@rit.edu','kmu','$2y$10$/TGAngySy2s117SvEBhQzuw5V2bVroaNbwuzgquvZ2MuhoWaD8HyS',2);
UNLOCK TABLES;


--
-- Table structure for table `venue`
--

DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `venue_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `capacity` int DEFAULT NULL,
  PRIMARY KEY (`venue_id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `allowed_number` int NOT NULL,
  `venue_id` smallint unsigned NOT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `idx_fk_venue_id` (`venue_id`),
  CONSTRAINT `fk_event_venue` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `attendee_event`
--

DROP TABLE IF EXISTS `attendee_event`;
CREATE TABLE `attendee_event` (
  `attendee_id` smallint unsigned NOT NULL,
  `event_id` smallint unsigned NOT NULL,
  `paid` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`attendee_id`,`event_id`),
  KEY `idx_fk_attendee_id` (`attendee_id`),
  KEY `idx_fk_event_id` (`event_id`),
  CONSTRAINT `fk_attendee_event_attendee` FOREIGN KEY (`attendee_id`) REFERENCES `attendee` (`attendee_id`),
  CONSTRAINT `fk_attendee_event_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- First, clear existing data to avoid duplicates
DELETE FROM attendee_event;
DELETE FROM event;
DELETE FROM venue;

-- Now add fresh venues with unique names
INSERT INTO venue (name, capacity) VALUES 
('Main Conference Hall', 100),
('Workshop Room A', 50),
('Large Auditorium', 200);

-- Add events
INSERT INTO event (name, start_date, end_date, allowed_number, venue_id) VALUES
('Tech Summit 2024', '2024-12-01 09:00:00', '2024-12-01 17:00:00', 100, 1),
('Web Dev Workshop', '2024-12-05 10:00:00', '2024-12-05 15:00:00', 50, 2),
('AI Conference', '2024-12-10 09:00:00', '2024-12-10 18:00:00', 200, 3);

-- Add registrations (using existing attendee IDs 1 and 2)
INSERT INTO attendee_event (attendee_id, event_id, paid) VALUES
(1, 1, 1),
(2, 1, 1),
(1, 2, 1),
(2, 2, 0),
(1, 3, 1);


