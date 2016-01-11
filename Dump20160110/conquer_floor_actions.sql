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
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `idaction` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`idaction`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (4,1,1,2,1,1,2,1,0,70,NULL,NULL),(5,1,1,6,4,2,1,4,0,33,NULL,NULL),(6,1,1,5,5,1,2,4,0,60,NULL,NULL),(7,1,1,8,6,6,1,1,0,100,NULL,NULL),(8,1,2,9,7,8,1,1,1,38,0,2),(9,1,2,6,4,9,1,4,1,65,0,0),(10,1,2,7,8,2,2,1,1,75,1,2),(11,1,3,8,6,1,1,1,1,35,0,2),(12,1,3,6,4,5,1,4,1,40,0,1),(13,1,3,4,3,5,2,2,1,25,0,0),(14,1,3,4,3,5,1,2,1,0,0,1),(15,1,4,4,3,6,2,2,1,0,0,0),(16,1,4,4,3,6,1,2,1,0,0,0),(17,1,5,4,3,6,2,2,1,10,0,0),(18,1,5,4,3,6,1,2,1,10,0,0),(19,1,6,4,3,6,2,2,1,35,0,0),(20,1,6,4,3,6,1,2,1,5,0,0),(21,1,6,7,8,1,1,1,1,120,0,1),(22,1,7,7,8,8,1,1,1,33,0,2),(23,1,7,4,3,6,1,2,1,5,0,0),(24,1,7,4,3,6,2,2,1,5,0,0),(25,1,8,4,3,7,0,0,0,35,0,0),(26,1,8,4,3,5,0,0,0,20,0,1),(27,1,8,5,5,4,0,0,0,30,0,2);
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
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
