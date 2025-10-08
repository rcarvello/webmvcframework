-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Ott 08, 2025 alle 11:00
-- Versione del server: 5.6.21-log
-- Versione PHP: 8.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrp`
--
CREATE
DATABASE IF NOT EXISTS `mrp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE
`mrp`;

-- --------------------------------------------------------

--
-- Struttura della tabella `access_level`
--

DROP TABLE IF EXISTS `access_level`;
CREATE TABLE `access_level`
(
  `id_access_level` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Access levels';

--
-- Dump dei dati per la tabella `access_level`
--

INSERT INTO `access_level` (`id_access_level`, `name`) VALUES
(50, 'user'),
(60, 'manager'),
(100, 'admin');

-- --------------------------------------------------------

--
-- Struttura della tabella `bom`
--

DROP TABLE IF EXISTS `bom`;
CREATE TABLE `bom`
(
  `parent_part_code` varchar(40) NOT NULL,
  `child_part_code` varchar(40) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bills of matirials';

-- --------------------------------------------------------

--
-- Struttura della tabella `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`
(
    `category_id`   int(11) NOT NULL,
    `category_name` varchar(20) NOT NULL,
    `list_order`    int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

--
-- Dump dei dati per la tabella `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `list_order`)
VALUES (1, 'Computer', 1),
       (2, 'Memory', 3),
       (3, 'Monitor', 2),
       (17, 'Caffè all\'anice', NULL),
(18, 'Caffè aromati', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `nationality` varchar(4) NOT NULL,
  `assurance` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `email`, `nationality`, `assurance`) VALUES
(11, 'Mario Rossi', 'm.rossi@email.com', 'it', 1),
(12, 'Elena Verdi', 'elena.verdi@email.com', 'it', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `customer_order`
--

DROP TABLE IF EXISTS `customer_order`;
CREATE TABLE `customer_order` (
  `order_id` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `file_type`
--

DROP TABLE IF EXISTS `file_type`;
CREATE TABLE `file_type` (
  `file_type_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `good_movement`
--

DROP TABLE IF EXISTS `good_movement`;
CREATE TABLE `good_movement` (
  `good_movement_id` int(11) NOT NULL,
  `movement_date` varchar(45) DEFAULT NULL,
  `part_code` varchar(40) NOT NULL,
  `store_code` int(11) NOT NULL,
  `quantity` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `measurement_unit`
--

DROP TABLE IF EXISTS `measurement_unit`;
CREATE TABLE `measurement_unit` (
  `measurement_unit_code` varchar(10) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Unit of measurament';

--
-- Dump dei dati per la tabella `measurement_unit`
--

INSERT INTO `measurement_unit` (`measurement_unit_code`, `name`) VALUES
('kg', 'kg'),
('pz', 'pieces');

-- --------------------------------------------------------

--
-- Struttura della tabella `order_file`
--

DROP TABLE IF EXISTS `order_file`;
CREATE TABLE `order_file` (
  `order_file_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `path` varchar(45) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `revision_n` varchar(10) DEFAULT NULL,
  `revision_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `order_macro_activity`
--

DROP TABLE IF EXISTS `order_macro_activity`;
CREATE TABLE `order_macro_activity` (
  `activity_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `activity_name` varchar(200) DEFAULT NULL,
  `cost` decimal(11,2) DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `part`
--

DROP TABLE IF EXISTS `part`;
CREATE TABLE `part` (
  `part_code` varchar(40) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `source` enum('MAKE','BUY') DEFAULT NULL COMMENT 'Make or Buy',
  `source_lead_time` int(11) DEFAULT NULL,
  `measurement_unit_code` varchar(10) NOT NULL,
  `part_type_code` varchar(20) NOT NULL COMMENT 'Product, Assembly, Component,Raw',
  `part_category_code` varchar(20) NOT NULL COMMENT 'Market class',
  `wastage` float DEFAULT NULL COMMENT 'Waste ratio',
  `bom_levels` int(11) DEFAULT NULL COMMENT 'Hierarchy depth of its BOM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Inventory parts';

--
-- Dump dei dati per la tabella `part`
--

INSERT INTO `part` (`part_code`, `description`, `source`, `source_lead_time`, `measurement_unit_code`, `part_type_code`, `part_category_code`, `wastage`, `bom_levels`) VALUES
('01', 'Simple product', 'BUY', 10000, 'kg', 'PRODUCT', '01', 1, 10),
('02', 'Demodulator', 'MAKE', 4, 'pz', 'RAW', '01', 1, 1),
('03', 'Converter', 'BUY', 5, 'pz', 'PRODUCT', '01', 10, 1),
('04', 'Jack', 'BUY', 10, 'pz', 'PRODUCT', '02', 1, 2),
('05', 'Mouse Wheel', 'MAKE', 5, 'kg', 'ASSEMBLY', '01', 10, NULL),
('06', 'Board rz-048', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, NULL),
('07', 'Led red', 'MAKE', 5, 'pz', 'RAW', '01', 2, 0),
('08', 'Led green', 'BUY', 10, 'kg', 'SUB-ASSEMBLY', '02', 1, NULL),
('09', 'RS232', 'BUY', 5, 'pz', 'PRODUCT', '01', 10, 0),
('10', 'RJ45', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, 0),
('11', 'Cable', 'BUY', 5, 'pz', 'PRODUCT', '02', 10, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `part_category`
--

DROP TABLE IF EXISTS `part_category`;
CREATE TABLE `part_category` (
  `part_category_code` varchar(20) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Product categories, market classes';

--
-- Dump dei dati per la tabella `part_category`
--

INSERT INTO `part_category` (`part_category_code`, `name`) VALUES
('01', 'electronic'),
('02', 'electric');

-- --------------------------------------------------------

--
-- Struttura della tabella `part_type`
--

DROP TABLE IF EXISTS `part_type`;
CREATE TABLE `part_type` (
  `part_type_code` varchar(20) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Levels classification for parts, e.g. assembly, raw material etc';

--
-- Dump dei dati per la tabella `part_type`
--

INSERT INTO `part_type` (`part_type_code`, `name`) VALUES
('ASSEMBLY', 'ASSEMBLED PART '),
('PRODUCT', 'PRODUCT'),
('RAW', 'RAW MATERIAL'),
('SUB-ASSEMBLY', 'SUB-ASSEMBLY');

-- --------------------------------------------------------

--
-- Struttura della tabella `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `list_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

--
-- Dump dei dati per la tabella `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `list_order`) VALUES
(1, 'NoteBook', 1, 2),
(2, 'Desktop', 1, 1),
(3, 'Ultrabook', 1, 3),
(4, 'DIM Corsair', 2, 2),
(5, 'DIM Toshiba', 2, 1),
(6, 'Samsung', 3, 1),
(7, 'LG', 3, 3),
(8, 'Sony', 3, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `product_option`
--

DROP TABLE IF EXISTS `product_option`;
CREATE TABLE `product_option` (
  `product_option_id` int(11) NOT NULL,
  `option_name` varchar(30) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `list_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;

--
-- Dump dei dati per la tabella `product_option`
--

INSERT INTO `product_option` (`product_option_id`, `option_name`, `product_id`, `list_order`) VALUES
(1, 'Lenovo', 1, 1),
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

-- --------------------------------------------------------

--
-- Struttura della tabella `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `store_code` int(11) NOT NULL,
  `part_code` varchar(40) NOT NULL,
  `quantity` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `stock_store`
-- (Vedi sotto per la vista effettiva)
--
DROP VIEW IF EXISTS `stock_store`;
CREATE TABLE `stock_store` (
`part_code` varchar(40)
,`store_code` int(11)
,`quantity` decimal(11,2)
,`name` varchar(45)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `store`
--

DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `store_code` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL COMMENT 'User ID',
  `id_access_level` int(11) NOT NULL COMMENT 'User Ascce Level',
  `full_name` varchar(45) NOT NULL COMMENT 'User full Name',
  `email` varchar(100) NOT NULL COMMENT 'User email',
  `password` varchar(200) NOT NULL COMMENT 'User encrypted password',
  `salt` varchar(200) NOT NULL COMMENT 'User encryption salt',
  `token` varchar(200) DEFAULT NULL COMMENT 'User access token',
  `token_timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Token timestamp validation check',
  `enabled` int(1) NOT NULL DEFAULT '1' COMMENT 'User enabled flag',
  `last_login` datetime DEFAULT NULL COMMENT 'Use last login date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users credentials';

--
-- Dump dei dati per la tabella `user`
-- ALL PASSWORDS ARE: 'password'

INSERT INTO `user` (`id_user`, `id_access_level`, `full_name`, `email`, `password`, `salt`, `enabled`)
VALUES 
(1, 100, 'Administrator', 'admin@email.com','163e821c6ece715c5053e40bfcc46b27f4751fe3e85a53c297ee2aa7df1f5252339d24b6f0849b1dcf914fb96d6cad2220609d43e2b04c45ab3a1cb68d178b14','194744212166472874e64879.46699751', 1),
(2, 60, 'Manager', 'manager@email.com','96887d1dd423fc6164cd51cf752bd363146b7fddfb0f0afb7f82f1c12c0d90943480ca599a2a05560c309884c925e06ad4d12fa1885c9ea50fd9bc368e62dc1d','205310676366472958b81a35.14153631', 1);
--
-- Struttura stand-in per le viste `users_roles_names`
-- (Vedi sotto per la vista effettiva)
--
DROP VIEW IF EXISTS `users_roles_names`;
CREATE TABLE `users_roles_names` (
`user_email` varchar(100)
,`role_name` varchar(45)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `wiki_application_role`
--

DROP TABLE IF EXISTS `wiki_application_role`;
CREATE TABLE `wiki_application_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `wiki_application_role`
--

INSERT INTO `wiki_application_role` (`role_id`, `role_name`) VALUES
(1, 'user'),
(2, 'editor'),
(3, 'moderator'),
(4, 'webmaster'),
(5, 'admin');

-- --------------------------------------------------------

--
-- Struttura della tabella `wiki_user`
--

DROP TABLE IF EXISTS `wiki_user`;
CREATE TABLE `wiki_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(45) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `wiki_user`
--

INSERT INTO `wiki_user` (`user_id`, `user_name`, `user_email`) VALUES
(1, 'Mark', 'mark@email.com'),
(2, 'Elen', 'elen@email.com'),
(3, 'John', 'john@email.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `wiki_users_roles`
--

DROP TABLE IF EXISTS `wiki_users_roles`;
CREATE TABLE `wiki_users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `wiki_users_roles`
--

INSERT INTO `wiki_users_roles` (`user_id`, `role_id`) VALUES
(2, 1),
(3, 1),
(2, 2),
(3, 2),
(1, 3),
(2, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Struttura per vista `stock_store`
--
DROP TABLE IF EXISTS `stock_store`;

DROP VIEW IF EXISTS `stock_store`;
CREATE OR REPLACE VIEW `stock_store`  AS SELECT `stock`.`part_code` AS `part_code`, `stock`.`store_code` AS `store_code`, `stock`.`quantity` AS `quantity`, `store`.`name` AS `name` FROM (`stock` join `store`) WHERE (`store`.`store_code` = `stock`.`store_code`) ;

-- --------------------------------------------------------

--
-- Struttura per vista `users_roles_names`
--
DROP TABLE IF EXISTS `users_roles_names`;

DROP VIEW IF EXISTS `users_roles_names`;
CREATE OR REPLACE VIEW `users_roles_names`  AS SELECT `wiki_user`.`user_email` AS `user_email`, `wiki_application_role`.`role_name` AS `role_name` FROM ((`wiki_user` join `wiki_users_roles` on((`wiki_user`.`user_id` = `wiki_users_roles`.`user_id`))) join `wiki_application_role` on((`wiki_users_roles`.`role_id` = `wiki_application_role`.`role_id`))) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `access_level`
--
ALTER TABLE `access_level`
  ADD PRIMARY KEY (`id_access_level`);

--
-- Indici per le tabelle `bom`
--
ALTER TABLE `bom`
  ADD PRIMARY KEY (`parent_part_code`,`child_part_code`),
  ADD KEY `fk_bom_part1_idx` (`child_part_code`);

--
-- Indici per le tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indici per le tabelle `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email_uq` (`email`);

--
-- Indici per le tabelle `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_order_customer1_idx` (`customer_id`),
  ADD KEY `fk_order_order_status1_idx` (`order_status_id`);

--
-- Indici per le tabelle `file_type`
--
ALTER TABLE `file_type`
  ADD PRIMARY KEY (`file_type_id`);

--
-- Indici per le tabelle `good_movement`
--
ALTER TABLE `good_movement`
  ADD PRIMARY KEY (`good_movement_id`),
  ADD KEY `fk_inventory_log_part1_idx` (`part_code`),
  ADD KEY `fk_inventory_log_store1_idx` (`store_code`);

--
-- Indici per le tabelle `measurement_unit`
--
ALTER TABLE `measurement_unit`
  ADD PRIMARY KEY (`measurement_unit_code`);

--
-- Indici per le tabelle `order_file`
--
ALTER TABLE `order_file`
  ADD PRIMARY KEY (`order_file_id`),
  ADD KEY `fk_order_file_order1_idx` (`order_id`),
  ADD KEY `fk_order_file_file_type1_idx` (`file_type_id`);

--
-- Indici per le tabelle `order_macro_activity`
--
ALTER TABLE `order_macro_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `fk_order_macro_activity_order1_idx` (`order_id`);

--
-- Indici per le tabelle `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indici per le tabelle `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`part_code`),
  ADD KEY `fk_part_part_type1_idx` (`part_type_code`),
  ADD KEY `fk_part_part_category1_idx` (`part_category_code`),
  ADD KEY `fk_part_part_unit_type1_idx` (`measurement_unit_code`);

--
-- Indici per le tabelle `part_category`
--
ALTER TABLE `part_category`
  ADD PRIMARY KEY (`part_category_code`);

--
-- Indici per le tabelle `part_type`
--
ALTER TABLE `part_type`
  ADD PRIMARY KEY (`part_type_code`);

--
-- Indici per le tabelle `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indici per le tabelle `product_option`
--
ALTER TABLE `product_option`
  ADD PRIMARY KEY (`product_option_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indici per le tabelle `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`store_code`,`part_code`),
  ADD KEY `fk_stock_part1_idx` (`part_code`),
  ADD KEY `fk_stock_store1_idx` (`store_code`);

--
-- Indici per le tabelle `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_code`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `fk_user_access_level_idx` (`id_access_level`),
  ADD KEY `idx_full_name` (`full_name`);

--
-- Indici per le tabelle `wiki_application_role`
--
ALTER TABLE `wiki_application_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indici per le tabelle `wiki_user`
--
ALTER TABLE `wiki_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indici per le tabelle `wiki_users_roles`
--
ALTER TABLE `wiki_users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user_has_application_role_application_role1_idx` (`role_id`),
  ADD KEY `fk_user_has_application_role_user_idx` (`user_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `order_macro_activity`
--
ALTER TABLE `order_macro_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `product_option`
--
ALTER TABLE `product_option`
  MODIFY `product_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `wiki_application_role`
--
ALTER TABLE `wiki_application_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `wiki_user`
--
ALTER TABLE `wiki_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bom`
--
ALTER TABLE `bom`
  ADD CONSTRAINT `fk_bom_part` FOREIGN KEY (`parent_part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bom_part1` FOREIGN KEY (`child_part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `customer_order`
--
ALTER TABLE `customer_order`
  ADD CONSTRAINT `fk_order_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_order_status1` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`order_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `good_movement`
--
ALTER TABLE `good_movement`
  ADD CONSTRAINT `fk_inventory_log_part1` FOREIGN KEY (`part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventory_log_store1` FOREIGN KEY (`store_code`) REFERENCES `store` (`store_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `order_file`
--
ALTER TABLE `order_file`
  ADD CONSTRAINT `fk_order_file_file_type1` FOREIGN KEY (`file_type_id`) REFERENCES `file_type` (`file_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_file_order1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `order_macro_activity`
--
ALTER TABLE `order_macro_activity`
  ADD CONSTRAINT `fk_order_macro_activity_order1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `part`
--
ALTER TABLE `part`
  ADD CONSTRAINT `fk_part_part_category1` FOREIGN KEY (`part_category_code`) REFERENCES `part_category` (`part_category_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_part_part_type1` FOREIGN KEY (`part_type_code`) REFERENCES `part_type` (`part_type_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_part_part_unit_type1` FOREIGN KEY (`measurement_unit_code`) REFERENCES `measurement_unit` (`measurement_unit_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Limiti per la tabella `product_option`
--
ALTER TABLE `product_option`
  ADD CONSTRAINT `product_option_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Limiti per la tabella `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_part1` FOREIGN KEY (`part_code`) REFERENCES `part` (`part_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stock_store1` FOREIGN KEY (`store_code`) REFERENCES `store` (`store_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_access_level1` FOREIGN KEY (`id_access_level`) REFERENCES `access_level` (`id_access_level`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `wiki_users_roles`
--
ALTER TABLE `wiki_users_roles`
  ADD CONSTRAINT `fk_user_has_application_role_application_role` FOREIGN KEY (`role_id`) REFERENCES `wiki_application_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_application_role_user` FOREIGN KEY (`user_id`) REFERENCES `wiki_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
