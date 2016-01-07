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
-- Table structure for table `fighters`
--

DROP TABLE IF EXISTS `fighters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fighters` (
  `idfighter` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `idclass` int(11) NOT NULL,
  `hp` smallint(6) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `color` tinyint(4) DEFAULT '0',
  `killspeech` varchar(100) DEFAULT NULL,
  `lastwords` varchar(100) DEFAULT NULL,
  `victoryspeech` varchar(100) DEFAULT NULL,
  `gender` smallint(1) DEFAULT NULL,
  `classhp` smallint(6) NOT NULL,
  PRIMARY KEY (`idfighter`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fighters`
--

LOCK TABLES `fighters` WRITE;
/*!40000 ALTER TABLE `fighters` DISABLE KEYS */;
INSERT INTO `fighters` VALUES (1,'Wolf',2,1,1,4,55,1,1,'Auuu!','au au au au...','Auuuuuuuuuuu!',0,55),(2,'Killa',1,1,2,2,80,1,1,'You fall!','Nooo','Hell yeah!',1,80),(3,'Slaking \"The Great\"',4,1,1,3,70,1,1,'Go in peace!','I\'m ready!','Wuju!',2,70);
/*!40000 ALTER TABLE `fighters` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-06 21:54:19
