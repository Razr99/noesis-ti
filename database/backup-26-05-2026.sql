-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: noesis_ti
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('Cliente') DEFAULT NULL,
  `password_hash` varchar(100) DEFAULT NULL,
  `puesto` varchar(50) DEFAULT NULL,
  `confirmado` tinyint DEFAULT NULL,
  `estatus_cuenta` enum('Activa','Inactiva') DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`),
  KEY `id_empresa_FK_idx` (`id_empresa`),
  CONSTRAINT `id_cliente_empresa_FK` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (5,2,'Ricardo Contreras','ricardo.contreras@example.com','8189856854','Cliente','','Ing. en Sistemas',0,'Inactiva','69fead190f159','2026-05-08 21:42:17'),(6,2,'Ricardo Contreras','ricardo.contreras1@example.com','1234567891','Cliente','','ricardo.contreras@example.com',0,'Inactiva','69feaff504564','2026-05-08 21:54:29'),(10,3,'Juán Pérez','example1234@example.com','1894354312','Cliente','$2y$10$PGtiGErzTTFuizAcJvqjoukkgpCTPf68ou75k3RJSRBlzcWGhAYpy','example123@example.com',1,'Activa','','2026-05-08 23:29:46'),(13,2,'Roberto Carlos','roberto.carlos@gmail.com','8159648745','Cliente','$2y$10$ieiKr8S.qzEy1MH/AhYB8eJIn7rveE6KJX3zfGnjMbTMneP.g4Kp6','Auxiliar en TI',1,'Activa','','2026-05-09 14:14:54'),(15,17,'Enrique Méndez','prueba.actualizar@gmail.com','8186543218','Cliente','','Ing. en Sistemas',0,'Activa','69ffc26e4d233','2026-05-09 17:25:34'),(16,6,'Ernesto Pérez','ernesto.perez@gmail.com','8195748562','Cliente','$2y$10$lFG91YhEpcPBBI2II8O5S.nX2W4gJAB68Z32YGpH30SiRq.BJfgaq','Ing. en Sistemas',1,'Activa','','2026-05-11 20:51:05'),(17,2,'Leonardo Alonso','leonardo.alonso@gmail.com','8148596235','Cliente','$2y$10$rgPNJaW1wLT4.lvkFjCe1.LDTJDX.osIQSp5IaDSRUvwonO7qtyaK','Ing. en Sistemas',1,'Activa','','2026-05-12 17:19:33'),(18,5,'Victor Robles','victor.robles@gmail.com','8194785265','Cliente','$2y$10$E4icjVa/ei05eh6PUUJdkO1EO6Z21HpfoZSRfmgs44G0s/qG3KWNu','Auxiliar de Sistemas',1,'Activa','','2026-05-18 22:48:59'),(19,4,'Francisco Ramírez','francisco.ramirez@gmail.com','8195685525','Cliente','$2y$10$dKo/Z1Rtpxqk1WHKNALNU.BUIpH8AacEABM9468TATMqt29Xl6rrC','Ing. Informático',1,'Activa','','2026-05-18 23:08:47'),(20,3,'Daniel Ontiveros','daniel.ontiveros@gmail.com','8485685112','Cliente','','Ing. en Sistemas',0,'Inactiva','6a0d02a0383af','2026-05-19 18:38:56');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_fiscal` varchar(100) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `representante_legal` varchar(100) NOT NULL,
  `estatus` enum('Activa','Inactiva','Suspendida') NOT NULL,
  `fecha_alta` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rfc` (`rfc`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (2,'Servicios Industriales Regiomontanos SA de CV','SIR920315KJ1','Av. Constitución 2500, Col. Obispado, Monterrey, NL','contacto@sir.com.mx','8183457788','Luis Fernando Garza Martínez','Activa','2024-01-15 09:30:00'),(3,'Tecnologías del Norte de México SA de CV','TNM850728GH4','Av. Eugenio Garza Sada 3820, Col. Contry, Monterrey, NL','ventas@tnm.com.mx','8122334455','María Guadalupe Villarreal López','Activa','2024-02-10 12:15:00'),(4,'Constructora Valle Oriente SA de CV','CVO990512RT8','Av. Lázaro Cárdenas 1000, Col. Valle Oriente, Monterrey, NL','info@cvo.com.mx','8188991122','José Alberto Hernández Salinas','Suspendida','2024-03-05 08:45:00'),(5,'Comercializadora Centro Monterrey SA de CV','CCM010920PL7','Calle Juárez 450, Centro, Monterrey, NL','atencion@ccm.com.mx','8181223344','Ana Sofía Rodríguez Cantú','Inactiva','2023-11-20 10:00:00'),(6,'Logística y Transporte Santa Catarina SA de CV','LTS870403MN9','Carretera a Saltillo Km 10, Col. La Fama, Santa Catarina, NL','operaciones@lts.com.mx','8187654321','Ricardo Iván Salazar Treviño','Activa','2024-04-01 07:20:00'),(9,'Prueba 1','TNM850728GH3','Av. Eloy Cavazos','raul231199@gmail.com','8168161651','ROBERTO CARLOS','Activa','2026-04-28 00:30:24'),(11,' Prueba 23','XAXX010101000','Av Eloy Cavazos','prueba@prueba.com','8149785866','PEDRO FERNANDEZ','Activa','2026-05-03 15:25:11'),(15,' Prueba_Jagc','JAGC270705NE2','Sierra de la Soledad ','DeisyFlores456@gmail.com','8184637131','Deisy Flores ','Activa','2026-05-05 17:33:35'),(16,' PRUEBA-1.1','JAGC270705NE3','FDJFNFHJGFJGFNJGFJNGF BGFJJGFNJGF ','HOLA@GMAIL.COM','8786541335','Segundo Pertez ','Activa','2026-05-05 17:45:19'),(17,' Eliminar Póliza','XAXX010101004','Crear Póliza y eliminar empresa','pruebas123@gmail.com','8100085953','PRUEBA ','Inactiva','2026-05-09 14:16:56'),(19,' Construrama SA de CV','XAXX010101005','Eloy Cavazos #4100, Tolteca, Guadalupe, Nuevo León','consturama@gmail.com','8159648745','Ing. Carlos Saucedo','Activa','2026-05-11 18:40:38');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `tipo_equipo` enum('Desktop','Laptop','Impresoras','Router','Switch','Servidores','Firewall','Cámaras CCTV','Grabadores DVR/NVR','Telefonía') DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `nombre_equipo` varchar(50) DEFAULT NULL,
  `procesador` varchar(45) DEFAULT NULL,
  `frecuencia_procesador` varchar(45) DEFAULT NULL,
  `sistema_operativo` varchar(45) DEFAULT NULL,
  `ram` varchar(45) DEFAULT NULL,
  `almacenamiento` varchar(45) DEFAULT NULL,
  `tipo_almacenamiento` enum('HDD','SSD','NVMe M.2','N/A') DEFAULT NULL,
  `ruta_imagen` varchar(100) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `estatus` enum('Excelente','Bueno','Regular','Dañado','Baja') DEFAULT NULL,
  `detalles` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `num_serie` (`numero_serie`),
  KEY `id_empresa_FK` (`id_empresa`),
  CONSTRAINT `id_empresa_FK` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES (1,2,'Desktop','HP','Pro SFF 400 G9','MXL789854L','TI','Intel Core i7 14700K','3.5 GHz','Windows 11','32 GB','1 TB','NVMe M.2','486b304ee02753d9665b91cd8395fe2d.jpg','2026-05-11 14:46:34','Excelente','Equipo manchado de maquillaje'),(4,2,'Desktop','HP','Pro SFF 400 G9','MXL789854M','TI','Intel Core i7 14700K','3.5 GHz','Windows 11','32 GB','1 TB','NVMe M.2','desktop.png','2026-05-11 14:55:15','Excelente','Sin detalles'),(6,19,'Laptop','Asus','Vivobook','876YU8L','Equipo de Contabilidad','Intel Core i5 13400','2.5 GHz','Windows 11','16 GB','512 GB','SSD','47afe90769958e363f97666d2cbc85bb.jpg','2026-05-11 18:50:43','Excelente','Daño en la display'),(9,6,'Desktop','HP','Pro SFF 400 G9','MXL785DFT9','RH','Intel Core i5 225H','2.5 GHz','Windows 11','32 GB','1 TB','SSD','046bbd6eaebf778f13b688df69f1370f.jpg','2026-05-11 21:05:20','Excelente',''),(10,2,'Impresoras','Brother','MFC-J6940DW','ED785848UTP','Impresora de Recepción','N/A','N/A','N/A','N/A','N/A','N/A','79836df9088c7fab992477c83c544f00.jpg','2026-05-12 17:38:15','Bueno','Daños y ruidos en el sistema ADF'),(11,2,'Desktop','Dell','OptiPlex 7090','SN-DELL-001A','PC-Contabilidad-01','Intel Core i5-11400','2.60 GHz','Windows 11 Pro','16 GB','512 GB','SSD','desktop.png','2026-05-15 14:11:27','Excelente','Equipo asignado al área de contabilidad.'),(12,2,'Laptop','HP','ProBook 450 G8','SN-HP-002B','LAP-Gerencia-01','Intel Core i7-1165G7','2.80 GHz','Windows 10 Pro','16 GB','1 TB','SSD','laptop.png','2026-05-11 14:11:27','Bueno','Laptop de uso administrativo para gerencia.'),(13,2,'Router','TP-Link','Archer AX50','SN-TPLINK-003C','RTR-Oficina-01','N/A','N/A','N/A','N/A','N/A','N/A','router.png','2026-05-08 14:11:27','Excelente','Router principal de la oficina.'),(14,2,'Switch','Cisco','SG350-28','SN-CISCO-004D','SW-Principal-01','N/A','N/A','N/A','N/A','N/A','N/A','switch.png','2026-05-04 14:11:27','Regular','Switch principal con algunos puertos presentan fallas intermitentes.'),(15,2,'Impresoras','Brother','HL-L2350DW','SN-BRO-005E','IMP-Recepcion-01','N/A','N/A','N/A','N/A','N/A','N/A','impresora.png','2026-05-13 14:11:27','Bueno','Impresora asignada a recepción para documentos generales.'),(16,5,'Desktop','Dell','OptiPlex 7010 Tower','DELL-DSK-99214A','DESK-DEV-01','Intel Core i7-13700','2.10 GHz u00e1s 5.20 GHz','Windows 11 Pro','32 GB DDR5','1 TB','NVMe M.2','desktop.png','2026-05-18 22:57:04','Excelente','Equipo de escritorio asignado al área de desarrollo. Cuenta con gráficos integrados Intel UHD 770.'),(17,5,'Laptop','Lenovo','ThinkPad X1 Carbon Gen 11','LEN-LAP-88312B','LAP-GERENCIA-01','Intel Core i5-1335U','1.30 GHz u00e1s 4.60 GHz','Windows 11 Pro','16 GB LPDDR5','512 GB','NVMe M.2','laptop.png','2026-05-18 22:57:04','Excelente','Laptop corporativa ultraportu00e1til para uso gerencial. Incluye teclado retroiluminado y lector de huellas.'),(18,5,'Laptop','HP','ProBook 445 G10','HP-LAP-55412C','LAP-ADMIN-03','AMD Ryzen 5 7530U','2.00 GHz u00e1s 4.50 GHz','Windows 10 Pro','8 GB DDR4','512 GB','SSD','laptop.png','2026-05-18 22:57:04','Bueno','Equipo portu00e1til utilizado por el personal administrativo para tareas de oficina y contabilidad.'),(19,3,'Laptop','Asus','ROG Zephyrus G14','ASUS-ROG-77219B','LAP-DISENO-01','AMD Ryzen 7 7735HS','3.20 GHz a 4.75 GHz','Windows 11 Pro','16 GB DDR5','1 TB','NVMe M.2','laptop.png','2026-05-18 23:26:40','Excelente','Equipo asignado al departamento de diseño gráfico y contenido. Cuenta con tarjeta dedicada NVIDIA RTX 4050.'),(20,3,'Desktop','HP','Pro Tower 290 G9','HP-DT-66512Z','DESK-RECEPCION','Intel Core i3-12100','3.30 GHz a 4.30 GHz','Windows 10 Pro','8 GB DDR4','512 GB','SSD','desktop.png','2026-05-18 23:26:40','Bueno','Equipo de escritorio base para atención en recepción. Utilizado principalmente para paquetería de oficina y correo.'),(21,3,'Laptop','Dell','Latitude 3440','DELL-LAT-11023X','LAP-VENTAS-02','Intel Core i5-1335U','1.30 GHz a 4.60 GHz','Windows 11 Pro','16 GB DDR4','512 GB','NVMe M.2','laptop.png','2026-05-18 23:26:40','Excelente','Laptop asignada al ejecutivo de ventas para visitas foráneas. Excelente rendimiento de batería.');
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidad`
--

