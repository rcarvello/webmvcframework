-- MySQL dump 10.13  Distrib 5.6.21, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mvc_wiki
-- ------------------------------------------------------
-- Server version	5.6.21-log

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
-- Table structure for table `application_role`
--

DROP TABLE IF EXISTS `application_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application_role`
(
    `role_id`   int(11) NOT NULL AUTO_INCREMENT,
    `role_name` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_role`
--

LOCK
TABLES `application_role` WRITE;
/*!40000 ALTER TABLE `application_role` DISABLE KEYS */;
INSERT INTO `application_role`
VALUES (1, 'user'),
       (2, 'editor'),
       (3, 'moderator'),
       (4, 'webmaster'),
       (5, 'admin');
/*!40000 ALTER TABLE `application_role` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user`
(
    `user_id`    int(11) NOT NULL AUTO_INCREMENT,
    `user_name`  varchar(45)  DEFAULT NULL,
    `user_email` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK
TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user`
VALUES (1, 'Mark', 'mark@email.com'),
       (2, 'Elen', 'elen@email.com'),
       (3, 'John', 'john@email.com');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles`
(
    `user_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    KEY       `fk_user_has_application_role_application_role1_idx` (`role_id`),
    KEY       `fk_user_has_application_role_user_idx` (`user_id`),
    CONSTRAINT `fk_user_has_application_role_application_role1` FOREIGN KEY (`role_id`) REFERENCES `application_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_has_application_role_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK
TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles`
VALUES (2, 1),
       (3, 1),
       (2, 2),
       (3, 2),
       (1, 3),
       (2, 3),
       (1, 4),
       (1, 5);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Temporary view structure for view `users_roles_names`
--

DROP TABLE IF EXISTS `users_roles_names`;
/*!50001 DROP VIEW IF EXISTS `users_roles_names`*/;
SET
@saved_cs_client     = @@character_set_client;
SET
character_set_client = utf8;
/*!50001 CREATE VIEW `users_roles_names` AS SELECT 
 1 AS `user_email`,
 1 AS `role_name`*/;
SET
character_set_client = @saved_cs_client;

--
-- Final view structure for view `users_roles_names`
--

/*!50001 DROP VIEW IF EXISTS `users_roles_names`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `users_roles_names` AS select `user`.`user_email` AS `user_email`,`application_role`.`role_name` AS `role_name` from ((`user` join `users_roles` on((`user`.`user_id` = `users_roles`.`user_id`))) join `application_role` on((`users_roles`.`role_id` = `application_role`.`role_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-13 23:47:42
