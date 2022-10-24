INSERT INTO `options` (`option_key`, `option_value`) VALUES
('adminemail', 'admin@nubium-sandbox.test'),
('post_per_page', '12');


INSERT INTO `pages` (`title`, `content`, `excerpt`, `slug`, `type`, `feature_image`, `activeinactive`, `menu_order`, `sitemap`) VALUES
('Hlavní', '', NULL, 'hlavni', 'page', 0, 1, 1, 1),
('Portfolio', '', NULL, 'portfolio', 'page', 0, 1, 4, 1),
('Jak objednat', '', NULL, 'objednat', 'page', 0, 1, 3, 1),
('Info', '', NULL, 'info', 'page', 0, 1, 2, 1),
('Kontakty', '', NULL, 'kontakty', 'page', 0, 1, 5, 1);


INSERT INTO `roles` (`title`, `slug`, `activeinactive`) VALUES
('SuperAdmin', 'superadmin', 1),
('Host', 'guest', 1);


INSERT INTO `users` (`name`, `password`, `email`, `phone`, `role`, `hash`, `activeinactive`) VALUES
('Viacheslav', '$2y$12$sWiHbR8mPYkr9smc7.Srk.gSE7rWWv4K/nNugy6blNWGrwZ01UROy', 'admin@nubium-sandbox.test', '', 1, '', 1),
('Julie', '$2y$12$ufi.xfARal7hkme8Yzk8veyjfRrZHma10xPWDfA92tcGdv8JLQeAy', 'user@nubium-sandbox.test', '', 2, '', 1);


INSERT INTO `favorites` (`post_id`, `author`) VALUES
(1, 2),
(2, 2),
(4, 1);


INSERT INTO `uploads` (`filename`, `filepath`, `mime_type`, `filesize`, `sort_id`, `user`) VALUES
('Praha.jpeg', 'uploads/2022/10', 'image/jpeg', 834877, 1, 1);
