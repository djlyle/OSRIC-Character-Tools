-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2016 at 02:36 PM
-- Server version: 5.5.49
-- PHP Version: 5.3.10-1ubuntu3.22

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `osric_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `abilities`
--

CREATE TABLE IF NOT EXISTS `abilities` (
  `AbilityId` bigint(20) NOT NULL AUTO_INCREMENT,
  `AbilityLongName` varchar(32) NOT NULL,
  `AbilityShortName` varchar(8) NOT NULL,
  PRIMARY KEY (`AbilityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `abilities`
--

INSERT INTO `abilities` (`AbilityId`, `AbilityLongName`, `AbilityShortName`) VALUES
(1, 'Strength', 'Str'),
(2, 'Dexterity', 'Dex'),
(3, 'Constitution', 'Con'),
(4, 'Intelligence', 'Int'),
(5, 'Wisdom', 'Wis'),
(6, 'Charisma', 'Cha');

-- --------------------------------------------------------

--
-- Table structure for table `alignment`
--

CREATE TABLE IF NOT EXISTS `alignment` (
  `AlignmentId` bigint(20) NOT NULL AUTO_INCREMENT,
  `AlignmentName` varchar(32) NOT NULL,
  `ShortDescription` varchar(32) NOT NULL,
  PRIMARY KEY (`AlignmentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `alignment`
--

INSERT INTO `alignment` (`AlignmentId`, `AlignmentName`, `ShortDescription`) VALUES
(1, 'Lawful Good', 'Crusader'),
(2, 'Neutral Good', 'Benefactor'),
(3, 'Chaotic Good', 'Rebel'),
(4, 'Lawful Neutral', 'Judge'),
(5, 'Neutral', ''),
(6, 'Chaotic Neutral', 'Free Spirit'),
(7, 'Lawful Evil', 'Dominator'),
(8, 'Neutral Evil', 'Malefactor'),
(9, 'Chaotic Evil', 'Destroyer');

-- --------------------------------------------------------

--
-- Table structure for table `armour`
--

CREATE TABLE IF NOT EXISTS `armour` (
  `ArmourId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ArmourType` varchar(32) DEFAULT NULL,
  `ArmourMovementRate` float NOT NULL,
  `ArmourEffectOnArmourClass` int(11) NOT NULL,
  `ItemId` bigint(20) NOT NULL,
  PRIMARY KEY (`ArmourId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `armour`
--

INSERT INTO `armour` (`ArmourId`, `ArmourType`, `ArmourMovementRate`, `ArmourEffectOnArmourClass`, `ItemId`) VALUES
(1, 'Banded', 90, -6, 108),
(2, 'Mail hauberk or byrnie (chain)', 90, -5, 109),
(3, 'Mail, elfin (chain)', 120, -5, 110),
(4, 'Leather', 120, -2, 111),
(5, 'Padded gambeson', 90, -2, 112),
(6, 'Plate', 60, -7, 113),
(7, 'Ring', 90, -3, 114),
(8, 'Scale or lamellar', 60, -4, 115),
(9, 'Shield, large', -1, -1, 116),
(10, 'Shield, medium', -1, -1, 117),
(11, 'Shield, small', -1, -1, 118),
(12, 'Splint', 60, -6, 119),
(13, 'Studded', 90, -3, 120);

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `CharacterName` varchar(255) NOT NULL,
  `CharacterGender` int(11) NOT NULL,
  `CharacterAge` float NOT NULL,
  `CharacterHeight` float NOT NULL,
  `CharacterWeight` float NOT NULL,
  `CharacterId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CharacterAlignment` int(11) NOT NULL,
  `RaceId` bigint(20) NOT NULL,
  PRIMARY KEY (`CharacterId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`CharacterName`, `CharacterGender`, `CharacterAge`, `CharacterHeight`, `CharacterWeight`, `CharacterId`, `CharacterAlignment`, `RaceId`) VALUES
('Roland1', 1, 77, 68, 143, 45, 0, 2),
('R2', 2, 22, 59, 130, 46, 0, 1),
('Mr. Generic', 1, 43, 65, 140, 67, 0, 0),
('Noobe', 1, 0, 0, 0, 114, 0, 0),
('DJL', 0, 44, 64, 136, 115, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `character_abilities`
--

CREATE TABLE IF NOT EXISTS `character_abilities` (
  `CharacterId` bigint(20) NOT NULL,
  `AbilityId` bigint(20) NOT NULL,
  `Value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_abilities`
--

INSERT INTO `character_abilities` (`CharacterId`, `AbilityId`, `Value`) VALUES
(45, 1, 22),
(45, 2, 16),
(45, 3, 18),
(45, 4, 18),
(45, 5, 16),
(45, 6, 19),
(46, 1, 18.2),
(46, 2, 17),
(46, 3, 44),
(46, 4, 15),
(46, 5, 3),
(46, 6, 2),
(67, 1, 1),
(67, 2, 2),
(67, 3, 3),
(67, 4, 4),
(67, 5, 6),
(67, 6, 8),
(114, 1, 0),
(114, 2, 0),
(114, 3, 0),
(114, 4, 0),
(114, 5, 0),
(114, 6, 0),
(115, 1, 0),
(115, 2, 0),
(115, 3, 0),
(115, 4, 0),
(115, 5, 0),
(115, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `character_classes`
--

CREATE TABLE IF NOT EXISTS `character_classes` (
  `CharacterId` bigint(20) NOT NULL,
  `ClassId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_classes`
--

INSERT INTO `character_classes` (`CharacterId`, `ClassId`) VALUES
(46, 5),
(67, 4),
(67, 6),
(45, 3),
(45, 4),
(45, 9),
(114, 3),
(115, 6);

-- --------------------------------------------------------

--
-- Table structure for table `character_coins`
--

CREATE TABLE IF NOT EXISTS `character_coins` (
  `CharacterCoinId` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterId` bigint(20) NOT NULL,
  `CoinId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ItemStatusId` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`CharacterCoinId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1252 ;

--
-- Dumping data for table `character_coins`
--

INSERT INTO `character_coins` (`CharacterCoinId`, `CharacterId`, `CoinId`, `Quantity`, `ItemStatusId`) VALUES
(1, 45, 1, 15, 1),
(7, 46, 2, 3, 1),
(8, 46, 3, 4, 1),
(9, 46, 4, 5, 1),
(10, 46, 5, 22, 1),
(44, 45, 1, 20363, 2),
(45, 46, 1, 2, 2),
(46, 45, 3, 3064, 2),
(48, 45, 4, 28, 2),
(49, 45, 5, 5, 2),
(622, 45, 2, 30132, 2),
(623, 45, 2, 3, 1),
(1241, 114, 1, 1, 1),
(1242, 114, 2, 1, 1),
(1243, 114, 3, 1, 1),
(1244, 114, 4, 2, 1),
(1245, 114, 5, 3, 1),
(1246, 114, 1, 49, 2),
(1247, 115, 1, 0, 1),
(1248, 115, 2, 0, 1),
(1249, 115, 3, 0, 1),
(1250, 115, 4, 0, 1),
(1251, 115, 5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `character_items`
--

CREATE TABLE IF NOT EXISTS `character_items` (
  `CharacterItemId` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterId` bigint(20) NOT NULL,
  `ItemId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ItemStatusId` int(11) NOT NULL DEFAULT '1',
  `Magic` int(11) NOT NULL,
  PRIMARY KEY (`CharacterItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Dumping data for table `character_items`
--

INSERT INTO `character_items` (`CharacterItemId`, `CharacterId`, `ItemId`, `Quantity`, `ItemStatusId`, `Magic`) VALUES
(2, 45, 7, 51, 1, 0),
(3, 45, 9, 11, 1, 0),
(4, 46, 1, 1, 1, 0),
(5, 46, 9, 1, 1, 0),
(6, 46, 12, 1, 1, 0),
(26, 45, 4, 3, 1, 0),
(28, 45, 12, 3, 1, 0),
(29, 45, 3, 10, 1, 0),
(30, 45, 5, 7, 1, 0),
(44, 45, 159, 4, 1, 0),
(49, 45, 159, 1, 2, 0),
(51, 45, 19, 8, 1, 0),
(52, 45, 17, 3, 1, 0),
(54, 45, 145, 3, 1, 0),
(55, 45, 153, 4, 1, 0),
(57, 45, 155, 7, 1, 0),
(73, 45, 127, 2, 1, 0),
(75, 45, 135, 1, 1, 0),
(76, 45, 137, 1, 1, 0),
(83, 114, 1, 1, 1, 0),
(84, 114, 3, 2, 1, 0),
(85, 114, 5, 3, 1, 0),
(86, 114, 111, 3, 1, 0),
(87, 114, 113, 4, 1, 0),
(88, 114, 115, 3, 1, 0),
(89, 114, 131, 1, 1, 0),
(90, 114, 133, 2, 1, 0),
(91, 114, 135, 2, 1, 0),
(92, 114, 151, 1, 1, 0),
(93, 114, 157, 1, 1, 0),
(94, 114, 111, 6, 2, 0),
(95, 45, 1, 95, 1, 0),
(96, 45, 115, 1, 1, 0),
(97, 45, 141, 30, 1, 0),
(102, 45, 149, 1, 2, 0),
(111, 45, 115, 5, 2, 0),
(115, 45, 153, 1, 3, 0),
(116, 45, 129, 1, 3, 0),
(117, 45, 135, 2, 2, 0),
(118, 45, 127, 2, 2, 0),
(119, 45, 141, 2, 3, 0),
(121, 45, 115, 2, 3, 0),
(122, 114, 11, 34, 1, 0),
(123, 114, 131, 1, 3, 0),
(124, 114, 135, 1, 2, 0),
(125, 45, 108, 140, 1, 0),
(126, 45, 128, 22, 1, 0),
(127, 45, 129, 2, 1, 0),
(128, 45, 32, 3, 1, 0),
(129, 45, 36, 1, 1, 0),
(130, 45, 120, 1, 1, 0),
(131, 45, 121, 3, 1, 0),
(132, 45, 122, 1, 1, 0),
(133, 45, 123, 1, 1, 0),
(134, 45, 109, 24, 1, 0),
(135, 45, 124, 13, 1, 0),
(136, 45, 125, 11, 1, 0),
(137, 45, 126, 12, 1, 0),
(138, 45, 112, 8, 1, 0),
(139, 45, 138, 2, 1, 0),
(140, 45, 142, 10, 1, 0),
(141, 45, 113, 8, 1, 0),
(142, 45, 114, 1, 1, 0),
(143, 45, 116, 1, 1, 0),
(144, 45, 111, 8, 1, 0),
(145, 45, 95, 1, 1, 0),
(146, 45, 96, 2, 1, 0),
(147, 45, 97, 2, 1, 0),
(148, 45, 98, 3, 1, 0),
(149, 45, 100, 5, 1, 0),
(150, 45, 134, 7, 1, 0),
(151, 45, 21, 3, 1, 0),
(152, 45, 130, 58, 1, 0),
(153, 45, 45, 4, 1, 0),
(154, 45, 13, 3, 1, 0),
(155, 45, 110, 1, 1, 0),
(156, 45, 0, 8, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `character_status`
--

CREATE TABLE IF NOT EXISTS `character_status` (
  `CharacterId` bigint(20) NOT NULL,
  `StatusId` int(11) NOT NULL,
  `Value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_status`
--

INSERT INTO `character_status` (`CharacterId`, `StatusId`, `Value`) VALUES
(45, 0, '7'),
(45, 1, '61'),
(45, 2, '51'),
(45, 3, '21');

-- --------------------------------------------------------

--
-- Table structure for table `character_traits`
--

CREATE TABLE IF NOT EXISTS `character_traits` (
  `CharacterId` bigint(20) NOT NULL,
  `TraitId` int(11) NOT NULL,
  `Value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `ClassId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(64) NOT NULL,
  PRIMARY KEY (`ClassId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`ClassId`, `ClassName`) VALUES
(1, 'Assassin'),
(2, 'Cleric'),
(3, 'Druid'),
(4, 'Fighter'),
(5, 'Illusionist'),
(6, 'Magic User'),
(7, 'Paladin'),
(8, 'Ranger'),
(9, 'Thief');

-- --------------------------------------------------------

--
-- Table structure for table `coins`
--

CREATE TABLE IF NOT EXISTS `coins` (
  `CoinId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CoinName` varchar(16) NOT NULL,
  `CoinValueInGoldCoins` decimal(10,2) NOT NULL,
  `CoinEncumbranceInLbs` float NOT NULL,
  PRIMARY KEY (`CoinId`),
  UNIQUE KEY `CoinId` (`CoinId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `coins`
--

INSERT INTO `coins` (`CoinId`, `CoinName`, `CoinValueInGoldCoins`, `CoinEncumbranceInLbs`) VALUES
(1, 'Gold', 1.00, 0.1),
(2, 'Silver', 0.10, 0.1),
(3, 'Copper', 0.01, 0.1),
(4, 'Platinum', 5.00, 0.1),
(5, 'Electrum', 0.50, 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

CREATE TABLE IF NOT EXISTS `data_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(16) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`type_id`, `type_name`) VALUES
(0, 'string'),
(1, 'integer'),
(2, 'float'),
(3, 'decimal'),
(4, 'choice');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ItemName` varchar(64) DEFAULT NULL,
  `ItemEncumbrance` float NOT NULL,
  `ItemCost` decimal(10,2) NOT NULL,
  `ItemId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ItemType` int(11) NOT NULL,
  UNIQUE KEY `ItemId` (`ItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=160 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemName`, `ItemEncumbrance`, `ItemCost`, `ItemId`, `ItemType`) VALUES
('Ale, pint			', 1, 0.10, 1, 0),
('Backpack			', 10, 2.00, 2, 0),
('Barrel			', 30, 2.00, 3, 0),
('Bedroll			', 5, 0.20, 4, 0),
('Bell			', 0, 1.00, 5, 0),
('Belt			', 0, 0.50, 6, 0),
('Blanket,woolen		', 2, 0.05, 7, 0),
('Block and tackle		', 5, 5.00, 8, 0),
('Boots,soft			', 3, 1.00, 9, 0),
('Boots,heavy		', 5, 2.00, 10, 0),
('Bottle (wine), glass		', 1, 2.00, 11, 0),
('Box (empty)		', 15, 1.00, 12, 0),
('Bracer, leather (archery)	', 1, 0.80, 13, 0),
('Caltrops			', 2, 1.00, 14, 0),
('Candle, beeswax		', 0, 0.01, 15, 0),
('Canvas			', 1, 0.10, 16, 0),
('Cauldron and tripod		', 15, 2.00, 17, 0),
('Chain (per 10 ft)		', 10, 30.00, 18, 0),
('Chalk, piece		', 0, 0.01, 19, 0),
('Chest (empty)		', 25, 2.00, 20, 0),
('Cloak			', 2, 0.03, 21, 0),
('Crowbar			', 5, 2.00, 22, 0),
('Dice, bone, pair		', 0, 0.50, 23, 0),
('Dice, loaded, pair		', 0, 5.00, 24, 0),
('Doublet, linen		', 1, 3.00, 25, 0),
('Firewood (per day)		', 20, 0.01, 26, 0),
('Fish hook			', 0, 0.10, 27, 0),
('Fishing net (per 25 sq. ft)	', 0, 0.10, 28, 0),
('Flask (leather)		', 0, 0.03, 29, 0),
('Flint and steel		', 0, 1.00, 30, 0),
('Gloves, kidskin, pair		', 0.5, 3.00, 31, 0),
('Gown, woolen		', 1, 0.05, 32, 0),
('Gown, linen		', 1, 3.00, 33, 0),
('Gown, silk		', 1, 50.00, 34, 0),
('Grappling hook		', 4, 1.00, 35, 0),
('Hammer (tool, not war)	', 2, 0.50, 36, 0),
('Holy symbol, silver		', 1, 25.00, 37, 0),
('Holy symbol, pewter		', 1, 5.00, 38, 0),
('Holy symbol, wooden	', 1, 0.60, 39, 0),
('Horse, cart		', 0, 15.00, 40, 0),
('Horse, nag		', 0, 8.00, 41, 0),
('Horse, palfrey		', 0, 40.00, 42, 0),
('Horse, rouncey		', 0, 25.00, 43, 0),
('Horse, war, heavy		', 0, 500.00, 44, 0),
('Horse, war, light		', 0, 200.00, 45, 0),
('Horse, war, medium		', 0, 350.00, 46, 0),
('Hose			', 0, 1.00, 47, 0),
('Iron spikes, dozen		', 0, 1.00, 48, 0),
('Ladder (per 10ft)		', 20, 0.50, 49, 0),
('Lamp (bronze)		', 1, 0.10, 50, 0),
('Lantern, bullseye		', 3, 12.00, 51, 0),
('Lantern, hooded		', 2, 7.00, 52, 0),
('Lock			', 1, 20.00, 53, 0),
('Manacles			', 2, 15.00, 54, 0),
('Mirror (small steel)		', 0.5, 20.00, 55, 0),
('Mirror (small silver)		', 0.5, 45.00, 56, 0),
('Mule			', 0, 18.00, 57, 0),
('Musical instrument		', 1, 5.00, 58, 0),
('Needle and thread		', 0, 0.03, 59, 0),
('Oil (lamp) (per pint)		', 1, 0.10, 60, 0),
('Ox			', 0, 15.00, 61, 0),
('Parchment (per sheet)	', 0, 0.20, 62, 0),
('Pin (cloak)		', 0, 0.40, 63, 0),
('Piton			', 0.5, 0.10, 64, 0),
('Pole (per 10 ft)		', 8, 0.20, 65, 0),
('Pony			', 0, 12.00, 66, 0),
('Pot, iron			', 10, 0.50, 67, 0),
('Pouch, belt, large		', 2, 0.40, 68, 0),
('Pouch, belt, small		', 1, 0.20, 69, 0),
('Quill (pen)			', 0, 0.10, 70, 0),
('Quiver (holds 12 arrows)	', 1, 1.00, 71, 0),
('Quiver (holds 24 arrows)	', 2, 0.25, 72, 0),
('Quiver (holds 12 bolts)	', 1, 0.12, 73, 0),
('Quiver (holds 24 bolts)	', 2, 3.00, 74, 0),
('Rations, standard (per day)	', 2, 2.00, 75, 0),
('Rations, trail (per day)	', 1, 6.00, 76, 0),
('Reins, bit and bridle		', 5, 2.00, 77, 0),
('Robe, linen		', 1, 3.00, 78, 0),
('Robe, silk			', 1, 60.00, 79, 0),
('Rope, hemp (per 50 ft)	', 10, 1.00, 80, 0),
('Rope, silk (per 50 ft)		', 5, 10.00, 81, 0),
('Sack, small		', 0.5, 0.09, 82, 0),
('Sack, large		', 1, 0.15, 83, 0),
('Saddle and stirrups		', 20, 10.00, 84, 0),
('Satchel			', 5, 1.00, 85, 0),
('Scrollcase, bone		', 0.5, 4.00, 86, 0),
('Scrollcase, leather		', 0.5, 1.00, 87, 0),
('Shoes, common		', 1, 0.50, 88, 0),
('Shoes, noble		', 1, 30.00, 89, 0),
('Shovel			', 8, 2.00, 90, 0),
('Signal Whistle		', 0, 0.80, 91, 0),
('Skillet			', 5, 1.00, 92, 0),
('Soap (per lb)		', 1, 0.50, 93, 0),
('Spell book (blank)		', 5, 25.00, 94, 0),
('Tent			', 20, 10.00, 95, 0),
('Thieves'' Tools		', 1, 30.00, 96, 0),
('Torch			', 1, 0.01, 97, 0),
('Tunic, woolen		', 1, 0.05, 98, 0),
('Tunic, banqueting		', 1, 10.00, 99, 0),
('Twine, linen (per 100 ft)	', 0.5, 0.08, 100, 0),
('Vellum (per sheet)		', 0, 0.30, 101, 0),
('Wagon, small		', 0, 100.00, 102, 0),
('Wagon, large		', 0, 250.00, 103, 0),
('Water,  holy (per vial)	', 0.5, 25.00, 104, 0),
('Waterskin			', 1, 1.00, 105, 0),
('Whetstone		', 0.5, 0.02, 106, 0),
('Wine, pint			', 1, 0.05, 107, 0),
('Banded armour', 35, 90.00, 108, 1),
('Mail hauberk or byrnie (chain)', 30, 75.00, 109, 1),
('Mail, elfin (chain)', 15, -1.00, 110, 1),
('Leather armour', 15, 5.00, 111, 1),
('Padded gambeson armour', 10, 4.00, 112, 1),
('Plate armour', 45, 400.00, 113, 1),
('Ring armour', 35, 30.00, 114, 1),
('Scale or lamellar armour', 40, 45.00, 115, 1),
('Shield, large', 10, 15.00, 116, 1),
('Shield, medium', 8, 12.00, 117, 1),
('Shield, small', 5, 10.00, 118, 1),
('Splint Armour', 40, 80.00, 119, 1),
('Studded Armour', 20, 15.00, 120, 1),
('Arrows', 0.333333, 0.17, 121, 2),
('Axe, battle', 7, 5.00, 122, 2),
('Axe, hand', 5, 1.00, 123, 2),
('Bolt, heavy crossbow', 0.333333, 0.33, 124, 2),
('Bolt, light crossbow', 0.166667, 0.17, 125, 2),
('Club', 3, 0.02, 126, 2),
('Dagger', 1, 2.00, 127, 2),
('Dart', 0.5, 0.20, 128, 2),
('Flail, heavy', 10, 3.00, 129, 2),
('Flail, light', 4, 6.00, 130, 2),
('Halberd', 18, 9.00, 131, 2),
('Hammer, war, heavy', 10, 7.00, 132, 2),
('Hammer, war, light', 5, 1.00, 133, 2),
('Javelin', 4, 0.50, 134, 2),
('Lance', 15, 6.00, 135, 2),
('Mace, heavy', 10, 10.00, 136, 2),
('Mace, light', 5, 4.00, 137, 2),
('Morning star', 12, 5.00, 138, 2),
('Pick, heavy', 10, 8.00, 139, 2),
('Pick, light', 4, 5.00, 140, 2),
('Pole arm', 8, 6.00, 141, 2),
('Sling bullet', 0.333333, 0.08, 142, 2),
('Sling stone', 0.166667, 0.00, 143, 2),
('Spear', 5, 1.00, 144, 2),
('Staff', 5, 0.00, 145, 2),
('Sword, claymore/bastard', 10, 25.00, 146, 2),
('Sword, broad', 8, 10.00, 147, 2),
('Sword, long', 7, 15.00, 148, 2),
('Sword, scimitar', 5, 15.00, 149, 2),
('Sword, short', 3, 8.00, 150, 2),
('Sword, two-handed', 25, 30.00, 151, 2),
('Trident', 5, 4.00, 152, 2),
('Bow, long', 12, 60.00, 153, 2),
('Bow, short', 8, 15.00, 154, 2),
('Composite bow, long', 13, 100.00, 155, 2),
('Composite bow, short', 9, 75.00, 156, 2),
('Crossbow, heavy', 12, 20.00, 157, 2),
('Crossbow, light', 4, 12.00, 158, 2),
('Sling', 0.5, 0.50, 159, 2);

-- --------------------------------------------------------

--
-- Table structure for table `item_status`
--

CREATE TABLE IF NOT EXISTS `item_status` (
  `ItemStatusId` int(11) NOT NULL AUTO_INCREMENT,
  `ItemStatus` varchar(16) NOT NULL,
  PRIMARY KEY (`ItemStatusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item_status`
--

INSERT INTO `item_status` (`ItemStatusId`, `ItemStatus`) VALUES
(1, 'In Storage'),
(2, 'Carried'),
(3, 'In Use'),
(4, 'Discard');

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE IF NOT EXISTS `item_type` (
  `ItemType` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) NOT NULL,
  PRIMARY KEY (`ItemType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`ItemType`, `Name`) VALUES
(0, 'Item'),
(1, 'Armour'),
(2, 'Weapon');

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `RaceId` bigint(20) NOT NULL AUTO_INCREMENT,
  `RaceName` varchar(64) NOT NULL,
  UNIQUE KEY `RaceId` (`RaceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`RaceId`, `RaceName`) VALUES
(0, 'Human'),
(2, 'Dwarf'),
(3, 'Elf'),
(4, 'Gnome'),
(5, 'Half Elf'),
(6, 'Halfling'),
(7, 'Half-Orc');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `StatusId` int(11) NOT NULL,
  `DisplayName` varchar(32) NOT NULL,
  `data_type` int(11) NOT NULL,
  PRIMARY KEY (`StatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`StatusId`, `DisplayName`, `data_type`) VALUES
(0, 'Armour Class', 1),
(1, 'Experience Points', 1),
(2, 'Full Hit Points', 1),
(3, 'Remaining Hit Points', 1);

-- --------------------------------------------------------

--
-- Table structure for table `traits`
--

CREATE TABLE IF NOT EXISTS `traits` (
  `TraitId` int(11) NOT NULL,
  `DisplayName` varchar(32) NOT NULL,
  `data_type` int(11) NOT NULL,
  `ChoiceTableName` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `traits`
--

INSERT INTO `traits` (`TraitId`, `DisplayName`, `data_type`, `ChoiceTableName`) VALUES
(0, 'Name', 0, ''),
(1, 'Gender', 4, 'gender'),
(2, 'Age', 2, ''),
(3, 'Height', 2, ''),
(4, 'Weight', 2, ''),
(5, 'Alignment', 4, 'alignment'),
(6, 'Race', 4, 'races');

-- --------------------------------------------------------

--
-- Table structure for table `weapons`
--

CREATE TABLE IF NOT EXISTS `weapons` (
  `WeaponId` bigint(11) NOT NULL AUTO_INCREMENT,
  `WeaponType` varchar(32) DEFAULT NULL,
  `ItemId` bigint(20) NOT NULL,
  PRIMARY KEY (`WeaponId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `weapons`
--

INSERT INTO `weapons` (`WeaponId`, `WeaponType`, `ItemId`) VALUES
(1, 'Arrows', 121),
(2, 'Axe, battle', 122),
(3, 'Axe, hand', 123),
(4, 'Bolt, heavy crossbow', 124),
(5, 'Bolt, light crossbow', 125),
(6, 'Bow, long', 153),
(7, 'Bow, short', 154),
(8, 'Club', 126),
(9, 'Composite bow, long', 155),
(10, 'Composite bow, short', 156),
(11, 'Crossbow, heavy', 157),
(12, 'Crossbow, light', 158),
(13, 'Dagger', 127),
(14, 'Dart', 128),
(15, 'Flail, heavy', 129),
(16, 'Flail, light', 130),
(17, 'Halberd', 131),
(18, 'Hammer, war, heavy', 132),
(19, 'Hammer, war, light', 133),
(20, 'Javelin', 134),
(21, 'Lance', 135),
(22, 'Mace, heavy', 136),
(23, 'Mace, light', 137),
(24, 'Morning Star', 138),
(25, 'Pick, heavy', 139),
(26, 'Pick, light', 140),
(27, 'Pole arm', 141),
(28, 'Sling', 159),
(29, 'Sling bullet', 142),
(30, 'Sling stone', 143),
(31, 'Spear', 144),
(34, 'Staff', 145),
(35, 'Sword, claymore/bastard', 146),
(36, 'Sword, broad', 147),
(37, 'Sword, long', 148),
(38, 'Sword, scimitar', 149),
(39, 'Sword, short', 150),
(40, 'Sword, two-handed', 151),
(41, 'Trident', 152);

-- --------------------------------------------------------

--
-- Table structure for table `weapon_as_melee`
--

CREATE TABLE IF NOT EXISTS `weapon_as_melee` (
  `WeaponId` bigint(20) NOT NULL,
  `DamageVsSmallOrMedium` int(11) NOT NULL,
  `DamageVsLarge` int(11) NOT NULL,
  `DamageModifierVsSmallOrMedium` int(11) NOT NULL,
  `DamageModifierVsLarge` int(11) NOT NULL,
  `DamageVsSmallOrMediumMultiples` int(11) NOT NULL DEFAULT '1',
  `DamageVsLargeMultiples` int(11) NOT NULL DEFAULT '1',
  `MeleeWeaponIndex` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`MeleeWeaponIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `weapon_as_melee`
--

INSERT INTO `weapon_as_melee` (`WeaponId`, `DamageVsSmallOrMedium`, `DamageVsLarge`, `DamageModifierVsSmallOrMedium`, `DamageModifierVsLarge`, `DamageVsSmallOrMediumMultiples`, `DamageVsLargeMultiples`, `MeleeWeaponIndex`) VALUES
(2, 8, 8, 0, 0, 1, 1, 2),
(3, 6, 4, 0, 0, 1, 1, 3),
(8, 4, 3, 0, 0, 1, 1, 4),
(13, 4, 3, 0, 0, 1, 1, 5),
(14, 3, 2, 0, 0, 1, 1, 6),
(15, 6, 4, 1, 0, 1, 2, 7),
(16, 4, 4, 1, 1, 1, 1, 8),
(17, 10, 6, 0, 0, 1, 2, 9),
(18, 6, 6, 1, 0, 1, 1, 10),
(19, 4, 4, 1, 0, 1, 1, 11),
(20, 6, 4, 0, 0, 1, 1, 12),
(21, 4, 6, 1, 0, 2, 3, 13),
(22, 6, 6, 1, 0, 1, 1, 14),
(23, 4, 4, 1, 1, 1, 1, 15),
(24, 4, 6, 0, 1, 2, 1, 16),
(25, 6, 4, 1, 0, 1, 2, 17),
(26, 4, 4, 1, 0, 1, 1, 18),
(27, 6, 10, 1, 0, 1, 1, 19),
(31, 6, 8, 0, 0, 1, 1, 20),
(34, 6, 6, 0, 0, 1, 1, 21),
(35, 4, 8, 0, 0, 2, 2, 22),
(36, 4, 6, 0, 1, 2, 1, 23),
(37, 8, 12, 0, 0, 1, 1, 24),
(38, 8, 8, 0, 0, 1, 1, 25),
(39, 6, 8, 0, 0, 1, 1, 26),
(40, 10, 6, 0, 0, 1, 3, 27),
(41, 6, 4, 1, 0, 1, 3, 28);

-- --------------------------------------------------------

--
-- Table structure for table `weapon_as_missile`
--

CREATE TABLE IF NOT EXISTS `weapon_as_missile` (
  `WeaponId` bigint(20) NOT NULL,
  `DamageVsSmallOrMedium` int(11) NOT NULL,
  `DamageVsLarge` int(11) NOT NULL,
  `DamageModifierVsSmallOrMedium` int(11) NOT NULL,
  `DamageModifierVsLarge` int(11) NOT NULL,
  `RateOfFire` float NOT NULL,
  `RangeInFt` int(11) NOT NULL,
  `MissileWeaponIndex` bigint(20) NOT NULL AUTO_INCREMENT,
  `DamageVsSmallOrMediumMultiples` int(11) NOT NULL DEFAULT '1',
  `DamageVsLargeMultiples` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`MissileWeaponIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `weapon_as_missile`
--

INSERT INTO `weapon_as_missile` (`WeaponId`, `DamageVsSmallOrMedium`, `DamageVsLarge`, `DamageModifierVsSmallOrMedium`, `DamageModifierVsLarge`, `RateOfFire`, `RangeInFt`, `MissileWeaponIndex`, `DamageVsSmallOrMediumMultiples`, `DamageVsLargeMultiples`) VALUES
(3, 6, 4, 0, 0, 1, 10, 1, 1, 1),
(6, 6, 6, 0, 0, 2, 70, 2, 1, 1),
(7, 6, 6, 0, 0, 2, 50, 3, 1, 1),
(8, 4, 3, 0, 0, 1, 10, 4, 1, 1),
(9, 6, 6, 0, 0, 2, 60, 5, 1, 1),
(10, 6, 6, 0, 0, 2, 50, 6, 1, 1),
(11, 6, 6, 1, 1, 0.5, 60, 7, 1, 1),
(12, 4, 4, 1, 1, 1, 60, 8, 1, 1),
(13, 4, 4, 0, 0, 2, 10, 9, 1, 1),
(14, 3, 2, 0, 0, 3, 15, 10, 1, 1),
(19, 4, 4, 1, 0, 1, 10, 11, 1, 1),
(20, 6, 4, 0, 0, 1, 20, 12, 1, 1),
(31, 6, 8, 0, 0, 1, 15, 14, 1, 1),
(29, 4, 6, 1, 1, 1, 35, 15, 1, 1),
(30, 4, 4, 0, 0, 1, 35, 16, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
