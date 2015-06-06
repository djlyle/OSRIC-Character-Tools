-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2015 at 09:04 PM
-- Server version: 5.5.43
-- PHP Version: 5.3.10-1ubuntu3.18

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
  `ArmourEncumbrance` float NOT NULL,
  `ArmourMovementRate` float NOT NULL,
  `ArmourEffectOnArmourClass` int(11) NOT NULL,
  `ArmourCost` float NOT NULL,
  PRIMARY KEY (`ArmourId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `armour`
--

INSERT INTO `armour` (`ArmourId`, `ArmourType`, `ArmourEncumbrance`, `ArmourMovementRate`, `ArmourEffectOnArmourClass`, `ArmourCost`) VALUES
(1, 'Banded', 35, 90, -6, 90),
(2, 'Mail hauberk or byrnie (chain)', 30, 90, -5, 75),
(3, 'Mail, elfin (chain)', 15, 120, -5, -1),
(4, 'Leather', 15, 120, -2, 5),
(5, 'Padded gambeson', 10, 90, -2, 4),
(6, 'Plate', 45, 60, -7, 400),
(7, 'Ring', 35, 90, -3, 30),
(8, 'Scale or lamellar', 40, 60, -4, 45),
(9, 'Shield, large', 10, -1, -1, 15),
(10, 'Shield, medium', 8, -1, -1, 12),
(11, 'Shield, small', 5, -1, -1, 10),
(12, 'Splint', 40, 60, -6, 80),
(13, 'Studded', 20, 90, -3, 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=270 ;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`CharacterName`, `CharacterGender`, `CharacterAge`, `CharacterHeight`, `CharacterWeight`, `CharacterId`, `CharacterAlignment`, `RaceId`) VALUES
('Roland1', 1, 74, 64, 143, 45, 0, 0),
('R2', 2, 22, 59, 130, 46, 0, 1),
('Mr. Generic', 1, 42, 65, 140, 50, 0, 0),
('d22', 0, 0, 0, 0, 51, 0, 0),
('f1', 0, 5, 11, 41, 141, 0, 4),
('f2', 0, 0, 0, 0, 269, 0, 0);

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
(45, 1, 11),
(45, 2, 13),
(45, 3, 17),
(45, 4, 15),
(45, 5, 16),
(45, 6, 18),
(46, 1, 18.2),
(46, 2, 17),
(46, 3, 44),
(46, 4, 15),
(46, 5, 3),
(46, 6, 2),
(50, 1, 0),
(50, 2, 0),
(50, 3, 0),
(50, 4, 0),
(50, 5, 0),
(50, 6, 0),
(51, 1, 0),
(51, 2, 0),
(51, 3, 0),
(51, 4, 0),
(51, 5, 0),
(51, 6, 0),
(141, 1, 4),
(141, 2, 5),
(141, 3, 6),
(141, 4, 9),
(141, 5, 10),
(141, 6, 11),
(269, 1, 1),
(269, 2, 1),
(269, 3, 2),
(269, 4, 2),
(269, 5, 2),
(269, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `character_armour`
--

CREATE TABLE IF NOT EXISTS `character_armour` (
  `CharacterArmourId` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterId` bigint(20) NOT NULL,
  `ArmourId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ArmourMagic` int(11) NOT NULL DEFAULT '0',
  `EquipmentStatusId` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`CharacterArmourId`),
  KEY `CharacterId` (`CharacterId`,`ArmourId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `character_armour`
--

INSERT INTO `character_armour` (`CharacterArmourId`, `CharacterId`, `ArmourId`, `Quantity`, `ArmourMagic`, `EquipmentStatusId`) VALUES
(1, 45, 1, 2, 4, 1),
(2, 45, 2, 11, 1, 1),
(3, 45, 4, 15, 9, 1),
(4, 45, 7, 6, 2, 1),
(5, 45, 9, 5, 8, 1),
(6, 51, 1, 2, 4, 1),
(7, 50, 3, 1, 0, 1),
(8, 51, 2, 3, 5, 1),
(9, 52, 1, 5, 3, 1),
(10, 52, 2, 1, 4, 2),
(11, 53, 1, 1, 0, 1),
(12, 54, 4, 7, 2, 2),
(13, 54, 5, 2, 4, 1),
(14, 54, 1, 1, 1, 1),
(15, 54, 2, 1, 1, 1),
(17, 55, 2, 1, 2, 2),
(18, 55, 3, 1, 0, 1),
(19, 54, 3, 2, 4, 3),
(20, 54, 7, 4, 3, 1),
(21, 55, 11, 2, 0, 1),
(22, 55, 12, 1, 0, 1),
(23, 56, 6, 1, 0, 3),
(24, 56, 7, 1, 0, 1),
(25, 56, 8, 1, 0, 2),
(26, 54, 13, 1, 3, 2),
(27, 52, 10, 1, 0, 1),
(29, 55, 13, 3, 0, 1),
(31, 55, 1, 1, 1, 1),
(34, 55, 1, 1, 1, 2),
(35, 55, 12, 1, 0, 2),
(37, 45, 3, 7, 0, 1),
(38, 45, 1, 2, 4, 3),
(39, 45, 13, 20, 0, 1),
(40, 45, 5, 5, 0, 1),
(42, 45, 7, 6, 2, 2),
(43, 45, 9, 5, 8, 2),
(44, 45, 13, 20, 0, 2),
(45, 45, 10, 1, 0, 1),
(46, 45, 11, 6, 0, 1);

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
(45, 7),
(51, 1),
(141, 5),
(141, 9),
(269, 9);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1162 ;

--
-- Dumping data for table `character_coins`
--

INSERT INTO `character_coins` (`CharacterCoinId`, `CharacterId`, `CoinId`, `Quantity`, `ItemStatusId`) VALUES
(1, 45, 1, 46, 1),
(2, 45, 2, 31, 1),
(3, 45, 3, 10, 1),
(4, 45, 4, 31, 1),
(5, 45, 5, 13, 1),
(7, 46, 2, 3, 1),
(8, 46, 3, 4, 1),
(9, 46, 4, 5, 1),
(10, 46, 5, 22, 1),
(44, 45, 1, 3, 2),
(45, 46, 1, 2, 2),
(46, 45, 3, 9, 2),
(517, 141, 1, 2, 1),
(518, 141, 2, 3, 1),
(519, 141, 3, 4, 1),
(520, 141, 4, 5, 1),
(521, 141, 5, 7, 1),
(1157, 269, 1, 0, 1),
(1158, 269, 2, 0, 1),
(1159, 269, 3, 0, 1),
(1160, 269, 4, 0, 1),
(1161, 269, 5, 0, 1);

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
  PRIMARY KEY (`CharacterItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `character_items`
--

INSERT INTO `character_items` (`CharacterItemId`, `CharacterId`, `ItemId`, `Quantity`, `ItemStatusId`) VALUES
(1, 45, 1, 15, 1),
(2, 45, 7, 41, 1),
(3, 45, 9, 6, 1),
(4, 46, 1, 1, 1),
(5, 46, 9, 1, 1),
(6, 46, 12, 1, 1),
(25, 45, 1, 15, 2),
(26, 45, 4, 3, 1),
(27, 45, 4, 3, 2),
(28, 45, 12, 3, 1),
(29, 45, 3, 2, 1),
(30, 45, 5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `character_status`
--

CREATE TABLE IF NOT EXISTS `character_status` (
  `CharacterId` bigint(20) NOT NULL,
  `CharacterStatusArmourClass` int(11) NOT NULL,
  `CharacterStatusExperiencePoints` int(11) NOT NULL,
  `CharacterStatusFullHitPoints` int(11) NOT NULL,
  `CharacterStatusRemainingHitPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_status`
--

INSERT INTO `character_status` (`CharacterId`, `CharacterStatusArmourClass`, `CharacterStatusExperiencePoints`, `CharacterStatusFullHitPoints`, `CharacterStatusRemainingHitPoints`) VALUES
(45, 3, 70, 15, 10),
(46, 4, 2, 3, 1),
(50, 0, 0, 0, 0),
(51, 0, 0, 0, 0),
(141, -1, 37, 8, 5),
(269, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `character_weapons`
--

CREATE TABLE IF NOT EXISTS `character_weapons` (
  `CharacterWeaponId` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterId` bigint(20) NOT NULL,
  `WeaponId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `WeaponMagic` int(11) NOT NULL,
  `EquipmentStatusId` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`CharacterWeaponId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `character_weapons`
--

INSERT INTO `character_weapons` (`CharacterWeaponId`, `CharacterId`, `WeaponId`, `Quantity`, `WeaponMagic`, `EquipmentStatusId`) VALUES
(19, 52, 7, 1, 0, 3),
(21, 52, 13, 2, 2, 2),
(22, 52, 14, 1, 0, 3),
(23, 52, 15, 1, 0, 2),
(25, 52, 13, 1, 0, 1),
(26, 52, 8, 1, 0, 2),
(35, 55, 8, 2, 0, 1),
(36, 55, 13, 1, 0, 1),
(39, 55, 8, 2, 0, 3),
(44, 54, 13, 2, 0, 3),
(46, 54, 8, 1, 0, 3),
(48, 54, 2, 1, 1, 3),
(51, 54, 2, 1, 5, 2),
(53, 54, 15, 1, 7, 1),
(54, 55, 2, 4, 0, 1),
(55, 55, 2, 4, 0, 2),
(58, 55, 1, 5, 0, 1),
(60, 55, 1, 5, 0, 2),
(62, 55, 10, 1, 0, 2),
(63, 55, 8, 2, 0, 2),
(64, 55, 15, 1, 0, 1),
(65, 55, 16, 1, 0, 1),
(68, 51, 25, 1, 0, 1),
(69, 51, 22, 1, 0, 3),
(70, 51, 24, 1, 0, 2),
(71, 54, 1, 5, 0, 1),
(74, 54, 1, 5, 0, 3),
(75, 54, 3, 1, 0, 3),
(76, 54, 6, 1, 0, 3),
(77, 45, 2, 45, 0, 1),
(79, 45, 2, 45, 0, 3),
(80, 45, 6, 5, 0, 2),
(81, 45, 27, 1, 0, 1),
(82, 45, 6, 5, 0, 3),
(83, 45, 27, 1, 0, 2),
(84, 45, 15, 12, 0, 1),
(85, 45, 38, 24, 0, 1),
(86, 45, 41, 2, 0, 1),
(87, 45, 2, 45, 0, 2),
(88, 45, 24, 4, 0, 1),
(89, 45, 34, 2, 0, 1),
(91, 45, 36, 2, 0, 1),
(92, 45, 35, 1, 0, 3),
(93, 45, 1, 2, 0, 1);

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
  `CoinValueInGoldCoins` float NOT NULL,
  `CoinEncumbranceInLbs` float NOT NULL,
  PRIMARY KEY (`CoinId`),
  UNIQUE KEY `CoinId` (`CoinId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `coins`
--

INSERT INTO `coins` (`CoinId`, `CoinName`, `CoinValueInGoldCoins`, `CoinEncumbranceInLbs`) VALUES
(1, 'Gold', 1, 0.1),
(2, 'Silver', 0.1, 0.1),
(3, 'Copper', 0.01, 0.1),
(4, 'Platinum', 5, 0.1),
(5, 'Electrum', 0.5, 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_status`
--

CREATE TABLE IF NOT EXISTS `equipment_status` (
  `EquipmentStatusId` int(11) NOT NULL AUTO_INCREMENT,
  `EquipmentStatus` varchar(32) NOT NULL,
  PRIMARY KEY (`EquipmentStatusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `equipment_status`
--

INSERT INTO `equipment_status` (`EquipmentStatusId`, `EquipmentStatus`) VALUES
(1, 'In storage'),
(2, 'Carried'),
(3, 'In Use (worn\\wielded)'),
(4, 'Discard');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ItemName` varchar(64) DEFAULT NULL,
  `ItemEncumbrance` float NOT NULL,
  `ItemCost` float NOT NULL,
  `ItemId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `ItemId` (`ItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemName`, `ItemEncumbrance`, `ItemCost`, `ItemId`) VALUES
('Ale, pint			', 1, 0.1, 1),
('Backpack			', 10, 2, 2),
('Barrel			', 30, 2, 3),
('Bedroll			', 5, 0.2, 4),
('Bell			', 0, 1, 5),
('Belt			', 0, 0.5, 6),
('Blanket,woolen		', 2, 0.05, 7),
('Block and tackle		', 5, 5, 8),
('Boots,soft			', 3, 1, 9),
('Boots,heavy		', 5, 2, 10),
('Bottle (wine), glass		', 1, 2, 11),
('Box (empty)		', 15, 1, 12),
('Bracer, leather (archery)	', 1, 0.8, 13),
('Caltrops			', 2, 1, 14),
('Candle, beeswax		', 0, 0.01, 15),
('Canvas			', 1, 0.1, 16),
('Cauldron and tripod		', 15, 2, 17),
('Chain (per 10 ft)		', 10, 30, 18),
('Chalk, piece		', 0, 0.01, 19),
('Chest (empty)		', 25, 2, 20),
('Cloak			', 2, 0.03, 21),
('Crowbar			', 5, 2, 22),
('Dice, bone, pair		', 0, 0.5, 23),
('Dice, loaded, pair		', 0, 5, 24),
('Doublet, linen		', 1, 3, 25),
('Firewood (per day)		', 20, 0.01, 26),
('Fish hook			', 0, 0.1, 27),
('Fishing net (per 25 sq. ft)	', 0, 0.1, 28),
('Flask (leather)		', 0, 0.03, 29),
('Flint and steel		', 0, 1, 30),
('Gloves, kidskin, pair		', 0.5, 3, 31),
('Gown, woolen		', 1, 0.05, 32),
('Gown, linen		', 1, 3, 33),
('Gown, silk		', 1, 50, 34),
('Grappling hook		', 4, 1, 35),
('Hammer (tool, not war)	', 2, 0.5, 36),
('Holy symbol, silver		', 1, 25, 37),
('Holy symbol, pewter		', 1, 5, 38),
('Holy symbol, wooden	', 1, 0.6, 39),
('Horse, cart		', 0, 15, 40),
('Horse, nag		', 0, 8, 41),
('Horse, palfrey		', 0, 40, 42),
('Horse, rouncey		', 0, 25, 43),
('Horse, war, heavy		', 0, 500, 44),
('Horse, war, light		', 0, 200, 45),
('Horse, war, medium		', 0, 350, 46),
('Hose			', 0, 1, 47),
('Iron spikes, dozen		', 0, 1, 48),
('Ladder (per 10ft)		', 20, 0.5, 49),
('Lamp (bronze)		', 1, 0.1, 50),
('Lantern, bullseye		', 3, 12, 51),
('Lantern, hooded		', 2, 7, 52),
('Lock			', 1, 20, 53),
('Manacles			', 2, 15, 54),
('Mirror (small steel)		', 0.5, 20, 55),
('Mirror (small silver)		', 0.5, 45, 56),
('Mule			', 0, 18, 57),
('Musical instrument		', 1, 5, 58),
('Needle and thread		', 0, 0.03, 59),
('Oil (lamp) (per pint)		', 1, 0.1, 60),
('Ox			', 0, 15, 61),
('Parchment (per sheet)	', 0, 0.2, 62),
('Pin (cloak)		', 0, 0.4, 63),
('Piton			', 0.5, 0.1, 64),
('Pole (per 10 ft)		', 8, 0.2, 65),
('Pony			', 0, 12, 66),
('Pot, iron			', 10, 0.5, 67),
('Pouch, belt, large		', 2, 0.4, 68),
('Pouch, belt, small		', 1, 0.2, 69),
('Quill (pen)			', 0, 0.1, 70),
('Quiver (holds 12 arrows)	', 1, 1, 71),
('Quiver (holds 24 arrows)	', 2, 0.25, 72),
('Quiver (holds 12 bolts)	', 1, 0.12, 73),
('Quiver (holds 24 bolts)	', 2, 3, 74),
('Rations, standard (per day)	', 2, 2, 75),
('Rations, trail (per day)	', 1, 6, 76),
('Reins, bit and bridle		', 5, 2, 77),
('Robe, linen		', 1, 3, 78),
('Robe, silk			', 1, 60, 79),
('Rope, hemp (per 50 ft)	', 10, 1, 80),
('Rope, silk (per 50 ft)		', 5, 10, 81),
('Sack, small		', 0.5, 0.09, 82),
('Sack, large		', 1, 0.15, 83),
('Saddle and stirrups		', 20, 10, 84),
('Satchel			', 5, 1, 85),
('Scrollcase, bone		', 0.5, 4, 86),
('Scrollcase, leather		', 0.5, 1, 87),
('Shoes, common		', 1, 0.5, 88),
('Shoes, noble		', 1, 30, 89),
('Shovel			', 8, 2, 90),
('Signal Whistle		', 0, 0.8, 91),
('Skillet			', 5, 1, 92),
('Soap (per lb)		', 1, 0.5, 93),
('Spell book (blank)		', 5, 25, 94),
('Tent			', 20, 10, 95),
('Thieves'' Tools		', 1, 30, 96),
('Torch			', 1, 0.01, 97),
('Tunic, woolen		', 1, 0.05, 98),
('Tunic, banqueting		', 1, 10, 99),
('Twine, linen (per 100 ft)	', 0.5, 0.08, 100),
('Vellum (per sheet)		', 0, 0.3, 101),
('Wagon, small		', 0, 100, 102),
('Wagon, large		', 0, 250, 103),
('Water,  holy (per vial)	', 0.5, 25, 104),
('Waterskin			', 1, 1, 105),
('Whetstone		', 0.5, 0.02, 106),
('Wine, pint			', 1, 0.05, 107);

-- --------------------------------------------------------

--
-- Table structure for table `item_status`
--

CREATE TABLE IF NOT EXISTS `item_status` (
  `ItemStatusId` int(11) NOT NULL AUTO_INCREMENT,
  `ItemStatus` varchar(16) NOT NULL,
  PRIMARY KEY (`ItemStatusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `item_status`
--

INSERT INTO `item_status` (`ItemStatusId`, `ItemStatus`) VALUES
(1, 'In Storage'),
(2, 'Carried'),
(3, 'Discarded');

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
-- Table structure for table `weapons`
--

CREATE TABLE IF NOT EXISTS `weapons` (
  `WeaponId` bigint(11) NOT NULL AUTO_INCREMENT,
  `WeaponType` varchar(32) DEFAULT NULL,
  `WeaponEncumbranceInLbs` float NOT NULL,
  `WeaponCost` float NOT NULL,
  PRIMARY KEY (`WeaponId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `weapons`
--

INSERT INTO `weapons` (`WeaponId`, `WeaponType`, `WeaponEncumbranceInLbs`, `WeaponCost`) VALUES
(1, 'Arrows', 0.33, 0.33),
(2, 'Axe, battle', 7, 5),
(3, 'Axe, hand', 5, 1),
(4, 'Bolt, heavy crossbow', 0.33, 0.33),
(5, 'Bolt, light crossbow', 0.17, 0.17),
(6, 'Bow, long', 12, 60),
(7, 'Bow, short', 8, 15),
(8, 'Club', 3, 0.02),
(9, 'Composite bow, long', 13, 100),
(10, 'Composite bow, short', 9, 75),
(11, 'Crossbow, heavy', 12, 20),
(12, 'Crossbow, light', 4, 12),
(13, 'Dagger', 1, 2),
(14, 'Dart', 0.5, 0.2),
(15, 'Flail, heavy', 10, 3),
(16, 'Flail, light', 4, 6),
(17, 'Halberd', 18, 9),
(18, 'Hammer, war, heavy', 10, 7),
(19, 'Hammer, war, light', 5, 1),
(20, 'Javelin', 4, 0.5),
(21, 'Lance', 15, 6),
(22, 'Mace, heavy', 10, 10),
(23, 'Mace, light', 5, 4),
(24, 'Morning Star', 12, 5),
(25, 'Pick, heavy', 10, 8),
(26, 'Pick, light', 4, 5),
(27, 'Pole arm', 8, 6),
(28, 'Sling', 0.5, 0.5),
(29, 'Sling bullet', 0.33, 0.08),
(30, 'Sling stone', 0.17, 0),
(31, 'Spear', 5, 1),
(34, 'Staff', 5, 0),
(35, 'Sword, claymore/bastard', 10, 25),
(36, 'Sword, broad', 8, 10),
(37, 'Sword, long', 7, 15),
(38, 'Sword, scimitar', 5, 15),
(39, 'Sword, short', 3, 8),
(40, 'Sword, two-handed', 25, 30),
(41, 'Trident', 5, 4);

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
