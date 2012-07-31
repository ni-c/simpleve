SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `se_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=128 ;

INSERT INTO `se_acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 254),
(2, 1, NULL, NULL, 'Pages', 2, 17),
(3, 2, NULL, NULL, 'display', 3, 4),
(4, 2, NULL, NULL, 'checkAuth', 5, 6),
(5, 2, NULL, NULL, 'add', 7, 8),
(6, 2, NULL, NULL, 'edit', 9, 10),
(7, 2, NULL, NULL, 'index', 11, 12),
(8, 2, NULL, NULL, 'view', 13, 14),
(9, 2, NULL, NULL, 'delete', 15, 16),
(10, 1, NULL, NULL, 'Administrations', 18, 37),
(11, 10, NULL, NULL, 'index', 19, 20),
(12, 10, NULL, NULL, 'save_api', 21, 22),
(13, 10, NULL, NULL, 'setGeneralOption', 23, 24),
(14, 10, NULL, NULL, 'updateSubscriptions', 25, 26),
(15, 10, NULL, NULL, 'checkAuth', 27, 28),
(16, 10, NULL, NULL, 'add', 29, 30),
(17, 10, NULL, NULL, 'edit', 31, 32),
(18, 10, NULL, NULL, 'view', 33, 34),
(19, 10, NULL, NULL, 'delete', 35, 36),
(20, 1, NULL, NULL, 'Apis', 38, 53),
(21, 20, NULL, NULL, 'cacheSingle', 39, 40),
(22, 20, NULL, NULL, 'checkAuth', 41, 42),
(23, 20, NULL, NULL, 'add', 43, 44),
(24, 20, NULL, NULL, 'edit', 45, 46),
(25, 20, NULL, NULL, 'index', 47, 48),
(26, 20, NULL, NULL, 'view', 49, 50),
(27, 20, NULL, NULL, 'delete', 51, 52),
(28, 1, NULL, NULL, 'CustomValues', 54, 69),
(29, 28, NULL, NULL, 'getAllowedValueTypes', 55, 56),
(30, 28, NULL, NULL, 'edit', 57, 58),
(31, 28, NULL, NULL, 'checkAuth', 59, 60),
(32, 28, NULL, NULL, 'add', 61, 62),
(33, 28, NULL, NULL, 'index', 63, 64),
(34, 28, NULL, NULL, 'view', 65, 66),
(35, 28, NULL, NULL, 'delete', 67, 68),
(36, 1, NULL, NULL, 'Dashboard', 70, 83),
(37, 36, NULL, NULL, 'index', 71, 72),
(38, 36, NULL, NULL, 'checkAuth', 73, 74),
(39, 36, NULL, NULL, 'add', 75, 76),
(40, 36, NULL, NULL, 'edit', 77, 78),
(41, 36, NULL, NULL, 'view', 79, 80),
(42, 36, NULL, NULL, 'delete', 81, 82),
(43, 1, NULL, NULL, 'Database', 84, 105),
(44, 43, NULL, NULL, 'invtype', 85, 86),
(45, 43, NULL, NULL, 'mapsolarsystem', 87, 88),
(46, 43, NULL, NULL, 'mapregion', 89, 90),
(47, 43, NULL, NULL, 'stastation', 91, 92),
(48, 43, NULL, NULL, 'checkAuth', 93, 94),
(49, 43, NULL, NULL, 'add', 95, 96),
(50, 43, NULL, NULL, 'edit', 97, 98),
(51, 43, NULL, NULL, 'index', 99, 100),
(52, 43, NULL, NULL, 'view', 101, 102),
(53, 43, NULL, NULL, 'delete', 103, 104),
(54, 1, NULL, NULL, 'Eveapi', 106, 127),
(55, 54, NULL, NULL, 'update', 107, 108),
(56, 54, NULL, NULL, 'lastsovereigntychanges', 109, 110),
(57, 54, NULL, NULL, 'get', 111, 112),
(58, 54, NULL, NULL, 'getCharacterName', 113, 114),
(59, 54, NULL, NULL, 'checkAuth', 115, 116),
(60, 54, NULL, NULL, 'add', 117, 118),
(61, 54, NULL, NULL, 'edit', 119, 120),
(62, 54, NULL, NULL, 'index', 121, 122),
(63, 54, NULL, NULL, 'view', 123, 124),
(64, 54, NULL, NULL, 'delete', 125, 126),
(65, 1, NULL, NULL, 'Evemap', 128, 143),
(66, 65, NULL, NULL, 'getSolarSystems', 129, 130),
(67, 65, NULL, NULL, 'checkAuth', 131, 132),
(68, 65, NULL, NULL, 'add', 133, 134),
(69, 65, NULL, NULL, 'edit', 135, 136),
(70, 65, NULL, NULL, 'index', 137, 138),
(71, 65, NULL, NULL, 'view', 139, 140),
(72, 65, NULL, NULL, 'delete', 141, 142),
(73, 1, NULL, NULL, 'Industries', 144, 161),
(74, 73, NULL, NULL, 'item_view', 145, 146),
(75, 73, NULL, NULL, 'item_search', 147, 148),
(76, 73, NULL, NULL, 'index', 149, 150),
(77, 73, NULL, NULL, 'checkAuth', 151, 152),
(78, 73, NULL, NULL, 'add', 153, 154),
(79, 73, NULL, NULL, 'edit', 155, 156),
(80, 73, NULL, NULL, 'view', 157, 158),
(81, 73, NULL, NULL, 'delete', 159, 160),
(82, 1, NULL, NULL, 'MineralIndexTypes', 162, 179),
(83, 82, NULL, NULL, 'getAll', 163, 164),
(84, 82, NULL, NULL, 'update', 165, 166),
(85, 82, NULL, NULL, 'checkAuth', 167, 168),
(86, 82, NULL, NULL, 'add', 169, 170),
(87, 82, NULL, NULL, 'edit', 171, 172),
(88, 82, NULL, NULL, 'index', 173, 174),
(89, 82, NULL, NULL, 'view', 175, 176),
(90, 82, NULL, NULL, 'delete', 177, 178),
(91, 1, NULL, NULL, 'Options', 180, 193),
(92, 91, NULL, NULL, 'edit', 181, 182),
(93, 91, NULL, NULL, 'checkAuth', 183, 184),
(94, 91, NULL, NULL, 'add', 185, 186),
(95, 91, NULL, NULL, 'index', 187, 188),
(96, 91, NULL, NULL, 'view', 189, 190),
(97, 91, NULL, NULL, 'delete', 191, 192),
(98, 1, NULL, NULL, 'Prices', 194, 209),
(99, 98, NULL, NULL, 'single', 195, 196),
(100, 98, NULL, NULL, 'checkAuth', 197, 198),
(101, 98, NULL, NULL, 'add', 199, 200),
(102, 98, NULL, NULL, 'edit', 201, 202),
(103, 98, NULL, NULL, 'index', 203, 204),
(104, 98, NULL, NULL, 'view', 205, 206),
(105, 98, NULL, NULL, 'delete', 207, 208),
(106, 1, NULL, NULL, 'Tickets', 210, 225),
(107, 106, NULL, NULL, 'approve', 211, 212),
(108, 106, NULL, NULL, 'checkAuth', 213, 214),
(109, 106, NULL, NULL, 'add', 215, 216),
(110, 106, NULL, NULL, 'edit', 217, 218),
(111, 106, NULL, NULL, 'index', 219, 220),
(112, 106, NULL, NULL, 'view', 221, 222),
(113, 106, NULL, NULL, 'delete', 223, 224),
(114, 1, NULL, NULL, 'Users', 226, 253),
(115, 114, NULL, NULL, 'index', 227, 228),
(116, 114, NULL, NULL, 'add', 229, 230),
(117, 114, NULL, NULL, 'login', 231, 232),
(118, 114, NULL, NULL, 'logout', 233, 234),
(119, 114, NULL, NULL, 'delete', 235, 236),
(120, 114, NULL, NULL, 'retrieve', 237, 238),
(121, 114, NULL, NULL, 'edit', 239, 240),
(122, 114, NULL, NULL, 'switchcharacter', 241, 242),
(123, 114, NULL, NULL, 'remove_api', 243, 244),
(124, 114, NULL, NULL, 'add_api', 245, 246),
(125, 114, NULL, NULL, 'build_acl', 247, 248),
(126, 114, NULL, NULL, 'checkAuth', 249, 250),
(127, 114, NULL, NULL, 'view', 251, 252);

