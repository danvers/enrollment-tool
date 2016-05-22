SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `reg_entries` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `study` varchar(100) NOT NULL,
  `matrikel` int(5) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `reg_entries_to_courses` (
  `entry_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `reg_lists` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `slug` varchar(160) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `matrikel` tinyint(4) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `dozent` varchar(50) NOT NULL,
  `max_limit` int(3) NOT NULL DEFAULT '0',
  `dozent_url` varchar(300) DEFAULT NULL,
  `study` varchar(300) NOT NULL,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `reg_members` (
  `memberID` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `addedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `attempts` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reg_members` ( `username`, `password`, `email`,  `last_login`, `attempts`) VALUES
( 'demo', '$2y$10$uJjZZN7yEf85Eso.A.H2deUiDK1k80TkEIFEJTKcYd/LWi0lvEx46', '', '0000-00-00 00:00:00', 0);

ALTER TABLE `reg_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `reg_entries_to_courses`
  ADD PRIMARY KEY (`entry_id`,`course_id`);

ALTER TABLE `reg_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `safe-title` (`slug`);

ALTER TABLE `reg_members`
  ADD PRIMARY KEY (`memberID`);

ALTER TABLE `reg_members`
  MODIFY `memberID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;