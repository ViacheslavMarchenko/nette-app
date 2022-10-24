SET SQL_MODE = "STRICT_ALL_TABLES";


CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `option_key` varchar(256) NOT NULL,
  `option_value` varchar(2000) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(512) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `excerpt` varchar(2000) DEFAULT NULL,
  `slug` varchar(256) NOT NULL,
  `type` varchar(80) NOT NULL,
  `feature_image` int(11) NOT NULL DEFAULT 0,
  `activeinactive` tinyint(4) NOT NULL DEFAULT 1,
  `menu_order` int(11) NOT NULL,
  `sitemap` tinyint(4) NOT NULL DEFAULT 1,
  `modifydate` datetime NOT NULL DEFAULT current_timestamp(),
  `createdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(80) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `activeinactive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(80) NOT NULL DEFAULT '',
  `password` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `phone` varchar(30) NOT NULL DEFAULT '',
  `role` int(10) NOT NULL DEFAULT 2,
  `hash` varchar(80) NOT NULL,
  `activeinactive` tinyint(4) NOT NULL DEFAULT 1,
  `modifydate` datetime NOT NULL DEFAULT current_timestamp(),
  `createdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `filename` varchar(256) DEFAULT NULL,
  `filepath` varchar(2000) DEFAULT NULL,
  `mime_type` varchar(40) DEFAULT NULL,
  `filesize` int(10) NOT NULL DEFAULT 0,
  `sort_id` int(10) NOT NULL,
  `user` int(11) NOT NULL DEFAULT 1,
  `modifydate` datetime NOT NULL DEFAULT current_timestamp(),
  `createdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DELIMITER $$
CREATE TRIGGER `modifydate_users` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
SET NEW.modifydate = CURRENT_TIMESTAMP();
END $$


DELIMITER $$
CREATE TRIGGER `modifydate_posts` BEFORE UPDATE ON `pages` FOR EACH ROW BEGIN
SET NEW.modifydate = CURRENT_TIMESTAMP();
END $$


DELIMITER $$
CREATE TRIGGER `modifydate_uploads` BEFORE UPDATE ON `uploads` FOR EACH ROW BEGIN
SET NEW.modifydate = CURRENT_TIMESTAMP();
END $$