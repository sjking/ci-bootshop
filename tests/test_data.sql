DROP TABLE IF EXISTS `foobar_lut`;

CREATE TABLE `foobar_lut` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
 `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
 `status` enum('alive','deceased','missing','') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'alive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `testing`.`foobar_lut` (`name`, `title`, `status`) VALUES ('Jim', 'Operator', 'missing');

INSERT INTO `testing`.`foobar_lut` (`name`, `title`, `status`) VALUES ('Fred', 'Hoser', 'deceased');

INSERT INTO `testing`.`foobar_lut` (`name`, `title`, `status`) VALUES ('Doug', 'Scout', 'alive');

INSERT INTO `testing`.`foobar_lut` (`name`, `title`, `status`) VALUES ('Bob', 'Captain', 'alive');