<?php

app::$database->query(

"CREATE TABLE `#__metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'config',
  `meta_key` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meta_value` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"

);

app::$database->query(
"CREATE TABLE  `#__users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(145) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `facebookId` double NOT NULL DEFAULT '0',
  `name` varchar(145) NOT NULL DEFAULT '',
  `dateRegistered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateActivated` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lastVisit` datetime DEFAULT NULL,
  `role` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `birthDate` date DEFAULT NULL,
  `log_attempts` int(10) unsigned NOT NULL DEFAULT '0',
  `log_timeout` int(10) unsigned NOT NULL DEFAULT '0',
  `city` varchar(145) DEFAULT NULL,
  `region` varchar(145) DEFAULT NULL,
  `country` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);

app::$database->query(
"CREATE TABLE  `#__content_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `module` varchar(45) NOT NULL DEFAULT '',
  `isCategory` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `haveSubCategory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `haveContent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);

app::$database->query(
"CREATE TABLE  `#__terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pathName` varchar(65) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `contentType` varchar(45) NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `defaultTags` varchar(255) DEFAULT NULL,
  `numContents` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);

app::$database->query(
"CREATE TABLE  `#__roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL DEFAULT '',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;"
);
app::$database->query(
"CREATE TABLE  `#__pagelogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contentId` int(10) unsigned NOT NULL DEFAULT '0',
  `contentType` varchar(24) NOT NULL DEFAULT '',
  `visitorId` char(32) NOT NULL DEFAULT '',
  `logType` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `lastView` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;"
);

app::$database->query(
"CREATE TABLE  `#__mostview` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contentId` int(10) unsigned NOT NULL DEFAULT '0',
  `lastView` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `daily` int(10) unsigned NOT NULL DEFAULT '1',
  `weekly` int(10) unsigned NOT NULL DEFAULT '1',
  `monthly` int(10) unsigned NOT NULL DEFAULT '1',
  `halfYearly` int(10) unsigned NOT NULL DEFAULT '1',
  `yearly` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;"
);

app::$database->query(
"CREATE TABLE  `#__contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `category` int(10) unsigned NOT NULL DEFAULT '2',
  `name` varchar(255) NOT NULL,
  `words` text,
  `body` text,
  `tags` text,
  `authorId` int(10) unsigned NOT NULL DEFAULT '0',
  `datePublished` datetime DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `dateModified` datetime DEFAULT NULL,
  `contentType` varchar(45) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `picture` varchar(125) DEFAULT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `lastView` int(10) unsigned NOT NULL DEFAULT '0',
  `modifierId` int(10) unsigned NOT NULL DEFAULT '0',
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `metaData` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);

Response::redirect(Request::$baseUrl);

?>