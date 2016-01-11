-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: conquer_floor
-- ------------------------------------------------------
-- Server version	5.5.29

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
-- Table structure for table `timeline`
--

DROP TABLE IF EXISTS `timeline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timeline` (
  `idtimeline` int(11) NOT NULL AUTO_INCREMENT,
  `idaction` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `idround` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idfighter` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `order` int(11) DEFAULT '0',
  `turn` smallint(6) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `damage` tinyint(6) DEFAULT NULL,
  `critical` tinyint(1) DEFAULT NULL,
  `effective` tinyint(2) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `idclass` int(11) NOT NULL,
  `hp` smallint(6) NOT NULL,
  `color` tinyint(4) DEFAULT '0',
  `killspeech` varchar(100) DEFAULT NULL,
  `gender` smallint(1) DEFAULT NULL,
  `classhp` smallint(6) NOT NULL,
  `target_idfighter` int(11) NOT NULL,
  `target_name` varchar(45) NOT NULL,
  `target_iduser` int(11) NOT NULL,
  `target_idgame` int(11) NOT NULL,
  `target_type` tinyint(4) NOT NULL,
  `target_idclass` int(11) NOT NULL,
  `target_hp` smallint(6) NOT NULL,
  `target_status` tinyint(4) NOT NULL DEFAULT '0',
  `target_color` tinyint(4) DEFAULT '0',
  `target_lastwords` varchar(100) DEFAULT NULL,
  `target_gender` smallint(1) DEFAULT NULL,
  `target_classhp` smallint(6) NOT NULL,
  PRIMARY KEY (`idtimeline`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timeline`
--

LOCK TABLES `timeline` WRITE;
/*!40000 ALTER TABLE `timeline` DISABLE KEYS */;
INSERT INTO `timeline` VALUES (11,11,1,3,8,6,1,1,1,1,35,0,2,'Dark Abyss',1,4,17,2,'Die!',2,55,2,'Killa',1,1,2,2,80,1,1,'Nooo',1,80),(12,13,1,3,4,3,5,1,2,1,25,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,5,'Fiora',5,1,2,1,100,1,2,'Sorry for not being so strong',1,100),(13,14,1,3,4,3,5,2,2,1,0,0,1,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,5,'Fiora',5,1,2,1,75,1,2,'Sorry for not being so strong',1,100),(14,12,1,3,6,4,5,1,4,1,40,0,1,'Berseker',3,1,100,3,'Die!',2,100,5,'Fiora',5,1,2,1,75,1,2,'Sorry for not being so strong',1,100),(15,16,1,4,4,3,6,1,2,1,0,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,100,1,3,'This can\'t be happening..',2,100),(16,15,1,4,4,3,6,2,2,1,0,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,100,1,3,'This can\'t be happening..',2,100),(17,18,1,5,4,3,6,1,2,1,10,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,90,1,3,'This can\'t be happening..',2,100),(18,17,1,5,4,3,6,2,2,1,10,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,80,1,3,'This can\'t be happening..',2,100),(19,21,1,6,7,8,1,1,1,1,120,0,1,'Quimera',3,4,55,3,'Roooar',0,55,2,'Killa',1,1,2,2,0,1,1,'Nooo',1,80),(20,20,1,6,4,3,6,1,2,1,5,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,75,1,3,'This can\'t be happening..',2,100),(21,19,1,6,4,3,6,2,2,1,35,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,40,1,3,'This can\'t be happening..',2,100),(22,22,1,7,7,8,8,1,1,1,33,0,2,'Quimera',3,4,55,3,'Roooar',0,55,6,'Dark Abyss',8,1,1,4,0,1,2,'No',2,55),(23,23,1,7,4,3,6,1,2,1,5,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,35,1,3,'This can\'t be happening..',2,100),(24,24,1,7,4,3,6,2,2,1,5,0,0,'Slaking \"The Great\"',3,3,70,1,'Go in peace!',2,70,4,'Berseker',6,1,3,1,30,1,3,'This can\'t be happening..',2,100);
/*!40000 ALTER TABLE `timeline` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-10 19:46:08
