-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2020 at 01:07 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (`cod_Producto` INT, `cantidad` INT, `token_user` VARCHAR(50))  BEGIN
 	DECLARE precio_actual decimal(10.0);
    SELECT Precio_Venta into precio_actual FROM producto where 	Id_Producto = cod_Producto;
    
    INSERT INTO detalle_temp(token_user,Id_Producto,cantidad,precio_venta) VALUES(token_user,cod_Producto,cantidad,precio_actual);
    
    SELECT tmp.correlativo, tmp.Id_Producto,p.Nombre_Producto,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
    INNER JOIN producto p
    ON tmp.Id_Producto = p.Id_Producto
    WHERE tmp.token_user = token_user;
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_detalle_temp` (IN `id_detalle` INT, IN `token` VARCHAR(50))  BEGIN
    
    	DELETE from detalle_temp WHERE Correlativo = id_detalle;
        
        SELECT tmp.Correlativo, tmp.Id_producto, p.Nombre_Producto, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp
        INNER JOIN producto p
        ON tmp.Id_Producto = p.Id_Producto
        WHERE tmp.token_user = token;
        
       END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `formapago` VARCHAR(50))  BEGIN
    	DECLARE factura int;
       
        DECLARE registros int;
        DECLARE total DECIMAL(10.2);
        
        DECLARE nueva_existencia int;
        DECLARE existencia_actual int;
        
        DECLARE tmp_cod_producto int;
        DECLARE tmp_cant_producto int;
        DECLARE a int;
        SET a = 1;
        
        create TEMPORARY TABLE tbl_tmp_tokenuser (
            id bigint not null AUTO_INCREMENT PRIMARY KEY,
            cod_prod int,
            cant_prod int);
            
         set registros = (SELECT COUNT(*) from detalle_temp where token_user = token);
         
         if registros > 0 THEN
         	
            INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT Id_Producto,cantidad FROM detalle_temp WHERE token_user = token;
            
            INSERT INTO factura(Empleado,Cod_cliente,forma_pago) VALUES(cod_usuario,cod_cliente,formapago);
            SET factura = LAST_INSERT_ID();
            
            INSERT INTO detalle_factura(No_factura,id_producto,cantidad,precio_venta) SELECT (factura) as nofactura, Id_producto,cantidad,precio_venta FROM detalle_temp
            WHERE token_user = token;
            
            WHILE a <= registros DO
            	
                SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
                SELECT Cantidad_Producto into existencia_actual FROM entradas_de_producto WHERE Id_Productoo = tmp_cod_producto;
                
                SET nueva_existencia = existencia_actual - tmp_cant_producto;
                UPDATE entradas_de_producto SET Cantidad_Producto = nueva_existencia WHERE Id_Productoo = tmp_cod_producto;
                
                SET a=a+1;
                
            
            END WHILE;
            
            SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
            UPDATE factura SET total_factura = total WHERE No_factura = factura;
            DELETE FROM detalle_temp WHERE token_user = token;
            TRUNCATE TABLE tbl_tmp_tokenuser;
            SELECT * FROM factura WHERE No_factura = factura;
                 
         ELSE
         
         	SELECT 0;
         
         END IF;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(50) NOT NULL,
  `cedula_cliente` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `cedula_cliente`, `nombre`, `telefono`, `direccion`) VALUES
(1, 1026162599, 'Estefania', 3023235138, 'calle 107 caldas'),
(2, 71334924, 'jaime', 30232547, 'calle 31 # 43-52 bello'),
(3, 474747, 'harold', 2457485, 'pedregal'),
(4, 7133, 'Estefania', 45, 'calle 107 caldas'),
(5, 21549425, 'janeth', 3175022920, 'girardota,antioquia'),
(6, 123, 'santiago', 3254756, 'sabaneta,antioquia'),
(7, 4578, 'Juan', 45987426, 'calle 28#23-34'),
(8, 89, 'ed', 455, 'medellin');

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `id_configuracion` bigint(20) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `direccion` text NOT NULL,
  `iva` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `nit`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `iva`) VALUES
(1, '100477856', 'Agropecuaria Ferer', '', 2981690, 'aferrer@gmail.com', 'medellin,antoquia', '19');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `Correlativo` bigint(11) NOT NULL,
  `No_factura` bigint(11) NOT NULL,
  `id_producto` int(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalle_factura`
--

INSERT INTO `detalle_factura` (`Correlativo`, `No_factura`, `id_producto`, `cantidad`, `precio_venta`) VALUES
(169, 195, 2, 1, '2300.00');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `Correlativo` int(100) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `Id_Producto` int(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `Direccion` varchar(50) NOT NULL,
  `passwd` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `Cargo`, `Nombre`, `Cedula`, `Celular`, `Direccion`, `passwd`) VALUES
(20, 'Administrador', 'Santiago', '22', '22', 'CL 107S SUR 50 99', '$2y$12$Hmb69IolUJfEpQvrFN4f/.dYT.IGqHdq/7YfdmO8V67Pypn5Vqa3i'),
(21, 'Cajero', 'isabell', '147', '3175022029', 'CL 107S SUR 50 99', '$2y$12$Gnp1ajMJ4Jy0MJ4EOPf6cud5F.MS9Rr6KOX1WIKwfry8D5zo/dTZy'),
(23, 'Administrador', 'Estefania', '214', '24', 'CL 107S SUR 50 99', '$2y$12$0e4xBYV74A4fA.p/vrpiNuF4nX2eV7MR0YYOmvUhF78cLD5aYKsfS');

