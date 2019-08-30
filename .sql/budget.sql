-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 30 2019 г., 11:53
-- Версия сервера: 10.1.34-MariaDB-1~jessie
-- Версия PHP: 5.6.36-0+deb8u1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `budget`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ref_customer_profitability`
--

DROP TABLE IF EXISTS `ref_customer_profitability`;
CREATE TABLE `ref_customer_profitability` (
  `customer` int(11) NOT NULL DEFAULT '0',
  `activity` int(11) NOT NULL,
  `Revenue` decimal(15,2) DEFAULT NULL,
  `GP` decimal(38,2) DEFAULT NULL,
  `Profitability` decimal(4,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ref_distr`
--

DROP TABLE IF EXISTS `ref_distr`;
CREATE TABLE `ref_distr` (
  `pc` char(36) NOT NULL,
  `activity` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ref_route`
--

DROP TABLE IF EXISTS `ref_route`;
CREATE TABLE `ref_route` (
  `pol_country` varchar(2) DEFAULT NULL,
  `pod_country` varchar(2) DEFAULT NULL,
  `route` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ref_route`
--

INSERT INTO `ref_route` (`pol_country`, `pod_country`, `route`) VALUES
('AE', 'RU', 2),
('BD', 'MY', 2),
('BD', 'RU', 2),
('BE', 'RU', 9),
('BG', 'RU', 9),
('BH', 'RU', 2),
('BR', 'NL', 4),
('BR', 'RU', 4),
('CA', 'RU', 3),
('CN', 'DE', 2),
('CN', 'FI', 2),
('CN', 'NL', 2),
('CN', 'RU', 2),
('CN', 'UA', 2),
('CO', 'RU', 4),
('DE', 'RU', 9),
('DJ', 'RU', 10),
('ES', 'RU', 9),
('GB', 'RU', 9),
('GR', 'RU', 9),
('HK', 'NL', 2),
('HK', 'RU', 2),
('ID', 'NL', 2),
('ID', 'RU', 2),
('IL', 'RU', 9),
('IN', 'RU', 2),
('IT', 'RU', 9),
('JP', 'CN', 1),
('JP', 'EE', 1),
('JP', 'LT', 1),
('JP', 'NL', 1),
('JP', 'RU', 1),
('KH', 'RU', 2),
('KR', 'DE', 2),
('KR', 'RU', 2),
('LK', 'RU', 2),
('MY', 'DE', 2),
('MY', 'PL', 2),
('MY', 'RU', 2),
('NL', 'RU', 9),
('PH', 'RU', 2),
('PK', 'RU', 2),
('RU', 'AE', 8),
('RU', 'BD', 6),
('RU', 'BG', 9),
('RU', 'BH', 6),
('RU', 'CN', 6),
('RU', 'CO', 8),
('RU', 'EG', 12),
('RU', 'ID', 6),
('RU', 'IN', 6),
('RU', 'JP', 5),
('RU', 'KR', 6),
('RU', 'LB', 6),
('RU', 'MA', 12),
('RU', 'MX', 7),
('RU', 'OM', 6),
('RU', 'PE', 8),
('RU', 'RU', 2),
('RU', 'SG', 6),
('RU', 'TH', 6),
('RU', 'TR', 9),
('RU', 'US', 7),
('RU', 'UY', 8),
('RU', 'VN', 6),
('SA', 'RU', 2),
('SG', 'GR', 2),
('SG', 'RU', 2),
('SG', 'US', 2),
('TH', 'GR', 2),
('TH', 'NL', 2),
('TH', 'RU', 2),
('TR', 'RU', 9),
('TW', 'GR', 2),
('TW', 'NL', 2),
('TW', 'RU', 2),
('US', 'DE', 3),
('US', 'NL', 3),
('US', 'RU', 3),
('VN', 'DE', 2),
('VN', 'HK', 2),
('VN', 'RU', 2),
('VN', 'SG', 2),
('CN', 'GE', 2),
('CZ', 'RU', 9),
('RU', 'IT', 9),
('RU', 'GE', 9),
('CZ', 'US', 7),
('AU', 'RU', 2),
('RU', 'BR', 8),
('RU', 'IQ', 6),
('RU', 'TW', 6),
('RU', 'PH', 6),
('RU', 'GB', 9),
('CN', 'US', 1),
('PT', 'RU', 2),
('AR', 'RU', 4),
('CR', 'RU', 4),
('DO', 'RU', 1),
('HN', 'RU', 4),
('CN', 'FR', 2),
('RU', 'MY', 6),
('RU', 'ES', 9),
('JP', 'FI', 2),
('AU', 'FI', 2),
('US', 'FI', 9),
('RU', 'DZ', 12),
('CN', 'LT', 2),
('RU', 'DE', 9),
('RU', 'FR', 9),
('EG', 'RU', 10),
('MM', 'RU', 2),
('TW', 'LT', 2),
('RU', 'AU', 13),
('RU', 'ME', 9),
('RU', 'CZ', 9),
('RU', 'AR', 8),
('RU', 'GT', 8),
('RU', 'ZA', 12),
('FI', 'HK', 6),
('RU', 'BE', 9),
('CN', 'CN', 2),
('RU', 'SA', 8),
('RU', 'PK', 2),
('US', 'JP', 5),
('RU', 'KZ', 6),
('RU', 'CL', 8),
('TH', 'AG', 2),
('JP', 'DE', 2),
('FR', 'RU', 9),
('RU', 'CR', 8),
('FI', 'FI', 9),
('KR', 'PL', 2),
('PH', 'NL', 2),
('RU', 'MQ', 12),
('RU', 'NG', 12),
('TW', 'FI', 2),
('JP', 'JP', 1),
('IN', 'LK', 2),
('RU', 'GR', 9),
('CN', 'KR', 2),
('JP', 'LV', 1),
('MX', 'RU', 4),
('RU', 'AT', 9),
('TH', 'AE', 8),
('MY', 'KR', 2),
('RU', 'DO', 8),
('RU', 'EC', 8),
('US', 'BE', 3),
('JP', 'KR', 1),
('QA', 'AL', 2),
('RU', 'HK', 6),
('CN', 'TH', 2),
('RU', 'PT', 9),
('RU', 'AO', 12),
('RU', 'CY', 9),
('RU', 'IE', 9),
('RU', 'PA', 8),
('RU', 'BB', 8),
('RU', 'HR', 9),
('KR', 'NL', 2),
('DE', 'NL', 9),
('FI', 'TW', 6),
('PL', 'RU', 9),
('US', 'EE', 3),
('LV', 'RU', 9),
('TH', 'SA', 8),
('DE', 'PL', 9),
('US', 'US', 9),
('VN', 'CA', 0),
('BM', 'RU', 4),
('CN', 'ZA', 2),
('ZA', 'RU', 2),
('CH', 'RU', 9),
('NL', 'PL', 9),
('RU', 'AM', 9),
('RU', 'HU', 9),
('AU', 'LT', 9),
('RU', 'CA', 7),
('KR', 'TH', 0),
('DE', 'FI', 9),
('HK', 'FI', 2),
('PE', 'RU', 4),
('RU', 'NL', 9),
('RU', 'JM', 8),
('RU', 'SD', 12),
('RU', 'IL', 9),
('RU', 'MT', 9),
('BD', 'LK', 0),
('AQ', 'RU', 2),
('SG', 'SG', 0),
('HK', 'HK', 0),
('KR', 'KR', 0),
('TR', 'AE', 0),
('GB', 'CN', 0),
('MY', 'NL', 0),
('TW', 'LV', 0),
('RU', 'TG', 0),
('MA', 'RU', 0),
('MY', 'CN', 0),
('PH', 'DE', 0),
('CN', 'EE', 0),
('FI', 'CN', 0),
('IN', 'GR', 0),
('RU', 'AG', 0),
('TW', 'PT', 0),
('CL', 'RU', 0),
('TZ', 'RU', 0),
('CN', 'GB', 0),
('RU', 'MD', 0),
('RU', 'CI', 0),
('SG', 'LT', 0),
('CN', 'HK', 0),
('RU', 'SI', 0),
('DE', 'IN', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `reg_costs`
--

DROP TABLE IF EXISTS `reg_costs`;
CREATE TABLE `reg_costs` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) NOT NULL DEFAULT '0',
  `product` int(11) NOT NULL DEFAULT '0',
  `supplier` int(11) NOT NULL DEFAULT '0',
  `agreement` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(20) NOT NULL DEFAULT 'Pieces',
  `buying_curr` char(3) NOT NULL DEFAULT 'RUB',
  `buying_rate` decimal(18,6) NOT NULL DEFAULT '0.000000',
  `period` enum('monthly','annual') NOT NULL DEFAULT 'monthly',
  `item` char(36) NOT NULL,
  `jan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `apr` decimal(15,2) NOT NULL DEFAULT '0.00',
  `may` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jun` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jul` decimal(15,2) NOT NULL DEFAULT '0.00',
  `aug` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sep` decimal(15,2) NOT NULL DEFAULT '0.00',
  `oct` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nov` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dec` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_depreciation`
--

DROP TABLE IF EXISTS `reg_depreciation`;
CREATE TABLE `reg_depreciation` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) NOT NULL DEFAULT '0',
  `customer` int(11) NOT NULL DEFAULT '0',
  `item` char(36) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `value_start` decimal(10,2) NOT NULL DEFAULT '0.00',
  `value_primo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `value_ultimo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date_start` date NOT NULL DEFAULT '2014-01-01',
  `date_end` date NOT NULL DEFAULT '2014-12-31',
  `replace` tinyint(1) NOT NULL DEFAULT '0',
  `jan` int(11) NOT NULL DEFAULT '0',
  `feb` int(11) NOT NULL DEFAULT '0',
  `mar` int(11) NOT NULL DEFAULT '0',
  `apr` int(11) NOT NULL DEFAULT '0',
  `may` int(11) NOT NULL DEFAULT '0',
  `jun` int(11) NOT NULL DEFAULT '0',
  `jul` int(11) NOT NULL DEFAULT '0',
  `aug` int(11) NOT NULL DEFAULT '0',
  `sep` int(11) NOT NULL DEFAULT '0',
  `oct` int(11) NOT NULL DEFAULT '0',
  `nov` int(11) NOT NULL DEFAULT '0',
  `dec` int(11) NOT NULL DEFAULT '0',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `particulars` char(36) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '1',
  `location` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_headcount`
--

DROP TABLE IF EXISTS `reg_headcount`;
CREATE TABLE `reg_headcount` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `location` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `account` varchar(6) NOT NULL,
  `item` char(36) NOT NULL,
  `jan` decimal(10,2) NOT NULL DEFAULT '0.00',
  `feb` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mar` decimal(10,2) NOT NULL DEFAULT '0.00',
  `apr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `may` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jun` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jul` decimal(10,2) NOT NULL DEFAULT '0.00',
  `aug` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sep` decimal(10,2) NOT NULL DEFAULT '0.00',
  `oct` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nov` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dec` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jan_1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `particulars` char(36) DEFAULT NULL,
  `function` char(36) DEFAULT NULL,
  `clothes` tinyint(4) DEFAULT '0',
  `pc_profile` tinyint(4) DEFAULT '0',
  `mobile_limit` decimal(10,2) DEFAULT '0.00',
  `fuel` decimal(10,2) DEFAULT '0.00',
  `insurance` decimal(10,2) DEFAULT '0.00',
  `salary` decimal(10,2) DEFAULT '0.00',
  `review_date` date DEFAULT NULL,
  `monthly_bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `wc` tinyint(1) NOT NULL DEFAULT '1',
  `vks` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `new_fte` decimal(10,1) NOT NULL DEFAULT '0.0',
  `sales` int(11) DEFAULT NULL,
  `compensation` decimal(10,2) DEFAULT NULL,
  `sga` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_interco_sales`
--

DROP TABLE IF EXISTS `reg_interco_sales`;
CREATE TABLE `reg_interco_sales` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) NOT NULL DEFAULT '0',
  `activity_cost` int(11) NOT NULL DEFAULT '0',
  `customer` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(20) NOT NULL DEFAULT 'TEU',
  `selling_curr` char(3) NOT NULL DEFAULT 'RUB',
  `buying_curr` char(3) NOT NULL DEFAULT 'RUB',
  `selling_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `buying_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jan` int(11) NOT NULL DEFAULT '0',
  `feb` int(11) NOT NULL DEFAULT '0',
  `mar` int(11) NOT NULL DEFAULT '0',
  `apr` int(11) NOT NULL DEFAULT '0',
  `may` int(11) NOT NULL DEFAULT '0',
  `jun` int(11) NOT NULL DEFAULT '0',
  `jul` int(11) NOT NULL DEFAULT '0',
  `aug` int(11) NOT NULL DEFAULT '0',
  `sep` int(11) NOT NULL DEFAULT '0',
  `oct` int(11) NOT NULL DEFAULT '0',
  `nov` int(11) NOT NULL DEFAULT '0',
  `dec` int(11) NOT NULL DEFAULT '0',
  `jan_1` int(11) NOT NULL DEFAULT '0',
  `feb_1` int(11) NOT NULL DEFAULT '0',
  `mar_1` int(11) NOT NULL DEFAULT '0',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `kpi` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: include to KPI summary',
  `sales` varchar(50) DEFAULT NULL COMMENT 'Responsible BDV person FK:stbl_user',
  `bdv` int(11) NOT NULL DEFAULT '0' COMMENT 'Selling department',
  `customer_group_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_master`
--

DROP TABLE IF EXISTS `reg_master`;
CREATE TABLE `reg_master` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) NOT NULL DEFAULT '0',
  `customer` int(11) NOT NULL DEFAULT '0',
  `account` varchar(6) NOT NULL,
  `item` char(36) NOT NULL,
  `jan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `apr` decimal(15,2) NOT NULL DEFAULT '0.00',
  `may` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jun` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jul` decimal(15,2) NOT NULL DEFAULT '0.00',
  `aug` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sep` decimal(15,2) NOT NULL DEFAULT '0.00',
  `oct` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nov` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dec` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) NOT NULL,
  `scenario` varchar(20) NOT NULL,
  `particulars` char(36) DEFAULT NULL,
  `part_type` enum('FIX','EMP','SUP','FUT') DEFAULT NULL,
  `estimate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `vat` int(11) UNSIGNED DEFAULT NULL,
  `deductible` tinyint(4) DEFAULT NULL,
  `cf` tinyint(4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ytd` decimal(15,2) NOT NULL DEFAULT '0.00',
  `roy` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sales` varchar(50) DEFAULT NULL COMMENT 'Responsible BDV person FK:stbl_user',
  `route` int(11) DEFAULT NULL,
  `bdv` int(11) NOT NULL DEFAULT '0' COMMENT 'Selling department',
  `customer_group_code` int(11) DEFAULT NULL,
  `new` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_msf`
--

DROP TABLE IF EXISTS `reg_msf`;
CREATE TABLE `reg_msf` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(20) NOT NULL DEFAULT 'FTE',
  `jan` decimal(10,2) NOT NULL DEFAULT '0.00',
  `feb` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mar` decimal(10,2) NOT NULL DEFAULT '0.00',
  `apr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `may` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jun` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jul` decimal(10,2) NOT NULL DEFAULT '0.00',
  `aug` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sep` decimal(10,2) NOT NULL DEFAULT '0.00',
  `oct` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nov` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dec` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `item` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_profit_ghq`
--

DROP TABLE IF EXISTS `reg_profit_ghq`;
CREATE TABLE `reg_profit_ghq` (
  `scenario` varchar(20) DEFAULT NULL,
  `pc` int(11) NOT NULL DEFAULT '1',
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `prtGHQ` varchar(50) DEFAULT NULL,
  `jan` decimal(32,2) DEFAULT NULL,
  `feb` decimal(32,2) DEFAULT NULL,
  `mar` decimal(32,2) DEFAULT NULL,
  `apr` decimal(32,2) DEFAULT NULL,
  `may` decimal(32,2) DEFAULT NULL,
  `jun` decimal(32,2) DEFAULT NULL,
  `jul` decimal(32,2) DEFAULT NULL,
  `aug` decimal(32,2) DEFAULT NULL,
  `sep` decimal(32,2) DEFAULT NULL,
  `oct` decimal(32,2) DEFAULT NULL,
  `nov` decimal(32,2) DEFAULT NULL,
  `dec` decimal(32,2) DEFAULT NULL,
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `estimate` decimal(37,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_rent`
--

DROP TABLE IF EXISTS `reg_rent`;
CREATE TABLE `reg_rent` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `customer` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(20) NOT NULL DEFAULT 'sqm',
  `jan` decimal(10,2) NOT NULL DEFAULT '0.00',
  `feb` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mar` decimal(10,2) NOT NULL DEFAULT '0.00',
  `apr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `may` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jun` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jul` decimal(10,2) NOT NULL DEFAULT '0.00',
  `aug` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sep` decimal(10,2) NOT NULL DEFAULT '0.00',
  `oct` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nov` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dec` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `pc` int(11) NOT NULL DEFAULT '5',
  `activity` int(11) DEFAULT NULL,
  `item` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_sales`
--

DROP TABLE IF EXISTS `reg_sales`;
CREATE TABLE `reg_sales` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) NOT NULL DEFAULT '0',
  `product` int(11) NOT NULL DEFAULT '0',
  `customer` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(20) NOT NULL DEFAULT 'TEU',
  `selling_curr` char(3) NOT NULL DEFAULT 'RUB',
  `buying_curr` char(3) NOT NULL DEFAULT 'RUB',
  `selling_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `buying_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jan` int(11) NOT NULL DEFAULT '0',
  `feb` int(11) NOT NULL DEFAULT '0',
  `mar` int(11) NOT NULL DEFAULT '0',
  `apr` int(11) NOT NULL DEFAULT '0',
  `may` int(11) NOT NULL DEFAULT '0',
  `jun` int(11) NOT NULL DEFAULT '0',
  `jul` int(11) NOT NULL DEFAULT '0',
  `aug` int(11) NOT NULL DEFAULT '0',
  `sep` int(11) NOT NULL DEFAULT '0',
  `oct` int(11) NOT NULL DEFAULT '0',
  `nov` int(11) NOT NULL DEFAULT '0',
  `dec` int(11) NOT NULL DEFAULT '0',
  `jan_1` int(11) NOT NULL DEFAULT '0',
  `feb_1` int(11) NOT NULL DEFAULT '0',
  `mar_1` int(11) NOT NULL DEFAULT '0',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `particulars` char(36) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `formula` varchar(255) NOT NULL DEFAULT '',
  `kpi` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: include to KPI summary',
  `sales` varchar(50) DEFAULT NULL COMMENT 'Responsible BDV person FK:stbl_user',
  `route` int(11) DEFAULT NULL,
  `hbl` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'In scope of HBL/HAWB',
  `bdv` int(11) NOT NULL DEFAULT '0' COMMENT 'Selling department',
  `customer_group_code` int(11) DEFAULT NULL,
  `bo` int(11) NOT NULL DEFAULT '714' COMMENT 'Business owner',
  `jo` int(11) DEFAULT NULL,
  `freehand` tinyint(1) NOT NULL DEFAULT '0',
  `pol` varchar(5) DEFAULT NULL,
  `pod` varchar(5) DEFAULT NULL,
  `gbr` tinyint(4) DEFAULT NULL,
  `new` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_sales_rhq`
--

DROP TABLE IF EXISTS `reg_sales_rhq`;
CREATE TABLE `reg_sales_rhq` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `ghq` varchar(50) NOT NULL DEFAULT '[None]',
  `customer` int(11) NOT NULL DEFAULT '0',
  `account` varchar(255) NOT NULL DEFAULT 'Revenue (local)',
  `jan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `apr` decimal(15,2) NOT NULL DEFAULT '0.00',
  `may` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jun` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jul` decimal(15,2) NOT NULL DEFAULT '0.00',
  `aug` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sep` decimal(15,2) NOT NULL DEFAULT '0.00',
  `oct` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nov` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dec` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `sales` varchar(50) DEFAULT NULL COMMENT 'Responsible BDV person FK:stbl_user',
  `hbl` tinyint(1) NOT NULL DEFAULT '0',
  `bdv` int(11) DEFAULT '0',
  `customer_group_code` int(11) DEFAULT NULL,
  `bo` int(11) NOT NULL DEFAULT '0',
  `jo` int(11) NOT NULL DEFAULT '0',
  `da` int(11) NOT NULL DEFAULT '0',
  `freehand` tinyint(1) NOT NULL DEFAULT '0',
  `gbr` tinyint(4) DEFAULT NULL,
  `new` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_summary`
--

DROP TABLE IF EXISTS `reg_summary`;
CREATE TABLE `reg_summary` (
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `pccFlagProd` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'PC is production center',
  `activity` int(11) NOT NULL DEFAULT '0',
  `account` varchar(6) NOT NULL,
  `item` char(36) NOT NULL,
  `scenario` varchar(20) NOT NULL,
  `jan` decimal(37,2) DEFAULT NULL,
  `feb` decimal(37,2) DEFAULT NULL,
  `mar` decimal(37,2) DEFAULT NULL,
  `apr` decimal(37,2) DEFAULT NULL,
  `may` decimal(37,2) DEFAULT NULL,
  `jun` decimal(37,2) DEFAULT NULL,
  `jul` decimal(37,2) DEFAULT NULL,
  `aug` decimal(37,2) DEFAULT NULL,
  `sep` decimal(37,2) DEFAULT NULL,
  `oct` decimal(37,2) DEFAULT NULL,
  `nov` decimal(37,2) DEFAULT NULL,
  `dec` decimal(37,2) DEFAULT NULL,
  `jan_1` decimal(37,2) DEFAULT NULL,
  `feb_1` decimal(37,2) DEFAULT NULL,
  `mar_1` decimal(37,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reg_vehicles`
--

DROP TABLE IF EXISTS `reg_vehicles`;
CREATE TABLE `reg_vehicles` (
  `id` int(11) NOT NULL,
  `company` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `pc` int(11) NOT NULL DEFAULT '1',
  `activity` int(11) NOT NULL DEFAULT '0',
  `particulars` char(36) DEFAULT '',
  `jan` int(10) NOT NULL DEFAULT '0',
  `feb` int(10) NOT NULL DEFAULT '0',
  `mar` int(10) NOT NULL DEFAULT '0',
  `apr` int(10) NOT NULL DEFAULT '0',
  `may` int(10) NOT NULL DEFAULT '0',
  `jun` int(10) NOT NULL DEFAULT '0',
  `jul` int(10) NOT NULL DEFAULT '0',
  `aug` int(10) NOT NULL DEFAULT '0',
  `sep` int(10) NOT NULL DEFAULT '0',
  `oct` int(10) NOT NULL DEFAULT '0',
  `nov` int(10) NOT NULL DEFAULT '0',
  `dec` int(10) NOT NULL DEFAULT '0',
  `jan_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `feb_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mar_1` decimal(15,2) NOT NULL DEFAULT '0.00',
  `source` char(36) DEFAULT NULL,
  `scenario` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `posted` tinyint(4) NOT NULL DEFAULT '0',
  `value_primo` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_action`
--

DROP TABLE IF EXISTS `stbl_action`;
CREATE TABLE `stbl_action` (
  `actID` varchar(20) NOT NULL,
  `actGUID` char(36) DEFAULT '0',
  `actTitle` varchar(255) NOT NULL DEFAULT '',
  `actTitleLocal` varchar(255) NOT NULL DEFAULT '',
  `actTitlePast` varchar(255) DEFAULT NULL,
  `actTitlePastLocal` varchar(255) DEFAULT NULL,
  `actDescription` text,
  `actDescriptionLocal` text,
  `actFlagDeleted` tinyint(1) DEFAULT '0',
  `actClass` varchar(50) DEFAULT NULL,
  `actFlagComment` tinyint(1) DEFAULT '0' COMMENT 'Mandatory comment on action',
  `actFlagSystem` tinyint(1) DEFAULT '0' COMMENT 'Hide in the matrix',
  `actFlagValidate` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Validation is needed',
  `actFlagInsert` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Action can be performed by record creator',
  `actFlagEdit` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Action can be performed by the last editor',
  `actInsertBy` varchar(50) DEFAULT NULL,
  `actInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `actEditBy` varchar(50) DEFAULT NULL,
  `actEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stbl_action`
--

INSERT INTO `stbl_action` (`actID`, `actGUID`, `actTitle`, `actTitleLocal`, `actTitlePast`, `actTitlePastLocal`, `actDescription`, `actDescriptionLocal`, `actFlagDeleted`, `actClass`, `actFlagComment`, `actFlagSystem`, `actFlagValidate`, `actFlagInsert`, `actFlagEdit`, `actInsertBy`, `actInsertDate`, `actEditBy`, `actEditDate`) VALUES
('classify', 'a69f8d54-40cb-11e5-bba0-9d7266a91b8a', 'Classify', 'Засекретить', 'Classified', 'Засекречен', NULL, NULL, 0, 'delete', 0, 0, 1, 1, 1, NULL, '2015-08-12 08:27:33', NULL, NULL),
('post', '56C1D60A-D9E7-41CE-9691-F2654C7B4ADD', 'Post', 'Провести', 'Posted', 'Проведен', NULL, NULL, 0, 'accept', 0, 0, 1, 1, 1, NULL, '2013-10-23 13:31:57', NULL, NULL),
('unpost', '566A7B6F-8E06-4213-9134-783AE60F3C33', 'Unport', 'Отменить проведение', 'Unposted', 'Снято с проведения', NULL, NULL, 0, NULL, 0, 0, 1, 1, 1, NULL, '2013-10-23 13:32:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_action_log`
--

DROP TABLE IF EXISTS `stbl_action_log`;
CREATE TABLE `stbl_action_log` (
  `aclID` int(11) NOT NULL,
  `aclEntityID` varchar(20) DEFAULT NULL COMMENT 'FK: stbl_entity',
  `aclGUID` char(36) NOT NULL DEFAULT '' COMMENT 'Target entity GUID',
  `aclActionID` varchar(20) NOT NULL COMMENT 'FK: stbl_action',
  `aclComment` text,
  `aclInsertBy` varchar(50) NOT NULL DEFAULT '',
  `aclInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aclScenarioID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_attribute`
--

DROP TABLE IF EXISTS `stbl_attribute`;
CREATE TABLE `stbl_attribute` (
  `atrID` varchar(20) NOT NULL,
  `atrGUID` char(36) DEFAULT NULL,
  `atrEntityID` varchar(30) NOT NULL,
  `atrTitle` varchar(255) DEFAULT NULL,
  `atrTitleLocal` varchar(255) DEFAULT NULL,
  `atrFieldName` varchar(255) DEFAULT NULL,
  `atrType` varchar(20) DEFAULT NULL,
  `atrOrder` int(11) DEFAULT '10' COMMENT 'Defines order how this attribute appears on screen',
  `atrHref` varchar(50) DEFAULT NULL COMMENT 'HREF attribute for PHPLister',
  `atrFlagPK` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PK attribute for PHPLister',
  `atrFlagFilter` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PK attribute for PHPLister',
  `atrFlagShowInForm` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PK attribute for PHPLister',
  `atrFlagShowInList` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'PHP Lister: show field in the list',
  `atrFlagEditable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PK attribute for PHPLister',
  `atrFlagMonitor` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PK attribute for PHPLister',
  `atrTab` tinyint(4) DEFAULT NULL COMMENT 'Tabsheet index, if any',
  `atrGroup` varchar(64) DEFAULT NULL COMMENT 'Fieldset name',
  `atrGroupLocal` varchar(128) DEFAULT NULL COMMENT 'Fieldset name in Russian',
  `atrProperties` varchar(255) NOT NULL DEFAULT '',
  `atrDefault` varchar(255) DEFAULT NULL,
  `atrProgrammerReserved` text,
  `atrSql` text COMMENT 'SQL for combobox',
  `atrMatrix` text COMMENT 'Criteria for the matrix, with AND superposition',
  `atrTable` varchar(40) NOT NULL DEFAULT '' COMMENT 'Properties for ''ajax'' fields',
  `atrPrefix` char(3) NOT NULL DEFAULT '' COMMENT 'Properties for ''ajax'' fields',
  `atrCheckMask` varchar(255) NOT NULL DEFAULT '',
  `atrFlagDeleted` int(11) NOT NULL DEFAULT '0',
  `atrInsertBy` varchar(50) DEFAULT 'admin',
  `atrInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `atrEditBy` varchar(50) DEFAULT NULL,
  `atrEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Defines entity attributes';

--
-- Дамп данных таблицы `stbl_attribute`
--

INSERT INTO `stbl_attribute` (`atrID`, `atrGUID`, `atrEntityID`, `atrTitle`, `atrTitleLocal`, `atrFieldName`, `atrType`, `atrOrder`, `atrHref`, `atrFlagPK`, `atrFlagFilter`, `atrFlagShowInForm`, `atrFlagShowInList`, `atrFlagEditable`, `atrFlagMonitor`, `atrTab`, `atrGroup`, `atrGroupLocal`, `atrProperties`, `atrDefault`, `atrProgrammerReserved`, `atrSql`, `atrMatrix`, `atrTable`, `atrPrefix`, `atrCheckMask`, `atrFlagDeleted`, `atrInsertBy`, `atrInsertDate`, `atrEditBy`, `atrEditDate`) VALUES
('calComment', '4765e5b3-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Comment', 'Комментарий', 'calComment', 'text', 60, '', 0, 0, 1, 0, 1, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-03-25 10:42:06'),
('calDateEnd', '4765e2ee-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Date end', 'Конечная дата', 'calDateEnd', 'date', 60, '', 0, 0, 1, 0, 1, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-02-08 21:39:18'),
('calDateStart', '4765e0e4-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Date start', 'Начальная дата', 'calDateStart', 'date', 50, '', 0, 0, 1, 0, 1, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2011-10-06 10:59:57'),
('calEditBy', '4765ee94-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Editor', 'Редактор', 'calEditBy', 'combobox', 9020, '', 0, 0, 1, 0, 0, 0, NULL, 'Timestamps', 'Информация о редактировании', '', '', 'stbl_user', '', '', 'stbl_user', 'usr', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-01-16 09:12:23'),
('calEditDate', '4765f0aa-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Edited', 'Дата изменения', 'calEditDate', 'datetime', 9030, '', 0, 0, 1, 0, 0, 0, NULL, 'Timestamps', 'Информация о редактировании', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-03-28 09:46:48'),
('calFlagDeleted', '4765dc80-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Deleted', 'Удален', 'calFlagDeleted', 'boolean', 30, '', 0, 0, 1, 0, 1, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-03-25 10:42:48'),
('calGUID', '4765d450-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'GUID', 'ГУИД', 'calGUID', 'guid', 20, '', 0, 0, 0, 0, 0, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2011-10-06 10:55:37'),
('calID', '4764a82f-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'ID', 'Код', 'calID', 'varchar', 10, '', 1, 0, 1, 0, 0, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2011-10-06 10:55:24'),
('calInsertBy', '4765e8c9-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Author', 'Автор', 'calInsertBy', 'combobox', 9000, '', 0, 0, 1, 0, 0, 0, NULL, 'Timestamps', 'Информация о редактировании', '', '', 'stbl_user', '', '', 'stbl_user', 'usr', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-02-03 08:05:17'),
('calInsertDate', '4765ec67-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Created on', 'Дата создания', 'calInsertDate', 'datetime', 9010, '', 0, 0, 1, 0, 0, 0, NULL, 'Timestamps', 'Информация о редактировании', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-01-16 09:13:07'),
('calTitle', '4765d7b5-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Title', 'Наименование на английском', 'calTitle', 'varchar', 30, '', 0, 0, 1, 1, 1, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-03-25 10:40:11'),
('calTitleLocal', '4765da34-d0fb-102e-beca-e3a593edeede', 'tbl_calendar', 'Title in Russian', 'По-русски', 'calTitleLocal', 'varchar', 40, '', 0, 0, 1, 0, 1, 0, NULL, '', '', '', '', '', '', '', '', '', '', 0, 'admin', '2011-05-16 02:56:18', 'ZHURAVLEV', '2012-03-25 10:40:28'),
('cemComment', '6520784c-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Comment', 'Комментарий', 'cemComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemEditBy', '6521beb7-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Editor', 'Редактор', 'cemEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemEditDate', '6521c361-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Edited', 'Дата изменения', 'cemEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemFlagDeleted', '65207b47-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Deleted', 'Удален', 'cemFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemFlagPosted', '65207e0a-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Posted', 'Проведен', 'cemFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemGUID', '6520746b-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'GUID', 'GUID', 'cemGUID', 'guid', 20, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemHeadcount', '18d5fa2f-6006-11e4-89b0-466732c33de6', 'tbl_current_employee', 'Headcount', 'Количество', 'cemHeadcount', 'decimal', 51, NULL, 0, 0, 0, 1, 1, 0, NULL, NULL, NULL, '', NULL, '', NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemID', '65207009-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'ID', 'ID', 'cemID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemInsertBy', '65207f7c-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Author', 'Автор', 'cemInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemInsertDate', '652080fd-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Created on', 'Дата создания', 'cemInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemOvertime', '66dbe0a5-4212-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Overtime, %', 'Overtime', 'cemOvertime', 'int', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-31 01:54:47', 'admin', '2013-10-31 09:54:47'),
('cemProfitID', '65207715-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Profit center', 'ЦФО', 'cemProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemScenario', '652075ce-419b-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Scenario', 'Сценарий', 'cemScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('cemTurnover', '66dbde36-4212-11e3-ad19-9b24e3067432', 'tbl_current_employee', 'Turnover, %', 'Turnover', 'cemTurnover', 'int', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-31 01:54:47', 'admin', '2013-10-31 09:54:47'),
('depComment', '2b43149f-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Comment', 'Комментарий', 'depComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depEditBy', '2b43278d-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Editor', 'Редактор', 'depEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depEditDate', '2b432d85-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Edited', 'Дата изменения', 'depEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depFlagDeleted', '2b4317cd-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Deleted', 'Удален', 'depFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depFlagPosted', '2b431a73-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Posted', 'Проведен', 'depFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depGUID', '2b4309f1-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'GUID', 'GUID', 'depGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depID', '2b3f7137-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'ID', 'ID', 'depID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depInsertBy', '2b431d9d-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Author', 'Автор', 'depInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depInsertDate', '2b4321aa-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Created on', 'Дата создания', 'depInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depProfitID', '2b431184-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Profit center', 'ЦФО', 'depProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('depScenario', '2b430e7e-46bd-11e3-92a1-2fdab601e36f', 'tbl_depreciation', 'Scenario', 'Сценарий', 'depScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-06 00:26:57', 'admin', '2013-11-06 08:26:57'),
('genComment', 'd64c1eba-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Comment', 'Комментарий', 'genComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genEditBy', 'd64c2906-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Editor', 'Редактор', 'genEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genEditDate', 'd64c2a48-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Edited', 'Дата изменения', 'genEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genFlagDeleted', 'd64c1feb-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Deleted', 'Удален', 'genFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genFlagPosted', 'd64c2114-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Posted', 'Проведен', 'genFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genGUID', 'd64c18f9-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'GUID', 'GUID', 'genGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genID', 'd64c13e7-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'ID', 'ID', 'genID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genInsertBy', 'd64c228d-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Author', 'Автор', 'genInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genInsertDate', 'd64c23d7-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Created on', 'Дата создания', 'genInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genItemGUID', 'd64c1d53-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Cost item', 'Статья затрат', 'genItemGUID', 'combobox', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_item', NULL, NULL, 'vw_item', 'itm', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genScenario', 'd64c1a76-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Scenario', 'Сценарий', 'genScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('genSupplierID', 'd64c1bfe-4db4-11e3-8c40-13216cbd6eee', 'tbl_general_costs', 'Supplier', 'Подрядчик', 'genSupplierID', 'ajax', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_supplier', NULL, NULL, 'vw_supplier', 'cnt', '', 0, 'admin', '2013-11-15 01:14:55', 'admin', '2013-11-15 09:14:55'),
('icoComment', 'd0e404b3-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Comment', 'Комментарий', 'icoComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoEditBy', 'd0e40ab6-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Editor', 'Редактор', 'icoEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoEditDate', 'd0e40bb7-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Edited', 'Дата изменения', 'icoEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoFlagDeleted', 'd0e4062c-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Deleted', 'Удален', 'icoFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoFlagPosted', 'd0e40797-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Posted', 'Проведен', 'icoFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoGUID', 'd0e3fe9d-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'GUID', 'GUID', 'icoGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoID', 'd0e31ea4-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'ID', 'ID', 'icoID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoInsertBy', 'd0e408b1-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Author', 'Автор', 'icoInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoInsertDate', 'd0e409b6-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Created on', 'Дата создания', 'icoInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoProfitID', 'd0e40362-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Profit center', 'ЦФО', 'icoProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoScenario', 'd0e4022e-42e7-11e3-ad19-9b24e3067432', 'tbl_indirect_costs', 'Scenario', 'Сценарий', 'icoScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-01 03:22:44', 'admin', '2013-11-01 11:22:44'),
('icoUserID', 'f7ddc405-89d8-11e5-979e-00155d010c2c', 'tbl_indirect_costs', 'Responsible', 'Ответственный', 'icoUserID', 'ajax', 14, NULL, 0, 0, 0, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2015-10-26 10:43:33', NULL, NULL),
('icsComment', 'ade2a4e0-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Comment', 'Комментарий', 'icsComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsCustomerID', 'ade2a8e2-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Customer', 'Клиент', 'icsCustomerID', 'combobox', 13, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-10-29 02:04:34', 'admin', '2013-10-29 10:04:34'),
('icsEditBy', 'ade2aa7d-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Editor', 'Редактор', 'icsEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsEditDate', 'ade2ac14-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Edited', 'Дата изменения', 'icsEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsFlagDeleted', 'ade2ad7b-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Deleted', 'Удален', 'icsFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsFlagPosted', 'ade2aed0-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Posted', 'Проведен', 'icsFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsGUID', 'ade2b01a-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'GUID', 'GUID', 'icsGUID', 'guid', 20, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsID', 'ade2b155-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'ID', 'ID', 'icsID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsInsertBy', 'ade2b294-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Author', 'Автор', 'icsInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsInsertDate', 'ade2b3d6-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Created on', 'Дата создания', 'icsInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsProductFolderID', 'ade2b50a-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Product folder', 'ProductFolderID', 'icsProductFolderID', 'combobox', 35, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_product', NULL, NULL, 'vw_product', 'prd', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsProfitID', 'ade2b658-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Profit center', 'ЦФО', 'icsProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('icsScenario', 'ade2b81b-4086-11e3-ad19-9b24e3067432', 'tbl_interco_sales', 'Scenario', 'Сценарий', 'icsScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('invComment', '6e03b8ff-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Comment', 'Комментарий', 'invComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invEditBy', '6e03c045-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Editor', 'Редактор', 'invEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invEditDate', '6e03c19e-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Edited', 'Дата изменения', 'invEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invFlagDeleted', '6e03ba84-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Deleted', 'Удален', 'invFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invFlagPosted', '6e03bbe8-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Posted', 'Проведен', 'invFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invGUID', '6e03b463-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'GUID', 'GUID', 'invGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invID', '6e03af34-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'ID', 'ID', 'invID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invInsertBy', '6e03bd73-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Author', 'Автор', 'invInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invInsertDate', '6e03bee2-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Created on', 'Дата создания', 'invInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invProfitID', '6e03b774-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Profit center', 'ЦФО', 'invProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('invScenario', '6e03b5fa-4d5b-11e3-8c40-13216cbd6eee', 'tbl_investment', 'Scenario', 'Сценарий', 'invScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-14 14:34:52', 'admin', '2013-11-14 22:34:52'),
('kznComment', 'fb7d8322-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Comment', 'Комментарий', 'kznComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznEditBy', 'fb7d8855-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Editor', 'Редактор', 'kznEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznEditDate', 'fb7d894a-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Edited', 'Дата изменения', 'kznEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznFlagDeleted', 'fb7d8452-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Deleted', 'Удален', 'kznFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznFlagPosted', 'fb7d8557-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Posted', 'Проведен', 'kznFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznGUID', 'fb7d78b6-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'GUID', 'GUID', 'kznGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznID', 'fb7d737c-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'ID', 'ID', 'kznID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznInsertBy', 'fb7d8657-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Author', 'Автор', 'kznInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznInsertDate', 'fb7d8750-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Created on', 'Дата создания', 'kznInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznItemGUID', 'fb7d8208-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'ItemGUID', 'ItemGUID', 'kznItemGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznRate', 'fb7d8d3a-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Rate', 'Rate', 'kznRate', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('kznScenario', 'fb7d80a4-56ca-11e3-b535-cae93343b5c1', 'tbl_kaizen', 'Scenario', 'Сценарий', 'kznScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-26 14:46:04', 'admin', '2013-11-26 18:46:04'),
('lcoComment', '445ca285-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Comment', 'Комментарий', 'lcoComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoEditBy', '445ca73b-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Editor', 'Редактор', 'lcoEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoEditDate', '445ca81e-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Edited', 'Дата изменения', 'lcoEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoFlagDeleted', '445ca36c-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Deleted', 'Удален', 'lcoFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoFlagPosted', '445ca44c-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Posted', 'Проведен', 'lcoFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoGUID', '445c9f92-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'GUID', 'GUID', 'lcoGUID', 'guid', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoID', '445c9c14-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'ID', 'ID', 'lcoID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoInsertBy', '445ca54c-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Author', 'Автор', 'lcoInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoInsertDate', '445ca64d-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Created on', 'Дата создания', 'lcoInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoLocationID', '445ca197-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Location', 'LocationID', 'lcoLocationID', 'combobox', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_location', NULL, NULL, 'vw_location', 'loc', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoScenario', '445ca093-3fcc-11e3-9648-3fdb903f8bfc', 'tbl_location_costs', 'Scenario', 'Сценарий', 'lcoScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'vw_active_scenario', 'scn', '', 0, 'admin', '2013-10-28 04:27:11', 'admin', '2013-10-28 16:27:11'),
('lcoUserID', '7b98badf-8ec2-11e5-979e-00155d010c2c', 'tbl_location_costs', 'Responsible', 'Ответственный', 'lcoUserID', 'ajax', 14, NULL, 0, 0, 0, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2015-10-26 10:43:33', NULL, NULL),
('msfAmount', '9c265304-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'Amount', 'Amount', 'msfAmount', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfComment', '9c2649d7-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'Comment', 'Comment', 'msfComment', 'text', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfEditBy', '9c265edb-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'EditBy', 'EditBy', 'msfEditBy', 'varchar', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfEditDate', '9c266180-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'EditDate', 'EditDate', 'msfEditDate', 'datetime', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfFlagDeleted', '9c264d78-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'FlagDeleted', 'FlagDeleted', 'msfFlagDeleted', 'boolean', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfFlagPosted', '9c265038-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'FlagPosted', 'FlagPosted', 'msfFlagPosted', 'boolean', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfGUID', '9c2054b5-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'GUID', 'GUID', 'msfGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfID', '9c0d96db-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'ID', 'ID', 'msfID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfInsertBy', '9c26559f-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'InsertBy', 'InsertBy', 'msfInsertBy', 'varchar', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfInsertDate', '9c26585b-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'InsertDate', 'InsertDate', 'msfInsertDate', 'timestamp', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfItemGUID', '360c288e-803c-11e4-89b0-466732c33de6', 'tbl_msf', 'Item', 'Бюджетный счет', 'msfItemGUID', 'combobox', 50, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, '', NULL, NULL, '', '', '', 0, 'admin', '2014-12-10 07:15:48', NULL, NULL),
('msfProfitID', '9c2640bc-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'ProfitID', 'ProfitID', 'msfProfitID', 'combobox', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfScenario', '9c264579-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'Scenario', 'Scenario', 'msfScenario', 'combobox', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('msfTotal', '9c266419-5dd4-11e4-b78c-fe79617c48f6', 'tbl_msf', 'Total', 'Total', 'msfTotal', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-10-27 12:27:39', 'admin', '2014-10-27 16:27:39'),
('nemComment', 'd08eae03-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Comment', 'Комментарий', 'nemComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemEditBy', 'd08eb3d0-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Editor', 'Редактор', 'nemEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemEditDate', 'd08eb4d7-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Edited', 'Дата изменения', 'nemEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemFlagDeleted', 'd08eaf58-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Deleted', 'Удален', 'nemFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemFlagPosted', 'd08eb06f-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Posted', 'Проведен', 'nemFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemGUID', 'd08ea94a-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'GUID', 'GUID', 'nemGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemHeadcount', '2b7aeaef-6006-11e4-89b0-466732c33de6', 'tbl_new_employee', 'Headcount', 'Количество', 'nemHeadcount', 'decimal', 51, NULL, 0, 0, 0, 1, 1, 0, NULL, NULL, NULL, '', NULL, '', NULL, NULL, '', '', '', 0, 'admin', '2013-10-30 11:42:48', 'admin', '2013-10-30 23:42:48'),
('nemID', 'd08b83e8-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'ID', 'ID', 'nemID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemInsertBy', 'd08eb197-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Author', 'Автор', 'nemInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemInsertDate', 'd08eb2ae-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Created on', 'Дата создания', 'nemInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemProfitID', 'd08eaccf-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Profit center', 'ЦФО', 'nemProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('nemScenario', 'd08eab8d-4c4c-11e3-bf3b-408bf93e48b2', 'tbl_new_employee', 'Scenario', 'Сценарий', 'nemScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-13 06:17:57', 'admin', '2013-11-13 10:17:57'),
('rntActivityID', 'd27033d3-fd3b-11e8-b866-000d3ab33059', 'tbl_rent', 'Activity', 'Номенклатура', 'rntActivityID', 'combobox', 51, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_product_type', NULL, NULL, 'vw_product_type', 'prt', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntAmount', '6a9dbc81-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Amount', 'Amount', 'rntAmount', 'decimal', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntComment', '6a9db474-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Comment', 'Комментарий', 'rntComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntEditBy', '6a9dc7e3-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Editor', 'Редактор', 'rntEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntEditDate', '6a9dcaa0-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Edited', 'Дата изменения', 'rntEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntFlagDeleted', '6a9db70d-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Deleted', 'Удален', 'rntFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntFlagPosted', '6a9db9c0-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Posted', 'Проведен', 'rntFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntGUID', '6a9d8ae1-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'GUID', 'GUID', 'rntGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntID', '6a9d7dbc-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'ID', 'ID', 'rntID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntInsertBy', '6a9dbf04-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Author', 'Автор', 'rntInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntInsertDate', '6a9dc510-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Created on', 'Дата создания', 'rntInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntItemGUID', '6a9db143-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Cost item', 'Статья затрат', 'rntItemGUID', 'combobox', 52, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'SELECT itmGUID as optValue, itmTitle as optText, itmFlagDeleted as optDeleted from vw_item', NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntProfitID', '6a9daa8d-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Profit center', 'ЦФО', 'rntProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntScenario', '6a9dadd4-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Scenario', 'Сценарий', 'rntScenario', 'combobox', 11, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('rntTotal', '6a9dcd39-948d-11e3-8e8c-232241e2a9aa', 'tbl_rent', 'Total', 'Total', 'rntTotal', 'decimal', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2014-02-13 09:01:32', 'admin', '2014-02-13 13:01:32'),
('salAmount', 'c96b0230-7bce-11e5-979e-00155d010c2c', 'tbl_sales', 'GP', 'GP', 'salAmount', 'integer', 15, NULL, 0, 0, 0, 1, 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2015-10-26 10:46:17', NULL, NULL),
('salBO', '25813756-fca6-11e5-82bf-00155d010c30', 'tbl_sales', 'Biz owner', 'Biz owner', 'salBO', 'ajax', 14, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_pb_intercompany', NULL, NULL, 'vw_pb_intercompany', 'cnt', '', 0, 'admin', '2013-10-29 02:04:34', 'admin', '2013-10-29 10:04:34'),
('salComment', 'b62a345d-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Comment', 'Комментарий', 'salComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salCompanyID', '1a8d7a40-a0fe-11e6-ab7e-00155d010c30', 'tbl_sales', 'Company', 'Организация', 'salCompanyID', 'combobox', 11, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_company', NULL, NULL, 'vw_company', 'com', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salCustomerID', '80b2eec5-4081-11e3-ad19-9b24e3067432', 'tbl_sales', 'Customer', 'Клиент', 'salCustomerID', 'ajax', 12, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_customer', NULL, NULL, 'vw_customer', 'cnt', '', 0, 'admin', '2013-10-29 02:04:34', 'admin', '2013-10-29 10:04:34'),
('salEditBy', 'b62a4081-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Editor', 'Редактор', 'salEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salEditDate', 'b62a42ba-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Edited', 'Дата изменения', 'salEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salFlagDeleted', 'b62a3687-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Deleted', 'Удален', 'salFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salFlagNew', 'cfa59c7b-d125-11e8-8f91-000d3ab33059', 'tbl_sales', 'New biz.', 'Новый', 'salFlagNew', 'boolean', 13, NULL, 0, 0, 0, 1, 1, 0, NULL, NULL, NULL, '', NULL, '', NULL, NULL, '', '', '', 0, 'admin', '2013-10-29 02:04:34', 'admin', '2013-10-29 10:04:34'),
('salFlagPosted', 'b62a38c2-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Posted', 'Проведен', 'salFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salGBR', 'abfe0194-ab23-11e6-ab7e-00155d010c30', 'tbl_sales', 'SAP/GBR', 'SAP/GBR', 'salGBR', 'integer', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salGUID', 'b62a2a6d-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'GUID', 'GUID', 'salGUID', 'guid', 20, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salID', 'b62a227b-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'ID', 'ID', 'salID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salInsertBy', 'b62a3b9c-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Author', 'Автор', 'salInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salInsertDate', 'b62a3e04-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Created on', 'Дата создания', 'salInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salKg', '11a6b63a-b7f9-11e8-8f91-000d3ab33059', 'tbl_sales', 'Kg', 'кг', 'salKg', 'integer', 16, NULL, 0, 0, 0, 1, 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2018-09-14 08:35:00', NULL, NULL),
('salProductFolderID', 'b62a3204-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Product folder', 'ProductFolderID', 'salProductFolderID', 'combobox', 35, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '', NULL, 'vw_product', NULL, NULL, 'vw_product', 'prd', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salProfitID', 'b62a2faf-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Profit center', 'ЦФО', 'salProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salRevenue', 'e99873f4-b264-11e7-addd-000d3ab33059', 'tbl_sales', 'Revenue', 'Выручка', 'salRevenue', 'integer', 14, NULL, 0, 0, 0, 1, 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2015-10-26 10:46:17', NULL, NULL),
('salRoute', '7ad93d03-91d8-11e5-979e-00155d010c2c', 'tbl_sales', 'Route', 'Маршрут', 'salRoute', 'combobox', 30, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, 'tbl_route', NULL, NULL, 'tbl_route', 'rte', '', 0, 'admin', '2015-11-23 11:49:58', NULL, NULL),
('salScenario', 'b62a2d4a-3bc3-11e3-9809-47406d5f96d1', 'tbl_sales', 'Scenario', 'Сценарий', 'salScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-10-23 01:16:36', 'admin', '2013-10-23 09:16:36'),
('salTEU', '30a14e0c-b802-11e8-8f91-000d3ab33059', 'tbl_sales', 'TEU', 'ТЕУ', 'salTEU', 'integer', 17, NULL, 0, 0, 0, 1, 0, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2018-09-14 08:35:00', NULL, NULL),
('salUserID', '67b6dc3c-7bce-11e5-979e-00155d010c2c', 'tbl_sales', 'Responsible', 'Ответственный', 'salUserID', 'ajax', 14, NULL, 0, 0, 0, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2015-10-26 10:43:33', NULL, NULL),
('vehCASCO', '02e5b7d0-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'CASCO', 'CASCO', 'vehCASCO', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehComment', '02e5a3e9-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Comment', 'Комментарий', 'vehComment', 'text', 60, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehConsumables', '02e5cde4-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Consumables', 'Consumables', 'vehConsumables', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54');
INSERT INTO `stbl_attribute` (`atrID`, `atrGUID`, `atrEntityID`, `atrTitle`, `atrTitleLocal`, `atrFieldName`, `atrType`, `atrOrder`, `atrHref`, `atrFlagPK`, `atrFlagFilter`, `atrFlagShowInForm`, `atrFlagShowInList`, `atrFlagEditable`, `atrFlagMonitor`, `atrTab`, `atrGroup`, `atrGroupLocal`, `atrProperties`, `atrDefault`, `atrProgrammerReserved`, `atrSql`, `atrMatrix`, `atrTable`, `atrPrefix`, `atrCheckMask`, `atrFlagDeleted`, `atrInsertBy`, `atrInsertDate`, `atrEditBy`, `atrEditDate`) VALUES
('vehConsumption', '02e5c008-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Consumption', 'Consumption', 'vehConsumption', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehEditBy', '02e5b26a-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Editor', 'Редактор', 'vehEditBy', 'combobox', 9020, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehEditDate', '02e5b518-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Edited', 'Дата изменения', 'vehEditDate', 'datetime', 9030, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehFlagDeleted', '02e5a6b0-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Deleted', 'Удален', 'vehFlagDeleted', 'boolean', 30, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehFlagPosted', '02e5a97b-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Posted', 'Проведен', 'vehFlagPosted', 'boolean', 40, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehFuelPrice', '02e5c2cc-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'FuelPrice', 'FuelPrice', 'vehFuelPrice', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehGUID', '02e5985f-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'GUID', 'GUID', 'vehGUID', 'char', 10, NULL, 0, 0, 1, 0, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehID', '02dfe6a4-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'ID', 'ID', 'vehID', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehInsertBy', '02e5ac93-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Author', 'Автор', 'vehInsertBy', 'combobox', 9000, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'stbl_user', NULL, NULL, 'stbl_user', 'usr', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehInsertDate', '02e5afab-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Created on', 'Дата создания', 'vehInsertDate', 'datetime', 9010, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehMaintenance', '02e5caf1-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Maintenance', 'Maintenance', 'vehMaintenance', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehOSAGO', '02e5ba81-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'OSAGO', 'OSAGO', 'vehOSAGO', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehPower', '02e5d08e-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Power', 'Power', 'vehPower', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehProfitID', '02e5a0dd-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Profit center', 'ЦФО', 'vehProfitID', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_profit', NULL, NULL, 'vw_profit', 'pcc', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehRate', '02e5d346-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Rate', 'Rate', 'vehRate', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehRun', '02e5bd32-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Run', 'Run', 'vehRun', 'int', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehScenario', '02e59d69-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Scenario', 'Сценарий', 'vehScenario', 'combobox', 50, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, 'vw_active_scenario', NULL, NULL, 'tbl_scenario', 'scn', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54'),
('vehWash', '02e5c5c2-50f0-11e3-b2bd-0eb45caf5dc1', 'tbl_vehicle', 'Wash', 'Wash', 'vehWash', 'decimal', 10, NULL, 0, 0, 1, 1, 1, 0, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', 0, 'admin', '2013-11-19 03:55:54', 'admin', '2013-11-19 11:55:54');

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_entity`
--

DROP TABLE IF EXISTS `stbl_entity`;
CREATE TABLE `stbl_entity` (
  `entID` int(11) NOT NULL,
  `entTitle` varchar(20) NOT NULL DEFAULT '',
  `entTitleLocal` varchar(40) NOT NULL DEFAULT '',
  `entEntity` varchar(50) DEFAULT NULL COMMENT 'System name for the entity',
  `entTable` varchar(20) DEFAULT NULL,
  `entForm` varchar(40) DEFAULT NULL COMMENT 'Form by default',
  `entRegister` varchar(40) DEFAULT NULL,
  `entPrefix` varchar(3) DEFAULT NULL,
  `entHeader` text COMMENT 'PHP-ized SQL expression to form the entity header',
  `entFlagDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `entInsertBy` varchar(50) DEFAULT NULL,
  `entInsertDate` datetime DEFAULT NULL,
  `entEditBy` varchar(50) DEFAULT NULL,
  `entEditDate` datetime DEFAULT NULL,
  `entType` enum('DOC','REF','MTX') NOT NULL DEFAULT 'DOC',
  `entCompleteStateID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stbl_entity`
--

INSERT INTO `stbl_entity` (`entID`, `entTitle`, `entTitleLocal`, `entEntity`, `entTable`, `entForm`, `entRegister`, `entPrefix`, `entHeader`, `entFlagDeleted`, `entInsertBy`, `entInsertDate`, `entEditBy`, `entEditDate`, `entType`, `entCompleteStateID`) VALUES
(1, 'Sales', 'Продажи', 'tbl_sales', 'tbl_sales', 'sales_form.php', 'reg_sales', 'sal', NULL, 0, 'zhuravlev', '2013-10-23 12:58:00', NULL, NULL, 'REF', NULL),
(2, 'Location costs', 'Затраты ОП', 'tbl_location_costs', 'tbl_location_costs', 'location_costs_form.php', 'reg_costs', 'lco', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(3, 'Intercompany sales', 'Внутренние услуги', 'tbl_interco_sales', 'tbl_interco_sales', 'interco_sales_form.php', 'reg_interco_sales', 'ics', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(4, 'Current employees', 'Текущие сотрудники', 'tbl_current_employee', 'tbl_current_employee', 'employee_current_form.php', 'reg_headcount', 'cem', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(5, 'New employees', 'Новые сотрудники', 'tbl_new_employee', 'tbl_new_employee', 'employee_new_form.php', 'reg_headcount', 'nem', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(6, 'Indirect costs', 'Косвенные расходы', 'tbl_indirect_costs', 'tbl_indirect_costs', 'indirect_costs_form.php', 'reg_costs', 'ico', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(7, 'Depreciation', 'Амортизация', 'tbl_depreciation', 'tbl_depreciation', 'depreciation_form.php', 'reg_depreciation', 'dep', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(8, 'Investments', 'Инвестиции', 'tbl_investment', 'tbl_investment', 'investment_form.php', 'reg_depreciation', 'inv', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(9, 'General costs', 'Общие затраты', 'tbl_general_costs', 'tbl_general_costs', 'general_cost_form.php', 'reg_costs', 'gen', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(10, 'Vehicles', 'Транспортные средства', 'tbl_vehicle', 'tbl_vehicle', 'vehicle_form.php', 'reg_vehicles', 'veh', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(11, 'Kaizen', 'Кайзен', 'tbl_kaizen', 'tbl_kaizen', 'kaizen_form.php', 'reg_costs', 'kzn', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(12, 'Cost distribution', 'Распределение затрат', 'tbl_rent', 'tbl_rent', 'rent_form.php', 'reg_rent', 'rnt', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL),
(13, 'MSF', 'Распределение HQ', 'tbl_msf', 'tbl_msf', 'msf_form.php', 'reg_msf', 'msf', NULL, 0, NULL, NULL, NULL, NULL, 'REF', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_file`
--

DROP TABLE IF EXISTS `stbl_file`;
CREATE TABLE `stbl_file` (
  `filID` int(11) NOT NULL,
  `filGUID` char(36) NOT NULL,
  `filName` varchar(255) NOT NULL,
  `filPath` varchar(512) NOT NULL,
  `filSize` int(11) NOT NULL,
  `filType` varchar(256) DEFAULT NULL,
  `filFlagDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `filInsertBy` varchar(50) NOT NULL,
  `filInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filEntityID` varchar(36) NOT NULL,
  `filField` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='File references';

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_page`
--

DROP TABLE IF EXISTS `stbl_page`;
CREATE TABLE `stbl_page` (
  `pagID` int(11) NOT NULL,
  `pagParentID` int(11) UNSIGNED DEFAULT NULL,
  `pagTitle` varchar(255) DEFAULT NULL,
  `pagEntityID` varchar(3) DEFAULT NULL,
  `pagIdxLeft` int(11) UNSIGNED ZEROFILL DEFAULT NULL,
  `pagIdxRight` int(11) UNSIGNED ZEROFILL DEFAULT NULL,
  `pagFlagShowInMenu` tinyint(1) UNSIGNED DEFAULT NULL,
  `pagFile` varchar(255) DEFAULT NULL,
  `pagFlagHierarchy` tinyint(1) UNSIGNED DEFAULT NULL,
  `pagTable` varchar(20) DEFAULT NULL,
  `pagPrefix` char(3) DEFAULT NULL,
  `pagTitleLocal` varchar(128) DEFAULT NULL,
  `pagFlagSystem` tinyint(1) UNSIGNED DEFAULT NULL,
  `pagInsertBy` varchar(30) DEFAULT NULL,
  `pagInsertDate` datetime DEFAULT NULL,
  `pagEditBy` varchar(30) DEFAULT NULL,
  `pagEditDate` datetime DEFAULT NULL,
  `pagFlagShowMyItems` tinyint(4) NOT NULL DEFAULT '0',
  `pagClass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='The table defines the list and the structure of all scripts';

--
-- Дамп данных таблицы `stbl_page`
--

INSERT INTO `stbl_page` (`pagID`, `pagParentID`, `pagTitle`, `pagEntityID`, `pagIdxLeft`, `pagIdxRight`, `pagFlagShowInMenu`, `pagFile`, `pagFlagHierarchy`, `pagTable`, `pagPrefix`, `pagTitleLocal`, `pagFlagSystem`, `pagInsertBy`, `pagInsertDate`, `pagEditBy`, `pagEditDate`, `pagFlagShowMyItems`, `pagClass`) VALUES
(1, NULL, 'ROOT', NULL, 00000000001, 00000000222, 0, '', NULL, NULL, NULL, NULL, NULL, 'admin', '2008-05-29 17:54:59', 'admin', '2008-05-29 17:54:59', 0, NULL),
(2, 1, 'HOME', NULL, 00000000002, 00000000221, 0, '/index.php', NULL, NULL, NULL, 'Заглавная страница', NULL, 'admin', '2008-05-29 17:54:59', 'ADMIN', '2008-06-09 00:00:00', 0, NULL),
(170, 2, 'Forms', '', 00000000003, 00000000034, 0, '', 0, '', NULL, 'Формы', 0, 'root', '2013-10-22 13:54:40', 'root', '2013-10-22 00:00:00', 0, NULL),
(171, 170, 'Sales', '', 00000000004, 00000000005, 0, '/sales_form.php', 0, '', NULL, 'Продажи', 0, 'root', '2013-10-22 13:55:27', 'root', '2013-11-21 00:00:00', 0, NULL),
(172, 2, 'Documents', '', 00000000035, 00000000062, 1, '', 0, '', NULL, 'Документы', 0, 'root', '2013-10-23 08:49:36', 'root', '2013-10-23 00:00:00', 0, NULL),
(173, 172, 'Sales', '', 00000000036, 00000000037, 1, '/sales_list.php', 0, '', NULL, 'Продажи', 0, 'root', '2013-10-23 08:50:42', 'root', '2013-11-21 00:00:00', 0, 'fa-cart-plus'),
(174, 2, 'Reports', '', 00000000063, 00000000162, 1, '', 0, '', NULL, 'Отчеты', 0, 'root', '2013-10-23 08:51:33', 'root', '2013-10-23 00:00:00', 0, NULL),
(175, 2, 'About', '', 00000000217, 00000000218, 1, '/about.php', 0, '', NULL, 'О программе', 0, 'root', '2013-10-23 09:25:13', 'root', '2013-10-23 00:00:00', 0, NULL),
(176, 178, 'Header', '', 00000000170, 00000000171, 0, '/frm_header.php', 0, '', NULL, 'Заголовок', 0, 'root', '2013-10-23 09:30:33', 'root', '2013-10-23 00:00:00', 0, NULL),
(177, 178, 'Menu', '', 00000000168, 00000000169, 0, '/frm_toc.php', 0, '', NULL, 'Меню', 0, 'root', '2013-10-23 09:31:08', 'root', '2013-10-23 00:00:00', 0, NULL),
(178, 2, 'Special', '', 00000000163, 00000000180, 0, '', 0, '', NULL, 'Специальные', 0, 'root', '2013-10-23 11:13:50', 'root', '2013-10-23 11:13:50', 0, NULL),
(179, 178, 'JSON Events', '', 00000000164, 00000000165, 0, '/json_vacation.php', 0, '', NULL, 'JSON Events', 0, 'root', '2013-10-23 11:14:12', 'root', '2013-10-23 00:00:00', 0, NULL),
(180, 178, 'Access denied', '', 00000000166, 00000000167, 0, '/profit_acl_denied.php', 0, '', NULL, 'Доступ закрыт', 0, 'root', '2013-10-23 14:05:29', 'root', '2013-10-23 00:00:00', 0, NULL),
(181, 174, 'Sales KPI', '', 00000000132, 00000000133, 1, '/rep_sales_kpi.php', 0, '', NULL, 'Натуральные показатели', 0, 'root', '2013-10-23 23:03:53', '', '2016-08-15 00:00:00', 0, NULL),
(182, 236, 'Headcount', '', 00000000099, 00000000100, 1, '/rep_headcount.php', 0, '', NULL, 'Персонал', 0, 'root', '2013-10-23 23:50:14', 'root', '2015-03-11 00:00:00', 0, NULL),
(183, 246, 'Profit & loss', '', 00000000067, 00000000068, 1, '/rep_pnl.php', 0, '', NULL, 'Прибыль', 0, 'root', '2013-10-24 13:57:23', '', '2016-12-08 00:00:00', 0, NULL),
(184, 2, 'Budget settings', '', 00000000211, 00000000212, 1, '/budget_setup.php', 0, '', NULL, 'Настройки бюджета', 0, 'root', '2013-10-28 14:44:54', 'root', '2013-10-28 00:00:00', 0, 'fa-cogs'),
(185, 170, 'Location costs', '', 00000000008, 00000000009, 0, '/location_costs_form.php', 0, '', NULL, 'Затраты ОП', 0, 'root', '2013-10-28 15:43:21', 'root', '2019-06-26 09:40:28', 0, NULL),
(186, 172, 'Location costs', '', 00000000040, 00000000041, 1, '/location_costs_list.php', 0, '', NULL, 'Затраты ОП', 0, 'root', '2013-10-28 15:45:05', 'root', '2018-11-15 15:14:28', 0, 'fa-globe'),
(187, 170, 'Calendar', '', 00000000006, 00000000007, 0, '/calendar_form.php', 0, '', NULL, 'Календарь', 0, 'root', '2013-10-29 10:06:12', 'root', '2014-05-26 00:00:00', 0, NULL),
(188, 178, 'JSON List', '', 00000000172, 00000000173, 0, '/json_list.php', 0, '', NULL, 'JSON List', 0, 'root', '2013-10-29 14:08:10', 'root', '2013-10-29 00:00:00', 0, NULL),
(189, 172, 'Intercompany sales', '', 00000000038, 00000000039, 1, '/interco_sales_list.php', 0, '', NULL, 'Внутренние услуги', 0, 'root', '2013-10-29 14:09:04', 'root', '2013-10-29 00:00:00', 0, NULL),
(190, 170, 'Intercompany sales', '', 00000000010, 00000000011, 0, '/interco_sales_form.php', 0, '', NULL, 'Внутренние услуги', 0, 'root', '2013-10-29 14:10:16', 'root', '2013-10-29 00:00:00', 0, NULL),
(191, 178, 'AJAX Details', '', 00000000174, 00000000175, 0, '/ajax_details.php', 0, '', NULL, 'AJAX Details', 0, 'root', '2013-10-29 17:22:25', 'root', '2013-10-29 00:00:00', 0, NULL),
(192, 172, 'Current employees', '', 00000000042, 00000000043, 1, '/employee_current_list.php', 0, '', NULL, 'Текущие сотрудники', 0, 'root', '2013-10-30 23:26:40', 'root', '2015-06-20 00:00:00', 0, 'fa-users'),
(193, 172, 'New employees', '', 00000000044, 00000000045, 1, '/employee_new_list.php', 0, '', NULL, 'Новые сотрудники', 0, 'root', '2013-10-30 23:27:26', 'root', '2013-11-21 00:00:00', 0, NULL),
(194, 170, 'Current employees', '', 00000000012, 00000000013, 0, '/employee_current_form.php', 0, '', NULL, 'Текущие сотрудники', 0, 'root', '2013-10-30 23:29:26', 'root', '2015-06-20 00:00:00', 0, NULL),
(195, 170, 'New employees', '', 00000000014, 00000000015, 0, '/employee_new_form.php', 0, '', NULL, 'Новые сотрудники', 0, 'root', '2013-10-30 23:30:20', 'root', '2013-11-21 00:00:00', 0, NULL),
(196, 170, 'Depreciation', '', 00000000016, 00000000017, 0, '/depreciation_form.php', 0, '', NULL, 'Амортизация', 0, 'root', '2013-10-31 16:13:53', 'root', '2013-11-12 00:00:00', 0, NULL),
(198, 170, 'Indirect costs', '', 00000000018, 00000000019, 0, '/indirect_costs_form.php', 0, '', NULL, 'Косвенные расходы', 0, 'root', '2013-10-31 16:15:18', 'root', '2013-11-08 00:00:00', 0, NULL),
(199, 172, 'Depreciation', '', 00000000046, 00000000047, 1, '/depreciation_list.php', 0, '', NULL, 'Амортизация', 0, 'root', '2013-10-31 16:33:35', 'root', '2013-11-12 00:00:00', 0, NULL),
(200, 172, 'Indirect costs', '', 00000000048, 00000000049, 1, '/indirect_costs_list.php', 0, '', NULL, 'Косвенные расходы', 0, 'root', '2013-11-01 15:16:45', 'root', '2013-11-08 00:00:00', 0, NULL),
(201, 2, 'References', '', 00000000181, 00000000192, 1, '', 0, '', NULL, 'Справочники', 0, 'root', '2013-11-11 14:23:28', 'root', '2013-11-11 00:00:00', 0, NULL),
(202, 201, 'Medical insurance', '', 00000000182, 00000000183, 1, '/insurance_list.php', 0, '', NULL, 'ДМС', 0, 'root', '2013-11-11 14:24:03', 'root', '2013-11-11 00:00:00', 0, NULL),
(203, 201, 'Mobile limits', '', 00000000184, 00000000185, 1, '/mobile_list.php', 0, '', NULL, 'Лимиты мобильной связи', 0, 'root', '2013-11-13 12:44:53', 'root', '2013-11-13 00:00:00', 0, NULL),
(204, 172, 'General costs', '', 00000000054, 00000000055, 1, '/general_cost_list.php', 0, '', NULL, 'Общие расходы', 0, 'root', '2013-11-14 21:46:17', 'root', '2013-11-20 00:00:00', 0, NULL),
(205, 172, 'Investments', '', 00000000052, 00000000053, 1, '/investment_list.php', 0, '', NULL, 'Инвестиции', 0, 'root', '2013-11-14 21:46:59', 'root', '2013-11-14 00:00:00', 0, NULL),
(206, 170, 'General costs', '', 00000000020, 00000000021, 0, '/general_cost_form.php', 0, '', NULL, 'Общие расходы', 0, 'root', '2013-11-14 21:49:36', 'root', '2019-05-20 17:16:29', 0, NULL),
(207, 170, 'Investments', '', 00000000022, 00000000023, 0, '/investment_form.php', 0, '', NULL, 'Инвестиции', 0, 'root', '2013-11-14 21:50:50', 'root', '2013-11-14 00:00:00', 0, NULL),
(208, 170, 'Vehicles', '', 00000000024, 00000000025, 0, '/vehicle_form.php', 0, '', NULL, 'Транспортные средства', 0, 'root', '2013-11-14 21:55:00', 'root', '2013-11-20 00:00:00', 0, NULL),
(209, 170, 'Travels', '', 00000000026, 00000000027, 0, '/travel_form.php', 0, '', NULL, 'Командировки', 0, 'root', '2013-11-14 21:58:47', 'root', '2013-11-14 00:00:00', 0, NULL),
(211, 172, 'Vehicles', '', 00000000050, 00000000051, 1, '/vehicle_list.php', 0, '', NULL, 'Транспортные средства', 0, 'root', '2013-11-14 22:00:46', 'root', '2013-11-20 00:00:00', 0, 'fa-truck'),
(212, 231, 'Unposted docs', '', 00000000107, 00000000108, 1, '/rep_unposted.php', 0, '', NULL, 'Непроведенные документы', 0, 'root', '2013-11-14 22:01:28', 'root', '2013-11-14 00:00:00', 0, NULL),
(213, 231, 'Unaccounted employees', '', 00000000109, 00000000110, 1, '/rep_employee_unaccounted.php', 0, '', NULL, 'Неучтенные сотрудники', 0, 'root', '2013-11-14 22:01:59', 'root', '2013-11-14 00:00:00', 0, NULL),
(214, 231, 'Unaccounted fixed assets', '', 00000000111, 00000000112, 1, '/rep_fa_unaccounted.php', 0, '', NULL, 'Неучтенные активы', 0, 'root', '2013-11-14 22:02:33', 'root', '2013-11-14 00:00:00', 0, NULL),
(215, 174, 'IT costs', '', 00000000134, 00000000135, 1, '/rep_it_costs.php', 0, '', NULL, 'Расходы на ИТ', 0, 'root', '2013-11-20 12:53:21', 'root', '2018-10-25 12:16:59', 0, NULL),
(216, 174, 'Admin costs', '', 00000000136, 00000000137, 1, '/rep_admin_costs.php', 0, '', NULL, 'Административные расходы', 0, 'root', '2013-11-20 16:56:20', 'root', '2018-10-25 12:17:26', 0, NULL),
(217, 231, 'Revenue', '', 00000000115, 00000000116, 1, '/rep_ratios.php', 0, '', NULL, 'Выручка', 0, 'root', '2013-11-22 13:12:20', 'root', '2013-11-22 00:00:00', 0, NULL),
(218, 246, 'Totals', '', 00000000069, 00000000070, 1, '/rep_totals.php', 0, '', NULL, 'Обзор итогов', 0, 'root', '2013-11-22 17:36:41', '', '2016-11-16 00:00:00', 0, NULL),
(219, 236, 'HR costs', '', 00000000103, 00000000104, 1, '/rep_hr_costs.php', 0, '', NULL, 'Расходы на персонал', 0, 'root', '2013-11-24 23:24:26', 'root', '2013-11-24 00:00:00', 0, NULL),
(220, 248, 'Report for GHQ', '', 00000000125, 00000000126, 1, '/sp_ghq.php', 0, '', NULL, 'Отчет для GHQ', 0, 'root', '2013-11-25 16:55:45', 'root', '2013-11-25 00:00:00', 0, NULL),
(221, 236, 'New employees', '', 00000000101, 00000000102, 1, '/rep_new_employees.php', 0, '', NULL, 'Новые сотрудники', 0, 'root', '2013-11-25 23:06:34', 'root', '2014-11-10 00:00:00', 0, NULL),
(222, 174, 'Investments', '', 00000000144, 00000000145, 1, '/rep_investment.php', 0, '', NULL, 'Инвестиции', 0, 'root', '2013-11-25 23:25:26', 'root', '2013-11-25 00:00:00', 0, NULL),
(223, 170, 'Kaizen', '', 00000000028, 00000000029, 0, '/kaizen_form.php', 0, '', NULL, 'Оптимизация затрат', 0, 'root', '2013-11-26 16:44:15', 'root', '2013-11-26 00:00:00', 0, NULL),
(224, 172, 'Kaizen', '', 00000000056, 00000000057, 1, '/kaizen_list.php', 0, '', NULL, 'Кайзен', 0, 'root', '2013-11-26 16:44:59', 'root', '2013-11-26 00:00:00', 0, NULL),
(225, 174, 'YACT report', '', 00000000146, 00000000147, 1, '/rep_yact.php', 0, '', NULL, 'Отчет YACT', 0, 'root', '2013-12-03 10:32:19', 'root', '2015-01-27 00:00:00', 0, NULL),
(226, 231, 'Empty YACT', '', 00000000113, 00000000114, 1, '/rep_noyact.php', 0, '', NULL, 'Отсутствует счет YACT', 0, 'root', '2014-01-31 15:23:58', 'root', '2014-01-31 00:00:00', 0, NULL),
(227, 172, 'Cost distribution', '', 00000000058, 00000000059, 1, '/rent_list.php', 0, '', NULL, 'Распределение затрат', 0, 'root', '2014-02-13 12:55:20', 'root', '2014-02-13 00:00:00', 0, NULL),
(228, 170, 'Cost distribution form', '', 00000000030, 00000000031, 0, '/rent_form.php', 0, '', NULL, 'Распределение затрат', 0, 'root', '2014-02-13 12:56:15', 'root', '2014-02-13 00:00:00', 0, NULL),
(229, 174, 'Report for RHQ', '', 00000000148, 00000000149, 1, '/sp_rhq.php', 0, '', NULL, 'Отчет для RHQ', 0, 'root', '2014-02-14 12:26:10', 'root', '2014-02-14 00:00:00', 0, NULL),
(230, 174, 'Corporate costs', '', 00000000140, 00000000141, 1, '/rep_totals_hq.php', 0, '', NULL, 'Расходы HQ', 0, 'root', '2014-10-24 17:21:11', '', '2015-11-24 00:00:00', 0, NULL),
(231, 174, 'Technical', '', 00000000106, 00000000119, 1, '', 0, '', NULL, 'Служебные', 0, 'root', '2014-10-24 17:22:35', 'root', '2014-10-27 00:00:00', 0, NULL),
(232, 170, 'MSF', '', 00000000032, 00000000033, 0, '/msf_form.php', 0, '', NULL, 'Распределение корпоративных затрат', 0, 'root', '2014-10-27 15:18:45', 'root', '2019-06-04 13:27:42', 0, NULL),
(233, 172, 'MSF', '', 00000000060, 00000000061, 1, '/msf_list.php', 0, '', NULL, 'Распределение корпоративных затрат', 0, 'root', '2014-10-27 15:19:41', 'root', '2014-10-27 00:00:00', 0, NULL),
(234, 174, 'PnL by activity', '', 00000000142, 00000000143, 1, '/rep_totals_activity.php', 0, '', NULL, 'Отчет по активности', 0, 'root', '2014-10-29 12:50:16', 'root', '2014-10-29 00:00:00', 0, NULL),
(235, 174, 'Customer GP', '', 00000000150, 00000000151, 1, '/rep_pnl_activity.php', 0, '', NULL, 'Прибыль по клиентам', 0, 'root', '2014-11-06 11:59:27', 'root', '2014-11-06 00:00:00', 0, NULL),
(236, 174, 'HR', '', 00000000098, 00000000105, 1, '', 0, '', NULL, 'Персонал', 0, 'root', '2014-11-10 14:57:12', 'root', '2015-03-11 00:00:00', 0, NULL),
(237, 174, 'Activity per branch', '', 00000000138, 00000000139, 1, '/rep_totals_activity.php', 0, '', NULL, 'Обзор итогов по активностям', 0, 'root', '2014-12-01 15:20:13', 'root', '2014-12-01 00:00:00', 0, NULL),
(238, 246, 'Monthly', '', 00000000071, 00000000072, 1, '/rep_monthly.php', 0, '', NULL, 'Ежемесячный', 0, 'root', '2015-03-18 16:26:51', '', '2016-02-10 00:00:00', 0, NULL),
(239, 174, 'Sales KPI', '', 00000000152, 00000000153, 0, '/rep_sales_kpi_new.php', 0, '', NULL, 'Продажи', 0, 'root', '2015-04-22 08:53:55', '', '2016-08-15 00:00:00', 0, NULL),
(240, 246, 'Waterfall', '', 00000000075, 00000000076, 1, '/rep_waterfall.php', 0, '', NULL, 'Водопад', 0, 'root', '2015-07-22 15:39:08', 'root', '2015-07-22 00:00:00', 0, NULL),
(241, 2, 'My sales', '', 00000000207, 00000000208, 1, '/rep_my.php', 0, '', NULL, 'Мои продажи', 0, '', '2015-11-06 10:06:35', '', '2015-11-06 00:00:00', 0, 'fa-shopping-cart'),
(242, 2, 'My documents', '', 00000000209, 00000000210, 1, '/sp_my.php', 0, '', NULL, 'Мои документы', 0, '', '2015-11-19 16:10:41', '', '2017-10-30 00:00:00', 0, 'fa-files-o'),
(243, 246, 'Charts', '', 00000000073, 00000000074, 1, '/rep_graphs.php', 0, '', NULL, 'Графики', 0, '', '2016-03-17 16:09:59', '', '2016-03-17 00:00:00', 0, 'fa-line-chart'),
(244, 246, 'Summary', '', 00000000065, 00000000066, 1, '/rep_summary.php', 0, '', NULL, 'Краткий отчет', 0, '', '2016-03-17 16:11:17', '', '2016-08-15 00:00:00', 0, NULL),
(245, 2, 'Setup', '', 00000000213, 00000000214, 1, '/setup.php', 0, '', NULL, 'Настройки приложения', 0, '', '2016-03-30 09:47:46', '', '2016-03-30 09:47:46', 0, NULL),
(246, 174, 'Management', '', 00000000064, 00000000097, 1, '', 0, '', NULL, 'Управленческие', 0, '', '2016-03-30 17:16:56', '', '2016-03-30 00:00:00', 0, NULL),
(247, 231, 'Errors in documents', '', 00000000117, 00000000118, 1, '/rep_nokpi.php', 0, '', NULL, 'Ошибки в документах', 0, '', '2016-06-16 09:12:20', '', '2016-06-16 00:00:00', 0, NULL),
(248, 174, 'GHQ', '', 00000000120, 00000000131, 1, '', 0, '', NULL, 'GHQ', 0, '', '2016-06-17 10:53:07', '', '2016-06-17 00:00:00', 0, NULL),
(249, 248, 'Summary', '', 00000000121, 00000000122, 1, '/rep_summary_ghq.php', 0, '', NULL, 'Краткий отчет', 0, '', '2016-06-17 10:54:01', '', '2016-06-17 00:00:00', 0, NULL),
(250, 248, 'Monthly', '', 00000000123, 00000000124, 1, '/rep_monthly_ghq.php', 0, '', NULL, 'Ежемесячный', 0, '', '2016-06-17 11:01:27', '', '2016-06-17 00:00:00', 0, NULL),
(251, 2, 'Sales by dept', '', 00000000215, 00000000216, 0, '/rep_my_bu.php', 0, '', NULL, 'Продажи отдела', 0, '', '2016-08-15 11:28:12', 'root', '2019-01-29 16:52:41', 0, 'fa-group'),
(252, 246, 'Column chart', '', 00000000077, 00000000078, 1, '/rep_columns.php', 0, '', NULL, 'Гистограмма', 0, '', '2016-11-16 09:59:09', '', '2016-11-16 00:00:00', 0, 'fa-bar-chart'),
(253, 174, 'Capacity', '', 00000000154, 00000000155, 1, '/rep_capacity.php', 0, '', NULL, 'Объемы по портам', 0, '', '2017-04-26 14:22:47', '', '2017-04-26 00:00:00', 0, 'fa-ship'),
(254, 246, 'HQ distribution', '', 00000000079, 00000000080, 1, '/rep_totals_distr.php', 0, '', NULL, 'Распределение корп.затрат', 0, '', '2017-09-01 15:57:45', '', '2017-09-01 00:00:00', 0, NULL),
(255, 246, 'ROY waterfall', '', 00000000081, 00000000082, 1, '/rep_waterfall_fye.php', 0, '', NULL, 'Анализ конца года', 0, '', '2017-09-14 09:49:22', '', '2017-09-14 00:00:00', 0, NULL),
(256, 248, 'ROY waterfall', '', 00000000127, 00000000128, 1, '/rep_waterfall_fye_ghq.php', 0, '', NULL, 'Анализ конца года', 0, '', '2017-09-14 09:52:57', '', '2017-09-14 00:00:00', 0, NULL),
(257, 246, 'Customer cloud', '', 00000000083, 00000000084, 1, '/rep_customer_group.php', 0, '', NULL, 'Облако клиентов', 0, '', '2017-09-14 18:41:39', '', '2017-09-15 00:00:00', 0, NULL),
(258, 246, 'Totals by activity', '', 00000000085, 00000000086, 1, '/rep_bu_activity.php', 0, '', NULL, 'Итоги по продуктам', 0, '', '2017-10-03 14:44:57', '', '2017-10-03 00:00:00', 0, NULL),
(259, 174, 'OFF productivity', '', 00000000156, 00000000157, 1, '/rep_productivity_off.php', 0, '', NULL, 'Производительность OFF', 0, '', '2017-10-27 15:18:34', '', '2017-10-27 00:00:00', 0, NULL),
(260, 2, 'Unit documents', '', 00000000219, 00000000220, 1, '/sp_bu.php', 0, '', NULL, 'Мои документы', 0, '', '2017-10-30 15:04:35', '', '2017-10-30 00:00:00', 0, NULL),
(261, 246, 'PIe chart', '', 00000000087, 00000000088, 0, '/rep_customer_pie.php', 0, '', NULL, 'Диаграмма клиентов', 0, '', '2017-11-03 17:25:07', '', '2017-11-03 00:00:00', 0, NULL),
(262, 2, 'Tools', '', 00000000193, 00000000206, 1, '', 0, '', NULL, 'Инструменты', 0, '', '2017-12-25 15:01:04', '', '2017-12-25 00:00:00', 0, NULL),
(263, 262, 'Post all', '', 00000000194, 00000000195, 1, '/sp_post_all.php', 0, '', NULL, 'Провести все', 0, '', '2017-12-25 15:05:12', '', '2017-12-25 00:00:00', 0, NULL),
(264, 262, 'Repost FX', '', 00000000196, 00000000197, 1, '/sp_repost.php', 0, '', NULL, 'Перепроведение валюты', 0, '', '2017-12-25 15:09:13', '', '2017-12-25 00:00:00', 0, NULL),
(265, 262, 'Post location costs', '', 00000000198, 00000000199, 1, '/sp_repost_loc.php', 0, '', NULL, 'Проведение расходов ОП', 0, '', '2017-12-25 15:23:36', '', '2017-12-25 00:00:00', 0, NULL),
(266, 178, 'Send message', '', 00000000176, 00000000177, 0, '/sp_inform.php', 0, '', NULL, 'Отправить сообщение', 0, '', '2018-01-23 16:03:51', '', '2018-01-23 00:00:00', 0, NULL),
(267, 178, 'Get stickers', '', 00000000178, 00000000179, 0, '/json_stickers.php', 0, '', NULL, 'Получить стикеры', 0, '', '2018-01-23 16:04:25', '', '2018-01-23 00:00:00', 0, NULL),
(268, 262, 'Post HQ costs', '', 00000000200, 00000000201, 1, '/sp_repost_hq.php', 0, '', NULL, 'Проведение корпоративных расходов', 0, 'root', '2018-03-13 11:02:03', 'root', '2018-03-13 11:03:43', 0, NULL),
(269, 246, 'Waterfall for KPI', '', 00000000089, 00000000090, 1, '/rep_waterfall_kpi.php', 0, '', NULL, 'Водопад для объемов', 0, 'root', '2018-06-05 10:36:38', 'root', '2018-10-23 15:08:09', 0, NULL),
(270, 174, 'Gross operating profit', '', 00000000158, 00000000159, 1, '/rep_gop.php', 0, '', NULL, 'Валовая операционная прибыль', 0, 'root', '2018-06-13 15:34:31', 'root', '2018-06-13 15:34:41', 0, NULL),
(271, 262, 'Repost Item', '', 00000000202, 00000000203, 1, '/sp_repost_item.php', 0, '', NULL, 'Перепроведение статьи', 0, 'root', '2018-06-18 16:11:37', 'root', '2018-06-18 16:11:47', 0, NULL),
(272, 246, 'New business', '', 00000000091, 00000000092, 1, '/rep_pnl_new.php', 0, '', NULL, 'Новый бизнес', 0, 'root', '2018-10-23 15:26:58', 'root', '2018-10-24 14:25:46', 0, NULL),
(273, 246, 'Sales composition', '', 00000000093, 00000000094, 1, '/rep_sales_ratio.php', 0, '', NULL, 'Состав клиентов', 0, 'root', '2018-10-24 10:48:41', 'root', '2018-10-24 14:26:25', 0, 'fa-pie-chart'),
(274, 246, 'Customers by year', '', 00000000095, 00000000096, 1, '/rep_year_ratio.php', 0, '', NULL, 'Клиенты по годам', 0, 'root', '2018-11-22 15:33:30', 'root', '2018-11-22 15:33:41', 0, NULL),
(275, 201, 'YACT', '', 00000000186, 00000000187, 1, '/yact_list.php', 0, '', NULL, 'Счета YACT', 0, 'root', '2018-12-24 15:19:41', 'root', '2018-12-24 15:20:01', 0, NULL),
(276, 201, 'Budget items', '', 00000000188, 00000000189, 1, '/item_list.php', 0, '', NULL, 'Бюджетные счета', 0, 'root', '2018-12-24 15:22:12', 'root', '2018-12-24 15:22:26', 0, NULL),
(277, 201, 'Activities', '', 00000000190, 00000000191, 1, '/product_list.php', 0, '', NULL, 'Продукты', 0, 'root', '2018-12-24 15:22:49', 'root', '2018-12-24 15:23:06', 0, NULL),
(278, 248, 'Graphs', '', 00000000129, 00000000130, 1, '/rep_graphs_rhq.php', 0, '', NULL, 'Графики', 0, 'root', '2019-06-05 17:29:29', 'root', '2019-06-06 09:43:36', 0, NULL),
(279, 174, 'Summary for RHQ', '', 00000000160, 00000000161, 0, '/rep_summary_rhq.php', 0, '', NULL, 'Краткий для RHQ', 0, 'root', '2019-06-10 17:42:35', 'root', '2019-06-13 14:42:28', 0, NULL),
(280, 262, 'Cost distribution', '', 00000000204, 00000000205, 1, '/sp_repost_distr.php', 0, '', NULL, 'Распределение затрат', 0, 'root', '2019-08-08 09:16:00', 'root', '2019-08-08 09:16:19', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_page_role`
--

DROP TABLE IF EXISTS `stbl_page_role`;
CREATE TABLE `stbl_page_role` (
  `pgrID` int(11) NOT NULL,
  `pgrPageID` int(11) DEFAULT NULL,
  `pgrRoleID` varchar(50) NOT NULL,
  `pgrFlagRead` tinyint(4) DEFAULT NULL,
  `pgrFlagCreate` tinyint(4) DEFAULT NULL,
  `pgrFlagUpdate` tinyint(4) DEFAULT NULL,
  `pgrFlagDelete` tinyint(4) DEFAULT NULL,
  `pgrFlagWrite` tinyint(4) DEFAULT NULL COMMENT 'Deprecated',
  `pgrInsertBy` varchar(30) DEFAULT NULL,
  `pgrInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pgrEditBy` varchar(30) DEFAULT NULL,
  `pgrEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Authorization table, assigns script rights to users';

--
-- Дамп данных таблицы `stbl_page_role`
--

INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(1, 170, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(2, 170, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(3, 170, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(4, 170, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(6, 170, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(8, 170, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(9, 170, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(10, 170, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(11, 170, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(12, 170, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(13, 170, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(14, 170, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(15, 170, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(16, 170, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(17, 170, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(18, 170, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(19, 170, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(20, 170, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(21, 170, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(22, 170, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(23, 170, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2014-01-14 09:17:01'),
(24, 170, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(25, 170, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(26, 170, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(27, 170, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(28, 170, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(29, 170, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(30, 170, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(31, 170, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(32, 170, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(33, 170, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(34, 170, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(35, 170, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(36, 170, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(37, 170, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:55:03'),
(38, 170, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(39, 170, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(40, 170, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(41, 170, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(42, 170, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(43, 170, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(44, 170, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(45, 170, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(46, 170, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(47, 170, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(49, 170, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(50, 170, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(51, 170, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(52, 170, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(53, 170, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(54, 170, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(55, 170, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:54:40', 'root', '2013-10-22 13:54:40'),
(64, 171, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(65, 171, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(66, 171, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(67, 171, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(69, 171, '35', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(71, 171, '39', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(72, 171, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(73, 171, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(74, 171, '44', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(75, 171, 'VYPMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(76, 171, '50', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(77, 171, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(78, 171, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(79, 171, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(80, 171, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(81, 171, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(82, 171, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(83, 171, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(84, 171, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(85, 171, 'STPMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(86, 171, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2014-01-14 09:17:01'),
(87, 171, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(88, 171, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(89, 171, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(90, 171, 'SALES', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:58:31'),
(91, 171, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(92, 171, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(93, 171, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(94, 171, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(95, 171, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(96, 171, 'TMMRMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(97, 171, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(98, 171, 'SALMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:58:31'),
(99, 171, 'FWDMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(100, 171, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:57:12'),
(101, 171, 'WHPMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(102, 171, 'WHMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(103, 171, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:57:12'),
(104, 171, 'AFFMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(105, 171, 'HCMRMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(106, 171, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(107, 171, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(108, 171, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(109, 171, 'WHSMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(110, 171, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(112, 171, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(113, 171, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(114, 171, 'NMGRMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(115, 171, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(116, 171, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(117, 171, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-22 13:55:27'),
(118, 171, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-22 01:55:27', 'root', '2013-10-28 13:27:18'),
(127, 172, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(128, 172, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(129, 172, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(130, 172, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(131, 172, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(133, 172, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(135, 172, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(136, 172, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(137, 172, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(138, 172, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(139, 172, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(140, 172, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(141, 172, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(142, 172, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(143, 172, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(144, 172, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(145, 172, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(146, 172, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(147, 172, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(148, 172, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(149, 172, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(150, 172, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2014-01-14 09:17:01'),
(151, 172, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(152, 172, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(153, 172, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(154, 172, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(155, 172, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(156, 172, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(157, 172, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(158, 172, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(159, 172, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(160, 172, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(161, 172, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(162, 172, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(163, 172, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(164, 172, 'ADMIN', 1, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(165, 172, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(166, 172, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(167, 172, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(168, 172, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(169, 172, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(170, 172, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(171, 172, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(172, 172, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(173, 172, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(174, 172, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(176, 172, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:50:08'),
(177, 172, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(178, 172, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(179, 172, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(180, 172, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(181, 172, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(182, 172, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:49:36', 'root', '2013-10-23 08:49:36'),
(190, 173, '10', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:12'),
(191, 173, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(192, 173, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(193, 173, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(194, 173, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(196, 173, '35', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-11-01 17:38:57'),
(198, 173, '39', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:12'),
(199, 173, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(200, 173, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(201, 173, '44', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:12'),
(202, 173, 'VYPMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:12'),
(203, 173, '50', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:12'),
(204, 173, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(205, 173, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(206, 173, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(207, 173, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(208, 173, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(209, 173, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(210, 173, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(211, 173, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(212, 173, 'STPMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(213, 173, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2014-01-14 09:17:01'),
(214, 173, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(215, 173, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(216, 173, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(217, 173, 'SALES', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(218, 173, 'MANAGEMENT', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-11-01 17:38:57'),
(219, 173, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(220, 173, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(221, 173, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(222, 173, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(223, 173, 'TMMRMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(224, 173, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(225, 173, 'SALMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(226, 173, 'FWDMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(227, 173, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:51:06'),
(228, 173, 'WHPMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(229, 173, 'WHMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(230, 173, 'FM', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(231, 173, 'AFFMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(232, 173, 'HCMRMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(233, 173, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(234, 173, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(235, 173, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(236, 173, 'WHSMNG', 0, 1, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 23:00:13'),
(237, 173, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(239, 173, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:51:06'),
(240, 173, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(241, 173, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(242, 173, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(243, 173, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(244, 173, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(245, 173, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:50:42', 'root', '2013-10-23 08:50:42'),
(253, 174, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(254, 174, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(255, 174, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(256, 174, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(257, 174, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(259, 174, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(261, 174, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(262, 174, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(263, 174, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(264, 174, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(265, 174, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(266, 174, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(267, 174, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(268, 174, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(269, 174, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(270, 174, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(271, 174, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(272, 174, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(273, 174, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(274, 174, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(275, 174, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(276, 174, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2014-01-14 09:17:01'),
(277, 174, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(278, 174, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(279, 174, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(280, 174, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(281, 174, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(282, 174, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(283, 174, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(284, 174, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(285, 174, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(286, 174, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(287, 174, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(288, 174, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(289, 174, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(290, 174, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:47'),
(291, 174, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(292, 174, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(293, 174, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(294, 174, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(295, 174, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(296, 174, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-10-22 20:51:33', '', '2018-10-29 16:14:16'),
(297, 174, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(298, 174, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(299, 174, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(300, 174, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(302, 174, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:47'),
(303, 174, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(304, 174, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(305, 174, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(306, 174, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(307, 174, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(308, 174, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 20:51:33', 'root', '2013-10-23 08:51:33'),
(316, 2, 'ALLUSERS', 1, NULL, NULL, NULL, NULL, NULL, '2013-10-22 21:22:23', NULL, NULL),
(317, 175, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(318, 175, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(319, 175, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(320, 175, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(321, 175, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(323, 175, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(325, 175, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(326, 175, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(327, 175, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(328, 175, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(329, 175, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(330, 175, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(331, 175, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(332, 175, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(333, 175, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(334, 175, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(335, 175, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(336, 175, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(337, 175, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(338, 175, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(339, 175, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(340, 175, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2014-01-14 09:17:01'),
(341, 175, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(342, 175, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(343, 175, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(344, 175, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(345, 175, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(346, 175, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(347, 175, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(348, 175, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(349, 175, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(350, 175, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(351, 175, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(352, 175, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(353, 175, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(354, 175, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:25'),
(355, 175, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(356, 175, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(357, 175, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(358, 175, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(359, 175, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(360, 175, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(361, 175, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(362, 175, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(363, 175, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(364, 175, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(366, 175, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:25'),
(367, 175, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(368, 175, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(369, 175, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(370, 175, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(371, 175, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(372, 175, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:25:13', 'root', '2013-10-23 09:25:13'),
(380, 176, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(381, 176, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(382, 176, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(383, 176, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(384, 176, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(386, 176, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(388, 176, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(389, 176, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(390, 176, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(391, 176, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(392, 176, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(393, 176, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(394, 176, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(395, 176, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(396, 176, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(397, 176, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(398, 176, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(399, 176, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(400, 176, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(401, 176, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(402, 176, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(403, 176, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2014-01-14 09:17:01'),
(404, 176, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(405, 176, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(406, 176, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(407, 176, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(408, 176, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(409, 176, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(410, 176, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(411, 176, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(412, 176, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(413, 176, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(414, 176, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(415, 176, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(416, 176, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(417, 176, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:51'),
(418, 176, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(419, 176, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(420, 176, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(421, 176, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(422, 176, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(423, 176, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(424, 176, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(425, 176, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(426, 176, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(427, 176, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(429, 176, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:51'),
(430, 176, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(431, 176, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(432, 176, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(433, 176, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(434, 176, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(435, 176, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:30:33', 'root', '2013-10-23 09:30:33'),
(443, 177, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(444, 177, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(445, 177, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(446, 177, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(447, 177, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(449, 177, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(451, 177, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(452, 177, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(453, 177, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(454, 177, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(455, 177, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(456, 177, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(457, 177, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(458, 177, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(459, 177, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(460, 177, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(461, 177, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(462, 177, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(463, 177, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(464, 177, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(465, 177, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(466, 177, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2014-01-14 09:17:01'),
(467, 177, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(468, 177, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(469, 177, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(470, 177, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(471, 177, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(472, 177, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(473, 177, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(474, 177, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(475, 177, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(476, 177, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(477, 177, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(478, 177, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(479, 177, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(480, 177, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:26'),
(481, 177, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(482, 177, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(483, 177, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(484, 177, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(485, 177, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(486, 177, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(487, 177, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(488, 177, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(489, 177, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(490, 177, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(492, 177, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:26'),
(493, 177, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(494, 177, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(495, 177, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(496, 177, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(497, 177, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(498, 177, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 21:31:08', 'root', '2013-10-23 09:31:08'),
(506, 178, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(507, 178, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(508, 178, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(509, 178, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(510, 178, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(512, 178, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(514, 178, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(515, 178, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(516, 178, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(517, 178, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(518, 178, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(519, 178, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(520, 178, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(521, 178, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(522, 178, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(523, 178, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(524, 178, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(525, 178, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(526, 178, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(527, 178, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(528, 178, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(529, 178, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2014-01-14 09:17:01'),
(530, 178, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(531, 178, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(532, 178, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(533, 178, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(534, 178, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(535, 178, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(536, 178, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(537, 178, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(538, 178, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(539, 178, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(540, 178, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(541, 178, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(542, 178, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(543, 178, 'ADMIN', 1, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(544, 178, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(545, 178, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(546, 178, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(547, 178, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(548, 178, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(549, 178, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(550, 178, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(551, 178, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(552, 178, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(553, 178, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(555, 178, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(556, 178, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(557, 178, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(558, 178, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(559, 178, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(560, 178, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(561, 178, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:13:50', 'root', '2013-10-23 11:13:50'),
(569, 179, '10', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(570, 179, '21', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(571, 179, '26', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(572, 179, '29', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(573, 179, '3', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(575, 179, '35', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(577, 179, '39', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(578, 179, '42', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(579, 179, '43', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(580, 179, '44', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(581, 179, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(582, 179, '50', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(583, 179, '51', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(584, 179, '8', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(585, 179, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(586, 179, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(587, 179, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(588, 179, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(589, 179, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(590, 179, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(591, 179, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(592, 179, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2014-01-14 09:17:01'),
(593, 179, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(594, 179, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(595, 179, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(596, 179, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(597, 179, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(598, 179, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(599, 179, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(600, 179, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(601, 179, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(602, 179, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(603, 179, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(604, 179, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(605, 179, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(606, 179, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:22'),
(607, 179, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(608, 179, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(609, 179, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(610, 179, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(611, 179, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(612, 179, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(613, 179, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(614, 179, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(615, 179, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(616, 179, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(618, 179, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:22'),
(619, 179, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(620, 179, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(621, 179, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(622, 179, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(623, 179, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(624, 179, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-22 23:14:12', 'root', '2013-10-23 11:14:12'),
(632, 180, '10', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(633, 180, '21', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(634, 180, '26', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(635, 180, '29', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(636, 180, '3', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(638, 180, '35', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(640, 180, '39', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(641, 180, '42', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(642, 180, '43', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(643, 180, '44', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(644, 180, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(645, 180, '50', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(646, 180, '51', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(647, 180, '8', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(648, 180, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(649, 180, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(650, 180, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(651, 180, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(652, 180, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(653, 180, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(654, 180, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(655, 180, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2014-01-14 09:17:01'),
(656, 180, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(657, 180, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(658, 180, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(659, 180, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(660, 180, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(661, 180, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(662, 180, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(663, 180, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(664, 180, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(665, 180, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(666, 180, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(667, 180, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(668, 180, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(669, 180, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:37'),
(670, 180, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(671, 180, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(672, 180, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(673, 180, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(674, 180, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(675, 180, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(676, 180, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(677, 180, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(678, 180, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(679, 180, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(681, 180, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:37'),
(682, 180, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(683, 180, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(684, 180, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(685, 180, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(686, 180, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(687, 180, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-23 02:05:29', 'root', '2013-10-23 14:05:29'),
(695, 181, '10', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(696, 181, '21', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(697, 181, '26', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(698, 181, '29', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(699, 181, '3', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(701, 181, '35', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(703, 181, '39', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(704, 181, '42', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(705, 181, '43', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(706, 181, '44', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(707, 181, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(708, 181, '50', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(709, 181, '51', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(710, 181, '8', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(711, 181, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(712, 181, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(713, 181, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(714, 181, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(715, 181, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(716, 181, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(717, 181, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(718, 181, 'HR', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2014-01-14 09:17:01'),
(719, 181, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(720, 181, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(721, 181, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(722, 181, 'SALES', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', '', '2016-08-15 11:43:34'),
(723, 181, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(724, 181, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(725, 181, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(726, 181, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(727, 181, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(728, 181, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(729, 181, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(730, 181, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(731, 181, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(732, 181, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:04:10'),
(733, 181, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(734, 181, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(735, 181, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(736, 181, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(737, 181, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(738, 181, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(739, 181, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(740, 181, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(741, 181, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(742, 181, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(744, 181, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:04:10'),
(745, 181, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(746, 181, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(747, 181, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(748, 181, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(749, 181, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(750, 181, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:03:53', 'root', '2013-10-23 23:03:53'),
(758, 182, '10', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(759, 182, '21', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(760, 182, '26', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(761, 182, '29', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(762, 182, '3', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(764, 182, '35', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2015-03-11 13:11:38'),
(766, 182, '39', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(767, 182, '42', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(768, 182, '43', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(769, 182, '44', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(770, 182, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(771, 182, '50', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(772, 182, '51', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(773, 182, '8', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(774, 182, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(775, 182, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(776, 182, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(777, 182, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(778, 182, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(779, 182, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(780, 182, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(781, 182, 'HR', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2014-01-14 09:17:01'),
(782, 182, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(783, 182, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(784, 182, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(785, 182, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(786, 182, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(787, 182, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(788, 182, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(789, 182, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(790, 182, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(791, 182, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(792, 182, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(793, 182, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(794, 182, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(795, 182, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:51:27'),
(796, 182, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(797, 182, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(798, 182, 'FM', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:51:27'),
(799, 182, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(800, 182, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(801, 182, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(802, 182, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(803, 182, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(804, 182, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(805, 182, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(807, 182, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(808, 182, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(809, 182, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(810, 182, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(811, 182, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(812, 182, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:50:14'),
(813, 182, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-23 11:50:14', 'root', '2013-10-23 23:51:27'),
(814, 183, '10', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(815, 183, '21', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(816, 183, '26', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(817, 183, '29', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(818, 183, '3', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(820, 183, '35', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(822, 183, '39', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(823, 183, '42', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(824, 183, '43', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(825, 183, '44', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(826, 183, 'VYPMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(827, 183, '50', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(828, 183, '51', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(829, 183, '8', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(830, 183, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(831, 183, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(832, 183, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(833, 183, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(834, 183, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(835, 183, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(836, 183, 'STPMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(837, 183, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2014-01-14 09:17:01'),
(838, 183, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(839, 183, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(840, 183, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(841, 183, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', '', '2016-12-08 14:54:51'),
(842, 183, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(843, 183, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(844, 183, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(845, 183, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(846, 183, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(847, 183, 'TMMRMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(848, 183, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(849, 183, 'SALMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(850, 183, 'FWDMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(851, 183, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(852, 183, 'WHPMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:26'),
(853, 183, 'WHMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(854, 183, 'FM', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(855, 183, 'AFFMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(856, 183, 'HCMRMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(857, 183, 'ADMMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-11-19 10:51:00'),
(858, 183, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(859, 183, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(860, 183, 'WHSMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(861, 183, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(863, 183, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(864, 183, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(865, 183, 'NMGRMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(866, 183, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(867, 183, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:57:23'),
(868, 183, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(869, 183, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-24 01:57:23', 'root', '2013-10-24 13:58:27'),
(870, 184, '10', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(871, 184, '21', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(872, 184, '26', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(873, 184, '29', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(874, 184, '3', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(876, 184, '35', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(878, 184, '39', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(879, 184, '42', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(880, 184, '43', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(881, 184, '44', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(882, 184, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(883, 184, '50', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(884, 184, '51', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(885, 184, '8', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(886, 184, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(887, 184, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(888, 184, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(889, 184, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(890, 184, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(891, 184, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(892, 184, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(893, 184, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2014-01-14 09:17:01'),
(894, 184, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(895, 184, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(896, 184, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(897, 184, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(898, 184, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:45:25'),
(899, 184, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(900, 184, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(901, 184, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(902, 184, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(903, 184, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(904, 184, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(905, 184, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(906, 184, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(907, 184, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:45:25'),
(908, 184, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(909, 184, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(910, 184, 'FM', 1, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:45:25'),
(911, 184, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(912, 184, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(913, 184, 'ADMMNG', 1, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:45:25'),
(914, 184, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(915, 184, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(916, 184, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(917, 184, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(919, 184, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(920, 184, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(921, 184, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(922, 184, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(923, 184, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:44:54'),
(924, 184, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:45:25'),
(925, 184, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-28 02:44:54', 'root', '2013-10-28 14:45:25'),
(933, 185, '10', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(934, 185, '21', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(935, 185, '26', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(936, 185, '29', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(937, 185, '3', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(939, 185, '35', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(941, 185, '39', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(942, 185, '42', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(943, 185, '43', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(944, 185, '44', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(945, 185, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(946, 185, '50', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(947, 185, '51', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(948, 185, '8', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(949, 185, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(950, 185, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(951, 185, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(952, 185, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(953, 185, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(954, 185, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(955, 185, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(956, 185, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2014-01-14 09:17:01'),
(957, 185, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(958, 185, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(959, 185, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(960, 185, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(961, 185, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:43:21', 'root', '2014-05-26 16:38:18'),
(962, 185, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(963, 185, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(964, 185, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2019-06-26 09:40:28'),
(965, 185, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(966, 185, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(967, 185, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:43:21', 'root', '2013-11-08 12:15:37'),
(968, 185, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(969, 185, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(970, 185, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:55'),
(971, 185, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(972, 185, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(973, 185, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:55'),
(974, 185, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(975, 185, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(976, 185, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:43:21', 'root', '2013-11-08 12:15:37'),
(977, 185, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(978, 185, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(979, 185, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(980, 185, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(982, 185, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(983, 185, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(984, 185, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(985, 185, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(986, 185, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(987, 185, 'ACCMNG', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:55'),
(988, 185, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:43:21', 'root', '2013-10-28 15:43:21'),
(996, 186, '10', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(997, 186, '21', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(998, 186, '26', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(999, 186, '29', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1000, 186, '3', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1002, 186, '35', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1004, 186, '39', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1005, 186, '42', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1006, 186, '43', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1007, 186, '44', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1008, 186, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1009, 186, '50', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1010, 186, '51', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1011, 186, '8', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1012, 186, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1013, 186, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1014, 186, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1015, 186, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1016, 186, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1017, 186, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1018, 186, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1019, 186, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2014-01-14 09:17:01'),
(1020, 186, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1021, 186, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1022, 186, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1023, 186, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1024, 186, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:45:05', 'root', '2014-05-26 14:58:48'),
(1025, 186, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1026, 186, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1027, 186, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', '', '2018-11-15 15:14:28'),
(1028, 186, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1029, 186, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1030, 186, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:45:05', 'root', '2013-11-11 17:48:09'),
(1031, 186, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1032, 186, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1033, 186, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:28'),
(1034, 186, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1035, 186, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1036, 186, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:28'),
(1037, 186, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1038, 186, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1039, 186, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-10-28 03:45:05', 'root', '2013-11-11 17:48:09'),
(1040, 186, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1041, 186, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1042, 186, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1043, 186, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1045, 186, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:28'),
(1046, 186, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1047, 186, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1048, 186, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1049, 186, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1050, 186, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1051, 186, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-28 03:45:05', 'root', '2013-10-28 15:45:05'),
(1052, 187, '10', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1053, 187, '21', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1054, 187, '26', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1055, 187, '29', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1056, 187, '3', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1058, 187, '35', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1060, 187, '39', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1061, 187, '42', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1062, 187, '43', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1063, 187, '44', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1064, 187, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1065, 187, '50', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1066, 187, '51', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1067, 187, '8', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1068, 187, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1069, 187, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1070, 187, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1071, 187, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1072, 187, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1073, 187, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1074, 187, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1075, 187, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2014-01-14 09:17:01'),
(1076, 187, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1077, 187, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1078, 187, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1079, 187, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1080, 187, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2014-05-26 15:05:22'),
(1081, 187, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1082, 187, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1083, 187, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1084, 187, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1085, 187, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1086, 187, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1087, 187, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1088, 187, 'FWDMNG', 0, 1, 1, 1, 1, 'root', '2013-10-28 22:06:12', 'root', '2014-05-26 15:05:22'),
(1089, 187, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:24'),
(1090, 187, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1091, 187, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1092, 187, 'FM', 0, 1, 1, 1, 1, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:24'),
(1093, 187, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1094, 187, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1095, 187, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1096, 187, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1097, 187, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1098, 187, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1099, 187, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1101, 187, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:24'),
(1102, 187, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1103, 187, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1104, 187, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1105, 187, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1106, 187, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1107, 187, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-28 22:06:12', 'root', '2013-10-29 10:06:12'),
(1115, 188, '10', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1116, 188, '21', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1117, 188, '26', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1118, 188, '29', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1119, 188, '3', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1121, 188, '35', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1123, 188, '39', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1124, 188, '42', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1125, 188, '43', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1126, 188, '44', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1127, 188, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1128, 188, '50', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1129, 188, '51', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1130, 188, '8', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1131, 188, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1132, 188, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1133, 188, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1134, 188, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1135, 188, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1136, 188, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1137, 188, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1138, 188, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2014-01-14 09:17:01'),
(1139, 188, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1140, 188, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1141, 188, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1142, 188, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1143, 188, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1144, 188, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1145, 188, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1146, 188, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1147, 188, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1148, 188, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1149, 188, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1150, 188, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1151, 188, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1152, 188, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:17'),
(1153, 188, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1154, 188, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1155, 188, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1156, 188, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1157, 188, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1158, 188, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1159, 188, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1160, 188, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1161, 188, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1162, 188, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1164, 188, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:17'),
(1165, 188, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1166, 188, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1167, 188, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1168, 188, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1169, 188, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1170, 188, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:08:10', 'root', '2013-10-29 14:08:10'),
(1178, 189, '10', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1179, 189, '21', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1180, 189, '26', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1181, 189, '29', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1182, 189, '3', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1184, 189, '35', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1186, 189, '39', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1187, 189, '42', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1188, 189, '43', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1189, 189, '44', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1190, 189, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1191, 189, '50', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1192, 189, '51', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1193, 189, '8', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1194, 189, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1195, 189, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1196, 189, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1197, 189, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1198, 189, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1199, 189, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1200, 189, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1201, 189, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2014-01-14 09:17:01'),
(1202, 189, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1203, 189, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1204, 189, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1205, 189, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1206, 189, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:26'),
(1207, 189, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1208, 189, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1209, 189, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1210, 189, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1211, 189, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(1212, 189, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1213, 189, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1214, 189, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1215, 189, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:26'),
(1216, 189, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1217, 189, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1218, 189, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:44'),
(1219, 189, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1220, 189, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1221, 189, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1222, 189, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1223, 189, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1224, 189, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1225, 189, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1227, 189, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:26'),
(1228, 189, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1229, 189, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1230, 189, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1231, 189, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1232, 189, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1233, 189, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:09:04', 'root', '2013-10-29 14:09:04'),
(1241, 190, '10', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1242, 190, '21', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1243, 190, '26', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1244, 190, '29', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1245, 190, '3', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1247, 190, '35', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1249, 190, '39', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1250, 190, '42', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1251, 190, '43', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1252, 190, '44', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1253, 190, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1254, 190, '50', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1255, 190, '51', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1256, 190, '8', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1257, 190, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1258, 190, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1259, 190, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1260, 190, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1261, 190, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1262, 190, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1263, 190, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1264, 190, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2014-01-14 09:17:01'),
(1265, 190, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1266, 190, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1267, 190, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1268, 190, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1269, 190, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:51'),
(1270, 190, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1271, 190, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1272, 190, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1273, 190, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1274, 190, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1275, 190, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1276, 190, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1277, 190, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1278, 190, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:51'),
(1279, 190, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1280, 190, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1281, 190, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:51'),
(1282, 190, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1283, 190, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1284, 190, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1285, 190, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1286, 190, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1287, 190, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1288, 190, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1290, 190, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:51'),
(1291, 190, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1292, 190, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1293, 190, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1294, 190, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1295, 190, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1296, 190, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-29 02:10:16', 'root', '2013-10-29 14:10:16'),
(1304, 191, '10', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1305, 191, '21', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1306, 191, '26', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1307, 191, '29', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1308, 191, '3', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1310, 191, '35', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1312, 191, '39', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1313, 191, '42', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1314, 191, '43', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1315, 191, '44', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1316, 191, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1317, 191, '50', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1318, 191, '51', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1319, 191, '8', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1320, 191, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1321, 191, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1322, 191, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1323, 191, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1324, 191, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1325, 191, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1326, 191, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1327, 191, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2014-01-14 09:17:01'),
(1328, 191, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1329, 191, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1330, 191, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1331, 191, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1332, 191, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1333, 191, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1334, 191, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1335, 191, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1336, 191, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1337, 191, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1338, 191, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1339, 191, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1340, 191, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1341, 191, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:34'),
(1342, 191, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1343, 191, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1344, 191, 'FM', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1345, 191, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1346, 191, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1347, 191, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1348, 191, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1349, 191, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1350, 191, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1351, 191, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1353, 191, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:34'),
(1354, 191, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1355, 191, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1356, 191, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1357, 191, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1358, 191, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1359, 191, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-29 05:22:25', 'root', '2013-10-29 17:22:25'),
(1367, 192, '10', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1368, 192, '21', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1369, 192, '26', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1370, 192, '29', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1371, 192, '3', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1373, 192, '35', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1375, 192, '39', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1376, 192, '42', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1377, 192, '43', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1378, 192, '44', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1379, 192, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1380, 192, '50', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1381, 192, '51', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1382, 192, '8', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1383, 192, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1384, 192, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1385, 192, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1386, 192, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1387, 192, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2015-06-20 10:59:44'),
(1388, 192, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1389, 192, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1390, 192, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2014-01-14 09:17:01'),
(1391, 192, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1392, 192, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1393, 192, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1394, 192, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1395, 192, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-31 10:46:07'),
(1396, 192, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1397, 192, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1398, 192, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1399, 192, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1400, 192, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1401, 192, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1402, 192, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1403, 192, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1404, 192, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:27:03'),
(1405, 192, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1406, 192, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1407, 192, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:27:03'),
(1408, 192, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1409, 192, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1410, 192, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1411, 192, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1412, 192, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1413, 192, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1414, 192, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1416, 192, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1417, 192, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1418, 192, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1419, 192, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1420, 192, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1421, 192, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:26:40'),
(1422, 192, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:26:40', 'root', '2013-10-30 23:27:03'),
(1430, 193, '10', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1431, 193, '21', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1432, 193, '26', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1433, 193, '29', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1434, 193, '3', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1436, 193, '35', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1438, 193, '39', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1439, 193, '42', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1440, 193, '43', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1441, 193, '44', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1442, 193, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1443, 193, '50', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1444, 193, '51', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1445, 193, '8', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1446, 193, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1447, 193, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1448, 193, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1449, 193, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1450, 193, '9101', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:27:26', 'root', '2013-10-31 10:54:41'),
(1451, 193, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1452, 193, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1453, 193, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2014-01-14 09:17:01'),
(1454, 193, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1455, 193, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1456, 193, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1457, 193, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1458, 193, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:27:26', 'root', '2013-10-31 10:54:41'),
(1459, 193, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1460, 193, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1461, 193, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1462, 193, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1463, 193, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1464, 193, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1465, 193, 'SALMNG', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:28:01'),
(1466, 193, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1467, 193, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:28:01'),
(1468, 193, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1469, 193, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1470, 193, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:28:01'),
(1471, 193, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1472, 193, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1473, 193, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1474, 193, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1475, 193, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1476, 193, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1477, 193, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1479, 193, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1480, 193, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1481, 193, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1482, 193, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1483, 193, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1484, 193, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:27:26'),
(1485, 193, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:27:26', 'root', '2013-10-30 23:28:01'),
(1521, 194, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:29:26', 'root', '2013-10-31 10:55:16'),
(1533, 194, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:29:26', 'root', '2013-10-30 23:29:54'),
(1548, 194, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:29:26', 'root', '2013-10-30 23:29:55'),
(1556, 195, '10', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1557, 195, '21', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1558, 195, '26', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1559, 195, '29', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1560, 195, '3', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1562, 195, '35', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1564, 195, '39', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1565, 195, '42', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1566, 195, '43', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1567, 195, '44', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1568, 195, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1569, 195, '50', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1570, 195, '51', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1571, 195, '8', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1572, 195, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1573, 195, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1574, 195, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1575, 195, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1576, 195, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-11-14 15:38:59'),
(1577, 195, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1578, 195, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1579, 195, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2014-01-14 09:17:01'),
(1580, 195, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1581, 195, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1582, 195, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1583, 195, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1584, 195, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:30:20', 'root', '2013-11-14 15:38:59'),
(1585, 195, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1586, 195, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1587, 195, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1588, 195, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1589, 195, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1590, 195, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1591, 195, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1592, 195, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1593, 195, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:52'),
(1594, 195, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1595, 195, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1596, 195, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:52'),
(1597, 195, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1598, 195, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1599, 195, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1600, 195, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1601, 195, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1602, 195, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1603, 195, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1605, 195, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1606, 195, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1607, 195, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1608, 195, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1609, 195, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:20'),
(1610, 195, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:52'),
(1611, 195, 'MD', 1, 0, 0, 0, 0, 'root', '2013-10-30 11:30:20', 'root', '2013-10-30 23:30:53'),
(1619, 196, '10', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1620, 196, '21', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1621, 196, '26', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1622, 196, '29', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1623, 196, '3', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1625, 196, '35', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1627, 196, '39', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1628, 196, '42', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1629, 196, '43', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1630, 196, '44', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1631, 196, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1632, 196, '50', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1633, 196, '51', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1634, 196, '8', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1635, 196, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1636, 196, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1637, 196, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1638, 196, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1639, 196, '9101', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1640, 196, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1641, 196, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1642, 196, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2014-01-14 09:17:02'),
(1643, 196, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1644, 196, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1645, 196, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1646, 196, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1647, 196, 'MANAGEMENT', 1, 1, 1, 0, 1, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:14:29'),
(1648, 196, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1649, 196, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1650, 196, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1651, 196, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1652, 196, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1653, 196, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1654, 196, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1655, 196, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1656, 196, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:14:29'),
(1657, 196, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1658, 196, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1659, 196, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:14:29'),
(1660, 196, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1661, 196, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1662, 196, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1663, 196, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1664, 196, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1665, 196, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1666, 196, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1668, 196, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:14:29'),
(1669, 196, 'FINANCE', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:13:53', 'root', '2013-11-12 13:13:04'),
(1670, 196, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1671, 196, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1672, 196, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1673, 196, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1674, 196, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:13:53', 'root', '2013-10-31 16:13:53'),
(1745, 198, '10', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1746, 198, '21', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1747, 198, '26', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1748, 198, '29', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1749, 198, '3', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1751, 198, '35', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1753, 198, '39', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1754, 198, '42', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1755, 198, '43', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1756, 198, '44', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1757, 198, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1758, 198, '50', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1759, 198, '51', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1760, 198, '8', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1761, 198, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1762, 198, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1763, 198, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1764, 198, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1765, 198, '9101', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:40'),
(1766, 198, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1767, 198, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1768, 198, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2014-01-14 09:17:02'),
(1769, 198, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1770, 198, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1771, 198, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1772, 198, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1773, 198, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:15:18', 'root', '2013-11-01 15:44:41'),
(1774, 198, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1775, 198, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1776, 198, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1777, 198, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1778, 198, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1779, 198, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:15:18', 'root', '2013-11-08 12:17:42'),
(1780, 198, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1781, 198, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1782, 198, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:40'),
(1783, 198, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1784, 198, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1785, 198, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:40'),
(1786, 198, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1787, 198, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1788, 198, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:15:18', 'root', '2013-11-08 12:17:42'),
(1789, 198, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1790, 198, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1791, 198, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1792, 198, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1794, 198, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:40'),
(1795, 198, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1796, 198, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1797, 198, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1798, 198, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1799, 198, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1800, 198, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:15:18', 'root', '2013-10-31 16:15:18'),
(1808, 199, '10', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1809, 199, '21', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1810, 199, '26', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1811, 199, '29', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1812, 199, '3', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1814, 199, '35', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1816, 199, '39', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1817, 199, '42', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1818, 199, '43', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1819, 199, '44', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1820, 199, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1821, 199, '50', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1822, 199, '51', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1823, 199, '8', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1824, 199, '9000', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1825, 199, '9001', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1826, 199, '9002', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1827, 199, '9100', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1828, 199, '9101', 1, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:34:03'),
(1829, 199, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1830, 199, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1831, 199, 'HR', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2014-01-14 09:17:02'),
(1832, 199, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1833, 199, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1834, 199, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1835, 199, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1836, 199, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:34:03'),
(1837, 199, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1838, 199, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1839, 199, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1840, 199, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1841, 199, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1842, 199, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1843, 199, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1844, 199, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1845, 199, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:34:03'),
(1846, 199, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1847, 199, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1848, 199, 'FM', 1, 1, 1, 1, 1, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:34:03'),
(1849, 199, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1850, 199, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1851, 199, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1852, 199, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1853, 199, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1854, 199, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1855, 199, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1857, 199, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:34:03'),
(1858, 199, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-11-12 13:12:46'),
(1859, 199, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1860, 199, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1861, 199, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1862, 199, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:34:03'),
(1863, 199, 'MD', 0, 0, 0, 0, 0, 'root', '2013-10-31 04:33:35', 'root', '2013-10-31 16:33:35'),
(1871, 200, '10', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1872, 200, '21', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1873, 200, '26', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1874, 200, '29', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1875, 200, '3', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1877, 200, '35', 1, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2019-05-20 17:15:15'),
(1879, 200, '39', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1880, 200, '42', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1881, 200, '43', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1882, 200, '44', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1883, 200, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1884, 200, '50', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1885, 200, '51', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1886, 200, '8', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1887, 200, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1888, 200, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1889, 200, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1890, 200, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1891, 200, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1892, 200, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1893, 200, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1894, 200, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2014-01-14 09:17:02'),
(1895, 200, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1896, 200, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1897, 200, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1898, 200, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1899, 200, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:17:14'),
(1900, 200, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1901, 200, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1902, 200, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1903, 200, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1904, 200, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1905, 200, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-11-01 03:16:45', 'root', '2013-11-08 12:17:19'),
(1906, 200, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1907, 200, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1908, 200, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:17:14'),
(1909, 200, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1910, 200, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1911, 200, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:17:14'),
(1912, 200, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1913, 200, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1914, 200, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-01 03:16:45', 'root', '2013-11-08 12:17:19'),
(1915, 200, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1916, 200, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1917, 200, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1918, 200, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1920, 200, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:17:15'),
(1921, 200, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1922, 200, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1923, 200, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1924, 200, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:16:45'),
(1925, 200, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:17:15'),
(1926, 200, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-01 03:16:45', 'root', '2013-11-01 15:17:15'),
(1927, 201, '10', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1928, 201, '21', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1929, 201, '26', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1930, 201, '29', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1931, 201, '3', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1933, 201, '35', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1935, 201, '39', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1936, 201, '42', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1937, 201, '43', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1938, 201, '44', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1939, 201, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1940, 201, '50', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1941, 201, '51', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(1942, 201, '8', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1943, 201, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1944, 201, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1945, 201, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1946, 201, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1947, 201, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1948, 201, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1949, 201, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1950, 201, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2014-01-14 09:17:02'),
(1951, 201, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1952, 201, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1953, 201, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1954, 201, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1955, 201, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1956, 201, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1957, 201, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1958, 201, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1959, 201, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1960, 201, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1961, 201, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1962, 201, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1963, 201, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1964, 201, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:37'),
(1965, 201, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1966, 201, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1967, 201, 'FM', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1968, 201, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1969, 201, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1970, 201, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1971, 201, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1972, 201, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1973, 201, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1974, 201, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1976, 201, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:37'),
(1977, 201, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1978, 201, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1979, 201, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1980, 201, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1981, 201, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1982, 201, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:23:28', 'root', '2013-11-11 14:23:28'),
(1990, 202, '10', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(1991, 202, '21', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(1992, 202, '26', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(1993, 202, '29', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(1994, 202, '3', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(1996, 202, '35', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:45'),
(1998, 202, '39', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(1999, 202, '42', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2000, 202, '43', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2001, 202, '44', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2002, 202, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2003, 202, '50', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2004, 202, '51', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2005, 202, '8', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2006, 202, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2007, 202, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2008, 202, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2009, 202, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2010, 202, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2011, 202, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2012, 202, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2013, 202, 'HR', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2014-01-14 09:17:02'),
(2014, 202, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2015, 202, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2016, 202, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2017, 202, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2018, 202, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2019, 202, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2020, 202, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2021, 202, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2022, 202, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2023, 202, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2024, 202, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2025, 202, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2026, 202, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2027, 202, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:45'),
(2028, 202, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2029, 202, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2030, 202, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:45'),
(2031, 202, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2032, 202, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2033, 202, 'ADMMNG', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:45'),
(2034, 202, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2035, 202, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2036, 202, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2037, 202, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2039, 202, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2040, 202, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2041, 202, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2042, 202, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2043, 202, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:03'),
(2044, 202, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:45'),
(2045, 202, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-11 06:24:03', 'root', '2013-11-11 14:24:45'),
(2053, 203, '10', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2054, 203, '21', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2055, 203, '26', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2056, 203, '29', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2057, 203, '3', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2059, 203, '35', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2061, 203, '39', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2062, 203, '42', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2063, 203, '43', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2064, 203, '44', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2065, 203, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2066, 203, '50', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2067, 203, '51', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2068, 203, '8', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2069, 203, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2070, 203, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2071, 203, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2072, 203, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2073, 203, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2074, 203, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2075, 203, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2076, 203, 'HR', 1, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2014-01-14 09:17:02'),
(2077, 203, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2078, 203, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2079, 203, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2080, 203, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2081, 203, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2082, 203, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2083, 203, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2084, 203, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2085, 203, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2086, 203, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2087, 203, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2088, 203, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2089, 203, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2090, 203, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:45:29'),
(2091, 203, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2092, 203, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2093, 203, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:45:30'),
(2094, 203, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2095, 203, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2096, 203, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:45:30'),
(2097, 203, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2098, 203, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2099, 203, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2100, 203, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2102, 203, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:45:30'),
(2103, 203, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2104, 203, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2105, 203, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2106, 203, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2107, 203, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:45:30'),
(2108, 203, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-13 08:44:53', 'root', '2013-11-13 12:44:53'),
(2110, 204, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2111, 204, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2112, 204, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2113, 204, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2114, 204, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2116, 204, '35', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2019-05-20 17:15:15'),
(2118, 204, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2119, 204, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2120, 204, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2121, 204, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2122, 204, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2123, 204, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2124, 204, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2125, 204, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2126, 204, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2127, 204, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2128, 204, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2129, 204, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2130, 204, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2131, 204, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2132, 204, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2133, 204, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2014-01-14 09:17:02'),
(2134, 204, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2135, 204, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2136, 204, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2137, 204, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2138, 204, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2139, 204, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2140, 204, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2141, 204, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2142, 204, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2143, 204, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2144, 204, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:17', 'root', '2013-11-20 15:54:43'),
(2145, 204, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2146, 204, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2147, 204, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:33'),
(2148, 204, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2149, 204, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2150, 204, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:33'),
(2151, 204, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2152, 204, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2153, 204, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:17', 'root', '2013-11-20 15:54:43'),
(2154, 204, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2155, 204, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2156, 204, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2157, 204, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2159, 204, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:33'),
(2160, 204, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2161, 204, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2162, 204, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2163, 204, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-14 21:46:17'),
(2164, 204, 'ACCMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:17', 'root', '2013-11-20 15:54:43'),
(2165, 204, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:46:17', 'root', '2013-11-20 15:54:43'),
(2167, 205, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2168, 205, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2169, 205, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2170, 205, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2171, 205, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2173, 205, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2175, 205, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2176, 205, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2177, 205, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2178, 205, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2179, 205, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2180, 205, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2181, 205, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2182, 205, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2183, 205, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2184, 205, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2185, 205, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2186, 205, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2187, 205, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2188, 205, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2189, 205, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2190, 205, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2014-01-14 09:17:02'),
(2191, 205, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2192, 205, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2193, 205, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2194, 205, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2195, 205, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2196, 205, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2197, 205, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2198, 205, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2199, 205, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2200, 205, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2201, 205, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2202, 205, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2203, 205, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2204, 205, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2205, 205, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2206, 205, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2207, 205, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2208, 205, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2209, 205, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2210, 205, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2211, 205, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2212, 205, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2213, 205, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2214, 205, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2216, 205, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:48:11'),
(2217, 205, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2218, 205, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2219, 205, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2220, 205, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2221, 205, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2222, 205, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:46:59', 'root', '2013-11-14 21:46:59'),
(2224, 206, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2225, 206, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2226, 206, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2227, 206, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2228, 206, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2230, 206, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2232, 206, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2233, 206, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2234, 206, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2235, 206, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2236, 206, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2237, 206, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2238, 206, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2239, 206, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2240, 206, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2241, 206, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2242, 206, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2243, 206, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2244, 206, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2245, 206, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2246, 206, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2247, 206, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2014-01-14 09:17:02'),
(2248, 206, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2249, 206, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2250, 206, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2251, 206, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2252, 206, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:50:04'),
(2253, 206, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2254, 206, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2255, 206, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2019-05-20 17:16:29'),
(2256, 206, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2257, 206, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2258, 206, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:49:36', 'root', '2013-11-20 15:55:18'),
(2259, 206, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2260, 206, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2261, 206, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:50:04'),
(2262, 206, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2263, 206, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2264, 206, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:50:04'),
(2265, 206, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2266, 206, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2267, 206, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:50:04'),
(2268, 206, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2269, 206, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2270, 206, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2271, 206, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2273, 206, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2274, 206, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2275, 206, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2276, 206, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2277, 206, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2278, 206, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2279, 206, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:49:36', 'root', '2013-11-14 21:49:36'),
(2281, 207, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2282, 207, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2283, 207, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2284, 207, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2285, 207, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2287, 207, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2289, 207, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2290, 207, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2291, 207, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2292, 207, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2293, 207, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2294, 207, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2295, 207, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2296, 207, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2297, 207, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2298, 207, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2299, 207, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2300, 207, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2301, 207, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2302, 207, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2303, 207, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2304, 207, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2014-01-14 09:17:02'),
(2305, 207, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2306, 207, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2307, 207, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2308, 207, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2309, 207, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:51:30'),
(2310, 207, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2311, 207, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2312, 207, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2313, 207, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2314, 207, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2315, 207, 'ITMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:51:30'),
(2316, 207, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2317, 207, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2318, 207, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:51:30'),
(2319, 207, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2320, 207, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2321, 207, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:51:30'),
(2322, 207, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2323, 207, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2324, 207, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:51:30'),
(2325, 207, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2326, 207, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2327, 207, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2328, 207, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2330, 207, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:51:30'),
(2331, 207, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2332, 207, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2333, 207, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2334, 207, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2335, 207, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2336, 207, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:50:50', 'root', '2013-11-14 21:50:50'),
(2338, 208, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2339, 208, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2340, 208, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2341, 208, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2342, 208, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2344, 208, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2346, 208, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2347, 208, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2348, 208, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2349, 208, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2350, 208, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2351, 208, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2352, 208, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2353, 208, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2354, 208, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2355, 208, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2356, 208, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2357, 208, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2358, 208, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2359, 208, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2360, 208, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2361, 208, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2014-01-14 09:17:02'),
(2362, 208, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2363, 208, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2364, 208, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2365, 208, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2366, 208, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:33'),
(2367, 208, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2368, 208, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2369, 208, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2370, 208, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2371, 208, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2372, 208, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2373, 208, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2374, 208, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2375, 208, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:33'),
(2376, 208, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2377, 208, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2378, 208, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:33'),
(2379, 208, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2380, 208, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2381, 208, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:55:00', 'root', '2013-11-20 17:15:34'),
(2382, 208, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2383, 208, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2384, 208, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2385, 208, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2387, 208, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:33'),
(2388, 208, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2389, 208, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2390, 208, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2391, 208, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2392, 208, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2393, 208, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:55:00', 'root', '2013-11-14 21:55:00'),
(2395, 209, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2396, 209, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2397, 209, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2398, 209, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2399, 209, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2401, 209, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2403, 209, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2404, 209, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2405, 209, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2406, 209, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2407, 209, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2408, 209, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2409, 209, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2410, 209, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2411, 209, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2412, 209, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2413, 209, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2414, 209, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2415, 209, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2416, 209, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2417, 209, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2418, 209, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2014-01-14 09:17:02'),
(2419, 209, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2420, 209, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2421, 209, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2422, 209, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2423, 209, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2424, 209, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2425, 209, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2426, 209, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2427, 209, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2428, 209, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2429, 209, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2430, 209, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2431, 209, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2432, 209, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:59:08'),
(2433, 209, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2434, 209, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2435, 209, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:59:08'),
(2436, 209, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2437, 209, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2438, 209, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:59:08'),
(2439, 209, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2440, 209, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2441, 209, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2442, 209, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2444, 209, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:59:08'),
(2445, 209, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2446, 209, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2447, 209, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2448, 209, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2449, 209, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2450, 209, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 17:58:47', 'root', '2013-11-14 21:58:47'),
(2509, 211, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2510, 211, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2511, 211, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2512, 211, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2513, 211, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2515, 211, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2517, 211, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2518, 211, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2519, 211, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2520, 211, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2521, 211, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2522, 211, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2523, 211, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2524, 211, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2525, 211, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2526, 211, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2527, 211, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2528, 211, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2529, 211, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2530, 211, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2531, 211, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2532, 211, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2014-01-14 09:17:02'),
(2533, 211, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2534, 211, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2535, 211, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2536, 211, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2537, 211, 'MANAGEMENT', 1, 1, 1, 1, 1, 'root', '2013-11-14 18:00:46', 'root', '2013-11-20 15:55:38'),
(2538, 211, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2539, 211, 'TRUMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 18:00:46', 'root', '2013-11-19 11:52:51'),
(2540, 211, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2541, 211, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2542, 211, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2543, 211, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2544, 211, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2545, 211, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2546, 211, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-19 11:52:51'),
(2547, 211, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2548, 211, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2549, 211, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-14 18:00:46', 'root', '2013-11-19 11:52:51'),
(2550, 211, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2551, 211, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2552, 211, 'ADMMNG', 1, 1, 1, 1, 1, 'root', '2013-11-14 18:00:46', 'root', '2013-11-19 11:52:51'),
(2553, 211, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2554, 211, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2555, 211, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2556, 211, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2558, 211, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-19 11:52:51'),
(2559, 211, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2560, 211, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2561, 211, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(2562, 211, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2563, 211, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2564, 211, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:00:46', 'root', '2013-11-14 22:00:46'),
(2566, 212, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2567, 212, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2568, 212, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2569, 212, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2570, 212, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2572, 212, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2574, 212, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2575, 212, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2576, 212, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2577, 212, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2578, 212, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2579, 212, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2580, 212, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2581, 212, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2582, 212, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2583, 212, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2584, 212, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2585, 212, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2586, 212, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2587, 212, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2588, 212, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2589, 212, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2014-01-14 09:17:02'),
(2590, 212, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2591, 212, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2592, 212, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2593, 212, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2594, 212, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2595, 212, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2596, 212, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2597, 212, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2598, 212, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2599, 212, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2600, 212, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2601, 212, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2602, 212, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2603, 212, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:36'),
(2604, 212, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2605, 212, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2606, 212, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', '', '2018-11-23 10:05:40'),
(2607, 212, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2608, 212, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2609, 212, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2610, 212, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2611, 212, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2612, 212, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2613, 212, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2615, 212, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:36'),
(2616, 212, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2617, 212, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2618, 212, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2619, 212, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2620, 212, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2621, 212, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:28', 'root', '2013-11-14 22:01:28'),
(2623, 213, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2624, 213, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2625, 213, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2626, 213, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2627, 213, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2629, 213, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2631, 213, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2632, 213, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2633, 213, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2634, 213, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2635, 213, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2636, 213, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2637, 213, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2638, 213, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2639, 213, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2640, 213, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2641, 213, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2642, 213, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2643, 213, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2644, 213, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2645, 213, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2646, 213, 'HR', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2014-01-14 09:17:02'),
(2647, 213, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2648, 213, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2649, 213, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2650, 213, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2651, 213, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2652, 213, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2653, 213, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2654, 213, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2655, 213, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2656, 213, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2657, 213, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2658, 213, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2659, 213, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2660, 213, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:02:08'),
(2661, 213, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2662, 213, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2663, 213, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', '', '2018-11-23 10:05:40'),
(2664, 213, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2665, 213, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2666, 213, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2667, 213, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2668, 213, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2669, 213, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2670, 213, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2672, 213, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:02:08'),
(2673, 213, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2674, 213, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2675, 213, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2676, 213, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2677, 213, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2678, 213, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:01:59', 'root', '2013-11-14 22:01:59'),
(2680, 214, '10', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2681, 214, '21', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2682, 214, '26', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2683, 214, '29', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2684, 214, '3', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2686, 214, '35', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2688, 214, '39', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2689, 214, '42', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2690, 214, '43', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2691, 214, '44', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2692, 214, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2693, 214, '50', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2694, 214, '51', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2695, 214, '8', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2696, 214, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2697, 214, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2698, 214, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2699, 214, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2700, 214, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2701, 214, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2702, 214, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2703, 214, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2014-01-14 09:17:02'),
(2704, 214, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2705, 214, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2706, 214, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2707, 214, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2708, 214, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2709, 214, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2710, 214, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2711, 214, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2712, 214, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2713, 214, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2714, 214, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2715, 214, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2716, 214, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2717, 214, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:39'),
(2718, 214, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2719, 214, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2720, 214, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', '', '2018-11-23 10:05:40'),
(2721, 214, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2722, 214, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2723, 214, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2724, 214, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2725, 214, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2726, 214, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2727, 214, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2729, 214, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:39'),
(2730, 214, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2731, 214, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2732, 214, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2733, 214, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2734, 214, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2735, 214, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-14 18:02:33', 'root', '2013-11-14 22:02:33'),
(2737, 215, '10', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2738, 215, '21', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2739, 215, '26', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2740, 215, '29', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2741, 215, '3', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2743, 215, '35', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2745, 215, '39', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2746, 215, '42', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2747, 215, '43', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2748, 215, '44', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2749, 215, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2750, 215, '50', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2751, 215, '51', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2752, 215, '8', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2753, 215, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2754, 215, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2755, 215, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2756, 215, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2757, 215, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2758, 215, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2759, 215, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2760, 215, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2014-01-14 09:17:02'),
(2761, 215, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2762, 215, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2763, 215, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2764, 215, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2765, 215, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2766, 215, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2767, 215, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2768, 215, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', '', '2018-10-25 12:16:59'),
(2769, 215, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2770, 215, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2771, 215, 'ITMNG', 1, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:42'),
(2772, 215, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2773, 215, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2774, 215, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:42'),
(2775, 215, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2776, 215, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2777, 215, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:42'),
(2778, 215, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2779, 215, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2780, 215, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2781, 215, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2782, 215, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2783, 215, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2784, 215, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2786, 215, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2787, 215, 'FINANCE', 1, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', '', '2018-10-25 12:16:59'),
(2788, 215, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2789, 215, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2790, 215, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:21'),
(2791, 215, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:42'),
(2792, 215, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-20 08:53:21', 'root', '2013-11-20 12:53:42'),
(2794, 216, '10', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2795, 216, '21', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2796, 216, '26', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2797, 216, '29', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2798, 216, '3', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2800, 216, '35', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2802, 216, '39', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2803, 216, '42', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2804, 216, '43', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2805, 216, '44', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2806, 216, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2807, 216, '50', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2808, 216, '51', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2809, 216, '8', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2810, 216, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2811, 216, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2812, 216, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2813, 216, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2814, 216, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2815, 216, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2816, 216, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2817, 216, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2014-01-14 09:17:02'),
(2818, 216, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2819, 216, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2820, 216, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2821, 216, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2822, 216, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2823, 216, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2824, 216, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2825, 216, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', '', '2018-10-25 12:17:26'),
(2826, 216, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2827, 216, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2828, 216, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2829, 216, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2830, 216, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2831, 216, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:30'),
(2832, 216, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2833, 216, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2834, 216, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:30'),
(2835, 216, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2836, 216, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2837, 216, 'ADMMNG', 1, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', '', '2018-10-29 16:14:16'),
(2838, 216, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2839, 216, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2840, 216, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2841, 216, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2843, 216, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2844, 216, 'FINANCE', 1, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', '', '2018-10-25 12:17:26'),
(2845, 216, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2846, 216, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2847, 216, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:20'),
(2848, 216, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:30'),
(2849, 216, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-20 12:56:20', 'root', '2013-11-20 16:56:30'),
(2851, 1, '10', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2852, 2, '10', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2853, 170, '10', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2854, 171, '10', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2855, 1, '21', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2856, 2, '21', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2857, 1, '26', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2858, 2, '26', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2859, 1, '29', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2860, 2, '29', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2861, 1, '3', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2862, 2, '3', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2865, 1, '35', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2866, 2, '35', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2869, 1, '39', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2870, 2, '39', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2871, 1, '42', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2872, 2, '42', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2873, 1, '43', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2874, 2, '43', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2875, 1, '44', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2876, 2, '44', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2877, 1, 'VYPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2878, 2, 'VYPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2879, 1, '50', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2880, 2, '50', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2881, 1, '51', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2882, 2, '51', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2883, 1, '8', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2884, 2, '8', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2885, 1, '9000', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2886, 2, '9000', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2887, 1, '9001', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2888, 2, '9001', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2889, 1, '9002', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2890, 2, '9002', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2891, 1, '9100', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2892, 2, '9100', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2893, 1, '9101', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2894, 2, '9101', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2895, 1, 'ACCMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2896, 2, 'ACCMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2897, 1, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2898, 2, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2899, 1, 'ADMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2900, 2, 'ADMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2901, 1, 'AFFMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2902, 2, 'AFFMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2903, 1, 'AFFOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2904, 2, 'AFFOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2905, 1, 'ALLUSERS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2906, 1, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2907, 2, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2908, 170, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2909, 171, 'DIRSALMNG', 1, 1, 1, 1, 1, NULL, '2013-11-21 12:26:39', 'root', '2013-11-21 16:26:53'),
(2910, 172, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2911, 173, 'DIRSALMNG', 0, 1, 0, 0, 0, NULL, '2013-11-21 12:26:39', 'root', '2013-11-21 16:27:08'),
(2912, 174, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2913, 175, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2914, 176, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2915, 177, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2916, 178, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2917, 179, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2918, 180, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2919, 181, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2920, 182, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2921, 183, 'DIRSALMNG', 1, 0, 0, 0, 0, NULL, '2013-11-21 12:26:39', 'root', '2013-11-21 16:28:06'),
(2922, 184, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2923, 185, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2924, 186, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2925, 187, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2926, 188, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2927, 189, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2928, 190, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2929, 191, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2930, 192, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2931, 193, 'DIRSALMNG', 1, 1, 1, 1, 1, NULL, '2013-11-21 12:26:39', 'root', '2013-11-21 16:27:27'),
(2933, 195, 'DIRSALMNG', 1, 1, 1, 1, 1, NULL, '2013-11-21 12:26:39', 'root', '2013-11-21 16:27:43'),
(2934, 196, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2935, 198, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2936, 199, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2937, 200, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2938, 201, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2939, 202, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2940, 203, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2941, 204, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2942, 205, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2943, 206, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2944, 207, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2945, 208, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2946, 209, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2947, 211, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2948, 212, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2949, 213, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2950, 214, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2951, 215, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2952, 216, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2953, 1, 'DOMADM', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2954, 2, 'DOMADM', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2955, 1, 'FINANCE', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2956, 2, 'FINANCE', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2957, 1, 'FINDATA', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2958, 2, 'FINDATA', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2959, 1, 'FM', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2960, 2, 'FM', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2961, 1, 'FWDMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2962, 2, 'FWDMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2963, 1, 'HANDS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2964, 2, 'HANDS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2965, 1, 'HCMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2966, 2, 'HCMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2967, 1, 'HR', 0, NULL, NULL, NULL, 0, NULL, '2013-11-21 12:26:39', 'root', '2014-01-14 09:17:01'),
(2968, 2, 'HR', 0, NULL, NULL, NULL, 0, NULL, '2013-11-21 12:26:39', 'root', '2014-01-14 09:17:01'),
(2969, 1, 'ITMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2970, 2, 'ITMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2971, 1, 'ITSUPPORT', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2972, 2, 'ITSUPPORT', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2973, 1, 'KRKOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2974, 2, 'KRKOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2975, 1, 'MANAGEMENT', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2976, 2, 'MANAGEMENT', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2977, 1, 'MD', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2978, 2, 'MD', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2979, 1, 'MOWFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2980, 2, 'MOWFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2981, 1, 'MOWOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2982, 2, 'MOWOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2983, 1, 'NMGRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2984, 2, 'NMGRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2985, 1, 'NMGRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2986, 2, 'NMGRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2987, 1, 'NMGROPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2988, 2, 'NMGROPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2989, 1, 'SALES', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2990, 2, 'SALES', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2991, 1, 'SALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2992, 2, 'SALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2993, 1, 'STPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2994, 2, 'STPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2995, 1, 'STPOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2996, 2, 'STPOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(2999, 1, 'TMMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3000, 2, 'TMMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3001, 1, 'TRUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3002, 2, 'TRUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3003, 1, 'TRUOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3004, 2, 'TRUOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3005, 1, 'WHMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3006, 2, 'WHMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3007, 1, 'WHPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3008, 2, 'WHPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3009, 1, 'WHSMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3010, 2, 'WHSMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 12:26:39', NULL, NULL),
(3012, 217, '10', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3013, 217, '21', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3014, 217, '26', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3015, 217, '29', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3016, 217, '3', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3018, 217, '35', 1, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:49'),
(3020, 217, '39', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3021, 217, '42', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3022, 217, '43', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3023, 217, '44', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3024, 217, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3025, 217, '50', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3026, 217, '51', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3027, 217, '8', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3028, 217, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3029, 217, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3030, 217, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3031, 217, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3032, 217, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3033, 217, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3034, 217, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3035, 217, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2014-01-14 09:17:02'),
(3036, 217, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3037, 217, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3038, 217, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3039, 217, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3040, 217, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3041, 217, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3042, 217, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3043, 217, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3044, 217, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3045, 217, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3046, 217, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3047, 217, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3048, 217, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3049, 217, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:49'),
(3050, 217, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3051, 217, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3052, 217, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:49'),
(3053, 217, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3054, 217, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3055, 217, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3056, 217, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3057, 217, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3058, 217, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3059, 217, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3061, 217, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:49'),
(3062, 217, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3063, 217, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3064, 217, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3065, 217, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3066, 217, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:20'),
(3067, 217, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:49'),
(3068, 217, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-22 09:12:20', 'root', '2013-11-22 13:12:49'),
(3069, 218, '10', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3070, 218, '21', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3071, 218, '26', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3072, 218, '29', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3073, 218, '3', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3075, 218, '35', 1, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:57'),
(3077, 218, '39', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3078, 218, '42', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3079, 218, '43', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3080, 218, '44', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3081, 218, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3082, 218, '50', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3083, 218, '51', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3084, 218, '8', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3085, 218, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3086, 218, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3087, 218, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3088, 218, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3089, 218, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3090, 218, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3091, 218, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3092, 218, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2014-01-14 09:17:02'),
(3093, 218, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3094, 218, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3095, 218, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3096, 218, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3097, 218, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', '', '2018-11-23 10:04:35'),
(3098, 218, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3099, 218, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3100, 218, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3101, 218, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3102, 218, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3103, 218, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3104, 218, 'SALMNG', 1, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-12-05 17:04:03'),
(3105, 218, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3106, 218, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:57'),
(3107, 218, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3108, 218, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3109, 218, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:57'),
(3110, 218, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3111, 218, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3112, 218, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3113, 218, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3114, 218, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3115, 218, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3116, 218, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3118, 218, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3119, 218, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3120, 218, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(3121, 218, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3122, 218, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3123, 218, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3124, 218, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:41'),
(3125, 218, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-22 13:36:41', 'root', '2013-11-22 17:36:57'),
(3126, 219, '10', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3127, 219, '21', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3128, 219, '26', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3129, 219, '29', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3130, 219, '3', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3132, 219, '35', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3134, 219, '39', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3135, 219, '42', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3136, 219, '43', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3137, 219, '44', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3138, 219, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3139, 219, '50', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3140, 219, '51', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3141, 219, '8', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3142, 219, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3143, 219, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3144, 219, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3145, 219, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3146, 219, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3147, 219, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3148, 219, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3149, 219, 'HR', 1, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2014-01-14 09:17:02'),
(3150, 219, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3151, 219, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3152, 219, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3153, 219, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3154, 219, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3155, 219, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3156, 219, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3157, 219, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3158, 219, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3159, 219, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3160, 219, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3161, 219, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3162, 219, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3163, 219, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:25:05'),
(3164, 219, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3165, 219, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3166, 219, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:25:05'),
(3167, 219, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3168, 219, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3169, 219, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3170, 219, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3171, 219, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3172, 219, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3173, 219, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3175, 219, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3176, 219, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3177, 219, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3178, 219, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3179, 219, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3180, 219, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3181, 219, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:24:26'),
(3182, 219, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-24 19:24:26', 'root', '2013-11-24 23:25:05'),
(3183, 220, '10', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3184, 220, '21', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3185, 220, '26', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3186, 220, '29', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3187, 220, '3', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3189, 220, '35', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3191, 220, '39', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3192, 220, '42', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3193, 220, '43', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3194, 220, '44', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3195, 220, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3196, 220, '50', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3197, 220, '51', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3198, 220, '8', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3199, 220, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3200, 220, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3201, 220, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3202, 220, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3203, 220, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3204, 220, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3205, 220, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3206, 220, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2014-01-14 09:17:02'),
(3207, 220, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3208, 220, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3209, 220, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3210, 220, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3211, 220, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3212, 220, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3213, 220, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3214, 220, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3215, 220, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3216, 220, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3217, 220, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3218, 220, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3219, 220, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3220, 220, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:52'),
(3221, 220, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3222, 220, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3223, 220, 'FM', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3224, 220, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3225, 220, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3226, 220, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3227, 220, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3228, 220, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3229, 220, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3230, 220, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3232, 220, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:52'),
(3233, 220, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3234, 220, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3235, 220, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3236, 220, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3237, 220, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3238, 220, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3239, 220, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-25 12:55:45', 'root', '2013-11-25 16:55:45'),
(3240, 221, '10', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3241, 221, '21', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3242, 221, '26', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3243, 221, '29', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3244, 221, '3', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3246, 221, '35', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3248, 221, '39', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3249, 221, '42', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3250, 221, '43', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3251, 221, '44', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3252, 221, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3253, 221, '50', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3254, 221, '51', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3255, 221, '8', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3256, 221, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3257, 221, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3258, 221, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3259, 221, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3260, 221, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3261, 221, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3262, 221, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3263, 221, 'HR', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2014-01-14 09:17:02'),
(3264, 221, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3265, 221, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3266, 221, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3267, 221, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3268, 221, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3269, 221, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3270, 221, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3271, 221, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3272, 221, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3273, 221, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3274, 221, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3275, 221, 'SALMNG', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2014-11-10 14:58:09'),
(3276, 221, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3277, 221, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:54'),
(3278, 221, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3279, 221, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3280, 221, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:54'),
(3281, 221, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3282, 221, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3283, 221, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3284, 221, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3285, 221, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3286, 221, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3287, 221, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3289, 221, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3290, 221, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3291, 221, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3292, 221, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3293, 221, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3294, 221, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3295, 221, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:34'),
(3296, 221, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:06:34', 'root', '2013-11-25 23:06:54'),
(3297, 222, '10', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3298, 222, '21', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3299, 222, '26', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3300, 222, '29', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3301, 222, '3', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3303, 222, '35', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:57'),
(3305, 222, '39', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3306, 222, '42', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3307, 222, '43', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3308, 222, '44', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3309, 222, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3310, 222, '50', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3311, 222, '51', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3312, 222, '8', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3313, 222, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3314, 222, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3315, 222, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3316, 222, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3317, 222, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3318, 222, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3319, 222, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3320, 222, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2014-01-14 09:17:02'),
(3321, 222, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3322, 222, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3323, 222, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3324, 222, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3325, 222, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:57'),
(3326, 222, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3327, 222, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3328, 222, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3329, 222, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3330, 222, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3331, 222, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3332, 222, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3333, 222, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3334, 222, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:57'),
(3335, 222, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3336, 222, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3337, 222, 'FM', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:57'),
(3338, 222, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3339, 222, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3340, 222, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3341, 222, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3342, 222, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3343, 222, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3344, 222, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3346, 222, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3347, 222, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3348, 222, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3349, 222, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3350, 222, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3351, 222, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3352, 222, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:26'),
(3353, 222, 'MD', 1, 0, 0, 0, 0, 'root', '2013-11-25 19:25:26', 'root', '2013-11-25 23:25:57'),
(3354, 223, '10', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3355, 223, '21', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3356, 223, '26', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3357, 223, '29', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3358, 223, '3', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3360, 223, '35', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3362, 223, '39', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3363, 223, '42', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3364, 223, '43', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3365, 223, '44', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3366, 223, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3367, 223, '50', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3368, 223, '51', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3369, 223, '8', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3370, 223, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3371, 223, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3372, 223, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3373, 223, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3374, 223, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3375, 223, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3376, 223, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3377, 223, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2014-01-14 09:17:02'),
(3378, 223, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3379, 223, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3380, 223, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3381, 223, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3382, 223, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3383, 223, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3384, 223, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3385, 223, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3386, 223, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3387, 223, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3388, 223, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3389, 223, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3390, 223, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3391, 223, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:29'),
(3392, 223, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3393, 223, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3394, 223, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:30'),
(3395, 223, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3396, 223, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3397, 223, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3398, 223, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3399, 223, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3400, 223, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3401, 223, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3403, 223, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:30'),
(3404, 223, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3405, 223, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3406, 223, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3407, 223, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3408, 223, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3409, 223, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3410, 223, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:15', 'root', '2013-11-26 16:44:15'),
(3411, 224, '10', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3412, 224, '21', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3413, 224, '26', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3414, 224, '29', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3415, 224, '3', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3417, 224, '35', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3419, 224, '39', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3420, 224, '42', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3421, 224, '43', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3422, 224, '44', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3423, 224, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3424, 224, '50', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3425, 224, '51', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3426, 224, '8', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3427, 224, '9000', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3428, 224, '9001', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3429, 224, '9002', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3430, 224, '9100', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3431, 224, '9101', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3432, 224, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3433, 224, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3434, 224, 'HR', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2014-01-14 09:17:02'),
(3435, 224, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3436, 224, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3437, 224, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3438, 224, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3439, 224, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3440, 224, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3441, 224, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3442, 224, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3443, 224, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3444, 224, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3445, 224, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3446, 224, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3447, 224, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3448, 224, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:45:09'),
(3449, 224, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3450, 224, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3451, 224, 'FM', 1, 1, 1, 1, 1, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:45:09'),
(3452, 224, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3453, 224, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3454, 224, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3455, 224, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3456, 224, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3457, 224, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3458, 224, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3460, 224, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:45:09'),
(3461, 224, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3462, 224, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3463, 224, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3464, 224, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3465, 224, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3466, 224, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3467, 224, 'MD', 0, 0, 0, 0, 0, 'root', '2013-11-26 12:44:59', 'root', '2013-11-26 16:44:59'),
(3468, 225, '10', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3469, 225, '21', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3470, 225, '26', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3471, 225, '29', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3472, 225, '3', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3474, 225, '35', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3476, 225, '39', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3477, 225, '42', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3478, 225, '43', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3479, 225, '44', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3480, 225, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3481, 225, '50', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3482, 225, '51', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3483, 225, '8', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3484, 225, '9000', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3485, 225, '9001', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3486, 225, '9002', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3487, 225, '9100', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3488, 225, '9101', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3489, 225, 'HANDS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3490, 225, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3491, 225, 'HR', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2014-01-14 09:17:02'),
(3492, 225, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3493, 225, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3494, 225, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3495, 225, 'SALES', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3496, 225, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3497, 225, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3498, 225, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3499, 225, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3500, 225, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3501, 225, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3502, 225, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3503, 225, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3504, 225, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3505, 225, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:31'),
(3506, 225, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3507, 225, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3508, 225, 'FM', 1, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:31'),
(3509, 225, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3510, 225, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3511, 225, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3512, 225, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3513, 225, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3514, 225, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3515, 225, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3517, 225, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3518, 225, 'FINANCE', 1, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2015-01-27 12:15:30'),
(3519, 225, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3520, 225, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3521, 225, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3522, 225, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3523, 225, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3524, 225, 'MD', 0, 0, 0, 0, 0, 'root', '2013-12-03 06:32:19', 'root', '2013-12-03 10:32:19'),
(3525, 226, '10', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3526, 226, '21', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3527, 226, '26', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3528, 226, '29', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3529, 226, '3', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3531, 226, '35', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3533, 226, '39', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3534, 226, '42', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3535, 226, '43', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3536, 226, '44', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3537, 226, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3538, 226, '50', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3539, 226, '51', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3540, 226, '8', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3541, 226, '9000', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3542, 226, '9001', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3543, 226, '9002', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3544, 226, '9100', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3545, 226, '9101', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3546, 226, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3547, 226, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3548, 226, 'HR', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3549, 226, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3550, 226, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3551, 226, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3552, 226, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3553, 226, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3554, 226, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3555, 226, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3556, 226, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3557, 226, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3558, 226, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3559, 226, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3560, 226, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3561, 226, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3562, 226, 'ADMIN', 1, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3563, 226, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3564, 226, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3565, 226, 'FM', 1, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', '', '2018-11-23 10:05:40'),
(3566, 226, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3567, 226, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3568, 226, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3569, 226, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3570, 226, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3571, 226, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3572, 226, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3574, 226, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:24:02'),
(3575, 226, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3576, 226, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3577, 226, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3578, 226, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3579, 226, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3580, 226, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3581, 226, 'MD', 0, 0, 0, 0, 0, 'root', '2014-01-31 11:23:58', 'root', '2014-01-31 15:23:58'),
(3582, 227, '10', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3583, 227, '21', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3584, 227, '26', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3585, 227, '29', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3586, 227, '3', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3588, 227, '35', 1, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2019-05-20 17:15:15'),
(3590, 227, '39', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3591, 227, '42', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3592, 227, '43', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3593, 227, '44', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3594, 227, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3595, 227, '50', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3596, 227, '51', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3597, 227, '8', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3598, 227, '9000', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3599, 227, '9001', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3600, 227, '9002', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3601, 227, '9100', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3602, 227, '9101', 1, 1, 1, 1, 1, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:48'),
(3603, 227, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3604, 227, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3605, 227, 'HR', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3606, 227, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3607, 227, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3608, 227, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3609, 227, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3610, 227, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3611, 227, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3612, 227, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3613, 227, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3614, 227, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3615, 227, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3616, 227, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3617, 227, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3618, 227, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3619, 227, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:48'),
(3620, 227, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3621, 227, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3622, 227, 'FM', 1, 1, 1, 1, 1, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:48'),
(3623, 227, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3624, 227, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3625, 227, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3626, 227, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3627, 227, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3628, 227, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3629, 227, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3631, 227, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:48'),
(3632, 227, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3633, 227, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3634, 227, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3635, 227, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3636, 227, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3637, 227, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3638, 227, 'MD', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:55:20', 'root', '2014-02-13 12:55:20'),
(3639, 228, '10', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3640, 228, '21', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3641, 228, '26', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3642, 228, '29', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3643, 228, '3', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3645, 228, '35', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3647, 228, '39', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3648, 228, '42', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3649, 228, '43', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3650, 228, '44', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3651, 228, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3652, 228, '50', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3653, 228, '51', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3654, 228, '8', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3655, 228, '9000', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3656, 228, '9001', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3657, 228, '9002', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3658, 228, '9100', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3659, 228, '9101', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3660, 228, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3661, 228, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3662, 228, 'HR', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3663, 228, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(3664, 228, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3665, 228, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3666, 228, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3667, 228, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3668, 228, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3669, 228, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3670, 228, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3671, 228, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3672, 228, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3673, 228, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3674, 228, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3675, 228, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3676, 228, 'ADMIN', 1, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3677, 228, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3678, 228, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3679, 228, 'FM', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3680, 228, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3681, 228, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3682, 228, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3683, 228, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3684, 228, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3685, 228, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3686, 228, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3688, 228, 'ALLUSERS', 1, 1, 1, 1, 1, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:22'),
(3689, 228, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3690, 228, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3691, 228, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3692, 228, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3693, 228, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3694, 228, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3695, 228, 'MD', 0, 0, 0, 0, 0, 'root', '2014-02-13 08:56:15', 'root', '2014-02-13 12:56:15'),
(3696, 229, '10', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3697, 229, '21', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3698, 229, '26', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3699, 229, '29', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3700, 229, '3', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3702, 229, '35', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3704, 229, '39', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3705, 229, '42', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3706, 229, '43', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3707, 229, '44', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3708, 229, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3709, 229, '50', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3710, 229, '51', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3711, 229, '8', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3712, 229, '9000', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3713, 229, '9001', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3714, 229, '9002', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3715, 229, '9100', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3716, 229, '9101', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3717, 229, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3718, 229, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3719, 229, 'HR', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3720, 229, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3721, 229, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3722, 229, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3723, 229, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3724, 229, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3725, 229, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3726, 229, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3727, 229, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3728, 229, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3729, 229, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3730, 229, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3731, 229, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3732, 229, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3733, 229, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:21'),
(3734, 229, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3735, 229, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3736, 229, 'FM', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3737, 229, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3738, 229, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3739, 229, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3740, 229, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3741, 229, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3742, 229, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3743, 229, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3745, 229, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:21'),
(3746, 229, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3747, 229, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3748, 229, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3749, 229, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3750, 229, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3751, 229, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3752, 229, 'MD', 0, 0, 0, 0, 0, 'root', '2014-02-14 08:26:10', 'root', '2014-02-14 12:26:10'),
(3753, 230, '10', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3754, 230, '21', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3755, 230, '26', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3756, 230, '29', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3757, 230, '3', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3759, 230, '35', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3761, 230, '39', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3762, 230, '42', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3763, 230, '43', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3764, 230, '44', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3765, 230, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3766, 230, '50', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3767, 230, '51', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3768, 230, '8', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3769, 230, '9000', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3770, 230, '9001', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3771, 230, '9002', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3772, 230, '9100', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3773, 230, '9101', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3774, 230, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3775, 230, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3776, 230, 'HR', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3777, 230, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3778, 230, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3779, 230, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3780, 230, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3781, 230, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3782, 230, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3783, 230, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3784, 230, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', '', '2015-11-24 15:21:26'),
(3785, 230, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3786, 230, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3787, 230, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3788, 230, 'SALMNG', 1, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-27 12:15:41'),
(3789, 230, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3790, 230, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-27 12:15:41'),
(3791, 230, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3792, 230, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3793, 230, 'FM', 1, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-27 12:15:41'),
(3794, 230, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3795, 230, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3796, 230, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3797, 230, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3798, 230, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3799, 230, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3800, 230, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3802, 230, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3803, 230, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3804, 230, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3805, 230, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3806, 230, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3807, 230, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-24 17:21:11'),
(3808, 230, 'ACCMNG', 1, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-27 12:15:41'),
(3809, 230, 'MD', 1, 0, 0, 0, 0, 'root', '2014-10-24 13:21:11', 'root', '2014-10-27 12:15:41'),
(3810, 231, '10', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3811, 231, '21', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3812, 231, '26', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3813, 231, '29', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3814, 231, '3', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3816, 231, '35', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3818, 231, '39', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3819, 231, '42', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3820, 231, '43', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3821, 231, '44', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3822, 231, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3823, 231, '50', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3824, 231, '51', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3825, 231, '8', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3826, 231, '9000', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3827, 231, '9001', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3828, 231, '9002', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3829, 231, '9100', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3830, 231, '9101', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3831, 231, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3832, 231, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3833, 231, 'HR', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3834, 231, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3835, 231, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3836, 231, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3837, 231, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3838, 231, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3839, 231, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3840, 231, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3841, 231, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3842, 231, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3843, 231, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3844, 231, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3845, 231, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3846, 231, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3847, 231, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-27 12:14:54'),
(3848, 231, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3849, 231, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3850, 231, 'FM', 1, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-27 12:14:54'),
(3851, 231, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3852, 231, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3853, 231, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3854, 231, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3855, 231, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3856, 231, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3857, 231, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3859, 231, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3860, 231, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3861, 231, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3862, 231, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3863, 231, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3864, 231, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3865, 231, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3866, 231, 'MD', 0, 0, 0, 0, 0, 'root', '2014-10-24 13:22:35', 'root', '2014-10-24 17:22:35'),
(3867, 232, '10', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3868, 232, '21', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3869, 232, '26', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3870, 232, '29', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3871, 232, '3', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3873, 232, '35', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3875, 232, '39', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3876, 232, '42', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3877, 232, '43', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3878, 232, '44', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3879, 232, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3880, 232, '50', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3881, 232, '51', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3882, 232, '8', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3883, 232, '9000', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3884, 232, '9001', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3885, 232, '9002', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3886, 232, '9100', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3887, 232, '9101', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:19:14'),
(3888, 232, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3889, 232, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3890, 232, 'HR', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3891, 232, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3892, 232, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3893, 232, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3894, 232, 'SALES', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2015-04-15 16:17:55'),
(3895, 232, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2015-04-15 16:56:40'),
(3896, 232, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3897, 232, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3898, 232, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2019-06-04 13:27:42'),
(3899, 232, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3900, 232, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3901, 232, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3902, 232, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3903, 232, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3904, 232, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:19:14'),
(3905, 232, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3906, 232, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3907, 232, 'FM', 1, 1, 1, 1, 1, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:19:14'),
(3908, 232, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3909, 232, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3910, 232, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3911, 232, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3912, 232, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3913, 232, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3914, 232, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3916, 232, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3917, 232, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3918, 232, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3919, 232, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3920, 232, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3921, 232, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3922, 232, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:18:45'),
(3923, 232, 'MD', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:18:45', 'root', '2014-10-27 15:19:14'),
(3924, 233, '10', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3925, 233, '21', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3926, 233, '26', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3927, 233, '29', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3928, 233, '3', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3930, 233, '35', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2019-05-20 17:15:15'),
(3932, 233, '39', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3933, 233, '42', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3934, 233, '43', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3935, 233, '44', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3936, 233, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3937, 233, '50', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3938, 233, '51', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3939, 233, '8', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3940, 233, '9000', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3941, 233, '9001', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3942, 233, '9002', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3943, 233, '9100', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3944, 233, '9101', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3945, 233, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3946, 233, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3947, 233, 'HR', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3948, 233, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3949, 233, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3950, 233, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3951, 233, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3952, 233, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:37:11'),
(3953, 233, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3954, 233, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3955, 233, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3956, 233, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3957, 233, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3958, 233, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3959, 233, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3960, 233, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3961, 233, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:37:11'),
(3962, 233, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3963, 233, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3964, 233, 'FM', 1, 1, 1, 1, 1, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:37:11'),
(3965, 233, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3966, 233, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3967, 233, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3968, 233, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3969, 233, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3970, 233, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3971, 233, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3973, 233, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3974, 233, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3975, 233, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3976, 233, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3977, 233, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3978, 233, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3979, 233, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:19:41'),
(3980, 233, 'MD', 0, 0, 0, 0, 0, 'root', '2014-10-27 11:19:41', 'root', '2014-10-27 15:37:11'),
(3981, 234, '10', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3982, 234, '21', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3983, 234, '26', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3984, 234, '29', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3985, 234, '3', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3987, 234, '35', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3989, 234, '39', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3990, 234, '42', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3991, 234, '43', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3992, 234, '44', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3993, 234, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3994, 234, '50', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3995, 234, '51', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3996, 234, '8', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3997, 234, '9000', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3998, 234, '9001', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(3999, 234, '9002', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4000, 234, '9100', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4001, 234, '9101', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4002, 234, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4003, 234, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4004, 234, 'HR', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4005, 234, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4006, 234, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4007, 234, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4008, 234, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4009, 234, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:33'),
(4010, 234, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4011, 234, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4012, 234, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4013, 234, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4014, 234, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4015, 234, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4016, 234, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4017, 234, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4018, 234, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:33'),
(4019, 234, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4020, 234, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4021, 234, 'FM', 1, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:33'),
(4022, 234, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4023, 234, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4024, 234, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4025, 234, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4026, 234, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4027, 234, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4028, 234, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4030, 234, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4031, 234, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4032, 234, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4033, 234, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4034, 234, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4035, 234, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4036, 234, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4037, 234, 'MD', 0, 0, 0, 0, 0, 'root', '2014-10-29 08:50:16', 'root', '2014-10-29 12:50:16'),
(4038, 235, '10', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4039, 235, '21', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4040, 235, '26', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4041, 235, '29', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4042, 235, '3', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4044, 235, '35', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4046, 235, '39', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4047, 235, '42', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4048, 235, '43', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4049, 235, '44', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4050, 235, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4051, 235, '50', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4052, 235, '51', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4053, 235, '8', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4054, 235, '9000', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4055, 235, '9001', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4056, 235, '9002', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4057, 235, '9100', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4058, 235, '9101', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4059, 235, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4060, 235, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4061, 235, 'HR', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4062, 235, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4063, 235, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4064, 235, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4065, 235, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4066, 235, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:43'),
(4067, 235, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4068, 235, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4069, 235, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4070, 235, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4071, 235, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4072, 235, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4073, 235, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4074, 235, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4075, 235, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:43'),
(4076, 235, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4077, 235, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4078, 235, 'FM', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4079, 235, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4080, 235, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4081, 235, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4082, 235, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4083, 235, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4084, 235, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4085, 235, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4087, 235, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4088, 235, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4089, 235, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4090, 235, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4091, 235, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4092, 235, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4093, 235, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4094, 235, 'MD', 0, 0, 0, 0, 0, 'root', '2014-11-06 07:59:27', 'root', '2014-11-06 11:59:27'),
(4095, 236, '10', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4096, 236, '21', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4097, 236, '26', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4098, 236, '29', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4099, 236, '3', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4101, 236, '35', 1, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2015-03-11 13:11:20'),
(4103, 236, '39', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4104, 236, '42', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4105, 236, '43', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4106, 236, '44', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4107, 236, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4108, 236, '50', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4109, 236, '51', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4110, 236, '8', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4111, 236, '9000', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4112, 236, '9001', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4113, 236, '9002', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4114, 236, '9100', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4115, 236, '9101', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4116, 236, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4117, 236, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4118, 236, 'HR', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4119, 236, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4120, 236, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4121, 236, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4122, 236, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4123, 236, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:20'),
(4124, 236, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4125, 236, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4126, 236, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4127, 236, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4128, 236, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4129, 236, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4130, 236, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4131, 236, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4132, 236, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:20'),
(4133, 236, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4134, 236, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4135, 236, 'FM', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4136, 236, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4137, 236, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4138, 236, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4139, 236, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4140, 236, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4141, 236, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4142, 236, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4144, 236, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4145, 236, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2015-03-11 13:11:20'),
(4146, 236, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4147, 236, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4148, 236, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4149, 236, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4150, 236, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4151, 236, 'MD', 0, 0, 0, 0, 0, 'root', '2014-11-10 10:57:12', 'root', '2014-11-10 14:57:12'),
(4152, 237, '10', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4153, 237, '21', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4154, 237, '26', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4155, 237, '29', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4156, 237, '3', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4158, 237, '35', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4160, 237, '39', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4161, 237, '42', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4162, 237, '43', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4163, 237, '44', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4164, 237, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4165, 237, '50', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4166, 237, '51', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4167, 237, '8', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4168, 237, '9000', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4169, 237, '9001', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4170, 237, '9002', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4171, 237, '9100', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4172, 237, '9101', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4173, 237, 'HANDS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4174, 237, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4175, 237, 'HR', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4176, 237, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4177, 237, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4178, 237, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4179, 237, 'SALES', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4180, 237, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:30'),
(4181, 237, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4182, 237, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4183, 237, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4184, 237, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4185, 237, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4186, 237, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4187, 237, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4188, 237, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4189, 237, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:30'),
(4190, 237, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4191, 237, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4192, 237, 'FM', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4193, 237, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4194, 237, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4195, 237, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4196, 237, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4197, 237, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4198, 237, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4199, 237, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4201, 237, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4202, 237, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4203, 237, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4204, 237, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(4205, 237, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4206, 237, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4207, 237, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4208, 237, 'MD', 0, 0, 0, 0, 0, 'root', '2014-12-01 11:20:13', 'root', '2014-12-01 15:20:13'),
(4209, 238, '10', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4210, 238, '21', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4211, 238, '26', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4212, 238, '29', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4213, 238, '3', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4215, 238, '35', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4217, 238, '39', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4218, 238, '42', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4219, 238, '43', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4220, 238, '44', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4221, 238, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4222, 238, '50', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4223, 238, '51', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4224, 238, '8', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4225, 238, '9000', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4226, 238, '9001', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4227, 238, '9002', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4228, 238, '9100', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4229, 238, '9101', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4230, 238, 'HANDS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4231, 238, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4232, 238, 'HR', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4233, 238, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4234, 238, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4235, 238, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4236, 238, 'SALES', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4237, 238, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:27:10'),
(4238, 238, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4239, 238, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4240, 238, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:27:10'),
(4241, 238, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4242, 238, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4243, 238, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4244, 238, 'SALMNG', 1, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', '', '2016-02-10 09:05:45'),
(4245, 238, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4246, 238, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:27:10'),
(4247, 238, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4248, 238, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4249, 238, 'FM', 1, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', '', '2018-11-23 10:05:40'),
(4250, 238, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4251, 238, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4252, 238, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4253, 238, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4254, 238, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4255, 238, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4256, 238, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4258, 238, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4259, 238, 'FINANCE', 1, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:27:10'),
(4260, 238, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4261, 238, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4262, 238, 'DIRSALMNG', 1, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', '', '2016-02-10 09:50:50'),
(4263, 238, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4264, 238, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-03-18 16:26:51'),
(4265, 238, 'MD', 1, 0, 0, 0, 0, 'root', '2015-03-18 13:26:51', 'root', '2015-05-06 17:20:11'),
(4266, 239, '10', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4267, 239, '21', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4268, 239, '26', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4269, 239, '29', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4270, 239, '3', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4271, 239, '35', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4272, 239, '39', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4273, 239, '42', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4274, 239, '43', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4275, 239, '44', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4276, 239, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4277, 239, '50', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4278, 239, '51', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4279, 239, '8', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4280, 239, '9000', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4281, 239, '9001', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4282, 239, '9002', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4283, 239, '9100', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4284, 239, '9101', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4285, 239, 'HANDS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4286, 239, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4287, 239, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4288, 239, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4289, 239, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4290, 239, 'HR', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4291, 239, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4292, 239, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4293, 239, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4294, 239, 'SALES', 1, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', '', '2016-08-15 11:43:07'),
(4295, 239, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4296, 239, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4297, 239, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4298, 239, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4299, 239, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4300, 239, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4301, 239, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4302, 239, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4303, 239, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4304, 239, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4305, 239, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4306, 239, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4307, 239, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:54:10'),
(4308, 239, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4309, 239, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4310, 239, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4311, 239, 'FM', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4312, 239, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4313, 239, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4314, 239, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4315, 239, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4316, 239, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4317, 239, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4318, 239, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4319, 239, 'ALLUSERS', 1, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:54:10'),
(4320, 239, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4321, 239, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4322, 239, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4323, 239, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4324, 239, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4325, 239, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4326, 239, 'MD', 0, 0, 0, 0, 0, 'root', '2015-04-22 05:53:55', 'root', '2015-04-22 08:53:55'),
(4327, 240, '3', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4328, 240, '9000', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4329, 240, '9001', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4330, 240, '9002', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4331, 240, '9100', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4332, 240, '9101', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4333, 240, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4334, 240, 'HR', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4335, 240, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4336, 240, 'KAMMNG', 1, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 16:03:53'),
(4337, 240, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4338, 240, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4339, 240, '29', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4340, 240, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4341, 240, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:26'),
(4342, 240, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4343, 240, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4344, 240, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4345, 240, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:26'),
(4346, 240, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4347, 240, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4348, 240, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4349, 240, 'SALES', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4350, 240, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4351, 240, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4352, 240, '51', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4353, 240, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4354, 240, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4355, 240, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4356, 240, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4357, 240, '26', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4358, 240, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4359, 240, '8', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4360, 240, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4361, 240, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4362, 240, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4363, 240, 'FM', 1, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:26'),
(4364, 240, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4365, 240, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4366, 240, '42', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4367, 240, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4368, 240, '44', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4369, 240, '35', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4370, 240, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4371, 240, 'DMD', 1, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 17:31:13'),
(4372, 240, '10', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4373, 240, '50', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4374, 240, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4375, 240, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4376, 240, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4377, 240, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4378, 240, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4379, 240, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4380, 240, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4381, 240, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4382, 240, '39', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4383, 240, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4384, 240, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4385, 240, 'MD', 1, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 17:31:13'),
(4386, 240, 'DIRSALMNG', 1, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 16:03:43'),
(4387, 240, 'HANDS', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4388, 240, '43', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4389, 240, '21', 0, 0, 0, 0, 0, 'root', '2015-07-22 12:39:08', 'root', '2015-07-22 15:39:08'),
(4390, 241, '3', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4391, 241, '9000', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4392, 241, '9001', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4393, 241, '9002', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4394, 241, '9100', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4395, 241, '9101', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4396, 241, 'STPMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4397, 241, 'HR', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4398, 241, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4399, 241, 'KAMMNG', 1, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:07:20'),
(4400, 241, 'SOUMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4401, 241, 'AFFOPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4402, 241, '29', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4403, 241, 'TOLMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4404, 241, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:07:20'),
(4405, 241, 'TRUMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4406, 241, 'FINDATA', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4407, 241, 'MOWFIN', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4408, 241, 'ADMIN', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:07:20'),
(4409, 241, 'NMGROPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4410, 241, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4411, 241, 'ITMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4412, 241, 'SALES', 1, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:07:20'),
(4413, 241, 'HRMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4414, 241, 'SALMNG', 1, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:07:20'),
(4415, 241, '51', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4416, 241, 'STPOPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4417, 241, 'TGLOPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4418, 241, 'FWDMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4419, 241, 'WHPMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4420, 241, '26', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4421, 241, 'FINANCE', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4422, 241, '8', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4423, 241, 'LEGAL', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4424, 241, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4425, 241, 'WHMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4426, 241, 'FM', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4427, 241, 'AFFMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4428, 241, 'VYPMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4429, 241, '42', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4430, 241, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4431, 241, '44', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4432, 241, '35', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4433, 241, 'CHBMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4434, 241, 'DMD', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4435, 241, '10', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4436, 241, '50', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4437, 241, 'KRKOPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4438, 241, 'ADMMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4439, 241, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4440, 241, 'WHSMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4441, 241, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:07:20'),
(4442, 241, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4443, 241, 'TRUOPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4444, 241, 'DOMADM', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4445, 241, '39', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4446, 241, 'MOWOPS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4447, 241, 'ACCMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4448, 241, 'MD', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4449, 241, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4450, 241, 'HANDS', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4451, 241, '43', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4452, 241, '21', 0, 0, 0, 0, 0, '', '2015-11-06 07:06:35', '', '2015-11-06 10:06:35'),
(4453, 242, 'ALLUSERS', 1, 0, 0, 0, 0, 'zhuravlev', '2015-11-19 13:12:47', '', '2017-10-30 15:03:05'),
(4454, 1, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4455, 1, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4456, 1, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4457, 1, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4458, 1, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4459, 1, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4460, 1, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4461, 1, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4462, 1, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4463, 2, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4464, 2, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4465, 2, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4466, 2, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4467, 2, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4468, 2, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4469, 2, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4470, 2, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4471, 2, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4472, 170, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4473, 170, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4474, 170, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4475, 170, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4476, 170, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4477, 170, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4478, 170, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4479, 170, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4480, 170, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4481, 171, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4482, 171, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4483, 171, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4484, 171, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4485, 171, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4486, 171, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4487, 171, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4488, 171, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4489, 171, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4490, 172, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4491, 172, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4492, 172, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4493, 172, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4494, 172, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4495, 172, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4496, 172, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4497, 172, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4498, 172, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4499, 173, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4500, 173, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4501, 173, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4502, 173, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4503, 173, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4504, 173, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4505, 173, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4506, 173, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4507, 173, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4508, 174, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4509, 174, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4510, 174, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4511, 174, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4512, 174, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4513, 174, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4514, 174, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4515, 174, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4516, 174, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4517, 175, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4518, 175, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4519, 175, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4520, 175, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4521, 175, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4522, 175, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4523, 175, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4524, 175, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4525, 175, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4526, 176, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4527, 176, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4528, 176, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4529, 176, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4530, 176, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4531, 176, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4532, 176, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4533, 176, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4534, 176, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4535, 177, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4536, 177, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4537, 177, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4538, 177, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4539, 177, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4540, 177, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4541, 177, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4542, 177, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4543, 177, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4544, 178, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4545, 178, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4546, 178, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4547, 178, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4548, 178, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4549, 178, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4550, 178, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4551, 178, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4552, 178, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4553, 179, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4554, 179, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4555, 179, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4556, 179, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4557, 179, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4558, 179, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4559, 179, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4560, 179, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4561, 179, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4562, 180, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4563, 180, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4564, 180, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4565, 180, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4566, 180, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4567, 180, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4568, 180, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4569, 180, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4570, 180, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4571, 181, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4572, 181, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4573, 181, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4574, 181, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4575, 181, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4576, 181, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4577, 181, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4578, 181, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4579, 181, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4580, 182, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4581, 182, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4582, 182, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4583, 182, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4584, 182, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4585, 182, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4586, 182, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4587, 182, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4588, 182, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4589, 183, 'KAMMNG', 1, 0, 0, 0, 0, NULL, '2016-02-10 06:50:07', '', '2016-12-08 14:54:51'),
(4590, 183, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4591, 183, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4592, 183, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4593, 183, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4594, 183, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4595, 183, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4596, 183, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4597, 183, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4598, 184, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4599, 184, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4600, 184, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4601, 184, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4602, 184, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4603, 184, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4604, 184, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4605, 184, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4606, 184, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4607, 185, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4608, 185, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4609, 185, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4610, 185, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4611, 185, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4612, 185, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4613, 185, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4614, 185, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4615, 185, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4616, 186, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4617, 186, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4618, 186, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4619, 186, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4620, 186, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4621, 186, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4622, 186, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4623, 186, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4624, 186, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4625, 187, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4626, 187, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4627, 187, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4628, 187, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4629, 187, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4630, 187, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4631, 187, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4632, 187, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4633, 187, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4634, 188, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4635, 188, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4636, 188, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4637, 188, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4638, 188, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4639, 188, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4640, 188, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4641, 188, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4642, 188, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4643, 189, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4644, 189, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4645, 189, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4646, 189, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4647, 189, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4648, 189, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4649, 189, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4650, 189, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4651, 189, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4652, 190, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4653, 190, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4654, 190, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4655, 190, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4656, 190, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4657, 190, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4658, 190, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4659, 190, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4660, 190, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4661, 191, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4662, 191, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4663, 191, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4664, 191, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4665, 191, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4666, 191, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4667, 191, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4668, 191, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4669, 191, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4670, 192, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4671, 192, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4672, 192, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4673, 192, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4674, 192, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4675, 192, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4676, 192, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4677, 192, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4678, 192, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4679, 193, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4680, 193, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4681, 193, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4682, 193, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4683, 193, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4684, 193, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4685, 193, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4686, 193, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4687, 193, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4688, 194, '3', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4689, 194, '9000', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4690, 194, '9001', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4691, 194, '9002', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4692, 194, '9100', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4693, 194, '9101', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4694, 194, 'STPMNG', 0, 0, 1, 0, 0, NULL, '2016-02-10 06:50:07', '', '2017-10-23 15:16:01'),
(4695, 194, 'HR', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4696, 194, 'NMGRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4697, 194, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4698, 194, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4699, 194, 'AFFOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4700, 194, '29', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4701, 194, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4702, 194, 'TRUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4703, 194, 'FINDATA', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4704, 194, 'MOWFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4705, 194, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4706, 194, 'NMGROPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4707, 194, 'TMMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4708, 194, 'ITMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4709, 194, 'SALES', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4710, 194, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4711, 194, 'SALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4712, 194, '51', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4713, 194, 'STPOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4714, 194, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4715, 194, 'FWDMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4716, 194, 'WHPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4717, 194, '26', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4718, 194, 'FINANCE', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4719, 194, '8', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4720, 194, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4721, 194, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4722, 194, 'WHMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4723, 194, 'AFFMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4724, 194, 'VYPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4725, 194, '42', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4726, 194, 'HCMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4727, 194, '44', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4728, 194, '35', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4729, 194, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4730, 194, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4731, 194, '10', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4732, 194, '50', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4733, 194, 'KRKOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4734, 194, 'ADMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4735, 194, 'ITSUPPORT', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4736, 194, 'WHSMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4737, 194, 'ALLUSERS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4738, 194, 'NMGRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4739, 194, 'TRUOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4740, 194, 'DOMADM', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4741, 194, '39', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4742, 194, 'MOWOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL);
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(4743, 194, 'ACCMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4744, 194, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4745, 194, 'HANDS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4746, 194, '43', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4747, 194, '21', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4748, 195, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4749, 195, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4750, 195, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4751, 195, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4752, 195, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4753, 195, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4754, 195, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4755, 195, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4756, 195, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4757, 196, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4758, 196, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4759, 196, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4760, 196, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4761, 196, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4762, 196, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4763, 196, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4764, 196, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4765, 196, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4766, 198, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4767, 198, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4768, 198, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4769, 198, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4770, 198, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4771, 198, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4772, 198, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4773, 198, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4774, 198, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4775, 199, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4776, 199, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4777, 199, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4778, 199, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4779, 199, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4780, 199, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4781, 199, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4782, 199, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4783, 199, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4784, 200, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4785, 200, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4786, 200, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4787, 200, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4788, 200, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4789, 200, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4790, 200, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4791, 200, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4792, 200, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4793, 201, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4794, 201, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4795, 201, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4796, 201, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4797, 201, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4798, 201, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4799, 201, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4800, 201, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4801, 201, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4802, 202, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4803, 202, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4804, 202, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4805, 202, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4806, 202, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4807, 202, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4808, 202, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4809, 202, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4810, 202, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4811, 203, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4812, 203, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4813, 203, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4814, 203, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4815, 203, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4816, 203, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4817, 203, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4818, 203, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4819, 203, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4820, 204, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4821, 204, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4822, 204, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4823, 204, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4824, 204, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4825, 204, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4826, 204, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4827, 204, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4828, 204, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4829, 205, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4830, 205, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4831, 205, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4832, 205, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4833, 205, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4834, 205, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4835, 205, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4836, 205, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4837, 205, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4838, 206, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4839, 206, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4840, 206, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4841, 206, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4842, 206, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4843, 206, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4844, 206, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4845, 206, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4846, 206, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4847, 207, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4848, 207, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4849, 207, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4850, 207, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4851, 207, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4852, 207, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4853, 207, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4854, 207, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4855, 207, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4856, 208, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4857, 208, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4858, 208, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4859, 208, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4860, 208, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4861, 208, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4862, 208, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4863, 208, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4864, 208, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4865, 209, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4866, 209, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4867, 209, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4868, 209, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4869, 209, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4870, 209, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4871, 209, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4872, 209, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4873, 209, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4874, 211, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4875, 211, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4876, 211, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4877, 211, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4878, 211, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4879, 211, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4880, 211, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4881, 211, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4882, 211, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4883, 212, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4884, 212, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4885, 212, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4886, 212, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4887, 212, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4888, 212, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4889, 212, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4890, 212, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4891, 212, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4892, 213, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4893, 213, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4894, 213, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4895, 213, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4896, 213, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4897, 213, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4898, 213, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4899, 213, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4900, 213, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4901, 214, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4902, 214, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4903, 214, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4904, 214, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4905, 214, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4906, 214, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4907, 214, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4908, 214, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4909, 214, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4910, 215, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4911, 215, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4912, 215, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4913, 215, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4914, 215, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4915, 215, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4916, 215, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4917, 215, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4918, 215, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4919, 216, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4920, 216, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4921, 216, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4922, 216, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4923, 216, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4924, 216, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4925, 216, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4926, 216, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4927, 216, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4928, 217, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4929, 217, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4930, 217, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4931, 217, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4932, 217, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4933, 217, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4934, 217, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4935, 217, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4936, 217, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4937, 218, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4938, 218, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4939, 218, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4940, 218, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4941, 218, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4942, 218, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4943, 218, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4944, 218, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4945, 218, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4946, 219, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4947, 219, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4948, 219, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4949, 219, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4950, 219, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4951, 219, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4952, 219, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4953, 219, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4954, 219, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4955, 220, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4956, 220, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4957, 220, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4958, 220, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4959, 220, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4960, 220, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4961, 220, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4962, 220, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4963, 220, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4964, 221, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4965, 221, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4966, 221, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4967, 221, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4968, 221, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4969, 221, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4970, 221, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4971, 221, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4972, 221, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4973, 222, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4974, 222, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4975, 222, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4976, 222, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4977, 222, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4978, 222, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4979, 222, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4980, 222, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4981, 222, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4982, 223, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4983, 223, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4984, 223, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4985, 223, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4986, 223, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4987, 223, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4988, 223, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4989, 223, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4990, 223, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4991, 224, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4992, 224, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4993, 224, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4994, 224, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4995, 224, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4996, 224, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4997, 224, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4998, 224, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(4999, 224, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5000, 225, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5001, 225, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5002, 225, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5003, 225, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5004, 225, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5005, 225, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5006, 225, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5007, 225, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5008, 225, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5009, 226, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5010, 226, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5011, 226, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5012, 226, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5013, 226, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5014, 226, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5015, 226, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5016, 226, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5017, 226, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5018, 227, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5019, 227, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5020, 227, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5021, 227, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5022, 227, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5023, 227, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5024, 227, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5025, 227, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5026, 227, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5027, 228, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5028, 228, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5029, 228, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5030, 228, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5031, 228, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5032, 228, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5033, 228, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5034, 228, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5035, 228, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5036, 229, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5037, 229, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5038, 229, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5039, 229, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5040, 229, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5041, 229, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5042, 229, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5043, 229, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5044, 229, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5045, 230, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5046, 230, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5047, 230, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5048, 230, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5049, 230, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5050, 230, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5051, 230, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5052, 230, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5053, 230, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5054, 231, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5055, 231, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5056, 231, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5057, 231, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5058, 231, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5059, 231, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5060, 231, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5061, 231, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5062, 231, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5063, 232, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5064, 232, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5065, 232, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5066, 232, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5067, 232, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5068, 232, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5069, 232, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5070, 232, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5071, 232, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5072, 233, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5073, 233, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5074, 233, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5075, 233, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5076, 233, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5077, 233, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5078, 233, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5079, 233, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5080, 233, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5081, 234, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5082, 234, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5083, 234, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5084, 234, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5085, 234, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5086, 234, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5087, 234, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5088, 234, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5089, 234, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5090, 235, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5091, 235, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5092, 235, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5093, 235, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5094, 235, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5095, 235, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5096, 235, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5097, 235, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5098, 235, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5099, 236, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5100, 236, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5101, 236, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5102, 236, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5103, 236, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5104, 236, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5105, 236, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5106, 236, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5107, 236, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5108, 237, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5109, 237, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5110, 237, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5111, 237, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5112, 237, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5113, 237, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5114, 237, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5115, 237, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5116, 237, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5117, 238, 'KAMMNG', 1, 0, 0, 0, 0, NULL, '2016-02-10 06:50:07', '', '2016-02-10 09:50:32'),
(5118, 238, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5119, 238, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5120, 238, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5121, 238, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5122, 238, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5123, 238, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5124, 238, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5125, 238, 'DMD', 1, 0, 0, 0, 0, NULL, '2016-02-10 06:50:07', '', '2016-02-10 09:50:57'),
(5126, 239, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5127, 239, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5128, 242, '3', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5129, 242, '9000', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5130, 242, '9001', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5131, 242, '9002', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5132, 242, '9100', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5133, 242, '9101', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5134, 242, 'STPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5135, 242, 'HR', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5136, 242, 'NMGRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5137, 242, 'KAMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5138, 242, 'SOUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5139, 242, 'AFFOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5140, 242, '29', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5141, 242, 'TOLMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5142, 242, 'MANAGEMENT', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5143, 242, 'TRUMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5144, 242, 'FINDATA', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5145, 242, 'MOWFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5146, 242, 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5147, 242, 'NMGROPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5148, 242, 'TMMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5149, 242, 'ITMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5150, 242, 'SALES', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5151, 242, 'HRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5152, 242, 'SALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5153, 242, '51', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5154, 242, 'STPOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5155, 242, 'TGLOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5156, 242, 'FWDMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5157, 242, 'WHPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5158, 242, '26', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5159, 242, 'FINANCE', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5160, 242, '8', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5161, 242, 'LEGAL', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5162, 242, 'TMMRFIN', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5163, 242, 'WHMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5164, 242, 'FM', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5165, 242, 'AFFMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5166, 242, 'VYPMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5167, 242, '42', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5168, 242, 'HCMRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5169, 242, '44', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5170, 242, '35', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5171, 242, 'CHBMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5172, 242, 'DMD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5173, 242, '10', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5174, 242, '50', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5175, 242, 'KRKOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5176, 242, 'ADMMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5177, 242, 'ITSUPPORT', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5178, 242, 'WHSMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5179, 242, 'NMGRMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5180, 242, 'TRUOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5181, 242, 'DOMADM', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5182, 242, '39', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5183, 242, 'MOWOPS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5184, 242, 'ACCMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5185, 242, 'MD', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5186, 242, 'DIRSALMNG', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5187, 242, 'HANDS', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5188, 242, '43', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5189, 242, '21', NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-10 06:50:07', NULL, NULL),
(5190, 243, '3', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5191, 243, '9000', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5192, 243, '9001', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5193, 243, '9002', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5194, 243, '9100', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5195, 243, '9101', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5196, 243, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5197, 243, 'HR', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5198, 243, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5199, 243, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5200, 243, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5201, 243, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5202, 243, '29', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5203, 243, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5204, 243, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5205, 243, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5206, 243, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5207, 243, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5208, 243, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:22:05'),
(5209, 243, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5210, 243, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5211, 243, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5212, 243, 'SALES', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5213, 243, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5214, 243, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5215, 243, '51', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5216, 243, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5217, 243, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5218, 243, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5219, 243, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5220, 243, '26', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5221, 243, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5222, 243, '8', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5223, 243, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5224, 243, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5225, 243, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5226, 243, 'FM', 1, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2018-11-23 10:05:40'),
(5227, 243, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5228, 243, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5229, 243, '42', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5230, 243, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5231, 243, '44', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5232, 243, '35', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5233, 243, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5234, 243, 'DMD', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5235, 243, '10', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5236, 243, '50', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5237, 243, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5238, 243, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5239, 243, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5240, 243, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5241, 243, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:22:06'),
(5242, 243, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5243, 243, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5244, 243, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5245, 243, '39', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5246, 243, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5247, 243, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5248, 243, 'MD', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5249, 243, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5250, 243, 'HANDS', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5251, 243, '43', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5252, 243, '21', 0, 0, 0, 0, 0, '', '2016-03-17 13:09:59', '', '2016-03-17 16:09:59'),
(5253, 244, '3', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5254, 244, '9000', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5255, 244, '9001', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5256, 244, '9002', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5257, 244, '9100', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5258, 244, '9101', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5259, 244, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5260, 244, 'HR', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5261, 244, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5262, 244, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5263, 244, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5264, 244, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5265, 244, '29', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5266, 244, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5267, 244, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-30 09:47:20'),
(5268, 244, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5269, 244, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5270, 244, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5271, 244, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-30 09:47:19'),
(5272, 244, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5273, 244, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5274, 244, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5275, 244, 'SALES', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5276, 244, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5277, 244, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5278, 244, '51', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5279, 244, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5280, 244, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5281, 244, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5282, 244, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5283, 244, '26', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5284, 244, 'FINANCE', 1, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-08-15 11:27:23'),
(5285, 244, '8', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5286, 244, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5287, 244, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5288, 244, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5289, 244, 'FM', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(5290, 244, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5291, 244, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5292, 244, '42', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5293, 244, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5294, 244, '44', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5295, 244, '35', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5296, 244, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5297, 244, 'DMD', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5298, 244, '10', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5299, 244, '50', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5300, 244, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5301, 244, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5302, 244, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5303, 244, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5304, 244, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5305, 244, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5306, 244, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5307, 244, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5308, 244, '39', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5309, 244, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5310, 244, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5311, 244, 'MD', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5312, 244, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5313, 244, 'HANDS', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5314, 244, '43', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5315, 244, '21', 0, 0, 0, 0, 0, '', '2016-03-17 13:11:17', '', '2016-03-17 16:11:17'),
(5316, 245, '3', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5317, 245, '9000', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5318, 245, '9001', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5319, 245, '9002', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5320, 245, '9100', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5321, 245, '9101', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5322, 245, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5323, 245, 'HR', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5324, 245, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5325, 245, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5326, 245, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5327, 245, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5328, 245, '29', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5329, 245, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5330, 245, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5331, 245, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5332, 245, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5333, 245, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5334, 245, 'ADMIN', 1, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5335, 245, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5336, 245, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5337, 245, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5338, 245, 'SALES', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5339, 245, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5340, 245, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5341, 245, '51', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5342, 245, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5343, 245, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5344, 245, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5345, 245, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5346, 245, '26', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5347, 245, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5348, 245, '8', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5349, 245, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5350, 245, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5351, 245, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5352, 245, 'FM', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5353, 245, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5354, 245, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5355, 245, '42', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5356, 245, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5357, 245, '44', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5358, 245, '35', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5359, 245, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5360, 245, 'DMD', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5361, 245, '10', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5362, 245, '50', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5363, 245, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5364, 245, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5365, 245, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5366, 245, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5367, 245, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5368, 245, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5369, 245, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5370, 245, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5371, 245, '39', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5372, 245, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5373, 245, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5374, 245, 'MD', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5375, 245, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5376, 245, 'HANDS', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5377, 245, '43', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5378, 245, '21', 0, 0, 0, 0, 0, '', '2016-03-30 06:47:46', '', '2016-03-30 09:47:46'),
(5379, 246, '3', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5380, 246, '9000', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5381, 246, '9001', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5382, 246, '9002', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5383, 246, '9100', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5384, 246, '9101', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5385, 246, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5386, 246, 'HR', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5387, 246, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5388, 246, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5389, 246, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5390, 246, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5391, 246, '29', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5392, 246, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5393, 246, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5394, 246, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5395, 246, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5396, 246, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5397, 246, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:17:43'),
(5398, 246, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5399, 246, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5400, 246, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5401, 246, 'SALES', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5402, 246, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5403, 246, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5404, 246, '51', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5405, 246, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5406, 246, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5407, 246, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5408, 246, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5409, 246, '26', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5410, 246, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5411, 246, '8', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5412, 246, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5413, 246, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5414, 246, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5415, 246, 'FM', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5416, 246, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5417, 246, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5418, 246, '42', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5419, 246, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5420, 246, '44', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5421, 246, '35', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5422, 246, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5423, 246, 'DMD', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5424, 246, '10', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5425, 246, '50', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5426, 246, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5427, 246, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5428, 246, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5429, 246, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5430, 246, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:17:43'),
(5431, 246, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5432, 246, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5433, 246, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5434, 246, '39', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5435, 246, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5436, 246, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5437, 246, 'MD', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5438, 246, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5439, 246, 'HANDS', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5440, 246, '43', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5441, 246, '21', 0, 0, 0, 0, 0, '', '2016-03-30 14:16:56', '', '2016-03-30 17:16:56'),
(5442, 247, '3', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5443, 247, '9000', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5444, 247, '9001', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5445, 247, '9002', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5446, 247, '9100', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5447, 247, '9101', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5448, 247, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5449, 247, 'HR', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5450, 247, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5451, 247, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5452, 247, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5453, 247, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5454, 247, '29', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5455, 247, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5456, 247, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5457, 247, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5458, 247, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5459, 247, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5460, 247, 'ADMIN', 1, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5461, 247, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5462, 247, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5463, 247, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5464, 247, 'SALES', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5465, 247, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5466, 247, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5467, 247, '51', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5468, 247, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5469, 247, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5470, 247, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5471, 247, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5472, 247, '26', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5473, 247, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5474, 247, '8', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5475, 247, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5476, 247, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5477, 247, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5478, 247, 'FM', 1, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2018-11-23 10:05:40'),
(5479, 247, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5480, 247, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5481, 247, '42', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5482, 247, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5483, 247, '44', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5484, 247, '35', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5485, 247, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5486, 247, 'DMD', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5487, 247, '10', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5488, 247, '50', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5489, 247, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5490, 247, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5491, 247, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5492, 247, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5493, 247, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:30'),
(5494, 247, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5495, 247, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5496, 247, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5497, 247, '39', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5498, 247, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5499, 247, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5500, 247, 'MD', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5501, 247, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5502, 247, 'HANDS', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5503, 247, '43', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5504, 247, '21', 0, 0, 0, 0, 0, '', '2016-06-16 06:12:20', '', '2016-06-16 09:12:20'),
(5505, 248, '3', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5506, 248, '9000', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5507, 248, '9001', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5508, 248, '9002', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5509, 248, '9100', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5510, 248, '9101', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5511, 248, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5512, 248, 'HR', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5513, 248, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5514, 248, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5515, 248, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5516, 248, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5517, 248, '29', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5518, 248, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5519, 248, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5520, 248, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5521, 248, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5522, 248, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5523, 248, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:16'),
(5524, 248, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5525, 248, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5526, 248, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5527, 248, 'SALES', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5528, 248, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5529, 248, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5530, 248, '51', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5531, 248, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5532, 248, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5533, 248, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5534, 248, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5535, 248, '26', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5536, 248, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5537, 248, '8', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5538, 248, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5539, 248, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5540, 248, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5541, 248, 'FM', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5542, 248, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5543, 248, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5544, 248, '42', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5545, 248, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5546, 248, '44', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5547, 248, '35', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5548, 248, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5549, 248, 'DMD', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5550, 248, '10', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5551, 248, '50', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5552, 248, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5553, 248, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5554, 248, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5555, 248, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5556, 248, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:16'),
(5557, 248, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5558, 248, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5559, 248, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5560, 248, '39', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5561, 248, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5562, 248, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5563, 248, 'MD', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5564, 248, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5565, 248, 'HANDS', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5566, 248, '43', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5567, 248, '21', 0, 0, 0, 0, 0, '', '2016-06-17 07:53:07', '', '2016-06-17 10:53:07'),
(5568, 249, '3', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5569, 249, '9000', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5570, 249, '9001', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5571, 249, '9002', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5572, 249, '9100', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5573, 249, '9101', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5574, 249, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5575, 249, 'HR', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5576, 249, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5577, 249, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5578, 249, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5579, 249, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5580, 249, '29', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5581, 249, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5582, 249, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5583, 249, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5584, 249, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5585, 249, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5586, 249, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:45'),
(5587, 249, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5588, 249, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5589, 249, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5590, 249, 'SALES', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5591, 249, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5592, 249, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5593, 249, '51', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5594, 249, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5595, 249, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5596, 249, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5597, 249, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5598, 249, '26', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5599, 249, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:45'),
(5600, 249, '8', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5601, 249, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5602, 249, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5603, 249, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5604, 249, 'FM', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:45'),
(5605, 249, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5606, 249, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5607, 249, '42', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5608, 249, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5609, 249, '44', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5610, 249, '35', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5611, 249, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5612, 249, 'DMD', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5613, 249, '10', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5614, 249, '50', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5615, 249, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5616, 249, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5617, 249, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5618, 249, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5619, 249, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:45'),
(5620, 249, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5621, 249, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5622, 249, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5623, 249, '39', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5624, 249, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5625, 249, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5626, 249, 'MD', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5627, 249, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5628, 249, 'HANDS', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5629, 249, '43', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5630, 249, '21', 0, 0, 0, 0, 0, '', '2016-06-17 07:54:01', '', '2016-06-17 10:54:01'),
(5631, 250, '3', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5632, 250, '9000', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5633, 250, '9001', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5634, 250, '9002', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5635, 250, '9100', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5636, 250, '9101', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5637, 250, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5638, 250, 'HR', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5639, 250, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5640, 250, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5641, 250, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5642, 250, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5643, 250, '29', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5644, 250, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5645, 250, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5646, 250, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5647, 250, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5648, 250, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5649, 250, 'ADMIN', 1, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5650, 250, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5651, 250, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5652, 250, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5653, 250, 'SALES', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5654, 250, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5655, 250, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5656, 250, '51', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5657, 250, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5658, 250, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5659, 250, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5660, 250, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5661, 250, '26', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5662, 250, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5663, 250, '8', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5664, 250, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5665, 250, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5666, 250, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5667, 250, 'FM', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5668, 250, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5669, 250, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5670, 250, '42', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5671, 250, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5672, 250, '44', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5673, 250, '35', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5674, 250, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5675, 250, 'DMD', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5676, 250, '10', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5677, 250, '50', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5678, 250, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5679, 250, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5680, 250, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5681, 250, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5682, 250, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:35'),
(5683, 250, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5684, 250, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5685, 250, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5686, 250, '39', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5687, 250, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5688, 250, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5689, 250, 'MD', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5690, 250, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5691, 250, 'HANDS', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5692, 250, '43', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5693, 250, '21', 0, 0, 0, 0, 0, '', '2016-06-17 08:01:27', '', '2016-06-17 11:01:27'),
(5694, 251, '3', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5695, 251, '9000', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5696, 251, '9001', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5697, 251, '9002', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5698, 251, '9100', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5699, 251, '9101', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5700, 251, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5701, 251, 'HR', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5702, 251, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5703, 251, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5704, 251, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5705, 251, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5706, 251, '29', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5707, 251, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5708, 251, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:33'),
(5709, 251, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5710, 251, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5711, 251, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5712, 251, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:33'),
(5713, 251, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5714, 251, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5715, 251, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5716, 251, 'SALES', 1, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:33'),
(5717, 251, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5718, 251, 'SALMNG', 1, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:33'),
(5719, 251, '51', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5720, 251, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5721, 251, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5722, 251, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5723, 251, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5724, 251, '26', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5725, 251, 'FINANCE', 1, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:33'),
(5726, 251, '8', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5727, 251, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5728, 251, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5729, 251, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5730, 251, 'FM', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5731, 251, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5732, 251, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5733, 251, '42', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5734, 251, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5735, 251, '44', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5736, 251, '35', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5737, 251, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5738, 251, 'DMD', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5739, 251, '10', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5740, 251, '50', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5741, 251, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5742, 251, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5743, 251, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5744, 251, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5745, 251, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5746, 251, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5747, 251, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5748, 251, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5749, 251, '39', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5750, 251, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5751, 251, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5752, 251, 'MD', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5753, 251, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5754, 251, 'HANDS', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5755, 251, '43', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5756, 251, '21', 0, 0, 0, 0, 0, '', '2016-08-15 08:28:12', '', '2016-08-15 11:28:12'),
(5757, 252, '3', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5758, 252, '9000', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5759, 252, '9001', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5760, 252, '9002', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5761, 252, '9100', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5762, 252, '9101', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5763, 252, 'STPMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5764, 252, 'HR', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5765, 252, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5766, 252, 'KAMMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5767, 252, 'SOUMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5768, 252, 'AFFOPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5769, 252, '29', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5770, 252, 'TOLMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5771, 252, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:30'),
(5772, 252, 'TRUMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5773, 252, 'FINDATA', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5774, 252, 'MOWFIN', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5775, 252, 'ADMIN', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:30'),
(5776, 252, 'NMGROPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5777, 252, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5778, 252, 'ITMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5779, 252, 'SALES', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5780, 252, 'HRMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5781, 252, 'SALMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5782, 252, '51', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5783, 252, 'STPOPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5784, 252, 'TGLOPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5785, 252, 'FWDMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5786, 252, 'WHPMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5787, 252, '26', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5788, 252, 'FINANCE', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5789, 252, '8', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5790, 252, 'LEGAL', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5791, 252, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5792, 252, 'WHMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5793, 252, 'FM', 1, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2018-11-23 10:05:40'),
(5794, 252, 'AFFMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5795, 252, 'VYPMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5796, 252, '42', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5797, 252, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5798, 252, '44', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5799, 252, '35', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5800, 252, 'CHBMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5801, 252, 'DMD', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5802, 252, '10', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5803, 252, '50', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5804, 252, 'KRKOPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5805, 252, 'ADMMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5806, 252, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5807, 252, 'WHSMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5808, 252, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5809, 252, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5810, 252, 'TRUOPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5811, 252, 'DOMADM', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5812, 252, '39', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5813, 252, 'MOWOPS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5814, 252, 'ACCMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5815, 252, 'MD', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5816, 252, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5817, 252, 'HANDS', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5818, 252, '43', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5819, 252, '21', 0, 0, 0, 0, 0, '', '2016-11-16 06:59:09', '', '2016-11-16 09:59:09'),
(5820, 253, '3', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5821, 253, '9000', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5822, 253, '9001', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5823, 253, '9002', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5824, 253, '9100', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5825, 253, '9101', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5826, 253, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5827, 253, 'HR', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5828, 253, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5829, 253, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5830, 253, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5831, 253, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5832, 253, '29', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5833, 253, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5834, 253, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5835, 253, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5836, 253, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5837, 253, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5838, 253, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:23:01'),
(5839, 253, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5840, 253, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5841, 253, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5842, 253, 'SALES', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5843, 253, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5844, 253, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5845, 253, '51', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5846, 253, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5847, 253, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5848, 253, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(5849, 253, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5850, 253, '26', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5851, 253, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5852, 253, '8', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5853, 253, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5854, 253, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5855, 253, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5856, 253, 'FM', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5857, 253, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5858, 253, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5859, 253, '42', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5860, 253, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5861, 253, '44', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5862, 253, '35', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5863, 253, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5864, 253, 'DMD', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5865, 253, '10', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5866, 253, '50', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5867, 253, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5868, 253, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5869, 253, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5870, 253, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5871, 253, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:23:01'),
(5872, 253, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5873, 253, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5874, 253, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5875, 253, '39', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5876, 253, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5877, 253, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5878, 253, 'MD', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5879, 253, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5880, 253, 'HANDS', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5881, 253, '43', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5882, 253, '21', 0, 0, 0, 0, 0, '', '2017-04-26 11:22:47', '', '2017-04-26 14:22:47'),
(5883, 254, '3', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5884, 254, '9000', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5885, 254, '9001', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5886, 254, '9002', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5887, 254, '9100', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5888, 254, '9101', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5889, 254, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5890, 254, 'HR', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5891, 254, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5892, 254, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5893, 254, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5894, 254, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5895, 254, '29', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5896, 254, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5897, 254, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:53'),
(5898, 254, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5899, 254, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5900, 254, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5901, 254, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:53'),
(5902, 254, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5903, 254, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5904, 254, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5905, 254, 'SALES', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5906, 254, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5907, 254, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5908, 254, '51', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5909, 254, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5910, 254, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5911, 254, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5912, 254, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5913, 254, '26', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5914, 254, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5915, 254, '8', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5916, 254, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5917, 254, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5918, 254, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5919, 254, 'FM', 1, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2018-11-23 10:05:40'),
(5920, 254, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5921, 254, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5922, 254, '42', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5923, 254, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5924, 254, '44', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5925, 254, '35', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5926, 254, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5927, 254, 'DMD', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5928, 254, '10', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5929, 254, '50', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5930, 254, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5931, 254, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5932, 254, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5933, 254, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5934, 254, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5935, 254, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5936, 254, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5937, 254, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5938, 254, '39', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5939, 254, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5940, 254, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5941, 254, 'MD', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5942, 254, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5943, 254, 'HANDS', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5944, 254, '43', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5945, 254, '21', 0, 0, 0, 0, 0, '', '2017-09-01 12:57:45', '', '2017-09-01 15:57:45'),
(5946, 255, '3', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5947, 255, '9000', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5948, 255, '9001', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5949, 255, '9002', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5950, 255, '9100', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5951, 255, '9101', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5952, 255, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5953, 255, 'HR', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5954, 255, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5955, 255, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5956, 255, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5957, 255, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5958, 255, '29', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5959, 255, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5960, 255, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:46'),
(5961, 255, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5962, 255, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5963, 255, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5964, 255, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:46'),
(5965, 255, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5966, 255, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5967, 255, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5968, 255, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5969, 255, 'SALES', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5970, 255, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5971, 255, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5972, 255, '51', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5973, 255, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5974, 255, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5975, 255, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5976, 255, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5977, 255, '26', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5978, 255, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5979, 255, '8', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5980, 255, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5981, 255, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5982, 255, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5983, 255, 'FM', 1, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2018-11-23 10:05:40'),
(5984, 255, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5985, 255, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5986, 255, '42', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5987, 255, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5988, 255, '44', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5989, 255, '35', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5990, 255, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5991, 255, 'DMD', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5992, 255, '10', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5993, 255, '50', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5994, 255, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5995, 255, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5996, 255, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5997, 255, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5998, 255, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(5999, 255, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6000, 255, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6001, 255, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6002, 255, '39', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6003, 255, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6004, 255, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6005, 255, 'MD', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6006, 255, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6007, 255, 'HANDS', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6008, 255, '43', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6009, 255, '21', 0, 0, 0, 0, 0, '', '2017-09-14 06:49:22', '', '2017-09-14 09:49:22'),
(6073, 256, '3', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6074, 256, '9000', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6075, 256, '9001', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6076, 256, '9002', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6077, 256, '9100', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6078, 256, '9101', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6079, 256, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6080, 256, 'HR', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6081, 256, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6082, 256, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6083, 256, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6084, 256, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6085, 256, '29', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6086, 256, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6087, 256, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6088, 256, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6089, 256, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6090, 256, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6091, 256, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:53:17'),
(6092, 256, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6093, 256, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6094, 256, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6095, 256, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6096, 256, 'SALES', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6097, 256, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6098, 256, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6099, 256, '51', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6100, 256, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6101, 256, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6102, 256, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6103, 256, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6104, 256, '26', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6105, 256, 'FINANCE', 1, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:53:17'),
(6106, 256, '8', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6107, 256, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6108, 256, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6109, 256, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6110, 256, 'FM', 1, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:53:17'),
(6111, 256, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6112, 256, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6113, 256, '42', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6114, 256, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6115, 256, '44', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6116, 256, '35', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6117, 256, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6118, 256, 'DMD', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6119, 256, '10', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6120, 256, '50', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6121, 256, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6122, 256, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6123, 256, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6124, 256, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6125, 256, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6126, 256, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6127, 256, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6128, 256, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6129, 256, '39', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6130, 256, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6131, 256, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6132, 256, 'MD', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6133, 256, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6134, 256, 'HANDS', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6135, 256, '43', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6136, 256, '21', 0, 0, 0, 0, 0, '', '2017-09-14 06:52:57', '', '2017-09-14 09:52:57'),
(6200, 257, '3', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6201, 257, '9000', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6202, 257, '9001', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6203, 257, '9002', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6204, 257, '9100', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6205, 257, '9101', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6206, 257, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6207, 257, 'HR', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6208, 257, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6209, 257, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6210, 257, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6211, 257, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6212, 257, '29', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6213, 257, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6214, 257, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6215, 257, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6216, 257, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6217, 257, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6218, 257, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:48'),
(6219, 257, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6220, 257, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6221, 257, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6222, 257, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6223, 257, 'SALES', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6224, 257, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6225, 257, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6226, 257, '51', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6227, 257, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6228, 257, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6229, 257, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6230, 257, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6231, 257, '26', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6232, 257, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6233, 257, '8', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6234, 257, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6235, 257, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6236, 257, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6237, 257, 'FM', 1, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2018-11-23 10:05:40'),
(6238, 257, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6239, 257, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6240, 257, '42', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6241, 257, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6242, 257, '44', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6243, 257, '35', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6244, 257, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6245, 257, 'DMD', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6246, 257, '10', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6247, 257, '50', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6248, 257, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6249, 257, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6250, 257, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6251, 257, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6252, 257, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:48'),
(6253, 257, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6254, 257, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6255, 257, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6256, 257, '39', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6257, 257, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6258, 257, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6259, 257, 'MD', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6260, 257, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6261, 257, 'HANDS', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6262, 257, '43', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6263, 257, '21', 0, 0, 0, 0, 0, '', '2017-09-14 15:41:39', '', '2017-09-14 18:41:39'),
(6327, 258, '3', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6328, 258, '9000', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6329, 258, '9001', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6330, 258, '9002', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6331, 258, '9100', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6332, 258, '9101', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6333, 258, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6334, 258, 'HR', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6335, 258, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6336, 258, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6337, 258, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6338, 258, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6339, 258, '29', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6340, 258, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6341, 258, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:45:09'),
(6342, 258, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6343, 258, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6344, 258, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6345, 258, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:45:09'),
(6346, 258, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6347, 258, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6348, 258, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6349, 258, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6350, 258, 'SALES', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6351, 258, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6352, 258, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6353, 258, '51', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6354, 258, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6355, 258, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6356, 258, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6357, 258, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6358, 258, '26', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6359, 258, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6360, 258, '8', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6361, 258, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6362, 258, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6363, 258, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6364, 258, 'FM', 1, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2018-11-23 10:05:40'),
(6365, 258, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6366, 258, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6367, 258, '42', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6368, 258, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6369, 258, '44', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6370, 258, '35', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6371, 258, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6372, 258, 'DMD', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6373, 258, '10', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6374, 258, '50', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6375, 258, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6376, 258, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6377, 258, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6378, 258, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6379, 258, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6380, 258, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6381, 258, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6382, 258, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6383, 258, '39', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6384, 258, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6385, 258, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6386, 258, 'MD', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6387, 258, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6388, 258, 'HANDS', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6389, 258, '43', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6390, 258, '21', 0, 0, 0, 0, 0, '', '2017-10-03 11:44:57', '', '2017-10-03 14:44:57'),
(6391, 259, '3', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6392, 259, '9000', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6393, 259, '9001', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6394, 259, '9002', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6395, 259, '9100', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6396, 259, '9101', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6397, 259, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6398, 259, 'HR', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6399, 259, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6400, 259, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6401, 259, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6402, 259, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6403, 259, '29', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6404, 259, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6405, 259, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:46'),
(6406, 259, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6407, 259, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6408, 259, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6409, 259, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:46'),
(6410, 259, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6411, 259, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6412, 259, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6413, 259, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6414, 259, 'SALES', 1, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:54'),
(6415, 259, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6416, 259, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6417, 259, '51', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6418, 259, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6419, 259, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6420, 259, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6421, 259, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6422, 259, '26', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6423, 259, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6424, 259, '8', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6425, 259, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6426, 259, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6427, 259, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6428, 259, 'FM', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6429, 259, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6430, 259, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6431, 259, '42', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6432, 259, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6433, 259, '44', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6434, 259, '35', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6435, 259, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6436, 259, 'DMD', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6437, 259, '10', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6438, 259, '50', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6439, 259, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6440, 259, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6441, 259, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6442, 259, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6443, 259, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6444, 259, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6445, 259, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6446, 259, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6447, 259, '39', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6448, 259, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6449, 259, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6450, 259, 'MD', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6451, 259, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6452, 259, 'HANDS', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6453, 259, '43', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6454, 259, '21', 0, 0, 0, 0, 0, '', '2017-10-27 12:18:34', '', '2017-10-27 15:18:34'),
(6455, 260, '3', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6456, 260, '9000', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6457, 260, '9001', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6458, 260, '9002', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6459, 260, '9100', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6460, 260, '9101', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6461, 260, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6462, 260, 'HR', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6463, 260, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6464, 260, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6465, 260, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6466, 260, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6467, 260, '29', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6468, 260, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6469, 260, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6470, 260, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6471, 260, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6472, 260, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6473, 260, 'ADMIN', 1, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6474, 260, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6475, 260, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6476, 260, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6477, 260, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6478, 260, 'SALES', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6479, 260, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6480, 260, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6481, 260, '51', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6482, 260, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6483, 260, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6484, 260, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6485, 260, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6486, 260, '26', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6487, 260, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6488, 260, '8', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6489, 260, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6490, 260, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6491, 260, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6492, 260, 'FM', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6493, 260, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6494, 260, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6495, 260, '42', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6496, 260, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6497, 260, '44', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6498, 260, '35', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6499, 260, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6500, 260, 'DMD', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6501, 260, '10', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6502, 260, '50', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6503, 260, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6504, 260, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6505, 260, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6506, 260, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6507, 260, 'ALLUSERS', 1, 0, 1, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:42'),
(6508, 260, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6509, 260, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6510, 260, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6511, 260, '39', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6512, 260, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6513, 260, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6514, 260, 'MD', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6515, 260, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6516, 260, 'HANDS', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6517, 260, '43', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6518, 260, '21', 0, 0, 0, 0, 0, '', '2017-10-30 12:04:35', '', '2017-10-30 15:04:35'),
(6519, 261, '3', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6520, 261, '9000', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6521, 261, '9001', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6522, 261, '9002', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6523, 261, '9100', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6524, 261, '9101', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6525, 261, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6526, 261, 'HR', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6527, 261, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6528, 261, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6529, 261, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6530, 261, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6531, 261, '29', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6532, 261, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6533, 261, 'MANAGEMENT', 1, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:15'),
(6534, 261, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6535, 261, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6536, 261, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6537, 261, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:15'),
(6538, 261, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6539, 261, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6540, 261, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6541, 261, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6542, 261, 'SALES', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6543, 261, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6544, 261, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6545, 261, '51', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6546, 261, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6547, 261, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6548, 261, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6549, 261, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6550, 261, '26', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6551, 261, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6552, 261, '8', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6553, 261, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6554, 261, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6555, 261, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6556, 261, 'FM', 1, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2018-11-23 10:05:40'),
(6557, 261, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6558, 261, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6559, 261, '42', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6560, 261, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6561, 261, '44', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6562, 261, '35', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6563, 261, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6564, 261, 'DMD', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6565, 261, '10', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6566, 261, '50', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6567, 261, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6568, 261, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6569, 261, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6570, 261, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6571, 261, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6572, 261, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6573, 261, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6574, 261, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6575, 261, '39', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6576, 261, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6577, 261, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6578, 261, 'MD', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6579, 261, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6580, 261, 'HANDS', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6581, 261, '43', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6582, 261, '21', 0, 0, 0, 0, 0, '', '2017-11-03 14:25:07', '', '2017-11-03 17:25:07'),
(6583, 262, '3', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6584, 262, '9000', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6585, 262, '9001', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6586, 262, '9002', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6587, 262, '9100', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6588, 262, '9101', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6589, 262, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6590, 262, 'HR', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6591, 262, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6592, 262, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6593, 262, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6594, 262, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6595, 262, '29', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6596, 262, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(6597, 262, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6598, 262, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6599, 262, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6600, 262, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6601, 262, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:03:05'),
(6602, 262, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6603, 262, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6604, 262, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6605, 262, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6606, 262, 'SALES', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6607, 262, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6608, 262, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6609, 262, '51', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6610, 262, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6611, 262, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6612, 262, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6613, 262, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6614, 262, '26', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6615, 262, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6616, 262, '8', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6617, 262, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6618, 262, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6619, 262, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6620, 262, 'FM', 1, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:03:05'),
(6621, 262, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6622, 262, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6623, 262, '42', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6624, 262, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6625, 262, '44', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6626, 262, '35', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6627, 262, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6628, 262, 'DMD', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6629, 262, '10', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6630, 262, '50', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6631, 262, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6632, 262, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6633, 262, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6634, 262, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6635, 262, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6636, 262, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6637, 262, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6638, 262, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6639, 262, '39', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6640, 262, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6641, 262, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6642, 262, 'MD', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6643, 262, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6644, 262, 'HANDS', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6645, 262, '43', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6646, 262, '21', 0, 0, 0, 0, 0, '', '2017-12-25 12:01:04', '', '2017-12-25 15:01:04'),
(6710, 263, '3', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6711, 263, '9000', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6712, 263, '9001', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6713, 263, '9002', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6714, 263, '9100', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6715, 263, '9101', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6716, 263, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6717, 263, 'HR', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6718, 263, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6719, 263, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6720, 263, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6721, 263, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6722, 263, '29', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6723, 263, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6724, 263, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6725, 263, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6726, 263, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6727, 263, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6728, 263, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:07:39'),
(6729, 263, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6730, 263, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6731, 263, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6732, 263, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6733, 263, 'SALES', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6734, 263, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6735, 263, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6736, 263, '51', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6737, 263, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6738, 263, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6739, 263, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6740, 263, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6741, 263, '26', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6742, 263, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6743, 263, '8', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6744, 263, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6745, 263, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6746, 263, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6747, 263, 'FM', 1, 1, 1, 1, 1, '', '2017-12-25 12:05:12', '', '2017-12-25 15:07:39'),
(6748, 263, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6749, 263, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6750, 263, '42', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6751, 263, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6752, 263, '44', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6753, 263, '35', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6754, 263, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6755, 263, 'DMD', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6756, 263, '10', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6757, 263, '50', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6758, 263, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6759, 263, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6760, 263, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6761, 263, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6762, 263, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6763, 263, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6764, 263, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6765, 263, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6766, 263, '39', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6767, 263, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6768, 263, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6769, 263, 'MD', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6770, 263, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6771, 263, 'HANDS', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6772, 263, '43', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6773, 263, '21', 0, 0, 0, 0, 0, '', '2017-12-25 12:05:12', '', '2017-12-25 15:05:12'),
(6837, 264, '3', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6838, 264, '9000', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6839, 264, '9001', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6840, 264, '9002', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6841, 264, '9100', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6842, 264, '9101', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6843, 264, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6844, 264, 'HR', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6845, 264, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6846, 264, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6847, 264, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6848, 264, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6849, 264, '29', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6850, 264, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6851, 264, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6852, 264, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6853, 264, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6854, 264, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6855, 264, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:35'),
(6856, 264, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6857, 264, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6858, 264, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6859, 264, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6860, 264, 'SALES', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6861, 264, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6862, 264, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6863, 264, '51', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6864, 264, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6865, 264, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6866, 264, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6867, 264, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6868, 264, '26', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6869, 264, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6870, 264, '8', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6871, 264, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6872, 264, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6873, 264, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6874, 264, 'FM', 1, 1, 1, 1, 1, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:35'),
(6875, 264, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6876, 264, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6877, 264, '42', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6878, 264, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6879, 264, '44', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6880, 264, '35', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6881, 264, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6882, 264, 'DMD', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6883, 264, '10', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6884, 264, '50', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6885, 264, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6886, 264, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6887, 264, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6888, 264, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6889, 264, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6890, 264, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6891, 264, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6892, 264, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6893, 264, '39', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6894, 264, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6895, 264, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6896, 264, 'MD', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6897, 264, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6898, 264, 'HANDS', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6899, 264, '43', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6900, 264, '21', 0, 0, 0, 0, 0, '', '2017-12-25 12:09:13', '', '2017-12-25 15:09:13'),
(6964, 265, '3', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6965, 265, '9000', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6966, 265, '9001', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6967, 265, '9002', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6968, 265, '9100', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6969, 265, '9101', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6970, 265, 'STPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6971, 265, 'HR', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6972, 265, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6973, 265, 'KAMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6974, 265, 'SOUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6975, 265, 'AFFOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6976, 265, '29', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6977, 265, 'TOLMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6978, 265, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6979, 265, 'TRUMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6980, 265, 'FINDATA', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6981, 265, 'MOWFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6982, 265, 'ADMIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:24:00'),
(6983, 265, 'NMGROPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6984, 265, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6985, 265, 'OFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6986, 265, 'ITMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6987, 265, 'SALES', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6988, 265, 'HRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6989, 265, 'SALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6990, 265, '51', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6991, 265, 'STPOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6992, 265, 'TGLOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6993, 265, 'FWDMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6994, 265, 'WHPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6995, 265, '26', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6996, 265, 'FINANCE', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6997, 265, '8', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6998, 265, 'LEGAL', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(6999, 265, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7000, 265, 'WHMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7001, 265, 'FM', 1, 1, 1, 1, 1, '', '2017-12-25 12:23:36', '', '2017-12-25 15:24:00'),
(7002, 265, 'AFFMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7003, 265, 'VYPMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7004, 265, '42', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7005, 265, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7006, 265, '44', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7007, 265, '35', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7008, 265, 'CHBMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7009, 265, 'DMD', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7010, 265, '10', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7011, 265, '50', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7012, 265, 'KRKOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7013, 265, 'ADMMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7014, 265, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7015, 265, 'WHSMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7016, 265, 'ALLUSERS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7017, 265, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7018, 265, 'TRUOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7019, 265, 'DOMADM', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7020, 265, '39', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7021, 265, 'MOWOPS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7022, 265, 'ACCMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7023, 265, 'MD', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7024, 265, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7025, 265, 'HANDS', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7026, 265, '43', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7027, 265, '21', 0, 0, 0, 0, 0, '', '2017-12-25 12:23:36', '', '2017-12-25 15:23:36'),
(7028, 266, '3', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7029, 266, '9000', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7030, 266, '9001', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7031, 266, '9002', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7032, 266, '9100', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7033, 266, '9101', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7034, 266, 'STPMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7035, 266, 'HR', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7036, 266, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7037, 266, 'KAMMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7038, 266, 'SOUMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7039, 266, 'AFFOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7040, 266, '29', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7041, 266, 'TOLMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7042, 266, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7043, 266, 'TRUMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7044, 266, 'FINDATA', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7045, 266, 'MOWFIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7046, 266, 'ADMIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:04:43'),
(7047, 266, 'NMGROPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7048, 266, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7049, 266, 'OFFMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7050, 266, 'ITMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7051, 266, 'SALES', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7052, 266, 'HRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7053, 266, 'SALMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7054, 266, '51', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7055, 266, 'STPOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7056, 266, 'TGLOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7057, 266, 'FWDMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7058, 266, 'WHPMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7059, 266, '26', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7060, 266, 'FINANCE', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7061, 266, '8', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7062, 266, 'LEGAL', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7063, 266, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7064, 266, 'WHMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7065, 266, 'FM', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7066, 266, 'AFFMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7067, 266, 'VYPMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7068, 266, '42', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7069, 266, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7070, 266, '44', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7071, 266, '35', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7072, 266, 'CHBMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7073, 266, 'DMD', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7074, 266, '10', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7075, 266, '50', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7076, 266, 'KRKOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7077, 266, 'ADMMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7078, 266, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7079, 266, 'WHSMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7080, 266, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:04:43'),
(7081, 266, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7082, 266, 'TRUOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7083, 266, 'DOMADM', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7084, 266, '39', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7085, 266, 'MOWOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7086, 266, 'ACCMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7087, 266, 'MD', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7088, 266, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7089, 266, 'HANDS', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7090, 266, '43', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7091, 266, '21', 0, 0, 0, 0, 0, '', '2018-01-23 13:03:51', '', '2018-01-23 16:03:51'),
(7155, 267, '3', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7156, 267, '9000', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7157, 267, '9001', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7158, 267, '9002', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7159, 267, '9100', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7160, 267, '9101', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7161, 267, 'STPMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7162, 267, 'HR', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7163, 267, 'NMGRFIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7164, 267, 'KAMMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7165, 267, 'SOUMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7166, 267, 'AFFOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7167, 267, '29', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7168, 267, 'TOLMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7169, 267, 'MANAGEMENT', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7170, 267, 'TRUMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7171, 267, 'FINDATA', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7172, 267, 'MOWFIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7173, 267, 'ADMIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:05:00'),
(7174, 267, 'NMGROPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7175, 267, 'TMMRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7176, 267, 'OFFMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7177, 267, 'ITMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7178, 267, 'SALES', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7179, 267, 'HRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7180, 267, 'SALMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7181, 267, '51', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7182, 267, 'STPOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7183, 267, 'TGLOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7184, 267, 'FWDMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7185, 267, 'WHPMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7186, 267, '26', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7187, 267, 'FINANCE', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7188, 267, '8', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7189, 267, 'LEGAL', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7190, 267, 'TMMRFIN', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7191, 267, 'WHMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7192, 267, 'FM', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7193, 267, 'AFFMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7194, 267, 'VYPMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7195, 267, '42', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7196, 267, 'HCMRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7197, 267, '44', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7198, 267, '35', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7199, 267, 'CHBMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7200, 267, 'DMD', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7201, 267, '10', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7202, 267, '50', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7203, 267, 'KRKOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7204, 267, 'ADMMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7205, 267, 'ITSUPPORT', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7206, 267, 'WHSMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7207, 267, 'ALLUSERS', 1, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:05:00'),
(7208, 267, 'NMGRMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7209, 267, 'TRUOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7210, 267, 'DOMADM', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7211, 267, '39', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7212, 267, 'MOWOPS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7213, 267, 'ACCMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7214, 267, 'MD', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7215, 267, 'DIRSALMNG', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7216, 267, 'HANDS', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7217, 267, '43', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7218, 267, '21', 0, 0, 0, 0, 0, '', '2018-01-23 13:04:25', '', '2018-01-23 16:04:25'),
(7219, 268, '3', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7220, 268, '9000', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7221, 268, '9001', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7222, 268, '9002', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7223, 268, '9100', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7224, 268, '9101', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7225, 268, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7226, 268, 'HR', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7227, 268, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7228, 268, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7229, 268, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7230, 268, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7231, 268, '29', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7232, 268, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7233, 268, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7234, 268, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7235, 268, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7236, 268, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7237, 268, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', '', '2018-03-13 11:02:16'),
(7238, 268, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7239, 268, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7240, 268, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7241, 268, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7242, 268, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7243, 268, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7244, 268, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7245, 268, '51', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7246, 268, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7247, 268, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7248, 268, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7249, 268, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7250, 268, '26', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7251, 268, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7252, 268, '8', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7253, 268, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7254, 268, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7255, 268, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7256, 268, 'FM', 1, 1, 1, 1, 1, 'root', '2018-03-13 08:02:03', '', '2018-03-13 11:02:16'),
(7257, 268, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7258, 268, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7259, 268, '42', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7260, 268, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7261, 268, '44', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7262, 268, '35', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7263, 268, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7264, 268, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7265, 268, '10', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7266, 268, '50', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7267, 268, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7268, 268, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7269, 268, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7270, 268, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7271, 268, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7272, 268, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7273, 268, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7274, 268, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7275, 268, '39', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7276, 268, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7277, 268, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7278, 268, 'MD', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7279, 268, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7280, 268, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7281, 268, '43', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7282, 268, '21', 0, 0, 0, 0, 0, 'root', '2018-03-13 08:02:03', 'root', '2018-03-13 11:02:03'),
(7346, 269, '3', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7347, 269, '9000', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7348, 269, '9001', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7349, 269, '9002', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7350, 269, '9100', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7351, 269, '9101', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7352, 269, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', '', '2018-10-23 15:08:09'),
(7353, 269, 'HR', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7354, 269, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7355, 269, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7356, 269, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7357, 269, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7358, 269, '29', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7359, 269, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7360, 269, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', '', '2018-10-23 15:08:09'),
(7361, 269, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7362, 269, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7363, 269, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7364, 269, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', '', '2018-06-05 10:37:59'),
(7365, 269, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7366, 269, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7367, 269, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7368, 269, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7369, 269, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7370, 269, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7371, 269, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7372, 269, '51', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7373, 269, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7374, 269, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7375, 269, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7376, 269, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7377, 269, '26', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7378, 269, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7379, 269, '8', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7380, 269, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7381, 269, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7382, 269, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7383, 269, 'FM', 1, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', '', '2018-06-05 10:37:59'),
(7384, 269, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7385, 269, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7386, 269, '42', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7387, 269, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7388, 269, '44', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7389, 269, '35', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7390, 269, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7391, 269, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7392, 269, '10', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7393, 269, '50', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7394, 269, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7395, 269, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7396, 269, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7397, 269, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7398, 269, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7399, 269, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7400, 269, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7401, 269, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7402, 269, '39', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7403, 269, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7404, 269, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7405, 269, 'MD', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7406, 269, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7407, 269, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7408, 269, '43', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7409, 269, '21', 0, 0, 0, 0, 0, 'root', '2018-06-05 07:36:38', 'root', '2018-06-05 10:36:38'),
(7473, 270, '3', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7474, 270, '9000', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7475, 270, '9001', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7476, 270, '9002', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7477, 270, '9100', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7478, 270, '9101', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7479, 270, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7480, 270, 'HR', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7481, 270, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7482, 270, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7483, 270, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7484, 270, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7485, 270, '29', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7486, 270, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7487, 270, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', '', '2018-06-13 15:34:41'),
(7488, 270, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7489, 270, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7490, 270, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7491, 270, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', '', '2018-06-13 15:34:41'),
(7492, 270, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7493, 270, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7494, 270, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7495, 270, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7496, 270, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7497, 270, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7498, 270, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7499, 270, '51', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7500, 270, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7501, 270, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7502, 270, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7503, 270, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7504, 270, '26', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7505, 270, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7506, 270, '8', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7507, 270, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7508, 270, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7509, 270, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7510, 270, 'FM', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7511, 270, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7512, 270, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7513, 270, '42', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7514, 270, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7515, 270, '44', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7516, 270, '35', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7517, 270, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7518, 270, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(7519, 270, '10', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7520, 270, '50', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7521, 270, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7522, 270, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7523, 270, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7524, 270, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7525, 270, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7526, 270, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7527, 270, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7528, 270, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7529, 270, '39', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7530, 270, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7531, 270, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7532, 270, 'MD', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7533, 270, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7534, 270, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7535, 270, '43', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7536, 270, '21', 0, 0, 0, 0, 0, 'root', '2018-06-13 12:34:31', 'root', '2018-06-13 15:34:31'),
(7600, 271, '3', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7601, 271, '9000', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7602, 271, '9001', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7603, 271, '9002', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7604, 271, '9100', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7605, 271, '9101', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7606, 271, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7607, 271, 'HR', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7608, 271, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7609, 271, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7610, 271, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7611, 271, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7612, 271, '29', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7613, 271, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7614, 271, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7615, 271, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7616, 271, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7617, 271, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7618, 271, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', '', '2018-06-18 16:11:47'),
(7619, 271, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7620, 271, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7621, 271, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7622, 271, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7623, 271, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7624, 271, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7625, 271, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7626, 271, '51', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7627, 271, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7628, 271, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7629, 271, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7630, 271, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7631, 271, '26', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7632, 271, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7633, 271, '8', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7634, 271, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7635, 271, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7636, 271, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7637, 271, 'FM', 1, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', '', '2018-06-18 16:11:47'),
(7638, 271, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7639, 271, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7640, 271, '42', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7641, 271, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7642, 271, '44', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7643, 271, '35', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7644, 271, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7645, 271, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7646, 271, '10', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7647, 271, '50', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7648, 271, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7649, 271, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7650, 271, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7651, 271, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7652, 271, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7653, 271, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7654, 271, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7655, 271, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7656, 271, '39', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7657, 271, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7658, 271, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7659, 271, 'MD', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7660, 271, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7661, 271, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7662, 271, '43', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7663, 271, '21', 0, 0, 0, 0, 0, 'root', '2018-06-18 13:11:37', 'root', '2018-06-18 16:11:37'),
(7664, 272, '3', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7665, 272, '9000', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7666, 272, '9001', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7667, 272, '9002', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7668, 272, '9100', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7669, 272, '9101', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7670, 272, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7671, 272, 'HR', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7672, 272, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7673, 272, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7674, 272, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7675, 272, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7676, 272, '29', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7677, 272, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7678, 272, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', '', '2018-10-23 15:27:08'),
(7679, 272, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7680, 272, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7681, 272, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7682, 272, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', '', '2018-10-23 15:27:08'),
(7683, 272, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7684, 272, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7685, 272, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7686, 272, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7687, 272, 'SALES', 1, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', '', '2018-10-24 14:25:46'),
(7688, 272, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7689, 272, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7690, 272, '51', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7691, 272, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7692, 272, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7693, 272, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7694, 272, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7695, 272, '26', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7696, 272, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7697, 272, '8', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7698, 272, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7699, 272, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7700, 272, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7701, 272, 'FM', 1, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', '', '2018-10-23 15:27:08'),
(7702, 272, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7703, 272, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7704, 272, '42', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7705, 272, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7706, 272, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7707, 272, '44', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7708, 272, '35', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7709, 272, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7710, 272, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7711, 272, '10', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7712, 272, '50', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7713, 272, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7714, 272, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7715, 272, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7716, 272, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7717, 272, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7718, 272, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7719, 272, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7720, 272, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7721, 272, '39', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7722, 272, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7723, 272, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7724, 272, 'MD', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7725, 272, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7726, 272, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7727, 272, '43', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7728, 272, '21', 0, 0, 0, 0, 0, 'root', '2018-10-23 12:26:58', 'root', '2018-10-23 15:26:58'),
(7791, 273, '3', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7792, 273, '9000', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7793, 273, '9001', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7794, 273, '9002', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7795, 273, '9100', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7796, 273, '9101', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7797, 273, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7798, 273, 'HR', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7799, 273, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7800, 273, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7801, 273, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7802, 273, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7803, 273, '29', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7804, 273, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7805, 273, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', '', '2018-10-24 10:48:50'),
(7806, 273, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7807, 273, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7808, 273, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7809, 273, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', '', '2018-10-24 10:48:50'),
(7810, 273, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7811, 273, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7812, 273, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7813, 273, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7814, 273, 'SALES', 1, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', '', '2018-10-24 14:26:25'),
(7815, 273, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7816, 273, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7817, 273, '51', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7818, 273, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7819, 273, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7820, 273, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7821, 273, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7822, 273, '26', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7823, 273, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7824, 273, '8', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7825, 273, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7826, 273, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7827, 273, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7828, 273, 'FM', 1, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', '', '2018-11-23 10:05:40'),
(7829, 273, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7830, 273, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7831, 273, '42', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7832, 273, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7833, 273, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7834, 273, '44', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7835, 273, '35', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7836, 273, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7837, 273, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7838, 273, '10', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7839, 273, '50', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7840, 273, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7841, 273, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7842, 273, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7843, 273, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7844, 273, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7845, 273, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7846, 273, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7847, 273, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7848, 273, '39', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7849, 273, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7850, 273, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7851, 273, 'MD', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7852, 273, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7853, 273, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7854, 273, '43', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7855, 273, '21', 0, 0, 0, 0, 0, 'root', '2018-10-24 07:48:41', 'root', '2018-10-24 10:48:41'),
(7856, 274, '3', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7857, 274, '9000', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7858, 274, '9001', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7859, 274, '9002', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7860, 274, '9100', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7861, 274, '9101', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7862, 274, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7863, 274, 'HR', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7864, 274, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7865, 274, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7866, 274, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7867, 274, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7868, 274, '29', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7869, 274, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7870, 274, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', '', '2018-11-22 15:33:41'),
(7871, 274, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7872, 274, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7873, 274, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7874, 274, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', '', '2018-11-22 15:33:41'),
(7875, 274, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7876, 274, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7877, 274, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7878, 274, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7879, 274, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7880, 274, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7881, 274, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7882, 274, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7883, 274, '51', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7884, 274, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7885, 274, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7886, 274, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7887, 274, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7888, 274, '26', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7889, 274, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7890, 274, '8', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7891, 274, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7892, 274, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7893, 274, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7894, 274, 'FM', 1, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', '', '2018-11-23 10:05:40'),
(7895, 274, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7896, 274, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7897, 274, '42', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7898, 274, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7899, 274, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7900, 274, '44', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7901, 274, '35', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7902, 274, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7903, 274, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7904, 274, '10', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7905, 274, '50', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7906, 274, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7907, 274, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7908, 274, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7909, 274, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7910, 274, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7911, 274, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7912, 274, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7913, 274, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7914, 274, '39', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7915, 274, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7916, 274, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7917, 274, 'MD', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7918, 274, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7919, 274, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7920, 274, '43', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7921, 274, '21', 0, 0, 0, 0, 0, 'root', '2018-11-22 12:33:30', 'root', '2018-11-22 15:33:30'),
(7983, 275, '3', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7984, 275, '9000', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7985, 275, '9001', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7986, 275, '9002', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7987, 275, '9100', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7988, 275, '9101', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7989, 275, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7990, 275, 'HR', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7991, 275, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7992, 275, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7993, 275, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7994, 275, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7995, 275, '29', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7996, 275, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7997, 275, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7998, 275, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(7999, 275, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', '', '2018-12-24 15:20:01'),
(8000, 275, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8001, 275, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', '', '2018-12-24 15:20:01'),
(8002, 275, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8003, 275, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8004, 275, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8005, 275, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8006, 275, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8007, 275, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8008, 275, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8009, 275, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8010, 275, '51', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8011, 275, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8012, 275, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8013, 275, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8014, 275, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8015, 275, '26', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8016, 275, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8017, 275, '8', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8018, 275, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8019, 275, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8020, 275, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8021, 275, 'FM', 1, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', '', '2018-12-24 15:20:01'),
(8022, 275, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8023, 275, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8024, 275, '42', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8025, 275, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8026, 275, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8027, 275, '44', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8028, 275, '35', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8029, 275, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8030, 275, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8031, 275, '10', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8032, 275, '50', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8033, 275, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8034, 275, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8035, 275, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8036, 275, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8037, 275, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8038, 275, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8039, 275, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8040, 275, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8041, 275, '39', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8042, 275, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8043, 275, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8044, 275, 'MD', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8045, 275, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8046, 275, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8047, 275, '43', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8048, 275, '21', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:19:41', 'root', '2018-12-24 15:19:41'),
(8110, 276, '3', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8111, 276, '9000', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8112, 276, '9001', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8113, 276, '9002', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8114, 276, '9100', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8115, 276, '9101', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8116, 276, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8117, 276, 'HR', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8118, 276, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8119, 276, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8120, 276, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8121, 276, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8122, 276, '29', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8123, 276, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8124, 276, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8125, 276, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8126, 276, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', '', '2018-12-24 15:22:26'),
(8127, 276, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8128, 276, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', '', '2018-12-24 15:22:26'),
(8129, 276, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8130, 276, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8131, 276, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8132, 276, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8133, 276, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8134, 276, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8135, 276, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8136, 276, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8137, 276, '51', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8138, 276, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8139, 276, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8140, 276, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8141, 276, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8142, 276, '26', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8143, 276, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8144, 276, '8', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8145, 276, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8146, 276, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8147, 276, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8148, 276, 'FM', 1, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', '', '2018-12-24 15:22:26'),
(8149, 276, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8150, 276, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8151, 276, '42', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8152, 276, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8153, 276, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8154, 276, '44', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8155, 276, '35', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8156, 276, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8157, 276, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8158, 276, '10', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8159, 276, '50', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8160, 276, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8161, 276, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8162, 276, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8163, 276, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8164, 276, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8165, 276, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8166, 276, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8167, 276, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8168, 276, '39', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8169, 276, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8170, 276, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8171, 276, 'MD', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8172, 276, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8173, 276, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8174, 276, '43', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8175, 276, '21', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:12', 'root', '2018-12-24 15:22:12'),
(8237, 277, '3', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8238, 277, '9000', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8239, 277, '9001', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8240, 277, '9002', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8241, 277, '9100', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8242, 277, '9101', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8243, 277, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8244, 277, 'HR', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8245, 277, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8246, 277, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8247, 277, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8248, 277, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8249, 277, '29', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8250, 277, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8251, 277, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8252, 277, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8253, 277, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', '', '2018-12-24 15:23:06'),
(8254, 277, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8255, 277, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', '', '2018-12-24 15:23:06'),
(8256, 277, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8257, 277, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8258, 277, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8259, 277, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8260, 277, 'SALES', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8261, 277, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8262, 277, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8263, 277, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8264, 277, '51', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8265, 277, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8266, 277, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8267, 277, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8268, 277, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8269, 277, '26', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8270, 277, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8271, 277, '8', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8272, 277, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8273, 277, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8274, 277, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8275, 277, 'FM', 1, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', '', '2018-12-24 15:23:06'),
(8276, 277, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8277, 277, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8278, 277, '42', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8279, 277, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8280, 277, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8281, 277, '44', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8282, 277, '35', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8283, 277, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8284, 277, 'DMD', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8285, 277, '10', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8286, 277, '50', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8287, 277, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8288, 277, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8289, 277, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8290, 277, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8291, 277, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8292, 277, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8293, 277, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8294, 277, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8295, 277, '39', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8296, 277, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8297, 277, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8298, 277, 'MD', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8299, 277, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8300, 277, 'HANDS', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8301, 277, '43', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8302, 277, '21', 0, 0, 0, 0, 0, 'root', '2018-12-24 12:22:49', 'root', '2018-12-24 15:22:49'),
(8303, 278, '3', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8304, 278, '9000', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8305, 278, '9001', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8306, 278, '9002', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8307, 278, '9100', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8308, 278, '9101', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8309, 278, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8310, 278, 'HR', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8311, 278, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8312, 278, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8313, 278, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8314, 278, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8315, 278, '29', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8316, 278, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8317, 278, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:40'),
(8318, 278, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8319, 278, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8320, 278, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8321, 278, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:40'),
(8322, 278, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8323, 278, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8324, 278, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8325, 278, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8326, 278, 'SALES', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8327, 278, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8328, 278, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8329, 278, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8330, 278, '51', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8331, 278, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8332, 278, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8333, 278, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8334, 278, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8335, 278, '26', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8336, 278, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8337, 278, '8', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8338, 278, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8339, 278, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8340, 278, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29');
INSERT INTO `stbl_page_role` (`pgrID`, `pgrPageID`, `pgrRoleID`, `pgrFlagRead`, `pgrFlagCreate`, `pgrFlagUpdate`, `pgrFlagDelete`, `pgrFlagWrite`, `pgrInsertBy`, `pgrInsertDate`, `pgrEditBy`, `pgrEditDate`) VALUES
(8341, 278, 'FM', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8342, 278, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8343, 278, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8344, 278, '42', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8345, 278, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8346, 278, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8347, 278, '44', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8348, 278, '35', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8349, 278, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8350, 278, 'DMD', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8351, 278, '10', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8352, 278, '50', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8353, 278, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8354, 278, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8355, 278, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8356, 278, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8357, 278, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8358, 278, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8359, 278, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8360, 278, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8361, 278, '39', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8362, 278, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8363, 278, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8364, 278, 'MD', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8365, 278, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8366, 278, 'HANDS', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8367, 278, '43', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8368, 278, '21', 0, 0, 0, 0, 0, 'root', '2019-06-05 14:29:29', 'root', '2019-06-05 17:29:29'),
(8369, 279, '3', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8370, 279, '9000', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8371, 279, '9001', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8372, 279, '9002', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8373, 279, '9100', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8374, 279, '9101', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8375, 279, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8376, 279, 'HR', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8377, 279, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8378, 279, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8379, 279, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8380, 279, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8381, 279, '29', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8382, 279, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8383, 279, 'MANAGEMENT', 1, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:46'),
(8384, 279, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8385, 279, 'FINDATA', 1, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-13 14:42:28'),
(8386, 279, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8387, 279, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:46'),
(8388, 279, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8389, 279, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8390, 279, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8391, 279, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8392, 279, 'SALES', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8393, 279, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8394, 279, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8395, 279, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8396, 279, '51', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8397, 279, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8398, 279, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8399, 279, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8400, 279, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8401, 279, '26', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8402, 279, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8403, 279, '8', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8404, 279, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8405, 279, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8406, 279, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8407, 279, 'FM', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8408, 279, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8409, 279, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8410, 279, '42', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8411, 279, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8412, 279, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8413, 279, '44', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8414, 279, '35', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8415, 279, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8416, 279, 'DMD', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8417, 279, '10', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8418, 279, '50', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8419, 279, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8420, 279, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8421, 279, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8422, 279, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8423, 279, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8424, 279, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8425, 279, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8426, 279, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8427, 279, '39', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8428, 279, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8429, 279, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8430, 279, 'MD', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8431, 279, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8432, 279, 'HANDS', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8433, 279, '43', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8434, 279, '21', 0, 0, 0, 0, 0, 'root', '2019-06-10 14:42:35', 'root', '2019-06-10 17:42:35'),
(8435, 280, '3', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8436, 280, '9000', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8437, 280, '9001', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8438, 280, '9002', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8439, 280, '9100', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8440, 280, '9101', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8441, 280, 'STPMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8442, 280, 'HR', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8443, 280, 'NMGRFIN', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8444, 280, 'KAMMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8445, 280, 'SOUMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8446, 280, 'AFFOPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8447, 280, '29', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8448, 280, 'TOLMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8449, 280, 'MANAGEMENT', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8450, 280, 'TRUMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8451, 280, 'FINDATA', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8452, 280, 'MOWFIN', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8453, 280, 'ADMIN', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:19'),
(8454, 280, 'NMGROPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8455, 280, 'TMMRMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8456, 280, 'OFFMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8457, 280, 'ITMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8458, 280, 'SALES', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8459, 280, 'CORPMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8460, 280, 'HRMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8461, 280, 'SALMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8462, 280, '51', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8463, 280, 'STPOPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8464, 280, 'TGLOPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8465, 280, 'FWDMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8466, 280, 'WHPMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8467, 280, '26', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8468, 280, 'FINANCE', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8469, 280, '8', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8470, 280, 'LEGAL', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8471, 280, 'TMMRFIN', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8472, 280, 'WHMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8473, 280, 'FM', 1, 1, 1, 1, 1, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:19'),
(8474, 280, 'AFFMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8475, 280, 'VYPMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8476, 280, '42', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8477, 280, 'HCMRMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8478, 280, 'LEDMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8479, 280, '44', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8480, 280, '35', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8481, 280, 'CHBMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8482, 280, 'DMD', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8483, 280, '10', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8484, 280, '50', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8485, 280, 'KRKOPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8486, 280, 'ADMMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8487, 280, 'ITSUPPORT', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8488, 280, 'WHSMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8489, 280, 'ALLUSERS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8490, 280, 'NMGRMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8491, 280, 'TRUOPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8492, 280, 'DOMADM', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8493, 280, '39', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8494, 280, 'MOWOPS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8495, 280, 'ACCMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8496, 280, 'MD', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8497, 280, 'DIRSALMNG', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8498, 280, 'HANDS', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8499, 280, '43', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00'),
(8500, 280, '21', 0, 0, 0, 0, 0, 'root', '2019-08-08 06:16:00', 'root', '2019-08-08 09:16:00');

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_profit_role`
--

DROP TABLE IF EXISTS `stbl_profit_role`;
CREATE TABLE `stbl_profit_role` (
  `pcrID` int(11) NOT NULL,
  `pcrProfitID` varchar(11) NOT NULL DEFAULT '1',
  `pcrRoleID` varchar(50) NOT NULL DEFAULT 'MD',
  `pcrFlagRead` tinyint(4) NOT NULL DEFAULT '0',
  `pcrFlagUpdate` tinyint(4) NOT NULL DEFAULT '0',
  `pcrInsertBy` varchar(50) DEFAULT NULL,
  `pcrInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pcrEditBy` varchar(50) DEFAULT NULL,
  `pcrEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stbl_profit_role`
--

INSERT INTO `stbl_profit_role` (`pcrID`, `pcrProfitID`, `pcrRoleID`, `pcrFlagRead`, `pcrFlagUpdate`, `pcrInsertBy`, `pcrInsertDate`, `pcrEditBy`, `pcrEditDate`) VALUES
(1, '%', 'FM', 1, 1, NULL, '2013-10-24 12:10:33', NULL, NULL),
(2, '%', 'MD', 1, 0, NULL, '2013-10-24 12:10:39', NULL, NULL),
(3, '%', 'SALES', 0, 0, NULL, '2013-10-24 12:15:22', NULL, NULL),
(4, '%', 'SALMNG', 1, 0, NULL, '2013-10-24 12:15:22', NULL, NULL),
(34, '%', 'FINDATA', 1, 0, NULL, '2013-10-24 12:15:26', NULL, NULL),
(276, '2', 'LEDMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(277, '3', 'TMMRMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(278, '4', 'FWDMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(279, '5', 'WHPMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(280, '8', 'FWDMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(281, '14', 'AFFMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(282, '15', 'WHSMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(283, '16', 'NOVMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(284, '18', 'TRUMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(285, '19', 'VYPMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(286, '20', 'HCMRMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(287, '21', 'TMMRMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(288, '22', 'TOLMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(289, '111', 'YTLMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(291, '162', 'VYPMNG', 1, 1, NULL, '2019-06-04 13:19:55', NULL, NULL),
(307, '2', 'STPMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(308, '3', 'STPMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(309, '21', 'STPMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(310, '18', 'STPMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(311, '2', 'OFFMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(312, '4', 'OFFMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(313, '16', 'OFFMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(314, '19', 'OFFMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL),
(315, '18', 'TMMRMNG', 1, 0, NULL, '2019-06-04 13:19:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_role`
--

DROP TABLE IF EXISTS `stbl_role`;
CREATE TABLE `stbl_role` (
  `rolID` varchar(50) NOT NULL,
  `rolGUID` char(36) DEFAULT NULL,
  `rolCN` varchar(255) DEFAULT NULL,
  `rolTitle` varchar(50) DEFAULT NULL,
  `rolTitleLocal` varchar(100) DEFAULT NULL,
  `rolFlagDefault` tinyint(4) DEFAULT '0',
  `rolFlagDeleted` tinyint(4) DEFAULT '0',
  `rolInsertBy` varchar(30) DEFAULT NULL,
  `rolInsertDate` datetime DEFAULT NULL,
  `rolEditBy` varchar(30) DEFAULT NULL,
  `rolEditDate` datetime DEFAULT NULL,
  `rolEmail` varchar(255) DEFAULT '',
  `rolSQL` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table defines roles in the application';

--
-- Дамп данных таблицы `stbl_role`
--

INSERT INTO `stbl_role` (`rolID`, `rolGUID`, `rolCN`, `rolTitle`, `rolTitleLocal`, `rolFlagDefault`, `rolFlagDeleted`, `rolInsertBy`, `rolInsertDate`, `rolEditBy`, `rolEditDate`, `rolEmail`, `rolSQL`) VALUES
('10', '9F8A0C41-2856-44C4-A82B-60222F003BCD', NULL, 'Branch manager- StP', 'Директор филиала- Говорова', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('21', 'F731FC0E-B273-4091-8C1D-67163B2C9457', NULL, 'Treasurer', 'Казначей', 0, 0, NULL, NULL, 'root', '2014-10-27 12:14:02', '', NULL),
('26', '647FB578-A26E-4C57-B4C4-5E049C93F79D', NULL, 'Office administrator - STP', 'Администратор офиса - СПб', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('29', '24E59136-E532-4A5D-8F54-9852BE30A826', NULL, 'Office administrator- Pokrov', 'Администратор офиса - Покров', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('3', NULL, NULL, 'Scanner', 'Сканировщик', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('35', '9A50481A-A8EB-4421-B4EB-7F5711FB3E2C', NULL, 'Finance Controller', 'Финансовый контролер', 0, 0, NULL, NULL, 'root', '2013-12-12 09:19:58', '', NULL),
('39', 'E1D42C56-5254-44B8-BFD0-8FDA27ADCF15', NULL, 'Branch manager - NOVO', 'РП Новороссийск', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('42', '7C4CEFC5-D717-4807-8F6A-31A54F0EABA9', NULL, 'Administrator - NOVO', 'Администратор - Новороссийск', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('43', 'F2D0EE6F-85B2-48E9-98DE-758CACE997EF', NULL, 'Procurement manager', 'Менеджер отдела закупок', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('44', '966354D2-E5F8-4E93-ADE6-95CA7C7EF196', NULL, 'Deputy forwarding manager', 'Заместитель руководителя направления экспедирования', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('50', 'A34B9A2E-F026-407B-9110-B59DA9D1247F', NULL, 'BM Trucking', 'РП Тракинг', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('51', '50F5D74C-FCD9-4F09-A655-E63E23CE3EC2', NULL, 'ICD manager', 'Руководитель контейнерной площадки', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('8', '66E15DEF-4A6A-473D-91D9-049118CAACFF', NULL, 'Office administrator - MOW', 'Администратор офиса - Москва', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('9000', NULL, NULL, 'Editors', 'Редакторы', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('9001', NULL, NULL, 'Last editor', 'Последний редактор', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('9002', NULL, NULL, 'First editor', 'Инициатор', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('9100', NULL, NULL, 'Immediate manager', 'Непосредственный руководитель', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('9101', NULL, NULL, 'Department manager', 'Руководитель департамента', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('ACCMNG', 'ED9B164C-0BD2-433B-B336-1DAD9AD5EAD9', NULL, 'Chief accountant', 'Главный бухгалтер', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('ADMIN', '3750414C-A210-45F3-9083-FDEFBB14F655', NULL, 'Secretary', 'Секретарь', 0, 0, 'zhuravlev', '2008-10-20 08:50:15', 'root', '2013-09-17 09:41:52', '', NULL),
('ADMMNG', 'B5399711-66EE-4A8B-B681-F04296B0CFAB', NULL, 'Admin manager', 'Административный менеджер', 0, 0, 'zhuravlev', '2009-07-29 10:11:10', 'zhuravlev', '2009-07-29 10:11:25', '', NULL),
('AFFMNG', '77517F6D-920A-4610-A465-01D9825C6C73', NULL, 'AFF manager', 'Руководитель отдела авиаперевозок', 0, 0, NULL, NULL, '', '2017-01-16 10:11:00', '', NULL),
('AFFOPS', '2288237F-53C9-4FE4-841A-A1488E0E3445', NULL, 'AFF operations', 'Отдел авиаперевозок', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('ALLUSERS', 'C22EEC92-67B5-4FCD-B4C3-FD76B6F0AAFA', NULL, 'User', 'Пользователь', 1, 0, 'admin', '2008-09-29 11:15:08', 'admin', '2008-09-29 11:15:08', '', NULL),
('CHBMNG', '9A6FA7F6-A8D3-4749-B058-86F3811D2F41', NULL, 'CHB Manager', 'Руководитель таможенного отдела', 0, 0, 'zhuravlev', '2014-06-04 12:37:54', 'root', '2015-06-17 11:10:45', '', NULL),
('CORPMNG', '4cb0a3c2-e657-11e8-8f91-000d3ab33059', NULL, 'Corporate manager', 'Руководитель корпоративного отдела', 0, 0, 'ZHURAVLEV', NULL, 'ZHURAVLEV', '2018-11-12 11:46:05', '', NULL),
('DIRSALMNG', 'EE31441C-3634-4868-8F4B-FB8289DF8C49', NULL, 'Direct sales manager', 'Руководитель отдела прямых продаж', 0, 0, NULL, NULL, 'root', '2013-11-21 16:29:55', '', NULL),
('DMD', '9AB0B0C8-40A8-4275-9CAA-A4D529F0ED98', NULL, 'Deputy MD', 'Заместитель генерального директора', 0, 0, 'zhuravlev', '2015-07-13 09:26:20', 'zhuravlev', '2015-07-13 09:26:20', '', NULL),
('DOMADM', 'DDC2FD1E-FE5B-43B9-B9CC-355306BA2B52', NULL, 'Administrator', 'Администратор', 0, 0, 'admin', '2008-09-29 11:15:08', '', '2012-03-14 09:55:38', '', NULL),
('FINANCE', '6606035C-6716-4FE3-8B2C-352A8FB45E5C', NULL, 'Accountant', 'Бухгалтер', 0, 0, '', '2010-12-09 09:13:36', '', '2013-07-12 13:54:36', '', NULL),
('FINDATA', '34161363-8846-4CF8-888C-57540219DB03', NULL, 'Registrator', 'Регистратор', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('FM', '704D6120-9E3C-408B-B6BF-DC0F382A0AB6', NULL, 'Finance manager', 'Финансовый менеджер', 0, 0, 'zhuravlev', '2008-10-31 08:48:58', 'root', '2019-08-08 09:23:25', '', NULL),
('FWDMNG', '58E443ED-AF61-4661-AFD1-22EA7AA77E8E', NULL, 'Forwarding manager', 'Руководитель направления экспедирования', 0, 0, NULL, NULL, '', '2019-02-01 11:34:29', '', NULL),
('HANDS', 'EF6DD6EF-D103-43C2-94AF-16DCC2AE5797', NULL, 'H&S Officer', NULL, 0, 0, '', '2012-10-09 09:56:52', '', '2012-10-09 09:57:06', '', NULL),
('HCMRMNG', '83BF3EB6-B869-4D71-BF90-B41A963F8D37', NULL, 'BM Tver', 'РП Тверь', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('HR', '0446C9E3-958C-444A-9875-0855A365C478', NULL, 'Human resources', 'Отдел кадров', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('HRMNG', '4CC6459A-1A86-4241-A260-5982125E52AE', NULL, 'HR Manager', 'Руководитель отдела кадров', 0, 0, 'zhuravlev', '2013-10-23 12:11:12', '', '2019-02-01 11:39:01', '', NULL),
('ITMNG', '433F700E-114E-4013-B966-FE2716B7A6B0', NULL, 'IT manager', 'ИТ-менеджер', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('ITSUPPORT', 'B777642D-7560-46D3-890C-DE5B6099188D', NULL, 'IT Support', NULL, 0, 0, '', '2012-10-09 09:57:50', '', '2012-12-04 13:43:15', '', NULL),
('KAMMNG', '2020978B-D7C1-4180-AD37-49DA5CD6AD7B', NULL, 'Customer service manager', 'Руководитель отдела обслуживания клиентов', 0, 0, 'zhuravlev', '2014-05-22 23:38:16', '', '2016-08-17 11:31:32', '', NULL),
('KRKOPS', 'AAC712A4-14E0-4F2B-B1BE-FADC7CCE0058', NULL, 'Operations- Krekshino', 'Оперативный отдел- Крекшино', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('LEDMNG', '8b97ef02-1317-11e8-be6d-000d3ab33059', NULL, 'StP FWD Manager', 'Руководитель отдела экпедирования СПб', 0, 0, 'ZHURAVLEV', NULL, '', '2018-02-16 15:48:55', '', NULL),
('LEGAL', '6E153256-DADD-451E-A079-AD2C813CA6F8', NULL, 'Lawyer', 'Юрист', 0, 0, NULL, NULL, 'root', '2015-01-08 17:08:35', '', NULL),
('MANAGEMENT', '2D355572-3DB0-4792-9BAA-70A1F73CB54E', NULL, 'Branch manager', 'Руководитель филиала', 0, 0, 'zhuravlev', '2008-10-23 11:19:08', '', '2017-10-19 12:05:04', '', NULL),
('MD', 'EDCEE078-F471-4506-90E3-CD38D1768ABC', NULL, 'Managing director', 'Генеральный директор', 0, 0, 'zhuravlev', '2008-10-31 08:47:05', 'root', '2015-08-12 12:21:32', '', NULL),
('MOWFIN', '35E886F7-8F21-4F2D-BA08-A7C888EED586', NULL, 'Accountant- Moscow', 'Бухгалтер- Москва', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('MOWOPS', 'EA42B79D-36C7-461D-889C-873B9623E330', NULL, 'Operations- Moscow', 'Оперативный отдел- Москва', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('NMGRFIN', '0C6FECCD-45F5-4551-A226-27F803DB11FC', NULL, 'Accountant- NMGR', 'Бухгалтер- НИССАН', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('NMGRMNG', 'D4FE8BBF-AE22-4FEE-A5B3-A482ADC1567D', NULL, 'Branch manager- NMGR', 'Руководитель филиала- НИССАН', 0, 0, NULL, NULL, '', '2017-01-16 10:11:39', '', NULL),
('NMGROPS', '39684397-D377-4A8E-BEAC-B5AF1AB0D9BC', NULL, 'Operations- NMGR', 'Оперативный отдел-НИССАН', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('OFFMNG', '40a5387e-946a-11e7-addd-000d3ab33059', NULL, 'OFF Manager', 'Руководитель направления OFF', 0, 0, 'ZHURAVLEV', NULL, '', '2017-09-08 10:55:45', '', NULL),
('SALES', '49261517-F580-46B8-929A-910519FA99D9', NULL, 'Project Manager', 'Менеджер проекта', 0, 0, '', '2011-03-09 12:12:35', 'root', '2019-06-10 11:05:49', '', NULL),
('SALMNG', '4D84A78E-A3A0-44E3-A5A3-43BAAB7A59B5', NULL, 'Commercial director', 'Коммерческий директор', 0, 0, NULL, NULL, 'root', '2014-10-30 10:32:17', '', NULL),
('SOUMNG', '20f1b12d-c320-11e4-8283-bbf390f520bb', NULL, 'South Russia manager', 'Директор Юга России', 0, 0, NULL, '2015-03-05 13:13:52', NULL, '2015-03-05 13:13:54', '', NULL),
('STPMNG', NULL, NULL, 'Branch manager- StP', 'Директор филиала- Говорова', 0, 0, NULL, NULL, '', '2016-05-26 17:41:08', '', NULL),
('STPOPS', '56B65EAB-0D3C-4F1D-B30D-D167796FB8EA', NULL, 'Operations- StP', 'Оперативный отдел- СПб', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('TGLOPS', '589E2FE4-AAC4-493A-9749-155185EDFB41', NULL, 'Togliatti OPS', 'Оперативный отдел - Тольятти', 0, 0, 'root', '2014-11-21 11:27:15', 'root', '2014-11-21 11:27:39', '', NULL),
('TMMRFIN', '6e5dc2f0-14ca-11e5-bba0-9d7266a91b8a', NULL, 'TMMR Finance', 'Бухгалтер, ТММР', 0, 0, 'zhuravlev', '2015-06-17 11:27:03', 'zhuravlev', '2015-06-17 11:27:03', '', NULL),
('TMMRMNG', '3CC75F4E-8660-4636-825A-F52D51E879C9', NULL, 'Branch manager- TMMR', 'Директор филиала- Шушары', 0, 0, NULL, NULL, 'root', '2015-04-20 10:54:36', '', NULL),
('TOLMNG', '27F68402-24D6-4451-A4F2-B3AAC9BEE74F', NULL, 'BM Togliatti', 'РП Тольятти', 0, 0, 'zhuravlev', '2014-03-03 15:12:15', NULL, NULL, '', NULL),
('TRUMNG', '2FFD5695-1BC3-4CCA-B5C6-EC08D4D9BC63', NULL, 'Trucking manager', 'Руководитель автохозяйства', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('TRUOPS', 'DD4C85BA-F18B-41F2-B6D8-8B46FDC74727', NULL, 'Trucking operations', 'Сотрудники автохозяйства', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('VYPMNG', '7A5C31DD-226E-4348-B957-E134CA878E65', NULL, 'BM Vostochny', 'РП Восточный', 0, 0, NULL, NULL, '', '2019-02-01 11:38:10', '', NULL),
('WHMNG', '6FD8DA5B-160A-4FAC-A15F-751FBFA5F1B7', NULL, 'GM, Contract logistics', 'Руководитель контрактной логистики', 0, 0, NULL, NULL, '', '2016-12-28 20:50:11', '', NULL),
('WHPMNG', '64497C18-4C97-4A29-8940-DE2FEE1257AC', NULL, 'WH manager- Pokrov', 'Начальник склада- Покров', 0, 0, NULL, NULL, NULL, NULL, '', NULL),
('WHSMNG', 'BC2BDC1B-3EBA-4FB8-BD44-158D2C1D2891', NULL, 'WH Manager - StP', 'Начальник склада - Шушары', 0, 0, NULL, NULL, NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `stbl_role_user`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `stbl_role_user`;
CREATE TABLE `stbl_role_user` (
`rluID` int(11)
,`rluUserID` varchar(50)
,`rluRoleID` varchar(50)
,`rluInsertBy` varchar(30)
,`rluInsertDate` timestamp
,`rluEditBy` varchar(30)
,`rluEditDate` datetime
,`rluDeadline` date
);

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_setting`
--

DROP TABLE IF EXISTS `stbl_setting`;
CREATE TABLE `stbl_setting` (
  `setID` varchar(30) NOT NULL DEFAULT '',
  `setTitle` varchar(255) DEFAULT NULL,
  `setTitleLocal` varchar(255) DEFAULT NULL,
  `setDescription` text,
  `setDescriptionLocal` text,
  `setFlagDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `setType` varchar(20) NOT NULL DEFAULT 'varchar',
  `setFlagReadOnly` tinyint(1) NOT NULL DEFAULT '0',
  `setSQL` text,
  `setOrder` smallint(6) DEFAULT NULL,
  `setInsertBy` varchar(50) NOT NULL DEFAULT 'admin',
  `setInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `setEditBy` varchar(50) NOT NULL DEFAULT 'admin',
  `setEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User-specific setting list';

--
-- Дамп данных таблицы `stbl_setting`
--

INSERT INTO `stbl_setting` (`setID`, `setTitle`, `setTitleLocal`, `setDescription`, `setDescriptionLocal`, `setFlagDeleted`, `setType`, `setFlagReadOnly`, `setSQL`, `setOrder`, `setInsertBy`, `setInsertDate`, `setEditBy`, `setEditDate`) VALUES
('usuDraftStatus', 'Default draft status', NULL, NULL, NULL, 0, 'varchar', 0, NULL, 3, 'admin', '2010-12-03 08:20:29', 'admin', NULL),
('usuInvoiceCostID', 'Default cost tab', NULL, NULL, NULL, 0, 'varchar', 0, NULL, 2, 'admin', '2010-04-22 02:10:41', 'admin', NULL),
('usuInvoiceTabsheet', 'Tabsheet type', NULL, NULL, NULL, 0, 'varchar', 0, NULL, 1, 'admin', '2010-04-22 02:10:29', 'admin', NULL);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `stbl_setup`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `stbl_setup`;
CREATE TABLE `stbl_setup` (
`stpID` int(11)
,`stpVarName` varchar(255)
,`stpCharType` varchar(20)
,`stpCharValue` varchar(512)
,`stpFlagReadOnly` tinyint(4)
,`stpNGroup` int(11)
,`stpCharName` varchar(255)
,`stpInsertBy` varchar(50)
,`stpInsertDate` datetime
,`stpEditBy` varchar(50)
,`stpEditDate` datetime
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `stbl_user`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `stbl_user`;
CREATE TABLE `stbl_user` (
`usrID` varchar(50)
,`usrName` varchar(70)
,`usrPass` varchar(32)
,`usrFlagDeleted` tinyint(4)
,`usrInsertBy` varchar(50)
,`usrInsertDate` datetime
,`usrEditBy` varchar(50)
,`usrEditDate` datetime
,`usrNameLocal` varchar(255)
,`usrScanFolder` varchar(255)
,`usrLanguage` char(2)
,`usrFlagLocal` tinyint(4)
,`usrPhone` varchar(50)
,`usrEmail` varchar(255)
,`usrProfitID` int(11)
,`usrEmployeeID` int(11)
,`usrGUID` char(36)
,`usrGDS` varchar(20)
,`usrTitle` varchar(70)
,`usrTitleLocal` varchar(255)
);

-- --------------------------------------------------------

--
-- Структура таблицы `stbl_user_setup`
--

DROP TABLE IF EXISTS `stbl_user_setup`;
CREATE TABLE `stbl_user_setup` (
  `usuID` int(10) NOT NULL,
  `usuFlagReadOnly` tinyint(1) NOT NULL DEFAULT '0',
  `usuSettingID` varchar(50) NOT NULL,
  `usuUserID` varchar(50) NOT NULL,
  `usuValue` varchar(255) DEFAULT NULL,
  `usuInsertBy` varchar(50) NOT NULL DEFAULT 'admin',
  `usuInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuEditBy` varchar(50) DEFAULT NULL,
  `usuEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User settings';

--
-- Дамп данных таблицы `stbl_user_setup`
--

INSERT INTO `stbl_user_setup` (`usuID`, `usuFlagReadOnly`, `usuSettingID`, `usuUserID`, `usuValue`, `usuInsertBy`, `usuInsertDate`, `usuEditBy`, `usuEditDate`) VALUES
(1, 0, 'usuInvoiceTabsheet', 'zhuravlev', 'cost', 'zhuravlev', '2010-04-22 02:05:30', 'zhuravlev', '2010-04-22 06:05:35'),
(2, 0, 'usuInvoiceCostID', 'zhuravlev', '5', 'zhuravlev', '2010-04-22 02:06:46', 'zhuravlev', '2010-04-22 06:06:51'),
(3, 0, 'usuInvoiceTabsheet', 'eliseev', 'cost', 'zhuravlev', '2010-04-22 05:50:55', 'zhuravlev', '2010-04-22 09:50:58'),
(4, 0, 'usuInvoiceCostID', 'eliseev', '7', 'zhuravlev', '2010-04-22 05:53:05', 'zhuravlev', '2010-04-22 09:53:09'),
(5, 0, 'usuInvoiceTabsheet', 'kholyavenko', 'cost', 'zhuravlev', '2010-04-22 05:59:52', 'zhuravlev', '2010-04-22 09:59:56'),
(6, 0, 'usuInvoiceCostID', 'kholyavenko', '4', 'zhuravlev', '2010-04-22 06:00:32', 'zhuravlev', '2010-04-22 10:00:36'),
(7, 0, 'usuInvoiceTabsheet', 'bakhtina', 'cost', 'admin', '2010-08-27 06:59:49', NULL, NULL),
(8, 0, 'usuInvoiceCostID', 'bakhtina', '5', 'admin', '2010-08-27 07:00:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_calendar`
--

DROP TABLE IF EXISTS `tbl_calendar`;
CREATE TABLE `tbl_calendar` (
  `calID` int(11) NOT NULL,
  `calGUID` char(36) NOT NULL,
  `calTitle` varchar(50) NOT NULL DEFAULT 'Payment run',
  `calTitleLocal` varchar(50) NOT NULL DEFAULT 'Платежный день',
  `calFlagDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `calDateStart` date DEFAULT NULL,
  `calDateEnd` date DEFAULT NULL,
  `calComment` text,
  `calInsertBy` varchar(50) NOT NULL,
  `calInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `calEditBy` varchar(50) DEFAULT NULL,
  `calEditDate` datetime DEFAULT NULL,
  `calClass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='calendar requests';

--
-- Дамп данных таблицы `tbl_calendar`
--

INSERT INTO `tbl_calendar` (`calID`, `calGUID`, `calTitle`, `calTitleLocal`, `calFlagDeleted`, `calDateStart`, `calDateEnd`, `calComment`, `calInsertBy`, `calInsertDate`, `calEditBy`, `calEditDate`, `calClass`) VALUES
(1, 'FCA68A29-4332-4899-B99C-742403C9A10E', 'Submission to GHQ', 'Сдача в GHQ', 0, '2013-11-25', '2013-11-25', NULL, 'zhuravlev', '2013-10-23 09:41:02', NULL, NULL, NULL),
(2, '79ff39be-4061-11e3-a47d-6648373a7cc2', 'Testing', 'Тестирование', 0, '2013-10-28', '2013-10-28', '', 'ZHURAVLEV', '2013-10-29 06:15:28', 'ZHURAVLEV', '2013-10-29 10:15:28', NULL),
(3, '89046e79-4061-11e3-a47d-6648373a7cc2', 'Deployment', 'Разворачивание на боевой сервер', 0, '2013-10-29', '2013-10-29', '', 'ZHURAVLEV', '2013-10-29 06:15:53', 'ZHURAVLEV', '2013-10-29 10:15:53', NULL),
(4, '9c4ad1ce-4061-11e3-a47d-6648373a7cc2', 'Sales input', 'Ввод продаж', 0, '2013-10-29', '2013-11-05', '', 'ZHURAVLEV', '2013-10-29 06:16:25', 'ZHURAVLEV', '2013-10-29 10:16:25', NULL),
(5, 'c182521d-4061-11e3-a47d-6648373a7cc2', 'Branch PnL review', 'Анализ результатов подразделений', 0, '2013-11-06', '2013-11-07', '', 'ZHURAVLEV', '2013-10-29 06:17:28', 'ZHURAVLEV', '2013-10-29 10:17:28', NULL),
(6, '3c9293f1-4067-11e3-a47d-6648373a7cc2', 'Indirect cost input', 'Косвенные расходы', 0, '2013-10-31', '2013-11-05', '', 'ZHURAVLEV', '2013-10-29 06:56:42', 'ZHURAVLEV', '2013-10-29 10:56:42', NULL),
(7, '5e8d77ed-4067-11e3-a47d-6648373a7cc2', 'Current employees (HQ)', 'Текущие сотрудники', 0, '2013-10-29', '2013-10-31', '', 'ZHURAVLEV', '2013-10-29 06:57:39', 'ZHURAVLEV', '2013-10-29 10:57:39', NULL),
(8, '349078f6-46ec-11e3-85ee-e463411dcfb5', 'Depreciation input', 'Амортизация (HQ)', 0, '2013-11-07', '2013-11-08', '', 'ZHURAVLEV', '2013-11-06 14:03:26', 'ZHURAVLEV', '2013-11-06 18:03:26', NULL),
(9, '9252c61f-46ee-11e3-85ee-e463411dcfb5', 'Medical insurance input', 'ДМС', 0, '2013-11-08', '2013-11-08', '', 'ZHURAVLEV', '2013-11-06 14:20:23', 'ZHURAVLEV', '2013-11-06 18:20:37', NULL),
(10, 'ac4efa35-46ee-11e3-85ee-e463411dcfb5', 'Vehicle maintenance', 'Расходы на оборудование', 0, '2013-11-07', '2013-11-08', '', 'ZHURAVLEV', '2013-11-06 14:21:06', 'ZHURAVLEV', '2013-11-06 18:21:06', NULL),
(11, 'c2d5a8c7-46ee-11e3-85ee-e463411dcfb5', 'Final review YLRU', 'Финальный анализ', 0, '2013-11-22', '2013-11-22', '', 'ZHURAVLEV', '2013-11-06 14:21:44', 'ZHURAVLEV', '2013-11-06 18:21:44', NULL),
(12, 'ef7e6af8-501d-11e3-93cc-7e5530f128f5', 'Management meeting', 'Обсуждение бюджета', 0, '2013-11-18', '2013-11-18', '', 'ZHURAVLEV', '2013-11-18 06:52:47', 'ZHURAVLEV', '2013-11-18 10:52:47', NULL),
(13, '019574a7-501e-11e3-93cc-7e5530f128f5', 'WH Budget review', 'Анализ бюджета складов', 0, NULL, NULL, '', 'ZHURAVLEV', '2013-11-18 06:53:17', 'ZHURAVLEV', '2013-11-18 10:53:17', NULL),
(15, '155322c2-527b-11e3-93cc-7e5530f128f5', 'Last input date', 'Последняя возможность ввести данные', 0, '2013-11-21', '2013-11-21', '', 'ZHURAVLEV', '2013-11-21 07:03:52', 'ZHURAVLEV', '2013-11-21 11:03:52', NULL),
(16, '4fa54a87-62ed-11e3-ade7-668f9c600d20', '3rd draft review', 'Пересмотр бюджета, 3-я редакция', 0, '2013-12-12', '2013-12-13', '', 'ZHURAVLEV', '2013-12-12 05:21:31', 'ZHURAVLEV', '2013-12-12 09:21:31', NULL),
(17, '3eb4f3d5-7fa2-11e4-89b0-466732c33de6', '2nd draft input deadline', 'Срок сдачи 2-1 редакции', 0, '2014-12-08', '2014-12-08', '', 'ZHURAVLEV', '2014-12-09 12:53:39', 'ZHURAVLEV', '2014-12-09 16:53:39', NULL),
(18, 'cfe6ac43-7d6e-11e5-979e-00155d010c2c', '1st Draft', 'Первая версия', 0, '2015-11-06', '2015-11-06', 'PBT\r\nComments on major assumptions and events', '', '2015-10-28 12:24:19', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_current_employee`
--

DROP TABLE IF EXISTS `tbl_current_employee`;
CREATE TABLE `tbl_current_employee` (
  `cemID` int(11) NOT NULL,
  `cemGUID` char(36) DEFAULT NULL,
  `cemScenario` varchar(20) DEFAULT NULL,
  `cemCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `cemProfitID` int(11) NOT NULL DEFAULT '1',
  `cemComment` text,
  `cemFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `cemAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cemFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `cemInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `cemInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cemEditBy` varchar(50) DEFAULT NULL,
  `cemEditDate` datetime DEFAULT NULL,
  `cemUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `cemTurnover` int(11) NOT NULL DEFAULT '25',
  `cemOvertime` int(11) NOT NULL DEFAULT '25',
  `cemBonusCorporate` int(11) NOT NULL,
  `cemBonusDepartment` int(11) NOT NULL,
  `cemHeadcount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cemClassifiedBy` varchar(50) NOT NULL DEFAULT '',
  `cemCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_depreciation`
--

DROP TABLE IF EXISTS `tbl_depreciation`;
CREATE TABLE `tbl_depreciation` (
  `depID` int(11) NOT NULL,
  `depGUID` char(36) DEFAULT NULL,
  `depScenario` varchar(20) DEFAULT NULL,
  `depCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `depProfitID` int(11) NOT NULL DEFAULT '1',
  `depComment` text,
  `depFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `depFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `depAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `depInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `depInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `depEditBy` varchar(50) DEFAULT NULL,
  `depEditDate` datetime DEFAULT NULL,
  `depUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `depDisposalDate` date DEFAULT NULL,
  `depDisposalValue` decimal(15,2) NOT NULL DEFAULT '0.00',
  `depCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_employee_insurance`
--

DROP TABLE IF EXISTS `tbl_employee_insurance`;
CREATE TABLE `tbl_employee_insurance` (
  `emdID` int(11) NOT NULL,
  `emdEmployeeID` char(36) NOT NULL,
  `emdInsuranceID` varchar(50) NOT NULL,
  `emdFlagDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `emdInsertBy` varchar(50) DEFAULT NULL,
  `emdInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emdEditBy` varchar(50) DEFAULT NULL,
  `emdEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_general_costs`
--

DROP TABLE IF EXISTS `tbl_general_costs`;
CREATE TABLE `tbl_general_costs` (
  `genID` int(11) NOT NULL,
  `genGUID` char(36) DEFAULT NULL,
  `genScenario` varchar(20) DEFAULT NULL,
  `genCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `genSupplierID` int(11) NOT NULL DEFAULT '0',
  `genItemGUID` char(36) NOT NULL DEFAULT '',
  `genComment` text,
  `genFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `genFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `genAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `genInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `genInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `genEditBy` varchar(50) DEFAULT NULL,
  `genEditDate` datetime DEFAULT NULL,
  `genUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `genRate` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `genCurrencyID` char(3) NOT NULL DEFAULT 'RUB',
  `genPeriod` enum('annual','monthly') NOT NULL DEFAULT 'annual',
  `genCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_indirect_costs`
--

DROP TABLE IF EXISTS `tbl_indirect_costs`;
CREATE TABLE `tbl_indirect_costs` (
  `icoID` int(11) NOT NULL,
  `icoGUID` char(36) DEFAULT NULL,
  `icoScenario` varchar(20) DEFAULT NULL,
  `icoCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `icoProfitID` int(11) NOT NULL DEFAULT '1',
  `icoComment` text,
  `icoFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `icoFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `icoAmount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `icoInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `icoInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icoEditBy` varchar(50) DEFAULT NULL,
  `icoEditDate` datetime DEFAULT NULL,
  `icoUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `icoCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_insurance`
--

DROP TABLE IF EXISTS `tbl_insurance`;
CREATE TABLE `tbl_insurance` (
  `dmsID` varchar(50) NOT NULL,
  `dmsGUID` char(36) NOT NULL,
  `dmsTitle` varchar(50) NOT NULL,
  `dmsTitleLocal` varchar(50) NOT NULL,
  `dmsFlagDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `dmsLocationID` int(11) DEFAULT NULL,
  `dmsInsertBy` varchar(50) DEFAULT NULL,
  `dmsInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dmsEditBy` varchar(50) DEFAULT NULL,
  `dmsEditDate` datetime DEFAULT NULL,
  `dmsPrice` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_interco_sales`
--

DROP TABLE IF EXISTS `tbl_interco_sales`;
CREATE TABLE `tbl_interco_sales` (
  `icsID` int(11) NOT NULL,
  `icsGUID` char(36) DEFAULT NULL,
  `icsScenario` varchar(20) DEFAULT NULL,
  `icsCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `icsProfitID` int(11) NOT NULL DEFAULT '18',
  `icsCustomerID` int(11) NOT NULL DEFAULT '6',
  `icsProductFolderID` int(11) NOT NULL DEFAULT '1',
  `icsComment` text,
  `icsFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `icsFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `icsAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `icsInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `icsInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icsEditBy` varchar(50) DEFAULT NULL,
  `icsEditDate` datetime DEFAULT NULL,
  `icsUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `icsCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original',
  `icsType` enum('DC','SC') NOT NULL DEFAULT 'DC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_investment`
--

DROP TABLE IF EXISTS `tbl_investment`;
CREATE TABLE `tbl_investment` (
  `invID` int(11) NOT NULL,
  `invGUID` char(36) DEFAULT NULL,
  `invScenario` varchar(20) DEFAULT NULL,
  `invCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `invProfitID` int(11) NOT NULL DEFAULT '1',
  `invComment` text,
  `invFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `invFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `invAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `invInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invEditBy` varchar(50) DEFAULT NULL,
  `invEditDate` datetime DEFAULT NULL,
  `invUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `invCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_kaizen`
--

DROP TABLE IF EXISTS `tbl_kaizen`;
CREATE TABLE `tbl_kaizen` (
  `kznID` int(11) NOT NULL,
  `kznGUID` char(36) DEFAULT NULL,
  `kznScenario` varchar(20) DEFAULT NULL,
  `kznCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `kznItemGUID` char(36) NOT NULL DEFAULT '4d99e16c-b832-11e0-b9fe-005056930d2f',
  `kznComment` text,
  `kznFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `kznFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `kznAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `kznInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `kznInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kznEditBy` varchar(50) DEFAULT NULL,
  `kznEditDate` datetime DEFAULT NULL,
  `kznUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `kznRate` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `kznCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_location_costs`
--

DROP TABLE IF EXISTS `tbl_location_costs`;
CREATE TABLE `tbl_location_costs` (
  `lcoID` int(11) NOT NULL,
  `lcoGUID` char(36) DEFAULT NULL,
  `lcoScenario` varchar(20) DEFAULT NULL,
  `lcoCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `lcoLocationID` int(11) NOT NULL DEFAULT '1',
  `lcoComment` text,
  `locFlagIncludeBC` tinyint(4) NOT NULL DEFAULT '0',
  `lcoFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `lcoFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `lcoAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lcoInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `lcoInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lcoEditBy` varchar(50) DEFAULT NULL,
  `lcoEditDate` datetime DEFAULT NULL,
  `lcoUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `lcoDistribution` varchar(50) NOT NULL DEFAULT 'all',
  `lcoCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_message_log`
--

DROP TABLE IF EXISTS `tbl_message_log`;
CREATE TABLE `tbl_message_log` (
  `msgID` int(10) NOT NULL,
  `msgGUID` char(36) NOT NULL DEFAULT '0',
  `msgRecipientID` varchar(50) DEFAULT NULL,
  `msgText` text,
  `msgType` int(2) DEFAULT '1',
  `msgEntityID` varchar(50) DEFAULT '1',
  `msgFlagRead` tinyint(1) DEFAULT '0',
  `msgFlagImportant` tinyint(1) DEFAULT '0',
  `msgInsertBy` varchar(50) NOT NULL DEFAULT 'admin',
  `msgInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_msf`
--

DROP TABLE IF EXISTS `tbl_msf`;
CREATE TABLE `tbl_msf` (
  `msfID` int(11) NOT NULL,
  `msfGUID` char(36) DEFAULT NULL,
  `msfProfitID` int(11) DEFAULT NULL,
  `msfItemGUID` char(36) NOT NULL DEFAULT '',
  `msfScenario` varchar(20) DEFAULT NULL,
  `msfCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `msfComment` text,
  `msfFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `msfFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `msfAmount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `msfInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `msfInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msfEditBy` varchar(50) DEFAULT NULL,
  `msfEditDate` datetime DEFAULT NULL,
  `msfUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `msfTotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `msfCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_new_employee`
--

DROP TABLE IF EXISTS `tbl_new_employee`;
CREATE TABLE `tbl_new_employee` (
  `nemID` int(11) NOT NULL,
  `nemGUID` char(36) DEFAULT NULL,
  `nemScenario` varchar(20) DEFAULT NULL,
  `nemCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `nemProfitID` int(11) NOT NULL DEFAULT '1',
  `nemComment` text,
  `nemFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `nemFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `nemAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nemInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `nemInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nemEditBy` varchar(50) DEFAULT NULL,
  `nemEditDate` datetime DEFAULT NULL,
  `nemUserID` varchar(50) NOT NULL DEFAULT 'ZHURAVLEV',
  `nemHeadcount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nemClassifiedBy` varchar(50) NOT NULL DEFAULT '',
  `nemCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `tbl_port`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `tbl_port`;
CREATE TABLE `tbl_port` (
`prtID` varchar(10)
,`prtCountryID` varchar(2)
,`prtLOCODE` varchar(255)
,`prtTitleLocal` varchar(255)
,`prtTitle` varchar(255)
,`prtFlagValid` tinyint(4)
,`prtFlagDeleted` tinyint(4)
,`prtInsertBy` varchar(50)
,`prtInsertDate` datetime
,`prtEditBy` varchar(50)
,`prtEditDate` datetime
);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_rent`
--

DROP TABLE IF EXISTS `tbl_rent`;
CREATE TABLE `tbl_rent` (
  `rntID` int(11) NOT NULL,
  `rntGUID` char(36) DEFAULT NULL,
  `rntProfitID` int(11) DEFAULT NULL,
  `rntScenario` varchar(20) DEFAULT NULL,
  `rntCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `rntItemGUID` char(36) NOT NULL DEFAULT 'f0b14b32-f52b-11de-95b2-00188bc729d2',
  `rntYACT` char(6) DEFAULT NULL,
  `rntComment` text,
  `rntFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `rntFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `rntAmount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `rntInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `rntInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rntEditBy` varchar(50) DEFAULT NULL,
  `rntEditDate` datetime DEFAULT NULL,
  `rntUserID` varchar(50) NOT NULL DEFAULT 'LEVIN',
  `rntTotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rntActivityID` int(11) DEFAULT NULL,
  `rntKPIActivityID` int(11) DEFAULT NULL,
  `rntCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_route`
--

DROP TABLE IF EXISTS `tbl_route`;
CREATE TABLE `tbl_route` (
  `rteID` int(11) NOT NULL,
  `rteTitle` varchar(50) NOT NULL DEFAULT '0',
  `rteTitleLocal` varchar(100) DEFAULT NULL,
  `rteFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `rteSC_OFF` decimal(10,0) NOT NULL COMMENT 'Sales commission OFF',
  `rteSC_AFF` decimal(10,0) NOT NULL COMMENT 'Sales commission AFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_route`
--

INSERT INTO `tbl_route` (`rteID`, `rteTitle`, `rteTitleLocal`, `rteFlagDeleted`, `rteSC_OFF`, `rteSC_AFF`) VALUES
(1, 'AEWB (JPN to Europe) ', 'Япония - Европа', 0, 30, 5),
(2, 'AEWB (Asia excl. JPN to Europe)', 'Азия (кроме Японии) - Европа', 0, 30, 5),
(3, 'TAEB (North America to Europe)', 'США/Канада - Европа', 0, 30, 5),
(4, 'LATAM to Europe', 'Латинская Америка - Европа', 0, 30, 5),
(5, 'AEEB (Europe to JPN)', 'Европа - Япония', 0, 30, 5),
(6, 'AEEB (Europe to Asia excl. JPN)', 'Европа - Азия (кроме Японии)', 0, 30, 5),
(7, 'TAWB (Europe to North America)', 'Европа - США/Канада', 0, 30, 5),
(8, 'Europe to LATAM', 'Европа - Латинская Америка', 0, 30, 5),
(9, 'INTRA-EUROPE', 'Внутри Европы', 0, 20, 3),
(10, 'Africa to Europe', 'Африка - Европа', 0, 30, 5),
(11, 'Oceania to Europe', 'Океания - Европа', 0, 30, 5),
(12, ' Europe to Africa', 'Европа - Африка', 0, 30, 5),
(13, 'Europe to Oceania', 'Европа - Океания', 0, 30, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_sales`
--

DROP TABLE IF EXISTS `tbl_sales`;
CREATE TABLE `tbl_sales` (
  `salID` int(11) NOT NULL,
  `salGUID` char(36) DEFAULT NULL,
  `salScenario` varchar(20) DEFAULT NULL,
  `salCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `salProfitID` int(11) NOT NULL DEFAULT '1',
  `salCustomerID` int(11) DEFAULT NULL,
  `salProductFolderID` int(11) NOT NULL DEFAULT '1',
  `salComment` text,
  `salFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `salFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `salAmount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `salInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `salInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `salEditBy` varchar(50) DEFAULT NULL,
  `salEditDate` datetime DEFAULT NULL,
  `salUserID` varchar(50) NOT NULL DEFAULT 'ADMIN' COMMENT 'Responsible BDV FK:stbl_user',
  `salPSProfitID` int(11) DEFAULT NULL,
  `salPSRate` int(11) NOT NULL DEFAULT '0',
  `salRoute` int(11) DEFAULT NULL,
  `salJO` int(11) DEFAULT NULL COMMENT 'Job owner',
  `salDA` int(11) DEFAULT NULL COMMENT 'Destination agent',
  `salBO` int(11) DEFAULT NULL COMMENT 'Business owner',
  `salCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original',
  `salGBR` int(11) DEFAULT NULL,
  `salPOL` varchar(5) DEFAULT NULL,
  `salPOD` varchar(5) DEFAULT NULL,
  `salGHQ` varchar(50) DEFAULT NULL,
  `salPrdIdxLeft` int(11) DEFAULT NULL,
  `salPrdIdxRight` int(11) DEFAULT NULL,
  `salRevenue` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Total revenue',
  `salKg` int(11) DEFAULT NULL,
  `salTEU` int(11) DEFAULT NULL,
  `salFlagNew` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_scenario`
--

DROP TABLE IF EXISTS `tbl_scenario`;
CREATE TABLE `tbl_scenario` (
  `scnID` varchar(20) NOT NULL,
  `scnFlagReadOnly` tinyint(1) NOT NULL DEFAULT '0',
  `scnTitle` varchar(255) NOT NULL,
  `scnTitleLocal` varchar(512) NOT NULL,
  `scnYear` year(4) NOT NULL,
  `scnDateStart` date DEFAULT NULL COMMENT 'Start date for estimated figures',
  `scnTotal` decimal(15,2) DEFAULT NULL COMMENT '[Deprecated] Jan-Dec total',
  `scnTotalAM` decimal(15,2) DEFAULT NULL COMMENT 'April-March totals from reg_master',
  `scnEditBy` varchar(50) DEFAULT NULL,
  `scnEditDate` datetime DEFAULT NULL,
  `scnInsertBy` varchar(50) DEFAULT NULL,
  `scnInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `scnFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `scnGUID` char(36) NOT NULL,
  `scnLastSource` char(36) DEFAULT NULL COMMENT 'GUID of last document that modified the scenario',
  `scnType` enum('Budget','FYE','Actual','Budget_AM','FYE_AM','Actual_AM') NOT NULL DEFAULT 'Budget',
  `scnFlagArchive` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Removes scenario from select boxes',
  `scnLastID` varchar(50) DEFAULT NULL COMMENT 'Default reference scenario',
  `scnLength` int(10) NOT NULL DEFAULT '12' COMMENT '[Deprecated] Financial year length',
  `scnChecksum` char(32) DEFAULT NULL COMMENT 'Hash of scenario figures, used to renew reg_summary',
  `scnNextID` varchar(50) DEFAULT NULL,
  `scnFlagPublic` tinyint(4) NOT NULL DEFAULT '0',
  `scnForecastID` varchar(50) DEFAULT NULL,
  `scnLastYearID` varchar(50) DEFAULT NULL,
  `scnDeadline` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_scenario_variable`
--

DROP TABLE IF EXISTS `tbl_scenario_variable`;
CREATE TABLE `tbl_scenario_variable` (
  `scvID` int(11) NOT NULL,
  `scvVariableID` varchar(50) NOT NULL,
  `scvScenarioID` varchar(20) NOT NULL,
  `scvValue` varchar(255) NOT NULL,
  `scvEditBy` varchar(50) DEFAULT NULL,
  `scvEditDate` datetime DEFAULT NULL,
  `scvInsertBy` varchar(50) DEFAULT NULL,
  `scvInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `scvFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `scvGUID` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_setup`
--

DROP TABLE IF EXISTS `tbl_setup`;
CREATE TABLE `tbl_setup` (
  `stpID` int(11) NOT NULL,
  `stpVarName` varchar(255) DEFAULT NULL,
  `stpCharType` varchar(20) DEFAULT NULL,
  `stpCharValue` varchar(512) DEFAULT NULL,
  `stpFlagReadOnly` tinyint(4) DEFAULT NULL,
  `stpNGroup` int(11) DEFAULT NULL,
  `stpCharName` varchar(255) DEFAULT NULL,
  `stpInsertBy` varchar(50) DEFAULT NULL,
  `stpInsertDate` datetime DEFAULT NULL,
  `stpEditBy` varchar(50) DEFAULT NULL,
  `stpEditDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_setup`
--

INSERT INTO `tbl_setup` (`stpID`, `stpVarName`, `stpCharType`, `stpCharValue`, `stpFlagReadOnly`, `stpNGroup`, `stpCharName`, `stpInsertBy`, `stpInsertDate`, `stpEditBy`, `stpEditDate`) VALUES
(1, 'stpLocalCurr', 'varchar', 'RUB', 1, NULL, 'Local currency', 'admin', '2008-06-24 18:34:20', 'zhuravlev', '2008-07-24 16:52:36'),
(2, 'stpCompanyName', 'text', 'OOO Yusen Logistics Rus', 0, NULL, 'Company name', 'admin', '2008-06-26 14:27:52', 'zhuravlev', '2009-11-02 09:33:11'),
(3, 'stpLocalCurrLocal', 'varchar', 'руб.', 1, NULL, 'Национальная валюта', 'admin', '2008-06-26 14:29:11', 'zhuravlev', '2008-07-24 16:45:01'),
(4, 'stpCompanyNameLocal', 'text', 'Общество с ограниченной ответственностью \"Юсен Лоджистикс Рус\"', 0, NULL, 'Наменование компании', 'admin', '2008-06-27 10:34:45', 'zhuravlev', '2009-11-02 09:48:11'),
(5, 'stpMDLocal', 'varchar', 'Холявенко М.Ю.', 0, NULL, 'Генеральный директор', 'admin', '2008-06-27 23:25:52', 'zhuravlev', '2008-07-24 16:45:01'),
(6, 'stpCALocal', 'varchar', 'Шакирова О.Р.', 0, NULL, 'Главный бухгалтер', 'admin', '2008-06-27 23:25:52', 'zhuravlev', '2008-10-14 12:05:40'),
(7, 'stpMD', 'varchar', 'Kholyavenko M.U.', 0, NULL, 'Managing director', 'admin', '2008-06-27 23:25:52', 'zhuravlev', '2008-07-24 16:45:01'),
(8, 'stpCA', 'varchar', 'Shakirova O.R.', 0, NULL, 'Chief accountant', 'admin', '2008-06-27 23:25:52', 'zhuravlev', '2009-08-05 11:47:21'),
(9, 'stpPhone', 'varchar', '+7(495)775-07-39', 0, NULL, 'Телефон', 'admin', '2008-06-27 23:25:52', 'zhuravlev', '2008-07-24 16:49:19'),
(13, 'stpMailPrefix', 'varchar', '[Treasury]', 0, NULL, 'Префикс почты', 'Igor.Zhuravlev', '2008-07-09 12:45:22', 'zhuravlev', '2008-07-24 16:45:01'),
(14, 'stpLocalCurrencyCode', 'varchar', '643', 0, NULL, 'Код валюты', 'Igor.Zhuravlev', '2008-07-11 07:28:19', 'zhuravlev', '2008-07-24 16:45:01'),
(17, 'stpINN', 'varchar', '7734515704', 0, NULL, 'ИНН', 'zhuravlev', '2008-09-03 14:11:32', 'zhuravlev', '2008-09-03 14:11:32'),
(18, 'stpKPP', 'varchar', '771001001', 0, NULL, 'КПП', 'zhuravlev', '2008-09-03 14:11:32', 'zhuravlev', '2008-09-03 14:11:32'),
(20, 'stpIntraPath', 'varchar', '../common/', 0, NULL, 'Path to INTRA components', 'zhuravlev', '2009-08-03 20:40:33', 'zhuravlev', '2009-08-05 11:42:00'),
(27, 'stpUploadPath', 'text', 'c:/wwwfiles/treasury/', 0, NULL, 'Upload path', 'admin', '2011-03-03 21:16:58', 'admin', '2011-03-03 21:17:03'),
(28, 'stpSMTPAddress', 'varchar', 'localhost', 0, NULL, 'SMTP Server address', NULL, NULL, NULL, NULL),
(34, 'stpScenarioID', 'varchar', 'B2019_2', 0, NULL, 'Current budget scenario', 'admin', '2013-11-27 17:17:09', 'ZHURAVLEV', '2019-05-21 13:28:33'),
(35, 'stpFYEID', 'varchar', 'FYE_19_Jul', 0, NULL, 'Current FYE scenario', 'admin', '2015-06-16 08:38:59', 'ZHURAVLEV', '2019-07-30 10:10:49');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_unknown`
--

DROP TABLE IF EXISTS `tbl_unknown`;
CREATE TABLE `tbl_unknown` (
  `cntID` int(11) NOT NULL DEFAULT '0',
  `cntTitle` varchar(255) DEFAULT NULL,
  `cntTitleLocal` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_variable`
--

DROP TABLE IF EXISTS `tbl_variable`;
CREATE TABLE `tbl_variable` (
  `varID` varchar(50) NOT NULL,
  `varTitle` varchar(255) NOT NULL,
  `varTitleLocal` varchar(512) NOT NULL DEFAULT '',
  `varType` varchar(20) NOT NULL,
  `varEditBy` varchar(50) DEFAULT NULL,
  `varEditDate` datetime DEFAULT NULL,
  `varInsertBy` varchar(50) DEFAULT NULL,
  `varInsertDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `varFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `varGUID` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_variable`
--

INSERT INTO `tbl_variable` (`varID`, `varTitle`, `varTitleLocal`, `varType`, `varEditBy`, `varEditDate`, `varInsertBy`, `varInsertDate`, `varFlagDeleted`, `varGUID`) VALUES
('Air export_growth', 'Air export growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96db2b-a768-11e7-addd-000d3ab33059'),
('Air import_growth', 'Air import growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96dbf3-a768-11e7-addd-000d3ab33059'),
('canteen_bc', 'Canteen for blue collars', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:39:11', 0, '9b31eb70-37e9-11e3-a1af-870894ce4e19'),
('canteen_wc', 'Canteen for white collars', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:39:09', 0, '9a3865e1-37e9-11e3-a1af-870894ce4e19'),
('clothes_profile_1', 'Clothes set #1', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:39:23', 0, 'a2997de0-37e9-11e3-a1af-870894ce4e19'),
('clothes_profile_2', 'Clothes set #2', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:39:29', 0, 'a5c2629e-37e9-11e3-a1af-870894ce4e19'),
('clothes_profile_3', 'Clothes set #3', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:39:31', 0, 'a6ddd888-37e9-11e3-a1af-870894ce4e19'),
('eur', 'EUR rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:35:04', 0, '086e00a9-37e9-11e3-a1af-870894ce4e19'),
('executive_bonus_avg', 'Executive bonus average', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:38:09', 0, '7649429b-37e9-11e3-a1af-870894ce4e19'),
('executive_bonus_base', 'Executive bonus index', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:38:06', 0, '747a628a-37e9-11e3-a1af-870894ce4e19'),
('gbp', 'GBP Rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:35:17', 0, '1024f0cb-37e9-11e3-a1af-870894ce4e19'),
('hiring', 'Hiring cost', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:36:59', 0, '4c95137c-37e9-11e3-a1af-870894ce4e19'),
('inflation', 'Inflation', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:36:34', 0, '3d9dcd56-37e9-11e3-a1af-870894ce4e19'),
('jpy', 'JPY rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:35:22', 0, '130777da-37e9-11e3-a1af-870894ce4e19'),
('kzt', 'KZT rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:35:09', 0, '0b709a3a-37e9-11e3-a1af-870894ce4e19'),
('Land transport_growth', 'Land transport growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96dc78-a768-11e7-addd-000d3ab33059'),
('medical_insurance_expiry', 'DMS expiry date', '', 'date', NULL, NULL, NULL, '2013-11-11 11:49:46', 0, 'A79FA005-3976-4CB6-9707-D56CD3E73D2F'),
('medical_insurance_index', 'DMS Inflation', '', 'decimal', NULL, NULL, NULL, '2013-11-11 11:49:17', 0, '3BD3A123-E574-4225-989D-E461EFD9E7A3'),
('Ocean export_growth', 'Ocean export growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96dceb-a768-11e7-addd-000d3ab33059'),
('Ocean import_growth', 'Ocean import growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96de3f-a768-11e7-addd-000d3ab33059'),
('OCM_growth', 'OCM growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96df27-a768-11e7-addd-000d3ab33059'),
('Other_growth', 'Other growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96e012-a768-11e7-addd-000d3ab33059'),
('pc_profile_1', 'PC set #1', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:38:52', 0, '8fd27667-37e9-11e3-a1af-870894ce4e19'),
('pc_profile_2', 'PC set #2', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:38:54', 0, '90e07f50-37e9-11e3-a1af-870894ce4e19'),
('pc_profile_3', 'PC set #3', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:38:55', 0, '91dc6cf9-37e9-11e3-a1af-870894ce4e19'),
('PS_Scheme', 'Profit share scheme', 'Схема распределения прибыли', 'varchar', NULL, NULL, 'ZHURAVLEV', '2017-12-15 09:16:38', 0, 'a77fa8f6-e178-11e7-9691-000d3ab33059'),
('regular_bonus_avg', 'Regular bonus average', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:37:55', 0, '6e1693c5-37e9-11e3-a1af-870894ce4e19'),
('regular_bonus_base', 'Regular bonus index', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:37:45', 0, '684424be-37e9-11e3-a1af-870894ce4e19'),
('rub', 'Ruble rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-22 09:08:50', 0, 'E3DFF71A-C456-40FA-9C7A-6DB420CA81CD'),
('salary_increase_ratio', 'Salary increase index', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:33:35', 0, 'FAAD3FB4-BEBE-4D94-B726-F0D618A630B7'),
('salary_review_month', 'Month for salary review', ' ', 'int', NULL, NULL, 'zhuravlev', '2013-10-18 07:32:22', 0, '4A2213E8-0E2E-4E9B-BB12-A2CA17AE4818'),
('social_cap', 'Social tax cap', '', 'decimal', NULL, NULL, NULL, '2013-10-31 03:48:51', 0, '5EF38F3F-140A-4833-8FE5-AEB1C23FF7B9'),
('social_cap_fss', 'FSS cap', '', 'decimal', NULL, NULL, NULL, '2015-11-09 07:35:57', 0, '833baf3e-86b4-11e5-837c-b0c5c9a0c4f5'),
('social_cap_pfr', 'PFR cap', '', 'decimal', NULL, NULL, NULL, '2015-11-09 07:34:02', 0, '3e70c160-86b4-11e5-837c-b0c5c9a0c4f5'),
('social_rate_foms', 'FOMS rate', '', 'decimal', NULL, NULL, NULL, '2015-11-09 07:37:57', 0, 'cace6758-86b4-11e5-837c-b0c5c9a0c4f5'),
('social_rate_fss', 'FSS rate', '', 'decimal', NULL, NULL, NULL, '2015-11-09 07:37:31', 0, 'bb416886-86b4-11e5-837c-b0c5c9a0c4f5'),
('social_rate_pfr', 'PFR rate', '', 'decimal', NULL, NULL, NULL, '2015-11-09 07:36:39', 0, '9c5884fd-86b4-11e5-837c-b0c5c9a0c4f5'),
('social_tax_1', 'Social tax rate #1', '', 'decimal', NULL, NULL, NULL, '2013-10-31 04:29:39', 0, '550A3C05-68BE-4063-A62D-39FE18ECE526'),
('social_tax_2', 'Social tax rate #2', '', 'decimal', NULL, NULL, NULL, '2013-10-31 04:30:18', 0, '07C365AB-2A63-4141-87FA-D1E02FEEDAC8'),
('social_tax_accident', 'Accident_rate', '', 'decimal', NULL, NULL, NULL, '2013-10-31 08:30:36', 0, 'A7CB2B0E-0669-4F58-ADD7-51D785AA07DC'),
('usd', 'USD rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:34:20', 0, '5FF37353-D055-4E2B-9EFC-989AD6BA6C58'),
('Warehouse_growth', 'Warehouse growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96e07e-a768-11e7-addd-000d3ab33059'),
('xcu', 'XCU rate', '', 'decimal', NULL, NULL, 'zhuravlev', '2013-10-18 07:36:13', 0, '319adff4-37e9-11e3-a1af-870894ce4e19'),
('_growth', ' growth,%', '', 'decimal', NULL, NULL, NULL, '2017-10-02 11:55:11', 0, '8b96b3c4-a768-11e7-addd-000d3ab33059');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_vehicle`
--

DROP TABLE IF EXISTS `tbl_vehicle`;
CREATE TABLE `tbl_vehicle` (
  `vehID` int(11) NOT NULL,
  `vehGUID` char(36) DEFAULT NULL,
  `vehScenario` varchar(20) DEFAULT NULL,
  `vehCompanyID` int(9) UNSIGNED ZEROFILL NOT NULL DEFAULT '000000001',
  `vehProfitID` int(11) NOT NULL DEFAULT '0',
  `vehComment` text,
  `vehFlagDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `vehFlagPosted` tinyint(4) NOT NULL DEFAULT '0',
  `vehAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehInsertBy` varchar(50) NOT NULL DEFAULT 'zhuravlev',
  `vehInsertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vehEditBy` varchar(50) DEFAULT NULL,
  `vehEditDate` datetime DEFAULT NULL,
  `vehUserID` varchar(50) NOT NULL DEFAULT 'LEVIN',
  `vehCASCO` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehOSAGO` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehRun` int(11) NOT NULL DEFAULT '0',
  `vehConsumption` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehFuelPrice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehWash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehMaintenance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehConsumables` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehPower` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vehFlagOffice` tinyint(1) NOT NULL DEFAULT '0',
  `vehCopyOf` int(11) DEFAULT NULL COMMENT 'Reference to original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_active_scenario`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_active_scenario`;
CREATE TABLE `vw_active_scenario` (
`scnID` varchar(20)
,`scnFlagReadOnly` tinyint(1)
,`scnTitle` varchar(255)
,`scnTitleLocal` varchar(512)
,`scnYear` year(4)
,`scnDateStart` date
,`scnTotal` decimal(15,2)
,`scnEditBy` varchar(50)
,`scnEditDate` datetime
,`scnInsertBy` varchar(50)
,`scnInsertDate` timestamp
,`scnFlagDeleted` tinyint(4)
,`scnGUID` char(36)
,`scnLastSource` char(36)
,`scnType` enum('Budget','FYE','Actual','Budget_AM','FYE_AM','Actual_AM')
,`scnFlagArchive` tinyint(1)
,`scnLastID` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_company`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_company`;
CREATE TABLE `vw_company` (
`comID` int(9) unsigned zerofill
,`comGUID` char(36)
,`comTitle` varchar(50)
,`comTitleLocal` varchar(100)
,`comTitleShort` varchar(50)
,`comINN` varchar(10)
,`comKPP` varchar(9)
,`comOGRN` varchar(50)
,`comAddress` varchar(1024)
,`comAddressLocal` varchar(1024)
,`comGeneralManager` varchar(255)
,`comGeneralManagerLocal` varchar(255)
,`comChiefAccountant` varchar(255)
,`comChiefAccountantLocal` varchar(255)
,`comFlagDeleted` tinyint(1)
,`comInsertBy` varchar(50)
,`comInsertDate` timestamp
,`comEditBy` varchar(50)
,`comEditDate` datetime
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_counterparty`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_counterparty`;
CREATE TABLE `vw_counterparty` (
`cntID` int(11)
,`cntTitle` varchar(255)
,`cntTitleLocal` varchar(512)
,`cntFlagDeleted` tinyint(1)
,`cntFlagConfirmed` tinyint(1)
,`cntINN` char(12)
,`cntKPP` char(10)
,`cntID1C` varchar(5)
,`cntOGRN` char(13)
,`cntParentID` int(11)
,`cntParentID1C` char(36)
,`cntParentCode1C` varchar(9)
,`cntCode1C` varchar(20)
,`cntGDS` varchar(10)
,`cntYUNAS` varchar(15)
,`cntGDSCountry` char(2)
,`cntGDSCity` char(3)
,`cntFlagFolder` tinyint(1) unsigned
,`cntFlagCustomer` tinyint(1) unsigned
,`cntFlagSupplier` tinyint(1) unsigned
,`cntBalanceCustomer` decimal(15,2)
,`cntBalanceSupplier` decimal(15,2)
,`cntUserID` varchar(50)
,`cntOperationsID` varchar(50)
,`cntAccountantID` varchar(50)
,`cntCostID` int(11)
,`cntProfitID` int(11)
,`cntCreditDays` tinyint(4)
,`cntFile` varchar(512)
,`cntFlagBankingDays` tinyint(1)
,`cntCitiProfile` varchar(35)
,`cntTitleFullLocal` varchar(400)
,`cntFlagSpecs` tinyint(4)
,`cntAccountID1C` varchar(4)
,`cntAccountCode1C` varchar(9)
,`cntFlagNR` tinyint(4)
,`cntCustomerID` mediumint(9)
,`cntAgreementID` mediumint(9)
,`cntAddress` varchar(512)
,`cntLegalAddress` varchar(512)
,`cntContact` varchar(255)
,`cntPhone` varchar(30)
,`cntFax` varchar(30)
,`cntEmailBilling` varchar(255)
,`cntLocationID` varchar(20)
,`cntGUID` char(36)
,`cntGUID1C` char(36)
,`cntCurConvert` smallint(6)
,`cntOurbankaccountID` tinyint(4)
,`cntReasonID` smallint(6)
,`cntFlagRequest` tinyint(1)
,`cntPrefix` varchar(3)
,`cntCalcDate` varchar(20)
,`cntInsertBy` varchar(50)
,`cntInsertDate` datetime
,`cntEditBy` varchar(50)
,`cntEditDate` datetime
,`cntTaxcomID` char(46)
,`cntIdxLeft` int(11)
,`cntIdxRight` int(11)
,`cntFlagGBR` tinyint(1)
,`cntComment` text
,`cntFlagDissolved` tinyint(4)
,`cntFlagDissolving` tinyint(4)
,`cntDissolvedDate` date
,`cntGroupID` int(11)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_currency`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_currency`;
CREATE TABLE `vw_currency` (
`curID` int(11)
,`curTitle` varchar(255)
,`curTitleLocal` varchar(512)
,`curFlagDeleted` tinyint(1)
,`curInsertBy` varchar(50)
,`curInsertDate` datetime
,`curEditBy` varchar(50)
,`curEditDate` datetime
,`curRate` decimal(11,4)
,`curDecRate` smallint(6)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_customer`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_customer`;
CREATE TABLE `vw_customer` (
`cntID` int(11)
,`cntTitle` varchar(255)
,`cntTitleLocal` varchar(512)
,`cntFlagDeleted` tinyint(1)
,`cntFlagConfirmed` tinyint(1)
,`cntINN` char(12)
,`cntKPP` char(10)
,`cntID1C` varchar(5)
,`cntOGRN` char(13)
,`cntParentID` int(11)
,`cntParentID1C` char(36)
,`cntParentCode1C` varchar(9)
,`cntCode1C` varchar(20)
,`cntGDS` varchar(10)
,`cntGDSCountry` char(2)
,`cntGDSCity` char(3)
,`cntFlagFolder` tinyint(1) unsigned
,`cntFlagCustomer` tinyint(1) unsigned
,`cntFlagSupplier` tinyint(1) unsigned
,`cntBalanceCustomer` decimal(15,2)
,`cntBalanceSupplier` decimal(15,2)
,`cntUserID` varchar(50)
,`cntAccountantID` varchar(50)
,`cntCostID` int(11)
,`cntProfitID` int(11)
,`cntCreditDays` tinyint(4)
,`cntFile` varchar(512)
,`cntFlagBankingDays` tinyint(1)
,`cntCitiProfile` varchar(35)
,`cntTitleFullLocal` varchar(400)
,`cntFlagSpecs` tinyint(4)
,`cntAccountID1C` varchar(4)
,`cntAccountCode1C` varchar(9)
,`cntFlagNR` tinyint(4)
,`cntCustomerID` mediumint(9)
,`cntAgreementID` mediumint(9)
,`cntAddress` varchar(512)
,`cntLegalAddress` varchar(512)
,`cntContact` varchar(255)
,`cntPhone` varchar(30)
,`cntFax` varchar(30)
,`cntEmailBilling` varchar(255)
,`cntLocationID` varchar(20)
,`cntGUID` char(36)
,`cntGUID1C` char(36)
,`cntCurConvert` smallint(6)
,`cntOurbankaccountID` tinyint(4)
,`cntReasonID` smallint(6)
,`cntFlagRequest` tinyint(1)
,`cntPrefix` varchar(3)
,`cntCalcDate` varchar(20)
,`cntInsertBy` varchar(50)
,`cntInsertDate` datetime
,`cntEditBy` varchar(50)
,`cntEditDate` datetime
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_employee`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_employee`;
CREATE TABLE `vw_employee` (
`empID` int(11)
,`empManagerID` int(11)
,`empTitle` varchar(255)
,`empTitleLocal` varchar(255)
,`empUserID` varchar(50)
,`empTitleGenitive` varchar(255)
,`empTitleDative` varchar(255)
,`empTitleAccusative` varchar(255)
,`empTitleInstrumental` varchar(255)
,`empTitlePrepositional` varchar(255)
,`empFunctionGUID` char(36)
,`empFunction` varchar(512)
,`empFile` varchar(512)
,`empFunctionLocal` varchar(512)
,`empFlagDeleted` tinyint(4) unsigned
,`empGender` enum('1','0')
,`empBirthDate` date
,`empFlagNR` tinyint(4)
,`empStartDate` date
,`empEndDate` date
,`empINN` varchar(12)
,`empPFR` varchar(11)
,`empID1C` varchar(5)
,`empCode1C` varchar(10)
,`empFlagFolder` tinyint(1)
,`empParentID1C` varchar(5)
,`empGUID` char(36)
,`empGUID1C` char(36)
,`empBranchID` int(11)
,`empProfitID` int(11)
,`empFlagTD` tinyint(4)
,`empFlagEO` tinyint(4)
,`empFlagTK` tinyint(4)
,`empFlagEducation` tinyint(4)
,`empFlagPassport` tinyint(4)
,`empFlagMilitary` tinyint(4)
,`empFlagMarriage` tinyint(4)
,`empFlagBirth` tinyint(4)
,`empDocSeries` varchar(10)
,`empDocNumber` varchar(10)
,`empDocDate` date
,`empDocIssuer` mediumtext
,`empAddress` varchar(512)
,`empActualAddress` varchar(512)
,`empPhone` varchar(20)
,`empTitleFullLocal` varchar(255)
,`empAccount` char(23)
,`empBeneficiary` varchar(255)
,`empBeneficiaryINN` varchar(12)
,`empNok1` varchar(255)
,`empNokPhone1` varchar(30)
,`empNokRelation1` varchar(30)
,`empNokAddress1` varchar(512)
,`empNok2` varchar(255)
,`empNokPhone2` varchar(30)
,`empNokRelation2` varchar(30)
,`empNokAddress2` varchar(512)
,`empBankID` char(9)
,`empPaymentOptions` varchar(512)
,`empVacationBalance` decimal(6,2)
,`empManagerID1C` varchar(5)
,`empInsertBy` varchar(50)
,`empInsertDate` timestamp
,`empEditBy` varchar(50)
,`empEditDate` datetime
,`empSalary` decimal(14,2) unsigned
,`empProbationDate` date
,`empPhoto` varchar(255)
,`empDayoffBalance` smallint(11)
,`empLocationID` int(10)
,`empCustomerID` int(10)
,`empProductTypeID` int(10)
,`empYACT` char(6)
,`empMobileLimit` decimal(10,2)
,`empFTE` decimal(5,3)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_employee_select`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_employee_select`;
CREATE TABLE `vw_employee_select` (
`empSkill` decimal(10,2)
,`empID` int(11)
,`empStartDate` date
,`empEndDate` date
,`empGUID1C` char(36)
,`empTitleLocal` varchar(255)
,`empTitle` varchar(255)
,`empFlagDeleted` tinyint(4) unsigned
,`empProfitID` int(11)
,`funTitle` varchar(70)
,`funFlagWC` tinyint(1)
,`funMobile` decimal(10,2)
,`funFuel` decimal(10,2)
,`locTitle` varchar(50)
,`empSalary` decimal(14,2) unsigned
,`empFunctionGUID` char(36)
,`empLocationID` int(10)
,`empProductTypeID` int(10)
,`empMobileLimit` decimal(10,2)
,`empMonthly` decimal(10,2)
,`empSalaryRevision` date
,`funFlagSGA` tinyint(1)
,`funBonus` int(11)
,`empFTE` decimal(5,3)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_fixed_assets`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_fixed_assets`;
CREATE TABLE `vw_fixed_assets` (
`fixID` varchar(9)
,`fixGUID` char(36)
,`fixTitle` varchar(255)
,`fixTitleLocal` varchar(512)
,`fixPlateNo` varchar(50)
,`fixVIN` varchar(50)
,`fixDeprStart` date
,`fixDeprEnd` date
,`fixDeprDuration` tinyint(4)
,`fixValueStart` decimal(15,2)
,`fixEmployeeGUID` char(36)
,`fixProfitID` int(11)
,`fixYACT` char(6)
,`fixItemID` int(11)
,`fixProductTypeID` int(11)
,`fixParentID` varchar(9)
,`fixIdxLeft` int(11)
,`fixIdxRight` int(11)
,`fixFlagFolder` tinyint(4)
,`fixFlagDeleted` tinyint(4)
,`fixInsertBy` varchar(50)
,`fixInsertDate` timestamp
,`fixEditBy` varchar(50)
,`fixEditDate` datetime
,`fixCompanyID` int(9) unsigned zerofill
,`fixLocationID` int(10)
);

-- --------------------------------------------------------

--
-- Структура таблицы `vw_folder`
--

DROP TABLE IF EXISTS `vw_folder`;
CREATE TABLE `vw_folder` (
  `prdID` int(11) NOT NULL,
  `prdTitle` varchar(255) NOT NULL,
  `prdTitleLocal` varchar(512) NOT NULL,
  `prdParentID` int(11) DEFAULT NULL,
  `prdLevelInside` bigint(21) NOT NULL,
  `prdFlagDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_function`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_function`;
CREATE TABLE `vw_function` (
`funID` varchar(9)
,`funGUID` char(36)
,`funFlagDeleted` tinyint(1)
,`funTitle` varchar(70)
,`funTitleLocal` varchar(255)
,`funFlagWC` tinyint(1)
,`funInsertBy` varchar(50)
,`funInsertDate` timestamp
,`funEditBy` varchar(50)
,`funEditDate` datetime
,`funComment` mediumtext
,`funMobile` decimal(10,2)
,`funFuel` decimal(10,2)
,`funRHQ` varchar(10)
,`funFlagSGA` tinyint(1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_headcount`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_headcount`;
CREATE TABLE `vw_headcount` (
`scenario` varchar(20)
,`company` int(9) unsigned zerofill
,`empCode1C` varchar(10)
,`empTitleLocal` varchar(255)
,`empSalary` decimal(14,2) unsigned
,`prtGHQ` varchar(50)
,`prtRHQ` varchar(50)
,`Location` varchar(50)
,`prtTitle` varchar(255)
,`function` char(36)
,`funRHQ` varchar(10)
,`funTitle` varchar(70)
,`funTitleLocal` varchar(255)
,`pc` int(11)
,`pccTitle` varchar(255)
,`pccTitleLocal` varchar(512)
,`pccFlagProd` tinyint(1)
,`pccParentCode1C` varchar(9)
,`wc` tinyint(1)
,`salary` decimal(10,2)
,`new_fte` decimal(10,1)
,`vks` tinyint(1)
,`start_date` date
,`end_date` date
,`sales` varchar(50)
,`bdv` int(11)
,`source` char(36)
,`activity` bigint(11)
,`jan` decimal(10,2)
,`feb` decimal(10,2)
,`mar` decimal(10,2)
,`apr` decimal(10,2)
,`may` decimal(10,2)
,`jun` decimal(10,2)
,`jul` decimal(10,2)
,`aug` decimal(10,2)
,`sep` decimal(10,2)
,`oct` decimal(10,2)
,`nov` decimal(10,2)
,`dec` decimal(10,2)
,`jan_1` decimal(10,2)
,`feb_1` decimal(10,2)
,`mar_1` decimal(10,2)
,`Q1` decimal(16,6)
,`Q2` decimal(16,6)
,`Q3` decimal(16,6)
,`Q4` decimal(16,6)
,`Q5` decimal(16,6)
,`Total` decimal(25,6)
,`Total_AM` decimal(25,6)
,`new` decimal(10,1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_insurance`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_insurance`;
CREATE TABLE `vw_insurance` (
`dmsID` varchar(50)
,`dmsTitle` varchar(50)
,`locTitle` varchar(50)
,`dmsPrice` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_item`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_item`;
CREATE TABLE `vw_item` (
`itmID` int(11)
,`itmGUID` char(36)
,`itmTitle` varchar(50)
,`itmTitleLocal` varchar(100)
,`itmParentID` int(11)
,`itmFlagFolder` tinyint(4)
,`itmFlagDeleted` tinyint(4)
,`itmInsertBy` varchar(50)
,`itmInsertDate` timestamp
,`itmEditBy` varchar(50)
,`itmEditDate` datetime
,`itmYACTProd` char(6)
,`itmYACTCorp` char(6)
,`itmOrder` int(11)
,`yctTitle` varchar(255)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_journal`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_journal`;
CREATE TABLE `vw_journal` (
`id` int(11)
,`guid` char(36)
,`posted` tinyint(4)
,`deleted` tinyint(4)
,`comment` mediumtext
,`insert_by` varchar(50)
,`insert_date` timestamp
,`edit_by` varchar(50)
,`edit_date` datetime
,`title` varchar(18)
,`prefix` varchar(3)
,`pc` int(11)
,`table` varchar(20)
,`script` varchar(25)
,`scenario` varchar(20)
,`amount` decimal(15,2)
,`responsible` varchar(50)
,`PL` varchar(255)
,`copy_of` int(11)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_location`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_location`;
CREATE TABLE `vw_location` (
`locID` int(10)
,`locGUID` char(36)
,`locTitle` varchar(50)
,`locTitleLocal` varchar(150)
,`locKPP` char(9)
,`locAddress` varchar(100)
,`locAddressLocal` varchar(200)
,`locZip` varchar(10)
,`locCity` varchar(30)
,`locCityLocal` varchar(60)
,`locPhone` varchar(60)
,`locFax` varchar(60)
,`locCountry` char(2)
,`locInsertBy` varchar(50)
,`locInsertDate` timestamp
,`locEditBy` varchar(50)
,`locEditDate` datetime
,`locFlagDeleted` tinyint(1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_master`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_master`;
CREATE TABLE `vw_master` (
`company` int(9) unsigned zerofill
,`pc` int(11)
,`activity` int(11)
,`customer` int(11)
,`account` varchar(6)
,`item` char(36)
,`jan` decimal(15,2)
,`feb` decimal(15,2)
,`mar` decimal(15,2)
,`apr` decimal(15,2)
,`may` decimal(15,2)
,`jun` decimal(15,2)
,`jul` decimal(15,2)
,`aug` decimal(15,2)
,`sep` decimal(15,2)
,`oct` decimal(15,2)
,`nov` decimal(15,2)
,`dec` decimal(15,2)
,`jan_1` decimal(15,2)
,`feb_1` decimal(15,2)
,`mar_1` decimal(15,2)
,`source` char(36)
,`scenario` varchar(20)
,`particulars` char(36)
,`part_type` enum('FIX','EMP','SUP','FUT')
,`estimate` decimal(15,2)
,`vat` int(11) unsigned
,`deductible` tinyint(4)
,`cf` tinyint(4)
,`timestamp` timestamp
,`Total` decimal(26,2)
,`Total_15` decimal(29,2)
,`Total_AM` decimal(26,2)
,`Q1` decimal(17,2)
,`Q2` decimal(17,2)
,`Q3` decimal(17,2)
,`Q4` decimal(17,2)
,`Q5` decimal(17,2)
,`YTD` decimal(15,2)
,`ROY` decimal(15,2)
,`Budget item` varchar(50)
,`Group` varchar(50)
,`Group_code` int(11)
,`itmOrder` int(11)
,`Profit` varchar(255)
,`ProfitLocal` varchar(512)
,`Title` varchar(255)
,`Customer_name` varchar(255)
,`customer_group_code` int(11)
,`customer_group_title` varchar(255)
,`Activity_title` varchar(255)
,`Activity_title_local` varchar(512)
,`prtRHQ` varchar(50)
,`prtGHQ` varchar(50)
,`pccFlagProd` tinyint(1)
,`yact_group` varchar(255)
,`yact_group_code` varchar(6)
,`sales` varchar(50)
,`usrTitle` varchar(70)
,`bdv` int(11)
,`bdvTitle` varchar(255)
,`bu_group` varchar(9)
,`bu_group_title` varchar(255)
,`ivlTitle` varchar(50)
,`ivlGroup` varchar(50)
,`ivlGUID` char(36)
,`new` tinyint(4)
,`Activity_titleLocal` varchar(512)
,`cntYear` int(11)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_pb_intercompany`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_pb_intercompany`;
CREATE TABLE `vw_pb_intercompany` (
`cntID` int(11)
,`cntTitle` varchar(255)
,`cntTitleLocal` varchar(512)
,`cntFlagDeleted` tinyint(1)
,`cntFlagConfirmed` tinyint(1)
,`cntINN` char(12)
,`cntKPP` char(10)
,`cntID1C` varchar(5)
,`cntOGRN` char(13)
,`cntParentID` int(11)
,`cntParentID1C` char(36)
,`cntParentCode1C` varchar(9)
,`cntCode1C` varchar(20)
,`cntGDS` varchar(10)
,`cntGDSCountry` char(2)
,`cntGDSCity` char(3)
,`cntFlagFolder` tinyint(1) unsigned
,`cntFlagCustomer` tinyint(1) unsigned
,`cntFlagSupplier` tinyint(1) unsigned
,`cntBalanceCustomer` decimal(15,2)
,`cntBalanceSupplier` decimal(15,2)
,`cntUserID` varchar(50)
,`cntOperationsID` varchar(50)
,`cntAccountantID` varchar(50)
,`cntCostID` int(11)
,`cntProfitID` int(11)
,`cntCreditDays` tinyint(4)
,`cntFile` varchar(512)
,`cntFlagBankingDays` tinyint(1)
,`cntCitiProfile` varchar(35)
,`cntTitleFullLocal` varchar(400)
,`cntFlagSpecs` tinyint(4)
,`cntAccountID1C` varchar(4)
,`cntAccountCode1C` varchar(9)
,`cntFlagNR` tinyint(4)
,`cntCustomerID` mediumint(9)
,`cntAgreementID` mediumint(9)
,`cntAddress` varchar(512)
,`cntLegalAddress` varchar(512)
,`cntContact` varchar(255)
,`cntPhone` varchar(30)
,`cntFax` varchar(30)
,`cntEmailBilling` varchar(255)
,`cntLocationID` varchar(20)
,`cntGUID` char(36)
,`cntGUID1C` char(36)
,`cntCurConvert` smallint(6)
,`cntOurbankaccountID` tinyint(4)
,`cntReasonID` smallint(6)
,`cntFlagRequest` tinyint(1)
,`cntPrefix` varchar(3)
,`cntCalcDate` varchar(20)
,`cntInsertBy` varchar(50)
,`cntInsertDate` datetime
,`cntEditBy` varchar(50)
,`cntEditDate` datetime
,`cntTaxcomID` char(46)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_port`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_port`;
CREATE TABLE `vw_port` (
`optValue` varchar(10)
,`optText` text
,`optTextLocal` text
,`optFlagDeleted` int(1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_product`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_product`;
CREATE TABLE `vw_product` (
`prdID` int(11)
,`prdGUID` char(36)
,`prdGUID1C` char(36)
,`prdIdxLeft` int(11)
,`prdIdxRight` int(11)
,`prdNlogjcID` int(10)
,`prdExternalID` varchar(12)
,`prdTitle` varchar(255)
,`prdTitleLocal` varchar(512)
,`prdFlagDeleted` tinyint(1)
,`prdParentID` int(11)
,`prdFlagFolder` tinyint(1)
,`prdPrice` decimal(10,2)
,`prdCurrencyID` smallint(6)
,`prdCategoryID` int(11)
,`prdCostID` int(11)
,`prdUnitID` int(11)
,`prdDescr` tinytext
,`prdDescrLocal` tinytext
,`prdGDS` char(3)
,`prdInsertBy` varchar(50)
,`prdInsertDate` timestamp
,`prdEditBy` varchar(50)
,`prdEditDate` datetime
,`prdValue` decimal(10,2)
,`prtUnit` varchar(10)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_product_select`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_product_select`;
CREATE TABLE `vw_product_select` (
`optValue` int(11)
,`optText` varchar(512)
,`optTextLocal` varchar(512)
,`optFlagDeleted` tinyint(1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_product_type`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_product_type`;
CREATE TABLE `vw_product_type` (
`prtID` int(11)
,`prtGUID` char(36)
,`prtGUID1C` char(36)
,`prtTitle` varchar(255)
,`prtTitleLocal` varchar(512)
,`prtFlagDeleted` tinyint(1)
,`prtParentID` int(11)
,`prtFlagFolder` tinyint(1)
,`prtInsertBy` varchar(50)
,`prtInsertDate` timestamp
,`prtEditBy` varchar(50)
,`prtEditDate` datetime
,`prtRHQ` varchar(50)
,`prtGHQ` varchar(50)
,`prtYACT` char(6)
,`prtBudgetIncomeID` char(36)
,`prtBudgetCostID` char(36)
,`prtUnit` varchar(10)
,`yctTitle` varchar(255)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_product_type_select`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_product_type_select`;
CREATE TABLE `vw_product_type_select` (
`optValue` int(11)
,`optText` varchar(255)
,`optTitleLocal` varchar(512)
,`optFlagDeleted` tinyint(1)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_profit`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_profit`;
CREATE TABLE `vw_profit` (
`pccID` int(11)
,`pccGUID` char(36)
,`pccCode1C` varchar(9)
,`pccTitle` varchar(255)
,`pccTitleLocal` varchar(512)
,`pccTitleFull` varchar(512)
,`pccFlagDeleted` tinyint(1) unsigned
,`pccInsertBy` varchar(50)
,`pccInsertDate` timestamp
,`pccEditBy` varchar(50)
,`pccEditDate` datetime
,`pccManagerRoleID` varchar(50)
,`pccPhone` varchar(11)
,`pccScanFolder` varchar(255)
,`pccAddress` varchar(255)
,`pccCity` varchar(20)
,`pccZip` varchar(10)
,`pccCountry` char(2)
,`pccDefaultLocation` int(10)
,`pccFlagProd` tinyint(1)
,`pccCompanyID` int(9) unsigned zerofill
,`pccParentCode1C` varchar(9)
,`pccFlagFolder` tinyint(4)
,`pccManagerID` int(11)
,`pccProductTypeID` int(11)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_rfc`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_rfc`;
CREATE TABLE `vw_rfc` (
`yctID` varchar(6)
,`yctGUID` char(36)
,`yctTitle` varchar(255)
,`yctTitleLocal` varchar(512)
,`yctParentID` varchar(6)
,`yctFlagFolder` tinyint(4)
,`yctFlagDeleted` tinyint(4)
,`yctInsertBy` varchar(50)
,`yctInsertDate` timestamp
,`yctEditBy` varchar(50)
,`yctEditDate` datetime
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_sales`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_sales`;
CREATE TABLE `vw_sales` (
`scenario` varchar(20)
,`company` int(9) unsigned zerofill
,`pccTitle` varchar(255)
,`prtTitle` varchar(255)
,`Activity` int(11)
,`Unit` varchar(10)
,`GHQ Activity` varchar(50)
,`cntTitle` varchar(255)
,`Customer_name` varchar(255)
,`customer` int(11)
,`source` char(36)
,`OFF_Route` varchar(50)
,`posted` tinyint(4)
,`active` tinyint(4)
,`kpi` tinyint(1)
,`pc` int(11)
,`jan` int(11)
,`feb` int(11)
,`mar` int(11)
,`apr` int(11)
,`may` int(11)
,`jun` int(11)
,`jul` int(11)
,`aug` int(11)
,`sep` int(11)
,`oct` int(11)
,`nov` int(11)
,`dec` int(11)
,`jan_1` int(11)
,`feb_1` int(11)
,`mar_1` int(11)
,`Q1` bigint(13)
,`Q2` bigint(13)
,`Q3` bigint(13)
,`Q4` bigint(13)
,`Q5` bigint(13)
,`Total` bigint(22)
,`Total_AM` bigint(22)
,`customer_group_code` int(11)
,`customer_group_title` varchar(255)
,`prtGHQ` varchar(50)
,`bo` int(11)
,`jo` int(11)
,`freehand` tinyint(1)
,`new` tinyint(4)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_supplier`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_supplier`;
CREATE TABLE `vw_supplier` (
`cntID` int(11)
,`cntTitle` varchar(255)
,`cntTitleLocal` varchar(512)
,`cntFlagDeleted` tinyint(1)
,`cntFlagConfirmed` tinyint(1)
,`cntINN` char(12)
,`cntKPP` char(10)
,`cntID1C` varchar(5)
,`cntOGRN` char(13)
,`cntParentID` int(11)
,`cntParentID1C` char(36)
,`cntParentCode1C` varchar(9)
,`cntCode1C` varchar(20)
,`cntGDS` varchar(10)
,`cntGDSCountry` char(2)
,`cntGDSCity` char(3)
,`cntFlagFolder` tinyint(1) unsigned
,`cntFlagCustomer` tinyint(1) unsigned
,`cntFlagSupplier` tinyint(1) unsigned
,`cntBalanceCustomer` decimal(15,2)
,`cntBalanceSupplier` decimal(15,2)
,`cntUserID` varchar(50)
,`cntAccountantID` varchar(50)
,`cntCostID` int(11)
,`cntProfitID` int(11)
,`cntCreditDays` tinyint(4)
,`cntFile` varchar(512)
,`cntFlagBankingDays` tinyint(1)
,`cntCitiProfile` varchar(35)
,`cntTitleFullLocal` varchar(400)
,`cntFlagSpecs` tinyint(4)
,`cntAccountID1C` varchar(4)
,`cntAccountCode1C` varchar(9)
,`cntFlagNR` tinyint(4)
,`cntCustomerID` mediumint(9)
,`cntAgreementID` mediumint(9)
,`cntAddress` varchar(512)
,`cntLegalAddress` varchar(512)
,`cntContact` varchar(255)
,`cntPhone` varchar(30)
,`cntFax` varchar(30)
,`cntEmailBilling` varchar(255)
,`cntLocationID` varchar(20)
,`cntGUID` char(36)
,`cntGUID1C` char(36)
,`cntCurConvert` smallint(6)
,`cntOurbankaccountID` tinyint(4)
,`cntReasonID` smallint(6)
,`cntFlagRequest` tinyint(1)
,`cntPrefix` varchar(3)
,`cntCalcDate` varchar(20)
,`cntInsertBy` varchar(50)
,`cntInsertDate` datetime
,`cntEditBy` varchar(50)
,`cntEditDate` datetime
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `vw_yact`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `vw_yact`;
CREATE TABLE `vw_yact` (
`yctID` varchar(6)
,`yctGUID` char(36)
,`yctTitle` varchar(255)
,`yctTitleLocal` varchar(512)
,`yctParentID` varchar(6)
,`yctFlagFolder` tinyint(4)
,`yctFlagDeleted` tinyint(4)
,`yctInsertBy` varchar(50)
,`yctInsertDate` timestamp
,`yctEditBy` varchar(50)
,`yctEditDate` datetime
);

-- --------------------------------------------------------

--
-- Структура для представления `stbl_role_user`
--
DROP TABLE IF EXISTS `stbl_role_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `stbl_role_user`  AS  select `common_db`.`stbl_role_user`.`rluID` AS `rluID`,`common_db`.`stbl_role_user`.`rluUserID` AS `rluUserID`,`common_db`.`stbl_role_user`.`rluRoleID` AS `rluRoleID`,`common_db`.`stbl_role_user`.`rluInsertBy` AS `rluInsertBy`,`common_db`.`stbl_role_user`.`rluInsertDate` AS `rluInsertDate`,`common_db`.`stbl_role_user`.`rluEditBy` AS `rluEditBy`,`common_db`.`stbl_role_user`.`rluEditDate` AS `rluEditDate`,`common_db`.`stbl_role_user`.`rluDeadline` AS `rluDeadline` from `common_db`.`stbl_role_user` ;

-- --------------------------------------------------------

--
-- Структура для представления `stbl_setup`
--
DROP TABLE IF EXISTS `stbl_setup`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `stbl_setup`  AS  select `tbl_setup`.`stpID` AS `stpID`,`tbl_setup`.`stpVarName` AS `stpVarName`,`tbl_setup`.`stpCharType` AS `stpCharType`,`tbl_setup`.`stpCharValue` AS `stpCharValue`,`tbl_setup`.`stpFlagReadOnly` AS `stpFlagReadOnly`,`tbl_setup`.`stpNGroup` AS `stpNGroup`,`tbl_setup`.`stpCharName` AS `stpCharName`,`tbl_setup`.`stpInsertBy` AS `stpInsertBy`,`tbl_setup`.`stpInsertDate` AS `stpInsertDate`,`tbl_setup`.`stpEditBy` AS `stpEditBy`,`tbl_setup`.`stpEditDate` AS `stpEditDate` from `tbl_setup` ;

-- --------------------------------------------------------

--
-- Структура для представления `stbl_user`
--
DROP TABLE IF EXISTS `stbl_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `stbl_user`  AS  select `common_db`.`stbl_user`.`usrID` AS `usrID`,`common_db`.`stbl_user`.`usrName` AS `usrName`,`common_db`.`stbl_user`.`usrPass` AS `usrPass`,`common_db`.`stbl_user`.`usrFlagDeleted` AS `usrFlagDeleted`,`common_db`.`stbl_user`.`usrInsertBy` AS `usrInsertBy`,`common_db`.`stbl_user`.`usrInsertDate` AS `usrInsertDate`,`common_db`.`stbl_user`.`usrEditBy` AS `usrEditBy`,`common_db`.`stbl_user`.`usrEditDate` AS `usrEditDate`,`common_db`.`stbl_user`.`usrNameLocal` AS `usrNameLocal`,`common_db`.`stbl_user`.`usrScanFolder` AS `usrScanFolder`,`common_db`.`stbl_user`.`usrLanguage` AS `usrLanguage`,`common_db`.`stbl_user`.`usrFlagLocal` AS `usrFlagLocal`,`common_db`.`stbl_user`.`usrPhone` AS `usrPhone`,`common_db`.`stbl_user`.`usrEmail` AS `usrEmail`,`common_db`.`stbl_user`.`usrProfitID` AS `usrProfitID`,`common_db`.`stbl_user`.`usrEmployeeID` AS `usrEmployeeID`,`common_db`.`stbl_user`.`usrGUID` AS `usrGUID`,`common_db`.`stbl_user`.`usrGDS` AS `usrGDS`,`common_db`.`stbl_user`.`usrName` AS `usrTitle`,`common_db`.`stbl_user`.`usrNameLocal` AS `usrTitleLocal` from `common_db`.`stbl_user` ;

-- --------------------------------------------------------

--
-- Структура для представления `tbl_port`
--
DROP TABLE IF EXISTS `tbl_port`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `tbl_port`  AS  select `geo`.`tbl_port`.`prtID` AS `prtID`,`geo`.`tbl_port`.`prtCountryID` AS `prtCountryID`,`geo`.`tbl_port`.`prtLOCODE` AS `prtLOCODE`,`geo`.`tbl_port`.`prtTitleLocal` AS `prtTitleLocal`,`geo`.`tbl_port`.`prtTitle` AS `prtTitle`,`geo`.`tbl_port`.`prtFlagValid` AS `prtFlagValid`,`geo`.`tbl_port`.`prtFlagDeleted` AS `prtFlagDeleted`,`geo`.`tbl_port`.`prtInsertBy` AS `prtInsertBy`,`geo`.`tbl_port`.`prtInsertDate` AS `prtInsertDate`,`geo`.`tbl_port`.`prtEditBy` AS `prtEditBy`,`geo`.`tbl_port`.`prtEditDate` AS `prtEditDate` from `geo`.`tbl_port` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_active_scenario`
--
DROP TABLE IF EXISTS `vw_active_scenario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_active_scenario`  AS  select `tbl_scenario`.`scnID` AS `scnID`,`tbl_scenario`.`scnFlagReadOnly` AS `scnFlagReadOnly`,`tbl_scenario`.`scnTitle` AS `scnTitle`,`tbl_scenario`.`scnTitleLocal` AS `scnTitleLocal`,`tbl_scenario`.`scnYear` AS `scnYear`,`tbl_scenario`.`scnDateStart` AS `scnDateStart`,`tbl_scenario`.`scnTotal` AS `scnTotal`,`tbl_scenario`.`scnEditBy` AS `scnEditBy`,`tbl_scenario`.`scnEditDate` AS `scnEditDate`,`tbl_scenario`.`scnInsertBy` AS `scnInsertBy`,`tbl_scenario`.`scnInsertDate` AS `scnInsertDate`,`tbl_scenario`.`scnFlagDeleted` AS `scnFlagDeleted`,`tbl_scenario`.`scnGUID` AS `scnGUID`,`tbl_scenario`.`scnLastSource` AS `scnLastSource`,`tbl_scenario`.`scnType` AS `scnType`,`tbl_scenario`.`scnFlagArchive` AS `scnFlagArchive`,`tbl_scenario`.`scnLastID` AS `scnLastID` from `tbl_scenario` where (`tbl_scenario`.`scnFlagArchive` = 0) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_company`
--
DROP TABLE IF EXISTS `vw_company`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_company`  AS  select `common_db`.`tbl_company`.`comID` AS `comID`,`common_db`.`tbl_company`.`comGUID` AS `comGUID`,`common_db`.`tbl_company`.`comTitle` AS `comTitle`,`common_db`.`tbl_company`.`comTitleLocal` AS `comTitleLocal`,`common_db`.`tbl_company`.`comTitleShort` AS `comTitleShort`,`common_db`.`tbl_company`.`comINN` AS `comINN`,`common_db`.`tbl_company`.`comKPP` AS `comKPP`,`common_db`.`tbl_company`.`comOGRN` AS `comOGRN`,`common_db`.`tbl_company`.`comAddress` AS `comAddress`,`common_db`.`tbl_company`.`comAddressLocal` AS `comAddressLocal`,`common_db`.`tbl_company`.`comGeneralManager` AS `comGeneralManager`,`common_db`.`tbl_company`.`comGeneralManagerLocal` AS `comGeneralManagerLocal`,`common_db`.`tbl_company`.`comChiefAccountant` AS `comChiefAccountant`,`common_db`.`tbl_company`.`comChiefAccountantLocal` AS `comChiefAccountantLocal`,`common_db`.`tbl_company`.`comFlagDeleted` AS `comFlagDeleted`,`common_db`.`tbl_company`.`comInsertBy` AS `comInsertBy`,`common_db`.`tbl_company`.`comInsertDate` AS `comInsertDate`,`common_db`.`tbl_company`.`comEditBy` AS `comEditBy`,`common_db`.`tbl_company`.`comEditDate` AS `comEditDate` from `common_db`.`tbl_company` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_counterparty`
--
DROP TABLE IF EXISTS `vw_counterparty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_counterparty`  AS  select `common_db`.`tbl_counterparty`.`cntID` AS `cntID`,`common_db`.`tbl_counterparty`.`cntTitle` AS `cntTitle`,`common_db`.`tbl_counterparty`.`cntTitleLocal` AS `cntTitleLocal`,`common_db`.`tbl_counterparty`.`cntFlagDeleted` AS `cntFlagDeleted`,`common_db`.`tbl_counterparty`.`cntFlagConfirmed` AS `cntFlagConfirmed`,`common_db`.`tbl_counterparty`.`cntINN` AS `cntINN`,`common_db`.`tbl_counterparty`.`cntKPP` AS `cntKPP`,`common_db`.`tbl_counterparty`.`cntID1C` AS `cntID1C`,`common_db`.`tbl_counterparty`.`cntOGRN` AS `cntOGRN`,`common_db`.`tbl_counterparty`.`cntParentID` AS `cntParentID`,`common_db`.`tbl_counterparty`.`cntParentID1C` AS `cntParentID1C`,`common_db`.`tbl_counterparty`.`cntParentCode1C` AS `cntParentCode1C`,`common_db`.`tbl_counterparty`.`cntCode1C` AS `cntCode1C`,`common_db`.`tbl_counterparty`.`cntGDS` AS `cntGDS`,`common_db`.`tbl_counterparty`.`cntYUNAS` AS `cntYUNAS`,`common_db`.`tbl_counterparty`.`cntGDSCountry` AS `cntGDSCountry`,`common_db`.`tbl_counterparty`.`cntGDSCity` AS `cntGDSCity`,`common_db`.`tbl_counterparty`.`cntFlagFolder` AS `cntFlagFolder`,`common_db`.`tbl_counterparty`.`cntFlagCustomer` AS `cntFlagCustomer`,`common_db`.`tbl_counterparty`.`cntFlagSupplier` AS `cntFlagSupplier`,`common_db`.`tbl_counterparty`.`cntBalanceCustomer` AS `cntBalanceCustomer`,`common_db`.`tbl_counterparty`.`cntBalanceSupplier` AS `cntBalanceSupplier`,`common_db`.`tbl_counterparty`.`cntUserID` AS `cntUserID`,`common_db`.`tbl_counterparty`.`cntOperationsID` AS `cntOperationsID`,`common_db`.`tbl_counterparty`.`cntAccountantID` AS `cntAccountantID`,`common_db`.`tbl_counterparty`.`cntCostID` AS `cntCostID`,`common_db`.`tbl_counterparty`.`cntProfitID` AS `cntProfitID`,`common_db`.`tbl_counterparty`.`cntCreditDays` AS `cntCreditDays`,`common_db`.`tbl_counterparty`.`cntFile` AS `cntFile`,`common_db`.`tbl_counterparty`.`cntFlagBankingDays` AS `cntFlagBankingDays`,`common_db`.`tbl_counterparty`.`cntCitiProfile` AS `cntCitiProfile`,`common_db`.`tbl_counterparty`.`cntTitleFullLocal` AS `cntTitleFullLocal`,`common_db`.`tbl_counterparty`.`cntFlagSpecs` AS `cntFlagSpecs`,`common_db`.`tbl_counterparty`.`cntAccountID1C` AS `cntAccountID1C`,`common_db`.`tbl_counterparty`.`cntAccountCode1C` AS `cntAccountCode1C`,`common_db`.`tbl_counterparty`.`cntFlagNR` AS `cntFlagNR`,`common_db`.`tbl_counterparty`.`cntCustomerID` AS `cntCustomerID`,`common_db`.`tbl_counterparty`.`cntAgreementID` AS `cntAgreementID`,`common_db`.`tbl_counterparty`.`cntAddress` AS `cntAddress`,`common_db`.`tbl_counterparty`.`cntLegalAddress` AS `cntLegalAddress`,`common_db`.`tbl_counterparty`.`cntContact` AS `cntContact`,`common_db`.`tbl_counterparty`.`cntPhone` AS `cntPhone`,`common_db`.`tbl_counterparty`.`cntFax` AS `cntFax`,`common_db`.`tbl_counterparty`.`cntEmailBilling` AS `cntEmailBilling`,`common_db`.`tbl_counterparty`.`cntLocationID` AS `cntLocationID`,`common_db`.`tbl_counterparty`.`cntGUID` AS `cntGUID`,`common_db`.`tbl_counterparty`.`cntGUID1C` AS `cntGUID1C`,`common_db`.`tbl_counterparty`.`cntCurConvert` AS `cntCurConvert`,`common_db`.`tbl_counterparty`.`cntOurbankaccountID` AS `cntOurbankaccountID`,`common_db`.`tbl_counterparty`.`cntReasonID` AS `cntReasonID`,`common_db`.`tbl_counterparty`.`cntFlagRequest` AS `cntFlagRequest`,`common_db`.`tbl_counterparty`.`cntPrefix` AS `cntPrefix`,`common_db`.`tbl_counterparty`.`cntCalcDate` AS `cntCalcDate`,`common_db`.`tbl_counterparty`.`cntInsertBy` AS `cntInsertBy`,`common_db`.`tbl_counterparty`.`cntInsertDate` AS `cntInsertDate`,`common_db`.`tbl_counterparty`.`cntEditBy` AS `cntEditBy`,`common_db`.`tbl_counterparty`.`cntEditDate` AS `cntEditDate`,`common_db`.`tbl_counterparty`.`cntTaxcomID` AS `cntTaxcomID`,`common_db`.`tbl_counterparty`.`cntIdxLeft` AS `cntIdxLeft`,`common_db`.`tbl_counterparty`.`cntIdxRight` AS `cntIdxRight`,`common_db`.`tbl_counterparty`.`cntFlagGBR` AS `cntFlagGBR`,`common_db`.`tbl_counterparty`.`cntComment` AS `cntComment`,`common_db`.`tbl_counterparty`.`cntFlagDissolved` AS `cntFlagDissolved`,`common_db`.`tbl_counterparty`.`cntFlagDissolving` AS `cntFlagDissolving`,`common_db`.`tbl_counterparty`.`cntDissolvedDate` AS `cntDissolvedDate`,`common_db`.`tbl_counterparty`.`cntGroupID` AS `cntGroupID` from `common_db`.`tbl_counterparty` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_currency`
--
DROP TABLE IF EXISTS `vw_currency`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_currency`  AS  select `common_db`.`tbl_currency`.`curID` AS `curID`,`common_db`.`tbl_currency`.`curTitle` AS `curTitle`,`common_db`.`tbl_currency`.`curTitleLocal` AS `curTitleLocal`,`common_db`.`tbl_currency`.`curFlagDeleted` AS `curFlagDeleted`,`common_db`.`tbl_currency`.`curInsertBy` AS `curInsertBy`,`common_db`.`tbl_currency`.`curInsertDate` AS `curInsertDate`,`common_db`.`tbl_currency`.`curEditBy` AS `curEditBy`,`common_db`.`tbl_currency`.`curEditDate` AS `curEditDate`,`common_db`.`tbl_currency`.`curRate` AS `curRate`,`common_db`.`tbl_currency`.`curDecRate` AS `curDecRate` from `common_db`.`tbl_currency` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_customer`
--
DROP TABLE IF EXISTS `vw_customer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_customer`  AS  select `common_db`.`tbl_counterparty`.`cntID` AS `cntID`,`common_db`.`tbl_counterparty`.`cntTitle` AS `cntTitle`,`common_db`.`tbl_counterparty`.`cntTitleLocal` AS `cntTitleLocal`,`common_db`.`tbl_counterparty`.`cntFlagDeleted` AS `cntFlagDeleted`,`common_db`.`tbl_counterparty`.`cntFlagConfirmed` AS `cntFlagConfirmed`,`common_db`.`tbl_counterparty`.`cntINN` AS `cntINN`,`common_db`.`tbl_counterparty`.`cntKPP` AS `cntKPP`,`common_db`.`tbl_counterparty`.`cntID1C` AS `cntID1C`,`common_db`.`tbl_counterparty`.`cntOGRN` AS `cntOGRN`,`common_db`.`tbl_counterparty`.`cntParentID` AS `cntParentID`,`common_db`.`tbl_counterparty`.`cntParentID1C` AS `cntParentID1C`,`common_db`.`tbl_counterparty`.`cntParentCode1C` AS `cntParentCode1C`,`common_db`.`tbl_counterparty`.`cntCode1C` AS `cntCode1C`,`common_db`.`tbl_counterparty`.`cntGDS` AS `cntGDS`,`common_db`.`tbl_counterparty`.`cntGDSCountry` AS `cntGDSCountry`,`common_db`.`tbl_counterparty`.`cntGDSCity` AS `cntGDSCity`,`common_db`.`tbl_counterparty`.`cntFlagFolder` AS `cntFlagFolder`,`common_db`.`tbl_counterparty`.`cntFlagCustomer` AS `cntFlagCustomer`,`common_db`.`tbl_counterparty`.`cntFlagSupplier` AS `cntFlagSupplier`,`common_db`.`tbl_counterparty`.`cntBalanceCustomer` AS `cntBalanceCustomer`,`common_db`.`tbl_counterparty`.`cntBalanceSupplier` AS `cntBalanceSupplier`,`common_db`.`tbl_counterparty`.`cntUserID` AS `cntUserID`,`common_db`.`tbl_counterparty`.`cntAccountantID` AS `cntAccountantID`,`common_db`.`tbl_counterparty`.`cntCostID` AS `cntCostID`,`common_db`.`tbl_counterparty`.`cntProfitID` AS `cntProfitID`,`common_db`.`tbl_counterparty`.`cntCreditDays` AS `cntCreditDays`,`common_db`.`tbl_counterparty`.`cntFile` AS `cntFile`,`common_db`.`tbl_counterparty`.`cntFlagBankingDays` AS `cntFlagBankingDays`,`common_db`.`tbl_counterparty`.`cntCitiProfile` AS `cntCitiProfile`,`common_db`.`tbl_counterparty`.`cntTitleFullLocal` AS `cntTitleFullLocal`,`common_db`.`tbl_counterparty`.`cntFlagSpecs` AS `cntFlagSpecs`,`common_db`.`tbl_counterparty`.`cntAccountID1C` AS `cntAccountID1C`,`common_db`.`tbl_counterparty`.`cntAccountCode1C` AS `cntAccountCode1C`,`common_db`.`tbl_counterparty`.`cntFlagNR` AS `cntFlagNR`,`common_db`.`tbl_counterparty`.`cntCustomerID` AS `cntCustomerID`,`common_db`.`tbl_counterparty`.`cntAgreementID` AS `cntAgreementID`,`common_db`.`tbl_counterparty`.`cntAddress` AS `cntAddress`,`common_db`.`tbl_counterparty`.`cntLegalAddress` AS `cntLegalAddress`,`common_db`.`tbl_counterparty`.`cntContact` AS `cntContact`,`common_db`.`tbl_counterparty`.`cntPhone` AS `cntPhone`,`common_db`.`tbl_counterparty`.`cntFax` AS `cntFax`,`common_db`.`tbl_counterparty`.`cntEmailBilling` AS `cntEmailBilling`,`common_db`.`tbl_counterparty`.`cntLocationID` AS `cntLocationID`,`common_db`.`tbl_counterparty`.`cntGUID` AS `cntGUID`,`common_db`.`tbl_counterparty`.`cntGUID1C` AS `cntGUID1C`,`common_db`.`tbl_counterparty`.`cntCurConvert` AS `cntCurConvert`,`common_db`.`tbl_counterparty`.`cntOurbankaccountID` AS `cntOurbankaccountID`,`common_db`.`tbl_counterparty`.`cntReasonID` AS `cntReasonID`,`common_db`.`tbl_counterparty`.`cntFlagRequest` AS `cntFlagRequest`,`common_db`.`tbl_counterparty`.`cntPrefix` AS `cntPrefix`,`common_db`.`tbl_counterparty`.`cntCalcDate` AS `cntCalcDate`,`common_db`.`tbl_counterparty`.`cntInsertBy` AS `cntInsertBy`,`common_db`.`tbl_counterparty`.`cntInsertDate` AS `cntInsertDate`,`common_db`.`tbl_counterparty`.`cntEditBy` AS `cntEditBy`,`common_db`.`tbl_counterparty`.`cntEditDate` AS `cntEditDate` from `common_db`.`tbl_counterparty` where (`common_db`.`tbl_counterparty`.`cntFlagCustomer` = 1) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_employee`
--
DROP TABLE IF EXISTS `vw_employee`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_employee`  AS  select `common_db`.`tbl_employee`.`empID` AS `empID`,`common_db`.`tbl_employee`.`empManagerID` AS `empManagerID`,`common_db`.`tbl_employee`.`empTitle` AS `empTitle`,`common_db`.`tbl_employee`.`empTitleLocal` AS `empTitleLocal`,`common_db`.`tbl_employee`.`empUserID` AS `empUserID`,`common_db`.`tbl_employee`.`empTitleGenitive` AS `empTitleGenitive`,`common_db`.`tbl_employee`.`empTitleDative` AS `empTitleDative`,`common_db`.`tbl_employee`.`empTitleAccusative` AS `empTitleAccusative`,`common_db`.`tbl_employee`.`empTitleInstrumental` AS `empTitleInstrumental`,`common_db`.`tbl_employee`.`empTitlePrepositional` AS `empTitlePrepositional`,`common_db`.`tbl_employee`.`empFunctionGUID` AS `empFunctionGUID`,`common_db`.`tbl_employee`.`empFunction` AS `empFunction`,`common_db`.`tbl_employee`.`empFile` AS `empFile`,`common_db`.`tbl_employee`.`empFunctionLocal` AS `empFunctionLocal`,`common_db`.`tbl_employee`.`empFlagDeleted` AS `empFlagDeleted`,`common_db`.`tbl_employee`.`empGender` AS `empGender`,`common_db`.`tbl_employee`.`empBirthDate` AS `empBirthDate`,`common_db`.`tbl_employee`.`empFlagNR` AS `empFlagNR`,`common_db`.`tbl_employee`.`empStartDate` AS `empStartDate`,`common_db`.`tbl_employee`.`empEndDate` AS `empEndDate`,`common_db`.`tbl_employee`.`empINN` AS `empINN`,`common_db`.`tbl_employee`.`empPFR` AS `empPFR`,`common_db`.`tbl_employee`.`empID1C` AS `empID1C`,`common_db`.`tbl_employee`.`empCode1C` AS `empCode1C`,`common_db`.`tbl_employee`.`empFlagFolder` AS `empFlagFolder`,`common_db`.`tbl_employee`.`empParentID1C` AS `empParentID1C`,`common_db`.`tbl_employee`.`empGUID` AS `empGUID`,`common_db`.`tbl_employee`.`empGUID1C` AS `empGUID1C`,`common_db`.`tbl_employee`.`empBranchID` AS `empBranchID`,`common_db`.`tbl_employee`.`empProfitID` AS `empProfitID`,`common_db`.`tbl_employee`.`empFlagTD` AS `empFlagTD`,`common_db`.`tbl_employee`.`empFlagEO` AS `empFlagEO`,`common_db`.`tbl_employee`.`empFlagTK` AS `empFlagTK`,`common_db`.`tbl_employee`.`empFlagEducation` AS `empFlagEducation`,`common_db`.`tbl_employee`.`empFlagPassport` AS `empFlagPassport`,`common_db`.`tbl_employee`.`empFlagMilitary` AS `empFlagMilitary`,`common_db`.`tbl_employee`.`empFlagMarriage` AS `empFlagMarriage`,`common_db`.`tbl_employee`.`empFlagBirth` AS `empFlagBirth`,`common_db`.`tbl_employee`.`empDocSeries` AS `empDocSeries`,`common_db`.`tbl_employee`.`empDocNumber` AS `empDocNumber`,`common_db`.`tbl_employee`.`empDocDate` AS `empDocDate`,`common_db`.`tbl_employee`.`empDocIssuer` AS `empDocIssuer`,`common_db`.`tbl_employee`.`empAddress` AS `empAddress`,`common_db`.`tbl_employee`.`empActualAddress` AS `empActualAddress`,`common_db`.`tbl_employee`.`empPhone` AS `empPhone`,`common_db`.`tbl_employee`.`empTitleFullLocal` AS `empTitleFullLocal`,`common_db`.`tbl_employee`.`empAccount` AS `empAccount`,`common_db`.`tbl_employee`.`empBeneficiary` AS `empBeneficiary`,`common_db`.`tbl_employee`.`empBeneficiaryINN` AS `empBeneficiaryINN`,`common_db`.`tbl_employee`.`empNok1` AS `empNok1`,`common_db`.`tbl_employee`.`empNokPhone1` AS `empNokPhone1`,`common_db`.`tbl_employee`.`empNokRelation1` AS `empNokRelation1`,`common_db`.`tbl_employee`.`empNokAddress1` AS `empNokAddress1`,`common_db`.`tbl_employee`.`empNok2` AS `empNok2`,`common_db`.`tbl_employee`.`empNokPhone2` AS `empNokPhone2`,`common_db`.`tbl_employee`.`empNokRelation2` AS `empNokRelation2`,`common_db`.`tbl_employee`.`empNokAddress2` AS `empNokAddress2`,`common_db`.`tbl_employee`.`empBankID` AS `empBankID`,`common_db`.`tbl_employee`.`empPaymentOptions` AS `empPaymentOptions`,`common_db`.`tbl_employee`.`empVacationBalance` AS `empVacationBalance`,`common_db`.`tbl_employee`.`empManagerID1C` AS `empManagerID1C`,`common_db`.`tbl_employee`.`empInsertBy` AS `empInsertBy`,`common_db`.`tbl_employee`.`empInsertDate` AS `empInsertDate`,`common_db`.`tbl_employee`.`empEditBy` AS `empEditBy`,`common_db`.`tbl_employee`.`empEditDate` AS `empEditDate`,`common_db`.`tbl_employee`.`empSalary` AS `empSalary`,`common_db`.`tbl_employee`.`empProbationDate` AS `empProbationDate`,`common_db`.`tbl_employee`.`empPhoto` AS `empPhoto`,`common_db`.`tbl_employee`.`empDayoffBalance` AS `empDayoffBalance`,`common_db`.`tbl_employee`.`empLocationID` AS `empLocationID`,`common_db`.`tbl_employee`.`empCustomerID` AS `empCustomerID`,`common_db`.`tbl_employee`.`empProductTypeID` AS `empProductTypeID`,`common_db`.`tbl_employee`.`empYACT` AS `empYACT`,`common_db`.`tbl_employee`.`empMobileLimit` AS `empMobileLimit`,`common_db`.`tbl_employee`.`empFTE` AS `empFTE` from `common_db`.`tbl_employee` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_employee_select`
--
DROP TABLE IF EXISTS `vw_employee_select`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_employee_select`  AS  select `common_db`.`tbl_employee`.`empSkill` AS `empSkill`,`common_db`.`tbl_employee`.`empID` AS `empID`,`common_db`.`tbl_employee`.`empStartDate` AS `empStartDate`,`common_db`.`tbl_employee`.`empEndDate` AS `empEndDate`,`common_db`.`tbl_employee`.`empGUID1C` AS `empGUID1C`,`common_db`.`tbl_employee`.`empTitleLocal` AS `empTitleLocal`,`common_db`.`tbl_employee`.`empTitle` AS `empTitle`,`common_db`.`tbl_employee`.`empFlagDeleted` AS `empFlagDeleted`,`common_db`.`tbl_employee`.`empProfitID` AS `empProfitID`,`common_db`.`tbl_function`.`funTitle` AS `funTitle`,`common_db`.`tbl_function`.`funFlagWC` AS `funFlagWC`,`common_db`.`tbl_function`.`funMobile` AS `funMobile`,`common_db`.`tbl_function`.`funFuel` AS `funFuel`,`common_db`.`tbl_location`.`locTitle` AS `locTitle`,`common_db`.`tbl_employee`.`empSalary` AS `empSalary`,`common_db`.`tbl_employee`.`empFunctionGUID` AS `empFunctionGUID`,`common_db`.`tbl_employee`.`empLocationID` AS `empLocationID`,`common_db`.`tbl_employee`.`empProductTypeID` AS `empProductTypeID`,`common_db`.`tbl_employee`.`empMobileLimit` AS `empMobileLimit`,`common_db`.`tbl_employee`.`empMonthly` AS `empMonthly`,`common_db`.`tbl_employee`.`empSalaryRevision` AS `empSalaryRevision`,`common_db`.`tbl_function`.`funFlagSGA` AS `funFlagSGA`,`common_db`.`tbl_function`.`funBonus` AS `funBonus`,`common_db`.`tbl_employee`.`empFTE` AS `empFTE` from ((`common_db`.`tbl_employee` left join `common_db`.`tbl_function` on((`common_db`.`tbl_function`.`funGUID` = `common_db`.`tbl_employee`.`empFunctionGUID`))) left join `common_db`.`tbl_location` on((`common_db`.`tbl_location`.`locID` = `common_db`.`tbl_employee`.`empLocationID`))) where (`common_db`.`tbl_employee`.`empFlagDeleted` = 0) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_fixed_assets`
--
DROP TABLE IF EXISTS `vw_fixed_assets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_fixed_assets`  AS  select `common_db`.`tbl_fixed_assets`.`fixID` AS `fixID`,`common_db`.`tbl_fixed_assets`.`fixGUID` AS `fixGUID`,`common_db`.`tbl_fixed_assets`.`fixTitle` AS `fixTitle`,`common_db`.`tbl_fixed_assets`.`fixTitleLocal` AS `fixTitleLocal`,`common_db`.`tbl_fixed_assets`.`fixPlateNo` AS `fixPlateNo`,`common_db`.`tbl_fixed_assets`.`fixVIN` AS `fixVIN`,`common_db`.`tbl_fixed_assets`.`fixDeprStart` AS `fixDeprStart`,`common_db`.`tbl_fixed_assets`.`fixDeprEnd` AS `fixDeprEnd`,`common_db`.`tbl_fixed_assets`.`fixDeprDuration` AS `fixDeprDuration`,`common_db`.`tbl_fixed_assets`.`fixValueStart` AS `fixValueStart`,`common_db`.`tbl_fixed_assets`.`fixEmployeeGUID` AS `fixEmployeeGUID`,`common_db`.`tbl_fixed_assets`.`fixProfitID` AS `fixProfitID`,`common_db`.`tbl_fixed_assets`.`fixYACT` AS `fixYACT`,`common_db`.`tbl_fixed_assets`.`fixItemID` AS `fixItemID`,`common_db`.`tbl_fixed_assets`.`fixProductTypeID` AS `fixProductTypeID`,`common_db`.`tbl_fixed_assets`.`fixParentID` AS `fixParentID`,`common_db`.`tbl_fixed_assets`.`fixIdxLeft` AS `fixIdxLeft`,`common_db`.`tbl_fixed_assets`.`fixIdxRight` AS `fixIdxRight`,`common_db`.`tbl_fixed_assets`.`fixFlagFolder` AS `fixFlagFolder`,`common_db`.`tbl_fixed_assets`.`fixFlagDeleted` AS `fixFlagDeleted`,`common_db`.`tbl_fixed_assets`.`fixInsertBy` AS `fixInsertBy`,`common_db`.`tbl_fixed_assets`.`fixInsertDate` AS `fixInsertDate`,`common_db`.`tbl_fixed_assets`.`fixEditBy` AS `fixEditBy`,`common_db`.`tbl_fixed_assets`.`fixEditDate` AS `fixEditDate`,`common_db`.`tbl_fixed_assets`.`fixCompanyID` AS `fixCompanyID`,`common_db`.`tbl_fixed_assets`.`fixLocationID` AS `fixLocationID` from `common_db`.`tbl_fixed_assets` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_function`
--
DROP TABLE IF EXISTS `vw_function`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_function`  AS  select `common_db`.`tbl_function`.`funID` AS `funID`,`common_db`.`tbl_function`.`funGUID` AS `funGUID`,`common_db`.`tbl_function`.`funFlagDeleted` AS `funFlagDeleted`,`common_db`.`tbl_function`.`funTitle` AS `funTitle`,`common_db`.`tbl_function`.`funTitleLocal` AS `funTitleLocal`,`common_db`.`tbl_function`.`funFlagWC` AS `funFlagWC`,`common_db`.`tbl_function`.`funInsertBy` AS `funInsertBy`,`common_db`.`tbl_function`.`funInsertDate` AS `funInsertDate`,`common_db`.`tbl_function`.`funEditBy` AS `funEditBy`,`common_db`.`tbl_function`.`funEditDate` AS `funEditDate`,`common_db`.`tbl_function`.`funComment` AS `funComment`,`common_db`.`tbl_function`.`funMobile` AS `funMobile`,`common_db`.`tbl_function`.`funFuel` AS `funFuel`,`common_db`.`tbl_function`.`funRHQ` AS `funRHQ`,`common_db`.`tbl_function`.`funFlagSGA` AS `funFlagSGA` from `common_db`.`tbl_function` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_headcount`
--
DROP TABLE IF EXISTS `vw_headcount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_headcount`  AS  select `reg_headcount`.`scenario` AS `scenario`,`reg_headcount`.`company` AS `company`,`common_db`.`tbl_employee`.`empCode1C` AS `empCode1C`,`common_db`.`tbl_employee`.`empTitleLocal` AS `empTitleLocal`,`common_db`.`tbl_employee`.`empSalary` AS `empSalary`,`vw_product_type`.`prtGHQ` AS `prtGHQ`,`vw_product_type`.`prtRHQ` AS `prtRHQ`,`vw_location`.`locTitle` AS `Location`,`vw_product_type`.`prtTitle` AS `prtTitle`,`reg_headcount`.`function` AS `function`,`vw_function`.`funRHQ` AS `funRHQ`,`vw_function`.`funTitle` AS `funTitle`,`vw_function`.`funTitleLocal` AS `funTitleLocal`,`reg_headcount`.`pc` AS `pc`,`common_db`.`tbl_profit`.`pccTitle` AS `pccTitle`,`common_db`.`tbl_profit`.`pccTitleLocal` AS `pccTitleLocal`,`common_db`.`tbl_profit`.`pccFlagProd` AS `pccFlagProd`,`common_db`.`tbl_profit`.`pccParentCode1C` AS `pccParentCode1C`,`reg_headcount`.`wc` AS `wc`,`reg_headcount`.`salary` AS `salary`,`reg_headcount`.`new_fte` AS `new_fte`,`reg_headcount`.`vks` AS `vks`,`reg_headcount`.`start_date` AS `start_date`,`reg_headcount`.`end_date` AS `end_date`,`common_db`.`tbl_employee`.`empUserID` AS `sales`,`reg_headcount`.`pc` AS `bdv`,`reg_headcount`.`source` AS `source`,ifnull(`reg_headcount`.`activity`,`common_db`.`tbl_profit`.`pccProductTypeID`) AS `activity`,`reg_headcount`.`jan` AS `jan`,`reg_headcount`.`feb` AS `feb`,`reg_headcount`.`mar` AS `mar`,`reg_headcount`.`apr` AS `apr`,`reg_headcount`.`may` AS `may`,`reg_headcount`.`jun` AS `jun`,`reg_headcount`.`jul` AS `jul`,`reg_headcount`.`aug` AS `aug`,`reg_headcount`.`sep` AS `sep`,`reg_headcount`.`oct` AS `oct`,`reg_headcount`.`nov` AS `nov`,`reg_headcount`.`dec` AS `dec`,`reg_headcount`.`jan_1` AS `jan_1`,`reg_headcount`.`feb_1` AS `feb_1`,`reg_headcount`.`mar_1` AS `mar_1`,(((`reg_headcount`.`jan` + `reg_headcount`.`feb`) + `reg_headcount`.`mar`) / 3) AS `Q1`,(((`reg_headcount`.`apr` + `reg_headcount`.`may`) + `reg_headcount`.`jun`) / 3) AS `Q2`,(((`reg_headcount`.`jul` + `reg_headcount`.`aug`) + `reg_headcount`.`sep`) / 3) AS `Q3`,(((`reg_headcount`.`oct` + `reg_headcount`.`nov`) + `reg_headcount`.`dec`) / 3) AS `Q4`,(((`reg_headcount`.`jan_1` + `reg_headcount`.`feb_1`) + `reg_headcount`.`mar_1`) / 3) AS `Q5`,((((((((((((`reg_headcount`.`jan` + `reg_headcount`.`feb`) + `reg_headcount`.`mar`) + `reg_headcount`.`apr`) + `reg_headcount`.`may`) + `reg_headcount`.`jun`) + `reg_headcount`.`jul`) + `reg_headcount`.`aug`) + `reg_headcount`.`sep`) + `reg_headcount`.`oct`) + `reg_headcount`.`nov`) + `reg_headcount`.`dec`) / 12) AS `Total`,((((((((((((`reg_headcount`.`jan_1` + `reg_headcount`.`feb_1`) + `reg_headcount`.`mar_1`) + `reg_headcount`.`apr`) + `reg_headcount`.`may`) + `reg_headcount`.`jun`) + `reg_headcount`.`jul`) + `reg_headcount`.`aug`) + `reg_headcount`.`sep`) + `reg_headcount`.`oct`) + `reg_headcount`.`nov`) + `reg_headcount`.`dec`) / 12) AS `Total_AM`,`reg_headcount`.`new_fte` AS `new` from (((((`reg_headcount` left join `vw_function` on((`vw_function`.`funGUID` = `reg_headcount`.`function`))) left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `reg_headcount`.`pc`))) left join `vw_product_type` on((`vw_product_type`.`prtID` = ifnull(`reg_headcount`.`activity`,`common_db`.`tbl_profit`.`pccProductTypeID`)))) left join `vw_location` on((`vw_location`.`locID` = `reg_headcount`.`location`))) left join `common_db`.`tbl_employee` on((`common_db`.`tbl_employee`.`empGUID1C` = `reg_headcount`.`particulars`))) where ((`reg_headcount`.`posted` = 1) and (`reg_headcount`.`active` = 1)) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_insurance`
--
DROP TABLE IF EXISTS `vw_insurance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_insurance`  AS  select `tbl_insurance`.`dmsID` AS `dmsID`,`tbl_insurance`.`dmsTitle` AS `dmsTitle`,`common_db`.`tbl_location`.`locTitle` AS `locTitle`,`tbl_insurance`.`dmsPrice` AS `dmsPrice` from (`tbl_insurance` join `common_db`.`tbl_location` on((`common_db`.`tbl_location`.`locID` = `tbl_insurance`.`dmsLocationID`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_item`
--
DROP TABLE IF EXISTS `vw_item`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_item`  AS  select `common_db`.`tbl_budget_item`.`itmID` AS `itmID`,`common_db`.`tbl_budget_item`.`itmGUID` AS `itmGUID`,`common_db`.`tbl_budget_item`.`itmTitle` AS `itmTitle`,`common_db`.`tbl_budget_item`.`itmTitleLocal` AS `itmTitleLocal`,`common_db`.`tbl_budget_item`.`itmParentID` AS `itmParentID`,`common_db`.`tbl_budget_item`.`itmFlagFolder` AS `itmFlagFolder`,`common_db`.`tbl_budget_item`.`itmFlagDeleted` AS `itmFlagDeleted`,`common_db`.`tbl_budget_item`.`itmInsertBy` AS `itmInsertBy`,`common_db`.`tbl_budget_item`.`itmInsertDate` AS `itmInsertDate`,`common_db`.`tbl_budget_item`.`itmEditBy` AS `itmEditBy`,`common_db`.`tbl_budget_item`.`itmEditDate` AS `itmEditDate`,`common_db`.`tbl_budget_item`.`itmYACTProd` AS `itmYACTProd`,`common_db`.`tbl_budget_item`.`itmYACTCorp` AS `itmYACTCorp`,`common_db`.`tbl_budget_item`.`itmOrder` AS `itmOrder`,`common_db`.`tbl_yact`.`yctTitle` AS `yctTitle` from (`common_db`.`tbl_budget_item` left join `common_db`.`tbl_yact` on((`common_db`.`tbl_yact`.`yctID` = `common_db`.`tbl_budget_item`.`itmYACTProd`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_journal`
--
DROP TABLE IF EXISTS `vw_journal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_journal`  AS  select `tbl_current_employee`.`cemID` AS `id`,`tbl_current_employee`.`cemGUID` AS `guid`,`tbl_current_employee`.`cemFlagPosted` AS `posted`,`tbl_current_employee`.`cemFlagDeleted` AS `deleted`,`tbl_current_employee`.`cemComment` AS `comment`,`tbl_current_employee`.`cemInsertBy` AS `insert_by`,`tbl_current_employee`.`cemInsertDate` AS `insert_date`,`tbl_current_employee`.`cemEditBy` AS `edit_by`,`tbl_current_employee`.`cemEditDate` AS `edit_date`,'Current employees' AS `title`,'cem' AS `prefix`,`tbl_current_employee`.`cemProfitID` AS `pc`,'tbl_current_employee' AS `table`,'employee_current_form.php' AS `script`,`tbl_current_employee`.`cemScenario` AS `scenario`,`tbl_current_employee`.`cemAmount` AS `amount`,`tbl_current_employee`.`cemUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_current_employee`.`cemCopyOf` AS `copy_of` from (`tbl_current_employee` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_current_employee`.`cemProfitID`))) union all select `tbl_new_employee`.`nemID` AS `id`,`tbl_new_employee`.`nemGUID` AS `guid`,`tbl_new_employee`.`nemFlagPosted` AS `posted`,`tbl_new_employee`.`nemFlagDeleted` AS `deleted`,`tbl_new_employee`.`nemComment` AS `comment`,`tbl_new_employee`.`nemInsertBy` AS `insert_by`,`tbl_new_employee`.`nemInsertDate` AS `insert_date`,`tbl_new_employee`.`nemEditBy` AS `edit_by`,`tbl_new_employee`.`nemEditDate` AS `edit_date`,'New employees' AS `title`,'nem' AS `prefix`,`tbl_new_employee`.`nemProfitID` AS `pc`,'tbl_new_employee' AS `table`,'employee_new_form.php' AS `script`,`tbl_new_employee`.`nemScenario` AS `scenario`,`tbl_new_employee`.`nemAmount` AS `amount`,`tbl_new_employee`.`nemUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_new_employee`.`nemCopyOf` AS `copy_of` from (`tbl_new_employee` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_new_employee`.`nemProfitID`))) union all select `tbl_depreciation`.`depID` AS `id`,`tbl_depreciation`.`depGUID` AS `guid`,`tbl_depreciation`.`depFlagPosted` AS `posted`,`tbl_depreciation`.`depFlagDeleted` AS `deleted`,`tbl_depreciation`.`depComment` AS `comment`,`tbl_depreciation`.`depInsertBy` AS `insert_by`,`tbl_depreciation`.`depInsertDate` AS `insert_date`,`tbl_depreciation`.`depEditBy` AS `edit_by`,`tbl_depreciation`.`depEditDate` AS `edit_date`,'Depreciation' AS `title`,'dep' AS `prefix`,`tbl_depreciation`.`depProfitID` AS `pc`,'tbl_depreciation' AS `table`,'depreciation_form.php' AS `script`,`tbl_depreciation`.`depScenario` AS `scenario`,`tbl_depreciation`.`depAmount` AS `amount`,`tbl_depreciation`.`depUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_depreciation`.`depCopyOf` AS `copy_of` from (`tbl_depreciation` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_depreciation`.`depProfitID`))) union all select `tbl_indirect_costs`.`icoID` AS `id`,`tbl_indirect_costs`.`icoGUID` AS `guid`,`tbl_indirect_costs`.`icoFlagPosted` AS `posted`,`tbl_indirect_costs`.`icoFlagDeleted` AS `deleted`,`tbl_indirect_costs`.`icoComment` AS `comment`,`tbl_indirect_costs`.`icoInsertBy` AS `insert_by`,`tbl_indirect_costs`.`icoInsertDate` AS `insert_date`,`tbl_indirect_costs`.`icoEditBy` AS `edit_by`,`tbl_indirect_costs`.`icoEditDate` AS `edit_date`,'Indirect costs' AS `title`,'ico' AS `prefix`,`tbl_indirect_costs`.`icoProfitID` AS `pc`,'tbl_indirect_costs' AS `table`,'indirect_costs_form.php' AS `script`,`tbl_indirect_costs`.`icoScenario` AS `scenario`,`tbl_indirect_costs`.`icoAmount` AS `amount`,`tbl_indirect_costs`.`icoUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_indirect_costs`.`icoCopyOf` AS `copy_of` from (`tbl_indirect_costs` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_indirect_costs`.`icoProfitID`))) union all select `tbl_location_costs`.`lcoID` AS `id`,`tbl_location_costs`.`lcoGUID` AS `guid`,`tbl_location_costs`.`lcoFlagPosted` AS `posted`,`tbl_location_costs`.`lcoFlagDeleted` AS `deleted`,`tbl_location_costs`.`lcoComment` AS `comment`,`tbl_location_costs`.`lcoInsertBy` AS `insert_by`,`tbl_location_costs`.`lcoInsertDate` AS `insert_date`,`tbl_location_costs`.`lcoEditBy` AS `edit_by`,`tbl_location_costs`.`lcoEditDate` AS `edit_date`,'Location costs' AS `title`,'lco' AS `prefix`,`tbl_location_costs`.`lcoLocationID` AS `pc`,'tbl_location_costs' AS `table`,'location_costs_form.php' AS `script`,`tbl_location_costs`.`lcoScenario` AS `scenario`,`tbl_location_costs`.`lcoAmount` AS `amount`,`tbl_location_costs`.`lcoUserID` AS `responsible`,`common_db`.`tbl_location`.`locTitle` AS `PL`,`tbl_location_costs`.`lcoCopyOf` AS `copy_of` from (`tbl_location_costs` left join `common_db`.`tbl_location` on((`common_db`.`tbl_location`.`locID` = `tbl_location_costs`.`lcoLocationID`))) union all select `tbl_sales`.`salID` AS `id`,`tbl_sales`.`salGUID` AS `guid`,`tbl_sales`.`salFlagPosted` AS `posted`,`tbl_sales`.`salFlagDeleted` AS `deleted`,concat('[',`common_db`.`tbl_counterparty`.`cntTitle`,'] ',ifnull(`tbl_sales`.`salComment`,'')) AS `comment`,`tbl_sales`.`salInsertBy` AS `insert_by`,`tbl_sales`.`salInsertDate` AS `insert_date`,`tbl_sales`.`salEditBy` AS `edit_by`,`tbl_sales`.`salEditDate` AS `edit_date`,'Sales' AS `title`,'sal' AS `prefix`,`tbl_sales`.`salProfitID` AS `pc`,'tbl_sales' AS `table`,'sales_form.php' AS `script`,`tbl_sales`.`salScenario` AS `scenario`,`tbl_sales`.`salAmount` AS `amount`,`tbl_sales`.`salUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_sales`.`salCopyOf` AS `copy_of` from ((`tbl_sales` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_sales`.`salProfitID`))) left join `common_db`.`tbl_counterparty` on((`common_db`.`tbl_counterparty`.`cntID` = `tbl_sales`.`salCustomerID`))) union all select `tbl_interco_sales`.`icsID` AS `id`,`tbl_interco_sales`.`icsGUID` AS `guid`,`tbl_interco_sales`.`icsFlagPosted` AS `posted`,`tbl_interco_sales`.`icsFlagDeleted` AS `deleted`,`tbl_interco_sales`.`icsComment` AS `comment`,`tbl_interco_sales`.`icsInsertBy` AS `insert_by`,`tbl_interco_sales`.`icsInsertDate` AS `insert_date`,`tbl_interco_sales`.`icsEditBy` AS `edit_by`,`tbl_interco_sales`.`icsEditDate` AS `edit_date`,'Intercompany sales' AS `title`,'ics' AS `prefix`,`tbl_interco_sales`.`icsProfitID` AS `pc`,'tbl_interco_sales' AS `table`,'interco_sales_form.php' AS `script`,`tbl_interco_sales`.`icsScenario` AS `scenario`,`tbl_interco_sales`.`icsAmount` AS `amount`,`tbl_interco_sales`.`icsUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_interco_sales`.`icsCopyOf` AS `copy_of` from (`tbl_interco_sales` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_interco_sales`.`icsProfitID`))) union all select `tbl_general_costs`.`genID` AS `id`,`tbl_general_costs`.`genGUID` AS `guid`,`tbl_general_costs`.`genFlagPosted` AS `posted`,`tbl_general_costs`.`genFlagDeleted` AS `deleted`,`tbl_general_costs`.`genComment` AS `comment`,`tbl_general_costs`.`genInsertBy` AS `insert_by`,`tbl_general_costs`.`genInsertDate` AS `insert_date`,`tbl_general_costs`.`genEditBy` AS `edit_by`,`tbl_general_costs`.`genEditDate` AS `edit_date`,'General costs' AS `title`,'gen' AS `prefix`,NULL AS `pc`,'tbl_general_costs' AS `table`,'general_cost_form.php' AS `script`,`tbl_general_costs`.`genScenario` AS `scenario`,`tbl_general_costs`.`genAmount` AS `amount`,`tbl_general_costs`.`genUserID` AS `responsible`,NULL AS `PL`,`tbl_general_costs`.`genCopyOf` AS `copy_of` from `tbl_general_costs` union all select `tbl_vehicle`.`vehID` AS `id`,`tbl_vehicle`.`vehGUID` AS `guid`,`tbl_vehicle`.`vehFlagPosted` AS `posted`,`tbl_vehicle`.`vehFlagDeleted` AS `deleted`,`tbl_vehicle`.`vehComment` AS `comment`,`tbl_vehicle`.`vehInsertBy` AS `insert_by`,`tbl_vehicle`.`vehInsertDate` AS `insert_date`,`tbl_vehicle`.`vehEditBy` AS `edit_by`,`tbl_vehicle`.`vehEditDate` AS `edit_date`,'Vehicles' AS `title`,'veh' AS `prefix`,`tbl_vehicle`.`vehProfitID` AS `pc`,'tbl_vehicle' AS `table`,'vehicle_form.php' AS `script`,`tbl_vehicle`.`vehScenario` AS `scenario`,`tbl_vehicle`.`vehAmount` AS `amount`,`tbl_vehicle`.`vehUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_vehicle`.`vehCopyOf` AS `copy_of` from (`tbl_vehicle` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_vehicle`.`vehProfitID`))) union all select `tbl_investment`.`invID` AS `id`,`tbl_investment`.`invGUID` AS `guid`,`tbl_investment`.`invFlagPosted` AS `posted`,`tbl_investment`.`invFlagDeleted` AS `deleted`,`tbl_investment`.`invComment` AS `comment`,`tbl_investment`.`invInsertBy` AS `insert_by`,`tbl_investment`.`invInsertDate` AS `insert_date`,`tbl_investment`.`invEditBy` AS `edit_by`,`tbl_investment`.`invEditDate` AS `edit_date`,'Investments' AS `title`,'inv' AS `prefix`,`tbl_investment`.`invProfitID` AS `pc`,'tbl_investment' AS `table`,'investment_form.php' AS `script`,`tbl_investment`.`invScenario` AS `scenario`,`tbl_investment`.`invAmount` AS `amount`,`tbl_investment`.`invUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_investment`.`invCopyOf` AS `copy_of` from (`tbl_investment` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_investment`.`invProfitID`))) union all select `tbl_kaizen`.`kznID` AS `id`,`tbl_kaizen`.`kznGUID` AS `guid`,`tbl_kaizen`.`kznFlagPosted` AS `posted`,`tbl_kaizen`.`kznFlagDeleted` AS `deleted`,`tbl_kaizen`.`kznComment` AS `comment`,`tbl_kaizen`.`kznInsertBy` AS `insert_by`,`tbl_kaizen`.`kznInsertDate` AS `insert_date`,`tbl_kaizen`.`kznEditBy` AS `edit_by`,`tbl_kaizen`.`kznEditDate` AS `edit_date`,'Kaizen' AS `title`,'kzn' AS `prefix`,NULL AS `pc`,'tbl_kaizen' AS `table`,'kaizen_form.php' AS `script`,`tbl_kaizen`.`kznScenario` AS `scenario`,`tbl_kaizen`.`kznAmount` AS `amount`,`tbl_kaizen`.`kznUserID` AS `responsible`,NULL AS `PL`,`tbl_kaizen`.`kznCopyOf` AS `copy_of` from `tbl_kaizen` union all select `tbl_msf`.`msfID` AS `id`,`tbl_msf`.`msfGUID` AS `guid`,`tbl_msf`.`msfFlagPosted` AS `posted`,`tbl_msf`.`msfFlagDeleted` AS `deleted`,`tbl_msf`.`msfComment` AS `comment`,`tbl_msf`.`msfInsertBy` AS `insert_by`,`tbl_msf`.`msfInsertDate` AS `insert_date`,`tbl_msf`.`msfEditBy` AS `edit_by`,`tbl_msf`.`msfEditDate` AS `edit_date`,'HQ distribution' AS `title`,'msf' AS `prefix`,`tbl_msf`.`msfProfitID` AS `pc`,'tbl_msf' AS `table`,'msf_form.php' AS `script`,`tbl_msf`.`msfScenario` AS `scenario`,`tbl_msf`.`msfAmount` AS `amount`,`tbl_msf`.`msfUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_msf`.`msfCopyOf` AS `copy_of` from (`tbl_msf` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_msf`.`msfProfitID`))) union all select `tbl_rent`.`rntID` AS `id`,`tbl_rent`.`rntGUID` AS `guid`,`tbl_rent`.`rntFlagPosted` AS `posted`,`tbl_rent`.`rntFlagDeleted` AS `deleted`,`tbl_rent`.`rntComment` AS `comment`,`tbl_rent`.`rntInsertBy` AS `insert_by`,`tbl_rent`.`rntInsertDate` AS `insert_date`,`tbl_rent`.`rntEditBy` AS `edit_by`,`tbl_rent`.`rntEditDate` AS `edit_date`,'Cost distribution' AS `title`,'rnt' AS `prefix`,`tbl_rent`.`rntProfitID` AS `pc`,'tbl_rent' AS `table`,'rent_form.php' AS `script`,`tbl_rent`.`rntScenario` AS `scenario`,`tbl_rent`.`rntAmount` AS `amount`,`tbl_rent`.`rntUserID` AS `responsible`,`common_db`.`tbl_profit`.`pccTitle` AS `PL`,`tbl_rent`.`rntCopyOf` AS `copy_of` from (`tbl_rent` left join `common_db`.`tbl_profit` on((`common_db`.`tbl_profit`.`pccID` = `tbl_rent`.`rntProfitID`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_location`
--
DROP TABLE IF EXISTS `vw_location`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_location`  AS  select `common_db`.`tbl_location`.`locID` AS `locID`,`common_db`.`tbl_location`.`locGUID` AS `locGUID`,`common_db`.`tbl_location`.`locTitle` AS `locTitle`,`common_db`.`tbl_location`.`locTitleLocal` AS `locTitleLocal`,`common_db`.`tbl_location`.`locKPP` AS `locKPP`,`common_db`.`tbl_location`.`locAddress` AS `locAddress`,`common_db`.`tbl_location`.`locAddressLocal` AS `locAddressLocal`,`common_db`.`tbl_location`.`locZip` AS `locZip`,`common_db`.`tbl_location`.`locCity` AS `locCity`,`common_db`.`tbl_location`.`locCityLocal` AS `locCityLocal`,`common_db`.`tbl_location`.`locPhone` AS `locPhone`,`common_db`.`tbl_location`.`locFax` AS `locFax`,`common_db`.`tbl_location`.`locCountry` AS `locCountry`,`common_db`.`tbl_location`.`locInsertBy` AS `locInsertBy`,`common_db`.`tbl_location`.`locInsertDate` AS `locInsertDate`,`common_db`.`tbl_location`.`locEditBy` AS `locEditBy`,`common_db`.`tbl_location`.`locEditDate` AS `locEditDate`,`common_db`.`tbl_location`.`locFlagDeleted` AS `locFlagDeleted` from `common_db`.`tbl_location` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_master`
--
DROP TABLE IF EXISTS `vw_master`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_master`  AS  select `reg_master`.`company` AS `company`,`reg_master`.`pc` AS `pc`,`reg_master`.`activity` AS `activity`,`reg_master`.`customer` AS `customer`,`reg_master`.`account` AS `account`,`reg_master`.`item` AS `item`,`reg_master`.`jan` AS `jan`,`reg_master`.`feb` AS `feb`,`reg_master`.`mar` AS `mar`,`reg_master`.`apr` AS `apr`,`reg_master`.`may` AS `may`,`reg_master`.`jun` AS `jun`,`reg_master`.`jul` AS `jul`,`reg_master`.`aug` AS `aug`,`reg_master`.`sep` AS `sep`,`reg_master`.`oct` AS `oct`,`reg_master`.`nov` AS `nov`,`reg_master`.`dec` AS `dec`,`reg_master`.`jan_1` AS `jan_1`,`reg_master`.`feb_1` AS `feb_1`,`reg_master`.`mar_1` AS `mar_1`,`reg_master`.`source` AS `source`,`reg_master`.`scenario` AS `scenario`,`reg_master`.`particulars` AS `particulars`,`reg_master`.`part_type` AS `part_type`,`reg_master`.`estimate` AS `estimate`,`reg_master`.`vat` AS `vat`,`reg_master`.`deductible` AS `deductible`,`reg_master`.`cf` AS `cf`,`reg_master`.`timestamp` AS `timestamp`,(((((((((((`reg_master`.`jan` + `reg_master`.`feb`) + `reg_master`.`mar`) + `reg_master`.`apr`) + `reg_master`.`may`) + `reg_master`.`jun`) + `reg_master`.`jul`) + `reg_master`.`aug`) + `reg_master`.`sep`) + `reg_master`.`oct`) + `reg_master`.`nov`) + `reg_master`.`dec`) AS `Total`,((((((((((((((`reg_master`.`jan` + `reg_master`.`feb`) + `reg_master`.`mar`) + `reg_master`.`apr`) + `reg_master`.`may`) + `reg_master`.`jun`) + `reg_master`.`jul`) + `reg_master`.`aug`) + `reg_master`.`sep`) + `reg_master`.`oct`) + `reg_master`.`nov`) + `reg_master`.`dec`) + `reg_master`.`jan_1`) + `reg_master`.`feb_1`) + `reg_master`.`mar_1`) AS `Total_15`,(((((((((((`reg_master`.`apr` + `reg_master`.`may`) + `reg_master`.`jun`) + `reg_master`.`jul`) + `reg_master`.`aug`) + `reg_master`.`sep`) + `reg_master`.`oct`) + `reg_master`.`nov`) + `reg_master`.`dec`) + `reg_master`.`jan_1`) + `reg_master`.`feb_1`) + `reg_master`.`mar_1`) AS `Total_AM`,((`reg_master`.`jan` + `reg_master`.`feb`) + `reg_master`.`mar`) AS `Q1`,((`reg_master`.`apr` + `reg_master`.`may`) + `reg_master`.`jun`) AS `Q2`,((`reg_master`.`jul` + `reg_master`.`aug`) + `reg_master`.`sep`) AS `Q3`,((`reg_master`.`oct` + `reg_master`.`nov`) + `reg_master`.`dec`) AS `Q4`,((`reg_master`.`jan_1` + `reg_master`.`feb_1`) + `reg_master`.`mar_1`) AS `Q5`,`reg_master`.`ytd` AS `YTD`,`reg_master`.`roy` AS `ROY`,`item`.`itmTitle` AS `Budget item`,`p_item`.`itmTitle` AS `Group`,`p_item`.`itmID` AS `Group_code`,`item`.`itmOrder` AS `itmOrder`,`vw_profit`.`pccTitle` AS `Profit`,`vw_profit`.`pccTitleLocal` AS `ProfitLocal`,`vw_yact`.`yctTitle` AS `Title`,`cus`.`cntTitle` AS `Customer_name`,`reg_master`.`customer_group_code` AS `customer_group_code`,`cg`.`cntTitle` AS `customer_group_title`,`vw_product_type`.`prtTitle` AS `Activity_title`,`vw_product_type`.`prtTitleLocal` AS `Activity_title_local`,`vw_product_type`.`prtRHQ` AS `prtRHQ`,`vw_product_type`.`prtGHQ` AS `prtGHQ`,`vw_profit`.`pccFlagProd` AS `pccFlagProd`,`yp`.`yctTitle` AS `yact_group`,`yp`.`yctID` AS `yact_group_code`,`reg_master`.`sales` AS `sales`,`sal`.`usrTitle` AS `usrTitle`,`reg_master`.`bdv` AS `bdv`,`pcs`.`pccTitle` AS `bdvTitle`,`pcg`.`pccCode1C` AS `bu_group`,`pcg`.`pccTitle` AS `bu_group_title`,`common_db`.`tbl_industry`.`ivlTitle` AS `ivlTitle`,`common_db`.`tbl_industry`.`ivlGroup` AS `ivlGroup`,`common_db`.`tbl_industry`.`ivlGUID` AS `ivlGUID`,`reg_master`.`new` AS `new`,`vw_product_type`.`prtTitleLocal` AS `Activity_titleLocal`,`cus`.`cntYear` AS `cntYear` from ((((((((((((`reg_master` left join `vw_item` `item` on((`item`.`itmGUID` = `reg_master`.`item`))) left join `vw_item` `p_item` on((`p_item`.`itmID` = `item`.`itmParentID`))) left join `common_db`.`tbl_profit` `vw_profit` on((`vw_profit`.`pccID` = `reg_master`.`pc`))) left join `vw_yact` on((`vw_yact`.`yctID` = `reg_master`.`account`))) left join `common_db`.`tbl_counterparty` `cus` on((`cus`.`cntID` = `reg_master`.`customer`))) left join `vw_product_type` on((`vw_product_type`.`prtID` = `reg_master`.`activity`))) left join `vw_yact` `yp` on((`yp`.`yctID` = `vw_yact`.`yctParentID`))) left join `stbl_user` `sal` on((`reg_master`.`sales` = `sal`.`usrID`))) left join `common_db`.`tbl_counterparty` `cg` on((`cg`.`cntID` = `reg_master`.`customer_group_code`))) left join `common_db`.`tbl_profit` `pcs` on((`pcs`.`pccID` = `reg_master`.`bdv`))) left join `common_db`.`tbl_profit` `pcg` on((`pcg`.`pccCode1C` = `vw_profit`.`pccParentCode1C`))) left join `common_db`.`tbl_industry` on((`common_db`.`tbl_industry`.`ivlGUID` = `cus`.`cntIndustryID`))) where (`reg_master`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_pb_intercompany`
--
DROP TABLE IF EXISTS `vw_pb_intercompany`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_pb_intercompany`  AS  select `common_db`.`tbl_counterparty`.`cntID` AS `cntID`,`common_db`.`tbl_counterparty`.`cntTitle` AS `cntTitle`,`common_db`.`tbl_counterparty`.`cntTitleLocal` AS `cntTitleLocal`,`common_db`.`tbl_counterparty`.`cntFlagDeleted` AS `cntFlagDeleted`,`common_db`.`tbl_counterparty`.`cntFlagConfirmed` AS `cntFlagConfirmed`,`common_db`.`tbl_counterparty`.`cntINN` AS `cntINN`,`common_db`.`tbl_counterparty`.`cntKPP` AS `cntKPP`,`common_db`.`tbl_counterparty`.`cntID1C` AS `cntID1C`,`common_db`.`tbl_counterparty`.`cntOGRN` AS `cntOGRN`,`common_db`.`tbl_counterparty`.`cntParentID` AS `cntParentID`,`common_db`.`tbl_counterparty`.`cntParentID1C` AS `cntParentID1C`,`common_db`.`tbl_counterparty`.`cntParentCode1C` AS `cntParentCode1C`,`common_db`.`tbl_counterparty`.`cntCode1C` AS `cntCode1C`,`common_db`.`tbl_counterparty`.`cntGDS` AS `cntGDS`,`common_db`.`tbl_counterparty`.`cntGDSCountry` AS `cntGDSCountry`,`common_db`.`tbl_counterparty`.`cntGDSCity` AS `cntGDSCity`,`common_db`.`tbl_counterparty`.`cntFlagFolder` AS `cntFlagFolder`,`common_db`.`tbl_counterparty`.`cntFlagCustomer` AS `cntFlagCustomer`,`common_db`.`tbl_counterparty`.`cntFlagSupplier` AS `cntFlagSupplier`,`common_db`.`tbl_counterparty`.`cntBalanceCustomer` AS `cntBalanceCustomer`,`common_db`.`tbl_counterparty`.`cntBalanceSupplier` AS `cntBalanceSupplier`,`common_db`.`tbl_counterparty`.`cntUserID` AS `cntUserID`,`common_db`.`tbl_counterparty`.`cntOperationsID` AS `cntOperationsID`,`common_db`.`tbl_counterparty`.`cntAccountantID` AS `cntAccountantID`,`common_db`.`tbl_counterparty`.`cntCostID` AS `cntCostID`,`common_db`.`tbl_counterparty`.`cntProfitID` AS `cntProfitID`,`common_db`.`tbl_counterparty`.`cntCreditDays` AS `cntCreditDays`,`common_db`.`tbl_counterparty`.`cntFile` AS `cntFile`,`common_db`.`tbl_counterparty`.`cntFlagBankingDays` AS `cntFlagBankingDays`,`common_db`.`tbl_counterparty`.`cntCitiProfile` AS `cntCitiProfile`,`common_db`.`tbl_counterparty`.`cntTitleFullLocal` AS `cntTitleFullLocal`,`common_db`.`tbl_counterparty`.`cntFlagSpecs` AS `cntFlagSpecs`,`common_db`.`tbl_counterparty`.`cntAccountID1C` AS `cntAccountID1C`,`common_db`.`tbl_counterparty`.`cntAccountCode1C` AS `cntAccountCode1C`,`common_db`.`tbl_counterparty`.`cntFlagNR` AS `cntFlagNR`,`common_db`.`tbl_counterparty`.`cntCustomerID` AS `cntCustomerID`,`common_db`.`tbl_counterparty`.`cntAgreementID` AS `cntAgreementID`,`common_db`.`tbl_counterparty`.`cntAddress` AS `cntAddress`,`common_db`.`tbl_counterparty`.`cntLegalAddress` AS `cntLegalAddress`,`common_db`.`tbl_counterparty`.`cntContact` AS `cntContact`,`common_db`.`tbl_counterparty`.`cntPhone` AS `cntPhone`,`common_db`.`tbl_counterparty`.`cntFax` AS `cntFax`,`common_db`.`tbl_counterparty`.`cntEmailBilling` AS `cntEmailBilling`,`common_db`.`tbl_counterparty`.`cntLocationID` AS `cntLocationID`,`common_db`.`tbl_counterparty`.`cntGUID` AS `cntGUID`,`common_db`.`tbl_counterparty`.`cntGUID1C` AS `cntGUID1C`,`common_db`.`tbl_counterparty`.`cntCurConvert` AS `cntCurConvert`,`common_db`.`tbl_counterparty`.`cntOurbankaccountID` AS `cntOurbankaccountID`,`common_db`.`tbl_counterparty`.`cntReasonID` AS `cntReasonID`,`common_db`.`tbl_counterparty`.`cntFlagRequest` AS `cntFlagRequest`,`common_db`.`tbl_counterparty`.`cntPrefix` AS `cntPrefix`,`common_db`.`tbl_counterparty`.`cntCalcDate` AS `cntCalcDate`,`common_db`.`tbl_counterparty`.`cntInsertBy` AS `cntInsertBy`,`common_db`.`tbl_counterparty`.`cntInsertDate` AS `cntInsertDate`,`common_db`.`tbl_counterparty`.`cntEditBy` AS `cntEditBy`,`common_db`.`tbl_counterparty`.`cntEditDate` AS `cntEditDate`,`common_db`.`tbl_counterparty`.`cntTaxcomID` AS `cntTaxcomID` from `common_db`.`tbl_counterparty` where ((`common_db`.`tbl_counterparty`.`cntIdxLeft` between (select `common_db`.`tbl_counterparty`.`cntIdxLeft` from `common_db`.`tbl_counterparty` where (`common_db`.`tbl_counterparty`.`cntID` = 11680)) and (select `common_db`.`tbl_counterparty`.`cntIdxRight` from `common_db`.`tbl_counterparty` where (`common_db`.`tbl_counterparty`.`cntID` = 11680))) and (`common_db`.`tbl_counterparty`.`cntFlagFolder` = 0) and (`common_db`.`tbl_counterparty`.`cntFlagDeleted` = 0)) order by `common_db`.`tbl_counterparty`.`cntTitle` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_port`
--
DROP TABLE IF EXISTS `vw_port`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_port`  AS  select `geo`.`tbl_port`.`prtID` AS `optValue`,(cast(concat(`geo`.`tbl_port`.`prtTitle`,', ',`geo`.`tbl_country`.`cntTitle`,' (',`geo`.`tbl_port`.`prtCountryID`,`geo`.`tbl_port`.`prtLOCODE`,')') as char charset utf8) collate utf8_general_ci) AS `optText`,(cast(concat(`geo`.`tbl_port`.`prtTitle`,', ',`geo`.`tbl_country`.`cntTitle`,' (',`geo`.`tbl_port`.`prtCountryID`,`geo`.`tbl_port`.`prtLOCODE`,')') as char charset utf8) collate utf8_general_ci) AS `optTextLocal`,(case `geo`.`tbl_port`.`prtFlagValid` when 0 then 1 else 0 end) AS `optFlagDeleted` from (`geo`.`tbl_port` join `geo`.`tbl_country` on((`geo`.`tbl_port`.`prtCountryID` = `geo`.`tbl_country`.`cntID`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_product`
--
DROP TABLE IF EXISTS `vw_product`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_product`  AS  select `prd`.`prdID` AS `prdID`,`prd`.`prdGUID` AS `prdGUID`,`prd`.`prdGUID1C` AS `prdGUID1C`,`prd`.`prdIdxLeft` AS `prdIdxLeft`,`prd`.`prdIdxRight` AS `prdIdxRight`,`prd`.`prdNlogjcID` AS `prdNlogjcID`,`prd`.`prdExternalID` AS `prdExternalID`,`prd`.`prdTitle` AS `prdTitle`,`prd`.`prdTitleLocal` AS `prdTitleLocal`,`prd`.`prdFlagDeleted` AS `prdFlagDeleted`,`prd`.`prdParentID` AS `prdParentID`,`prd`.`prdFlagFolder` AS `prdFlagFolder`,`prd`.`prdPrice` AS `prdPrice`,`prd`.`prdCurrencyID` AS `prdCurrencyID`,`prd`.`prdCategoryID` AS `prdCategoryID`,`prd`.`prdCostID` AS `prdCostID`,`prd`.`prdUnitID` AS `prdUnitID`,`prd`.`prdDescr` AS `prdDescr`,`prd`.`prdDescrLocal` AS `prdDescrLocal`,`prd`.`prdGDS` AS `prdGDS`,`prd`.`prdInsertBy` AS `prdInsertBy`,`prd`.`prdInsertDate` AS `prdInsertDate`,`prd`.`prdEditBy` AS `prdEditBy`,`prd`.`prdEditDate` AS `prdEditDate`,`prd`.`prdValue` AS `prdValue`,`prt`.`prtUnit` AS `prtUnit` from (`common_db`.`tbl_product` `prd` left join `common_db`.`tbl_product_type` `prt` on((`prt`.`prtID` = `prd`.`prdCategoryID`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_product_select`
--
DROP TABLE IF EXISTS `vw_product_select`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_product_select`  AS  select `common_db`.`tbl_product`.`prdID` AS `optValue`,`common_db`.`tbl_product`.`prdTitleLocal` AS `optText`,`common_db`.`tbl_product`.`prdTitleLocal` AS `optTextLocal`,`common_db`.`tbl_product`.`prdFlagDeleted` AS `optFlagDeleted` from `common_db`.`tbl_product` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_product_type`
--
DROP TABLE IF EXISTS `vw_product_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_product_type`  AS  select `common_db`.`tbl_product_type`.`prtID` AS `prtID`,`common_db`.`tbl_product_type`.`prtGUID` AS `prtGUID`,`common_db`.`tbl_product_type`.`prtGUID1C` AS `prtGUID1C`,`common_db`.`tbl_product_type`.`prtTitle` AS `prtTitle`,`common_db`.`tbl_product_type`.`prtTitleLocal` AS `prtTitleLocal`,`common_db`.`tbl_product_type`.`prtFlagDeleted` AS `prtFlagDeleted`,`common_db`.`tbl_product_type`.`prtParentID` AS `prtParentID`,`common_db`.`tbl_product_type`.`prtFlagFolder` AS `prtFlagFolder`,`common_db`.`tbl_product_type`.`prtInsertBy` AS `prtInsertBy`,`common_db`.`tbl_product_type`.`prtInsertDate` AS `prtInsertDate`,`common_db`.`tbl_product_type`.`prtEditBy` AS `prtEditBy`,`common_db`.`tbl_product_type`.`prtEditDate` AS `prtEditDate`,`common_db`.`tbl_product_type`.`prtRHQ` AS `prtRHQ`,`common_db`.`tbl_product_type`.`prtGHQ` AS `prtGHQ`,`common_db`.`tbl_product_type`.`prtYACT` AS `prtYACT`,`common_db`.`tbl_product_type`.`prtBudgetIncomeID` AS `prtBudgetIncomeID`,`common_db`.`tbl_product_type`.`prtBudgetCostID` AS `prtBudgetCostID`,`common_db`.`tbl_product_type`.`prtUnit` AS `prtUnit`,`common_db`.`tbl_yact`.`yctTitle` AS `yctTitle` from (`common_db`.`tbl_product_type` left join `common_db`.`tbl_yact` on((`common_db`.`tbl_yact`.`yctID` = `common_db`.`tbl_product_type`.`prtYACT`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_product_type_select`
--
DROP TABLE IF EXISTS `vw_product_type_select`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_product_type_select`  AS  select `common_db`.`tbl_product_type`.`prtID` AS `optValue`,`common_db`.`tbl_product_type`.`prtTitle` AS `optText`,`common_db`.`tbl_product_type`.`prtTitleLocal` AS `optTitleLocal`,`common_db`.`tbl_product_type`.`prtFlagDeleted` AS `optFlagDeleted` from `common_db`.`tbl_product_type` order by `common_db`.`tbl_product_type`.`prtGHQ`,`common_db`.`tbl_product_type`.`prtTitle` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_profit`
--
DROP TABLE IF EXISTS `vw_profit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_profit`  AS  select `common_db`.`tbl_profit`.`pccID` AS `pccID`,`common_db`.`tbl_profit`.`pccGUID` AS `pccGUID`,`common_db`.`tbl_profit`.`pccCode1C` AS `pccCode1C`,`common_db`.`tbl_profit`.`pccTitle` AS `pccTitle`,`common_db`.`tbl_profit`.`pccTitleLocal` AS `pccTitleLocal`,`common_db`.`tbl_profit`.`pccTitleFull` AS `pccTitleFull`,`common_db`.`tbl_profit`.`pccFlagDeleted` AS `pccFlagDeleted`,`common_db`.`tbl_profit`.`pccInsertBy` AS `pccInsertBy`,`common_db`.`tbl_profit`.`pccInsertDate` AS `pccInsertDate`,`common_db`.`tbl_profit`.`pccEditBy` AS `pccEditBy`,`common_db`.`tbl_profit`.`pccEditDate` AS `pccEditDate`,`common_db`.`tbl_profit`.`pccManagerRoleID` AS `pccManagerRoleID`,`common_db`.`tbl_profit`.`pccPhone` AS `pccPhone`,`common_db`.`tbl_profit`.`pccScanFolder` AS `pccScanFolder`,`common_db`.`tbl_profit`.`pccAddress` AS `pccAddress`,`common_db`.`tbl_profit`.`pccCity` AS `pccCity`,`common_db`.`tbl_profit`.`pccZip` AS `pccZip`,`common_db`.`tbl_profit`.`pccCountry` AS `pccCountry`,`common_db`.`tbl_profit`.`pccDefaultLocation` AS `pccDefaultLocation`,`common_db`.`tbl_profit`.`pccFlagProd` AS `pccFlagProd`,`common_db`.`tbl_profit`.`pccCompanyID` AS `pccCompanyID`,`common_db`.`tbl_profit`.`pccParentCode1C` AS `pccParentCode1C`,`common_db`.`tbl_profit`.`pccFlagFolder` AS `pccFlagFolder`,`common_db`.`tbl_profit`.`pccManagerID` AS `pccManagerID`,`common_db`.`tbl_profit`.`pccProductTypeID` AS `pccProductTypeID` from `common_db`.`tbl_profit` ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_rfc`
--
DROP TABLE IF EXISTS `vw_rfc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_rfc`  AS  select `common_db`.`tbl_yact`.`yctID` AS `yctID`,`common_db`.`tbl_yact`.`yctGUID` AS `yctGUID`,`common_db`.`tbl_yact`.`yctTitle` AS `yctTitle`,`common_db`.`tbl_yact`.`yctTitleLocal` AS `yctTitleLocal`,`common_db`.`tbl_yact`.`yctParentID` AS `yctParentID`,`common_db`.`tbl_yact`.`yctFlagFolder` AS `yctFlagFolder`,`common_db`.`tbl_yact`.`yctFlagDeleted` AS `yctFlagDeleted`,`common_db`.`tbl_yact`.`yctInsertBy` AS `yctInsertBy`,`common_db`.`tbl_yact`.`yctInsertDate` AS `yctInsertDate`,`common_db`.`tbl_yact`.`yctEditBy` AS `yctEditBy`,`common_db`.`tbl_yact`.`yctEditDate` AS `yctEditDate` from `common_db`.`tbl_yact` where ((`common_db`.`tbl_yact`.`yctID` like 'J%') and (`common_db`.`tbl_yact`.`yctID` not in ('J00400','J00802','J45010','J40010')) and (`common_db`.`tbl_yact`.`yctFlagFolder` = 0)) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_sales`
--
DROP TABLE IF EXISTS `vw_sales`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_sales`  AS  select `reg_sales`.`scenario` AS `scenario`,`reg_sales`.`company` AS `company`,`vw_profit`.`pccTitle` AS `pccTitle`,`vw_product_type`.`prtTitle` AS `prtTitle`,`reg_sales`.`activity` AS `Activity`,`vw_product_type`.`prtUnit` AS `Unit`,`vw_product_type`.`prtGHQ` AS `GHQ Activity`,`cus`.`cntTitle` AS `cntTitle`,`cus`.`cntTitle` AS `Customer_name`,`reg_sales`.`customer` AS `customer`,`reg_sales`.`source` AS `source`,`tbl_route`.`rteTitle` AS `OFF_Route`,`reg_sales`.`posted` AS `posted`,`reg_sales`.`active` AS `active`,`reg_sales`.`kpi` AS `kpi`,`reg_sales`.`pc` AS `pc`,`reg_sales`.`jan` AS `jan`,`reg_sales`.`feb` AS `feb`,`reg_sales`.`mar` AS `mar`,`reg_sales`.`apr` AS `apr`,`reg_sales`.`may` AS `may`,`reg_sales`.`jun` AS `jun`,`reg_sales`.`jul` AS `jul`,`reg_sales`.`aug` AS `aug`,`reg_sales`.`sep` AS `sep`,`reg_sales`.`oct` AS `oct`,`reg_sales`.`nov` AS `nov`,`reg_sales`.`dec` AS `dec`,`reg_sales`.`jan_1` AS `jan_1`,`reg_sales`.`feb_1` AS `feb_1`,`reg_sales`.`mar_1` AS `mar_1`,((`reg_sales`.`jan` + `reg_sales`.`feb`) + `reg_sales`.`mar`) AS `Q1`,((`reg_sales`.`apr` + `reg_sales`.`may`) + `reg_sales`.`jun`) AS `Q2`,((`reg_sales`.`jul` + `reg_sales`.`aug`) + `reg_sales`.`sep`) AS `Q3`,((`reg_sales`.`oct` + `reg_sales`.`nov`) + `reg_sales`.`dec`) AS `Q4`,((`reg_sales`.`jan_1` + `reg_sales`.`feb_1`) + `reg_sales`.`mar_1`) AS `Q5`,(((((((((((`reg_sales`.`jan` + `reg_sales`.`feb`) + `reg_sales`.`mar`) + `reg_sales`.`apr`) + `reg_sales`.`may`) + `reg_sales`.`jun`) + `reg_sales`.`jul`) + `reg_sales`.`aug`) + `reg_sales`.`sep`) + `reg_sales`.`oct`) + `reg_sales`.`nov`) + `reg_sales`.`dec`) AS `Total`,(((((((((((`reg_sales`.`jan_1` + `reg_sales`.`feb_1`) + `reg_sales`.`mar_1`) + `reg_sales`.`apr`) + `reg_sales`.`may`) + `reg_sales`.`jun`) + `reg_sales`.`jul`) + `reg_sales`.`aug`) + `reg_sales`.`sep`) + `reg_sales`.`oct`) + `reg_sales`.`nov`) + `reg_sales`.`dec`) AS `Total_AM`,`reg_sales`.`customer_group_code` AS `customer_group_code`,`cg`.`cntTitle` AS `customer_group_title`,`vw_product_type`.`prtGHQ` AS `prtGHQ`,`reg_sales`.`bo` AS `bo`,`reg_sales`.`jo` AS `jo`,`reg_sales`.`freehand` AS `freehand`,`reg_sales`.`new` AS `new` from (((((`reg_sales` left join `vw_product_type` on((`vw_product_type`.`prtID` = `reg_sales`.`activity`))) left join `common_db`.`tbl_counterparty` `cus` on((`cus`.`cntID` = `reg_sales`.`customer`))) left join `vw_profit` on((`reg_sales`.`pc` = `vw_profit`.`pccID`))) left join `tbl_route` on((`reg_sales`.`route` = `tbl_route`.`rteID`))) left join `common_db`.`tbl_counterparty` `cg` on((`cg`.`cntID` = `reg_sales`.`customer_group_code`))) where ((`reg_sales`.`posted` = 1) and (`reg_sales`.`kpi` = 1) and (`reg_sales`.`unit` <> '')) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_supplier`
--
DROP TABLE IF EXISTS `vw_supplier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_supplier`  AS  select `common_db`.`tbl_counterparty`.`cntID` AS `cntID`,`common_db`.`tbl_counterparty`.`cntTitle` AS `cntTitle`,`common_db`.`tbl_counterparty`.`cntTitleLocal` AS `cntTitleLocal`,`common_db`.`tbl_counterparty`.`cntFlagDeleted` AS `cntFlagDeleted`,`common_db`.`tbl_counterparty`.`cntFlagConfirmed` AS `cntFlagConfirmed`,`common_db`.`tbl_counterparty`.`cntINN` AS `cntINN`,`common_db`.`tbl_counterparty`.`cntKPP` AS `cntKPP`,`common_db`.`tbl_counterparty`.`cntID1C` AS `cntID1C`,`common_db`.`tbl_counterparty`.`cntOGRN` AS `cntOGRN`,`common_db`.`tbl_counterparty`.`cntParentID` AS `cntParentID`,`common_db`.`tbl_counterparty`.`cntParentID1C` AS `cntParentID1C`,`common_db`.`tbl_counterparty`.`cntParentCode1C` AS `cntParentCode1C`,`common_db`.`tbl_counterparty`.`cntCode1C` AS `cntCode1C`,`common_db`.`tbl_counterparty`.`cntGDS` AS `cntGDS`,`common_db`.`tbl_counterparty`.`cntGDSCountry` AS `cntGDSCountry`,`common_db`.`tbl_counterparty`.`cntGDSCity` AS `cntGDSCity`,`common_db`.`tbl_counterparty`.`cntFlagFolder` AS `cntFlagFolder`,`common_db`.`tbl_counterparty`.`cntFlagCustomer` AS `cntFlagCustomer`,`common_db`.`tbl_counterparty`.`cntFlagSupplier` AS `cntFlagSupplier`,`common_db`.`tbl_counterparty`.`cntBalanceCustomer` AS `cntBalanceCustomer`,`common_db`.`tbl_counterparty`.`cntBalanceSupplier` AS `cntBalanceSupplier`,`common_db`.`tbl_counterparty`.`cntUserID` AS `cntUserID`,`common_db`.`tbl_counterparty`.`cntAccountantID` AS `cntAccountantID`,`common_db`.`tbl_counterparty`.`cntCostID` AS `cntCostID`,`common_db`.`tbl_counterparty`.`cntProfitID` AS `cntProfitID`,`common_db`.`tbl_counterparty`.`cntCreditDays` AS `cntCreditDays`,`common_db`.`tbl_counterparty`.`cntFile` AS `cntFile`,`common_db`.`tbl_counterparty`.`cntFlagBankingDays` AS `cntFlagBankingDays`,`common_db`.`tbl_counterparty`.`cntCitiProfile` AS `cntCitiProfile`,`common_db`.`tbl_counterparty`.`cntTitleFullLocal` AS `cntTitleFullLocal`,`common_db`.`tbl_counterparty`.`cntFlagSpecs` AS `cntFlagSpecs`,`common_db`.`tbl_counterparty`.`cntAccountID1C` AS `cntAccountID1C`,`common_db`.`tbl_counterparty`.`cntAccountCode1C` AS `cntAccountCode1C`,`common_db`.`tbl_counterparty`.`cntFlagNR` AS `cntFlagNR`,`common_db`.`tbl_counterparty`.`cntCustomerID` AS `cntCustomerID`,`common_db`.`tbl_counterparty`.`cntAgreementID` AS `cntAgreementID`,`common_db`.`tbl_counterparty`.`cntAddress` AS `cntAddress`,`common_db`.`tbl_counterparty`.`cntLegalAddress` AS `cntLegalAddress`,`common_db`.`tbl_counterparty`.`cntContact` AS `cntContact`,`common_db`.`tbl_counterparty`.`cntPhone` AS `cntPhone`,`common_db`.`tbl_counterparty`.`cntFax` AS `cntFax`,`common_db`.`tbl_counterparty`.`cntEmailBilling` AS `cntEmailBilling`,`common_db`.`tbl_counterparty`.`cntLocationID` AS `cntLocationID`,`common_db`.`tbl_counterparty`.`cntGUID` AS `cntGUID`,`common_db`.`tbl_counterparty`.`cntGUID1C` AS `cntGUID1C`,`common_db`.`tbl_counterparty`.`cntCurConvert` AS `cntCurConvert`,`common_db`.`tbl_counterparty`.`cntOurbankaccountID` AS `cntOurbankaccountID`,`common_db`.`tbl_counterparty`.`cntReasonID` AS `cntReasonID`,`common_db`.`tbl_counterparty`.`cntFlagRequest` AS `cntFlagRequest`,`common_db`.`tbl_counterparty`.`cntPrefix` AS `cntPrefix`,`common_db`.`tbl_counterparty`.`cntCalcDate` AS `cntCalcDate`,`common_db`.`tbl_counterparty`.`cntInsertBy` AS `cntInsertBy`,`common_db`.`tbl_counterparty`.`cntInsertDate` AS `cntInsertDate`,`common_db`.`tbl_counterparty`.`cntEditBy` AS `cntEditBy`,`common_db`.`tbl_counterparty`.`cntEditDate` AS `cntEditDate` from `common_db`.`tbl_counterparty` where (`common_db`.`tbl_counterparty`.`cntFlagSupplier` = 1) ;

-- --------------------------------------------------------

--
-- Структура для представления `vw_yact`
--
DROP TABLE IF EXISTS `vw_yact`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vw_yact`  AS  select `common_db`.`tbl_yact`.`yctID` AS `yctID`,`common_db`.`tbl_yact`.`yctGUID` AS `yctGUID`,`common_db`.`tbl_yact`.`yctTitle` AS `yctTitle`,`common_db`.`tbl_yact`.`yctTitleLocal` AS `yctTitleLocal`,`common_db`.`tbl_yact`.`yctParentID` AS `yctParentID`,`common_db`.`tbl_yact`.`yctFlagFolder` AS `yctFlagFolder`,`common_db`.`tbl_yact`.`yctFlagDeleted` AS `yctFlagDeleted`,`common_db`.`tbl_yact`.`yctInsertBy` AS `yctInsertBy`,`common_db`.`tbl_yact`.`yctInsertDate` AS `yctInsertDate`,`common_db`.`tbl_yact`.`yctEditBy` AS `yctEditBy`,`common_db`.`tbl_yact`.`yctEditDate` AS `yctEditDate` from `common_db`.`tbl_yact` order by `common_db`.`tbl_yact`.`yctID` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ref_customer_profitability`
--
ALTER TABLE `ref_customer_profitability`
  ADD KEY `customer` (`customer`),
  ADD KEY `activity` (`activity`);

--
-- Индексы таблицы `ref_route`
--
ALTER TABLE `ref_route`
  ADD UNIQUE KEY `pol_country` (`pol_country`,`pod_country`);

--
-- Индексы таблицы `reg_costs`
--
ALTER TABLE `reg_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_headcount_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `supplier` (`supplier`),
  ADD KEY `unit` (`unit`),
  ADD KEY `product` (`product`),
  ADD KEY `item` (`item`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `company` (`company`);

--
-- Индексы таблицы `reg_depreciation`
--
ALTER TABLE `reg_depreciation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reg_depreciation_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `customer` (`customer`),
  ADD KEY `particulars` (`particulars`),
  ADD KEY `item` (`item`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `company` (`company`),
  ADD KEY `location` (`location`);

--
-- Индексы таблицы `reg_headcount`
--
ALTER TABLE `reg_headcount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_headcount_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `customer` (`customer`),
  ADD KEY `account` (`account`),
  ADD KEY `item` (`item`),
  ADD KEY `particulars` (`particulars`),
  ADD KEY `location` (`location`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `company` (`company`);

--
-- Индексы таблицы `reg_interco_sales`
--
ALTER TABLE `reg_interco_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_headcount_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `customer` (`customer`),
  ADD KEY `unit` (`unit`),
  ADD KEY `product` (`activity_cost`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `kpi` (`kpi`),
  ADD KEY `sales` (`sales`),
  ADD KEY `bdv` (`bdv`),
  ADD KEY `customer_group_code` (`customer_group_code`),
  ADD KEY `company` (`company`);

--
-- Индексы таблицы `reg_master`
--
ALTER TABLE `reg_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_master_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `customer` (`customer`),
  ADD KEY `account` (`account`),
  ADD KEY `item` (`item`),
  ADD KEY `particulars` (`particulars`),
  ADD KEY `part_type` (`part_type`),
  ADD KEY `active` (`active`),
  ADD KEY `sales` (`sales`),
  ADD KEY `route` (`route`),
  ADD KEY `bdv` (`bdv`),
  ADD KEY `customer_group_code` (`customer_group_code`),
  ADD KEY `company` (`company`),
  ADD KEY `ix_new` (`new`);

--
-- Индексы таблицы `reg_msf`
--
ALTER TABLE `reg_msf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reg_msf_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `unit` (`unit`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `company` (`company`),
  ADD KEY `item` (`item`);

--
-- Индексы таблицы `reg_rent`
--
ALTER TABLE `reg_rent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reg_rent_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `customer` (`customer`),
  ADD KEY `unit` (`unit`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `item` (`item`),
  ADD KEY `company` (`company`);

--
-- Индексы таблицы `reg_sales`
--
ALTER TABLE `reg_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_headcount_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `activity` (`activity`),
  ADD KEY `customer` (`customer`),
  ADD KEY `unit` (`unit`),
  ADD KEY `particulars` (`particulars`),
  ADD KEY `product` (`product`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `kpi` (`kpi`),
  ADD KEY `sales` (`sales`),
  ADD KEY `route` (`route`),
  ADD KEY `bdv` (`bdv`),
  ADD KEY `customer_group_code` (`customer_group_code`),
  ADD KEY `bo` (`bo`),
  ADD KEY `company` (`company`),
  ADD KEY `jo` (`jo`),
  ADD KEY `freehand` (`freehand`),
  ADD KEY `pol` (`pol`),
  ADD KEY `pod` (`pod`),
  ADD KEY `ix_new` (`new`);

--
-- Индексы таблицы `reg_sales_rhq`
--
ALTER TABLE `reg_sales_rhq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_headcount_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `customer` (`customer`),
  ADD KEY `active` (`active`),
  ADD KEY `sales` (`sales`),
  ADD KEY `bdv` (`bdv`),
  ADD KEY `customer_group_code` (`customer_group_code`),
  ADD KEY `bo` (`bo`),
  ADD KEY `company` (`company`),
  ADD KEY `jo` (`jo`),
  ADD KEY `da` (`da`),
  ADD KEY `freehand` (`freehand`),
  ADD KEY `ix_new` (`new`),
  ADD KEY `ghq` (`ghq`),
  ADD KEY `account` (`account`);

--
-- Индексы таблицы `reg_summary`
--
ALTER TABLE `reg_summary`
  ADD KEY `company` (`company`),
  ADD KEY `pc` (`pc`),
  ADD KEY `pccFlagProd` (`pccFlagProd`),
  ADD KEY `activity` (`activity`),
  ADD KEY `account` (`account`),
  ADD KEY `item` (`item`),
  ADD KEY `scenario` (`scenario`);

--
-- Индексы таблицы `reg_vehicles`
--
ALTER TABLE `reg_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_headcount_tbl_scenario` (`scenario`),
  ADD KEY `source` (`source`),
  ADD KEY `pc` (`pc`),
  ADD KEY `active` (`active`),
  ADD KEY `posted` (`posted`),
  ADD KEY `company` (`company`);

--
-- Индексы таблицы `stbl_action`
--
ALTER TABLE `stbl_action`
  ADD PRIMARY KEY (`actID`),
  ADD KEY `actFlagInsert` (`actFlagInsert`),
  ADD KEY `actFlagEdit` (`actFlagEdit`);

--
-- Индексы таблицы `stbl_action_log`
--
ALTER TABLE `stbl_action_log`
  ADD PRIMARY KEY (`aclID`),
  ADD KEY `aclGUID` (`aclGUID`),
  ADD KEY `aclInsertDate` (`aclInsertDate`),
  ADD KEY `aclActionID` (`aclActionID`),
  ADD KEY `aclInsertBy` (`aclInsertBy`),
  ADD KEY `aclEntityID` (`aclEntityID`),
  ADD KEY `aclScenarioID` (`aclScenarioID`);

--
-- Индексы таблицы `stbl_attribute`
--
ALTER TABLE `stbl_attribute`
  ADD PRIMARY KEY (`atrID`,`atrEntityID`),
  ADD KEY `atrTab` (`atrTab`),
  ADD KEY `atrGUID` (`atrGUID`),
  ADD KEY `atrOrder` (`atrOrder`);

--
-- Индексы таблицы `stbl_entity`
--
ALTER TABLE `stbl_entity`
  ADD PRIMARY KEY (`entID`);

--
-- Индексы таблицы `stbl_file`
--
ALTER TABLE `stbl_file`
  ADD PRIMARY KEY (`filID`),
  ADD UNIQUE KEY `filGUID_2` (`filGUID`,`filEntityID`),
  ADD KEY `filGUID` (`filGUID`),
  ADD KEY `filInsertDate` (`filInsertDate`),
  ADD KEY `filField` (`filField`),
  ADD KEY `filEntityID` (`filEntityID`);

--
-- Индексы таблицы `stbl_page`
--
ALTER TABLE `stbl_page`
  ADD PRIMARY KEY (`pagID`),
  ADD KEY `pagIdxLeft` (`pagIdxLeft`),
  ADD KEY `pagIdxRight` (`pagIdxRight`),
  ADD KEY `pagEntityID` (`pagEntityID`),
  ADD KEY `pagParentID` (`pagParentID`),
  ADD KEY `pagFlagShowMyItems` (`pagFlagShowMyItems`);

--
-- Индексы таблицы `stbl_page_role`
--
ALTER TABLE `stbl_page_role`
  ADD PRIMARY KEY (`pgrID`),
  ADD UNIQUE KEY `pgrPageRole` (`pgrPageID`,`pgrRoleID`),
  ADD KEY `pgrRoleID` (`pgrRoleID`),
  ADD KEY `pgrPageID` (`pgrPageID`);

--
-- Индексы таблицы `stbl_profit_role`
--
ALTER TABLE `stbl_profit_role`
  ADD PRIMARY KEY (`pcrID`),
  ADD UNIQUE KEY `pcrProfitID_pcrRoleID` (`pcrProfitID`,`pcrRoleID`);

--
-- Индексы таблицы `stbl_role`
--
ALTER TABLE `stbl_role`
  ADD PRIMARY KEY (`rolID`),
  ADD UNIQUE KEY `rolGUID` (`rolGUID`);

--
-- Индексы таблицы `stbl_setting`
--
ALTER TABLE `stbl_setting`
  ADD PRIMARY KEY (`setID`),
  ADD KEY `setOrder` (`setOrder`);

--
-- Индексы таблицы `stbl_user_setup`
--
ALTER TABLE `stbl_user_setup`
  ADD PRIMARY KEY (`usuID`),
  ADD UNIQUE KEY `usuSettingID_usuUserID` (`usuSettingID`,`usuUserID`),
  ADD KEY `usuUserID` (`usuUserID`);

--
-- Индексы таблицы `tbl_calendar`
--
ALTER TABLE `tbl_calendar`
  ADD PRIMARY KEY (`calID`),
  ADD UNIQUE KEY `calGUID` (`calGUID`),
  ADD KEY `calFlagDeleted` (`calFlagDeleted`),
  ADD KEY `calDateStart` (`calDateStart`),
  ADD KEY `calDateEnd` (`calDateEnd`);

--
-- Индексы таблицы `tbl_current_employee`
--
ALTER TABLE `tbl_current_employee`
  ADD PRIMARY KEY (`cemID`),
  ADD UNIQUE KEY `cemGUID` (`cemGUID`),
  ADD KEY `cemScenario` (`cemScenario`),
  ADD KEY `cemProfitID` (`cemProfitID`),
  ADD KEY `cemFlagPosted` (`cemFlagPosted`),
  ADD KEY `cemFlagDeleted` (`cemFlagDeleted`),
  ADD KEY `cemClassifiedBy` (`cemClassifiedBy`),
  ADD KEY `cemUserID` (`cemUserID`);

--
-- Индексы таблицы `tbl_depreciation`
--
ALTER TABLE `tbl_depreciation`
  ADD PRIMARY KEY (`depID`),
  ADD UNIQUE KEY `depGUID` (`depGUID`),
  ADD KEY `depScenario` (`depScenario`),
  ADD KEY `depProfitID` (`depProfitID`),
  ADD KEY `depFlagDeleted` (`depFlagDeleted`),
  ADD KEY `depFlagPosted` (`depFlagPosted`),
  ADD KEY `depUserID` (`depUserID`);

--
-- Индексы таблицы `tbl_employee_insurance`
--
ALTER TABLE `tbl_employee_insurance`
  ADD PRIMARY KEY (`emdID`),
  ADD KEY `emdEmployeeID` (`emdEmployeeID`),
  ADD KEY `emdInsuranceID` (`emdInsuranceID`);

--
-- Индексы таблицы `tbl_general_costs`
--
ALTER TABLE `tbl_general_costs`
  ADD PRIMARY KEY (`genID`),
  ADD UNIQUE KEY `genGUID` (`genGUID`),
  ADD KEY `genScenario` (`genScenario`),
  ADD KEY `genProfitID` (`genSupplierID`),
  ADD KEY `genItemGUID` (`genItemGUID`),
  ADD KEY `genFlagDeleted` (`genFlagDeleted`),
  ADD KEY `genFlagPosted` (`genFlagPosted`),
  ADD KEY `genUserID` (`genUserID`);

--
-- Индексы таблицы `tbl_indirect_costs`
--
ALTER TABLE `tbl_indirect_costs`
  ADD PRIMARY KEY (`icoID`),
  ADD UNIQUE KEY `icoGUID` (`icoGUID`),
  ADD KEY `icoScenario` (`icoScenario`),
  ADD KEY `icoProfitID` (`icoProfitID`),
  ADD KEY `icoFlagDeleted` (`icoFlagDeleted`),
  ADD KEY `icoFlagPosted` (`icoFlagPosted`),
  ADD KEY `icoUserID` (`icoUserID`);

--
-- Индексы таблицы `tbl_insurance`
--
ALTER TABLE `tbl_insurance`
  ADD PRIMARY KEY (`dmsID`),
  ADD UNIQUE KEY `dmsGUID` (`dmsGUID`),
  ADD KEY `dmsLocationID` (`dmsLocationID`);

--
-- Индексы таблицы `tbl_interco_sales`
--
ALTER TABLE `tbl_interco_sales`
  ADD PRIMARY KEY (`icsID`),
  ADD UNIQUE KEY `icsGUID` (`icsGUID`),
  ADD KEY `icsScenario` (`icsScenario`),
  ADD KEY `icsProfitID` (`icsProfitID`),
  ADD KEY `icsCustomerID` (`icsCustomerID`),
  ADD KEY `icsFlagDeleted` (`icsFlagDeleted`),
  ADD KEY `icsFlagPosted` (`icsFlagPosted`),
  ADD KEY `icsUserID` (`icsUserID`);

--
-- Индексы таблицы `tbl_investment`
--
ALTER TABLE `tbl_investment`
  ADD PRIMARY KEY (`invID`),
  ADD UNIQUE KEY `invGUID` (`invGUID`),
  ADD KEY `invScenario` (`invScenario`),
  ADD KEY `invProfitID` (`invProfitID`),
  ADD KEY `invFlagDeleted` (`invFlagDeleted`),
  ADD KEY `invFlagPosted` (`invFlagPosted`),
  ADD KEY `invUserID` (`invUserID`);

--
-- Индексы таблицы `tbl_kaizen`
--
ALTER TABLE `tbl_kaizen`
  ADD PRIMARY KEY (`kznID`),
  ADD UNIQUE KEY `kznGUID` (`kznGUID`),
  ADD KEY `kznScenario` (`kznScenario`),
  ADD KEY `kznItemGUID` (`kznItemGUID`),
  ADD KEY `kznFlagDeleted` (`kznFlagDeleted`),
  ADD KEY `kznFlagPosted` (`kznFlagPosted`),
  ADD KEY `kznUserID` (`kznUserID`);

--
-- Индексы таблицы `tbl_location_costs`
--
ALTER TABLE `tbl_location_costs`
  ADD PRIMARY KEY (`lcoID`),
  ADD UNIQUE KEY `lcoGUID` (`lcoGUID`),
  ADD KEY `lcoScenario` (`lcoScenario`),
  ADD KEY `lcoLocationID` (`lcoLocationID`),
  ADD KEY `lcoFlagDeleted` (`lcoFlagDeleted`),
  ADD KEY `lcoFlagPosted` (`lcoFlagPosted`),
  ADD KEY `lcoUserID` (`lcoUserID`);

--
-- Индексы таблицы `tbl_message_log`
--
ALTER TABLE `tbl_message_log`
  ADD PRIMARY KEY (`msgID`),
  ADD KEY `msgGUID` (`msgGUID`),
  ADD KEY `msgRecipientID` (`msgRecipientID`),
  ADD KEY `msgInsertBy` (`msgInsertBy`),
  ADD KEY `msgType` (`msgType`),
  ADD KEY `msgEntityID` (`msgEntityID`),
  ADD KEY `msgFlagRead` (`msgFlagRead`);

--
-- Индексы таблицы `tbl_msf`
--
ALTER TABLE `tbl_msf`
  ADD PRIMARY KEY (`msfID`),
  ADD UNIQUE KEY `msfGUID` (`msfGUID`),
  ADD KEY `msfScenario` (`msfScenario`),
  ADD KEY `msfFlagDeleted` (`msfFlagDeleted`),
  ADD KEY `msfFlagPosted` (`msfFlagPosted`),
  ADD KEY `msfItemGUID` (`msfItemGUID`),
  ADD KEY `msfUserID` (`msfUserID`);

--
-- Индексы таблицы `tbl_new_employee`
--
ALTER TABLE `tbl_new_employee`
  ADD PRIMARY KEY (`nemID`),
  ADD UNIQUE KEY `nemGUID` (`nemGUID`),
  ADD KEY `nemScenario` (`nemScenario`),
  ADD KEY `nemProfitID` (`nemProfitID`),
  ADD KEY `nemFlagDeleted` (`nemFlagDeleted`),
  ADD KEY `nemFlagPosted` (`nemFlagPosted`),
  ADD KEY `nemClassifiedBy` (`nemClassifiedBy`),
  ADD KEY `nemUserID` (`nemUserID`);

--
-- Индексы таблицы `tbl_rent`
--
ALTER TABLE `tbl_rent`
  ADD PRIMARY KEY (`rntID`),
  ADD UNIQUE KEY `rntGUID` (`rntGUID`),
  ADD KEY `rntScenario` (`rntScenario`),
  ADD KEY `rntItemGUID` (`rntItemGUID`),
  ADD KEY `rntFlagDeleted` (`rntFlagDeleted`),
  ADD KEY `rntFlagPosted` (`rntFlagPosted`),
  ADD KEY `rntUserID` (`rntUserID`),
  ADD KEY `rntYACT` (`rntYACT`),
  ADD KEY `rntKPIActivityID` (`rntKPIActivityID`);

--
-- Индексы таблицы `tbl_route`
--
ALTER TABLE `tbl_route`
  ADD PRIMARY KEY (`rteID`);

--
-- Индексы таблицы `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`salID`),
  ADD UNIQUE KEY `salGUID` (`salGUID`),
  ADD KEY `salScenario` (`salScenario`),
  ADD KEY `salProfitID` (`salProfitID`),
  ADD KEY `salCustomerID` (`salCustomerID`),
  ADD KEY `salFlagDeleted` (`salFlagDeleted`),
  ADD KEY `salFlagPosted` (`salFlagPosted`),
  ADD KEY `salUserID` (`salUserID`),
  ADD KEY `salRoute` (`salRoute`),
  ADD KEY `salPOL` (`salPOL`),
  ADD KEY `salPOD` (`salPOD`),
  ADD KEY `ix_new` (`salFlagNew`);

--
-- Индексы таблицы `tbl_scenario`
--
ALTER TABLE `tbl_scenario`
  ADD PRIMARY KEY (`scnID`),
  ADD KEY `scnType` (`scnType`),
  ADD KEY `scnFlagArchive` (`scnFlagArchive`),
  ADD KEY `scnFlagPublic` (`scnFlagPublic`);

--
-- Индексы таблицы `tbl_scenario_variable`
--
ALTER TABLE `tbl_scenario_variable`
  ADD PRIMARY KEY (`scvID`),
  ADD UNIQUE KEY `scvGUID` (`scvGUID`),
  ADD KEY `scvVariableID` (`scvVariableID`),
  ADD KEY `scvScenarioID` (`scvScenarioID`);

--
-- Индексы таблицы `tbl_setup`
--
ALTER TABLE `tbl_setup`
  ADD PRIMARY KEY (`stpID`);

--
-- Индексы таблицы `tbl_unknown`
--
ALTER TABLE `tbl_unknown`
  ADD PRIMARY KEY (`cntID`);

--
-- Индексы таблицы `tbl_variable`
--
ALTER TABLE `tbl_variable`
  ADD PRIMARY KEY (`varID`),
  ADD UNIQUE KEY `varGUID` (`varGUID`);

--
-- Индексы таблицы `tbl_vehicle`
--
ALTER TABLE `tbl_vehicle`
  ADD PRIMARY KEY (`vehID`),
  ADD UNIQUE KEY `vehGUID` (`vehGUID`),
  ADD KEY `vehScenario` (`vehScenario`),
  ADD KEY `vehProfitID` (`vehProfitID`),
  ADD KEY `vehFlagDeleted` (`vehFlagDeleted`),
  ADD KEY `vehFlagPosted` (`vehFlagPosted`),
  ADD KEY `vehUserID` (`vehUserID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `reg_costs`
--
ALTER TABLE `reg_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_depreciation`
--
ALTER TABLE `reg_depreciation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_headcount`
--
ALTER TABLE `reg_headcount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_interco_sales`
--
ALTER TABLE `reg_interco_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_master`
--
ALTER TABLE `reg_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_msf`
--
ALTER TABLE `reg_msf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_rent`
--
ALTER TABLE `reg_rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_sales`
--
ALTER TABLE `reg_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_sales_rhq`
--
ALTER TABLE `reg_sales_rhq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reg_vehicles`
--
ALTER TABLE `reg_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stbl_action_log`
--
ALTER TABLE `stbl_action_log`
  MODIFY `aclID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stbl_entity`
--
ALTER TABLE `stbl_entity`
  MODIFY `entID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `stbl_file`
--
ALTER TABLE `stbl_file`
  MODIFY `filID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stbl_page`
--
ALTER TABLE `stbl_page`
  MODIFY `pagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT для таблицы `stbl_page_role`
--
ALTER TABLE `stbl_page_role`
  MODIFY `pgrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8562;

--
-- AUTO_INCREMENT для таблицы `stbl_profit_role`
--
ALTER TABLE `stbl_profit_role`
  MODIFY `pcrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT для таблицы `stbl_user_setup`
--
ALTER TABLE `stbl_user_setup`
  MODIFY `usuID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `tbl_calendar`
--
ALTER TABLE `tbl_calendar`
  MODIFY `calID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `tbl_current_employee`
--
ALTER TABLE `tbl_current_employee`
  MODIFY `cemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_depreciation`
--
ALTER TABLE `tbl_depreciation`
  MODIFY `depID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_employee_insurance`
--
ALTER TABLE `tbl_employee_insurance`
  MODIFY `emdID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_general_costs`
--
ALTER TABLE `tbl_general_costs`
  MODIFY `genID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_indirect_costs`
--
ALTER TABLE `tbl_indirect_costs`
  MODIFY `icoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_interco_sales`
--
ALTER TABLE `tbl_interco_sales`
  MODIFY `icsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_investment`
--
ALTER TABLE `tbl_investment`
  MODIFY `invID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_kaizen`
--
ALTER TABLE `tbl_kaizen`
  MODIFY `kznID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_location_costs`
--
ALTER TABLE `tbl_location_costs`
  MODIFY `lcoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_message_log`
--
ALTER TABLE `tbl_message_log`
  MODIFY `msgID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_msf`
--
ALTER TABLE `tbl_msf`
  MODIFY `msfID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_new_employee`
--
ALTER TABLE `tbl_new_employee`
  MODIFY `nemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_rent`
--
ALTER TABLE `tbl_rent`
  MODIFY `rntID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_route`
--
ALTER TABLE `tbl_route`
  MODIFY `rteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `salID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_scenario_variable`
--
ALTER TABLE `tbl_scenario_variable`
  MODIFY `scvID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_setup`
--
ALTER TABLE `tbl_setup`
  MODIFY `stpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `tbl_vehicle`
--
ALTER TABLE `tbl_vehicle`
  MODIFY `vehID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `reg_costs`
--
ALTER TABLE `reg_costs`
  ADD CONSTRAINT `FK_reg_costs_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_depreciation`
--
ALTER TABLE `reg_depreciation`
  ADD CONSTRAINT `FK_reg_depreciation_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_headcount`
--
ALTER TABLE `reg_headcount`
  ADD CONSTRAINT `FK_tbl_headcount_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_master`
--
ALTER TABLE `reg_master`
  ADD CONSTRAINT `FK_tbl_master_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_msf`
--
ALTER TABLE `reg_msf`
  ADD CONSTRAINT `FK_reg_msf_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_rent`
--
ALTER TABLE `reg_rent`
  ADD CONSTRAINT `FK_reg_rent_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_sales`
--
ALTER TABLE `reg_sales`
  ADD CONSTRAINT `FK_tbl_sales_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reg_vehicles`
--
ALTER TABLE `reg_vehicles`
  ADD CONSTRAINT `FK_reg_vehicles_tbl_scenario` FOREIGN KEY (`scenario`) REFERENCES `tbl_scenario` (`scnID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `stbl_page_role`
--
ALTER TABLE `stbl_page_role`
  ADD CONSTRAINT `FK_stbl_page_role_stbl_page` FOREIGN KEY (`pgrPageID`) REFERENCES `stbl_page` (`pagID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_stbl_page_role_stbl_role` FOREIGN KEY (`pgrRoleID`) REFERENCES `stbl_role` (`rolID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_scenario_variable`
--
ALTER TABLE `tbl_scenario_variable`
  ADD CONSTRAINT `FK_tbl_scenario_variable_tbl_scenario` FOREIGN KEY (`scvScenarioID`) REFERENCES `tbl_scenario` (`scnID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_scenario_variable_tbl_variable` FOREIGN KEY (`scvVariableID`) REFERENCES `tbl_variable` (`varID`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
