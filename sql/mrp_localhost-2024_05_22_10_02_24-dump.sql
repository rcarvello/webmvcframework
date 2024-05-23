-- MySQL dump 10.13  Distrib 5.6.21, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mrp
-- ------------------------------------------------------
-- Server version	5.6.21-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `access_level`
--

DROP TABLE IF EXISTS `access_level`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_level`
(
    `id_access_level` int(11)     NOT NULL,
    `name`            varchar(45) NOT NULL,
    PRIMARY KEY (`id_access_level`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Access levels';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_level`
--

LOCK TABLES `access_level` WRITE;
/*!40000 ALTER TABLE `access_level`
    DISABLE KEYS */;
INSERT INTO `access_level` (`id_access_level`, `name`)
VALUES (50, 'user'),
       (60, 'manager'),
       (100, 'admin');
/*!40000 ALTER TABLE `access_level`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bom`
--

DROP TABLE IF EXISTS `bom`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bom`
(
    `parent_part_code` varchar(40) NOT NULL,
    `child_part_code`  varchar(40) NOT NULL,
    `quantity`         int(11) DEFAULT NULL,
    PRIMARY KEY (`parent_part_code`, `child_part_code`),
    KEY `fk_bom_part1_idx` (`child_part_code`),
    CONSTRAINT `fk_bom_part` FOREIGN KEY (`parent_part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_bom_part1` FOREIGN KEY (`child_part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Bills of matirials';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bom`
--

LOCK TABLES `bom` WRITE;
/*!40000 ALTER TABLE `bom`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `bom`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category`
(
    `category_id`   int(11)     NOT NULL AUTO_INCREMENT,
    `category_name` varchar(20) NOT NULL,
    `list_order`    int(11) DEFAULT '0',
    PRIMARY KEY (`category_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 19
  DEFAULT CHARSET = utf8
  PACK_KEYS = 0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category`
    DISABLE KEYS */;
INSERT INTO `category` (`category_id`, `category_name`, `list_order`)
VALUES (1, 'Computer', 1),
       (2, 'Memory', 3),
       (3, 'Monitor', 2),
       (17, 'Caffè all\'anice', NULL),
       (18, 'Caffè aromati', 1);
/*!40000 ALTER TABLE `category`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer`
(
    `customer_id` int(11)      NOT NULL AUTO_INCREMENT,
    `name`        varchar(45) DEFAULT NULL,
    `email`       varchar(100) NOT NULL,
    `nationality` varchar(4)   NOT NULL,
    `assurance`   int(1)       NOT NULL,
    PRIMARY KEY (`customer_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer`
    DISABLE KEYS */;
INSERT INTO `customer` (`customer_id`, `name`, `email`, `nationality`, `assurance`)
VALUES (2, 'Mario Rossi', 'm.rossi@email.it', 'it', 1);
/*!40000 ALTER TABLE `customer`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_order`
--

DROP TABLE IF EXISTS `customer_order`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_order`
(
    `order_id`        int(11) NOT NULL AUTO_INCREMENT,
    `order_date`      date DEFAULT NULL,
    `customer_id`     int(11) NOT NULL,
    `order_status_id` int(11) NOT NULL,
    PRIMARY KEY (`order_id`),
    KEY `fk_order_customer1_idx` (`customer_id`),
    KEY `fk_order_order_status1_idx` (`order_status_id`),
    CONSTRAINT `fk_order_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_order_order_status1` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`order_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_order`
--

LOCK TABLES `customer_order` WRITE;
/*!40000 ALTER TABLE `customer_order`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_order`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_type`
--

DROP TABLE IF EXISTS `file_type`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_type`
(
    `file_type_id` int(11) NOT NULL,
    `name`         varchar(45) DEFAULT NULL,
    PRIMARY KEY (`file_type_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_type`
--

LOCK TABLES `file_type` WRITE;
/*!40000 ALTER TABLE `file_type`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `file_type`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good_movement`
--

DROP TABLE IF EXISTS `good_movement`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `good_movement`
(
    `good_movement_id` int(11)     NOT NULL,
    `movement_date`    varchar(45)    DEFAULT NULL,
    `part_code`        varchar(40) NOT NULL,
    `store_code`       int(11)     NOT NULL,
    `quantity`         decimal(11, 2) DEFAULT NULL,
    PRIMARY KEY (`good_movement_id`),
    KEY `fk_inventory_log_part1_idx` (`part_code`),
    KEY `fk_inventory_log_store1_idx` (`store_code`),
    CONSTRAINT `fk_inventory_log_part1` FOREIGN KEY (`part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_inventory_log_store1` FOREIGN KEY (`store_code`) REFERENCES `store` (`store_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_movement`
--

LOCK TABLES `good_movement` WRITE;
/*!40000 ALTER TABLE `good_movement`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `good_movement`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurement_unit`
--

DROP TABLE IF EXISTS `measurement_unit`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measurement_unit`
(
    `measurement_unit_code` varchar(10) NOT NULL,
    `name`                  varchar(45) DEFAULT NULL,
    PRIMARY KEY (`measurement_unit_code`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Unit of measurament';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurement_unit`
--

LOCK TABLES `measurement_unit` WRITE;
/*!40000 ALTER TABLE `measurement_unit`
    DISABLE KEYS */;
