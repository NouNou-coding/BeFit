-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: befit_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (3,2,1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,5,21.24,'completed','2025-07-14 11:08:41','2025-07-15 18:53:14');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (1,5,'f64bd4af2e22b8af1827a1f1df7b7eec0c5b346af71897ab6ee1eda32fef5131','2025-07-15 21:59:36','2025-07-15 18:59:36'),(2,5,'7bee5e94f4bb945d8213b6f83f156b21e97c4c74a9c7dc40fde46138d0eead4d','2025-07-15 22:04:13','2025-07-15 19:04:13'),(3,5,'fbd812d53b399ea56a9acac643b97d2d1d246079255ef6351c45ea7bbf59b665','2025-07-15 22:04:14','2025-07-15 19:04:14'),(4,5,'445761729ae94d03ee4603bdcd31c4861f626b182f5589f3af1e0b5e43d9fb1c','2025-07-15 22:14:31','2025-07-15 19:14:31'),(5,5,'58a8fbaac17d62765e7f9ec9b4f1506cb66ebe1faab70d6c47f1353ca3763518','2025-07-15 22:25:34','2025-07-15 19:25:34'),(6,5,'7f114cd229a0bacb11ed22425856dbc22f4534fd8a970b035d032ec2302bba6c','2025-07-15 22:29:19','2025-07-15 19:29:19'),(8,5,'e1d3e7677a771cd3ff4d1490ef8b5272abacb530a45b022a0fd731ce9d0c83fe','2025-07-16 00:00:43','2025-07-15 20:00:43'),(9,5,'b718a7e46a90617764924297ed58f20892e298ec32c50b4b754595f6c64edadb','2025-07-16 00:06:10','2025-07-15 20:06:10');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` enum('equipment','supplement') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'FitRx Smart Adjustable Dumbbells - 1kg to 20kg','Adjustable dumbbells with smart tracking',124.99,'photos/dumbell.jpeg','equipment','2025-07-11 22:47:39'),(2,'Resistance Band Set 1-5kg','Set of resistance bands for full-body workouts',24.99,'photos/resistance.jpg','equipment','2025-07-11 22:47:39'),(3,'10 mm lever-action belt for weightlifting','Premium weightlifting belt for support',59.99,'photos/belt.jpg','equipment','2025-07-11 22:47:39'),(4,'Portable Doorway Pull-up Bar','Portable pull-up bar for home workouts',44.99,'photos/pullup.jpg','equipment','2025-07-11 22:47:39'),(5,'2kg Kevin Levrone - Gold Whey Protein','Premium whey protein for muscle recovery',64.99,'photos/prot.webp','supplement','2025-07-11 22:47:39'),(6,'500g Kevin Levrone - Gold Creatine Monohydrate','Pure creatine monohydrate for strength gains',34.99,'photos/creatine.jpg','supplement','2025-07-11 22:47:39'),(7,'500g Kevin Levrone - Gold Preworkout','Pre-workout supplement for energy and focus',34.99,'photos/preworkout.jpeg','supplement','2025-07-11 22:47:39'),(8,'4kg Kevin Levrone - Mass Gainer','Mass gainer for weight and muscle gain',84.99,'photos/mass.jpeg','supplement','2025-07-11 22:47:39');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommended_supplements`
--

DROP TABLE IF EXISTS `recommended_supplements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recommended_supplements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `recommended_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchased` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `recommended_supplements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `recommended_supplements_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recommended_supplements`
--

LOCK TABLES `recommended_supplements` WRITE;
/*!40000 ALTER TABLE `recommended_supplements` DISABLE KEYS */;
/*!40000 ALTER TABLE `recommended_supplements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_workout_history`
--

DROP TABLE IF EXISTS `user_workout_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_workout_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `workout_date` date NOT NULL,
  `workout_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`workout_data`)),
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_workout_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_workout_history`
--

LOCK TABLES `user_workout_history` WRITE;
/*!40000 ALTER TABLE `user_workout_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_workout_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0,
  `verification_sent_at` datetime DEFAULT NULL,
  `verification_attempts` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'anthony.imad@isae.edu.lb','$2y$10$Q65vpgrmm/TrWWGMoVXfb.DbpRnoT6g/6DdpzVXHaORuxTqQ9E6Yy','anthony','2025-07-12 00:49:50',0,NULL,0),(5,'yorgobekaii.0@gmail.com','$2y$10$9xLiAlnYtvVFeml06aOhJu4Hu6rCMEU6/A3jdkRO0ICtSiR5H00fi','Yorgo','2025-07-14 11:06:39',1,NULL,0),(10,'yorgobekaiiprofessional@gmail.com','$2y$10$YtDfn.Sh3tzCWa6iOCfWOOb0AOU9Q3yOiT11uBTwTuLWmuuBmuwjq','Yorgo','2025-07-16 22:00:10',1,NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workout_plans`
--

DROP TABLE IF EXISTS `workout_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workout_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `training_days` int(11) DEFAULT NULL,
  `equipment` varchar(255) DEFAULT NULL,
  `workout_plan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`workout_plan`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fitness_level` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `gender` enum('male','female','other') DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workout_plans`
--

LOCK TABLES `workout_plans` WRITE;
/*!40000 ALTER TABLE `workout_plans` DISABLE KEYS */;
INSERT INTO `workout_plans` VALUES (1,5,45.00,170,54,'build_muscle',3,'dumbbells,resistance_bands',NULL,'2025-07-15 23:38:51','beginner','male','','','2025-07-16 16:58:08');
/*!40000 ALTER TABLE `workout_plans` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-17  1:01:51
