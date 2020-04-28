-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2020 at 03:50 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ferrer`
--

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `Cargo` varchar(15) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Cedula` varchar(15) NOT NULL,
  `Celular` varchar(15) NOT NULL,
  `Direccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `Cargo`, `Nombre`, `Cedula`, `Celular`, `Direccion`) VALUES
(14, 'Administrador', 'Estefania', '56', '5658', 'CL 107S SUR 50 99');

-- --------------------------------------------------------

--
-- Table structure for table `entradas_de_producto`
--

CREATE TABLE `entradas_de_producto` (
  `Id_entrada_producto` int(100) UNSIGNED NOT NULL,
  `Cantidad_Producto` int(100) NOT NULL,
  `Id_Productoo` int(100) NOT NULL,
  `Cedula_Proveedor` bigint(200) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entradas_de_producto`
--

INSERT INTO `entradas_de_producto` (`Id_entrada_producto`, `Cantidad_Producto`, `Id_Productoo`, `Cedula_Proveedor`) VALUES
(12, 1, 1, 21549425);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `Id_Producto` int(100) NOT NULL,
  `Nombre_Producto` varchar(25) NOT NULL,
  `Id_Tipo_Producto` varchar(50) NOT NULL,
  `Precio_Venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`Id_Producto`, `Nombre_Producto`, `Id_Tipo_Producto`, `Precio_Venta`) VALUES
(1, 'estiercol5', 'Insecticida', 2300),
(2, 'estefania', 'Cuidos', 12004),
(4, 'vetenira', 'Insecticida', 8000),
(7, 'estiercol', 'Cuidos', 8000),
(15, 'estiercol', 'Cuidos', 2300),
(44, 'estiercol', 'Cuidos', 8000),
(56, 'estiercol', 'Cuidos', 2300),
(255, 'estiercol', 'Insecticida', 8000);

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `Cedula_Proveedor` bigint(200) UNSIGNED NOT NULL,
  `Nombre_proveedor` varchar(20) NOT NULL,
  `Telefono_proveedor` bigint(200) NOT NULL,
  `Ciudad_proveedor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`Cedula_Proveedor`, `Nombre_proveedor`, `Telefono_proveedor`, `Ciudad_proveedor`) VALUES
(21549425, 'janneth', 3175022920, 'medellin');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `Id_Tipo_Producto` varchar(50) NOT NULL,
  `Tipo_Producto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_producto`
--

INSERT INTO `tipo_producto` (`Id_Tipo_Producto`, `Tipo_Producto`) VALUES
('Abonos', 'Abonos'),
('Cuidos', 'Cuidos'),
('Insecticida', 'Insecticida'),
('Semillas', 'Semillas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indexes for table `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  ADD PRIMARY KEY (`Id_entrada_producto`),
  ADD KEY `Id_Producto` (`Id_Productoo`,`Cedula_Proveedor`),
  ADD KEY `fk_Entradas_proveedor` (`Cedula_Proveedor`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Id_Producto`),
  ADD UNIQUE KEY `Id_Producto` (`Id_Producto`),
  ADD KEY `Id_Tipo_Producto` (`Id_Tipo_Producto`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`Cedula_Proveedor`);

--
-- Indexes for table `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`Id_Tipo_Producto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  MODIFY `Id_entrada_producto` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  ADD CONSTRAINT `fk_Entradas_proveedor` FOREIGN KEY (`Cedula_Proveedor`) REFERENCES `proveedor` (`Cedula_Proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_productos` FOREIGN KEY (`Id_Productoo`) REFERENCES `producto` (`Id_Producto`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_tipoproducto` FOREIGN KEY (`Id_Tipo_Producto`) REFERENCES `tipo_producto` (`Id_Tipo_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