DROP TABLE IF EXISTS `especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_especialidad` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (1,'Soporte Técnico de Escritorio (Helpdesk)'),(2,'Técnico de Soporte de Impresión'),(3,'Técnico de Conectividad y Redes'),(4,'Administrador de Sistemas (SysAdmin)'),(5,'Especialista en Seguridad Electrónica'),(6,'Técnico en Telecomunicaciones'),(7,'Administrador de Noesis TI'),(8,'Almacenista');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poliza`
--

DROP TABLE IF EXISTS `poliza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poliza` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `numero_poliza` varchar(45) NOT NULL,
  `tipo_plan` enum('Básico','Estándar','Premium') NOT NULL,
  `costo` decimal(12,2) NOT NULL,
  `monto_cobertura` decimal(12,2) NOT NULL,
  `poliza_pdf` varchar(255) NOT NULL,
  `periodo` enum('Mensual','Bimestral','Trimestral','Tetramestral','Semestral','Anual') DEFAULT NULL,
  `estatus` enum('Vigente','Finalizada','Cancelada') NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_empresa_FK_idx` (`id_empresa`),
  CONSTRAINT `id_poliza_empresa_FK` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poliza`
--

LOCK TABLES `poliza` WRITE;
/*!40000 ALTER TABLE `poliza` DISABLE KEYS */;
INSERT INTO `poliza` VALUES (1,2,'159','Básico',500.00,50000.00,'deb10b9626861850d030f8286a92785e.pdf','Mensual','Vigente','2026-05-05','2026-06-05'),(5,16,'-8','Premium',500.00,499985.00,'4897763171ffb7ecfa432fae16585799.pdf','Anual','Vigente','2026-05-05','2027-05-05'),(6,9,'15951','Básico',500.01,50000.99,'7fb4e8bfe77c89738d928efed714aef4.pdf','Mensual','Vigente','2026-05-05','2026-06-05'),(7,11,'159851','Básico',500.00,50000.00,'3b747dfa4ff3d491935dca34bf631bda.pdf','Bimestral','Cancelada','2026-05-11','2026-07-11'),(8,3,'8979587905','Estándar',986070988.00,9283598235.00,'ce5d87cfbd0d49cb6905494c020fbf95.pdf','Mensual','Vigente','2026-05-07','2026-06-09'),(9,17,'8165131513','Premium',10000.00,1000000.00,'b79c717e429f3398c9a4ece25ff620d5.pdf','Anual','Cancelada','2026-05-09','2027-05-11'),(13,19,'159852','Básico',499.00,50000.00,'d7a574ae79d126d74b6f968f71a5de4a.pdf','Anual','Vigente','2026-05-11','2027-05-11'),(14,6,'8684351483','Básico',500.00,50000.00,'5b521a57c5eb38ad7d90b55242461634.pdf','Anual','Vigente','2026-05-11','2027-05-11');
/*!40000 ALTER TABLE `poliza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `Id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `stock_actual` int DEFAULT '0',
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte`
--

