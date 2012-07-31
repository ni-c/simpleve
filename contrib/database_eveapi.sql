SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `ea_eve_alliance_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allianceID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shortName` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `executorCorpID` int(11) NOT NULL,
  `memberCount` int(11) NOT NULL,
  `startDate` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `allianceID` (`allianceID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `ea_map_sovereignty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solarSystemID` int(11) NOT NULL,
  `allianceID` int(11) NOT NULL,
  `factionID` int(11) NOT NULL,
  `solarSystemName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `corporationID` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `solarSystemID` (`solarSystemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `ea_map_sovereignty_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `solarSystemID` int(11) NOT NULL,
  `action` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `allianceID` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

