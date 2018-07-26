-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2017 at 10:37 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timelessthings`
--

-- --------------------------------------------------------

--
-- Table structure for table `ln_contents`
--

CREATE TABLE IF NOT EXISTS `ln_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `category` int(10) unsigned NOT NULL DEFAULT '2',
  `name` varchar(255) NOT NULL,
  `words` text,
  `body` text,
  `scopeOfWork` text,
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
  `lang` varchar(125) DEFAULT NULL,
  `langRelated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `ln_contents`
--

INSERT INTO `ln_contents` (`id`, `title`, `parent`, `category`, `name`, `words`, `body`, `scopeOfWork`, `tags`, `authorId`, `datePublished`, `dateCreated`, `dateModified`, `contentType`, `status`, `picture`, `views`, `lastView`, `modifierId`, `featured`, `metaData`, `lang`, `langRelated`) VALUES
(1, 'A Natural Masterpice Bearing Its Own Uniqueness And Splendour', 0, 2, 'a-natural-masterpice-bearing-its-own-uniqueness-and-splendour', 'A natural masterpice bearing its own uniqueness and splendour', '<p>A natural masterpice bearing its <br /> own uniqueness and splendour</p>', '', NULL, 2, '2017-07-15 10:15:10', '2017-07-15 10:15:10', '2017-07-16 08:12:20', 'slider', 1, 'slide-5.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(2, 'From The Ring Of Fire Comes A Material Of Incredible Worth Of Expectation Beuty', 0, 2, 'from-the-ring-of-fire-comes-a-material-of-incredible-worth-of-expectation-beuty', 'From the ring of fire comes a material incredible worth expectation beuty', '<p>From the ring of fire comes a material of <br /> incredible worth of expectation beuty</p>', '', NULL, 2, '2017-07-15 10:28:49', '2017-07-15 10:28:49', '2017-07-16 08:12:36', 'slider', 1, 'slide-4.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(3, 'Rescued And Recycled For Another Million Years Of Joy', 0, 2, 'rescued-and-recycled-for-another-million-years-of-joy', 'Rescued and recycled for another million years of joy', '<p>Rescued and recycled <br /> for another million years of joy</p>', '', NULL, 2, '2017-07-15 10:29:25', '2017-07-15 10:29:25', '2017-07-16 08:12:52', 'slider', 1, 'slide-3.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(4, 'Transformed From Wood To Stone', 0, 2, 'transformed-from-wood-to-stone', 'Transformed from wood to stone', '<p>Transformed from wood to stone</p>', '', NULL, 2, '2017-07-15 10:30:02', '2017-07-15 10:30:02', '2017-07-16 08:13:03', 'slider', 1, 'slide-2.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(5, 'BRING THE BEAUTY OF PETRIFIED WOOD INTO YOUR HOME', 0, 2, 'bring-the-beauty-of-petrified-wood-into-your-home', 'BRING THE BEAUTY OF PETRIFIED WOOD INTO YOUR HOME', '<p>BRING THE BEAUTY OF PETRIFIED <br /> WOOD INTO YOUR HOME</p>', '', NULL, 2, '2017-07-15 10:31:06', '2017-07-15 10:31:06', '2017-07-16 08:13:16', 'slider', 1, 'slide-1.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(6, 'KITCHEN TOOLS', 0, 0, 'kitchen-tools', 'From the best looking bits, we create smaller, more elaborated objects such as candle holders, trays and bowls. Although grains of stone will vary, colors are mostly earth tones, making them suitable for virtually any interior.', '<p>From the best looking bits, we create smaller, more elaborated objects such as candle holders, trays and bowls. Although the grains of the stone will vary, the colors are mostly earth tones, making them suitable for virtually any interior.</p>', '', NULL, 2, '2017-07-15 10:32:23', '2017-07-15 10:32:23', '2017-07-15 12:05:38', 'product', 1, 'product-kitchentools.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(7, 'SLABS', 0, 0, 'slabs', 'Each slab is thickly cut and more than strong enough to be used as a table top. They are ready coffee or top, displayed on an easel wall piece. Polished mirror finish, each of our petrified wood plates flat buffed produce gorgeous piece natural art.', '<p>Each slab is thickly cut and is more than strong enough to be used as a table top. They are ready to be used as a coffee table or table top, or displayed on an easel or as a wall piece. Polished to a mirror finish, each of our petrified wood plates is flat and buffed to produce a gorgeous piece of natural art.</p>', '', NULL, 2, '2017-07-15 11:23:31', '2017-07-15 11:23:31', '2017-07-15 12:05:46', 'product', 1, 'product-slabs.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(8, 'STOOLS', 0, 0, 'stools', 'Whether for the piano, bar, or everything in-between, a stool crafted from petrified wood will amaze and delight every occasion. Three-legged four-legged, our stools come in variety of shapes sizes.', '<p>Whether for the piano, the bar, or everything in-between, a stool crafted from petrified wood will amaze and delight for every occasion. Three-legged or four-legged, our stools come in a variety of shapes and sizes.</p>', '', NULL, 2, '2017-07-15 12:04:44', '2017-07-15 12:04:44', '2017-07-15 12:06:01', 'product', 1, 'product-stools.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(9, 'About Us', 0, 0, 'about-us', 'Body Page', 'Body Page', '', NULL, 2, '2017-07-15 11:23:31', '2017-07-15 11:23:31', '2017-07-16 07:57:11', 'page', 1, 'hero-about.jpg', 0, 0, 2, 0, 'a:1:{s:8:"subtitle";s:53:"RESCUED AND RECYCLED FOR ANOTHER MILLION YEARS OF JOY";}', NULL, NULL),
(10, 'Mosaics', 0, 5, 'mosaics', 'Our craftsmen know how to rejuvenate the left-over pieces, shaping them into colored patterns. Assembling these blocks a collage of shades, gorgeous mosaic design is created, ideal as wall panel or sturdy floor tile.', '<p>Our craftsmen know how to rejuvenate the left-over pieces, shaping them into colored patterns. Assembling these blocks into a collage of shades, a gorgeous mosaic design is created, ideal as a wall panel or a sturdy floor tile.</p>', '', NULL, 2, '2017-07-16 08:25:48', '2017-07-16 08:25:48', '2017-07-16 08:25:48', 'product', 1, 'product-mosaicts.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(11, 'DECORATIVE COLUMNS', 0, 5, 'decorative-columns', 'Nature can&rsquo;t be beaten when it comes to creating stunning shapes and colors. This certainly counts for our sculptures of petrified wood. Awe-inspiring artistic, a column wood is extracted, hand cut polished museum-quality piece art. These decorative columns pieces offer striking focal point in any living room, office or garden.', '<p>Nature can&rsquo;t be beaten when it comes to creating stunning shapes and colors. This certainly counts for our sculptures of petrified wood. Awe-inspiring and artistic, a column of petrified wood is extracted, hand cut and polished for a museum-quality piece of art. These decorative columns pieces offer a striking focal point in any living room, office or garden.</p>', '', NULL, 2, '2017-07-16 08:26:28', '2017-07-16 08:26:28', '2017-07-16 08:26:28', 'product', 1, 'product-decorativecolumns.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(12, 'MANTLE PIECES', 0, 5, 'mantle-pieces', 'Intriguing and rare, petrified wood has the qualities of stone. To create a perfect mantle piece, first cut is from center tree, before our craftsmen sculpt stone into large, rectangular-shaped piece. We make sure rings will be clearly visible.', '<p>Intriguing and rare, petrified wood has the qualities of stone. To create a perfect mantle piece, the first cut is from the center of a petrified tree, before our craftsmen sculpt the stone into a large, rectangular-shaped mantle piece. We make sure the rings will be clearly visible.</p>', '', NULL, 2, '2017-07-16 08:26:58', '2017-07-16 08:26:58', '2017-07-16 08:26:58', 'product', 1, 'product-mantlepieces.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(13, 'SINKS', 0, 5, 'sinks', 'Nothing is more natural than a stone sink made of petrified wood. Quarried to our workshop, every single wood log hand selected based on its color, hardness and size. Before crafting, each meticulously examined determine the best way cut optimize pattern form. With so many combinations shape sizes, no two sinks are ever alike. From simple round cross-cuts extreme organic shapes, hand-crafted truly one-of-a-kind.', '<div class="text">\n<p>Nothing is more natural than a stone sink made of petrified wood. Quarried to our workshop, every single wood log is hand selected based on its color, hardness and size.</p>\n<p>Before crafting, each log is meticulously examined to determine the best way to cut to optimize its pattern and form. With so many combinations of color, shape and sizes, no two sinks are ever alike. From simple round cross-cuts to extreme organic shapes, our hand-crafted petrified wood sinks are truly one-of-a-kind.</p>\n</div>', '', NULL, 2, '2017-07-16 08:27:36', '2017-07-16 08:27:36', '2017-07-16 08:27:36', 'product', 1, 'product-sinks.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(14, 'TABLES', 0, 5, 'tables', 'A stunning slab of petrified wood will make a dramatic statement in your dining room when it&rsquo;s polished and transformed into table &ndash; stylish, functional simply spectacular. The most basic type is trunk that&rsquo;s large enough seat two couples. After the extracted from below ground, down to create smooth, glossy surface, leaving natural shape tree ring as rim masterpiece. At Timeliness Things Company, we design tables which can be made entirely or just top. However you like it, shimmering colors minerals creates sculptured icon guaranteed memorable impact, whatever setting.', '<div class="text">\n<p>A stunning slab of petrified wood will make a dramatic statement in your dining room when it&rsquo;s polished and transformed into a table &ndash; stylish, functional and simply spectacular.</p>\n<p>The most basic type of petrified wood table is simply a trunk that&rsquo;s large enough seat two couples. After the trunk is extracted from below ground, it&rsquo;s polished down to create a smooth, glossy surface, leaving the natural shape of the tree ring as the rim of the masterpiece.</p>\n<p>At the Timeliness Things Company, we design tables which can be made entirely of petrified wood or just the table top. However you like it, the shimmering colors of the minerals creates a sculptured icon that&rsquo;s guaranteed to make a memorable impact, whatever the setting.</p>\n</div>', '', NULL, 2, '2017-07-16 08:28:05', '2017-07-16 08:28:05', '2017-07-16 08:28:05', 'product', 1, 'product-tables.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(15, 'People 1', 0, 3, 'people-1', 'people 1', '<p>people 1</p>', '', NULL, 2, '2017-07-16 10:55:48', '2017-07-16 10:55:48', '2017-07-16 10:55:48', 'slider', 1, 'people-1.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(16, 'People 2', 0, 3, 'people-2', 'People 2', '<p>People 2</p>', '', NULL, 2, '2017-07-16 10:56:07', '2017-07-16 10:56:07', '2017-07-16 10:56:07', 'slider', 1, 'people-2.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(17, 'People 3', 0, 3, 'people-3', 'People 3', '<p>People 3</p>', '', NULL, 2, '2017-07-16 10:56:21', '2017-07-16 10:56:21', '2017-07-16 10:56:21', 'slider', 1, 'people-3.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(18, 'People 4', 0, 3, 'people-4', 'People 4', '<p>People 4</p>', '', NULL, 2, '2017-07-16 11:01:13', '2017-07-16 11:01:13', '2017-07-16 11:01:13', 'slider', 1, 'people-4.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(19, 'People 5', 0, 3, 'people-5', 'People 5', '<p>People 5</p>', '', NULL, 2, '2017-07-16 11:01:31', '2017-07-16 11:01:31', '2017-07-16 11:01:31', 'slider', 1, 'people-5.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(20, 'Peopl 6', 0, 3, 'peopl-6', 'People 6', '<p>People 6</p>', '', NULL, 2, '2017-07-16 11:01:48', '2017-07-16 11:01:48', '2017-07-16 11:01:48', 'slider', 1, 'people-6.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(21, 'Peopl 7', 0, 3, 'peopl-7', 'People 7', '<p>People 7</p>', '', NULL, 2, '2017-07-16 11:02:04', '2017-07-16 11:02:04', '2017-07-16 11:02:04', 'slider', 1, 'people-7.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(22, 'People 8', 0, 3, 'people-8', 'People 8', '<p>People 8</p>', '', NULL, 2, '2017-07-16 11:02:19', '2017-07-16 11:02:19', '2017-07-16 11:02:19', 'slider', 1, 'people-8.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(23, 'Waste Is Grace 1', 0, 4, 'waste-is-grace-1', 'Waste Is Grace 1', '<p>Waste Is Grace 1</p>', '', NULL, 2, '2017-07-16 11:06:54', '2017-07-16 11:06:54', '2017-07-16 11:06:54', 'slider', 1, 'waste-1.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(24, 'Waste Is Grace 2', 0, 4, 'waste-is-grace-2', 'Waste Is Grace 3', '<p>Waste Is Grace 3</p>', '', NULL, 2, '2017-07-16 11:07:09', '2017-07-16 11:07:09', '2017-07-16 11:07:09', 'slider', 1, 'waste-2.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(25, 'Waste Is Grace 3', 0, 4, 'waste-is-grace-3', 'Waste Is Grace 3', '<p>Waste Is Grace 3</p>', '', NULL, 2, '2017-07-16 11:07:22', '2017-07-16 11:07:22', '2017-07-16 11:07:22', 'slider', 1, 'waste-3.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(26, 'Waste Is Grace 4', 0, 4, 'waste-is-grace-4', 'Waste Is Grace 4', '<p>Waste Is Grace 4</p>', '', NULL, 2, '2017-07-16 11:07:45', '2017-07-16 11:07:45', '2017-07-16 11:07:45', 'slider', 1, 'waste-4.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(27, 'Waste Is Grace 5', 0, 4, 'waste-is-grace-5', 'Waste Is Grace 5', '<p>Waste Is Grace 5</p>', '', NULL, 2, '2017-07-16 11:07:57', '2017-07-16 11:07:57', '2017-07-16 11:07:57', 'slider', 1, 'waste-5.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL),
(28, 'Waste Is Grace 6', 0, 4, 'waste-is-grace-6', 'Waste Is Grace 6', '<p>Waste Is Grace 6</p>', '', NULL, 2, '2017-07-16 11:08:13', '2017-07-16 11:08:13', '2017-07-16 11:08:13', 'slider', 1, 'waste-6.jpg', 0, 0, 2, 0, 'a:1:{s:9:"upperHead";s:0:"";}', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ln_content_types`
--

