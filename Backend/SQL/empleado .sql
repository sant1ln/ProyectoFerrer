-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-04-2020 a las 04:57:20
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ferrer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `Cargo` varchar(15) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Cedula` varchar(15) NOT NULL,
  `Celular` varchar(15) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `passwd` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `Cargo`, `Nombre`, `Cedula`, `Celular`, `Direccion`, `passwd`) VALUES
(1, 'Administrador', 'Santiago ', '106545443', '313 423 32 22', 'cll4532', '$2y$12$60BVqbPwCvLzK7OJCp.htOJ4kNZcH887G8hPAlmXV//jr5.XiKXp.'),
(6, 'Administrador', 'Estefania', '10034321', '321232', 'Caldaspapá', '$2y$12$gi6YvCEVeKYAfl1FGgbsKuj7eebwoYpHAr99ISWWUcOt/9VLRZvd6'),
(7, 'Cajero', 'Sara', '1003432', '321232', 'envigado', '$2y$12$KFuLE5BNadpsEBLtg33H5uwi/cM0NlRLlSE2SflYMIo2x0hvcQGuK'),
(8, 'Cajero', 'Jose Manuel', '10345431', '322 234 34 32', 'Cll 34 431', '$2y$12$KBlpkBuzWkP7buwQYt1x3eLKy9uN.dAThzTLVF.V6sYhAky7oNKi.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
