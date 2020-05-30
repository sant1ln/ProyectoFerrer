-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-05-2020 a las 23:28:58
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

DELIMITER $$
--
-- Procedimientos
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))  BEGIN
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
            
            INSERT INTO factura(Empleado,Cod_cliente) VALUES(cod_usuario,cod_cliente);
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
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(50) NOT NULL,
  `cedula_cliente` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
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
-- Estructura de tabla para la tabla `configuracion`
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
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `nit`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `iva`) VALUES
(1, '100477856', 'Agropecuaria Ferer', '', 2981690, 'aferrer@gmail.com', 'medellin,antoquia', '19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `Correlativo` bigint(11) NOT NULL,
  `No_factura` bigint(11) NOT NULL,
  `id_producto` int(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
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
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `Cargo` varchar(15) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Cedula` varchar(15) NOT NULL,
  `Celular` varchar(15) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `passwd` varchar(60) NOT NULL,
  `FechaCreacion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `Cargo`, `Nombre`, `Cedula`, `Celular`, `Direccion`, `passwd`, `FechaCreacion`) VALUES
(19, 'Administrador', 'Estefania', '212514', '325', 'CL 107S SUR 50 99', '$2y$12$dEr1PeuRPlawbpnDp1fueuaLFw50pb2DiZeOJ8caz6CgReIl6mWla', 0),
(20, 'Administrador', 'Santiago', '22', '22', 'CL 107S SUR 50 99', '$2y$12$Hmb69IolUJfEpQvrFN4f/.dYT.IGqHdq/7YfdmO8V67Pypn5Vqa3i', 0),
(21, 'Cajero', 'isabel', '147', '3175022029', 'CL 107S SUR 50 99', '$2y$12$303ffkFNj2UsK0IkRVzJleDI5VBN0BDOLYWA2w.O/DsEbI2v7Ub9m', 0);

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
(1, 123, 2, 122, 'Santiago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `No_factura` bigint(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Empleado` int(11) NOT NULL,
  `Cod_cliente` int(50) NOT NULL,
  `total_factura` decimal(10,2) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`No_factura`, `Fecha`, `Empleado`, `Cod_cliente`, `total_factura`, `estado`) VALUES
(1, '2020-05-25 17:57:35', 20, 1, '8000.00', 1),
(2, '2020-05-25 20:24:12', 20, 1, '34300.00', 1),
(3, '2020-05-25 20:25:40', 20, 1, '8000.00', 1),
(4, '2020-05-25 20:30:55', 20, 1, NULL, 1),
(5, '2020-05-25 20:31:00', 20, 1, NULL, 1),
(6, '2020-05-25 20:32:43', 20, 1, '9200.00', 1),
(7, '2020-05-25 20:33:27', 20, 1, '8000.00', 1),
(8, '2020-05-25 20:33:56', 20, 1, '173550.00', 1),
(9, '2020-05-25 20:37:46', 20, 1, '53640.00', 1),
(10, '2020-05-25 22:49:02', 20, 1, '34300.00', 1),
(11, '2020-05-25 22:52:01', 20, 1, '6900.00', 1),
(12, '2020-05-25 23:18:48', 19, 1, '8000.00', 1),
(13, '2020-05-25 23:24:17', 20, 1, '8000.00', 1),
(14, '2020-05-25 23:26:14', 20, 1, '8000.00', 1),
(15, '2020-05-25 23:27:41', 20, 1, '8000.00', 1),
(16, '2020-05-25 23:28:52', 20, 1, '16000.00', 1),
(17, '2020-05-25 23:29:22', 20, 1, '8000.00', 1),
(18, '2020-05-25 23:29:39', 20, 1, '8000.00', 1),
(19, '2020-05-25 23:30:28', 20, 1, '26300.00', 1),
(20, '2020-05-25 23:32:52', 20, 1, '1200.00', 1),
(21, '2020-05-25 23:36:01', 20, 1, '1200.00', 1),
(22, '2020-05-25 23:36:33', 20, 1, '8000.00', 1),
(23, '2020-05-25 23:37:14', 20, 1, '8000.00', 1),
(24, '2020-05-25 23:37:24', 20, 1, '8000.00', 1),
(25, '2020-05-25 23:37:55', 20, 1, '8000.00', 1),
(26, '2020-05-25 23:38:53', 20, 1, '16000.00', 1),
(27, '2020-05-25 23:40:04', 20, 1, '8000.00', 1),
(28, '2020-05-25 23:40:43', 20, 1, '8000.00', 1),
(29, '2020-05-25 23:41:07', 20, 1, '8000.00', 1),
(30, '2020-05-25 23:41:47', 20, 1, '8000.00', 1),
(31, '2020-05-25 23:56:23', 20, 1, '8000.00', 1),
(32, '2020-05-25 23:56:49', 20, 1, '8000.00', 1),
(33, '2020-05-26 00:01:04', 20, 1, '8000.00', 1),
(34, '2020-05-26 00:02:16', 20, 1, '8000.00', 1),
(35, '2020-05-26 00:05:51', 20, 1, '8000.00', 1),
(36, '2020-05-26 00:06:36', 20, 1, '8000.00', 1),
(37, '2020-05-26 00:07:26', 20, 1, '8000.00', 1),
(38, '2020-05-26 00:07:49', 20, 1, '8000.00', 1),
(39, '2020-05-26 00:08:18', 20, 1, '8000.00', 1),
(40, '2020-05-26 00:08:37', 20, 1, '8000.00', 1),
(41, '2020-05-26 00:08:48', 20, 1, '8000.00', 1),
(42, '2020-05-26 00:10:33', 20, 1, '8000.00', 1),
(43, '2020-05-26 00:11:47', 20, 1, '10300.00', 1),
(44, '2020-05-26 00:12:23', 20, 1, '8000.00', 1),
(45, '2020-05-26 00:16:27', 20, 1, '8000.00', 1),
(46, '2020-05-26 00:17:11', 20, 1, '1200.00', 1),
(47, '2020-05-26 00:18:25', 20, 1, '1200.00', 1),
(48, '2020-05-26 00:18:38', 20, 1, '8000.00', 1),
(49, '2020-05-26 00:20:12', 20, 1, '8000.00', 1),
(50, '2020-05-26 00:21:29', 20, 1, '8000.00', 1),
(51, '2020-05-26 00:21:53', 20, 1, '8000.00', 1),
(52, '2020-05-26 00:24:36', 20, 1, '8000.00', 1),
(53, '2020-05-26 00:25:47', 20, 1, '8000.00', 1),
(54, '2020-05-26 00:26:36', 20, 1, '8000.00', 1),
(55, '2020-05-26 00:31:37', 20, 1, '8000.00', 1),
(56, '2020-05-26 00:33:44', 20, 1, '8000.00', 1),
(57, '2020-05-26 00:34:49', 20, 1, '2300.00', 1),
(58, '2020-05-26 00:35:53', 20, 1, '8000.00', 1),
(59, '2020-05-26 00:38:01', 20, 1, '69200.00', 1),
(60, '2020-05-26 00:44:05', 20, 1, '13200.00', 1),
(61, '2020-05-26 00:45:36', 20, 1, '24100.00', 1),
(62, '2020-05-26 00:46:40', 20, 1, '2300.00', 1),
(63, '2020-05-26 00:49:28', 20, 1, '8000.00', 1),
(64, '2020-05-26 00:50:16', 20, 1, '8000.00', 1),
(65, '2020-05-26 01:37:22', 20, 1, '56000.00', 1),
(66, '2020-05-26 01:38:21', 20, 3, NULL, 1),
(67, '2020-05-26 01:38:37', 20, 3, NULL, 1),
(68, '2020-05-26 01:39:04', 20, 3, NULL, 1),
(69, '2020-05-26 01:39:27', 20, 3, '1200.00', 1),
(70, '2020-05-26 01:40:21', 20, 3, '116100.00', 1),
(71, '2020-05-26 01:44:19', 20, 6, '25650.00', 1),
(72, '2020-05-26 01:49:04', 21, 6, '293100.00', 1),
(73, '2020-05-26 01:51:27', 21, 7, '1200.00', 1),
(74, '2020-05-26 17:17:21', 19, 1, '230000.00', 1),
(75, '2020-05-26 17:23:09', 19, 1, '12800.00', 1),
(76, '2020-05-26 17:41:18', 19, 1, '8000.00', 1),
(77, '2020-05-30 16:28:58', 20, 6, '5000.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
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
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Id_Producto`, `Nombre_Producto`, `Id_Tipo_Producto`, `Precio_Venta`, `Nombre_Usuario`, `FechaCreacion`) VALUES
(2, 'Luzes', 'Abonos', 123, 'Santiago', '2020-05-30'),
(3, 'Pedigrie', 'Abonos', 12000, 'Santiago', '2020-05-30'),
(4, 'Electricable', 'Abonos', 3, 'Santiago', '2020-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
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
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`Cedula_Proveedor`, `Nombre_proveedor`, `Telefono_proveedor`, `Ciudad_proveedor`, `creador`, `FechaCreacion`) VALUES
(103, 'Andres', 111, '123', 'Santiago', '2020-05-30'),
(122, 'Santiago ', 0, '123', 'Santiago', '2020-05-30'),
(321, 'Jose Manuel', 0, 'Carrera 64 -16', 'Santiago', '2020-05-30'),
(123555, 'PurinaLatam', 300058789, 'Bogota', 'Estefania', '2020-01-16');

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
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`Correlativo`),
  ADD KEY `No_factura` (`No_factura`,`id_producto`),
  ADD KEY `fk_id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`Correlativo`),
  ADD KEY `No_factura` (`Id_Producto`);

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
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`No_factura`),
  ADD KEY `Empleado` (`Empleado`,`Cod_cliente`),
  ADD KEY `fk_cliente` (`Cod_cliente`);

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
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_configuracion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `Correlativo` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `Correlativo` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  MODIFY `Id_entrada_producto` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `No_factura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`Id_Producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nofactura` FOREIGN KEY (`No_factura`) REFERENCES `factura` (`No_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`Id_Producto`);

--
-- Filtros para la tabla `entradas_de_producto`
--
ALTER TABLE `entradas_de_producto`
  ADD CONSTRAINT `fk_Entradas_proveedor` FOREIGN KEY (`Cedula_Proveedor`) REFERENCES `proveedor` (`Cedula_Proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_productos` FOREIGN KEY (`Id_Productoo`) REFERENCES `producto` (`Id_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_EMPLEADO` FOREIGN KEY (`Empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`Cod_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_tipoproducto` FOREIGN KEY (`Id_Tipo_Producto`) REFERENCES `tipo_producto` (`Id_Tipo_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
