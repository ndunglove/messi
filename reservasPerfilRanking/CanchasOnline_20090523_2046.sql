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
  `N_Nombre` varchar(45) NOT NULL,
  `ID_Privilegio` int(10) unsigned NOT NULL,
  `N_Usuario` varchar(50) NOT NULL,
  `T_Pass` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Administrador`),
  KEY `FK_administrador_1` (`ID_Privilegio`),
  CONSTRAINT `FK_administrador_1` FOREIGN KEY (`ID_Privilegio`) REFERENCES `privilegio` (`ID_Privilegio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
  `N_Nombre` varchar(45) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canchaxclub`
--

/*!40000 ALTER TABLE `canchaxclub` DISABLE KEYS */;
INSERT INTO `canchaxclub` (`ID_Cancha`,`ID_Club`) VALUES 
 (1,1),
 (1,2),
 (2,1),
 (2,2),
 (3,1),
 (4,1);
/*!40000 ALTER TABLE `canchaxclub` ENABLE KEYS */;


--
-- Definition of table `club`
--

DROP TABLE IF EXISTS `club`;
CREATE TABLE `club` (
  `ID_Club` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) NOT NULL,
  `ID_Distrito` int(10) unsigned NOT NULL,
  `T_Direccion` varchar(100) NOT NULL,
  `C_Telefono` varchar(10) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `N_Nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_Deporte`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
  `N_Nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distrito`
--

/*!40000 ALTER TABLE `distrito` DISABLE KEYS */;
INSERT INTO `distrito` (`ID_Distrito`,`N_Nombre`) VALUES 
 (1,'Cercado'),
 (2,'Ancon'),
 (3,'Ate'),
 (4,'Barranco'),
 (5,'Breña'),
 (6,'Carabayllo'),
 (7,'Comas'),
 (8,'Chaclacayo'),
 (9,'Chorrillos'),
 (10,'El Agustino'),
 (11,'Jesus Maria'),
 (12,'La Molina'),
 (13,'La Victoria'),
 (14,'Lince'),
 (15,'Lurigancho'),
 (16,'Lurin'),
 (17,'Magdalena'),
 (18,'Miraflores'),
 (19,'Pachacamac'),
 (20,'Pucusana'),
 (21,'Pueblo Libre'),
 (22,'Puente Piedra'),
 (23,'Punta Negra'),
 (24,'Punta Hermosa'),
 (25,'Rimac'),
 (26,'San Bartolo'),
 (27,'San Isidro'),
 (28,'Independencia'),
 (29,'San Juan De Miraflores'),
 (30,'San Luis'),
 (31,'San Martin De Porres'),
 (32,'San Miguel'),
 (33,'Santiago De Surco'),
 (34,'Surquillo'),
 (35,'Villa Maria Del Triunfo'),
 (36,'San Juan De Lurigancho'),
 (37,'Santa Maria Del Mar'),
 (38,'Santa Rosa'),
 (39,'Los Olivos'),
 (40,'Cieneguilla'),
 (41,'San Borja'),
 (42,'Villa El Salvador'),
 (43,'Santa Anita');
/*!40000 ALTER TABLE `distrito` ENABLE KEYS */;


--
-- Definition of table `ducha`
--

DROP TABLE IF EXISTS `ducha`;
CREATE TABLE `ducha` (
  `ID_Ducha` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `F_AguaCaliente` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Ducha`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hora`
--

/*!40000 ALTER TABLE `hora` DISABLE KEYS */;
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
  PRIMARY KEY (`ID_Hora`,`ID_Cancha`) USING BTREE,
  KEY `FK_horario_2` (`ID_Cancha`),
  KEY `FK_horario_3` (`ID_Reserva`),
  KEY `FK_horario_4` (`D_Fecha`) USING BTREE,
  CONSTRAINT `FK_horario_1` FOREIGN KEY (`ID_Hora`) REFERENCES `hora` (`ID_Hora`),
  CONSTRAINT `FK_horario_2` FOREIGN KEY (`ID_Cancha`) REFERENCES `cancha` (`ID_Cancha`),
  CONSTRAINT `FK_horario_3` FOREIGN KEY (`ID_Reserva`) REFERENCES `reserva` (`ID_Reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `horario`
--

/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;


--
-- Definition of table `kiosko`
--

DROP TABLE IF EXISTS `kiosko`;
CREATE TABLE `kiosko` (
  `ID_Kiosko` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `F_Chela` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Kiosko`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
  `T_Detalle` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_Notificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `C_Voucher` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_Pago`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pago`
--

/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;


--
-- Definition of table `privilegio`
--

DROP TABLE IF EXISTS `privilegio`;
CREATE TABLE `privilegio` (
  `ID_Privilegio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_Privilegio`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
  `T_DetallesAdicionales` varchar(200) DEFAULT NULL,
  `T_Estado` smallint(5) unsigned DEFAULT '0',
  `T_Ranking` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Reserva`) USING BTREE,
  KEY `FK_reserva_1` (`ID_Pago`),
  KEY `FK_reserva_2` (`ID_Usuario`),
  CONSTRAINT `FK_reserva_1` FOREIGN KEY (`ID_Pago`) REFERENCES `pago` (`ID_Pago`),
  CONSTRAINT `FK_reserva_2` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reserva`
--

/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;


--
-- Definition of table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
CREATE TABLE `servicio` (
  `ID_Servicio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_Nombre` varchar(45) NOT NULL,
  `F_Opcional` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ID_Deporte` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_Servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
  `N_Nombre` varchar(45) NOT NULL,
  `ID_Deporte` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_TamanoCancha`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
  `N_Tipo` varchar(45) NOT NULL,
  `ID_Deporte` varchar(45) NOT NULL,
  PRIMARY KEY (`ID_TipoCancha`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

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
  `N_Nombre` varchar(100) NOT NULL,
  `C_Telefono` varchar(12) NOT NULL,
  `D_FechaNacimiento` datetime NOT NULL,
  `T_Imagen` varchar(200) DEFAULT NULL,
  `ID_Distrito` int(10) unsigned NOT NULL,
  `T_Direccion` varchar(100) NOT NULL,
  `C_Puntos` int(10) unsigned NOT NULL,
  `T_Email` varchar(100) NOT NULL,
  `T_Pass` varchar(16) NOT NULL,
  `F_Estado` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`ID_Usuario`),
  KEY `FK_usuario_1` (`ID_Distrito`),
  CONSTRAINT `FK_usuario_1` FOREIGN KEY (`ID_Distrito`) REFERENCES `distrito` (`ID_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`ID_Usuario`,`N_Nombre`,`C_Telefono`,`D_FechaNacimiento`,`T_Imagen`,`ID_Distrito`,`T_Direccion`,`C_Puntos`,`T_Email`,`T_Pass`,`F_Estado`) VALUES 
 (1,'Peluca','923456789','1986-06-16 00:00:00',NULL,41,'JR. Las Avellanas',0,'a@a.com','a',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