CREATE TABLE IF NOT EXISTS `ln_content_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `module` varchar(45) NOT NULL DEFAULT '',
  `isCategory` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `haveSubCategory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `haveContent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ln_content_types`
--

INSERT INTO `ln_content_types` (`id`, `name`, `module`, `isCategory`, `haveSubCategory`, `haveContent`) VALUES
(1, 'page', 'Page', 1, 0, 1),
(2, 'product', 'Product', 1, 0, 1),
(3, 'slider', 'Slider', 1, 1, 1),
(4, 'article', 'PostContent', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ln_media`
--

CREATE TABLE IF NOT EXISTS `ln_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text CHARACTER SET latin1,
  `extension` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `fileSize` int(10) unsigned NOT NULL DEFAULT '0',
  `mediaType` varchar(10) CHARACTER SET latin1 NOT NULL DEFAULT 'library',
  `posterId` int(10) unsigned NOT NULL DEFAULT '0',
  `datePosted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(10) unsigned NOT NULL DEFAULT '100',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `metaData` text CHARACTER SET latin1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `ln_media`
--

INSERT INTO `ln_media` (`id`, `owner`, `name`, `title`, `description`, `extension`, `fileSize`, `mediaType`, `posterId`, `datePosted`, `ordering`, `status`, `metaData`) VALUES
(1, 0, 'home-about', 'home-about', NULL, 'jpg', 112422, 'library', 2, '2017-07-15 07:57:54', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(2, 0, 'home-people', 'home-people', NULL, 'jpg', 70166, 'library', 2, '2017-07-15 07:57:55', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:300;}'),
(3, 0, 'intro-philosophy', 'intro-philosophy', NULL, 'jpg', 143875, 'library', 2, '2017-07-15 07:58:42', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(4, 0, 'process', 'process', NULL, 'jpg', 64493, 'library', 2, '2017-07-15 07:59:07', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:300;}'),
(5, 0, 'slide-1', 'slide-1', NULL, 'jpg', 164215, 'library', 2, '2017-07-15 10:13:10', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(6, 0, 'slide-2', 'slide-2', NULL, 'jpg', 146814, 'library', 2, '2017-07-15 10:13:10', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(7, 0, 'slide-3', 'slide-3', NULL, 'jpg', 167623, 'library', 2, '2017-07-15 10:13:11', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(8, 0, 'slide-4', 'slide-4', NULL, 'jpg', 178389, 'library', 2, '2017-07-15 10:13:11', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(9, 0, 'slide-5', 'slide-5', NULL, 'jpg', 140782, 'library', 2, '2017-07-15 10:13:12', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(10, 0, 'decorativecolumns', 'decorativecolumns', NULL, 'jpg', 55720, 'library', 2, '2017-07-15 10:32:02', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(11, 0, 'kitchentools', 'kitchentools', NULL, 'jpg', 48211, 'library', 2, '2017-07-15 10:32:03', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(12, 0, 'mantlepieces', 'mantlepieces', NULL, 'jpg', 52260, 'library', 2, '2017-07-15 10:32:03', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(13, 0, 'mosaics', 'mosaics', NULL, 'jpg', 74815, 'library', 2, '2017-07-15 10:32:04', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(14, 0, 'sinks', 'sinks', NULL, 'jpg', 50341, 'library', 2, '2017-07-15 10:32:04', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(15, 0, 'slabs', 'slabs', NULL, 'jpg', 53633, 'library', 2, '2017-07-15 10:32:05', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(16, 0, 'stools', 'stools', NULL, 'jpg', 54503, 'library', 2, '2017-07-15 10:32:05', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(17, 0, 'tables', 'tables', NULL, 'jpg', 66067, 'library', 2, '2017-07-15 10:32:06', 100, 0, 'a:2:{s:5:"width";i:450;s:6:"height";i:260;}'),
(18, 0, 'product-decorativecolumns', 'product-decorativecolumns', NULL, 'jpg', 85111, 'library', 2, '2017-07-15 12:05:20', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(19, 0, 'product-kitchentools', 'product-kitchentools', NULL, 'jpg', 71253, 'library', 2, '2017-07-15 12:05:21', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(20, 0, 'product-mantlepieces', 'product-mantlepieces', NULL, 'jpg', 72023, 'library', 2, '2017-07-15 12:05:21', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(21, 0, 'product-mosaicts', 'product-mosaicts', NULL, 'jpg', 120205, 'library', 2, '2017-07-15 12:05:22', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(22, 0, 'product-sinks', 'product-sinks', NULL, 'jpg', 80326, 'library', 2, '2017-07-15 12:05:22', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(23, 0, 'product-slabs', 'product-slabs', NULL, 'jpg', 72550, 'library', 2, '2017-07-15 12:05:23', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(24, 0, 'product-stools', 'product-stools', NULL, 'jpg', 95816, 'library', 2, '2017-07-15 12:05:23', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(25, 0, 'product-tables', 'product-tables', NULL, 'jpg', 105404, 'library', 2, '2017-07-15 12:05:24', 100, 0, 'a:2:{s:5:"width";i:650;s:6:"height";i:400;}'),
(26, 0, 'hero-about', 'hero-about', NULL, 'jpg', 180244, 'library', 2, '2017-07-16 07:45:39', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(27, 0, 'people-1', 'people-1', NULL, 'jpg', 86208, 'library', 2, '2017-07-16 08:47:01', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(28, 0, 'people-2', 'people-2', NULL, 'jpg', 126898, 'library', 2, '2017-07-16 08:47:02', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(29, 0, 'people-3', 'people-3', NULL, 'jpg', 100164, 'library', 2, '2017-07-16 08:47:02', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(30, 0, 'people-4', 'people-4', NULL, 'jpg', 157676, 'library', 2, '2017-07-16 08:47:03', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(31, 0, 'people-5', 'people-5', NULL, 'jpg', 142781, 'library', 2, '2017-07-16 08:47:03', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(32, 0, 'people-6', 'people-6', NULL, 'jpg', 134800, 'library', 2, '2017-07-16 08:47:04', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(33, 0, 'people-7', 'people-7', NULL, 'jpg', 127189, 'library', 2, '2017-07-16 08:47:04', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(34, 0, 'people-8', 'people-8', NULL, 'jpg', 150212, 'library', 2, '2017-07-16 08:47:05', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:580;}'),
(35, 0, 'waste-1', 'waste-1', NULL, 'jpg', 150458, 'library', 2, '2017-07-16 11:06:27', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(36, 0, 'waste-2', 'waste-2', NULL, 'jpg', 233532, 'library', 2, '2017-07-16 11:06:28', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(37, 0, 'waste-3', 'waste-3', NULL, 'jpg', 168946, 'library', 2, '2017-07-16 11:06:28', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(38, 0, 'waste-4', 'waste-4', NULL, 'jpg', 221658, 'library', 2, '2017-07-16 11:06:29', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(39, 0, 'waste-5', 'waste-5', NULL, 'jpg', 118981, 'library', 2, '2017-07-16 11:06:29', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(40, 0, 'waste-6', 'waste-6', NULL, 'jpg', 134980, 'library', 2, '2017-07-16 11:06:30', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(41, 0, 'hero-about-1596b5cafaf836', 'hero-about', NULL, 'jpg', 180244, 'library', 2, '2017-07-16 12:31:43', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(42, 0, 'about-1', 'about-1', NULL, 'jpg', 43437, 'library', 2, '2017-07-16 12:31:58', 100, 0, 'a:2:{s:5:"width";i:330;s:6:"height";i:440;}'),
(43, 0, 'about-2', 'about-2', NULL, 'jpg', 176352, 'library', 2, '2017-07-16 12:32:45', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(44, 0, 'about-3', 'about-3', NULL, 'jpg', 95090, 'library', 2, '2017-07-16 12:34:31', 100, 0, 'a:2:{s:5:"width";i:440;s:6:"height";i:440;}'),
(45, 0, 'about-4', 'about-4', NULL, 'jpg', 70853, 'library', 2, '2017-07-16 12:34:36', 100, 0, 'a:2:{s:5:"width";i:440;s:6:"height";i:320;}'),
(46, 0, 'hero-philosophy', 'hero-philosophy', NULL, 'jpg', 179361, 'library', 2, '2017-07-16 12:38:15', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(47, 0, 'philosophy-1', 'philosophy-1', NULL, 'jpg', 115119, 'library', 2, '2017-07-16 12:38:36', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}'),
(48, 0, 'philosophy-2', 'philosophy-2', NULL, 'jpg', 95854, 'library', 2, '2017-07-16 12:38:36', 100, 0, 'a:2:{s:5:"width";i:1200;s:6:"height";i:480;}');

-- --------------------------------------------------------

--
-- Table structure for table `ln_metadata`
--

CREATE TABLE IF NOT EXISTS `ln_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'config',
  `meta_key` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meta_value` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ln_metadata`
--

INSERT INTO `ln_metadata` (`id`, `scope`, `meta_key`, `meta_value`) VALUES
(1, 'config', 'siteName', 'Timeless Things'),
(2, 'config', 'senderMail', 'noreply@timelessthingsco.com'),
(3, 'config', 'settings', 'a:17:{s:11:"contactMail";s:12:"tes@mail.com";s:14:"contactAddress";s:315:"<h5 style="font-weight: 200;">LOS ANGELES</h5>\r\n<p>&nbsp;5404 Alton Parkway, Suite 771 <br />Irvine, CA 92604 <br />T. (+1) 949 6169675</p>\r\n<p>&nbsp;</p>\r\n<h5 style="font-weight: 200;">BALI</h5>\r\n<p>Regus Benoa Square <br />Jl. Bypass Ngurah Rai No.21A <br />T. (+62) 361 2003275 <br />www.timelessthingsco.com</p>";s:9:"instagram";s:4:"test";s:8:"facebook";s:4:"test";s:7:"twitter";s:4:"test";s:12:"pictureAbout";s:14:"home-about.jpg";s:9:"aboutText";s:350:"At The Timeless Things Company, we have built a creative community of artisans around this natural relic. Melding up-to-date technology with traditional craftmanship we create natural works of art - things that are truly one-of-a-kind. Each piece shares the history and splendor of the natural tree from where it came â€“ itâ€™s original living form.";s:12:"homeSection1";s:178:"Legally harvested and completely unique, each piece of petrified wood is a natural masterpiece. An exceptional piece of petrified wood brings the beauty of nature into your home.";s:17:"picturePhilosophy";s:20:"intro-philosophy.jpg";s:15:"titlePhilosophy";s:14:"WASTE IS GRACE";s:14:"textPhilosophy";s:288:"The company believes there is no such thing as waste, and strives to find innovative ways of using every part of the stone. All the off-cuts from larger items are saved, and re-cycled to make something unique and beautiful. Where there is waste, we see grace to bring things back to life.";s:14:"pictureProcess";s:11:"process.jpg";s:12:"titleProcess";s:7:"PROCESS";s:13:"picturePeople";s:15:"home-people.jpg";s:11:"titlePeople";s:6:"PEOPLE";s:15:"pagePeopleTitle";s:79:"<p>FOLDED BY THE FORCES OF NATURE, <br />MOLDED BY CRAFTSMEN, ADORED BY YOU</p>";s:14:"pagePeopleDesc";s:404:"It would not be possible to make our masterpieces of petrified wood without our community of skilled artisans. The Timeless Things Company is built on a collaboration of traditional Indonesian techniques, made more efficient with advanced technology. From the efforts of these creative artisans, whole trunks of petrified wood are selected, cut, shaped and polished, into wonders of extraordinary beauty.";}'),
(4, 'config', 'aboutus', 'a:12:{s:9:"heroImage";s:29:"hero-about-1596b5cafaf836.jpg";s:9:"heroTitle";s:67:"<p>RESCUED AND RECYCLED FOR <br /> ANOTHER MILLION YEARS OF JOY</p>";s:18:"pictureBelowHeader";s:11:"about-1.jpg";s:14:"titleBelowHero";s:36:"Timeless <span>Things</span> Company";s:13:"textBelowHero";s:594:"<p>A handsome piece of petrified wood, with its tree rings clearly visible and stunningly preserved, is a per-mineralized fossil of an ancient old tree, one of a vast prehistoric forest. Formed over millions of years, petrified wood comes from the trunks of trees that have been turned to stone â€“ literally â€˜petrifiedâ€™ and transformed from plant matter into solid rock. practical uses.\r\n</p>\r\n<p>\r\nThe raw essence of petrified wood attracts many a collector to showcase the trunks and slabs as natural works of art, but when molded for a purpose, petrified wood can have other, more\r\n</p>";s:17:"thirdSectionImage";s:11:"about-2.jpg";s:17:"thirdSectionTitle";s:161:"<p>\r\nThe Timeless Things Company sculpts, reinvigorates, and recycles this primal material to produce incredible furniture and architectural masterpieces. \r\n</p>";s:18:"titleFourthSection";s:39:"HOW PETRI<span>FIED WO</span>OD IS MADE";s:13:"firstRowImage";s:11:"about-3.jpg";s:12:"firstRowText";s:912:"<h3>FROZEN IN TIME : FOSSILIZED WOOD FROM PRE-HISTORY</h3>\r\n<p>The petrifaction process occurs underground, when wood becomes buried under sediment or volcanic ash. Rapid burial is vital to ensure the tree trunks is buried without insects or oxygen &ndash; the necessary ingredient for decay, and preserves the original plant structure and general appearance.</p>\r\n<p>The mineralization process occurs when mineralrich water flows through the mass of material. In this prehistoric brew, the water deposits minerals in the plant&rsquo;s cells, replacing the organic plant structure with inorganic minerals, mostly a silicate-like quartz. As the plant&rsquo;s cellulose or living matter decays, a stone cast is formed in its place. The final result, which can take up to 300 million years to form, is petrified wood, something that resembles a plant with its original structure in place, now replaced by stone.</p>";s:14:"secondRowImage";s:11:"about-4.jpg";s:13:"secondRowText";s:631:"<div class="text">\r\n<h3>MINERAL DEPOSITS</h3>\r\n<p>Elements such as manganese, iron, and copper in the water/mud during the petrification process give petrified wood a variety of color ranges. Pure quartz crystals are colorless, but when contaminants are added to the process the crystals take on a yellow, red, or other tints.</p>\r\n<p>The Timeless Things Company is based in Indonesia, where petrified wood dates from the Cenozo&iuml;cum era, about 20-22 million years ago. Surrounded by the Ring of Fire, this highly volcanic region produces petrified wood that is characterized by white, brown, grey and black colors.</p>\r\n</div>";}'),
(5, 'config', 'philosophy', 'a:11:{s:9:"heroImage";s:19:"hero-philosophy.jpg";s:9:"heroTitle";s:82:"<p>A NATURAL MASTERPIECE <br /> BEARING ITS OWN UNIQUENESS<br /> AND SPLENDOUR</p>";s:18:"pictureBelowHeader";s:16:"philosophy-1.jpg";s:14:"titleBelowHero";s:41:"Transform <span>From Wo</span>od To Stone";s:13:"textBelowHero";s:365:"<p>At the Timeless Things Company, we have built a creative community of artisans around this natural relic. Melding up-to-date technology with traditional craftmanship we create natural works of art - things that are truly one-of-a-kind. Each piece shares the history and splendor of the natural tree from where it came &ndash; it&rsquo;s original living form.</p>";s:17:"thirdSectionImage";s:12:"people-4.jpg";s:17:"thirdSectionTitle";s:25:"CRA<span>FTMAN</span>SHIP";s:16:"thirdSectionDesc";s:275:"Our company takes an artisanal approach to carefully selecting the right fragment, before carving the hard stone. Using whole trunks of fossilized rock, we fashion larger architectural and furniture items such as table tops, deep sinks, decorative columns, and mantle pieces.";s:17:"thirdSectionDesc1";s:127:"Although the grains of the stone will vary, the colors are mostly earth tones, making them suitable for virtually any interior.";s:18:"titleFourthSection";s:14:"WASTE IS GRACE";s:17:"textFourthSection";s:288:"The company believes there is no such thing as waste, and strives to find innovative ways of using every part of the stone. All the off-cuts from larger items are saved, and re-cycled to make something unique and beautiful. Where there is waste, we see grace to bring things back to life.";}');

-- --------------------------------------------------------

--
-- Table structure for table `ln_roles`
--

CREATE TABLE IF NOT EXISTS `ln_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL DEFAULT '',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ln_roles`
--

INSERT INTO `ln_roles` (`id`, `title`, `group`) VALUES
(1, 'Common User', 1),
(2, 'Root Administrator', 2),
(3, 'Administrator', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ln_terms`
--

CREATE TABLE IF NOT EXISTS `ln_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `pathName` varchar(65) NOT NULL DEFAULT '',
  `title` varchar(45) DEFAULT NULL,
  `contentType` varchar(45) NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  `defaultTags` varchar(255) DEFAULT NULL,
  `numContents` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ln_terms`
--

INSERT INTO `ln_terms` (`id`, `parent`, `pathName`, `title`, `contentType`, `status`, `ordering`, `defaultTags`, `numContents`) VALUES
(1, 0, 'slider', 'Slider', 'slider', 1, 0, NULL, 0),
(2, 1, 'slider/home', 'Slider Home', 'slider', 1, 0, NULL, 0),
(3, 1, 'slider/people', 'Slider People', 'slider', 1, 0, NULL, 0),
(4, 1, 'slider/philosophy', 'Slider Philosophy', 'slider', 1, 0, NULL, 0),
(5, 0, 'products', 'Products', 'product', 1, 0, NULL, 0),
(6, 0, 'page', 'Page', 'page', 1, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ln_users`
--

CREATE TABLE IF NOT EXISTS `ln_users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ln_users`
--

INSERT INTO `ln_users` (`id`, `email`, `password`, `facebookId`, `name`, `dateRegistered`, `dateActivated`, `status`, `lastVisit`, `role`, `birthDate`, `log_attempts`, `log_timeout`, `city`, `region`, `country`) VALUES
(2, 'admin@mail.com', 'cbfc77604396d4311140a3236fa1df85', 476829285826007, 'administrator', '2015-07-31 11:55:36', NULL, 1, '2017-07-19 10:16:18', 3, NULL, 0, 0, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
