-- MySQL dump 10.13  Distrib 8.0.25, for Linux (x86_64)
--
-- Host: localhost    Database: examify
-- ------------------------------------------------------
-- Server version	8.0.25-0ubuntu0.20.04.1

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
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `batches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `batches_name_unique` (`name`),
  UNIQUE KEY `batches_slug_unique` (`slug`),
  KEY `batches_course_id_foreign` (`course_id`),
  CONSTRAINT `batches_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batches`
--

LOCK TABLES `batches` WRITE;
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
INSERT INTO `batches` VALUES (3,5,'New Batch','new-batch',1,'2021-08-21 05:56:28','2021-08-21 05:56:28'),(4,6,'BCS45-1','bcs45-1',1,'2021-08-22 12:09:32','2021-08-22 12:09:32');
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `admission_status` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_name_unique` (`name`),
  UNIQUE KEY `courses_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (5,'BCS 44','bcs-44',NULL,1,1,'2021-08-21 01:46:00','2021-08-21 02:15:10'),(6,'BCS 45','bcs-45',NULL,1,1,'2021-08-21 01:46:09','2021-08-22 12:14:50');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_categories`
--

DROP TABLE IF EXISTS `exam_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_categories_name_unique` (`name`),
  UNIQUE KEY `exam_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_categories`
--

