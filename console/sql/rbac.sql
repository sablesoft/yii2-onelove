-- MySQL dump 10.13  Distrib 8.0.12, for Linux (x86_64)
--
-- Host: localhost    Database: onelove
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,'Администрация сайта',NULL,NULL,1548028395,1548358382),('admin.ask',2,'Доступ к полному управлению заявками',NULL,NULL,1548028638,1548076671),('admin.control',2,'Доступ к контрольной панели',NULL,NULL,1548076307,1548076307),('admin.index',2,'Доступ к панели администратора',NULL,NULL,1548040648,1548040648),('admin.member',2,'Доступ к полному управлению участниками',NULL,NULL,1548028601,1548076691),('admin.party',2,'Доступ к полному управлению встречами',NULL,NULL,1548028745,1548076723),('admin.place',2,'Доступ к полному управлению местами',NULL,NULL,1548028548,1548076757),('admin.price',2,'Доступ к полному управлению расценками',NULL,NULL,1548028694,1548076814),('admin.setting',2,'Полный доступ к управлению настройками сайта',NULL,NULL,1548116591,1548118146),('admin.ticket',2,'Доступ администратора к управлению билетами',NULL,NULL,1548358360,1548358360),('ask.block',2,'Доступ к заморозке заявки',NULL,NULL,1548037132,1548037132),('ask.create',2,'Доступ к созданию заявки',NULL,NULL,1548030193,1548030193),('ask.delete',2,'Доступ к удалению заявки',NULL,NULL,1548030277,1548030277),('ask.index',2,'Доступ к списку заявок',NULL,NULL,1548030065,1548030065),('ask.unblock',2,'Доступ к разморозке заявки',NULL,NULL,1548037190,1548037190),('ask.update',2,'Доступ к обновлению данных заявки',NULL,NULL,1548030224,1548031414),('ask.view',2,'Доступ к просмотру данных заявки',NULL,NULL,1548030148,1548031113),('gold',1,'Премиум участник клуба c дополнительными возможностями',NULL,NULL,1548033206,1548040520),('gold.ask',2,'Доступ премиум участника к данным текущих заявок',NULL,NULL,1548040029,1548040064),('gold.index',2,'Доступ к панели премиум участника',NULL,NULL,1548039950,1548039950),('gold.member',2,'Доступ премиум участника к данным участников',NULL,NULL,1548040159,1548040159),('gold.party',2,'Доступ премиум участника к данным всех встреч',NULL,NULL,1548040272,1548040272),('manager',1,'Менеджер встреч - расширенные права управления встречами, участниками и заявками',NULL,NULL,1548029913,1548118285),('manager.ask',2,'Доступ менеджера к управлением заявками',NULL,NULL,1548036713,1548037662),('manager.index',2,'Доступ к панели менеджера',NULL,NULL,1548038369,1548038369),('manager.member',2,'Доступ менеджера к управлению участниками',NULL,NULL,1548036909,1548039259),('manager.party',2,'Доступ менеджера к управлению встречами',NULL,NULL,1548036796,1548039300),('manager.price',2,'Доступ менеджера к управлению ценами',NULL,NULL,1548036511,1548039455),('manager.settings',2,'Доступ менеджера к настройкам сайта',NULL,NULL,1548118249,1548118249),('member.block',2,'Доступ к блокировке участника',NULL,NULL,1548037297,1548037297),('member.create',2,'Доступ к созданию участника',NULL,NULL,1548030785,1548030785),('member.delete',2,'Доступ к удалению участника',NULL,NULL,1548030889,1548032508),('member.index',2,'Доступ к списку всех участников',NULL,NULL,1548030743,1548030743),('member.unblock',2,'Доступ к разблокировке участника',NULL,NULL,1548037322,1548037322),('member.update',2,'Доступ к обновлению данных участника',NULL,NULL,1548030833,1548032438),('member.view',2,'Доступ к просмотру данных участника',NULL,NULL,1548030864,1548032419),('operator',1,'Оператор встреч, в задачи которого входит обработка заявок',NULL,NULL,1548034603,1548038330),('operator.ask',2,'Доступ оператора к данным заявок',NULL,NULL,1548035151,1548039559),('operator.index',2,'Доступ к панели оператора',NULL,NULL,1548038301,1548038301),('operator.member',2,'Доступ оператора к данным участников',NULL,NULL,1548035269,1548037741),('operator.party',2,'Доступ оператора к данным встреч',NULL,NULL,1548035376,1548038051),('operator.place',2,'Доступ оператора к данным мест',NULL,NULL,1548035447,1548038088),('party.block',2,'Доступ к заморозке встречи',NULL,NULL,1548037419,1548037461),('party.create',2,'Доступ к созданию встречи',NULL,NULL,1548031222,1548031222),('party.delete',2,'Доступ к удалению встречи',NULL,NULL,1548031181,1548031181),('party.index',2,'Доступ к просмотру списка всех встреч',NULL,NULL,1548031008,1548031008),('party.unblock',2,'Доступ к разморозке встречи',NULL,NULL,1548037442,1548037442),('party.update',2,'Доступ к обновлению данных встречи',NULL,NULL,1548031255,1548031255),('party.view',2,'Доступ к просмотру данных встречи',NULL,NULL,1548031102,1548031102),('place.block',2,'Доступ к блокировке места',NULL,NULL,1548038988,1548038988),('place.create',2,'Доступ к созданию места встреч',NULL,NULL,1548031580,1548031580),('place.delete',2,'Доступ к удалению места встреч',NULL,NULL,1548031622,1548031622),('place.index',2,'Доступ к просмотру списка всех мест',NULL,NULL,1548031542,1548031542),('place.unblock',2,'Доступ к разблокировке места',NULL,NULL,1548039014,1548039014),('place.update',2,'Доступ к обновлению данных места',NULL,NULL,1548031692,1548031692),('place.view',2,'Доступ к просмотру данных места',NULL,NULL,1548031663,1548031663),('price.block',2,'Доступ к заморозке расценок',NULL,NULL,1548039363,1548039363),('price.create',2,'Доступ к созданию новых расценок',NULL,NULL,1548031859,1548031859),('price.delete',2,'Доступ к удалению расценок',NULL,NULL,1548031888,1548031888),('price.index',2,'Доступ к списку всех расценок',NULL,NULL,1548031798,1548031798),('price.unblock',2,'Доступ к разморозке расценок',NULL,NULL,1548039381,1548039381),('price.update',2,'Доступ к обновлению данных расценок',NULL,NULL,1548031905,1548031905),('price.view',2,'Доступ к просмотру данных расценки',NULL,NULL,1548031830,1548031830),('setting.create',2,'Доступ к созданию настройки сайта',NULL,NULL,1548117189,1548117189),('setting.delete',2,'Доступ к удалению настройки сайта',NULL,NULL,1548118126,1548118126),('setting.index',2,'Доступ к списку настроек сайта',NULL,NULL,1548116540,1548116540),('setting.update',2,'Доступ к обновлению данных настройки сайта',NULL,NULL,1548117726,1548117726),('setting.view',2,'Доступ к просмотру данных настройки сайта',NULL,NULL,1548117429,1548117429),('ticket.block',2,'Доступ к блокированию билета',NULL,NULL,1548358254,1548358254),('ticket.create',2,'Доступ к созданию нового билета',NULL,NULL,1548358193,1548358193),('ticket.delete',2,'Доступ к удалению билета',NULL,NULL,1548358236,1548358236),('ticket.index',2,'Доступ к списку созданных билетов',NULL,NULL,1548358151,1548358151),('ticket.unblock',2,'Доступ к разблокировке билета',NULL,NULL,1548358281,1548358281),('ticket.update',2,'Доступ к обновлению данных билета',NULL,NULL,1548358213,1548358213),('ticket.view',2,'Доступ к информации по билету',NULL,NULL,1548358172,1548358172),('user',1,'Обычный пользователь сайта и участник встреч',NULL,NULL,1548032202,1548038593),('user.ask',2,'Доступ участника к данным и управлению своими текущими заявками',NULL,NULL,1548033826,1548039691),('user.index',2,'Доступ к панели участника',NULL,NULL,1548038537,1548038537),('user.member',2,'Доступ к управлению своими данными участника',NULL,NULL,1548032309,1548037898),('user.party',2,'Доступ участника к активным встречам и встречам, на которых он был',NULL,NULL,1548034145,1548039791),('user.place',2,'Доступ участника к данным мест',NULL,NULL,1548040380,1548040380);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('admin','admin.ask'),('admin','admin.control'),('admin','admin.index'),('admin','admin.member'),('admin','admin.party'),('admin','admin.place'),('admin','admin.price'),('admin','admin.setting'),('admin','admin.ticket'),('admin.ask','ask.block'),('operator.ask','ask.block'),('admin.ask','ask.create'),('manager.ask','ask.create'),('admin.ask','ask.delete'),('user.ask','ask.delete'),('admin.ask','ask.index'),('gold.ask','ask.index'),('operator.ask','ask.index'),('admin.ask','ask.unblock'),('operator.ask','ask.unblock'),('admin.ask','ask.update'),('operator.ask','ask.update'),('admin.ask','ask.view'),('gold.ask','ask.view'),('operator.ask','ask.view'),('user.ask','ask.view'),('gold','gold.ask'),('gold','gold.index'),('gold','gold.member'),('gold','gold.party'),('admin','manager'),('manager','manager.ask'),('manager','manager.index'),('manager','manager.member'),('manager','manager.party'),('manager','manager.price'),('manager','manager.settings'),('admin.member','member.block'),('manager.member','member.block'),('admin.member','member.create'),('manager.member','member.create'),('admin.member','member.delete'),('manager.member','member.delete'),('user.member','member.delete'),('admin.member','member.index'),('gold.member','member.index'),('operator.member','member.index'),('admin.member','member.unblock'),('manager.member','member.unblock'),('admin.member','member.update'),('manager.member','member.update'),('user.member','member.update'),('admin.member','member.view'),('gold.member','member.view'),('operator.member','member.view'),('user.member','member.view'),('manager','operator'),('operator','operator.ask'),('operator','operator.index'),('operator','operator.member'),('operator','operator.party'),('operator','operator.place'),('admin.party','party.block'),('manager.party','party.block'),('admin.party','party.create'),('manager.party','party.create'),('admin.party','party.delete'),('manager.party','party.delete'),('admin.party','party.index'),('gold.party','party.index'),('operator.party','party.index'),('user.party','party.index'),('admin.party','party.unblock'),('manager.party','party.unblock'),('admin.party','party.update'),('manager.party','party.update'),('admin.party','party.view'),('gold.party','party.view'),('operator.party','party.view'),('user.party','party.view'),('admin.place','place.block'),('admin.place','place.create'),('admin.place','place.delete'),('admin.place','place.index'),('operator.place','place.index'),('user.place','place.index'),('admin.place','place.unblock'),('admin.place','place.update'),('admin.place','place.view'),('operator.place','place.view'),('user.place','place.view'),('admin.price','price.block'),('manager.price','price.block'),('admin.price','price.create'),('admin.price','price.delete'),('admin.price','price.index'),('manager.price','price.index'),('admin.price','price.unblock'),('manager.price','price.unblock'),('admin.price','price.update'),('manager.price','price.update'),('admin.price','price.view'),('manager.price','price.view'),('admin.setting','setting.create'),('admin.setting','setting.delete'),('admin.setting','setting.index'),('manager.settings','setting.index'),('admin.setting','setting.update'),('manager.settings','setting.update'),('admin.setting','setting.view'),('manager.settings','setting.view'),('admin.ticket','ticket.block'),('admin.ticket','ticket.create'),('admin.ticket','ticket.delete'),('admin.ticket','ticket.index'),('admin.ticket','ticket.unblock'),('admin.ticket','ticket.update'),('admin.ticket','ticket.view'),('gold','user'),('operator','user'),('user','user.ask'),('user','user.index'),('user','user.member'),('user','user.party');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-25 22:04:49
