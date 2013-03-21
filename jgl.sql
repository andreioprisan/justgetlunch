-- MySQL dump 10.13  Distrib 5.5.25a, for Linux (x86_64)
--
-- Host: localhost    Database: jgl1.0
-- ------------------------------------------------------
-- Server version	5.5.25a

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
-- Table structure for table `lunches`
--

DROP TABLE IF EXISTS `lunches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lunches` (
  `lid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid_author` int(11) unsigned DEFAULT NULL,
  `uids_invitees_list` varchar(500) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  `near` varchar(200) DEFAULT NULL,
  `transportation_list` varchar(500) DEFAULT NULL,
  `yid` varchar(50) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lunches`
--

LOCK TABLES `lunches` WRITE;
/*!40000 ALTER TABLE `lunches` DISABLE KEYS */;
INSERT INTO `lunches` VALUES (5,57,'[57]','07/16/12','5:00pm','Waltham, Massachusetts','{\"57\":\"\"}','Mw6coNmjhkE6pce4kGOkkQ','asdfasdf'),(13,57,'[57,78,79,80]','07/16/12','5:00pm','Boston, Massachusetts','{\"57\":\"23\"}','C--wIpxJ4j1y01G_raHdbA',NULL);
/*!40000 ALTER TABLE `lunches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `u_sessions`
--

DROP TABLE IF EXISTS `u_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `u_sessions` (
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `last_activity` int(10) unsigned DEFAULT NULL,
  `user_data` text NOT NULL,
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `u_sessions`
--

LOCK TABLES `u_sessions` WRITE;
/*!40000 ALTER TABLE `u_sessions` DISABLE KEYS */;
INSERT INTO `u_sessions` VALUES ('2bf9b11547ece5b937c23e49b492f15d','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',1342472145,'a:4:{s:9:\"user_data\";s:0:\"\";s:12:\"author_email\";s:28:\"andrei.oprisan@lycos-inc.com\";s:8:\"userdata\";a:6:{s:2:\"id\";s:21:\"117895713925538076588\";s:5:\"email\";s:28:\"andrei.oprisan@lycos-inc.com\";s:14:\"verified_email\";b:1;s:4:\"name\";s:14:\"Andrei Oprisan\";s:10:\"given_name\";s:6:\"Andrei\";s:11:\"family_name\";s:7:\"Oprisan\";}s:3:\"uid\";s:2:\"57\";}');
/*!40000 ALTER TABLE `u_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `googleid` varchar(128) DEFAULT NULL,
  `given_name` varchar(100) DEFAULT NULL,
  `family_name` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--


--
-- Table structure for table `yelp_restaurants`
--

DROP TABLE IF EXISTS `yelp_restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yelp_restaurants` (
  `yid` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  UNIQUE KEY `yid` (`yid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yelp_restaurants`
--

LOCK TABLES `yelp_restaurants` WRITE;
/*!40000 ALTER TABLE `yelp_restaurants` DISABLE KEYS */;
INSERT INTO `yelp_restaurants` VALUES ('4-parrXC5vWK0ONgbY-eTA','The Proper Slice','547 Washington St, Boston, MA 02135','6177894889','http://www.yelp.com/biz/the-proper-slice-boston'),('C--wIpxJ4j1y01G_raHdbA','Punjab Palace','109 Brighton Ave, Allston, MA 02134','6172541500',NULL),('Mw6coNmjhkE6pce4kGOkkQ','B & F House of Pizza','227 Lake St, Waltham, MA 02454','7818911020','http://www.yelp.com/biz/b-and-f-house-of-pizza-waltham'),('PBsWxOeMpbr8tMAUFgPi-A','Guru The Caterer','1297 Broadway, Somerville, MA 02144','6177180078',NULL);
/*!40000 ALTER TABLE `yelp_restaurants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-07-16 23:28:59
