-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-09-2025 a las 18:59:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `viventa_store`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `cod_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`cod_usuario`) VALUES
(4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cod_usuario` int(11) NOT NULL,
  `categoria_cliente` varchar(10) NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `token_confirmacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cod_usuario`, `categoria_cliente`, `confirmado`, `token_confirmacion`) VALUES
(8, 'Medium', 1, 'aabd3fdb35d9ab90bf819775da240f230a669b93dd0a68febaebd254b16aae5b'),
(9, 'Premium', 1, 'f26f75574c19a49934b0ba477a6fb19f051be945227e850cd052e29d64d6ae74'),
(10, 'Inicial', 1, ''),
(11, 'Inicial', 1, '6714ceecd268506f774db9734a552e3521bb3bb27f6d048dbf4ae9dd1e5bf1f1'),
(14, 'Inicial', 0, '078d898bf58e71a08726346f58a933b7e1c5f5a0a3c44170f710f43a1b2a20d2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueño_local`
--

CREATE TABLE `dueño_local` (
  `cod_usuario` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dueño_local`
--

INSERT INTO `dueño_local` (`cod_usuario`, `estado`) VALUES
(12, 'aprobado'),
(13, 'aprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `cod_local` int(11) NOT NULL,
  `nombre_local` varchar(100) NOT NULL,
  `ubicacion_local` varchar(50) NOT NULL,
  `rubro_local` varchar(20) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `foto_local` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`cod_local`, `nombre_local`, `ubicacion_local`, `rubro_local`, `cod_usuario`, `foto_local`) VALUES
(11, 'Nike', 'Ala A', 'Accesorios', 14, NULL),
(12, 'Nikes', 'Ala A', 'Accesorios', 14, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE `novedades` (
  `cod_novedad` int(11) NOT NULL,
  `texto_novedad` varchar(200) NOT NULL,
  `fecha_desde_novedad` date NOT NULL,
  `fecha_hasta_novedad` date NOT NULL,
  `foto_novedad` longtext DEFAULT NULL,
  `categoria_cliente` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novedades`
--

INSERT INTO `novedades` (`cod_novedad`, `texto_novedad`, `fecha_desde_novedad`, `fecha_hasta_novedad`, `foto_novedad`, `categoria_cliente`) VALUES
(36, 'hola', '2025-09-01', '2025-09-01', NULL, 'inicial'),
(37, 'hola', '2025-09-05', '2025-09-30', 'uploads/novedad_68c997337d309.png', 'inicial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `cod_promocion` int(11) NOT NULL,
  `texto_promocion` varchar(200) NOT NULL,
  `fecha_desde_promocion` date NOT NULL,
  `fecha_hasta_promocion` date NOT NULL,
  `categoria_cliente` varchar(10) NOT NULL,
  `estado_promo` varchar(10) NOT NULL,
  `cod_local` int(11) NOT NULL,
  `foto_promocion` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion_dia`
--

CREATE TABLE `promocion_dia` (
  `cod_promocion` int(11) NOT NULL,
  `cod_dia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `cod_solicitud` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `cod_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`cod_solicitud`, `fecha_solicitud`, `cod_usuario`) VALUES
(6001, '2025-06-01', 201),
(6002, '2025-06-05', 202),
(6003, '2025-06-10', 203),
(6004, '2025-07-01', 204),
(6005, '2025-07-12', 205);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_promociones`
--

CREATE TABLE `uso_promociones` (
  `fecha_uso_promocion` date NOT NULL,
  `estado` varchar(10) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_promocion` int(11) NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `cod_usuario` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `email`, `clave`, `nombre_usuario`) VALUES
(4, 'admin@shopping.com', '$2y$10$GN67du1fugiLmAQZ.j6qZ.2TImXOmYalJCiBRww6dVlZP048goeGO', 'admin'),
(8, 'matigdinero@gmail.com', '$2y$10$Xqo.Rzc0NaZvSzSiuyh55O7QWMo9cYhRlDL1NOZdXkkQeuzsd0fJi', 'Matias Fernando'),
(9, 'matiasgarcia1577@gmail.com', '$2y$10$6wmjZ0bpBsA2gsAbvnz8d.Wv6jV1X.0XYjPFBBrVx3QUXq1hyevwG', 'Matias Fernando'),
(10, 'mgarciamarianelli@gmail.com', '$2y$10$txHFNrekaXQ2IRVJz3TVo.UkLW8mGNd1/sESKILl/9Yt.3.I7yEyy', 'mati'),
(11, 'ramiromc04@gmail.com', '$2y$10$/VC2NsWk.7yRL/.AacFVjuPhjy28eX6Wf4HGwV6AVynyhd8b8hxpW', 'Ramiro'),
(12, 'ramiromc2do2da@gmail.com', '$2y$10$RuMxr5qh0cgdraONv6eR4uTa77TntpjUXq2ZdijtB4dFk5ju/5jta', 'Rami'),
(13, 'matiasgarcia1157@gmail.com', '$2y$10$el9bvYHj909GP26pKBpQbugoOEEdeaIPxSWMKgpA8d7iZ5ktA5.6S', 'matute'),
(14, 'lostutis1112@gmail.com', '$2y$10$j7cxsDpaqAVIyQEQ6VrDuOus.DdIqtTi2s5lhDxYCdq9NU1n4YayG', 'elias');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- Indices de la tabla `dueño_local`
--
ALTER TABLE `dueño_local`
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`cod_local`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `novedades`
--
ALTER TABLE `novedades`
  ADD PRIMARY KEY (`cod_novedad`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`cod_promocion`),
  ADD KEY `cod_local` (`cod_local`);

--
-- Indices de la tabla `promocion_dia`
--
ALTER TABLE `promocion_dia`
  ADD KEY `cod_promocion` (`cod_promocion`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`cod_solicitud`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  ADD PRIMARY KEY (`cod_usuario`,`cod_promocion`),
  ADD KEY `cod_promocion` (`cod_promocion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `cod_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `novedades`
--
ALTER TABLE `novedades`
  MODIFY `cod_novedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `cod_promocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `cod_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6006;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `dueño_local`
--
ALTER TABLE `dueño_local`
  ADD CONSTRAINT `dueño_local_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `locales`
--
ALTER TABLE `locales`
  ADD CONSTRAINT `locales_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`cod_local`) REFERENCES `locales` (`cod_local`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `promocion_dia`
--
ALTER TABLE `promocion_dia`
  ADD CONSTRAINT `promocion_dia_ibfk_1` FOREIGN KEY (`cod_promocion`) REFERENCES `promociones` (`cod_promocion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  ADD CONSTRAINT `uso_promociones_ibfk_1` FOREIGN KEY (`cod_promocion`) REFERENCES `promociones` (`cod_promocion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uso_promociones_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
