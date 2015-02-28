CREATE TABLE IF NOT EXISTS `vegetable` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `vegetable` (`id`, `name`, `order`) VALUES
(1, 'brocolli', 3),
(2, 'tomato', 13),
(3, 'celery', 1),
(4, 'carrot', 9),
(5, 'beet', 2),
(6, 'spinach', 4),
(7, 'cabbage', 11),
(8, 'cactus', 12),
(9, 'eggplant', 7),
(10, 'squash', 10),
(11, 'kale', 8),
(12, 'bok choy', 5),
(13, 'kai-lan', 6);

ALTER TABLE `vegetable`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `order` (`order`), ADD UNIQUE KEY `order_2` (`order`);

ALTER TABLE `vegetable`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;

CREATE TABLE IF NOT EXISTS `vegetable_fans` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `vegetable_id` int(11) NOT NULL,
  `vegetarian` tinyint(1) NOT NULL DEFAULT '0',
  `vegetable_status` enum('Fresh','Frozen','Canned','Freeze Dried') DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO `vegetable_fans` (`id`, `name`, `occupation`, `vegetable_id`, `vegetarian`, `vegetable_status`, `notes`) VALUES
(1, 'Steve', 'Web Developer', 2, 0, 'Frozen', NULL),
(2, 'Roger', 'Bus Driver', 10, 2, 'Freeze Dried', NULL),
(3, 'Lisa', 'Journalist', 12, 0, 'Canned', NULL),
(4, 'Jerry', 'Welder', 10, 0, 'Freeze Dried', NULL),
(5, 'Peter', 'Business Analyst', 7, 0, 'Fresh', NULL),
(6, 'Eliza', 'Golfer', 7, 1, 'Fresh', NULL),
(7, 'Tony', 'Race Car Driver', 8, 0, 'Canned', NULL),
(8, 'Gabrielle', 'Salesperson', 11, 0, 'Freeze Dried', NULL),
(9, 'Hank', 'Banker', 4, 1, 'Frozen', NULL),
(10, 'James', 'Spy', 12, 0, 'Fresh', NULL);

ALTER TABLE `vegetable_fans`
 ADD PRIMARY KEY (`id`), ADD KEY `vegetable_id` (`vegetable_id`);

ALTER TABLE `vegetable_fans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;

ALTER TABLE `vegetable_fans`
ADD CONSTRAINT `vegetable_fans_ibfk_1` FOREIGN KEY (`vegetable_id`) REFERENCES `vegetable` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;