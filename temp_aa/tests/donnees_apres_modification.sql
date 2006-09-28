-- MySQL dump 10.10
--
-- Host: localhost    Database: pbem
-- ------------------------------------------------------
-- Server version	5.0.22-Debian_0ubuntu6.06.2-log

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
-- Dumping data for table `mountyhall_troll`
--


/*!40000 ALTER TABLE `mountyhall_troll` DISABLE KEYS */;
LOCK TABLES `mountyhall_troll` WRITE;
INSERT INTO `mountyhall_troll` (`numero`, `nom`, `race`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `vue`, `armure`, `date_compilation`, `sortileges`) VALUES (44245,'KADJAR','Kastar','entre 85 et 105','entre 9 et 11','entre 7 et 9','entre 18 et 20','entre 2 et 3','entre 5 et 7','entre 15 et 17','2006-09-27',NULL),(7996,'TOM33','Kastar','120','entre 15 et 16','entre 10 et 11','supérieur à 20','5','entre 6 et 7','entre 14 et 15','2006-09-26',NULL),(12706,'GLURPS','Durakuir','entre 180 et 190','entre 9 et 11','entre 11 et 13','entre 15 et 16','5','5','entre 19 et 20','2006-09-12',NULL),(31343,'DUCKATROLL','Durakuir','entre 130 et 150','entre 10 et 12','entre 8 et 10','entre 11 et 13','entre 3 et 4','entre 4 et 6','supérieur à 20','2006-06-14',NULL),(29201,'BIDOUILLE','Tomawak','entre 100 et 120','entre 13 et 15','entre 11 et 13','entre 13 et 15','5','entre 10 et 12','entre 14 et 16','2006-02-14',NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `mountyhall_troll` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

