-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generaci�n: 23-02-2018 a las 20:10:01
-- Versi�n del servidor: 10.1.28-MariaDB
-- Versi�n de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

--
-- Base de datos: `eventos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf16_spanish2_ci NOT NULL,
  `subtitulo` varchar(255) COLLATE utf16_spanish2_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `cupos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `lugar` varchar(255) COLLATE utf16_spanish2_ci NOT NULL,
  `latitud` varchar(100) COLLATE utf16_spanish2_ci NOT NULL,
  `longitud` varchar(100) COLLATE utf16_spanish2_ci NOT NULL,
  `objetivo` text COLLATE utf16_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `subtitulo`, `precio`, `cupos`, `fecha`, `hora_inicio`, `hora_final`, `lugar`, `latitud`, `longitud`, `objetivo`) VALUES
(1, 'Educaci�n innovadora sin cambios', 'Evoluci�n constante sin precedentes', 30000, 300, '2018-02-28', '15:00:00', '19:00:00', 'coyancura 2283', '', '', 'Aliquam eu ipsum dolor. Proin convallis, ante non ullamcorper consequat, eros dolor pulvinar tellus, eu efficitur enim est ac felis. Praesent posuere dignissim quam, sit amet.                       ');

--
-- �ndices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
