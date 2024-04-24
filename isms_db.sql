-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: isms_db
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category_list`
--

DROP TABLE IF EXISTS `category_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `department_id` int NOT NULL,
  `name` text NOT NULL,
  `unit` varchar(250) NOT NULL DEFAULT 'pcs',
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_list`
--

LOCK TABLES `category_list` WRITE;
/*!40000 ALTER TABLE `category_list` DISABLE KEYS */;
INSERT INTO `category_list` VALUES (1,1,'concierge','pcs','description     is needed',1,1,'2024-04-19 05:04:47','2024-04-19 05:35:05'),(2,1,'concierge','pcs','desc',1,0,'2024-04-19 05:36:29','2024-04-19 05:36:29');
/*!40000 ALTER TABLE `category_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department_list`
--

DROP TABLE IF EXISTS `department_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department_list`
--

LOCK TABLES `department_list` WRITE;
/*!40000 ALTER TABLE `department_list` DISABLE KEYS */;
INSERT INTO `department_list` VALUES (1,'department 1','Description New',1,0,'2024-04-19 04:49:04','2024-04-22 09:02:50'),(2,'Department 2','desc',1,0,'2024-04-19 04:49:33','2024-04-19 04:50:55'),(3,'Test D','Test',1,0,'2024-04-22 06:38:31','2024-04-22 06:38:31'),(4,'Test D3','Test',1,0,'2024-04-22 06:45:24','2024-04-22 06:45:24'),(5,'Test D4','Test',1,0,'2024-04-22 06:47:48','2024-04-22 06:47:48');
/*!40000 ALTER TABLE `department_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_units`
--

DROP TABLE IF EXISTS `inventory_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_units` (
  `unit_id` int NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(50) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_units`
--

LOCK TABLES `inventory_units` WRITE;
/*!40000 ALTER TABLE `inventory_units` DISABLE KEYS */;
INSERT INTO `inventory_units` VALUES (1,'Pieces','Individual pieces','2023-12-15 08:56:20','2023-12-15 09:09:36'),(2,'Liters','Volume measurement in liters','2023-12-15 08:56:20','2023-12-15 09:09:30'),(3,'KG','Weight measurement in grams','2023-12-15 08:56:20','2023-12-15 09:09:22'),(7,'Packets','Packets','2023-12-15 09:10:06','2023-12-15 09:10:06');
/*!40000 ALTER TABLE `inventory_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_list`
--

DROP TABLE IF EXISTS `item_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `department_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `name` text NOT NULL,
  `unit` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vendor_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `rate_per_unit` varchar(255) DEFAULT NULL,
  `safety_stock` int DEFAULT NULL,
  `reorder_point` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_id_fk_il` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_list`
--

LOCK TABLES `item_list` WRITE;
/*!40000 ALTER TABLE `item_list` DISABLE KEYS */;
INSERT INTO `item_list` VALUES (1,1,1,'item','','hwssdw',1,1,'2024-04-19 05:26:41','2024-04-19 05:34:57','1','22',12,12),(2,1,2,'spoon','','rerhj',1,1,'2024-04-19 05:38:07','2024-04-22 07:00:37','1','43',43,67),(3,1,2,'test item','KG','Test ',1,0,'2024-04-22 07:00:21','2024-04-22 07:00:21','1','10',10,10);
/*!40000 ALTER TABLE `item_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stockin_list`
--

DROP TABLE IF EXISTS `stockin_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stockin_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `date` date NOT NULL,
  `quantity` float(12,2) NOT NULL DEFAULT '0.00',
  `rate` varchar(255) DEFAULT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_id_fk_sl` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockin_list`
--

LOCK TABLES `stockin_list` WRITE;
/*!40000 ALTER TABLE `stockin_list` DISABLE KEYS */;
INSERT INTO `stockin_list` VALUES (1,2,'2024-04-19',6.00,'43','ngfytg','2024-04-19 05:38:47','2024-04-19 05:38:47');
/*!40000 ALTER TABLE `stockin_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stockout_list`
--

DROP TABLE IF EXISTS `stockout_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stockout_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `date` date NOT NULL,
  `quantity` float(12,2) NOT NULL DEFAULT '0.00',
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_id_fk_sol` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockout_list`
--

LOCK TABLES `stockout_list` WRITE;
/*!40000 ALTER TABLE `stockout_list` DISABLE KEYS */;
INSERT INTO `stockout_list` VALUES (1,2,'2024-04-19',9.00,'56fdfg','2024-04-19 05:39:13','2024-04-19 05:39:13');
/*!40000 ALTER TABLE `stockout_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_info`
--

DROP TABLE IF EXISTS `system_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_info`
--

LOCK TABLES `system_info` WRITE;
/*!40000 ALTER TABLE `system_info` DISABLE KEYS */;
INSERT INTO `system_info` VALUES (1,'name','Rely'),(6,'short_name','Rely'),(11,'logo','uploads/logo.png?v=1653699689'),(13,'user_avatar','uploads/user_avatar.jpg'),(14,'cover','uploads/cover.png?v=1653710421'),(17,'phone','456-987-1231'),(18,'mobile','09123456987 / 094563212222 '),(19,'email','info@musicschool.com'),(20,'address','Here St, Down There City, Anywhere Here, 2306 -updated');
/*!40000 ALTER TABLE `system_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `middlename` text,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='2';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Adarsh','','Narahari','admin','0192023a7bbd73250516f069df18b500','uploads/avatars/1.png?v=1649834664',NULL,1,'2021-01-20 14:02:37','2024-02-17 03:48:24'),(5,'Soumya','','Shah','Soumya@gmail.com','d00f5d5217896fb7fd601412cb890830',NULL,NULL,2,'2024-04-19 05:24:57','2024-04-19 05:24:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_list`
--

DROP TABLE IF EXISTS `vendor_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) DEFAULT NULL,
  `vendor_type` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `contacr_person` varchar(255) DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `other_details` text,
  `ratings` varchar(255) DEFAULT NULL,
  `billing` varchar(255) DEFAULT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_list`
--

LOCK TABLES `vendor_list` WRITE;
/*!40000 ALTER TABLE `vendor_list` DISABLE KEYS */;
INSERT INTO `vendor_list` VALUES (1,'nameera','One Time','625162','9887756543',6576576575,'raidurg','',NULL,NULL,'2024-04-19 05:09:13');
/*!40000 ALTER TABLE `vendor_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waste_list`
--

DROP TABLE IF EXISTS `waste_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `waste_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `date` date NOT NULL,
  `quantity` float(12,2) NOT NULL DEFAULT '0.00',
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_id_fk_wl` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waste_list`
--

LOCK TABLES `waste_list` WRITE;
/*!40000 ALTER TABLE `waste_list` DISABLE KEYS */;
INSERT INTO `waste_list` VALUES (1,2,'2024-04-19',67.00,'hgfht','2024-04-19 05:39:28','2024-04-19 05:39:28');
/*!40000 ALTER TABLE `waste_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-22 12:00:00