DROP TABLE IF EXISTS `reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporte` (
  `Id_reporte` int NOT NULL AUTO_INCREMENT,
  `Id_ticket` int DEFAULT NULL,
  `diagnostico_final` varchar(255) DEFAULT NULL,
  `actividades_realizadas` varchar(255) DEFAULT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  `horas_trabajadas` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`Id_reporte`),
  UNIQUE KEY `Id_ticket` (`Id_ticket`),
  CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`Id_ticket`) REFERENCES `ticket` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte_materiales`
--

DROP TABLE IF EXISTS `reporte_materiales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporte_materiales` (
  `Id_reporte_mat` int NOT NULL AUTO_INCREMENT,
  `Id_reporte` int DEFAULT NULL,
  `Id_producto` int DEFAULT NULL,
  `cantidad_usada` int DEFAULT NULL,
  PRIMARY KEY (`Id_reporte_mat`),
  KEY `Id_reporte` (`Id_reporte`),
  KEY `Id_producto` (`Id_producto`),
  CONSTRAINT `reporte_materiales_ibfk_1` FOREIGN KEY (`Id_reporte`) REFERENCES `reporte` (`Id_reporte`),
  CONSTRAINT `reporte_materiales_ibfk_2` FOREIGN KEY (`Id_producto`) REFERENCES `producto` (`Id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte_materiales`
--

LOCK TABLES `reporte_materiales` WRITE;
/*!40000 ALTER TABLE `reporte_materiales` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte_materiales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_trabajador` int DEFAULT NULL,
  `id_equipo` int DEFAULT NULL,
  `id_empresa` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `numero_ticket` varchar(45) DEFAULT NULL,
  `prioridad` enum('Baja','Media','Alta','Crítica') DEFAULT 'Baja',
  `estatus` enum('Abierto','En Proceso','Cerrado','Cancelado') DEFAULT 'Abierto',
  `descripcion` varchar(255) DEFAULT NULL,
  `ruta_evidencia` varchar(100) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_empresa_FK_idx` (`id_empresa`),
  KEY `id_ticket_cliente_FK` (`id_cliente`),
  KEY `id_ticket_trabajador_FK` (`id_trabajador`),
  KEY `id_ticket_equipo_FK` (`id_equipo`),
  KEY `id_ticket_categoria_FK_idx` (`id_categoria`),
  CONSTRAINT `id_ticket_categoria_FK` FOREIGN KEY (`id_categoria`) REFERENCES `ticket_categoria` (`id`),
  CONSTRAINT `id_ticket_cliente_FK` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  CONSTRAINT `id_ticket_empresa_FK` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`),
  CONSTRAINT `id_ticket_equipo_FK` FOREIGN KEY (`id_equipo`) REFERENCES `equipo` (`id`),
  CONSTRAINT `id_ticket_trabajador_FK` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (1,10,NULL,19,3,1,'INC-20260519-1','Alta','Abierto','La pantalla después de encender el equipo, 10 minutos y se pone en azul','a2e7c8664d28531707820760104b5633.jpg','2026-05-19 10:28:15',NULL,NULL),(2,10,NULL,21,3,4,'SYS-20260519-1','Baja','Abierto','No tengo acceso a internet','fdc882908f7a33b6d934805c8c41b1ce.jpg','2026-05-19 10:33:02',NULL,NULL),(3,16,NULL,9,6,5,'CCTV-20260519-1','Media','Abierto','Se programa instalación de Office para las 5:00 P.M.','','2026-05-19 17:55:02',NULL,NULL),(4,10,NULL,19,3,5,'CCTV-20260519-2','Crítica','Abierto','Adobe Ilustrator','aee31923a182bc994718d04e00979e66.jpg','2026-05-19 18:58:10',NULL,NULL),(5,17,42,10,2,11,'TCK-20260519-1','Crítica','En Proceso','Al director General se le atora muy constante las hojas al imprimir desde MAC','2deea22e0f21a0498da9c47f36e7aef9.jpg','2026-05-19 19:13:43',NULL,NULL),(6,17,NULL,1,2,2,'IMP-20260520-1','Alta','Abierto','Me salen muchos anuncios en el navegador','','2026-05-20 17:53:40',NULL,NULL),(8,17,42,1,2,1,'INC-20260520-1','Media','En Proceso','PRUEBA 123456789101112','b00379f5e8546256df01227c7439b083.jpg','2026-05-20 19:57:42','2026-05-25 18:48:43',NULL),(9,17,NULL,1,2,2,'IMP-20260520-2','Crítica','Cancelado','PRUEBAS DEL 1 AL 3','e1421378d443889b24f797dffe4386ad.jpg','2026-05-20 22:18:13','2026-05-20 22:40:17','2026-05-20 22:40:17');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_categoria`
--

DROP TABLE IF EXISTS `ticket_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_especialidad` int DEFAULT NULL,
  `categoria_ticket` varchar(100) DEFAULT NULL,
  `tipo_equipo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_especialidad_FK_idx` (`id_especialidad`),
  CONSTRAINT `id_especialidad_FK` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_categoria`
