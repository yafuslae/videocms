-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-10-2012 a las 14:35:43
-- Versión del servidor: 5.1.49
-- Versión de PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `videocms`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `apellido1` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `apellido2` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `fnacimiento` date NOT NULL,
  `dni` int(8) NOT NULL,
  `telefono` int(9) NOT NULL,
  `provincia` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `ciudad` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `calle` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `numero` int(4) NOT NULL,
  `puerta` int(3) NOT NULL,
  `escalera` int(2) DEFAULT NULL,
  `letra` varchar(1) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `contrasena` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `tipo_usuario` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `apellido1`, `apellido2`, `fnacimiento`, `dni`, `telefono`, `provincia`, `ciudad`, `calle`, `numero`, `puerta`, `escalera`, `letra`, `usuario`, `email`, `contrasena`, `id`, `tipo_usuario`) VALUES
('Daniel', 'Ruiz', 'Rengel', '1985-02-10', 48600517, 697265512, 'Valencia', 'Ontinyent', 'Agullent', 42, 0, NULL, NULL, 'admin', 'danielruizrengel@gmail.com', 'admin', 1, 'Admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
