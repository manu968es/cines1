-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-11-2012 a las 17:49:58
-- Versión del servidor: 5.1.44
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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

DROP TABLE IF EXISTS `usuarios`;
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
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `pass`, `estado`, `puntos`, `regentrada`, `regpalomitas`, `premios`) VALUES
('jiji', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 0, 0, 0, 0),
('lito', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 90, 1, 3, 4),
('lorena', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 30, 1, 2, 3),
('manuel', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 60, 13, 27, 40),
('mm', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 40, 0, 0, 0),
('vicent', '827ccb0eea8a706c4c34a16891f84e7b', 'A', 0, 0, 0, 0);
