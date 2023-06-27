-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2023 a las 00:51:13
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `nombre_documento` varchar(250) DEFAULT NULL,
  `titulo_documento` varchar(250) DEFAULT NULL,
  `descriptcion_documento` text DEFAULT NULL,
  `ubicacion_documento` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_procesos`
--

CREATE TABLE `doc_procesos` (
  `id_proceso` bigint(20) DEFAULT NULL,
  `id_documentos` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE `procesos` (
  `id` bigint(20) NOT NULL,
  `objeto` varchar(250) DEFAULT NULL,
  `nombre_responsable` varchar(250) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `moneda` enum('COD','USD','EUR','') DEFAULT NULL,
  `presupuesto` decimal(10,0) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `actividades_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `procesos`
--

INSERT INTO `procesos` (`id`, `objeto`, `nombre_responsable`, `descripcion`, `moneda`, `presupuesto`, `estado`, `fecha_inicio`, `hora_inicio`, `fecha_fin`, `hora_fin`, `actividades_id`) VALUES
(9, 'SDsd', 'Aldaoir', 'ssda', 'USD', '1212', 'Y', '2023-07-07', '17:03:00', '2023-06-23', '17:03:00', 2),
(11, '121', 'asa', '1asa', 'USD', '1212', 'Y', '2023-06-25', '18:32:00', '2023-06-21', '17:32:00', 2),
(12, '121', 'asa', '1asa', 'USD', '1212', 'Y', '2023-06-25', '18:32:00', '2023-06-21', '17:32:00', 2),
(13, 'SDsd', 'Aldaoir', 'ssda ', 'USD', '1212', 'Y', '2023-07-07', '17:03:00', '2023-06-23', '17:03:00', 2),
(14, 'SDsd', 'Aldaoir', 'ssda ', 'USD', '1212', 'Y', '2023-07-07', '17:03:00', '2023-06-23', '17:03:00', 2),
(15, 'SDsd', 'Aldaoir', 'ssda ', 'USD', '1212', 'Y', '2023-07-07', '17:03:00', '2023-06-23', '17:03:00', 2);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procesos`
--
ALTER TABLE `procesos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
