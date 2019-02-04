-- MySQL dump 10.13  Distrib 8.0.12, for Linux (x86_64)
--
-- Host: localhost    Database: onelove
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
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

DROP TABLE IF EXISTS `auth_item_child`;
DROP TABLE IF EXISTS `auth_item`;
DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
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

--
-- Table structure for table `auth_item_child`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
SET character_set_client = utf8mb4 ;
CREATE TABLE `auth_item_child` (
   `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
   `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
   PRIMARY KEY (`parent`,`child`),
   KEY `child` (`child`),
   CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isOwner', 0x4f3a32313a22636f6d6d6f6e5c726261635c4f776e657252756c65223a333a7b733a343a226e616d65223b733a373a2269734f776e6572223b733a393a22637265617465644174223b693a313534393238323037303b733a393a22757064617465644174223b693a313534393238323037303b7d, 1549282070, 1549282070);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администрация сайта', NULL, NULL, 1548028395, 1549213914),
('admin.ask', 2, 'Доступ к полному управлению заявками', NULL, NULL, 1548028638, 1548606582),
('admin.control', 2, 'Доступ к контрольной панели', NULL, NULL, 1548076307, 1548076307),
('admin.group', 2, 'Доступ администрации к группам предпочтения', NULL, NULL, 1549208666, 1549208913),
('admin.index', 2, 'Доступ к панели администратора', NULL, NULL, 1548040648, 1548040648),
('admin.media', 2, 'Доступ администрации к управлению медиафайлами', NULL, NULL, 1549209259, 1549209845),
('admin.member', 2, 'Доступ к полному управлению участниками', NULL, NULL, 1548028601, 1548076691),
('admin.party', 2, 'Доступ к полному управлению встречами', NULL, NULL, 1548028745, 1548076723),
('admin.place', 2, 'Доступ к полному управлению местами', NULL, NULL, 1548028548, 1548076757),
('admin.price', 2, 'Доступ к полному управлению расценками', NULL, NULL, 1548028694, 1548076814),
('admin.setting', 2, 'Полный доступ к управлению настройками сайта', NULL, NULL, 1548116591, 1548118146),
('admin.ticket', 2, 'Доступ администратора к управлению билетами', NULL, NULL, 1548358360, 1548358360),
('ask.accept', 2, 'Контроль на подтверждение заявки', NULL, NULL, 1548606570, 1548606570),
('ask.accept-all', 2, 'Контроль к подтверждению всех заявок', NULL, NULL, 1548604362, 1548604475),
('ask.block', 2, 'Доступ к заморозке заявки', NULL, NULL, 1548037132, 1548037132),
('ask.create', 2, 'Доступ к созданию заявки', NULL, NULL, 1548030193, 1548030193),
('ask.delete', 2, 'Доступ к удалению заявки', NULL, NULL, 1548030277, 1548030277),
('ask.delete-own', 2, 'Доступ к удалению своей заявки', 'isOwner', NULL, 1549223272, 1549282108),
('ask.index', 2, 'Доступ к списку заявок', NULL, NULL, 1548030065, 1548030065),
('ask.member-save', 2, 'Доступ к сохранению участника из заявки', NULL, NULL, 1549223772, 1549223772),
('ask.reject-all', 2, 'Контроль к отклонению всех заявок', NULL, NULL, 1548604332, 1548604489),
('ask.unblock', 2, 'Доступ к разморозке заявки', NULL, NULL, 1548037190, 1548037190),
('ask.update', 2, 'Доступ к обновлению данных заявки', NULL, NULL, 1548030224, 1548031414),
('ask.update-own', 2, 'Доступ к обновлению своей заявки', 'isOwner', NULL, 1549223356, 1549282135),
('ask.view', 2, 'Доступ к просмотру данных заявки', NULL, NULL, 1548030148, 1548031113),
('ask.view-own', 2, 'Доступ у просмотру своей заявки', 'isOwner', NULL, 1549223309, 1549282150),
('dev', 1, 'Разработчик сайта', NULL, NULL, 1549205004, 1549205347),
('dev.permission', 2, 'Доступ к управлению разрешениями', NULL, NULL, 1549205290, 1549205290),
('dev.role', 2, 'Доступ к управлению ролями', NULL, NULL, 1549205206, 1549205206),
('dev.rule', 2, 'Доступ к управлению правилами', NULL, NULL, 1549205254, 1549216945),
('gold', 1, 'Премиум участник клуба c дополнительными возможностями', NULL, NULL, 1548033206, 1548040520),
('gold.ask', 2, 'Доступ премиум участника к данным текущих заявок', NULL, NULL, 1548040029, 1548040064),
('gold.index', 2, 'Доступ к панели премиум участника', NULL, NULL, 1548039950, 1548039950),
('gold.member', 2, 'Доступ премиум участника к данным участников', NULL, NULL, 1548040159, 1548040159),
('gold.party', 2, 'Доступ премиум участника к данным всех встреч', NULL, NULL, 1548040272, 1548040272),
('group.block', 2, 'Доступ к блокировке группы предпочтения', NULL, NULL, 1549208804, 1549208804),
('group.create', 2, 'Доступ к созданию группы предпочтения', NULL, NULL, 1549208745, 1549208745),
('group.delete', 2, 'Доступ к удалению группы предпочтения', NULL, NULL, 1549208783, 1549208783),
('group.index', 2, 'Доступ к списку групп предпочтения', NULL, NULL, 1549208618, 1549208618),
('group.unblock', 2, 'Доступ к разблокировке группы предпочтения', NULL, NULL, 1549208825, 1549208825),
('group.update', 2, 'Доступ к обновлению группы предпочтения', NULL, NULL, 1549208766, 1549208766),
('group.view', 2, 'Доступ к просмотру группы предпочтения', NULL, NULL, 1549208864, 1549208864),
('manager', 1, 'Менеджер встреч - расширенные права управления встречами, участниками и заявками', NULL, NULL, 1548029913, 1549215588),
('manager.ask', 2, 'Доступ менеджера к управлением заявками', NULL, NULL, 1548036713, 1548037662),
('manager.group', 2, 'Доступ менеджера к управлению группами предпочтений', NULL, NULL, 1549215460, 1549215460),
('manager.index', 2, 'Доступ к панели менеджера', NULL, NULL, 1548038369, 1548038369),
('manager.media', 2, 'Доступ менеджера к управлению медиафайлами', NULL, NULL, 1549215566, 1549215566),
('manager.member', 2, 'Доступ менеджера к управлению участниками', NULL, NULL, 1548036909, 1548039259),
('manager.party', 2, 'Доступ менеджера к управлению встречами', NULL, NULL, 1548036796, 1548039300),
('manager.place', 2, 'Доступ менеджера к управлению местами', NULL, NULL, 1549215384, 1549215384),
('manager.price', 2, 'Доступ менеджера к управлению ценами', NULL, NULL, 1548036511, 1548039455),
('manager.settings', 2, 'Доступ менеджера к настройкам сайта', NULL, NULL, 1548118249, 1548118249),
('media.crop', 2, 'Доступ к обрезке медиафайла', NULL, NULL, 1549209718, 1549209718),
('media.delete', 2, 'Доступ к удалению медиафайла', NULL, NULL, 1549209833, 1549209833),
('media.get-original-image', 2, 'Доступ к получению оригинального медиафайла', NULL, NULL, 1549209611, 1549209663),
('media.index', 2, 'Доступ к медиа хранилищу файлов', NULL, NULL, 1549209306, 1549209306),
('media.upload', 2, 'Доступ к загрузке медиафайлов', NULL, NULL, 1549209489, 1549209489),
('media.view', 2, 'Доступ к просмотру медиафайла', NULL, NULL, 1549209424, 1549209424),
('member.block', 2, 'Доступ к блокировке участника', NULL, NULL, 1548037297, 1548037297),
('member.create', 2, 'Доступ к созданию участника', NULL, NULL, 1548030785, 1548030785),
('member.delete', 2, 'Доступ к удалению участника', NULL, NULL, 1548030889, 1549217855),
('member.delete-own', 2, 'Доступ к удалению собственных данных пользователя', 'isOwner', NULL, 1549217203, 1549282177),
('member.index', 2, 'Доступ к списку всех участников', NULL, NULL, 1548030743, 1548030743),
('member.unblock', 2, 'Доступ к разблокировке участника', NULL, NULL, 1548037322, 1548037322),
('member.update', 2, 'Доступ к обновлению данных участника', NULL, NULL, 1548030833, 1548032438),
('member.update-own', 2, 'Доступ к обновлению личных данных участника', 'isOwner', NULL, 1549222838, 1549282200),
('member.view', 2, 'Доступ к просмотру данных участника', NULL, NULL, 1548030864, 1548032419),
('member.view-own', 2, 'Доступ к просмотру своих данных участника', 'isOwner', NULL, 1549223160, 1549282217),
('menu.admin', 2, 'Доступ к меню администратора', NULL, NULL, 1549213894, 1549215712),
('menu.ask', 2, 'Доступ к меню заявок', NULL, NULL, 1549213958, 1549213958),
('menu.group', 2, 'Доступ к меню групп', NULL, NULL, 1549214134, 1549214134),
('menu.manager', 2, 'Доступ к меню менеджера', NULL, NULL, 1549214602, 1549214602),
('menu.media', 2, 'Доступ к меню медиахранилища', NULL, NULL, 1549214415, 1549214415),
('menu.member', 2, 'Доступ к меню участников', NULL, NULL, 1549214059, 1549214059),
('menu.operator', 2, 'Доступ к меню оператора', NULL, NULL, 1549214204, 1549214515),
('menu.party', 2, 'Доступ к меню встреч', NULL, NULL, 1549214107, 1549214107),
('menu.place', 2, 'Доступ к меню мест', NULL, NULL, 1549214367, 1549214367),
('menu.price', 2, 'Доступ к меню расценок', NULL, NULL, 1549214154, 1549214154),
('menu.ticket', 2, 'Доступ к меню билетов', NULL, NULL, 1549214079, 1549214079),
('operator', 1, 'Оператор встреч, в задачи которого входит обработка заявок', NULL, NULL, 1548034603, 1549215208),
('operator.ask', 2, 'Доступ оператора к данным заявок', NULL, NULL, 1548035151, 1549282566),
('operator.index', 2, 'Доступ к панели оператора', NULL, NULL, 1548038301, 1548038301),
('operator.member', 2, 'Доступ оператора к данным участников', NULL, NULL, 1548035269, 1548037741),
('operator.party', 2, 'Доступ оператора к данным встреч', NULL, NULL, 1548035376, 1549216130),
('operator.place', 2, 'Доступ оператора к данным мест', NULL, NULL, 1548035447, 1548038088),
('operator.ticket', 2, 'Доступ оператора к управлению билетами', NULL, NULL, 1549215184, 1549215184),
('party.block', 2, 'Доступ к заморозке встречи', NULL, NULL, 1548037419, 1548037461),
('party.create', 2, 'Доступ к созданию встречи', NULL, NULL, 1548031222, 1548031222),
('party.delete', 2, 'Доступ к удалению встречи', NULL, NULL, 1548031181, 1548031181),
('party.index', 2, 'Доступ к просмотру списка всех встреч', NULL, NULL, 1548031008, 1548031008),
('party.unblock', 2, 'Доступ к разморозке встречи', NULL, NULL, 1548037442, 1548037442),
('party.update', 2, 'Доступ к обновлению данных встречи', NULL, NULL, 1548031255, 1548031255),
('party.view', 2, 'Доступ к просмотру данных встречи', NULL, NULL, 1548031102, 1548031102),
('permission.create', 2, 'Доступ к созданию разрешения', NULL, NULL, 1549204058, 1549204058),
('permission.delete', 2, 'Доступ к удалению разрешения', NULL, NULL, 1549204257, 1549204257),
('permission.index', 2, 'Доступ к списку разрешений', NULL, NULL, 1549204404, 1549204404),
('permission.update', 2, 'Доступ к обновлению разрешения', NULL, NULL, 1549204122, 1549204122),
('place.block', 2, 'Доступ к блокировке места', NULL, NULL, 1548038988, 1548038988),
('place.create', 2, 'Доступ к созданию места встреч', NULL, NULL, 1548031580, 1548031580),
('place.delete', 2, 'Доступ к удалению места встреч', NULL, NULL, 1548031622, 1548031622),
('place.index', 2, 'Доступ к просмотру списка всех мест', NULL, NULL, 1548031542, 1548031542),
('place.unblock', 2, 'Доступ к разблокировке места', NULL, NULL, 1548039014, 1548039014),
('place.update', 2, 'Доступ к обновлению данных места', NULL, NULL, 1548031692, 1548031692),
('place.view', 2, 'Доступ к просмотру данных места', NULL, NULL, 1548031663, 1548031663),
('price.block', 2, 'Доступ к заморозке расценок', NULL, NULL, 1548039363, 1548039363),
('price.create', 2, 'Доступ к созданию новых расценок', NULL, NULL, 1548031859, 1548031859),
('price.delete', 2, 'Доступ к удалению расценок', NULL, NULL, 1548031888, 1548031888),
('price.index', 2, 'Доступ к списку всех расценок', NULL, NULL, 1548031798, 1548031798),
('price.unblock', 2, 'Доступ к разморозке расценок', NULL, NULL, 1548039381, 1548039381),
('price.update', 2, 'Доступ к обновлению данных расценок', NULL, NULL, 1548031905, 1548031905),
('price.view', 2, 'Доступ к просмотру данных расценки', NULL, NULL, 1548031830, 1548031830),
('role.create', 2, 'Доступ к созданию роли', NULL, NULL, 1549204023, 1549204023),
('role.delete', 2, 'Доступ к удалению роли', NULL, NULL, 1549204213, 1549204213),
('role.index', 2, 'Доступ к списку ролей', NULL, NULL, 1549204442, 1549204442),
('role.update', 2, 'Доступ к обновлению роли', NULL, NULL, 1549204183, 1549204183),
('rule.create', 2, 'Доступ к созданию правил', NULL, NULL, 1549203994, 1549203994),
('rule.delete', 2, 'Доступ к удалению правила', NULL, NULL, 1549204272, 1549204272),
('rule.index', 2, 'Доступ к списку правил', NULL, NULL, 1549204422, 1549204422),
('rule.search', 2, 'Доступ к поиску правил', NULL, NULL, 1549216920, 1549216920),
('rule.update', 2, 'Доступ к обновлению правила', NULL, NULL, 1549204156, 1549204156),
('setting.create', 2, 'Доступ к созданию настройки сайта', NULL, NULL, 1548117189, 1548117189),
('setting.delete', 2, 'Доступ к удалению настройки сайта', NULL, NULL, 1548118126, 1548118126),
('setting.index', 2, 'Доступ к списку настроек сайта', NULL, NULL, 1548116540, 1548116540),
('setting.update', 2, 'Доступ к обновлению данных настройки сайта', NULL, NULL, 1548117726, 1548117726),
('setting.view', 2, 'Доступ к просмотру данных настройки сайта', NULL, NULL, 1548117429, 1548117429),
('ticket.block', 2, 'Доступ к блокированию билета', NULL, NULL, 1548358254, 1548358254),
('ticket.create', 2, 'Доступ к созданию нового билета', NULL, NULL, 1548358193, 1548358193),
('ticket.delete', 2, 'Доступ к удалению билета', NULL, NULL, 1548358236, 1548358236),
('ticket.index', 2, 'Доступ к списку созданных билетов', NULL, NULL, 1548358151, 1548358151),
('ticket.unblock', 2, 'Доступ к разблокировке билета', NULL, NULL, 1548358281, 1548358281),
('ticket.update', 2, 'Доступ к обновлению данных билета', NULL, NULL, 1548358213, 1548358213),
('ticket.view', 2, 'Доступ к информации по билету', NULL, NULL, 1548358172, 1548358172),
('user', 1, 'Обычный пользователь сайта и участник встреч', NULL, NULL, 1548032202, 1548038593),
('user.ask', 2, 'Доступ участника к данным и управлению своими текущими заявками', NULL, NULL, 1548033826, 1549223440),
('user.index', 2, 'Доступ к панели участника', NULL, NULL, 1548038537, 1548038537),
('user.member', 2, 'Доступ к управлению своими данными участника', NULL, NULL, 1548032309, 1549223187),
('user.party', 2, 'Доступ участника к активным встречам и встречам, на которых он был', NULL, NULL, 1548034145, 1548039791),
('user.place', 2, 'Доступ участника к данным мест', NULL, NULL, 1548040380, 1548040380);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('dev', 'admin'),
('admin', 'admin.ask'),
('admin', 'admin.control'),
('admin', 'admin.group'),
('admin', 'admin.index'),
('admin', 'admin.media'),
('admin', 'admin.member'),
('admin', 'admin.party'),
('admin', 'admin.place'),
('admin', 'admin.price'),
('admin', 'admin.setting'),
('admin', 'admin.ticket'),
('admin.ask', 'ask.accept'),
('operator.ask', 'ask.accept'),
('admin.ask', 'ask.accept-all'),
('admin.ask', 'ask.block'),
('operator.ask', 'ask.block'),
('admin.ask', 'ask.create'),
('manager.ask', 'ask.create'),
('user.ask', 'ask.create'),
('admin.ask', 'ask.delete'),
('ask.delete-own', 'ask.delete'),
('operator.ask', 'ask.delete'),
('user.ask', 'ask.delete-own'),
('admin.ask', 'ask.index'),
('gold.ask', 'ask.index'),
('operator.ask', 'ask.index'),
('operator.ask', 'ask.member-save'),
('admin.ask', 'ask.reject-all'),
('admin.ask', 'ask.unblock'),
('operator.ask', 'ask.unblock'),
('admin.ask', 'ask.update'),
('ask.update-own', 'ask.update'),
('operator.ask', 'ask.update'),
('user.ask', 'ask.update-own'),
('admin.ask', 'ask.view'),
('ask.view-own', 'ask.view'),
('gold.ask', 'ask.view'),
('operator.ask', 'ask.view'),
('user.ask', 'ask.view-own'),
('dev', 'dev.permission'),
('dev', 'dev.role'),
('dev', 'dev.rule'),
('gold', 'gold.ask'),
('gold', 'gold.index'),
('gold', 'gold.member'),
('gold', 'gold.party'),
('admin.group', 'group.block'),
('admin.group', 'group.create'),
('admin.group', 'group.delete'),
('admin.group', 'group.index'),
('admin.group', 'group.unblock'),
('admin.group', 'group.update'),
('admin.group', 'group.view'),
('admin', 'manager'),
('manager', 'manager.ask'),
('manager', 'manager.group'),
('manager', 'manager.index'),
('manager', 'manager.media'),
('manager', 'manager.member'),
('manager', 'manager.party'),
('manager', 'manager.place'),
('manager', 'manager.price'),
('manager', 'manager.settings'),
('admin.media', 'media.crop'),
('admin.media', 'media.delete'),
('admin.media', 'media.get-original-image'),
('admin.media', 'media.index'),
('admin.media', 'media.upload'),
('admin.media', 'media.view'),
('admin.member', 'member.block'),
('manager.member', 'member.block'),
('admin.member', 'member.create'),
('manager.member', 'member.create'),
('admin.member', 'member.delete'),
('manager.member', 'member.delete'),
('member.delete-own', 'member.delete'),
('user.member', 'member.delete-own'),
('admin.member', 'member.index'),
('gold.member', 'member.index'),
('operator.member', 'member.index'),
('admin.member', 'member.unblock'),
('manager.member', 'member.unblock'),
('admin.member', 'member.update'),
('manager.member', 'member.update'),
('member.update-own', 'member.update'),
('user.member', 'member.update-own'),
('admin.member', 'member.view'),
('gold.member', 'member.view'),
('member.view-own', 'member.view'),
('operator.member', 'member.view'),
('user.member', 'member.view-own'),
('admin', 'menu.admin'),
('menu.operator', 'menu.ask'),
('menu.manager', 'menu.group'),
('manager', 'menu.manager'),
('menu.manager', 'menu.media'),
('menu.operator', 'menu.member'),
('operator', 'menu.operator'),
('menu.operator', 'menu.party'),
('menu.operator', 'menu.place'),
('menu.manager', 'menu.price'),
('menu.operator', 'menu.ticket'),
('manager', 'operator'),
('operator', 'operator.ask'),
('operator', 'operator.index'),
('operator', 'operator.member'),
('operator', 'operator.party'),
('operator', 'operator.place'),
('operator', 'operator.ticket'),
('admin.party', 'party.block'),
('manager.party', 'party.block'),
('admin.party', 'party.create'),
('manager.party', 'party.create'),
('admin.party', 'party.delete'),
('manager.party', 'party.delete'),
('admin.party', 'party.index'),
('gold.party', 'party.index'),
('operator.party', 'party.index'),
('user.party', 'party.index'),
('admin.party', 'party.unblock'),
('manager.party', 'party.unblock'),
('admin.party', 'party.update'),
('manager.party', 'party.update'),
('admin.party', 'party.view'),
('gold.party', 'party.view'),
('operator.party', 'party.view'),
('user.party', 'party.view'),
('dev.permission', 'permission.create'),
('dev.permission', 'permission.delete'),
('dev.permission', 'permission.index'),
('dev.permission', 'permission.update'),
('admin.place', 'place.block'),
('admin.place', 'place.create'),
('admin.place', 'place.delete'),
('admin.place', 'place.index'),
('operator.place', 'place.index'),
('user.place', 'place.index'),
('admin.place', 'place.unblock'),
('admin.place', 'place.update'),
('admin.place', 'place.view'),
('operator.place', 'place.view'),
('user.place', 'place.view'),
('admin.price', 'price.block'),
('manager.price', 'price.block'),
('admin.price', 'price.create'),
('admin.price', 'price.delete'),
('admin.price', 'price.index'),
('manager.price', 'price.index'),
('admin.price', 'price.unblock'),
('manager.price', 'price.unblock'),
('admin.price', 'price.update'),
('manager.price', 'price.update'),
('admin.price', 'price.view'),
('manager.price', 'price.view'),
('dev.role', 'role.create'),
('dev.role', 'role.delete'),
('dev.role', 'role.index'),
('dev.role', 'role.update'),
('dev.rule', 'rule.create'),
('dev.rule', 'rule.delete'),
('dev.rule', 'rule.index'),
('dev.rule', 'rule.search'),
('dev.rule', 'rule.update'),
('admin.setting', 'setting.create'),
('admin.setting', 'setting.delete'),
('admin.setting', 'setting.index'),
('manager.settings', 'setting.index'),
('admin.setting', 'setting.update'),
('manager.settings', 'setting.update'),
('admin.setting', 'setting.view'),
('manager.settings', 'setting.view'),
('admin.ticket', 'ticket.block'),
('admin.ticket', 'ticket.create'),
('operator.ticket', 'ticket.create'),
('admin.ticket', 'ticket.delete'),
('admin.ticket', 'ticket.index'),
('operator.ticket', 'ticket.index'),
('admin.ticket', 'ticket.unblock'),
('admin.ticket', 'ticket.update'),
('admin.ticket', 'ticket.view'),
('operator.ticket', 'ticket.view'),
('gold', 'user'),
('operator', 'user'),
('user', 'user.ask'),
('user', 'user.index'),
('user', 'user.member'),
('user', 'user.party');
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

-- Dump completed on 2019-02-03 19:59:00
