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
  PRIMARY KEY (`ID_Administrador`),
  KEY `FK_administrador_1` (`ID_Privilegio`),
  CONSTRAINT `FK_administrador_1` FOREIGN KEY (`ID_Privilegio`) REFERENCES `privilegio` (`ID_Privilegio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrador`
--

/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` (`ID_Administrador`,`N_Nombre`,`ID_Privilegio`,`N_Usuario`,`T_Pass`) VALUES 
 (1,'admin',1,'admin','admin'),
 (2,'Juan Perez',2,'club','club'),
 (3,'Robinson',2,'club2','club2');
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
  `C_Precio` int(10) unsigned NOT NULL,
  `ID_TipoCancha` int(10) unsigned NOT NULL,
  `ID_Deporte` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_Cancha`),
  KEY `FK_cancha_1` (`ID_Deporte`),
  KEY `FK_cancha_2` (`ID_TamanoCancha`),
  KEY `FK_cancha_3` (`ID_TipoCancha`),
  CONSTRAINT `FK_cancha_1` FOREIGN KEY (`ID_Deporte`) REFERENCES `deporte` (`ID_Deporte`),
  CONSTRAINT `FK_cancha_2` FOREIGN KEY (`ID_TamanoCancha`) REFERENCES `tamcancha` (`ID_TamanoCancha`),
  CONSTRAINT `FK_cancha_3` FOREIGN KEY (`ID_TipoCancha`) REFERENCES `tipocancha` (`ID_TipoCancha`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cancha`
--

/*!40000 ALTER TABLE `cancha` DISABLE KEYS */;
INSERT INTO `cancha` (`ID_Cancha`,`N_Nombre`,`ID_TamanoCancha`,`F_Techado`,`C_Precio`,`ID_TipoCancha`,`ID_Deporte`) VALUES 
 (1,'Cancha 1',1,0,180,2,1),
 (2,'Cancha 2',2,0,180,1,1),
 (3,'tenis 1',NULL,0,100,3,2),
 (4,'tenis 2',NULL,0,80,5,2);
/*!40000 ALTER TABLE `cancha` ENABLE KEYS */;


--
-- Definition of table `canchaxclub`
--

DROP TABLE IF EXISTS `canchaxclub`;
CREATE TABLE `canchaxclub` (
  `ID_Cancha` int(10) unsigned NOT NULL,
  `ID_Club` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_Cancha`,`ID_Club`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `canchaxclub`
--

/*!40000 ALTER TABLE `canchaxclub` DISABLE KEYS */;
INSERT INTO `canchaxclub` (`ID_Cancha`,`ID_Club`) VALUES 
 (0,0),
 (1,1),
 (1,3),
 (2,1),
 (2,3),
 (3,1),
 (3,3),
 (4,1);
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
INSERT INTO `club` (`ID_Club`,`N_Nombre`,`ID_Distrito`,`T_Direccion`,`C_Telefono`,`ID_Estacionamiento`,`ID_Kiosko`,`ID_Ducha`,`ID_Administrador`) VALUES 
 (1,'El Club',41,'Av. bla bla','998268545',3,2,2,2),
 (3,'El Club 2',26,'Jr. bla bla','978268545',7,2,2,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

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
 (73,20,20);
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
  PRIMARY KEY (`ID_Hora`) USING BTREE,
  KEY `FK_horario_4` (`D_Fecha`) USING BTREE,
  KEY `FK_horario_3` (`ID_Cancha`,`ID_Club`),
  KEY `FK_horario_2` (`ID_Reserva`),
  CONSTRAINT `FK_horario_3` FOREIGN KEY (`ID_Cancha`, `ID_Club`) REFERENCES `canchaxclub` (`ID_Cancha`, `ID_Club`),
  CONSTRAINT `FK_horario_2` FOREIGN KEY (`ID_Reserva`) REFERENCES `reserva` (`ID_Reserva`),
  CONSTRAINT `FK_horario_1` FOREIGN KEY (`ID_Hora`) REFERENCES `hora` (`ID_Hora`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `horario`
--

/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` (`ID_Hora`,`ID_Cancha`,`ID_Reserva`,`D_Fecha`,`C_Dia`,`ID_Club`) VALUES 
 (5,1,2,'2009-06-13 00:00:00',5,1),
 (6,1,2,'2009-06-13 00:00:00',5,1),
 (7,1,3,'2009-06-13 00:00:00',5,1),
 (8,1,3,'2009-06-13 00:00:00',5,1),
 (9,1,4,'2009-06-13 00:00:00',5,3),
 (10,1,4,'2009-06-13 00:00:00',5,3),
 (11,1,5,'2009-06-13 00:00:00',5,3),
 (12,1,5,'2009-06-13 00:00:00',5,3),
 (13,1,6,'2009-06-13 00:00:00',5,3),
 (14,1,6,'2009-06-13 00:00:00',5,3),
 (15,1,7,'2009-06-13 00:00:00',5,3),
 (16,1,7,'2009-06-13 00:00:00',5,3),
 (17,1,8,'2009-06-13 00:00:00',5,1),
 (18,1,8,'2009-06-13 00:00:00',5,1),
 (19,1,9,'2009-06-13 00:00:00',5,1),
 (20,1,9,'2009-06-13 00:00:00',5,1),
 (21,1,9,'2009-06-13 00:00:00',5,1),
 (22,1,10,'2009-06-13 00:00:00',7,1),
 (23,1,10,'2009-06-13 00:00:00',7,1),
 (35,2,11,'2009-06-15 00:00:00',2,3),
 (36,2,11,'2009-06-15 00:00:00',2,1),
 (37,2,11,'2009-06-15 00:00:00',2,1),
 (38,2,12,'2009-06-15 00:00:00',2,3),
 (39,2,12,'2009-06-15 00:00:00',2,3),
 (40,2,12,'2009-06-15 00:00:00',2,3),
 (41,2,13,'2009-06-15 00:00:00',1,3),
 (42,2,13,'2009-06-15 00:00:00',1,3),
 (43,2,13,'2009-06-15 00:00:00',1,1),
 (44,2,14,'2009-06-15 00:00:00',1,1),
 (45,2,14,'2009-06-15 00:00:00',1,1),
 (46,2,14,'2009-06-15 00:00:00',1,1),
 (47,2,15,'2009-06-15 00:00:00',1,3),
 (48,2,15,'2009-06-15 00:00:00',1,3),
 (49,2,15,'2009-06-15 00:00:00',1,3),
 (50,2,16,'2009-06-15 00:00:00',3,3),
 (52,2,17,'2009-06-28 00:00:00',2,1),
 (53,1,18,'2009-06-28 00:00:00',1,1),
 (54,1,18,'2009-06-28 00:00:00',1,1),
 (55,1,19,'2009-06-28 00:00:00',7,1),
 (56,1,19,'2009-06-28 00:00:00',7,1),
 (57,1,19,'2009-06-28 00:00:00',7,1),
 (58,1,20,'2009-06-28 00:00:00',1,1),
 (59,1,20,'2009-06-28 00:00:00',1,1),
 (60,1,20,'2009-06-28 00:00:00',1,1),
 (61,1,21,'2009-06-01 00:00:00',7,1),
 (62,1,21,'2009-06-01 00:00:00',6,1),
 (63,1,21,'2009-06-01 00:00:00',7,1),
 (64,1,21,'2009-06-01 00:00:00',6,1),
 (65,1,22,'2009-06-19 00:00:00',5,1),
 (66,1,22,'2009-06-19 00:00:00',5,1),
 (67,1,22,'2009-06-19 00:00:00',5,1),
 (68,1,23,'2009-06-19 00:00:00',5,1),
 (69,1,23,'2009-06-19 00:00:00',5,1),
 (70,1,23,'2009-06-19 00:00:00',5,1),
 (71,1,24,'2009-06-20 00:00:00',6,1),
 (72,1,24,'2009-06-20 00:00:00',6,1),
 (73,1,26,'2009-06-20 00:00:00',6,1);
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
  `T_Detalle` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_Notificacion`)
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
 (6,'0000-00-00 00:00:00','159753465854');
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
  PRIMARY KEY (`ID_Reserva`) USING BTREE,
  KEY `FK_reserva_1` (`ID_Pago`),
  KEY `FK_reserva_2` (`ID_Usuario`),
  CONSTRAINT `FK_reserva_1` FOREIGN KEY (`ID_Pago`) REFERENCES `pago` (`ID_Pago`),
  CONSTRAINT `FK_reserva_2` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reserva`
--

/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` (`ID_Reserva`,`ID_Usuario`,`D_FechaReserva`,`ID_Pago`,`T_DetallesAdicionales`,`T_Estado`,`T_Ranking`) VALUES 
 (1,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (2,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (3,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (4,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (5,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (6,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (7,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (8,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (9,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (10,2,'2009-06-05 00:00:00',1,NULL,0,0),
 (11,2,'2009-06-12 00:00:00',2,NULL,0,0),
 (12,2,'2009-06-12 00:00:00',2,NULL,0,0),
 (13,2,'2009-06-12 00:00:00',2,NULL,0,0),
 (14,2,'2009-06-12 00:00:00',2,NULL,0,0),
 (15,2,'2009-06-12 00:00:00',2,NULL,0,0),
 (16,2,'2009-06-12 00:00:00',2,NULL,0,0),
 (17,2,'2009-06-12 00:00:00',2,NULL,1,0),
 (18,2,'2009-06-12 00:00:00',2,NULL,1,0),
 (19,3,'2009-06-19 00:00:00',5,NULL,0,0),
 (20,3,'2009-06-19 00:00:00',6,NULL,0,0),
 (21,3,'2009-06-19 00:00:00',NULL,NULL,0,0),
 (22,3,'2009-06-19 00:00:00',NULL,NULL,0,0),
 (23,3,'2009-06-19 00:00:00',NULL,'\".$adi_aux.\"',0,0),
 (24,3,'2009-06-19 00:00:00',NULL,NULL,0,0),
 (25,3,'2009-06-19 00:00:00',NULL,NULL,0,0),
 (26,3,'2009-06-19 00:00:00',NULL,'camisetas;',0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
 (6,'raquetas',1,2);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;


--
-- Definition of table `servicioxclub`
--

DROP TABLE IF EXISTS `servicioxclub`;
CREATE TABLE `servicioxclub` (
  `ID_Servicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Club` int(10) unsigned NOT NULL,
  `F_Recargo` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Servicio`,`ID_Club`),
  KEY `FK_servicioxclub_2` (`ID_Club`),
  CONSTRAINT `FK_servicioxclub_1` FOREIGN KEY (`ID_Servicio`) REFERENCES `servicio` (`ID_Servicio`),
  CONSTRAINT `FK_servicioxclub_2` FOREIGN KEY (`ID_Club`) REFERENCES `club` (`ID_Club`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicioxclub`
--

/*!40000 ALTER TABLE `servicioxclub` DISABLE KEYS */;
INSERT INTO `servicioxclub` (`ID_Servicio`,`ID_Club`,`F_Recargo`) VALUES 
 (2,1,1),
 (2,3,1),
 (4,1,1),
 (4,3,1),
 (6,1,1);
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
  `F_Estado` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Usuario`),
  KEY `FK_usuario_1` (`ID_Distrito`),
  CONSTRAINT `FK_usuario_1` FOREIGN KEY (`ID_Distrito`) REFERENCES `distrito` (`ID_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`ID_Usuario`,`N_Nombre`,`C_Telefono`,`D_FechaNacimiento`,`T_Imagen`,`ID_Distrito`,`T_Direccion`,`C_Puntos`,`T_Email`,`T_Pass`,`F_Estado`) VALUES 
 (1,'admin','923456789','1986-06-16 00:00:00',NULL,41,'JR. Las Avellanas',0,'a@a.com','a',1),
 (2,'Peluca','235235435','1986-05-28 00:00:00',NULL,34,'Calle siempre viva 123',0,'b@b.com','b',1),
 (3,'asd',NULL,'0000-00-00 00:00:00',NULL,12,NULL,0,'c@c.com','c',1),
 (4,'sdfsdf',NULL,'2000-05-16 00:00:00',NULL,26,NULL,0,'d@d.com','d',1),
 (5,'sdfsdf',NULL,'1981-11-25 00:00:00',NULL,29,NULL,0,'e@e.com','e',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
