-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2015 at 12:31 AM
-- Server version: 5.5.41
-- PHP Version: 5.3.10-1ubuntu3.16

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`CharacterName`, `CharacterGender`, `CharacterAge`, `CharacterHeight`, `CharacterWeight`, `CharacterId`, `CharacterAlignment`, `RaceId`) VALUES
('R1', 1, 21, 60, 135, 45, 0, 3),
('R2', 2, 22, 59, 130, 46, 0, 1),
('R3', 1, 2, 3, 1, 50, 0, 6),
('R4', 0, 1, 3, 2, 51, 0, 2),
('R5', 1, 3, 1, 1, 52, 0, 0),
('R7', 1, 37, 66, 140, 54, 0, 5);

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
(45, 1, 111),
(45, 2, 222),
(45, 3, 333),
(45, 4, 444),
(45, 5, 555),
(45, 6, 666),
(46, 1, 22),
(46, 2, 22),
(46, 3, 44),
(46, 4, 55),
(46, 5, 3),
(46, 6, 2),
(50, 1, 8),
(50, 2, 14),
(50, 3, 19),
(50, 4, 18),
(50, 5, 17),
(50, 6, 22),
(51, 1, 3),
(51, 2, 4),
(51, 3, 5),
(51, 4, 6),
(51, 5, 7),
(51, 6, 8),
(52, 1, 0),
(52, 2, 0),
(52, 3, 0),
(52, 4, 0),
(52, 5, 0),
(52, 6, 0),
(54, 1, 9),
(54, 2, 4),
(54, 3, 3),
(54, 4, 3),
(54, 5, 2),
(54, 6, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `character_armour`
--

INSERT INTO `character_armour` (`CharacterArmourId`, `CharacterId`, `ArmourId`, `Quantity`, `ArmourMagic`, `EquipmentStatusId`) VALUES
(1, 45, 1, 4, 4, 1),
(2, 45, 2, 4, 1, 1),
(3, 45, 4, 5, 9, 1),
(4, 45, 7, 6, 2, 1),
(5, 45, 9, 6, 8, 1),
(6, 51, 1, 2, 4, 1),
(7, 50, 3, 1, 0, 1),
(8, 51, 2, 3, 5, 1),
(9, 52, 1, 2, 3, 1),
(10, 52, 2, 1, 4, 1),
(11, 53, 1, 1, 0, 1),
(12, 54, 4, 7, 2, 2),
(13, 54, 5, 2, 4, 3),
(14, 54, 1, 1, 1, 3),
(15, 54, 2, 1, 1, 1),
(16, 55, 1, 4, 1, 3),
(17, 55, 2, 1, 2, 2),
(18, 55, 3, 1, 0, 1),
(19, 54, 3, 2, 4, 2),
(20, 54, 7, 4, 3, 3),
(21, 55, 11, 2, 0, 1),
(22, 55, 12, 2, 0, 1),
(23, 56, 6, 1, 0, 3),
(24, 56, 7, 1, 0, 1),
(25, 56, 8, 1, 0, 2),
(26, 54, 13, 1, 3, 2);

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
(50, 2),
(50, 7),
(46, 1),
(46, 5),
(45, 3),
(45, 7),
(51, 3),
(54, 4);

-- --------------------------------------------------------

--
-- Table structure for table `character_coins`
--

CREATE TABLE IF NOT EXISTS `character_coins` (
  `CharacterId` bigint(20) NOT NULL,
  `CoinId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`CharacterId`,`CoinId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_coins`
--

INSERT INTO `character_coins` (`CharacterId`, `CoinId`, `Quantity`) VALUES
(45, 1, 13),
(45, 2, 31),
(45, 3, 13),
(45, 4, 31),
(45, 5, 13),
(46, 1, 2),
(46, 2, 3),
(46, 3, 4),
(46, 4, 5),
(46, 5, 22),
(50, 1, 2),
(50, 2, 1),
(50, 3, 2),
(50, 4, 1),
(50, 5, 2),
(51, 1, 3),
(51, 2, 4),
(51, 3, 5),
(51, 4, 6),
(51, 5, 7),
(52, 1, 3),
(52, 2, 3),
(52, 3, 4),
(52, 4, 5),
(52, 5, 6),
(54, 1, 8),
(54, 2, 9),
(54, 3, 9),
(54, 4, 8),
(54, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `character_items`
--

CREATE TABLE IF NOT EXISTS `character_items` (
  `CharacterItemId` bigint(20) NOT NULL AUTO_INCREMENT,
  `CharacterId` bigint(20) NOT NULL,
  `ItemId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`CharacterItemId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `character_items`
--

INSERT INTO `character_items` (`CharacterItemId`, `CharacterId`, `ItemId`, `Quantity`) VALUES
(1, 45, 1, 6),
(2, 45, 7, 5),
(3, 45, 9, 4),
(4, 46, 1, 1),
(5, 46, 9, 1),
(6, 46, 12, 1),
(7, 50, 2, 1),
(8, 51, 1, 4),
(9, 51, 2, 3),
(10, 52, 1, 1),
(11, 52, 4, 1),
(12, 54, 3, 3),
(13, 54, 4, 3),
(14, 54, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `character_status`
--

CREATE TABLE IF NOT EXISTS `character_status` (
  `CharacterId` bigint(20) NOT NULL,
  `CharacterStatusArmorClass` int(11) NOT NULL,
  `CharacterStatusExperiencePoints` int(11) NOT NULL,
  `CharacterStatusLevel` int(11) NOT NULL,
  `CharacterStatusFullHitPoints` int(11) NOT NULL,
  `CharacterStatusRemainingHitPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_status`
--

INSERT INTO `character_status` (`CharacterId`, `CharacterStatusArmorClass`, `CharacterStatusExperiencePoints`, `CharacterStatusLevel`, `CharacterStatusFullHitPoints`, `CharacterStatusRemainingHitPoints`) VALUES
(45, 3, 1, 1, 5, 2),
(46, 3, 2, 1, 3, 1),
(50, 1, 1, 1, 1, 1),
(51, 1, 1, 1, 1, 1),
(52, 0, 0, 0, 0, 0),
(54, 1, 6000, 2, 9, 6);

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
  `EquipmentStatusId` int(11) NOT NULL,
  PRIMARY KEY (`CharacterWeaponId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `character_weapons`
--

INSERT INTO `character_weapons` (`CharacterWeaponId`, `CharacterId`, `WeaponId`, `Quantity`, `WeaponMagic`, `EquipmentStatusId`) VALUES
(1, 52, 1, 2, 4, 0),
(2, 52, 2, 1, 5, 0),
(3, 52, 6, 7, 6, 0),
(4, 52, 7, 5, 4, 0),
(5, 52, 8, 3, 0, 0),
(6, 53, 1, 1, 0, 0),
(7, 53, 5, 2, 0, 0),
(8, 53, 27, 1, 0, 0),
(9, 53, 28, 1, 0, 0),
(10, 54, 2, 3, 2, 1),
(11, 54, 4, 3, 2, 1),
(12, 54, 6, 1, 2, 1),
(13, 54, 11, 1, 3, 1),
(14, 55, 1, 3, 1, 2),
(15, 55, 2, 1, 0, 1),
(16, 55, 6, 1, 2, 2),
(17, 55, 8, 1, 3, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `equipment_status`
--

INSERT INTO `equipment_status` (`EquipmentStatusId`, `EquipmentStatus`) VALUES
(1, 'In storage'),
(2, 'Carried'),
(3, 'In Use (worn\\wielded)');

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
  KEY `WeaponId` (`WeaponId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `RateOfFire` int(11) NOT NULL,
  `RangeInFt` int(11) NOT NULL,
  KEY `WeaponId` (`WeaponId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
