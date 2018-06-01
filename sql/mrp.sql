-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mag 11, 2018 alle 15:21
-- Versione del server: 5.6.21-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mrp`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `access_level`
--

CREATE TABLE IF NOT EXISTS `access_level` (
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

CREATE TABLE IF NOT EXISTS `bom` (
  `parent_part_code` varchar(40) NOT NULL,
  `child_part_code` varchar(40) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bills of matirials';

-- --------------------------------------------------------

--
-- Struttura della tabella `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`customer_id` int(11) NOT NULL,
  `customer_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `customer_order`
--

CREATE TABLE IF NOT EXISTS `customer_order` (
`order_id` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `file_type`
--

CREATE TABLE IF NOT EXISTS `file_type` (
  `file_type_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `good_movement`
--

CREATE TABLE IF NOT EXISTS `good_movement` (
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

CREATE TABLE IF NOT EXISTS `measurement_unit` (
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

CREATE TABLE IF NOT EXISTS `order_file` (
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

CREATE TABLE IF NOT EXISTS `order_macro_activity` (
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

CREATE TABLE IF NOT EXISTS `order_status` (
  `order_status_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `part`
--

CREATE TABLE IF NOT EXISTS `part` (
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
('01', 'Descrizione 2', 'MAKE', 10000, 'kg', 'PRODUCT', '01', 1, 10),
('02', 'Demodulator', 'MAKE', 2, 'kg', 'PRODUCT', '01', 1, 1),
('03', 'Converter', 'BUY', 5, 'pz', 'PRODUCT', '01', 10, 1),
('04', 'Jack', 'BUY', 10, 'pz', 'PRODUCT', '02', 1, 2),
('05', 'Mouse Wheel4', 'MAKE', 5, 'kg', 'ASSEMBLY', '01', 10, NULL),
('06', 'Board rz-048', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, 0),
('07', 'Led mm 02 red', 'MAKE', 5, 'pz', 'PRODUCT', '01', 2, NULL),
('08', 'Led mm 02 green', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, 0),
('09', 'RS232', 'BUY', 5, 'pz', 'PRODUCT', '01', 10, 0),
('10', 'RJ45', 'BUY', 10, 'pz', 'PRODUCT', '01', 1, 0),
('11', 'Cable', 'BUY', 5, 'pz', 'PRODUCT', '02', 10, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `part_category`
--

CREATE TABLE IF NOT EXISTS `part_category` (
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

CREATE TABLE IF NOT EXISTS `part_type` (
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
-- Struttura della tabella `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `store_code` int(11) NOT NULL,
  `part_code` varchar(40) NOT NULL,
  `quantity` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `stock_store`
--
CREATE TABLE IF NOT EXISTS `stock_store` (
`part_code` varchar(40)
,`store_code` int(11)
,`quantity` decimal(11,2)
,`name` varchar(45)
);
-- --------------------------------------------------------

--
-- Struttura della tabella `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `store_code` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id_user` int(11) NOT NULL,
  `id_access_level` int(11) NOT NULL,
  `full_name` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Users credentials';

--
-- Dump dei dati per la tabella `user`
-- ALL PASSWORDS ARE: 'password'

INSERT INTO `user` (`id_user`, `id_access_level`, `full_name`, `email`, `password`, `enabled`) VALUES
(1, 100, 'Administrator', 'admin@email.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1),
(2, 60, 'Manager', 'manager@email.it', '5f4dcc3b5aa765d61d8327deb882cf99', 1);

-- --------------------------------------------------------

--
-- Struttura per la vista `stock_store`
--
DROP TABLE IF EXISTS `stock_store`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_store` AS select `stock`.`part_code` AS `part_code`,`stock`.`store_code` AS `store_code`,`stock`.`quantity` AS `quantity`,`store`.`name` AS `name` from (`stock` join `store`) where (`store`.`store_code` = `stock`.`store_code`);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_level`
--
ALTER TABLE `access_level`
 ADD PRIMARY KEY (`id_access_level`);

--
-- Indexes for table `bom`
--
ALTER TABLE `bom`
 ADD PRIMARY KEY (`parent_part_code`,`child_part_code`), ADD KEY `fk_bom_part1_idx` (`child_part_code`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
 ADD PRIMARY KEY (`order_id`), ADD KEY `fk_order_customer1_idx` (`customer_id`), ADD KEY `fk_order_order_status1_idx` (`order_status_id`);

--
-- Indexes for table `file_type`
--
ALTER TABLE `file_type`
 ADD PRIMARY KEY (`file_type_id`);

--
-- Indexes for table `good_movement`
--
ALTER TABLE `good_movement`
 ADD PRIMARY KEY (`good_movement_id`), ADD KEY `fk_inventory_log_part1_idx` (`part_code`), ADD KEY `fk_inventory_log_store1_idx` (`store_code`);

--
-- Indexes for table `measurement_unit`
--
ALTER TABLE `measurement_unit`
 ADD PRIMARY KEY (`measurement_unit_code`);

--
-- Indexes for table `order_file`
--
ALTER TABLE `order_file`
 ADD PRIMARY KEY (`order_file_id`), ADD KEY `fk_order_file_order1_idx` (`order_id`), ADD KEY `fk_order_file_file_type1_idx` (`file_type_id`);

--
-- Indexes for table `order_macro_activity`
--
ALTER TABLE `order_macro_activity`
 ADD PRIMARY KEY (`activity_id`), ADD KEY `fk_order_macro_activity_order1_idx` (`order_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
 ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `part`
--
ALTER TABLE `part`
 ADD PRIMARY KEY (`part_code`), ADD KEY `fk_part_part_type1_idx` (`part_type_code`), ADD KEY `fk_part_part_category1_idx` (`part_category_code`), ADD KEY `fk_part_part_unit_type1_idx` (`measurement_unit_code`);

--
-- Indexes for table `part_category`
--
ALTER TABLE `part_category`
 ADD PRIMARY KEY (`part_category_code`);

--
-- Indexes for table `part_type`
--
ALTER TABLE `part_type`
 ADD PRIMARY KEY (`part_type_code`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
 ADD PRIMARY KEY (`store_code`,`part_code`), ADD KEY `fk_stock_part1_idx` (`part_code`), ADD KEY `fk_stock_store1_idx` (`store_code`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
 ADD PRIMARY KEY (`store_code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id_user`), ADD UNIQUE KEY `unique_email` (`email`), ADD KEY `fk_user_access_level_idx` (`id_access_level`), ADD KEY `idx_full_name` (`full_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_macro_activity`
--
ALTER TABLE `order_macro_activity`
MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
