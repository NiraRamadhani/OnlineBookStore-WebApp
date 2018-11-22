-- MySQL dump 10.13  Distrib 5.7.21, for osx10.13 (x86_64)
--
-- Host: localhost    Database: probooks
-- ------------------------------------------------------
-- Server version	8.0.13

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'Nota Hidup','Light R. D. B.','Buku ajaib yang berisi nama-nama orang terpilih. Jika namamu tertulis di buku ini maka kamu adalah salah satu orang yang beruntung.','public/img/book/nota_hidup.png'),(2,'Bis Fantastis dan Cara Menemukannya','JK Rowling','Buku ini adalah buku ajaib yang berisi tentang dongeng=dongeng di masa lampau. Salah satu cerita dari buku ini adalah tentang bis ajaib.','public/img/book/fantastis_bis.png'),(3,'Database System Concepts','Avi Silberschatz','Database System Concepts, by Abraham Silberschatz and Hank Korth, is a classic textbook on database systems. It is often called the sailboat book, because its first edition had on its cover a number of sailboats, labelled with the names of various database models.','public/img/book/database.jpeg'),(4,'Computer Networks: A Systems Approach','Larry L. Peterson','New to the edition is a downloadable network simulation lab manual that allows students to visualize and experiment with core networking technologies in direct coordination with the book\'s discussion.','public/img/book/jarkom.jpeg');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordering`
--

DROP TABLE IF EXISTS `ordering`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordering` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `bookid` int(10) unsigned DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ordering_book` (`bookid`),
  KEY `FK_ordering_user` (`username`),
  CONSTRAINT `FK_ordering_book` FOREIGN KEY (`bookid`) REFERENCES `book` (`id`),
  CONSTRAINT `FK_ordering_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordering`
--

LOCK TABLES `ordering` WRITE;
/*!40000 ALTER TABLE `ordering` DISABLE KEYS */;
INSERT INTO `ordering` VALUES (27,'tayotayo',1,4,'2018-10-21'),(28,'tayotayo',1,4,'2018-10-21'),(29,'tayotayo',1,2,'2018-10-21'),(30,'tayotayo',1,2,'2018-10-21'),(31,'tayotayo',1,1,'2018-10-21'),(32,'tayotayo',1,1,'2018-10-21'),(33,'tayotayo',1,5,'2018-10-22'),(34,'tayotayo',1,5,'2018-10-22'),(35,'tayotayo',1,3,'2018-10-22'),(36,'tayotayo',1,3,'2018-10-22'),(37,'tayotayo',1,4,'2018-10-22'),(38,'tayotayo',1,5,'2018-10-25'),(39,'tayotayo',2,3,'2018-10-25'),(40,'gas',2,1,'2018-10-25'),(41,'gas',1,1,'2018-10-25'),(42,'tayotayo',2,2,'2018-10-25'),(43,'tayotayo',1,4,'2018-10-25'),(44,'tayotayo',1,1,'2018-10-25'),(45,'tayotayo',1,3,'2018-10-25'),(46,'tayotayo',2,1,'2018-10-25'),(47,'tayotayo',2,1,'2018-10-25'),(48,'tayotayo',2,1,'2018-10-25'),(49,'tayotayo',2,1,'2018-10-25'),(50,'tayotayo',2,1,'2018-10-25'),(51,'tayotayo',2,1,'2018-10-25'),(52,'tayotayo',2,1,'2018-10-25'),(53,'tayotayo',2,1,'2018-10-25'),(54,'tayotayo',2,1,'2018-10-25'),(55,'gas',2,3,'2018-10-26'),(56,'gas',3,1,'2018-10-26'),(57,'gas',3,2,'2018-10-26'),(58,'gas',4,3,'2018-10-26'),(59,'tayotayo',4,1,'2018-10-26'),(60,'tayotayo',4,1,'2018-10-26'),(61,'tayotayo',3,3,'2018-10-26'),(62,'tayotayo',1,4,'2018-10-26'),(63,'hayo',2,1,'2018-10-26'),(64,'hayo',2,1,'2018-10-26'),(65,'hayo',2,1,'2018-10-26'),(66,'hayo',3,1,'2018-10-26'),(67,'tayotayo',2,1,'2018-10-27'),(68,'tayotayo',3,1,'2018-10-27'),(69,'tayotayo',3,1,'2018-10-27'),(70,'tayotayo',3,1,'2018-10-27'),(71,'tayotayo',1,1,'2018-10-29'),(72,'tayotayo',2,1,'2018-10-29'),(73,'tayotayo',2,1,'2018-10-29'),(74,'tayotayo',2,1,'2018-10-29'),(75,'tayotayo',2,1,'2018-10-29'),(76,'tayotayo',2,1,'2018-10-29'),(77,'tayotayo',2,1,'2018-10-29'),(78,'tayotayo',1,1,'2018-10-29'),(79,'tayotayo',1,1,'2018-10-29'),(80,'tayotayo',1,1,'2018-10-29'),(81,'tayotayo',1,1,'2018-10-29'),(82,'tayotayo',1,1,'2018-10-29'),(83,'tayotayo',1,1,'2018-10-29'),(84,'tayotayo',1,1,'2018-10-29'),(85,'tayotayo',1,1,'2018-10-29'),(86,'tayotayo',1,1,'2018-10-29'),(87,'tayotayo',2,1,'2018-10-29'),(88,'tayotayo',2,1,'2018-10-29'),(89,'tayotayo',2,1,'2018-10-29'),(90,'tayotayo',2,1,'2018-10-29'),(91,'tayotayo',2,1,'2018-10-29'),(92,'tayotayo',1,1,'2018-10-29'),(93,'tayotayo',1,1,'2018-10-29'),(94,'tayotayo',2,1,'2018-10-31'),(95,'tayotayo',2,1,'2018-10-31'),(96,'tayotayo',2,1,'2018-10-31'),(97,'tayotayo',2,1,'2018-10-31'),(98,'kevin',4,2,'2018-10-31'),(99,'kevin',4,1,'2018-10-31');
/*!40000 ALTER TABLE `ordering` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(11) unsigned NOT NULL,
  `content` text,
  `rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_review_ordering` (`orderid`),
  CONSTRAINT `FK_review_ordering` FOREIGN KEY (`orderid`) REFERENCES `ordering` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (1,28,'lalalalalalala',4),(2,27,'yihaaaaa ehehehehehehehehehehe',3),(3,37,'test',5),(4,36,'test',5),(5,35,'hehe',5),(6,33,'ew jelek',1),(7,34,'jelek',1),(8,38,'HALO INI REVIEW YANG BARU',5),(9,39,'HAHAAA',5),(10,40,'GAAAAASSSS',5),(11,41,'a',5),(12,42,'WOWW aku jadi bisa sihir',5),(13,30,'test',5),(14,32,'haha',5),(15,46,'Mantap boi',5),(16,54,'Buruq\r\n',1),(17,55,'Buku mantap',4),(18,56,'Aku jadi tercerdaskan',5),(19,58,'MANTAP PA DODY',4),(20,59,'2 3 Mahasiswa Bolos\r\nLOSSSS',5),(21,62,'a',5),(22,61,'test',5),(23,66,'test',4),(24,98,'BAGUSS',5);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('AlifArifin','Alif','dodymanadody','m.alif.arifin@g','Indonesia','081312223644','default.jpg'),('BigTayo','1234','Tayo Bis Besar','088888888888','Terminal Cicaheum','BigTayo@BigBuss.com','public/img/profpic/default.jpg'),('gas','gas','Ngegas','6666666666','pertamina','gas@lpg.com','public/img/profpic/download.jpeg'),('HAHA','haha','HAHA','1234567890','123','HAHA@HAHhAHA.com','public/img/profpic/default.jpg'),('Hahaha','haha','Cek','08123456789','haha','haha@hahahha.com','public/img/profpic/default.jpg'),('hai','haha','HAHAHA','081221676227','123','hai@haha.com','public/img/profpic/default.jpg'),('haihai','ha','Rahmat Santosa','801239183981','ha','hai@hahaa.com','public/img/profpic/default.jpg'),('hayo','haha','Hayoloh','08123456789','hahaha','hayo@hayo.com','public/img/profpic/Rahmat.png'),('Ilma Alifia','yipi','Ilma Alifia Mahardika','081234567890','Bandung','ilma@gmail.com','public/img/nota_hidup.png'),('kevin','abcd','bebas','123032423','asbdjsbd','haha@haha.com','public/img/profpic/IMG_3002.JPG'),('tayotayo','yipi','Bernat','81234567890','Di Hatimu','tayo@littlebus.com','public/img/profpic/IMG_3002.JPG');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-22 15:19:44