INSERT INTO `measurement_unit` (`measurement_unit_code`, `name`)
VALUES ('kg', 'kg'),
       ('pz', 'pieces');
/*!40000 ALTER TABLE `measurement_unit`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_file`
--

DROP TABLE IF EXISTS `order_file`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_file`
(
    `order_file_id` int(11) NOT NULL,
    `name`          varchar(45) DEFAULT NULL,
    `path`          varchar(45) DEFAULT NULL,
    `order_id`      int(11) NOT NULL,
    `file_type_id`  int(11) NOT NULL,
    `revision_n`    varchar(10) DEFAULT NULL,
    `revision_date` date        DEFAULT NULL,
    PRIMARY KEY (`order_file_id`),
    KEY `fk_order_file_order1_idx` (`order_id`),
    KEY `fk_order_file_file_type1_idx` (`file_type_id`),
    CONSTRAINT `fk_order_file_file_type1` FOREIGN KEY (`file_type_id`) REFERENCES `file_type` (`file_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_order_file_order1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_file`
--

LOCK TABLES `order_file` WRITE;
/*!40000 ALTER TABLE `order_file`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `order_file`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_macro_activity`
--

DROP TABLE IF EXISTS `order_macro_activity`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_macro_activity`
(
    `activity_id`   int(11) NOT NULL AUTO_INCREMENT,
    `order_id`      int(11) NOT NULL,
    `activity_name` varchar(200)   DEFAULT NULL,
    `cost`          decimal(11, 2) DEFAULT NULL,
    `start_time`    date           DEFAULT NULL,
    `end_time`      date           DEFAULT NULL,
    PRIMARY KEY (`activity_id`),
    KEY `fk_order_macro_activity_order1_idx` (`order_id`),
    CONSTRAINT `fk_order_macro_activity_order1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_macro_activity`
--

LOCK TABLES `order_macro_activity` WRITE;
/*!40000 ALTER TABLE `order_macro_activity`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `order_macro_activity`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status`
(
    `order_status_id` int(11) NOT NULL,
    `name`            varchar(45) DEFAULT NULL,
    PRIMARY KEY (`order_status_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `part`
--

DROP TABLE IF EXISTS `part`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `part`
(
    `part_code`             varchar(40) NOT NULL,
    `description`           varchar(45)         DEFAULT NULL,
    `source`                enum ('MAKE','BUY') DEFAULT NULL COMMENT 'Make or Buy',
    `source_lead_time`      int(11)             DEFAULT NULL,
    `measurement_unit_code` varchar(10) NOT NULL,
    `part_type_code`        varchar(20) NOT NULL COMMENT 'Product, Assembly, Component,Raw',
    `part_category_code`    varchar(20) NOT NULL COMMENT 'Market class',
    `wastage`               float               DEFAULT NULL COMMENT 'Waste ratio',
    `bom_levels`            int(11)             DEFAULT NULL COMMENT 'Hierarchy depth of its BOM',
    PRIMARY KEY (`part_code`),
    KEY `fk_part_part_type1_idx` (`part_type_code`),
    KEY `fk_part_part_category1_idx` (`part_category_code`),
    KEY `fk_part_part_unit_type1_idx` (`measurement_unit_code`),
    CONSTRAINT `fk_part_part_category1` FOREIGN KEY (`part_category_code`) REFERENCES `part_category` (`part_category_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_part_part_type1` FOREIGN KEY (`part_type_code`) REFERENCES `part_type` (`part_type_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_part_part_unit_type1` FOREIGN KEY (`measurement_unit_code`) REFERENCES `measurement_unit` (`measurement_unit_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Inventory parts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part`
--

LOCK TABLES `part` WRITE;
/*!40000 ALTER TABLE `part`
    DISABLE KEYS */;
