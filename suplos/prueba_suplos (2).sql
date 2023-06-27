-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2023 a las 06:50:06
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_suplos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` bigint(20) NOT NULL,
  `codigo_segmento` varchar(250) DEFAULT NULL,
  `nombre_segmento` varchar(500) DEFAULT NULL,
  `codigo_familia` varchar(250) DEFAULT NULL,
  `nombre_familia` varchar(250) DEFAULT NULL,
  `codigo_clase` varchar(250) DEFAULT NULL,
  `nombre_clase` varchar(250) DEFAULT NULL,
  `codigo_productos` varchar(500) DEFAULT NULL,
  `nombre_productos` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `codigo_segmento`, `nombre_segmento`, `codigo_familia`, `nombre_familia`, `codigo_clase`, `nombre_clase`, `codigo_productos`, `nombre_productos`) VALUES
(2, '50\r\n', 'Alimentos, Bebidas y Tabaco \r\n', '5042\r\n', 'Vegetales secos\r\n', '504252\r\n', 'Cebollas Secas\r\n', '50425211\r\n', 'Cebolla baron rojo seca\r\n'),
(3, '53\r\n', 'Ropa, Maletas y Productos de Aseo Personal\r\n', '5310\r\n', 'Ropa\r\n', '531027\r\n', 'Uniformes\r\n', '53102715\r\n', 'Uniformes de oficiales de cárceles\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint(20) NOT NULL,
  `titulo_documento` varchar(250) DEFAULT NULL,
  `descriptcion_documento` text DEFAULT NULL,
  `nombre_documento` varchar(250) DEFAULT NULL,
  `ubicacion_documento` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `titulo_documento`, `descriptcion_documento`, `nombre_documento`, `ubicacion_documento`) VALUES
(14, 'as', 'asas', '043103Prueba de desarrollo FullStack 2023_Suplos_V2.pdf', './public/archivos/043103Prueba de desarrollo FullStack 2023_Suplos_V2.pdf'),
(15, 'sads', 'sdsd', '044651Prueba de desarrollo FullStack 2023_Suplos_V2.pdf', './public/archivos/044651Prueba de desarrollo FullStack 2023_Suplos_V2.pdf'),
(16, 'asa', 'asas', '051004usuario_controlador.php', './public/archivos/051004usuario_controlador.php'),
(17, 'TITULO 1', 'asas', '061624Prueba de desarrollo FullStack 2023_Suplos_V2.pdf', './public/archivos/061624Prueba de desarrollo FullStack 2023_Suplos_V2.pdf'),
(18, 'q', 'dfdf', '062357Prueba de desarrollo FullStack 2023_Suplos_V2.pdf', './public/archivos/062357Prueba de desarrollo FullStack 2023_Suplos_V2.pdf'),
(19, 'sdsa', 'sadsa', '062739Prueba de desarrollo FullStack 2023_Suplos_V2.pdf', './public/archivos/062739Prueba de desarrollo FullStack 2023_Suplos_V2.pdf'),
(20, 'sdsd', 'sdsa', '062807prueba_suplos.sql', './public/archivos/062807prueba_suplos.sql'),
(21, 'asas', 'asas', '062815clasificador_de_bienes_y_servicios_v14_1.xls.crdownload', './public/archivos/062815clasificador_de_bienes_y_servicios_v14_1.xls.crdownload'),
(22, 'xcxzc', 'xcxc', '062954Prueba de desarrollo FullStack 2023_Suplos_V2.pdf', './public/archivos/062954Prueba de desarrollo FullStack 2023_Suplos_V2.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_procesos`
--

CREATE TABLE `doc_procesos` (
  `id` bigint(20) NOT NULL,
  `id_proceso` bigint(20) DEFAULT NULL,
  `id_documentos` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `doc_procesos`
--

INSERT INTO `doc_procesos` (`id`, `id_proceso`, `id_documentos`) VALUES
(9, 9, 14),
(10, 9, 15),
(11, 16, 16),
(12, 16, 17),
(13, 25, 18),
(14, 25, 19),
(15, 25, 20),
(16, 25, 21),
(17, 25, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE `procesos` (
  `id` bigint(20) NOT NULL,
  `objeto` varchar(250) DEFAULT NULL,
  `nombre_responsable` varchar(250) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `moneda` enum('COP','USD','EUR','') DEFAULT NULL,
  `presupuesto` decimal(10,0) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `actividades_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `procesos`
--

INSERT INTO `procesos` (`id`, `objeto`, `nombre_responsable`, `descripcion`, `moneda`, `presupuesto`, `estado`, `fecha_inicio`, `hora_inicio`, `fecha_fin`, `hora_fin`, `actividades_id`) VALUES
(9, 'SDsd', 'Aldaoir', 'sdsd', 'EUR', '1212', 'Y', '2023-07-07', '17:03:00', '2023-06-23', '17:03:00', 3),
(16, 'ssds', 'Aldaoirsdsd', 'sds', 'COP', '121', 'Y', '0000-00-00', '21:03:00', '2023-06-30', '09:02:00', 2),
(25, 'SDsd', 'sad', 'sadas', 'USD', '121', 'Y', '0001-12-12', '00:12:00', '0012-12-12', '22:55:00', 2),
(30, 'objetivo', '1', '2', 'USD', '2', 'Y', '2023-06-26', '23:38:00', '2023-06-26', '23:38:00', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doc_procesos`
--
ALTER TABLE `doc_procesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_documentos` (`id_documentos`),
  ADD KEY `id_proceso` (`id_proceso`);

--
-- Indices de la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actividades_id` (`actividades_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `doc_procesos`
--
ALTER TABLE `doc_procesos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `procesos`
--
ALTER TABLE `procesos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `doc_procesos`
--
ALTER TABLE `doc_procesos`
  ADD CONSTRAINT `doc_procesos_ibfk_1` FOREIGN KEY (`id_documentos`) REFERENCES `documentos` (`id`),
  ADD CONSTRAINT `doc_procesos_ibfk_2` FOREIGN KEY (`id_proceso`) REFERENCES `procesos` (`id`);

--
-- Filtros para la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD CONSTRAINT `procesos_ibfk_1` FOREIGN KEY (`actividades_id`) REFERENCES `actividades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