CREATE TABLE IF NOT EXISTS `se_alecache` (
  `host` varchar(64) NOT NULL,
  `path` varchar(64) NOT NULL,
  `params` varchar(64) NOT NULL,
  `content` longtext NOT NULL,
  `cachedUntil` datetime DEFAULT NULL,
  PRIMARY KEY (`host`,`path`,`params`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `se_apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `api_user_id` int(11) NOT NULL,
  `api_key` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `errorcode` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_user_id` (`api_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `se_aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

INSERT INTO `se_aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 1, 'Users', 1, 30),
(2, 1, 'Group', 2, 'Trials', 2, 29),
(3, 2, 'Group', 3, 'Subscribers', 3, 12),
(4, 3, 'Group', 4, 'Moderators', 4, 9),
(5, 4, 'Group', 5, 'Admins', 5, 8),
(6, 5, 'User', 1, 'admin', 6, 7);

CREATE TABLE IF NOT EXISTS `se_aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_read` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_update` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_delete` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

INSERT INTO `se_aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 5, 1, '1', '1', '1', '1'),
(2, 1, 2, '0', '1', '0', '0'),
(3, 2, 20, '1', '1', '1', '0'),
(4, 2, 28, '0', '0', '1', '0'),
(5, 2, 36, '0', '1', '1', '0'),
(6, 2, 43, '0', '1', '0', '0'),
(7, 1, 43, '0', '1', '0', '0'),
(8, 1, 54, '0', '1', '0', '0'),
(9, 2, 54, '0', '1', '1', '0'),
(10, 2, 65, '0', '1', '0', '0'),
(11, 2, 73, '0', '1', '0', '0'),
(12, 1, 82, '0', '1', '1', '0'),
(13, 2, 91, '1', '1', '1', '1'),
(14, 2, 98, '0', '1', '1', '0'),
(15, 1, 98, '0', '0', '1', '0'),
(16, 1, 106, '1', '1', '1', '1'),
(17, 1, 114, '0', '1', '1', '0');

CREATE TABLE IF NOT EXISTS `se_custom_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `value_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `eve_inv_type_id` int(11) NOT NULL,
  `value` float NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_value_type_eve_material_type_id` (`user_id`,`value_type`,`eve_inv_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `se_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `se_groups` (`id`, `name`, `parent_id`, `created`, `modified`) VALUES
(1, 'Users', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Trials', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Subscribers', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Moderators', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Admin', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `se_mineral_indexes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eve_inv_type_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

INSERT INTO `se_mineral_indexes` (`id`, `eve_inv_type_id`, `price`, `created`, `modified`) VALUES
(1, 37, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 40, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 36, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 11399, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 38, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 35, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 34, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 39, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `se_mineral_index_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eve_inv_type_id` int(11) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `eve_inv_type_id` (`eve_inv_type_id`,`order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

INSERT INTO `se_mineral_index_types` (`id`, `eve_inv_type_id`, `order`, `created`, `modified`) VALUES
(8, 39, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 34, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 35, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 38, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 11399, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 36, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 40, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(1, 37, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `se_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_key` (`user_id`,`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `se_subscription_journals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` bigint(20) NOT NULL,
  `character_id` int(11) NOT NULL,
  `character_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` float(12,2) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ref_id_unique` (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `se_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `se_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `expires` bigint(16) NOT NULL DEFAULT '0',
  `balance` bigint(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;