INSERT INTO `part` (`part_code`, `description`, `source`, `source_lead_time`, `measurement_unit_code`, `part_type_code`,
                    `part_category_code`, `wastage`, `bom_levels`)
VALUES ('01', 'Descrizione', 'BUY', 10000, 'kg', 'PRODUCT', '01', 1, 10),
       ('02', 'Demodulator', 'BUY', 2, 'pz', 'RAW', '01', 1, 1),
       ('03', 'Converter', 'BUY', 5, 'pz', 'PRODUCT', '01', 10, 1),
       ('04', 'Jack', 'BUY', 10, 'pz', 'PRODUCT', '02', 1, 2),
       ('05', 'Mouse Wheel2', 'MAKE', 5, 'kg', 'ASSEMBLY', '01', 10, NULL),
       ('06', 'Board rz-048', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, NULL),
       ('07', 'Led mm 02 red', 'MAKE', 5, 'pz', 'PRODUCT', '01', 2, NULL),
       ('08', 'Led mm 02 green', 'BUY', 10, 'kg', 'SUB-ASSEMBLY', '02', 1, NULL),
       ('09', 'RS232', 'BUY', 5, 'pz', 'PRODUCT', '01', 10, 0),
       ('10', 'RJ45', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, 0),
       ('11', 'Cable', 'BUY', 5, 'pz', 'PRODUCT', '02', 10, 0);
/*!40000 ALTER TABLE `part`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `part_category`
--

DROP TABLE IF EXISTS `part_category`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `part_category`
(
    `part_category_code` varchar(20) NOT NULL,
    `name`               varchar(45) DEFAULT NULL,
    PRIMARY KEY (`part_category_code`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Product categories, market classes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part_category`
--

LOCK TABLES `part_category` WRITE;
/*!40000 ALTER TABLE `part_category`
    DISABLE KEYS */;
INSERT INTO `part_category` (`part_category_code`, `name`)
VALUES ('01', 'electronic'),
       ('02', 'electric');
/*!40000 ALTER TABLE `part_category`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `part_type`
--

DROP TABLE IF EXISTS `part_type`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `part_type`
(
    `part_type_code` varchar(20) NOT NULL,
    `name`           varchar(45) DEFAULT NULL,
    PRIMARY KEY (`part_type_code`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Levels classification for parts, e.g. assembly, raw material etc';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `part_type`
--

LOCK TABLES `part_type` WRITE;
/*!40000 ALTER TABLE `part_type`
    DISABLE KEYS */;
INSERT INTO `part_type` (`part_type_code`, `name`)
VALUES ('ASSEMBLY', 'ASSEMBLED PART '),
       ('PRODUCT', 'PRODUCT'),
       ('RAW', 'RAW MATERIAL'),
       ('SUB-ASSEMBLY', 'SUB-ASSEMBLY');
/*!40000 ALTER TABLE `part_type`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product`
(
    `product_id`   int(11)     NOT NULL AUTO_INCREMENT,
    `product_name` varchar(20) NOT NULL,
    `category_id`  int(11)              DEFAULT NULL,
    `list_order`   int(11)     NOT NULL DEFAULT '0',
    PRIMARY KEY (`product_id`),
    KEY `category_id` (`category_id`),
    CONSTRAINT `product_fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARSET = utf8
  PACK_KEYS = 0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product`
    DISABLE KEYS */;
INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `list_order`)
VALUES (1, 'NoteBook', 1, 2),
       (2, 'Desktop', 1, 1),
       (3, 'Ultrabook', 1, 3),
       (4, 'DIM Corsair', 2, 2),
       (5, 'DIM Toshiba', 2, 1),
       (6, 'Samsung', 3, 1),
       (7, 'LG', 3, 3),
       (8, 'Sony', 3, 2);
/*!40000 ALTER TABLE `product`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_option`
--

DROP TABLE IF EXISTS `product_option`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_option`
(
    `product_option_id` int(11)     NOT NULL AUTO_INCREMENT,
    `option_name`       varchar(30) NOT NULL,
    `product_id`        int(11)              DEFAULT NULL,
    `list_order`        int(11)     NOT NULL DEFAULT '0',
    PRIMARY KEY (`product_option_id`),
    KEY `product_id` (`product_id`),
    CONSTRAINT `product_option_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 15
  DEFAULT CHARSET = utf8
  PACK_KEYS = 0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_option`
--

LOCK TABLES `product_option` WRITE;
/*!40000 ALTER TABLE `product_option`
    DISABLE KEYS */;
