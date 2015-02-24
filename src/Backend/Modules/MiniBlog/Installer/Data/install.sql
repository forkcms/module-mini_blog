CREATE TABLE `mini_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `introduction` text CHARACTER SET utf8,
  `text` text CHARACTER SET utf8,
  `created` datetime DEFAULT NULL,
  `edited` datetime DEFAULT NULL,
  `publish` enum('Y','N') CHARACTER SET utf8 DEFAULT 'Y',
  `user_id` int(11) DEFAULT NULL,
  `language` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `meta_id` int(11) DEFAULT NULL,
  `awesomeness` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
