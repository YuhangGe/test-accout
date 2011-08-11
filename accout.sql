-- MySQL dump 10.13  Distrib 5.5.15, for Win32 (x86)
--
-- Host: localhost    Database: accout
-- ------------------------------------------------------
-- Server version	5.5.15

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
-- Table structure for table `accouts`
--

DROP TABLE IF EXISTS `accouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` int(11) unsigned NOT NULL COMMENT '对应的标签id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '账户名',
  `password` varchar(255) NOT NULL COMMENT '账户密码',
  `describe` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '对账户的描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1 COMMENT='保存标签对应的账户密码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accouts`
--

LOCK TABLES `accouts` WRITE;
/*!40000 ALTER TABLE `accouts` DISABLE KEYS */;
INSERT INTO `accouts` VALUES (34,1,'cdsdsd','dwfsd','dsafasf'),(35,1,'yunqian-02','taobao','卖家账户卖家账户卖家账户卖家账户'),(36,1,'yunqian-03','taobao',NULL),(37,4,'alice','abe','买家账户'),(38,4,'daisy','good',NULL),(39,4,'yini','abraham','     '),(40,2,'daisy','daisy','卖家账户'),(41,2,'alice','alice','买家账户'),(42,3,'abe','abraham',NULL),(43,3,'abraham','abe','卖家账户'),(44,3,'daisy','daisy','     '),(45,5,'abe','abe',NULL),(46,5,'yuhang','abe',NULL),(47,6,'yini','yini','爱你爱你爱你！！！！'),(48,6,'yini','yini','dsadfasf'),(49,7,'a','b','cc'),(50,8,'a','b',''),(51,8,'c','dsf','dasfsf'),(52,9,'dsa','dfwfds','dafasf'),(54,9,'alice','alice','love alice'),(55,9,'daisy','daisy','love daisy'),(56,9,'伊妮','yini','fsfsfdsafdasdfsfsf'),(57,12,'长长长长长长长长长','djsljflasjfklsjafkljaslfjaslfkjlasdf','asfasdfddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd'),(58,11,'a','b','c');
/*!40000 ALTER TABLE `accouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labels`
--

DROP TABLE IF EXISTS `labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '标签名称',
  `type` tinyint(4) NOT NULL COMMENT '标签类型.\n0:个人标签\n1：项目标签',
  `describe` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '对标签的描述',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labels`
--

LOCK TABLES `labels` WRITE;
/*!40000 ALTER TABLE `labels` DISABLE KEYS */;
INSERT INTO `labels` VALUES (1,'yunqian',0,'云谦的个人测试账户'),(2,'demo',1,'测试项目'),(3,'daisy',1,'my love girl'),(4,'alice',0,'羽航的测试账户'),(5,'羽航',0,'不解释'),(6,'伊妮',0,'啊啊啊啊啊啊啊啊啊啊啊啊'),(7,'aa',0,'describe'),(8,'dsd',0,'dasfdasf'),(9,'love you',1,'love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,love you,'),(10,'love daisy',1,'love daisy.love daisy.love daisy.love daisy.love daisy.love daisy.'),(11,'love alice',1,'dsfsfsdadfasdfsfsdf'),(12,'测试中文',1,'测试中文测试中文测试中文测试中文测试中文测试中文'),(13,'长标签长标签长标签长标签长标签长标签长标签',1,'长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签长标签'),(14,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',1,'ddddddddddddddddddddddddd');
/*!40000 ALTER TABLE `labels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-08-11  9:10:32