INSERT INTO `product_option` (`product_option_id`, `option_name`, `product_id`, `list_order`)
VALUES (1, 'Lenovo', 1, 1),
       (2, 'Asus', 1, 2),
       (3, 'Tower', 2, 1),
       (4, 'All in one', 2, 2),
       (5, 'Apple', 3, 1),
       (6, 'Microsoft', 3, 2),
       (7, '4 Gb', 4, 1),
       (8, '8 Gb', 4, 2),
       (9, '16 Gb', 5, 1),
       (10, '20 \'\'', 6, 1),
       (11, '23', 6, 2),
       (12, '14', 7, 1),
       (13, '32', 8, 1),
       (14, '50', 8, 2);
/*!40000 ALTER TABLE `product_option`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock`
(
    `store_code` int(11)     NOT NULL,
    `part_code`  varchar(40) NOT NULL,
    `quantity`   decimal(11, 2) DEFAULT NULL,
    PRIMARY KEY (`store_code`, `part_code`),
    KEY `fk_stock_part1_idx` (`part_code`),
    KEY `fk_stock_store1_idx` (`store_code`),
    CONSTRAINT `fk_stock_part1` FOREIGN KEY (`part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_stock_store1` FOREIGN KEY (`store_code`) REFERENCES `store` (`store_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `stock`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `stock_store`
--

DROP TABLE IF EXISTS `stock_store`;
/*!50001 DROP VIEW IF EXISTS `stock_store`*/;
SET @saved_cs_client = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stock_store` AS
SELECT 1 AS `part_code`,
       1 AS `store_code`,
       1 AS `quantity`,
       1 AS `name`
        */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store`
