-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-05-2020 a las 06:25:28
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

---PEGA ESTO EN SQL.
ALTER TABLE `proveedor` ADD `creador` VARCHAR(30) NOT NULL AFTER `Ciudad_proveedor`;


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
(17, 'Administrador', 'Juan Manuel', '141', '31750220297', 'CL 107S SUR 50 99', '$2y$12$lYlPxSvJtLGZxjzFYVeO8eNT9FZYqXX5iVe937MFeI5bQ5J6pSNIy'),
(19, 'Administrador', 'Estefania', '212514', '325', 'CL 107S SUR 50 99', '$2y$12$dEr1PeuRPlawbpnDp1fueuaLFw50pb2DiZeOJ8caz6CgReIl6mWla'),
(20, 'Administrador', 'Santiago', '22', '22', 'CL 107S SUR 50 99', '$2y$12$Hmb69IolUJfEpQvrFN4f/.dYT.IGqHdq/7YfdmO8V67Pypn5Vqa3i');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas_de_producto`
--

CREATE TABLE `entradas_de_producto` (
  `Id_entrada_producto` int(100) UNSIGNED NOT NULL,
  `Cantidad_Producto` int(100) NOT NULL,
  `Id_Productoo` int(100) NOT NULL,
  `Cedula_Proveedor` bigint(200) UNSIGNED NOT NULL,
  `Nombre_Usuarioo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `entradas_de_producto`
--

INSERT INTO `entradas_de_producto` (`Id_entrada_producto`, `Cantidad_Producto`, `Id_Productoo`, `Cedula_Proveedor`, `Nombre_Usuarioo`) VALUES
(124, 2, 4, 21549425, 'Estefania'),
(126, 14, 4, 1026162599, 'Estefania');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Id_Producto` int(100) NOT NULL,
  `Nombre_Producto` varchar(25) NOT NULL,
  `Id_Tipo_Producto` varchar(50) NOT NULL,
  `Precio_Venta` int(11) NOT NULL,
  `Nombre_Usuario` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Id_Producto`, `Nombre_Producto`, `Id_Tipo_Producto`, `Precio_Venta`, `Nombre_Usuario`) VALUES
(4, 'estiercolld', 'Abonos', 2300, ' Estefania');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `Cedula_Proveedor` bigint(200) UNSIGNED NOT NULL,
  `Nombre_proveedor` varchar(20) NOT NULL,
  `Telefono_proveedor` bigint(200) NOT NULL,
  `Ciudad_proveedor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`Cedula_Proveedor`, `Nombre_proveedor`, `Telefono_proveedor`, `Ciudad_proveedor`) VALUES
(21549425, 'janneth', 3175022920, 'medellin'),
(1026162599, 'Estefania', 3004760587, 'CL 107S SUR 50 99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `Id_Tipo_Producto` varchar(50) NOT NULL,
  `Tipo_Producto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`Id_Tipo_Producto`, `Tipo_Producto`) VALUES
('Abonos', 'Abonos'),
('Cuidos', 'Cuidos'),
('Insecticida', 'Insecticida'),
('Semillas', 'Semillas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  ADD PRIMARY KEY (`Id_entrada_producto`),
  ADD KEY `Id_Producto` (`Id_Productoo`,`Cedula_Proveedor`),
  ADD KEY `fk_Entradas_proveedor` (`Cedula_Proveedor`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Id_Producto`),
  ADD UNIQUE KEY `Id_Producto` (`Id_Producto`),
  ADD KEY `Id_Tipo_Producto` (`Id_Tipo_Producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`Cedula_Proveedor`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`Id_Tipo_Producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  MODIFY `Id_entrada_producto` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  ADD CONSTRAINT `fk_Entradas_proveedor` FOREIGN KEY (`Cedula_Proveedor`) REFERENCES `proveedor` (`Cedula_Proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_productos` FOREIGN KEY (`Id_Productoo`) REFERENCES `producto` (`Id_Producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_tipoproducto` FOREIGN KEY (`Id_Tipo_Producto`) REFERENCES `tipo_producto` (`Id_Tipo_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
