-- MySQL dump 10.13  Distrib 8.0.21, for macos10.15 (x86_64)
--
-- Host: 127.0.0.1    Database: vanzhin_test
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `big_link` varchar(255) DEFAULT NULL,
  `small_link` varchar(255) DEFAULT NULL,
  `size` int unsigned DEFAULT NULL,
  `likes` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'02.jpg','/Applications/MAMP/htdocs/gallery_img/big/02.jpg','/Applications/MAMP/htdocs/gallery_img/small/02.jpg',70076,1),(2,'03.jpg','/Applications/MAMP/htdocs/gallery_img/big/03.jpg','/Applications/MAMP/htdocs/gallery_img/small/03.jpg',70215,0),(3,'04.jpg','/Applications/MAMP/htdocs/gallery_img/big/04.jpg','/Applications/MAMP/htdocs/gallery_img/small/04.jpg',61733,0),(4,'05.jpg','/Applications/MAMP/htdocs/gallery_img/big/05.jpg','/Applications/MAMP/htdocs/gallery_img/small/05.jpg',160617,0),(5,'06.jpg','/Applications/MAMP/htdocs/gallery_img/big/06.jpg','/Applications/MAMP/htdocs/gallery_img/small/06.jpg',89871,0),(6,'07.jpg','/Applications/MAMP/htdocs/gallery_img/big/07.jpg','/Applications/MAMP/htdocs/gallery_img/small/07.jpg',99418,0),(7,'08.jpg','/Applications/MAMP/htdocs/gallery_img/big/08.jpg','/Applications/MAMP/htdocs/gallery_img/small/08.jpg',103775,0),(8,'09.jpg','/Applications/MAMP/htdocs/gallery_img/big/09.jpg','/Applications/MAMP/htdocs/gallery_img/small/09.jpg',81022,0),(9,'10.jpg','/Applications/MAMP/htdocs/gallery_img/big/10.jpg','/Applications/MAMP/htdocs/gallery_img/small/10.jpg',97127,0),(10,'11.jpg','/Applications/MAMP/htdocs/gallery_img/big/11.jpg','/Applications/MAMP/htdocs/gallery_img/small/11.jpg',98579,0),(11,'12.jpg','/Applications/MAMP/htdocs/gallery_img/big/12.jpg','/Applications/MAMP/htdocs/gallery_img/small/12.jpg',139286,0),(12,'13.jpg','/Applications/MAMP/htdocs/gallery_img/big/13.jpg','/Applications/MAMP/htdocs/gallery_img/small/13.jpg',113016,0),(13,'14.jpg','/Applications/MAMP/htdocs/gallery_img/big/14.jpg','/Applications/MAMP/htdocs/gallery_img/small/14.jpg',151814,0),(14,'15.jpg','/Applications/MAMP/htdocs/gallery_img/big/15.jpg','/Applications/MAMP/htdocs/gallery_img/small/15.jpg',112488,0),(22,'01.jpg','/Applications/MAMP/htdocs/gallery_img/big/01.jpg','/Applications/MAMP/htdocs/gallery_img/small/01.jpg',111456,0),(24,'13-334.jpg','/Applications/MAMP/htdocs/gallery_img/big/13-334.jpg','/Applications/MAMP/htdocs/gallery_img/small/13-334.jpg',90068,3);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-27 16:43:38
