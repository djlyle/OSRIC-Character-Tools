-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2015 at 11:23 PM
-- Server version: 5.5.41
-- PHP Version: 5.3.10-1ubuntu3.15

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
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `CharacterName` varchar(255) NOT NULL,
  `CharacterGender` int(11) NOT NULL,
  `CharacterAge` float NOT NULL,
  `CharacterHeight` float NOT NULL,
  `CharacterWeight` float NOT NULL,
  `CharacterId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CharacterArmorClass` int(11) NOT NULL,
  `CharacterFullHitPoints` int(11) NOT NULL,
  `CharacterRemainingHitPoints` int(11) NOT NULL,
  `CharacterExperiencePoints` int(11) NOT NULL,
  `CharacterLevel` int(11) NOT NULL,
  `CharacterAlignment` int(11) NOT NULL,
  PRIMARY KEY (`CharacterId`),
  UNIQUE KEY `Id` (`CharacterId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`CharacterName`, `CharacterGender`, `CharacterAge`, `CharacterHeight`, `CharacterWeight`, `CharacterId`, `CharacterArmorClass`, `CharacterFullHitPoints`, `CharacterRemainingHitPoints`, `CharacterExperiencePoints`, `CharacterLevel`, `CharacterAlignment`) VALUES
('Roland', 1, 43, 65, 141, 1, 0, 0, 0, 0, 0, 0),
('Broomhelda', 2, 26, 62, 123, 3, 0, 0, 0, 0, 0, 0),
('Oscar', 1, 98, 34, 95, 4, 0, 0, 0, 0, 0, 0),
('Laura', 2, 32, 62, 123, 5, 0, 0, 0, 0, 0, 0),
('Dirk Smirk', 1, 30, 70, 180, 6, 0, 0, 0, 0, 0, 0),
('Gary', 1, 78, 76, 164, 7, 0, 0, 0, 0, 0, 0),
('Stuart', 1, 22, 69, 160, 9, 0, 0, 0, 0, 0, 0),
('d3', 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0),
('d111', 0, 0, 0, 0, 17, 0, 0, 0, 0, 0, 0),
('d222', 0, 0, 0, 0, 18, 0, 0, 0, 0, 0, 0),
('d2223', 0, 0, 0, 0, 19, 0, 0, 0, 0, 0, 0),
('d655', 0, 0, 0, 0, 20, 0, 0, 0, 0, 0, 0),
('ddd', 0, 0, 0, 0, 21, 0, 0, 0, 0, 0, 0),
('d222556', 0, 0, 0, 0, 22, 0, 0, 0, 0, 0, 0),
('d222556', 0, 0, 0, 0, 23, 0, 0, 0, 0, 0, 0),
('l1', 0, 0, 0, 0, 24, 0, 0, 0, 0, 0, 0),
('l2', 0, 0, 0, 0, 25, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `character_abilities`
--

CREATE TABLE IF NOT EXISTS `character_abilities` (
  `CharacterId` bigint(20) NOT NULL,
  `CharacterAbilityStrength` float NOT NULL,
  `CharacterAbilityDexterity` float NOT NULL,
  `CharacterAbilityConstitution` float NOT NULL,
  `CharacterAbilityIntelligence` float NOT NULL,
  `CharacterAbilityWisdom` float NOT NULL,
  `CharacterAbilityCharisma` float NOT NULL,
  PRIMARY KEY (`CharacterId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(0, 1, 0),
(0, 2, 0),
(0, 3, 0),
(0, 4, 0),
(0, 5, 0),
(1, 1, 2),
(24, 1, 0),
(24, 2, 0),
(24, 3, 0),
(24, 4, 0),
(24, 5, 0),
(25, 1, 10),
(25, 2, 1),
(25, 3, 0),
(25, 4, 0),
(25, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `character_items`
--

CREATE TABLE IF NOT EXISTS `character_items` (
  `CharacterId` bigint(20) NOT NULL,
  `ItemId` bigint(20) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`CharacterId`,`ItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `character_items`
--

INSERT INTO `character_items` (`CharacterId`, `ItemId`, `Quantity`) VALUES
(1, 1, 1),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(1, 8, 0),
(1, 9, 0),
(1, 10, 0),
(1, 11, 0),
(1, 12, 0),
(1, 13, 0),
(1, 14, 0),
(1, 15, 0),
(1, 16, 0),
(1, 17, 0),
(1, 18, 0),
(1, 19, 0),
(1, 20, 0),
(1, 21, 0),
(1, 22, 0),
(1, 23, 0),
(1, 24, 0),
(1, 25, 0),
(1, 26, 0),
(1, 27, 0),
(1, 28, 0),
(1, 29, 0),
(1, 30, 0),
(1, 31, 0),
(1, 32, 0),
(1, 33, 0),
(1, 34, 0),
(1, 35, 0),
(1, 36, 0),
(1, 37, 0),
(1, 38, 0),
(1, 39, 0),
(1, 40, 0),
(1, 41, 0),
(1, 42, 0),
(1, 43, 0),
(1, 44, 0),
(1, 45, 0),
(1, 46, 0),
(1, 47, 0),
(1, 48, 0),
(1, 49, 0),
(1, 50, 0),
(1, 51, 0),
(1, 52, 0),
(1, 53, 0),
(1, 54, 0),
(1, 55, 0),
(1, 56, 0),
(1, 57, 0),
(1, 58, 0),
(1, 59, 0),
(1, 60, 0),
(1, 61, 0),
(1, 62, 0),
(1, 63, 0),
(1, 64, 0),
(1, 65, 0),
(1, 66, 0),
(1, 67, 0),
(1, 68, 0),
(1, 69, 0),
(1, 70, 0),
(1, 71, 0),
(1, 72, 0),
(1, 73, 0),
(1, 74, 0),
(1, 75, 0),
(1, 76, 0),
(1, 77, 0),
(1, 78, 0),
(1, 79, 0),
(1, 80, 0),
(1, 81, 0),
(1, 82, 0),
(1, 83, 0),
(1, 84, 0),
(1, 85, 0),
(1, 86, 0),
(1, 87, 0),
(1, 88, 0),
(1, 89, 0),
(1, 90, 0),
(1, 91, 0),
(1, 92, 0),
(1, 93, 0),
(1, 94, 0),
(1, 95, 0),
(1, 96, 0),
(1, 97, 0),
(1, 98, 0),
(1, 99, 0),
(1, 100, 0),
(1, 101, 0),
(1, 102, 0),
(1, 103, 0),
(1, 104, 0),
(1, 105, 0),
(1, 106, 0),
(1, 107, 0),
(3, 1, 9),
(3, 5, 1),
(3, 10, 1),
(3, 12, 1),
(3, 34, 1),
(5, 1, 6),
(5, 2, 1),
(5, 3, 5),
(5, 4, 6),
(5, 5, 7),
(5, 6, 6),
(9, 1, 16),
(9, 2, 1),
(9, 7, 1),
(9, 35, 1),
(9, 38, 1),
(9, 40, 3),
(9, 44, 1),
(9, 45, 5),
(9, 48, 12),
(9, 51, 1),
(9, 56, 1),
(9, 57, 5),
(9, 61, 2),
(9, 80, 1),
(9, 83, 1),
(9, 95, 1),
(9, 97, 4),
(9, 98, 1),
(9, 104, 1),
(9, 105, 2);

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
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ItemName` varchar(64) DEFAULT NULL,
  `ItemEncumbrance` float NOT NULL,
  `ItemCost` float NOT NULL,
  `ItemId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ItemId`),
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