LOCK TABLES `exam_categories` WRITE;
/*!40000 ALTER TABLE `exam_categories` DISABLE KEYS */;
INSERT INTO `exam_categories` VALUES (3,'Preli','preli','2021-08-21 06:22:43','2021-08-21 06:22:43'),(4,'Written','written','2021-08-21 06:22:49','2021-08-21 06:25:03');
/*!40000 ALTER TABLE `exam_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_code` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` bigint unsigned NOT NULL,
  `exam_category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_question` int NOT NULL,
  `exam_duration` int NOT NULL COMMENT 'in minute',
  `has_negative_mark` tinyint(1) NOT NULL DEFAULT '0',
  `negative_mark` double(8,2) NOT NULL DEFAULT '0.25',
  `exam_started_at` timestamp NULL DEFAULT NULL,
  `exam_ended_at` timestamp NULL DEFAULT NULL,
  `subjects` json NOT NULL,
  `status` enum('pending','published','ongoing','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exams_exam_code_unique` (`exam_code`),
  KEY `exams_batch_id_foreign` (`batch_id`),
  KEY `exams_exam_category_id_foreign` (`exam_category_id`),
  CONSTRAINT `exams_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exams_exam_category_id_foreign` FOREIGN KEY (`exam_category_id`) REFERENCES `exam_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,'1a186828-f218-44af-9cff-d7d7e7be6a7f',3,3,'Model Test new',10,5,1,0.50,'2021-08-22 04:00:00','2021-08-23 16:00:00','[{\"id\": 1, \"name\": \"Bangla\", \"no_of_question\": \"5\"}, {\"id\": 2, \"name\": \"English\", \"no_of_question\": \"5\"}]','closed','2021-08-21 08:51:28','2021-08-22 16:40:38'),(2,'912eda4c-74f7-4467-9680-d4943ba278c9',4,3,'Final Test 1',100,100,1,0.50,'2021-08-22 04:00:00','2021-08-23 16:00:00','[{\"id\": 1, \"name\": \"Bangla\", \"no_of_question\": \"50\"}, {\"id\": 2, \"name\": \"English\", \"no_of_question\": \"20\"}, {\"id\": 3, \"name\": \"General Knowledge\", \"no_of_question\": \"30\"}]','pending','2021-08-22 12:11:01','2021-08-24 16:53:21'),(3,'f4ded56c-d121-4cac-a5d9-b917c62b9bc2',3,3,'Final Test - 02',10,5,1,0.50,'2021-08-24 04:00:00','2021-08-26 16:00:00','[{\"id\": 1, \"name\": \"Bangla\", \"no_of_question\": \"5\"}, {\"id\": 2, \"name\": \"English\", \"no_of_question\": \"3\"}, {\"id\": 3, \"name\": \"General Knowledge\", \"no_of_question\": \"2\"}]','closed','2021-08-24 16:57:43','2021-08-24 17:02:02');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_02_07_111848_create_courses_table',1),(6,'2021_02_07_114957_create_batches_table',1),(7,'2021_02_07_123512_create_subjects_table',1),(8,'2021_02_13_134916_create_students_table',1),(9,'2021_02_23_211841_create_exam_categories_table',1),(10,'2021_02_23_215132_create_exams_table',1),(11,'2021_02_27_193406_create_questions_table',1),(12,'2021_03_02_190528_create_results_table',1),(13,'2021_03_10_151504_create_media_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_exam_id_foreign` (`exam_id`),
  KEY `questions_subject_id_foreign` (`subject_id`),
  CONSTRAINT `questions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (7,1,1,'<p>Question 1</p>\n<p>&nbsp;</p>\n<p><img src=\"../../../../../storage/uploads/doqwPh03uMIlbCQEKiwNHq6tPYBdSOQ6J3N9IEaT.png\" alt=\"\" width=\"300\" height=\"184\" /></p>','<h1><span style=\"color: #d1d5db; font-family: \'Inter var\', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #111827;\">Tailwind UI is a collection of professionally designed, pre-built, fully responsive HTML snippets you can drop into your Tailwind projects. Get started by checking out our free preview components, or browsing the PNG previews in the categories you\'re most curious about.</span></h1>','option b','option c','option d','a','2021-08-22 00:31:00','2021-08-22 16:35:05'),(8,1,1,'Question 2','option a','option b','option c','option d','b','2021-08-22 00:31:00','2021-08-22 00:31:00'),(9,1,1,'Question 3','option a','option b','option c','option d','d','2021-08-22 00:31:00','2021-08-22 00:31:00'),(10,1,1,'Question 4','option a','option b','option c','option d','a','2021-08-22 00:31:00','2021-08-22 00:31:00'),(11,1,1,'Question 5','option a','option b','option c','option d','c','2021-08-22 00:31:00','2021-08-22 00:31:00'),(12,1,2,'Question 6','option a','option b','option c','option d','d','2021-08-22 00:31:00','2021-08-22 00:31:00'),(13,1,2,'Question 7','option a','option b','option c','option d','c','2021-08-22 00:31:00','2021-08-22 00:31:00'),(14,1,2,'Question 8','option a','option b','option c','option d','b','2021-08-22 00:31:00','2021-08-22 00:31:00'),(15,1,2,'Question 9','option a','option b','option c','option d','b','2021-08-22 00:31:00','2021-08-22 00:31:00'),(16,1,2,'Question 10','option a','option b','option c','option d','a','2021-08-22 00:31:00','2021-08-22 00:31:00'),(17,2,1,'Question no 1','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(18,2,1,'Question no 2','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(19,2,1,'Question no 3','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(20,2,1,'Question no 4','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(21,2,1,'Question no 5','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(22,2,1,'Question no 6','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(23,2,1,'Question no 7','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(24,2,1,'Question no 8','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(25,2,1,'Question no 9','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(26,2,1,'Question no 10','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(27,2,1,'Question no 11','Option A ','Option B','Option C','Option D','a','2021-08-22 12:13:46','2021-08-22 12:13:46'),(28,2,1,'Question no 12','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(29,2,1,'Question no 13','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(30,2,1,'Question no 14','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(31,2,1,'Question no 15','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(32,2,1,'Question no 16','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(33,2,1,'Question no 17','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(34,2,1,'Question no 18','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(35,2,1,'Question no 19','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(36,2,1,'Question no 20','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(37,2,1,'Question no 21','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(38,2,1,'Question no 22','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(39,2,1,'Question no 23','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(40,2,1,'Question no 24','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(41,2,1,'Question no 25','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(42,2,1,'Question no 26','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(43,2,1,'Question no 27','Option A ','Option B','Option C','Option D','b','2021-08-22 12:13:46','2021-08-22 12:13:46'),(44,2,1,'Question no 28','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(45,2,1,'Question no 29','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(46,2,1,'Question no 30','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(47,2,1,'Question no 31','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(48,2,1,'Question no 32','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(49,2,1,'Question no 33','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(50,2,1,'Question no 34','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(51,2,1,'Question no 35','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(52,2,1,'Question no 36','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(53,2,1,'Question no 37','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(54,2,1,'Question no 38','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(55,2,1,'Question no 39','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(56,2,1,'Question no 40','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(57,2,1,'Question no 41','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(58,2,1,'Question no 42','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(59,2,1,'Question no 43','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(60,2,1,'Question no 44','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:46','2021-08-22 12:13:46'),(61,2,1,'Question no 45','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(62,2,1,'Question no 46','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(63,2,1,'Question no 47','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(64,2,1,'Question no 48','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(65,2,1,'Question no 49','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(66,2,1,'Question no 50','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(67,2,2,'Question no 51','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(68,2,2,'Question no 52','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(69,2,2,'Question no 53','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(70,2,2,'Question no 54','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(71,2,2,'Question no 55','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(72,2,2,'Question no 56','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(73,2,2,'Question no 57','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(74,2,2,'Question no 58','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(75,2,2,'Question no 59','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(76,2,2,'Question no 60','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(77,2,2,'Question no 61','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(78,2,2,'Question no 62','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(79,2,2,'Question no 63','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(80,2,2,'Question no 64','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(81,2,2,'Question no 65','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(82,2,2,'Question no 66','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(83,2,2,'Question no 67','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(84,2,2,'Question no 68','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(85,2,2,'Question no 69','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(86,2,2,'Question no 70','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(87,2,3,'Question no 71','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(88,2,3,'Question no 72','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(89,2,3,'Question no 73','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(90,2,3,'Question no 74','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(91,2,3,'Question no 75','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(92,2,3,'Question no 76','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(93,2,3,'Question no 77','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(94,2,3,'Question no 78','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(95,2,3,'Question no 79','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(96,2,3,'Question no 80','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(97,2,3,'Question no 81','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(98,2,3,'Question no 82','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(99,2,3,'Question no 83','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(100,2,3,'Question no 84','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(101,2,3,'Question no 85','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(102,2,3,'Question no 86','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(103,2,3,'Question no 87','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(104,2,3,'Question no 88','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(105,2,3,'Question no 89','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(106,2,3,'Question no 90','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(107,2,3,'Question no 91','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(108,2,3,'Question no 92','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(109,2,3,'Question no 93','Option A ','Option B','Option C','Option D','c','2021-08-22 12:13:47','2021-08-22 12:13:47'),(110,2,3,'Question no 94','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(111,2,3,'Question no 95','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(112,2,3,'Question no 96','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(113,2,3,'Question no 97','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(114,2,3,'Question no 98','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(115,2,3,'Question no 99','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(116,2,3,'Question no 100','Option A ','Option B','Option C','Option D','d','2021-08-22 12:13:47','2021-08-22 12:13:47'),(117,3,1,'question no 1','option a','option b','option c','option d','a','2021-08-24 16:59:25','2021-08-24 16:59:25'),(118,3,1,'question no 2','option a','option b','option c','option d','b','2021-08-24 16:59:25','2021-08-24 16:59:25'),(119,3,1,'question no 3','option a','option b','option c','option d','a','2021-08-24 16:59:25','2021-08-24 16:59:25'),(120,3,1,'question no 4','option a','option b','option c','option d','b','2021-08-24 16:59:25','2021-08-24 16:59:25'),(121,3,1,'question no 5','option a','option b','option c','option d','c','2021-08-24 16:59:25','2021-08-24 16:59:25'),(122,3,2,'question no 6','option a','option b','option c','option d','c','2021-08-24 16:59:25','2021-08-24 16:59:25'),(123,3,2,'question no 7','option a','option b','option c','option d','d','2021-08-24 16:59:25','2021-08-24 16:59:25'),(124,3,2,'question no 8','option a','option b','option c','option d','d','2021-08-24 16:59:25','2021-08-24 16:59:25'),(125,3,3,'question no 9','option a','option b','option c','option d','d','2021-08-24 16:59:25','2021-08-24 16:59:25'),(126,3,3,'question no 10','option a','option b','option c','option d','d','2021-08-24 16:59:25','2021-08-24 16:59:25');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `result_code` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `exam_id` bigint unsigned DEFAULT NULL,
  `position` int DEFAULT NULL,
  `exam_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_question` int DEFAULT NULL,
  `total_answered` int DEFAULT NULL,
  `correct_answer` int DEFAULT NULL,
  `wrong_answer` int DEFAULT NULL,
  `negative_mark` decimal(8,2) DEFAULT NULL,
  `total_mark` decimal(8,2) DEFAULT NULL,
  `exam_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_meta_data` json DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `results_result_code_unique` (`result_code`),
  KEY `results_user_id_foreign` (`user_id`),
  KEY `results_exam_id_foreign` (`exam_id`),
  CONSTRAINT `results_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE SET NULL,
  CONSTRAINT `results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (18,'f1a14901-9700-4d57-86f9-dd10bed5987e',3,1,2,'Preli','Model Test new',10,9,3,6,3.00,0.00,NULL,'[{\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 1\", \"selectedAnswer\": \"a\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 2\", \"selectedAnswer\": \"b\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 3\", \"selectedAnswer\": \"b\"}, {\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 4\", \"selectedAnswer\": \"c\"}, {\"answer\": \"c\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 5\", \"selectedAnswer\": \"c\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 6\", \"selectedAnswer\": \"c\"}, {\"answer\": \"c\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 7\", \"selectedAnswer\": \"d\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 8\", \"selectedAnswer\": \"a\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 9\", \"selectedAnswer\": \"a\"}, {\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 10\", \"selectedAnswer\": null}]',1,'2021-08-22 12:07:58','2021-08-22 16:40:38'),(22,'c6d121f1-f8fa-4285-9ed9-d32460bbf7b3',5,1,1,'Preli','Model Test new',10,9,5,4,2.00,3.00,NULL,'[{\"answer\": \"a\", \"options\": {\"a\": \"<h1><span style=\\\"color: #d1d5db; font-family: \'Inter var\', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #111827;\\\">Tailwind UI is a collection of professionally designed, pre-built, fully responsive HTML snippets you can drop into your Tailwind projects. Get started by checking out our free preview components, or browsing the PNG previews in the categories you\'re most curious about.</span></h1>\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"<p>Question 1</p>\\n<p>&nbsp;</p>\\n<p><img src=\\\"../../../../../storage/uploads/doqwPh03uMIlbCQEKiwNHq6tPYBdSOQ6J3N9IEaT.png\\\" alt=\\\"\\\" width=\\\"300\\\" height=\\\"184\\\" /></p>\", \"selectedAnswer\": \"a\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 2\", \"selectedAnswer\": \"b\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 3\", \"selectedAnswer\": null}, {\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 4\", \"selectedAnswer\": \"a\"}, {\"answer\": \"c\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"Question 5\", \"selectedAnswer\": \"d\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 6\", \"selectedAnswer\": \"a\"}, {\"answer\": \"c\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 7\", \"selectedAnswer\": \"c\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 8\", \"selectedAnswer\": \"b\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 9\", \"selectedAnswer\": \"c\"}, {\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"Question 10\", \"selectedAnswer\": \"c\"}]',1,'2021-08-22 16:39:23','2021-08-22 16:40:38'),(23,'713269ef-015b-4018-bfbf-bcf4bc230e5f',3,3,1,'Preli','Final Test - 02',10,8,2,6,3.00,-1.00,NULL,'[{\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"question no 1\", \"selectedAnswer\": \"a\"}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"question no 2\", \"selectedAnswer\": \"a\"}, {\"answer\": \"a\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"question no 3\", \"selectedAnswer\": null}, {\"answer\": \"b\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"question no 4\", \"selectedAnswer\": \"a\"}, {\"answer\": \"c\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"Bangla\", \"question\": \"question no 5\", \"selectedAnswer\": \"b\"}, {\"answer\": \"c\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"question no 6\", \"selectedAnswer\": \"b\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"question no 7\", \"selectedAnswer\": \"d\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"English\", \"question\": \"question no 8\", \"selectedAnswer\": \"b\"}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"General Knowledge\", \"question\": \"question no 9\", \"selectedAnswer\": null}, {\"answer\": \"d\", \"options\": {\"a\": \"option a\", \"b\": \"option b\", \"c\": \"option c\", \"d\": \"option d\"}, \"subject\": \"General Knowledge\", \"question\": \"question no 10\", \"selectedAnswer\": \"a\"}]',1,'2021-08-24 17:00:28','2021-08-24 17:02:02');
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `course_id` bigint unsigned NOT NULL,
  `batch_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_email_unique` (`email`),
  UNIQUE KEY `students_phone_unique` (`phone`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_course_id_foreign` (`course_id`),
  KEY `students_batch_id_foreign` (`batch_id`),
  CONSTRAINT `students_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,3,5,3,'Forkan','Ali','forkan@app.com','01858098583','male','1992-05-12',1,'2021-08-22 00:44:59','2021-08-22 00:58:56'),(2,4,6,4,'Mahmud','Hasan','hasan@app.com','01858078582','male','2014-06-22',1,'2021-08-22 12:15:28','2021-08-22 12:15:59'),(3,5,5,3,'Karim','Ahmed','karim@app.com','01858078481','male','2021-08-22',1,'2021-08-22 16:37:51','2021-08-22 16:38:11'),(4,6,6,4,'Akdul','Kader','akakib@app.com','01858078580','male','2021-08-24',1,'2021-08-24 17:03:31','2021-08-24 17:04:19');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_name_unique` (`name`),
  UNIQUE KEY `subjects_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Bangla','bangla',1,'2021-08-21 06:07:59','2021-08-21 06:07:59'),(2,'English','english',1,'2021-08-21 06:08:05','2021-08-21 06:08:05'),(3,'General Knowledge','general-knowledge',1,'2021-08-21 06:08:15','2021-08-21 06:12:03');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','student') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super','Admin','admin@app.com',NULL,'2021-08-21 00:20:25','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','PghnnvnYsbF0KJy9uTzeis51bdSaIzl0rGsHWCPsuyEHXR0zPVX1vUqQjVfC','2021-08-21 00:20:25','2021-08-21 00:20:25'),(2,'Irfan','Ali','irfan@app.com','01858078583',NULL,'$2y$10$Mlf4Jwm1LN4s8cVoETnr8OyCT6NTNJTUWD918iXgMGPCIOQ43ts/6','admin',NULL,'2021-08-21 06:53:41','2021-08-21 06:56:27'),(3,'Forkan','Ali','forkan@app.com',NULL,NULL,'$2y$10$AIm2Mk9Dtkc0tERCMwBNMecIpEiHzmZeapowHmpZl7PdJBmFR21l6','student',NULL,'2021-08-22 00:58:56','2021-08-22 01:15:38'),(4,'Mahmud','Hasan','hasan@app.com',NULL,NULL,'$2y$10$w1w5lV0Rh.CGAwua1Ug5oeC8KHH04IwyCK/1CHA.hHAfngB6qN5Bi','student',NULL,'2021-08-22 12:15:59','2021-08-22 12:20:21'),(5,'Karim','Ahmed','karim@app.com',NULL,NULL,'$2y$10$tzlzItqgiuaSlXEUBRQcHudkIPp7gvCN1pvDIvLs8z/TP.0eZl7YS','student',NULL,'2021-08-22 16:38:11','2021-08-22 16:38:11'),(6,'Akdul','Kader','akakib@app.com',NULL,NULL,'$2y$10$p64MyXhvYZ3uvyNA.Ey8q.pCvhPlwHdRi6ZzOOMWsOX5u6uB3cy3m','student',NULL,'2021-08-24 17:04:19','2021-08-24 17:04:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-25 13:24:28