(
    `store_code` int(11) NOT NULL,
    `name`       varchar(45) DEFAULT NULL,
    PRIMARY KEY (`store_code`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `store`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user`
(
    `id_user`         int(11)      NOT NULL AUTO_INCREMENT COMMENT 'User ID',
    `id_access_level` int(11)      NOT NULL COMMENT 'User Ascce Level',
    `full_name`       varchar(45)  NOT NULL COMMENT 'User full Name',
    `email`           varchar(100) NOT NULL COMMENT 'User email',
    `password`        varchar(200) NOT NULL COMMENT 'User encrypted password',
    `salt`            varchar(200) NOT NULL COMMENT 'User encryption salt',
    `token`           varchar(200)          DEFAULT NULL COMMENT 'User access token',
    `token_timestamp` timestamp    NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Token timestamp validation check',
    `enabled`         int(1)       NOT NULL DEFAULT '1' COMMENT 'User enabled flag',
    `last_login`      datetime              DEFAULT NULL COMMENT 'Use last login date',
    PRIMARY KEY (`id_user`),
    UNIQUE KEY `unique_email` (`email`),
    KEY `fk_user_access_level_idx` (`id_access_level`),
    KEY `idx_full_name` (`full_name`),
    CONSTRAINT `fk_user_access_level1` FOREIGN KEY (`id_access_level`) REFERENCES `access_level` (`id_access_level`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8 COMMENT ='Users credentials';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user`
    DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `id_access_level`, `full_name`, `email`, `password`, `salt`, `token`, `token_timestamp`,
                    `enabled`, `last_login`)
VALUES (1, 100, 'Administrators', 'rosario.carvello@gmail.com',
        'f35d51264735fb85246c06120994aaa9c412bb8bf97dca68ba919296eb59ea3a80c5be96df92c539ceec0eaf9d7f13de88fbb97892e915ce4a5ba5676f9f89a1',
        '131150533065d5aee20ebf29.70637320', NULL, NULL, 1, NULL),
       (2, 60, 'Manager', 'manager@email.it', '482c811da5d5b4bc6d497ffa98491e38', '21120102305b159287d7fee8.43527519',
        NULL, NULL, 1, NULL),
       (3, 50, 'Utente', 'user@email.com',
        '8310da4e5aa1fc1f34674f3cd0433e0f721d85e00f0e7b6654c1040a42d4e6cdd6efefea69c2501496e1a060b20c9a120fda873e800881629465279febb3ca17',
        '34225278865d5a9f12db076.35118376', NULL, '2024-05-22 06:57:16', 1, '2024-05-22 09:41:40'),
       (5, 60, 'Rosario Carvello', 'rosario.carvello@email.it',
        '66d8ad2ec739c402f3c5b14d53304bc615cde9e7107572759d0944fa08f188a25e95548f5d7f5e92ffaeb097ef9512bd240484a1767b903d708ca3fbc2b7b617',
        '170691651065d5aec33d5628.67261642', NULL, NULL, 1, NULL);
/*!40000 ALTER TABLE `user`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `users_roles_names`
--

DROP TABLE IF EXISTS `users_roles_names`;
/*!50001 DROP VIEW IF EXISTS `users_roles_names`*/;
SET @saved_cs_client = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `users_roles_names` AS
SELECT 1 AS `user_email`,
       1 AS `role_name`
        */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `wiki_application_role`
--

DROP TABLE IF EXISTS `wiki_application_role`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_application_role`
(
    `role_id`   int(11) NOT NULL AUTO_INCREMENT,
    `role_name` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`role_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_application_role`
--

LOCK TABLES `wiki_application_role` WRITE;
/*!40000 ALTER TABLE `wiki_application_role`
    DISABLE KEYS */;
INSERT INTO `wiki_application_role` (`role_id`, `role_name`)
VALUES (1, 'user'),
       (2, 'editor'),
       (3, 'moderator'),
       (4, 'webmaster'),
       (5, 'admin');
/*!40000 ALTER TABLE `wiki_application_role`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_user`
--

DROP TABLE IF EXISTS `wiki_user`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_user`
(
    `user_id`    int(11) NOT NULL AUTO_INCREMENT,
    `user_name`  varchar(45)  DEFAULT NULL,
    `user_email` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_user`
--

LOCK TABLES `wiki_user` WRITE;
/*!40000 ALTER TABLE `wiki_user`
    DISABLE KEYS */;
INSERT INTO `wiki_user` (`user_id`, `user_name`, `user_email`)
VALUES (1, 'Mark', 'mark@email.com'),
       (2, 'Elen', 'elen@email.com'),
       (3, 'John', 'john@email.com');
/*!40000 ALTER TABLE `wiki_user`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki_users_roles`
--

DROP TABLE IF EXISTS `wiki_users_roles`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki_users_roles`
(
    `user_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    KEY `fk_user_has_application_role_application_role1_idx` (`role_id`),
    KEY `fk_user_has_application_role_user_idx` (`user_id`),
    CONSTRAINT `fk_user_has_application_role_application_role` FOREIGN KEY (`role_id`) REFERENCES `wiki_application_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_has_application_role_user` FOREIGN KEY (`user_id`) REFERENCES `wiki_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki_users_roles`
--

LOCK TABLES `wiki_users_roles` WRITE;
/*!40000 ALTER TABLE `wiki_users_roles`
    DISABLE KEYS */;
INSERT INTO `wiki_users_roles` (`user_id`, `role_id`)
VALUES (2, 1),
       (3, 1),
       (2, 2),
       (3, 2),
       (1, 3),
       (2, 3),
       (1, 4),
       (1, 5);
/*!40000 ALTER TABLE `wiki_users_roles`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `stock_store`
--

/*!50001 DROP VIEW IF EXISTS `stock_store`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`root`@`localhost` SQL SECURITY DEFINER */ /*!50001 VIEW `stock_store` AS
select `stock`.`part_code`  AS `part_code`,
       `stock`.`store_code` AS `store_code`,
       `stock`.`quantity`   AS `quantity`,
       `store`.`name`       AS `name`
from (`stock` join `store`)
where (`store`.`store_code` = `stock`.`store_code`)
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;

--
-- Final view structure for view `users_roles_names`
--

/*!50001 DROP VIEW IF EXISTS `users_roles_names`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8 */;
/*!50001 SET character_set_results = utf8 */;
/*!50001 SET collation_connection = utf8_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`root`@`localhost` SQL SECURITY DEFINER */ /*!50001 VIEW `users_roles_names` AS
select `wiki_user`.`user_email` AS `user_email`, `wiki_application_role`.`role_name` AS `role_name`
from ((`wiki_user` join `wiki_users_roles`
       on ((`wiki_user`.`user_id` = `wiki_users_roles`.`user_id`))) join `wiki_application_role`
      on ((`wiki_users_roles`.`role_id` = `wiki_application_role`.`role_id`)))
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22 10:02:25
