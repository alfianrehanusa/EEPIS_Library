-- MariaDB dump 10.17  Distrib 10.4.12-MariaDB, for osx10.15 (x86_64)
--
-- Host: localhost    Database: EEPIS_Library
-- ------------------------------------------------------
-- Server version	10.4.12-MariaDB

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
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `tahun` varchar(5) NOT NULL,
  `pengarang` text NOT NULL,
  `sinopsis` text NOT NULL,
  `jumlah` int(11) DEFAULT 0,
  `type_buku` varchar(45) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (6,'Sherlock Holmes Best Of The Best','2019','Detective Conan Doyle','Petualangan Sherlock Holmes Dengan Dokter Watson',11,'umum','5ea9ac993a1a2.jpg',NULL,'2020-04-29 15:08:59','2020-05-06 16:46:04'),(7,'Judul Jurnal','2018','Pengarang Jurnal','Sinopsis Jurnal',4,'jurnal','5ea9bc81be9e1.jpg',NULL,'2020-04-29 17:42:25','2020-05-06 16:54:45'),(8,'Judul Majalah','1998','Pengarang','Sinopsis Majalah',1,'majalah','5ea9be9d25a87.jpg',NULL,'2020-04-29 17:51:25','2020-04-29 17:51:25'),(9,'PA/TA','2017','pengarangPATA','Sinopsis PATA',0,'pa_ta','5ea9bec12868b.jpg',NULL,'2020-04-29 17:52:01','2020-05-06 18:59:35');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ebook`
--

DROP TABLE IF EXISTS `ebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `tahun` varchar(5) NOT NULL,
  `pengarang` text NOT NULL,
  `sinopsis` text NOT NULL,
  `ebook` varchar(50) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ebook`
--

LOCK TABLES `ebook` WRITE;
/*!40000 ALTER TABLE `ebook` DISABLE KEYS */;
INSERT INTO `ebook` VALUES (2,'Adventure of Sherlock Holmes','2019','Sir Arthur Conan Doyle','Detective','5eb9816606f5c.pdf','5eb98166044f3.jpg',NULL,'2020-05-11 16:20:21','2020-05-11 16:46:30');
/*!40000 ALTER TABLE `ebook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tgl_pesan` date DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (1,'2103187051',6,'2020-04-02','2020-04-05','2020-05-06',4,'2020-04-29 15:08:59','2020-05-06 16:46:04'),(2,'2103187052',7,'2020-05-03','2020-05-05','2020-05-06',5,NULL,'2020-05-06 16:54:45'),(3,'2531470203980002',8,'2020-05-07',NULL,NULL,1,'2020-05-06 17:49:22','2020-05-06 17:49:22'),(4,'2103187052',9,'2020-05-07','2020-05-12',NULL,3,'2020-05-06 18:59:23','2020-05-06 18:59:35'),(5,'2103187052',7,'2020-05-04','2020-05-06','2020-05-07',5,NULL,'2020-05-07 16:54:45');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaturan`
--

DROP TABLE IF EXISTS `pengaturan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengaturan` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nama` varchar(45) NOT NULL,
  `nilai` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan`
--

LOCK TABLES `pengaturan` WRITE;
/*!40000 ALTER TABLE `pengaturan` DISABLE KEYS */;
INSERT INTO `pengaturan` VALUES (1,'Batas Pesanan Diambil','5',NULL,'2020-05-10 06:41:42'),(2,'Batas Pengembalian Buku','14',NULL,NULL);
/*!40000 ALTER TABLE `pengaturan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_pinjam`
--

DROP TABLE IF EXISTS `status_pinjam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_pinjam` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_pinjam`
--

LOCK TABLES `status_pinjam` WRITE;
/*!40000 ALTER TABLE `status_pinjam` DISABLE KEYS */;
INSERT INTO `status_pinjam` VALUES (1,'dipesan'),(2,'pemesanan_tidak_diambil'),(3,'dipinjam'),(4,'dikembalikan_telat'),(5,'dikembalikan_tepat_waktu');
/*!40000 ALTER TABLE `status_pinjam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_token` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1203040','Security Secure','security@secure.com','25d55ad283aa400af464c76d713c07ad','karyawan',NULL,NULL,'2020-05-10 06:50:01','2020-05-10 06:50:21'),('2103187051','Alfian Rehanusa Wibowo','alfianwibowo@it.student.pens.ac.id','8ccf0eb10a5ac6aacc12345253757c77','mahasiswa',NULL,NULL,'2020-04-17 10:35:19','2020-04-17 10:35:19'),('2103187052','Dimas Eko Setyo Budi','dimaseko@it.student.pens.ac.id','25d55ad283aa400af464c76d713c07ad','mahasiswa',NULL,NULL,'2020-04-17 10:40:40','2020-04-17 10:40:40'),('2103187053','dd','wibowoalfian5229@gmail.comd','8ccf0eb10a5ac6aacc12345253757c77','mahasiswa',NULL,NULL,'2020-04-20 03:05:32','2020-05-10 06:44:49'),('2103187054','c','wibowoalfian5229@gmail.comc','8ccf0eb10a5ac6aacc12345253757c77','mahasiswa',NULL,NULL,'2020-04-20 03:04:07','2020-04-20 03:04:07'),('2103187055','b','wibowoalfian5229@gmail.comb','8ccf0eb10a5ac6aacc12345253757c77','mahasiswa',NULL,NULL,'2020-04-20 03:03:31','2020-04-20 03:03:31'),('2103187056','Afrizal Fatra Wibowo','afrizalfatra@it.student.pens.ac.id','8ccf0eb10a5ac6aacc12345253757c77','mahasiswa',NULL,NULL,'2020-04-17 10:37:04','2020-04-17 10:37:04'),('2103187057','aaa','wibowoalfian5229@gmail.com','8ccf0eb10a5ac6aacc12345253757c77','mahasiswa','93ca5679db4a31ad13c18683d1ed476e',NULL,'2020-04-20 03:03:12','2020-05-10 05:17:55'),('2531470203980002','Ira Prasetyaningrum','iraprasetyaningrum@pens.ac.id','25d55ad283aa400af464c76d713c07ad','dosen',NULL,NULL,'2020-04-21 15:09:10','2020-04-21 15:09:10');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_admin`
--

DROP TABLE IF EXISTS `user_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_admin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_admin`
--

LOCK TABLES `user_admin` WRITE;
/*!40000 ALTER TABLE `user_admin` DISABLE KEYS */;
INSERT INTO `user_admin` VALUES (1,'Alfian Rehanusa Wibowo','wibowoalfian5229@gmail.com',NULL,'$2y$10$1KmSvsxkhYVfiTdUF6WYW.c3g3xt0jlyNs9PGUi.bgSmckNOmnK16',NULL,'2020-04-13 08:53:14','2020-04-13 08:53:14'),(2,'Pustakawan','pustakawan@gmail.com',NULL,'$2y$10$qRMcWFdQ2HkCBk9i1F5TGuyCllSUetSZMZYG5YoftcmRQXF9d.E3q',NULL,'2020-05-11 04:28:42','2020-05-11 06:30:38');
/*!40000 ALTER TABLE `user_admin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-12 23:37:10
