-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.32-community-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema dbcanchasonline
--

CREATE DATABASE IF NOT EXISTS dbcanchasonline;
USE dbcanchasonline;

--
-- Definition of table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE `administrador` (
  `ID_Administrador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  `ID_Privilegio` int(10) unsigned NOT NULL,
  `N_Usuario` varchar(50) CHARACTER SET latin1 NOT NULL,
  `T_Pass` varchar(50) CHARACTER SET latin1 NOT NULL,
  `F_Estado` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`ID_Administrador`),
  KEY `FK_administrador_1` (`ID_Privilegio`),
  CONSTRAINT `FK_administrador_1` FOREIGN KEY (`ID_Privilegio`) REFERENCES `privilegio` (`ID_Privilegio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrador`
--

/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` (`ID_Administrador`,`N_Nombre`,`ID_Privilegio`,`N_Usuario`,`T_Pass`,`F_Estado`) VALUES 
 (1,'admin',1,'admin','admin',1),
 (2,'Juan Perez',2,'club','club',1),
 (3,'Robinson',2,'club2','club2',1),
 (4,'club3',2,'club3','club3',1);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;


--
-- Definition of table `cancha`
--

DROP TABLE IF EXISTS `cancha`;
CREATE TABLE `cancha` (
  `ID_Cancha` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  `ID_TamanoCancha` int(10) unsigned DEFAULT NULL,
  `F_Techado` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ID_TipoCancha` int(10) unsigned NOT NULL,
  `ID_Deporte` int(10) unsigned NOT NULL,
  `T_Imagen` varchar(500) DEFAULT NULL,
  `F_Estado` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`ID_Cancha`),
  KEY `FK_cancha_1` (`ID_Deporte`),
  KEY `FK_cancha_2` (`ID_TamanoCancha`),
  KEY `FK_cancha_3` (`ID_TipoCancha`),
  CONSTRAINT `FK_cancha_1` FOREIGN KEY (`ID_Deporte`) REFERENCES `deporte` (`ID_Deporte`),
  CONSTRAINT `FK_cancha_2` FOREIGN KEY (`ID_TamanoCancha`) REFERENCES `tamcancha` (`ID_TamanoCancha`),
  CONSTRAINT `FK_cancha_3` FOREIGN KEY (`ID_TipoCancha`) REFERENCES `tipocancha` (`ID_TipoCancha`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cancha`
--

/*!40000 ALTER TABLE `cancha` DISABLE KEYS */;
INSERT INTO `cancha` (`ID_Cancha`,`N_Nombre`,`ID_TamanoCancha`,`F_Techado`,`ID_TipoCancha`,`ID_Deporte`,`T_Imagen`,`F_Estado`) VALUES 
 (1,'Cancha 1',1,0,2,1,'images/clubs/cancha/cf1.jpg',1),
 (2,'Cancha 2',2,0,2,1,'images/clubs/cancha/cf2.jpg',1),
 (3,'tenis 1',NULL,0,3,2,'images/clubs/cancha/ct1.jpg',1),
 (4,'tenis 2',NULL,0,5,2,'images/clubs/cancha/ct1.jpg',1),
 (8,'sadasd',1,0,2,1,'',1),
 (11,'cancha3',NULL,0,4,2,'',1),
 (12,'cancha3',NULL,0,4,2,'',1),
 (13,'cancha3',NULL,0,4,2,'',1),
 (14,'cancha3',NULL,0,4,2,NULL,1),
 (15,'cancha3',NULL,0,4,2,NULL,1),
 (16,'cancha4',NULL,0,3,2,NULL,1);
/*!40000 ALTER TABLE `cancha` ENABLE KEYS */;


--
-- Definition of table `canchaxclub`
--

DROP TABLE IF EXISTS `canchaxclub`;
CREATE TABLE `canchaxclub` (
  `ID_Cancha` int(10) unsigned NOT NULL,
  `ID_Club` int(10) unsigned NOT NULL,
  `C_Reputacion` varchar(45) DEFAULT '0',
  `C_Relevancia` varchar(45) DEFAULT '0',
  `C_Precio` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Cancha`,`ID_Club`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `canchaxclub`
--

/*!40000 ALTER TABLE `canchaxclub` DISABLE KEYS */;
INSERT INTO `canchaxclub` (`ID_Cancha`,`ID_Club`,`C_Reputacion`,`C_Relevancia`,`C_Precio`) VALUES 
 (0,0,'0','0',180),
 (0,1,'0','0',99),
 (1,1,'0','0',85),
 (1,3,'0','0',80),
 (2,1,'0','0',123),
 (2,3,'4','0',123),
 (3,1,'0','0',185),
 (3,3,'0','0',200),
 (4,1,'0','0',50),
 (16,1,'0','0',432);
/*!40000 ALTER TABLE `canchaxclub` ENABLE KEYS */;


--
-- Definition of table `club`
--

DROP TABLE IF EXISTS `club`;
CREATE TABLE `club` (
  `ID_Club` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  `ID_Distrito` int(10) unsigned NOT NULL,
  `T_Direccion` varchar(100) CHARACTER SET latin1 NOT NULL,
  `C_Telefono` varchar(10) CHARACTER SET latin1 NOT NULL,
  `ID_Estacionamiento` int(10) unsigned DEFAULT NULL,
  `ID_Kiosko` int(10) unsigned DEFAULT NULL,
  `ID_Ducha` int(10) unsigned DEFAULT NULL,
  `ID_Administrador` int(10) unsigned NOT NULL,
  `C_Relevancia` varchar(45) DEFAULT '0',
  `T_Banco` varchar(400) DEFAULT NULL,
  `T_CuentaBanco` varchar(400) DEFAULT NULL,
  `F_Estado` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`ID_Club`),
  KEY `FK_club_1` (`ID_Distrito`),
  KEY `FK_club_2` (`ID_Estacionamiento`),
  KEY `FK_club_3` (`ID_Kiosko`),
  KEY `FK_club_4` (`ID_Administrador`),
  KEY `FK_club_5` (`ID_Ducha`),
  CONSTRAINT `FK_club_1` FOREIGN KEY (`ID_Distrito`) REFERENCES `distrito` (`ID_Distrito`),
  CONSTRAINT `FK_club_2` FOREIGN KEY (`ID_Estacionamiento`) REFERENCES `estacionamiento` (`ID_Estacionamiento`),
  CONSTRAINT `FK_club_3` FOREIGN KEY (`ID_Kiosko`) REFERENCES `kiosko` (`ID_Kiosko`),
  CONSTRAINT `FK_club_4` FOREIGN KEY (`ID_Administrador`) REFERENCES `administrador` (`ID_Administrador`),
  CONSTRAINT `FK_club_5` FOREIGN KEY (`ID_Ducha`) REFERENCES `ducha` (`ID_Ducha`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `club`
--

/*!40000 ALTER TABLE `club` DISABLE KEYS */;
INSERT INTO `club` (`ID_Club`,`N_Nombre`,`ID_Distrito`,`T_Direccion`,`C_Telefono`,`ID_Estacionamiento`,`ID_Kiosko`,`ID_Ducha`,`ID_Administrador`,`C_Relevancia`,`T_Banco`,`T_CuentaBanco`,`F_Estado`) VALUES 
 (1,'El Club',41,'Av. bla bla','998268548',3,2,2,2,'0','','',1),
 (3,'El Club 2',26,'Jr. bla bla','978268545',7,2,2,3,'0','','',1);
/*!40000 ALTER TABLE `club` ENABLE KEYS */;


--
-- Definition of table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `ID_Configuracion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `C_IntervaloNivel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_Configuracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configuracion`
--

/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;


--
-- Definition of table `deporte`
--

DROP TABLE IF EXISTS `deporte`;
CREATE TABLE `deporte` (
  `ID_Deporte` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_Deporte`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deporte`
--

/*!40000 ALTER TABLE `deporte` DISABLE KEYS */;
INSERT INTO `deporte` (`ID_Deporte`,`N_Nombre`) VALUES 
 (1,'futbol'),
 (2,'tenis');
/*!40000 ALTER TABLE `deporte` ENABLE KEYS */;


--
-- Definition of table `distrito`
--

DROP TABLE IF EXISTS `distrito`;
CREATE TABLE `distrito` (
  `ID_Distrito` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  `C_Prioridad` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distrito`
--

/*!40000 ALTER TABLE `distrito` DISABLE KEYS */;
INSERT INTO `distrito` (`ID_Distrito`,`N_Nombre`,`C_Prioridad`) VALUES 
 (1,'Cercado',0),
 (2,'Ancon',0),
 (3,'Ate',0),
 (4,'Barranco',0),
 (5,'Breña',0),
 (6,'Carabayllo',0),
 (7,'Comas',0),
 (8,'Chaclacayo',0),
 (9,'Chorrillos',0),
 (10,'El Agustino',0),
 (11,'Jesus Maria',0),
 (12,'La Molina',1),
 (13,'La Victoria',0),
 (14,'Lince',1),
 (15,'Lurigancho',0),
 (16,'Lurin',0),
 (17,'Magdalena',0),
 (18,'Miraflores',0),
 (19,'Pachacamac',0),
 (20,'Pucusana',0),
 (21,'Pueblo Libre',0),
 (22,'Puente Piedra',0),
 (23,'Punta Negra',0),
 (24,'Punta Hermosa',0),
 (25,'Rimac',0),
 (26,'San Bartolo',0),
 (27,'San Isidro',0),
 (28,'Independencia',0),
 (29,'San Juan De Miraflores',0),
 (30,'San Luis',0),
 (31,'San Martin De Porres',0),
 (32,'San Miguel',0),
 (33,'Santiago De Surco',1),
 (34,'Surquillo',0),
 (35,'Villa Maria Del Triunfo',0),
 (36,'San Juan De Lurigancho',0),
 (37,'Santa Maria Del Mar',0),
 (38,'Santa Rosa',0),
 (39,'Los Olivos',0),
 (40,'Cieneguilla',1),
 (41,'San Borja',1),
 (42,'Villa El Salvador',0),
 (43,'Santa Anita',0);
/*!40000 ALTER TABLE `distrito` ENABLE KEYS */;


--
-- Definition of table `ducha`
--

DROP TABLE IF EXISTS `ducha`;
CREATE TABLE `ducha` (
  `ID_Ducha` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `F_AguaCaliente` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Ducha`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ducha`
--

/*!40000 ALTER TABLE `ducha` DISABLE KEYS */;
INSERT INTO `ducha` (`ID_Ducha`,`F_AguaCaliente`) VALUES 
 (1,0),
 (2,1);
/*!40000 ALTER TABLE `ducha` ENABLE KEYS */;


--
-- Definition of table `estacionamiento`
--

DROP TABLE IF EXISTS `estacionamiento`;
CREATE TABLE `estacionamiento` (
  `ID_Estacionamiento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `F_Pagado` smallint(5) unsigned NOT NULL DEFAULT '0',
  `F_Gratis` smallint(5) unsigned NOT NULL DEFAULT '0',
  `F_Vigilado` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Estacionamiento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `estacionamiento`
--

/*!40000 ALTER TABLE `estacionamiento` DISABLE KEYS */;
INSERT INTO `estacionamiento` (`ID_Estacionamiento`,`F_Pagado`,`F_Gratis`,`F_Vigilado`) VALUES 
 (1,0,0,0),
 (2,1,0,0),
 (3,0,1,0),
 (4,0,0,1),
 (5,1,1,0),
 (6,1,0,1),
 (7,0,1,1),
 (8,1,1,1);
/*!40000 ALTER TABLE `estacionamiento` ENABLE KEYS */;


--
-- Definition of table `hora`
--

DROP TABLE IF EXISTS `hora`;
CREATE TABLE `hora` (
  `ID_Hora` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `D_HoraInicio` int(10) unsigned NOT NULL,
  `D_HoraFin` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_Hora`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hora`
--

/*!40000 ALTER TABLE `hora` DISABLE KEYS */;
INSERT INTO `hora` (`ID_Hora`,`D_HoraInicio`,`D_HoraFin`) VALUES 
 (1,14,14),
 (2,15,15),
 (3,14,14),
 (4,15,15),
 (5,14,14),
 (6,15,15),
 (7,14,14),
 (8,15,15),
 (9,14,14),
 (10,15,15),
 (11,14,14),
 (12,15,15),
 (13,14,14),
 (14,15,15),
 (15,18,18),
 (16,19,19),
 (17,16,16),
 (18,17,17),
 (19,17,17),
 (20,18,18),
 (21,19,19),
 (22,17,17),
 (23,18,18),
 (24,14,14),
 (25,15,15),
 (26,13,13),
 (27,14,14),
 (28,15,15),
 (29,22,22),
 (30,23,23),
 (31,21,21),
 (32,21,21),
 (33,21,21),
 (34,21,21),
 (35,15,15),
 (36,16,16),
 (37,17,17),
 (38,15,15),
 (39,16,16),
 (40,17,17),
 (41,15,15),
 (42,16,16),
 (43,17,17),
 (44,15,15),
 (45,16,16),
 (46,17,17),
 (47,15,15),
 (48,16,16),
 (49,17,17),
 (50,23,23),
 (51,23,23),
 (52,22,22),
 (53,15,15),
 (54,16,16),
 (55,18,18),
 (56,19,19),
 (57,20,20),
 (58,20,20),
 (59,21,21),
 (60,22,22),
 (61,20,20),
 (62,21,21),
 (63,21,21),
 (64,22,22),
 (65,21,21),
 (66,22,22),
 (67,23,23),
 (68,21,21),
 (69,22,22),
 (70,23,23),
 (71,18,18),
 (72,19,19),
 (73,20,20),
 (74,18,18),
 (75,19,19),
 (76,17,17),
 (77,18,18),
 (78,20,20),
 (79,21,21),
 (80,21,21),
 (81,11,11),
 (82,16,16),
 (83,20,20),
 (84,15,15),
 (85,16,16),
 (86,9,9),
 (87,10,10),
 (88,13,13),
 (89,14,14),
 (90,11,11),
 (91,12,12),
 (92,20,20),
 (93,7,7),
 (94,7,7),
 (95,7,7),
 (96,7,7),
 (97,7,7),
 (98,7,7),
 (99,7,7),
 (100,7,7),
 (101,7,7),
 (102,7,7),
 (103,7,7),
 (104,7,7),
 (105,7,7),
 (106,7,7),
 (107,7,7),
 (108,7,7),
 (109,7,7),
 (110,7,7),
 (111,7,7),
 (112,7,7),
 (113,7,7),
 (114,7,7),
 (115,7,7),
 (116,7,7),
 (117,7,7),
 (118,7,7),
 (119,7,7),
 (120,7,7),
 (121,7,7),
 (122,7,7),
 (123,7,7),
 (124,7,7),
 (125,7,7),
 (126,7,7),
 (127,7,7),
 (128,7,7),
 (129,7,7),
 (130,7,7),
 (131,7,7),
 (132,7,7),
 (133,7,7),
 (134,7,7),
 (135,7,7),
 (136,7,7),
 (137,11,11),
 (138,17,17),
 (139,17,17),
 (140,17,17),
 (141,17,17),
 (142,14,14),
 (143,17,17),
 (144,12,12),
 (145,13,13),
 (146,20,20),
 (147,21,21),
 (148,17,17),
 (149,18,18),
 (150,16,16),
 (151,17,17),
 (152,20,20),
 (153,20,20),
 (154,20,20),
 (155,20,20),
 (156,20,20),
 (157,20,20),
 (158,20,20),
 (159,20,20),
 (160,8,8),
 (161,8,8),
 (162,19,19),
 (163,19,19),
 (164,11,11),
 (165,12,12),
 (166,13,13),
 (167,14,14),
 (168,15,15),
 (169,16,16),
 (170,17,17),
 (171,18,18),
 (172,20,20),
 (173,21,21),
 (174,22,22),
 (175,12,12),
 (176,12,12),
 (177,13,13),
 (178,13,13),
 (179,17,17),
 (180,10,10),
 (181,11,11),
 (182,23,23),
 (183,10,10),
 (184,11,11),
 (185,10,10),
 (186,11,11),
 (187,10,10),
 (188,11,11),
 (189,10,10),
 (190,11,11),
 (191,10,10),
 (192,11,11),
 (193,18,18),
 (194,19,19);
/*!40000 ALTER TABLE `hora` ENABLE KEYS */;


--
-- Definition of table `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario` (
  `ID_Hora` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Cancha` int(10) unsigned NOT NULL,
  `ID_Reserva` int(10) unsigned DEFAULT NULL,
  `D_Fecha` datetime NOT NULL,
  `C_Dia` int(10) unsigned NOT NULL,
  `ID_Club` int(10) unsigned NOT NULL,
  `F_Califica` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Hora`) USING BTREE,
  KEY `FK_horario_4` (`D_Fecha`) USING BTREE,
  KEY `FK_horario_3` (`ID_Cancha`,`ID_Club`),
  KEY `FK_horario_2` (`ID_Reserva`),
  CONSTRAINT `FK_horario_1` FOREIGN KEY (`ID_Hora`) REFERENCES `hora` (`ID_Hora`),
  CONSTRAINT `FK_horario_2` FOREIGN KEY (`ID_Reserva`) REFERENCES `reserva` (`ID_Reserva`),
  CONSTRAINT `FK_horario_3` FOREIGN KEY (`ID_Cancha`, `ID_Club`) REFERENCES `canchaxclub` (`ID_Cancha`, `ID_Club`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `horario`
--

/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` (`ID_Hora`,`ID_Cancha`,`ID_Reserva`,`D_Fecha`,`C_Dia`,`ID_Club`,`F_Califica`) VALUES 
 (5,1,2,'2009-06-13 00:00:00',5,1,0),
 (6,1,2,'2009-06-13 00:00:00',5,1,0),
 (7,1,3,'2009-06-13 00:00:00',5,1,0),
 (8,1,3,'2009-06-13 00:00:00',5,1,0),
 (9,1,4,'2009-06-13 00:00:00',5,3,0),
 (10,1,4,'2009-06-13 00:00:00',5,3,0),
 (11,1,5,'2009-06-13 00:00:00',5,3,0),
 (12,1,5,'2009-06-13 00:00:00',5,3,0),
 (13,1,6,'2009-06-13 00:00:00',5,3,0),
 (14,1,6,'2009-06-13 00:00:00',5,3,0),
 (15,1,7,'2009-06-13 00:00:00',5,3,0),
 (16,1,7,'2009-06-13 00:00:00',5,3,0),
 (17,1,8,'2009-06-13 00:00:00',5,1,0),
 (18,1,8,'2009-06-13 00:00:00',5,1,0),
 (19,1,9,'2009-06-13 00:00:00',5,1,0),
 (20,1,9,'2009-06-13 00:00:00',5,1,0),
 (21,1,9,'2009-06-13 00:00:00',5,1,0),
 (22,1,10,'2009-06-13 00:00:00',7,1,0),
 (23,1,10,'2009-06-13 00:00:00',7,1,0),
 (35,2,11,'2009-06-15 00:00:00',2,3,0),
 (36,2,11,'2009-06-15 00:00:00',2,1,0),
 (37,2,11,'2009-06-15 00:00:00',2,1,0),
 (38,2,12,'2009-06-15 00:00:00',2,3,0),
 (39,2,12,'2009-06-15 00:00:00',2,3,0),
 (40,2,12,'2009-06-15 00:00:00',2,3,0),
 (41,2,13,'2009-06-15 00:00:00',1,3,0),
 (42,2,13,'2009-06-15 00:00:00',1,3,0),
 (43,2,13,'2009-06-15 00:00:00',1,1,0),
 (44,2,14,'2009-06-15 00:00:00',1,1,0),
 (45,2,14,'2009-06-15 00:00:00',1,1,0),
 (46,2,14,'2009-06-15 00:00:00',1,1,0),
 (47,2,15,'2009-06-15 00:00:00',1,3,0),
 (48,2,15,'2009-06-15 00:00:00',1,3,0),
 (49,2,15,'2009-06-15 00:00:00',1,3,0),
 (50,2,16,'2009-06-15 00:00:00',3,3,0),
 (52,2,17,'2009-06-28 00:00:00',2,1,0),
 (53,1,18,'2009-06-28 00:00:00',1,1,0),
 (54,1,18,'2009-06-28 00:00:00',1,1,0),
 (55,1,19,'2009-06-28 00:00:00',7,1,0),
 (56,1,19,'2009-06-28 00:00:00',7,1,0),
 (57,1,19,'2009-06-28 00:00:00',7,1,0),
 (58,1,20,'2009-06-28 00:00:00',1,1,0),
 (59,1,20,'2009-06-28 00:00:00',1,1,0),
 (60,1,20,'2009-06-28 00:00:00',1,1,0),
 (61,1,21,'2009-06-01 00:00:00',7,1,0),
 (62,1,21,'2009-06-01 00:00:00',6,1,0),
 (63,1,21,'2009-06-01 00:00:00',7,1,0),
 (64,1,21,'2009-06-01 00:00:00',6,1,0),
 (65,1,22,'2009-06-19 00:00:00',5,1,0),
 (66,1,22,'2009-06-19 00:00:00',5,1,0),
 (67,1,22,'2009-06-19 00:00:00',5,1,0),
 (68,1,23,'2009-06-19 00:00:00',5,1,0),
 (69,1,23,'2009-06-19 00:00:00',5,1,0),
 (70,1,23,'2009-06-19 00:00:00',5,1,0),
 (71,1,24,'2009-06-20 00:00:00',6,1,0),
 (72,1,24,'2009-06-20 00:00:00',6,1,0),
 (73,1,26,'2009-06-20 00:00:00',6,1,0),
 (74,1,27,'2009-06-24 00:00:00',3,1,0),
 (75,1,27,'2009-06-24 00:00:00',3,1,0),
 (76,1,28,'2009-06-30 00:00:00',2,1,0),
 (77,1,28,'2009-06-30 00:00:00',2,1,0),
 (78,1,29,'2009-06-27 00:00:00',6,1,0),
 (79,1,29,'2009-06-26 00:00:00',5,1,0),
 (80,1,29,'2009-06-27 00:00:00',6,1,0),
 (81,2,30,'2009-06-28 00:00:00',7,1,0),
 (82,2,30,'2009-06-28 00:00:00',7,1,0),
 (83,1,31,'2009-06-30 00:00:00',2,3,0),
 (84,1,32,'2009-06-30 00:00:00',2,1,0),
 (85,1,32,'2009-06-30 00:00:00',2,1,0),
 (86,1,33,'2009-06-27 00:00:00',6,1,0),
 (87,1,33,'2009-06-27 00:00:00',6,1,0),
 (88,1,34,'2009-07-26 00:00:00',7,1,0),
 (89,1,34,'2009-07-26 00:00:00',7,1,0),
 (90,1,35,'2009-07-26 00:00:00',7,1,0),
 (91,1,35,'2009-07-26 00:00:00',7,1,0),
 (92,1,36,'2009-07-28 00:00:00',2,1,0),
 (93,2,37,'2009-08-03 00:00:00',1,1,0),
 (94,2,37,'2009-08-04 00:00:00',2,1,0),
 (95,2,37,'2009-08-05 00:00:00',3,1,0),
 (96,1,38,'2009-08-03 00:00:00',1,3,0),
 (97,2,39,'2009-08-03 00:00:00',1,3,0),
 (98,2,40,'2009-08-03 00:00:00',1,3,0),
 (99,2,41,'2009-08-03 00:00:00',1,1,0),
 (100,2,41,'2009-08-04 00:00:00',2,1,0),
 (101,2,41,'2009-08-05 00:00:00',3,1,0),
 (102,2,42,'2009-08-03 00:00:00',1,1,0),
 (103,2,42,'2009-08-04 00:00:00',2,1,0),
 (104,2,42,'2009-08-05 00:00:00',3,1,0),
 (105,2,43,'2009-08-03 00:00:00',1,1,0),
 (106,2,43,'2009-08-04 00:00:00',2,1,0),
 (107,2,43,'2009-08-05 00:00:00',3,1,0),
 (108,2,44,'2009-08-03 00:00:00',1,1,0),
 (109,2,44,'2009-08-04 00:00:00',2,1,0),
 (110,2,44,'2009-08-05 00:00:00',3,1,0),
 (111,2,45,'2009-08-03 00:00:00',1,3,0),
 (112,2,46,'2009-08-03 00:00:00',1,1,0),
 (113,2,46,'2009-08-04 00:00:00',2,1,0),
 (114,2,46,'2009-08-05 00:00:00',3,1,0),
 (115,2,47,'2009-08-03 00:00:00',1,1,0),
 (116,2,47,'2009-08-04 00:00:00',2,1,0),
 (117,2,47,'2009-08-05 00:00:00',3,1,0),
 (118,2,48,'2009-08-03 00:00:00',1,3,0),
 (119,2,49,'2009-08-03 00:00:00',1,3,0),
 (120,2,50,'2009-08-03 00:00:00',1,1,0),
 (121,2,50,'2009-08-04 00:00:00',2,1,0),
 (122,2,50,'2009-08-05 00:00:00',3,1,0),
 (123,2,51,'2009-08-03 00:00:00',1,1,0),
 (124,2,51,'2009-08-04 00:00:00',2,1,0),
 (125,2,51,'2009-08-05 00:00:00',3,1,0),
 (126,2,52,'2009-08-03 00:00:00',1,3,0),
 (127,2,53,'2009-08-03 00:00:00',1,1,0),
 (128,2,53,'2009-08-04 00:00:00',2,1,0),
 (129,2,53,'2009-08-05 00:00:00',3,1,0),
 (130,2,54,'2009-08-03 00:00:00',1,3,0),
 (131,2,55,'2009-08-03 00:00:00',1,3,0),
 (132,2,56,'2009-08-03 00:00:00',1,1,0),
 (133,2,56,'2009-08-04 00:00:00',2,1,0),
 (134,2,56,'2009-08-05 00:00:00',3,1,0),
 (135,2,57,'2009-08-04 00:00:00',2,3,0),
 (136,2,58,'2009-08-04 00:00:00',2,3,0),
 (137,2,60,'2009-08-05 00:00:00',3,3,0),
 (138,2,61,'2009-08-11 00:00:00',2,1,0),
 (139,1,62,'2009-08-01 00:00:00',6,1,0),
 (140,1,62,'2009-08-02 00:00:00',7,1,0),
 (141,1,62,'2009-08-03 00:00:00',1,1,0),
 (142,2,63,'2009-08-03 00:00:00',1,1,0),
 (143,2,64,'2009-08-02 00:00:00',7,1,0),
 (144,4,65,'2009-08-05 00:00:00',3,1,0),
 (145,4,65,'2009-08-05 00:00:00',3,1,0),
 (146,4,65,'2009-08-05 00:00:00',3,1,0),
 (147,4,65,'2009-08-05 00:00:00',3,1,0),
 (148,3,66,'2009-08-04 00:00:00',2,3,0),
 (149,3,66,'2009-08-06 00:00:00',4,3,0),
 (150,2,67,'2009-08-07 00:00:00',5,1,0),
 (151,2,67,'2009-08-07 00:00:00',5,1,0),
 (152,2,68,'2009-08-11 00:00:00',2,1,0),
 (153,2,69,'2009-08-11 00:00:00',2,1,0),
 (154,2,70,'2009-08-11 00:00:00',2,1,0),
 (155,2,71,'2009-08-11 00:00:00',2,1,0),
 (156,2,72,'2009-08-11 00:00:00',2,1,0),
 (157,2,73,'2009-08-11 00:00:00',2,1,0),
 (158,2,74,'2009-08-11 00:00:00',2,1,0),
 (159,2,75,'2009-08-11 00:00:00',2,1,0),
 (160,3,76,'2009-08-10 00:00:00',1,3,0),
 (161,3,77,'2009-08-10 00:00:00',1,3,0),
 (162,1,78,'2009-08-10 00:00:00',1,3,0),
 (163,1,78,'2009-08-11 00:00:00',2,3,0),
 (164,1,79,'2009-08-10 00:00:00',1,3,0),
 (165,1,79,'2009-08-10 00:00:00',1,3,0),
 (166,1,79,'2009-08-10 00:00:00',1,3,0),
 (167,1,79,'2009-08-10 00:00:00',1,3,0),
 (168,1,79,'2009-08-10 00:00:00',1,3,0),
 (169,1,79,'2009-08-10 00:00:00',1,3,0),
 (170,1,79,'2009-08-10 00:00:00',1,3,0),
 (171,1,79,'2009-08-10 00:00:00',1,3,0),
 (172,1,79,'2009-08-10 00:00:00',1,3,0),
 (173,1,79,'2009-08-10 00:00:00',1,3,0),
 (174,1,79,'2009-08-10 00:00:00',1,3,0),
 (175,2,80,'2009-08-09 00:00:00',7,1,0),
 (176,2,80,'2009-08-10 00:00:00',1,1,0),
 (177,2,80,'2009-08-09 00:00:00',7,1,0),
 (178,2,80,'2009-08-10 00:00:00',1,1,0),
 (179,2,80,'2009-08-09 00:00:00',7,1,0),
 (180,1,81,'2009-08-08 00:00:00',6,3,0),
 (181,1,81,'2009-08-08 00:00:00',6,3,0),
 (182,2,82,'2009-08-12 00:00:00',3,1,0),
 (183,4,83,'2009-08-08 00:00:00',6,1,0),
 (184,4,83,'2009-08-08 00:00:00',6,1,0),
 (185,4,84,'2009-08-08 00:00:00',6,1,0),
 (186,4,84,'2009-08-08 00:00:00',6,1,0),
 (187,4,85,'2009-08-08 00:00:00',6,1,0),
 (188,4,85,'2009-08-08 00:00:00',6,1,0),
 (189,4,86,'2009-08-08 00:00:00',6,1,0),
 (190,4,86,'2009-08-08 00:00:00',6,1,0),
 (191,2,87,'2009-08-08 00:00:00',6,1,0),
 (192,2,87,'2009-08-08 00:00:00',6,1,0),
 (193,2,87,'2009-08-11 00:00:00',2,1,0),
 (194,2,87,'2009-08-11 00:00:00',2,1,0);
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;


--
-- Definition of table `kiosko`
--

DROP TABLE IF EXISTS `kiosko`;
CREATE TABLE `kiosko` (
  `ID_Kiosko` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `F_Chela` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Kiosko`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kiosko`
--

/*!40000 ALTER TABLE `kiosko` DISABLE KEYS */;
INSERT INTO `kiosko` (`ID_Kiosko`,`F_Chela`) VALUES 
 (1,0),
 (2,1);
/*!40000 ALTER TABLE `kiosko` ENABLE KEYS */;


--
-- Definition of table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
CREATE TABLE `notificacion` (
  `ID_Notificacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `T_Detalle` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `ID_Privilegio` int(10) unsigned NOT NULL,
  `D_Fecha` datetime NOT NULL,
  PRIMARY KEY (`ID_Notificacion`),
  KEY `FK_notificacion_1` (`ID_Privilegio`),
  CONSTRAINT `FK_notificacion_1` FOREIGN KEY (`ID_Privilegio`) REFERENCES `privilegio` (`ID_Privilegio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notificacion`
--

/*!40000 ALTER TABLE `notificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificacion` ENABLE KEYS */;


--
-- Definition of table `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago` (
  `ID_Pago` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `D_FechaPago` datetime NOT NULL,
  `C_Voucher` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_Pago`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pago`
--

/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` (`ID_Pago`,`D_FechaPago`,`C_Voucher`) VALUES 
 (1,'2009-06-15 00:00:00','1234567891'),
 (2,'2009-06-16 00:00:00','1234569871'),
 (3,'0000-00-00 00:00:00','9876543211'),
 (4,'0000-00-00 00:00:00','9876543218'),
 (5,'0000-00-00 00:00:00','98715975318'),
 (6,'0000-00-00 00:00:00','159753465854'),
 (7,'0000-00-00 00:00:00','123222222'),
 (8,'0000-00-00 00:00:00','-8399'),
 (9,'0000-00-00 00:00:00','98776545545'),
 (10,'0000-00-00 00:00:00','567567567'),
 (11,'0000-00-00 00:00:00','1234');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;


--
-- Definition of table `privilegio`
--

DROP TABLE IF EXISTS `privilegio`;
CREATE TABLE `privilegio` (
  `ID_Privilegio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_Privilegio`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilegio`
--

/*!40000 ALTER TABLE `privilegio` DISABLE KEYS */;
INSERT INTO `privilegio` (`ID_Privilegio`,`N_Nombre`) VALUES 
 (1,'administrador'),
 (2,'club');
/*!40000 ALTER TABLE `privilegio` ENABLE KEYS */;


--
-- Definition of table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `ID_Reserva` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Usuario` int(10) unsigned NOT NULL,
  `D_FechaReserva` datetime NOT NULL,
  `ID_Pago` int(10) unsigned DEFAULT NULL,
  `T_DetallesAdicionales` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `T_Estado` smallint(5) unsigned DEFAULT '0',
  `T_Ranking` smallint(5) unsigned DEFAULT '0',
  `C_MontoTotal` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Reserva`) USING BTREE,
  KEY `FK_reserva_1` (`ID_Pago`),
  KEY `FK_reserva_2` (`ID_Usuario`),
  CONSTRAINT `FK_reserva_1` FOREIGN KEY (`ID_Pago`) REFERENCES `pago` (`ID_Pago`),
  CONSTRAINT `FK_reserva_2` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reserva`
--

/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` (`ID_Reserva`,`ID_Usuario`,`D_FechaReserva`,`ID_Pago`,`T_DetallesAdicionales`,`T_Estado`,`T_Ranking`,`C_MontoTotal`) VALUES 
 (1,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (2,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (3,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (4,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (5,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (6,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (7,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (8,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (9,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (10,2,'2009-06-05 00:00:00',1,NULL,0,0,0),
 (11,2,'2009-06-12 00:00:00',2,NULL,0,0,0),
 (12,2,'2009-06-12 00:00:00',2,NULL,0,0,0),
 (13,2,'2009-06-12 00:00:00',2,NULL,0,0,0),
 (14,2,'2009-06-12 00:00:00',2,NULL,0,0,0),
 (15,2,'2009-06-12 00:00:00',2,NULL,0,0,0),
 (16,2,'2009-06-12 00:00:00',2,NULL,0,0,0),
 (17,2,'2009-06-12 00:00:00',2,NULL,1,0,0),
 (18,2,'2009-06-12 00:00:00',2,NULL,1,0,0),
 (19,3,'2009-06-19 00:00:00',5,NULL,0,0,0),
 (20,3,'2009-06-19 00:00:00',6,NULL,0,0,0),
 (21,3,'2009-06-19 00:00:00',NULL,NULL,0,0,0),
 (22,3,'2009-06-19 00:00:00',NULL,NULL,0,0,0),
 (23,3,'2009-06-19 00:00:00',NULL,'\".$adi_aux.\"',0,0,0),
 (24,3,'2009-06-19 00:00:00',NULL,NULL,0,0,0),
 (25,3,'2009-06-19 00:00:00',NULL,NULL,0,0,0),
 (26,3,'2009-06-19 00:00:00',NULL,'camisetas;',0,0,0),
 (27,2,'2009-06-22 00:00:00',NULL,'camisetas;arbitro;',0,0,0),
 (28,6,'2009-06-25 00:00:00',NULL,'camisetas;arbitro;',0,0,0),
 (29,2,'2009-06-26 00:00:00',NULL,'arbitro;',0,0,0),
 (30,6,'2009-06-26 00:00:00',NULL,NULL,0,0,0),
 (31,2,'2009-06-26 00:00:00',NULL,NULL,0,0,0),
 (32,2,'2009-06-26 00:00:00',NULL,NULL,0,0,0),
 (33,2,'2009-06-26 00:00:00',NULL,NULL,0,0,0),
 (34,2,'2009-07-22 00:00:00',NULL,'camisetas;',0,0,0),
 (35,2,'2009-07-24 00:00:00',NULL,NULL,0,0,0),
 (36,2,'2009-07-24 00:00:00',NULL,'camisetas;',0,0,0),
 (37,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (38,2,'2009-07-30 00:00:00',7,NULL,0,0,0),
 (39,2,'2009-07-30 00:00:00',9,NULL,0,0,0),
 (40,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (41,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (42,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (43,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (44,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (45,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (46,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (47,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (48,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (49,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (50,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (51,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (52,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (53,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (54,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (55,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (56,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (57,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (58,2,'2009-07-30 00:00:00',NULL,'camisetas;',0,0,0),
 (59,3,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (60,3,'2009-07-30 00:00:00',NULL,'camisetas;',0,0,0),
 (61,3,'2009-07-30 00:00:00',10,'camisetas;',0,0,0),
 (62,2,'2009-07-30 00:00:00',NULL,NULL,0,0,0),
 (63,2,'2009-07-31 00:00:00',NULL,NULL,0,0,0),
 (64,2,'2009-07-31 00:00:00',NULL,'camisetas;',0,0,0),
 (65,2,'2009-08-03 00:00:00',8,'raquetas;',0,0,0),
 (66,7,'2009-08-03 00:00:00',NULL,NULL,0,0,220),
 (67,2,'2009-08-03 00:00:00',NULL,'camisetas;',0,0,0),
 (68,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (69,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (70,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (71,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (72,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (73,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (74,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (75,2,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (76,3,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (77,3,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (78,3,'2009-08-06 00:00:00',NULL,NULL,0,0,400),
 (79,6,'2009-08-06 00:00:00',NULL,'camisetas;',0,0,2060),
 (80,6,'2009-08-06 00:00:00',NULL,'camisetas;',0,0,900),
 (81,8,'2009-08-06 00:00:00',NULL,NULL,0,0,160),
 (82,3,'2009-08-06 00:00:00',NULL,'camisetas;',0,0,135),
 (83,9,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (84,9,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (85,9,'2009-08-06 00:00:00',NULL,NULL,0,0,0),
 (86,9,'2009-08-06 00:00:00',NULL,'raquetas;',0,0,100),
 (87,10,'2009-08-06 00:00:00',11,'camisetas;arbitro;',0,0,516);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;


--
-- Definition of table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
CREATE TABLE `servicio` (
  `ID_Servicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  `F_Opcional` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ID_Deporte` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_Servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicio`
--

/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` (`ID_Servicio`,`N_Nombre`,`F_Opcional`,`ID_Deporte`) VALUES 
 (1,'arbitro',0,1),
 (2,'arbitro',1,1),
 (3,'camisetas',0,1),
 (4,'camisetas',1,1),
 (5,'raquetas',0,2),
 (6,'raquetas',1,2),
 (7,'luz',0,1);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;


--
-- Definition of table `servicioxclub`
--

DROP TABLE IF EXISTS `servicioxclub`;
CREATE TABLE `servicioxclub` (
  `ID_Servicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Club` int(10) unsigned NOT NULL,
  `F_Recargo` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Servicio`,`ID_Club`),
  KEY `FK_servicioxclub_2` (`ID_Club`),
  CONSTRAINT `FK_servicioxclub_1` FOREIGN KEY (`ID_Servicio`) REFERENCES `servicio` (`ID_Servicio`),
  CONSTRAINT `FK_servicioxclub_2` FOREIGN KEY (`ID_Club`) REFERENCES `club` (`ID_Club`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicioxclub`
--

/*!40000 ALTER TABLE `servicioxclub` DISABLE KEYS */;
INSERT INTO `servicioxclub` (`ID_Servicio`,`ID_Club`,`F_Recargo`) VALUES 
 (2,1,20),
 (2,3,12),
 (4,1,12),
 (4,3,12),
 (6,1,12),
 (7,1,12),
 (7,3,20);
/*!40000 ALTER TABLE `servicioxclub` ENABLE KEYS */;


--
-- Definition of table `tamcancha`
--

DROP TABLE IF EXISTS `tamcancha`;
CREATE TABLE `tamcancha` (
  `ID_TamanoCancha` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) CHARACTER SET latin1 NOT NULL,
  `ID_Deporte` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_TamanoCancha`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tamcancha`
--

/*!40000 ALTER TABLE `tamcancha` DISABLE KEYS */;
INSERT INTO `tamcancha` (`ID_TamanoCancha`,`N_Nombre`,`ID_Deporte`) VALUES 
 (1,'futbol 7',1),
 (2,'futbol 5',1);
/*!40000 ALTER TABLE `tamcancha` ENABLE KEYS */;


--
-- Definition of table `tipocancha`
--

DROP TABLE IF EXISTS `tipocancha`;
CREATE TABLE `tipocancha` (
  `ID_TipoCancha` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Tipo` varchar(45) CHARACTER SET latin1 NOT NULL,
  `ID_Deporte` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_TipoCancha`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipocancha`
--

/*!40000 ALTER TABLE `tipocancha` DISABLE KEYS */;
INSERT INTO `tipocancha` (`ID_TipoCancha`,`N_Tipo`,`ID_Deporte`) VALUES 
 (1,'cesped','1'),
 (2,'cemento','1'),
 (3,'arcilla','2'),
 (4,'cesped','2'),
 (5,'cemento','2');
/*!40000 ALTER TABLE `tipocancha` ENABLE KEYS */;


--
-- Definition of table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `ID_Usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(100) CHARACTER SET latin1 NOT NULL,
  `C_Telefono` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `D_FechaNacimiento` datetime DEFAULT NULL,
  `T_Imagen` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `ID_Distrito` int(10) unsigned DEFAULT NULL,
  `T_Direccion` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `C_Puntos` int(10) unsigned DEFAULT '0',
  `T_Email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `T_Pass` varchar(16) CHARACTER SET latin1 NOT NULL,
  `F_Estado` smallint(5) unsigned DEFAULT '1',
  `N_Apellido` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_Usuario`),
  KEY `FK_usuario_1` (`ID_Distrito`),
  CONSTRAINT `FK_usuario_1` FOREIGN KEY (`ID_Distrito`) REFERENCES `distrito` (`ID_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`ID_Usuario`,`N_Nombre`,`C_Telefono`,`D_FechaNacimiento`,`T_Imagen`,`ID_Distrito`,`T_Direccion`,`C_Puntos`,`T_Email`,`T_Pass`,`F_Estado`,`N_Apellido`) VALUES 
 (1,'admin','923456789','1986-06-16 00:00:00',NULL,41,'JR. Las Avellanas',0,'a@a.com','a',1,'qwe'),
 (2,'Peluca','235235477','1986-05-28 00:00:00','',34,'Calle siempre viva 177',0,'b@b.com','b',1,'qwe'),
 (3,'asd',NULL,'0000-00-00 00:00:00',NULL,12,NULL,0,'c@c.com','c',1,'qwe'),
 (4,'sdfsdf',NULL,'2000-05-16 00:00:00',NULL,26,NULL,0,'d@d.com','d',1,'qwe'),
 (5,'sdfsdf',NULL,'1981-11-25 00:00:00',NULL,29,NULL,0,'e@e.com','e',1,'qwe'),
 (6,'f','234','1998-12-19 00:00:00',NULL,19,'fgdfg',0,'f@f.com','f',1,'qwe'),
 (7,'Alejandro','12312312312','1985-06-12 00:00:00',NULL,12,'sadd',0,'alejandromv12@hotmail.com','MANA',1,'Martinez'),
 (8,'Rodrigo',NULL,'1986-09-22 00:00:00','Files/fotos/2e1bed_5649_129244230604_606955604_3511305_7486181_n.jpg',33,NULL,0,'rsarria86@yahoo.com','ratita',1,'Sarria'),
 (9,'Felipe',NULL,'1986-12-10 00:00:00',NULL,18,NULL,0,'fcarreno1@hotmail.com','felipao',1,'CarreÃ±o van Oordt'),
 (10,'alberto',NULL,'1986-05-02 00:00:00',NULL,3,NULL,0,'larg_86@hotmail.com','chiquillo',1,'ramirez gallo');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