-- --------------------------------------------------------

--
-- Table structure for table `entradas_de_producto`
--

CREATE TABLE `entradas_de_producto` (
  `Id_entrada_producto` int(100) UNSIGNED NOT NULL,
  `Cantidad_Producto` int(100) NOT NULL,
  `Id_Productoo` int(100) NOT NULL,
  `Cedula_Proveedor` bigint(200) UNSIGNED NOT NULL,
  `Nombre_Usuarioo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entradas_de_producto`
--

INSERT INTO `entradas_de_producto` (`Id_entrada_producto`, `Cantidad_Producto`, `Id_Productoo`, `Cedula_Proveedor`, `Nombre_Usuarioo`) VALUES
(4, 34, 3, 103, 'Estefania'),
(5, 61, 1, 103, 'Estefania'),
(7, 87, 5, 103, 'Estefania'),
(8, 86, 6, 103, 'Estefania'),
(10, 42, 4, 103, 'Estefania'),
(15, 57, 7, 103, 'Estefania'),
(16, 21, 10, 103, 'Santiago'),
(17, 211, 2, 103, 'Santiago'),
(18, 43, 11, 103, 'Santiago');

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `No_factura` bigint(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Empleado` int(11) NOT NULL,
  `Cod_cliente` int(50) NOT NULL,
  `total_factura` decimal(10,2) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `forma_pago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `factura`
--

INSERT INTO `factura` (`No_factura`, `Fecha`, `Empleado`, `Cod_cliente`, `total_factura`, `estado`, `forma_pago`) VALUES
(195, '2020-06-01 08:06:02', 23, 1, '2300.00', 1, 'Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `Id_Producto` int(100) NOT NULL,
  `Nombre_Producto` varchar(25) NOT NULL,
  `Id_Tipo_Producto` varchar(50) NOT NULL,
  `Precio_Venta` int(11) NOT NULL,
  `Nombre_Usuario` varchar(30) NOT NULL,
  `FechaCreacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`Id_Producto`, `Nombre_Producto`, `Id_Tipo_Producto`, `Precio_Venta`, `Nombre_Usuario`, `FechaCreacion`) VALUES
(1, 'girasol', 'Semillas', 8000, 'Estefania', '2020-05-31'),
(2, 'dw', 'Abonos', 2300, 'Santiago', '2020-06-01'),
(3, 'Pedigrieeee', 'Abonos', 12000, ' Estefania', '2020-06-01'),
(4, 'melasa', 'Cuidos', 7400, 'Estefania', '2020-05-31'),
(5, 'vaselina', 'Insecticida', 1200, 'Estefania', '2020-05-31'),
(6, 'vetenira', 'Insecticida', 2300, 'Estefania', '2020-05-31'),
(7, 'vaselina', 'Abonos', 2300, 'Estefania', '2020-06-01'),
(10, 'vaselina', 'Cuidos', 1200, 'Estefania', '2020-06-01'),
(11, 'spti', 'Cuidos', 2, 'Santiago', '2020-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `Cedula_Proveedor` bigint(200) UNSIGNED NOT NULL,
  `Nombre_proveedor` varchar(20) NOT NULL,
  `Telefono_proveedor` bigint(200) NOT NULL,
  `Ciudad_proveedor` varchar(20) NOT NULL,
  `creador` varchar(30) NOT NULL,
  `FechaCreacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`Cedula_Proveedor`, `Nombre_proveedor`, `Telefono_proveedor`, `Ciudad_proveedor`, `creador`, `FechaCreacion`) VALUES
(103, 'Andres', 111, '123', 'Santiago', '2020-05-30'),
(122, 'Santiago ', 0, '123', 'Santiago', '2020-05-30'),
(321, 'Jose Manuel', 0, 'Carrera 64 -16', 'Santiago', '2020-05-30'),
(123555, 'PurinaLatam', 300058789, 'Bogota', 'Estefania', '2020-01-16');

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
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indexes for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`Correlativo`),
  ADD KEY `No_factura` (`No_factura`,`id_producto`),
  ADD KEY `fk_id_producto` (`id_producto`);

--
-- Indexes for table `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`Correlativo`),
  ADD KEY `No_factura` (`Id_Producto`);

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
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`No_factura`),
  ADD KEY `Empleado` (`Empleado`,`Cod_cliente`),
  ADD KEY `fk_cliente` (`Cod_cliente`);

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
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_configuracion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `Correlativo` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `Correlativo` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  MODIFY `Id_entrada_producto` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `No_factura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`Id_Producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nofactura` FOREIGN KEY (`No_factura`) REFERENCES `factura` (`No_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`Id_Producto`);

--
-- Constraints for table `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  ADD CONSTRAINT `fk_Entradas_proveedor` FOREIGN KEY (`Cedula_Proveedor`) REFERENCES `proveedor` (`Cedula_Proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_productos` FOREIGN KEY (`Id_Productoo`) REFERENCES `producto` (`Id_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_EMPLEADO` FOREIGN KEY (`Empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`Cod_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_tipoproducto` FOREIGN KEY (`Id_Tipo_Producto`) REFERENCES `tipo_producto` (`Id_Tipo_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
