-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Verzió:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for enaplo
CREATE DATABASE IF NOT EXISTS `enaplo` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci */;
USE `enaplo`;


-- Dumping structure for tábla enaplo.diak
CREATE TABLE IF NOT EXISTS `diak` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NEV` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '0',
  `osztalyID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- Dumping data for table enaplo.diak: ~4 rows (approximately)
/*!40000 ALTER TABLE `diak` DISABLE KEYS */;
INSERT INTO `diak` (`ID`, `NEV`, `osztalyID`) VALUES
	(1, 'János Péter', 1),
	(2, 'János Pali', 1),
	(3, 'János Petra', 1),
	(4, 'János Piter', 2);
/*!40000 ALTER TABLE `diak` ENABLE KEYS */;


-- Dumping structure for tábla enaplo.jegy
CREATE TABLE IF NOT EXISTS `jegy` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diakID` int(10) unsigned NOT NULL,
  `tantargyID` int(10) unsigned DEFAULT NULL,
  `JEGY` tinyint(4) NOT NULL,
  `DATUM` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tanevID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- Dumping data for table enaplo.jegy: ~4 rows (approximately)
/*!40000 ALTER TABLE `jegy` DISABLE KEYS */;
INSERT INTO `jegy` (`ID`, `diakID`, `tantargyID`, `JEGY`, `DATUM`, `tanevID`) VALUES
	(3, 2, 2, 3, '2017-02-16 08:33:24', 1),
	(4, 3, 1, 4, '2017-02-16 08:33:24', 1),
	(5, 1, 3, 5, '2017-02-16 08:33:24', 1),
	(6, 2, 1, 1, '2017-02-16 08:33:46', 1);
/*!40000 ALTER TABLE `jegy` ENABLE KEYS */;


-- Dumping structure for tábla enaplo.osztaly
CREATE TABLE IF NOT EXISTS `osztaly` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EVFOLYAM` tinyint(4) NOT NULL,
  `BETU` char(3) COLLATE utf8_hungarian_ci NOT NULL,
  `KEZDES` smallint(5) unsigned NOT NULL,
  `SZAK` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `AKTIV` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- Dumping data for table enaplo.osztaly: ~2 rows (approximately)
/*!40000 ALTER TABLE `osztaly` DISABLE KEYS */;
INSERT INTO `osztaly` (`ID`, `EVFOLYAM`, `BETU`, `KEZDES`, `SZAK`, `AKTIV`) VALUES
	(1, 13, 'A', 1222, 'Informatika', b'1'),
	(2, 13, 'B', 1222, 'Közgazdaság', b'1');
/*!40000 ALTER TABLE `osztaly` ENABLE KEYS */;


-- Dumping structure for tábla enaplo.tanev
CREATE TABLE IF NOT EXISTS `tanev` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tanev` tinytext COLLATE utf8_hungarian_ci,
  `kezdes` date DEFAULT NULL,
  `veg` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- Dumping data for table enaplo.tanev: ~0 rows (approximately)
/*!40000 ALTER TABLE `tanev` DISABLE KEYS */;
INSERT INTO `tanev` (`ID`, `tanev`, `kezdes`, `veg`) VALUES
	(1, '2016/17', '2016-09-01', '2017-06-15'),
	(2, '2015/16', '2015-09-01', '2016-06-15');
/*!40000 ALTER TABLE `tanev` ENABLE KEYS */;


-- Dumping structure for tábla enaplo.tanevdiak
CREATE TABLE IF NOT EXISTS `tanevdiak` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `diakID` int(11) NOT NULL DEFAULT '0',
  `tanevID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- Dumping data for table enaplo.tanevdiak: ~0 rows (approximately)
/*!40000 ALTER TABLE `tanevdiak` DISABLE KEYS */;
INSERT INTO `tanevdiak` (`ID`, `diakID`, `tanevID`) VALUES
	(1, 2, 1),
	(2, 1, 1),
	(3, 3, 1),
	(4, 1, 2);
/*!40000 ALTER TABLE `tanevdiak` ENABLE KEYS */;


-- Dumping structure for tábla enaplo.tantargy
CREATE TABLE IF NOT EXISTS `tantargy` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NEV` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- Dumping data for table enaplo.tantargy: ~3 rows (approximately)
/*!40000 ALTER TABLE `tantargy` DISABLE KEYS */;
INSERT INTO `tantargy` (`ID`, `NEV`) VALUES
	(1, 'Matek'),
	(2, 'Magyar'),
	(3, 'Szakmai');
/*!40000 ALTER TABLE `tantargy` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
