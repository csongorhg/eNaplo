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
-- Dumping data for table enaplo.diak: ~4 rows (approximately)
/*!40000 ALTER TABLE `diak` DISABLE KEYS */;
INSERT INTO `diak` (`ID`, `NEV`, `osztalyID`) VALUES
	(1, 'János Péter', 1),
	(2, 'János Pali', 1),
	(3, 'János Petra', 1),
	(4, 'János Piter', 2);
/*!40000 ALTER TABLE `diak` ENABLE KEYS */;

-- Dumping data for table enaplo.jegy: ~0 rows (approximately)
/*!40000 ALTER TABLE `jegy` DISABLE KEYS */;
INSERT INTO `jegy` (`ID`, `diakID`, `tantargyID`, `JEGY`) VALUES
	(3, 2, 2, 3),
	(4, 3, 1, 4),
	(5, 1, 3, 5);
/*!40000 ALTER TABLE `jegy` ENABLE KEYS */;

-- Dumping data for table enaplo.osztaly: ~2 rows (approximately)
/*!40000 ALTER TABLE `osztaly` DISABLE KEYS */;
INSERT INTO `osztaly` (`ID`, `EVFOLYAM`, `BETU`, `KEZDES`, `SZAK`) VALUES
	(1, 13, 'A', 1222, 'Informatika'),
	(2, 13, 'B', 1222, 'Közgazdaság');
/*!40000 ALTER TABLE `osztaly` ENABLE KEYS */;

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