--

LOCK TABLES `ticket_categoria` WRITE;
/*!40000 ALTER TABLE `ticket_categoria` DISABLE KEYS */;
INSERT INTO `ticket_categoria` VALUES (1,1,'PC no enciende / Pantalla Azul','Desktop / Laptop'),(2,1,'Lentitud / Virus o Malware','Desktop / Laptop'),(3,1,'Fallo de Hardware (RAM, SSD)','Desktop / Laptop'),(4,1,'Problemas de Wi-Fi / Internet','Desktop / Laptop'),(5,1,'Instalación de software','Desktop / Laptop'),(6,1,'Configuración de perfiles','Desktop / Laptop'),(7,1,'Asignación de equipo nuevo','Desktop / Laptop'),(8,1,'Montaje de puesto de trabajo','Desktop / Laptop'),(9,1,'Mantenimiento físico de equipo','Desktop / Laptop'),(10,1,'Depuración de sistema y actualizaciones','Desktop / Laptop'),(11,2,'Atasco de papel constante','Impresoras'),(12,2,'Impresión borrosa / sin tóner','Impresoras'),(13,2,'Impresora fuera de línea','Impresoras'),(14,2,'Configurar impresora en red','Impresoras'),(15,2,'Reemplazo de consumibles','Impresoras'),(16,2,'Instalación y direccionamiento IP de nuevo equipo','Impresoras'),(17,2,'Limpieza de rodillos y calibración de cabezales','Impresoras'),(18,3,'Caída de Internet / Enlace','Router / Switch / Firewall'),(19,3,'Saturación o lentitud en LAN','Router / Switch / Firewall'),(20,3,'Puerto de switch dañado','Router / Switch / Firewall'),(21,3,'Apertura de puertos / Reglas','Router / Switch / Firewall'),(22,3,'Creación de VLANs / VPN','Router / Switch / Firewall'),(23,3,'Reserva de IPs (DHCP)','Router / Switch / Firewall'),(24,3,'Montaje en rack y peinado de cableado de red','Router / Switch / Firewall'),(25,3,'Respaldo de archivos de configuración','Router / Switch / Firewall'),(26,4,'Servidor inaccesible / Caído','Administrador de Sistemas (SysAdmin)'),(27,4,'Arreglo RAID degradado','Administrador de Sistemas (SysAdmin)'),(28,4,'Almacenamiento lleno','Administrador de Sistemas (SysAdmin)'),(29,4,'Creación de carpetas y permisos','Administrador de Sistemas (SysAdmin)'),(30,4,'Crear Máquinas Virtuales','Administrador de Sistemas (SysAdmin)'),(31,4,'Restauración de backups','Administrador de Sistemas (SysAdmin)'),(32,4,'Montaje de servidor físico','Administrador de Sistemas (SysAdmin)'),(33,4,'Instalación de SO (Windows Server/Linux)','Administrador de Sistemas (SysAdmin)'),(34,4,'Monitoreo de backups diarios','Administrador de Sistemas (SysAdmin)'),(35,4,'Aplicación de parches de seguridad','Administrador de Sistemas (SysAdmin)'),(36,5,'Canal en negro / Sin video','Especialista en Seguridad Electrónica'),(37,5,'Fallo de visión nocturna','Especialista en Seguridad Electrónica'),(38,5,'El grabador no almacena datos','Especialista en Seguridad Electrónica'),(39,5,'Extracción de clips de video','Especialista en Seguridad Electrónica'),(40,5,'Ajuste de ángulo o enfoque','Especialista en Seguridad Electrónica'),(41,5,'Cableado (UTP/Coaxial) y montaje de cámaras','Especialista en Seguridad Electrónica'),(42,5,'Configuración inicial del DVR/NVR','Especialista en Seguridad Electrónica'),(43,5,'Limpieza de lentes y domos','Especialista en Seguridad Electrónica'),(44,5,'Revisión de fuentes de poder y voltajes','Especialista en Seguridad Electrónica'),(45,6,'Teléfono sin tono / muerto','Técnico en Telecomunicaciones'),(46,6,'Audio entrecortado o estática','Técnico en Telecomunicaciones'),(47,6,'No entran/salen llamadas','Técnico en Telecomunicaciones'),(48,6,'Creación de nueva extensión','Técnico en Telecomunicaciones'),(49,6,'Configuración de desvíos / IVR','Técnico en Telecomunicaciones'),(50,6,'Asignación y ponchado de nodo de voz','Técnico en Telecomunicaciones'),(51,6,'Revisión de logs de la PBX','Técnico en Telecomunicaciones'),(52,6,'Sanitización física de aparatos','Técnico en Telecomunicaciones');
/*!40000 ALTER TABLE `ticket_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_seguimiento`
--

DROP TABLE IF EXISTS `ticket_seguimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_seguimiento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_ticket` int DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_trabajador` int DEFAULT NULL,
  `atiende` varchar(100) DEFAULT NULL,
  `descripcion` longtext,
  `estatus` varchar(45) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ticket_FK_idx` (`id_ticket`),
  KEY `id_trabajador_FK_idx` (`id_trabajador`),
  KEY `id_cliente_FK_idx` (`id_cliente`),
  CONSTRAINT `id_cliente_FK` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  CONSTRAINT `id_ticket_FK` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`),
  CONSTRAINT `id_trabajador_FK` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_seguimiento`
--

LOCK TABLES `ticket_seguimiento` WRITE;
/*!40000 ALTER TABLE `ticket_seguimiento` DISABLE KEYS */;
INSERT INTO `ticket_seguimiento` VALUES (1,9,17,NULL,'Leonardo Alonso','El cliente ha cancelado el ticket','Cancelado','2026-05-20 22:40:17'),(3,8,17,42,' Karina Segundo','El Técnico  Karina Segundo ha tomado el ticket.','En Proceso','2026-05-25 18:48:43');
/*!40000 ALTER TABLE `ticket_seguimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajador`
--

DROP TABLE IF EXISTS `trabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trabajador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `num_empleado` varchar(10) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('Administrador','Técnico','Almacenista') NOT NULL,
  `especialidad` enum('Soporte Técnico de Escritorio (Helpdesk)','Técnico de Soporte de Impresión','Técnico de Conectividad y Redes','Administrador de Sistemas (SysAdmin)','Especialista en Seguridad Electrónica','Técnico en Telecomunicaciones','Administrador de Noesis TI','Almacenista') DEFAULT NULL,
  `estatus` enum('Disponible','En Sitio','Vacaciones','No Disponible') DEFAULT 'Disponible',
  `password_hash` varchar(100) DEFAULT NULL,
  `confirmado` tinyint DEFAULT NULL,
  `estatus_cuenta` enum('Activa','Inactiva') DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajador`
--

LOCK TABLES `trabajador` WRITE;
/*!40000 ALTER TABLE `trabajador` DISABLE KEYS */;
INSERT INTO `trabajador` VALUES (1,'Juán Pérez','juan.perez@noesis.com.mx','53897','8163256982','Técnico','Soporte Técnico de Escritorio (Helpdesk)','Disponible','$2y$10$DSo432aVb/4gmksHHBID/uI8JpOarewitLIbxpwc04RiY11YZob96',1,'Activa',NULL,'2026-04-12 15:30:00'),(2,'Pedro Fernández','pedro.fernandez@noesis.com.mx','53898','8145678952','Administrador','Administrador de Noesis TI','Disponible','$2y$10$DSo432aVb/4gmksHHBID/uI8JpOarewitLIbxpwc04RiY11YZob96',1,'Activa',NULL,'2026-04-12 15:30:00'),(21,'Joquín Pérez','joaquin.perez@noesis.com.mx','84978','8189856854','Técnico','Técnico de Soporte de Impresión','Vacaciones','$2y$10$DSo432aVb/4gmksHHBID/uI8JpOarewitLIbxpwc04RiY11YZob96',1,'Activa',NULL,'2026-04-16 17:28:35'),(27,'Joquín Pérez','joaquin.perez1@noesis.com.mx','84978','8189856854','Técnico','Técnico de Conectividad y Redes','En Sitio','$2y$10$DSo432aVb/4gmksHHBID/uI8JpOarewitLIbxpwc04RiY11YZob96',1,'Activa','','2026-04-16 21:07:08'),(28,'Joquín Pérez','joaquin.perez2@noesis.com.mx','84978','8189856854','Técnico','Administrador de Sistemas (SysAdmin)','No Disponible','$2y$10$DSo432aVb/4gmksHHBID/uI8JpOarewitLIbxpwc04RiY11YZob96',1,'Activa','','2026-04-16 21:07:08'),(29,'Joquín Pérez','joaquin.perez3@noesis.com.mx','84978','8189856854','Técnico','Especialista en Seguridad Electrónica','Disponible','$2y$10$DSo432aVb/4gmksHHBID/uI8JpOarewitLIbxpwc04RiY11YZob96',1,'Activa','','2026-04-16 21:07:08'),(42,' Karina Segundo','karina.seg10@gmail.com','5310','8195865852','Técnico','Técnico en Telecomunicaciones','Disponible','$2y$10$vjJTDbXc8iStPKBb13Pa8OgG6jxmzbwOWUkBwHkw5xeWSurWFINf6',1,'Activa','','2026-04-17 18:59:18'),(43,' Pablo Gutiérritos','pablo.gutierritos@gmail.com','12345','8179854685','Técnico','Soporte Técnico de Escritorio (Helpdesk)','Disponible','$2y$10$5CWd6i4PyMUJ0KvYdf3YGeETDzBlYxTA1EH1/kOynyKEhCv2u/VJq',1,'Activa','','2026-04-22 17:36:24'),(44,' Prueba uno','prueba@prueba.com','1856451','1864163513','Almacenista','Almacenista','Disponible','$2y$10$nSA72f4n19BXe9segOu8qODFNN/nsBfEAyfNTovKHpJJR.4aUEjsm',1,'Activa','','2026-05-08 00:26:04');
/*!40000 ALTER TABLE `trabajador` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-26 19:46:35
