-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-11-2012 a las 17:35:47
-- Versión del servidor: 5.5.24
-- Versión de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gestcines`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'A',
  `puntos` int(11) NOT NULL DEFAULT '0',
  `regentrada` int(11) NOT NULL DEFAULT '0',
  `regpalomitas` int(11) NOT NULL DEFAULT '0',
  `premios` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `pass`, `estado`, `puntos`, `regentrada`, `regpalomitas`, `premios`) VALUES
('lito', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 0, 0, 0, 0),
('lorena', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 30, 1, 2, 3),
('manuel', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 10, 8, 16, 24),
('vicent', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
