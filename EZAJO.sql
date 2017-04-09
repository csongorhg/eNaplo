CREATE DATABASE  IF NOT EXISTS `enaplov2` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_icelandic_ci */;
USE `enaplov2`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: enaplov2
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `diak`
--

DROP TABLE IF EXISTS `diak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nev` tinytext COLLATE utf8_hungarian_ci,
  `szuletes` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diak`
--

LOCK TABLES `diak` WRITE;
/*!40000 ALTER TABLE `diak` DISABLE KEYS */;
INSERT INTO `diak` VALUES (1,'Péter Kalapács','1999-02-13'),(2,'Kalap Ernő','1999-11-01'),(3,'József Béla','1999-12-22');
/*!40000 ALTER TABLE `diak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evfolyam`
--

DROP TABLE IF EXISTS `evfolyam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evfolyam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanevid` int(11) DEFAULT NULL,
  `osztalyid` int(11) DEFAULT NULL,
  `diakid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`diakid`),
  CONSTRAINT `id` FOREIGN KEY (`diakid`) REFERENCES `diak` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_icelandic_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evfolyam`
--

LOCK TABLES `evfolyam` WRITE;
/*!40000 ALTER TABLE `evfolyam` DISABLE KEYS */;
INSERT INTO `evfolyam` VALUES (1,1,3,1),(2,1,4,2),(3,1,1,3);
/*!40000 ALTER TABLE `evfolyam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jegy`
--

DROP TABLE IF EXISTS `jegy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jegy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evfolyamid` int(11) DEFAULT NULL,
  `jegy` tinyint(2) DEFAULT NULL,
  `tanarid` int(11) DEFAULT NULL,
  `tantargyid` int(11) DEFAULT NULL,
  `datum` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`evfolyamid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_icelandic_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jegy`
--

LOCK TABLES `jegy` WRITE;
/*!40000 ALTER TABLE `jegy` DISABLE KEYS */;
INSERT INTO `jegy` VALUES (1,1,5,1,1,'2017-06-15 00:00:00'),(2,1,4,2,2,'2017-05-16 00:00:00'),(3,2,4,1,1,'2017-03-18 00:00:00'),(4,2,3,2,2,'2017-02-11 00:00:00'),(5,1,3,1,1,'2017-01-01 00:00:00'),(6,1,2,2,3,'2017-03-15 21:35:50'),(7,3,4,1,4,'2017-03-18 14:22:30'),(8,3,2,2,1,'2017-05-18 14:22:30'),(9,3,2,1,1,'2016-09-15 00:00:00'),(10,3,2,1,1,'2016-09-15 00:00:00'),(11,3,5,2,3,'2017-01-19 13:40:17'),(12,2,2,1,1,'2017-03-15 00:00:00');
/*!40000 ALTER TABLE `jegy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osztaly`
--

DROP TABLE IF EXISTS `osztaly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osztaly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `szam` int(11) DEFAULT NULL,
  `betu` tinytext COLLATE utf8_hungarian_ci,
  `szakid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osztaly`
--

LOCK TABLES `osztaly` WRITE;
/*!40000 ALTER TABLE `osztaly` DISABLE KEYS */;
INSERT INTO `osztaly` VALUES (1,9,'A',1),(2,9,'B',1),(3,9,'C',2),(4,9,'D',2);
/*!40000 ALTER TABLE `osztaly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `szak`
--

DROP TABLE IF EXISTS `szak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `szak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `szak` tinytext CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_icelandic_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `szak`
--

LOCK TABLES `szak` WRITE;
/*!40000 ALTER TABLE `szak` DISABLE KEYS */;
INSERT INTO `szak` VALUES (1,'kozg'),(2,'info'),(3,'nyelvi');
/*!40000 ALTER TABLE `szak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanar`
--

DROP TABLE IF EXISTS `tanar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tanar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nev` varchar(45) COLLATE utf8_icelandic_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_icelandic_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanar`
--

LOCK TABLES `tanar` WRITE;
/*!40000 ALTER TABLE `tanar` DISABLE KEYS */;
INSERT INTO `tanar` VALUES (1,'Tóth Ernő'),(2,'Varga Aladár');
/*!40000 ALTER TABLE `tanar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanev`
--

DROP TABLE IF EXISTS `tanev`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tanev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanev` tinytext COLLATE utf8_hungarian_ci,
  `kezdet` int(11) DEFAULT NULL,
  `veg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanev`
--

LOCK TABLES `tanev` WRITE;
/*!40000 ALTER TABLE `tanev` DISABLE KEYS */;
INSERT INTO `tanev` VALUES (1,'2016/2017',2016,2017);
/*!40000 ALTER TABLE `tanev` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tantargy`
--

DROP TABLE IF EXISTS `tantargy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tantargy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nev` varchar(45) COLLATE utf8_icelandic_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_icelandic_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tantargy`
--

LOCK TABLES `tantargy` WRITE;
/*!40000 ALTER TABLE `tantargy` DISABLE KEYS */;
INSERT INTO `tantargy` VALUES (1,'Matek'),(2,'Programozás'),(3,'Ügyvitel'),(4,'Közg.');
/*!40000 ALTER TABLE `tantargy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tantargyszak`
--

DROP TABLE IF EXISTS `tantargyszak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tantargyszak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tantargyid` int(11) DEFAULT NULL,
  `szakid` tinytext CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_icelandic_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tantargyszak`
--

LOCK TABLES `tantargyszak` WRITE;
/*!40000 ALTER TABLE `tantargyszak` DISABLE KEYS */;
INSERT INTO `tantargyszak` VALUES (1,1,'1'),(2,1,'2'),(3,1,'3'),(4,2,'2'),(5,3,'1'),(6,4,'1');
/*!40000 ALTER TABLE `tantargyszak` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-25 18:58:07
