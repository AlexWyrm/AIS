-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2014 at 05:34 
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `collector`
--

CREATE TABLE IF NOT EXISTS `collector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `passport` char(10) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passport` (`passport`),
  UNIQUE KEY `passport_2` (`passport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `collector`
--

INSERT INTO `collector` (`id`, `last_name`, `first_name`, `middle_name`, `passport`, `salary`) VALUES
(1, 'Писарьков', 'Александр', 'Сергеевич', '0001000002', NULL),
(2, 'Быкова', 'Юлия', 'Сергеевна', '0001000003', NULL),
(3, 'Зайберт', 'Валерия', 'Сергеевна', '0001000004', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE IF NOT EXISTS `contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_creditor` int(11) NOT NULL,
  `id_debtor` int(11) NOT NULL,
  `sum` decimal(10,2) NOT NULL,
  `residue` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_creditor` (`id_creditor`),
  KEY `id_debtor` (`id_debtor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`id`, `id_creditor`, `id_debtor`, `sum`, `residue`) VALUES
(11, 1, 3, '60000.00', '50000.00'),
(12, 1, 1, '200000.00', '92000.50'),
(13, 2, 1, '200000.00', '70000.00'),
(14, 1, 2, '60000.00', '60000.00'),
(19, 4, 6, '23456.00', '23456.00'),
(20, 4, 10, '98764.30', '98764.30'),
(21, 1, 11, '95000.70', '95000.70');

--
-- Triggers `contract`
--
DROP TRIGGER IF EXISTS `auto_job`;
DELIMITER //
CREATE TRIGGER `auto_job` AFTER INSERT ON `contract`
 FOR EACH ROW BEGIN 
INSERT INTO job (id_contract) values (NEW.id); 
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `residue_trigger`;
DELIMITER //
CREATE TRIGGER `residue_trigger` BEFORE INSERT ON `contract`
 FOR EACH ROW SET NEW.residue := NEW.sum
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `creditor`
--

CREATE TABLE IF NOT EXISTS `creditor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `registration_number` char(13) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_number` (`registration_number`),
  UNIQUE KEY `registration_number_2` (`registration_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `creditor`
--

INSERT INTO `creditor` (`id`, `name`, `registration_number`) VALUES
(1, 'ООО "Крыша"', '0000000000001'),
(2, 'ОАО "Вектор"', '0000000000002'),
(4, 'ОАО "Пирамида"', '0000000000003');

-- --------------------------------------------------------

--
-- Table structure for table `debtor`
--

CREATE TABLE IF NOT EXISTS `debtor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `passport` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passport` (`passport`),
  UNIQUE KEY `passport_2` (`passport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `debtor`
--

INSERT INTO `debtor` (`id`, `last_name`, `first_name`, `middle_name`, `passport`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', '0001000001'),
(2, 'Сидоров', 'Пётр', 'Петрович', '9999666666'),
(3, 'Петрова', 'Надежда', 'Ивановна', '6666999999'),
(6, 'Ольшанская', 'Лидия', 'Петровна', '0522045930'),
(10, 'Кошкина', 'Ирина', 'Борисовна', '0522053400'),
(11, 'Васильев', 'Иван', 'Петрович', '0522203700');

-- --------------------------------------------------------

--
-- Stand-in structure for view `debtor_info`
--
CREATE TABLE IF NOT EXISTS `debtor_info` (
`id` int(11)
,`last_name` varchar(30)
,`first_name` varchar(30)
,`middle_name` varchar(30)
,`passport` char(10)
,`sum` decimal(10,2)
,`residue` decimal(10,2)
,`id_creditor` int(11)
,`id_collector` int(11)
,`status` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_collector` int(11) DEFAULT NULL,
  `id_contract` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'В ожидании',
  `id_archive` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_collector` (`id_collector`),
  KEY `id_contract` (`id_contract`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`id`, `id_collector`, `id_contract`, `status`, `id_archive`) VALUES
(1, 2, 11, 'Дело в суде', NULL),
(2, 1, 12, 'Дело в суде', NULL),
(3, 1, 13, 'Взыскивается', NULL),
(4, NULL, 14, 'В ожидании', NULL),
(9, 1, 19, 'В ожидании', NULL),
(10, 1, 20, 'В ожидании', NULL),
(11, NULL, 21, 'В ожидании', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `job_info`
--
CREATE TABLE IF NOT EXISTS `job_info` (
`id` int(11)
,`id_collector` int(11)
,`id_contract` int(11)
,`sum` decimal(10,2)
,`residue` decimal(10,2)
,`last_name` varchar(30)
,`first_name` varchar(30)
,`middle_name` varchar(30)
,`passport` char(10)
,`status` varchar(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `job_info_extended`
--
CREATE TABLE IF NOT EXISTS `job_info_extended` (
`id` int(11)
,`last_name` varchar(30)
,`first_name` varchar(30)
,`middle_name` varchar(30)
,`passport` char(10)
,`sum` decimal(10,2)
,`residue` decimal(10,2)
,`id_collector` int(11)
,`collector` varchar(105)
,`status` varchar(20)
,`id_creditor` int(11)
,`creditor` varchar(116)
);
-- --------------------------------------------------------

--
-- Structure for view `debtor_info`
--
DROP TABLE IF EXISTS `debtor_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `debtor_info` AS select `debtor`.`id` AS `id`,`debtor`.`last_name` AS `last_name`,`debtor`.`first_name` AS `first_name`,`debtor`.`middle_name` AS `middle_name`,`debtor`.`passport` AS `passport`,`contract`.`sum` AS `sum`,`contract`.`residue` AS `residue`,`creditor`.`id` AS `id_creditor`,`job`.`id_collector` AS `id_collector`,`job`.`status` AS `status` from (((`debtor` left join `contract` on((`contract`.`id_debtor` = `debtor`.`id`))) left join `creditor` on((`contract`.`id_creditor` = `creditor`.`id`))) left join `job` on((`job`.`id_contract` = `contract`.`id`))) order by `debtor`.`last_name`;

-- --------------------------------------------------------

--
-- Structure for view `job_info`
--
DROP TABLE IF EXISTS `job_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `job_info` AS select `job`.`id` AS `id`,`job`.`id_collector` AS `id_collector`,`job`.`id_contract` AS `id_contract`,`contract`.`sum` AS `sum`,`contract`.`residue` AS `residue`,`debtor`.`last_name` AS `last_name`,`debtor`.`first_name` AS `first_name`,`debtor`.`middle_name` AS `middle_name`,`debtor`.`passport` AS `passport`,`job`.`status` AS `status` from ((`job` left join `contract` on((`job`.`id_contract` = `contract`.`id`))) left join `debtor` on((`contract`.`id_debtor` = `debtor`.`id`))) order by `debtor`.`last_name`;

-- --------------------------------------------------------

--
-- Structure for view `job_info_extended`
--
DROP TABLE IF EXISTS `job_info_extended`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `job_info_extended` AS select `job`.`id` AS `id`,`debtor`.`last_name` AS `last_name`,`debtor`.`first_name` AS `first_name`,`debtor`.`middle_name` AS `middle_name`,`debtor`.`passport` AS `passport`,`contract`.`sum` AS `sum`,`contract`.`residue` AS `residue`,`job`.`id_collector` AS `id_collector`,ifnull(concat(`collector`.`last_name`,' ',`collector`.`first_name`,' ',`collector`.`middle_name`,' (',`collector`.`passport`,')'),'Без привязки') AS `collector`,`job`.`status` AS `status`,`contract`.`id_creditor` AS `id_creditor`,concat(`creditor`.`name`,' (',`creditor`.`registration_number`,')') AS `creditor` from ((((`contract` join `job` on((`job`.`id_contract` = `contract`.`id`))) left join `collector` on((`job`.`id_collector` = `collector`.`id`))) join `creditor` on((`contract`.`id_creditor` = `creditor`.`id`))) join `debtor` on((`contract`.`id_debtor` = `debtor`.`id`))) order by `job`.`id`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`id_creditor`) REFERENCES `creditor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`id_debtor`) REFERENCES `debtor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`id_collector`) REFERENCES `collector` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `job_ibfk_2` FOREIGN KEY (`id_contract`) REFERENCES `contract` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
