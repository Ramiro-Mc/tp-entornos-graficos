-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: viventa_store
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `cod_usuario` int(11) NOT NULL,
  KEY `cod_usuario` (`cod_usuario`),
  CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (4);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `cod_usuario` int(11) NOT NULL,
  `categoria_cliente` varchar(10) NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `token_confirmacion` varchar(255) NOT NULL,
  PRIMARY KEY (`cod_usuario`),
  CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (8,'Medium',1,'aabd3fdb35d9ab90bf819775da240f230a669b93dd0a68febaebd254b16aae5b'),(9,'Premium',1,'f26f75574c19a49934b0ba477a6fb19f051be945227e850cd052e29d64d6ae74'),(10,'Inicial',1,''),(11,'Inicial',1,'6714ceecd268506f774db9734a552e3521bb3bb27f6d048dbf4ae9dd1e5bf1f1');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dueño_local`
--

DROP TABLE IF EXISTS `dueño_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dueño_local` (
  `cod_usuario` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  KEY `cod_usuario` (`cod_usuario`),
  CONSTRAINT `dueño_local_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dueño_local`
--

LOCK TABLES `dueño_local` WRITE;
/*!40000 ALTER TABLE `dueño_local` DISABLE KEYS */;
INSERT INTO `dueño_local` VALUES (12,'aprobado'),(13,'aprobado');
/*!40000 ALTER TABLE `dueño_local` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locales`
--

DROP TABLE IF EXISTS `locales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locales` (
  `cod_local` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_local` varchar(100) NOT NULL,
  `ubicacion_local` varchar(50) NOT NULL,
  `rubro_local` varchar(20) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `foto_local` longtext NOT NULL,
  PRIMARY KEY (`cod_local`),
  KEY `cod_usuario` (`cod_usuario`),
  CONSTRAINT `locales_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locales`
--

LOCK TABLES `locales` WRITE;
/*!40000 ALTER TABLE `locales` DISABLE KEYS */;
/*!40000 ALTER TABLE `locales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `novedades`
--

DROP TABLE IF EXISTS `novedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `novedades` (
  `cod_novedad` int(11) NOT NULL AUTO_INCREMENT,
  `texto_novedad` varchar(200) NOT NULL,
  `fecha_desde_novedad` date NOT NULL,
  `fecha_hasta_novedad` date NOT NULL,
  `foto_novedad` longtext NOT NULL,
  `tipo_usuario` varchar(15) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  PRIMARY KEY (`cod_novedad`),
  KEY `cod_usuario` (`cod_usuario`),
  CONSTRAINT `novedades_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `novedades`
--

LOCK TABLES `novedades` WRITE;
/*!40000 ALTER TABLE `novedades` DISABLE KEYS */;
/*!40000 ALTER TABLE `novedades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocion_dia`
--

DROP TABLE IF EXISTS `promocion_dia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promocion_dia` (
  `cod_promocion` int(11) NOT NULL,
  `cod_dia` int(11) NOT NULL,
  KEY `cod_promocion` (`cod_promocion`),
  CONSTRAINT `promocion_dia_ibfk_1` FOREIGN KEY (`cod_promocion`) REFERENCES `promociones` (`cod_promocion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocion_dia`
--

LOCK TABLES `promocion_dia` WRITE;
/*!40000 ALTER TABLE `promocion_dia` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocion_dia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promociones`
--

DROP TABLE IF EXISTS `promociones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promociones` (
  `cod_promocion` int(11) NOT NULL AUTO_INCREMENT,
  `texto_promocion` varchar(200) NOT NULL,
  `fecha_desde_promocion` date NOT NULL,
  `fecha_hasta_promocion` date NOT NULL,
  `categoria_cliente` varchar(10) NOT NULL,
  `estado_promo` varchar(10) NOT NULL,
  `cod_local` int(11) NOT NULL,
  `foto_promocion` longtext NOT NULL,
  PRIMARY KEY (`cod_promocion`),
  KEY `cod_local` (`cod_local`),
  CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`cod_local`) REFERENCES `locales` (`cod_local`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promociones`
--

LOCK TABLES `promociones` WRITE;
/*!40000 ALTER TABLE `promociones` DISABLE KEYS */;
/*!40000 ALTER TABLE `promociones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uso_promociones`
--

DROP TABLE IF EXISTS `uso_promociones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uso_promociones` (
  `fecha_uso_promocion` date NOT NULL,
  `estado` varchar(10) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_promocion` int(11) NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cod_usuario`,`cod_promocion`),
  KEY `cod_promocion` (`cod_promocion`),
  CONSTRAINT `uso_promociones_ibfk_1` FOREIGN KEY (`cod_promocion`) REFERENCES `promociones` (`cod_promocion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `uso_promociones_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uso_promociones`
--

LOCK TABLES `uso_promociones` WRITE;
/*!40000 ALTER TABLE `uso_promociones` DISABLE KEYS */;
/*!40000 ALTER TABLE `uso_promociones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `cod_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (4,'admin@shopping.com','$2y$10$GN67du1fugiLmAQZ.j6qZ.2TImXOmYalJCiBRww6dVlZP048goeGO','admin'),(8,'matigdinero@gmail.com','$2y$10$Xqo.Rzc0NaZvSzSiuyh55O7QWMo9cYhRlDL1NOZdXkkQeuzsd0fJi','Matias Fernando'),(9,'matiasgarcia1577@gmail.com','$2y$10$6wmjZ0bpBsA2gsAbvnz8d.Wv6jV1X.0XYjPFBBrVx3QUXq1hyevwG','Matias Fernando'),(10,'mgarciamarianelli@gmail.com','$2y$10$txHFNrekaXQ2IRVJz3TVo.UkLW8mGNd1/sESKILl/9Yt.3.I7yEyy','mati'),(11,'ramiromc04@gmail.com','$2y$10$/VC2NsWk.7yRL/.AacFVjuPhjy28eX6Wf4HGwV6AVynyhd8b8hxpW','Ramiro'),(12,'ramiromc2do2da@gmail.com','$2y$10$RuMxr5qh0cgdraONv6eR4uTa77TntpjUXq2ZdijtB4dFk5ju/5jta','Rami'),(13,'matiasgarcia1157@gmail.com','$2y$10$el9bvYHj909GP26pKBpQbugoOEEdeaIPxSWMKgpA8d7iZ5ktA5.6S','matute');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-11 22:49:05
