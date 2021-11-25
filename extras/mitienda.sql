-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2021 a las 17:37:17
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mitienda`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarclienteuser` (IN `nombre` TEXT, IN `documento` TEXT, IN `ruc` TEXT, IN `email` TEXT, IN `telefono` TEXT, IN `direccion` TEXT, IN `clave` TEXT, IN `fecha` TEXT, IN `modo` TEXT, IN `tipocliente` TEXT)  INSERT INTO clientes (nombre,documento,ruc,email,telefono,direccion,clave,fecha,modo,tipocliente)   
VALUES(nombre,documento,ruc,email,telefono,direccion,clave,fecha,modo,tipocliente)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregardeseo` (IN `email` TEXT, IN `id_producto` TEXT, IN `precio` TEXT)  INSERT INTO deseos (email,id_producto,precio)       
VALUES (email,id_producto,precio)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarpedido` (IN `estado` TEXT, IN `metodo` TEXT, IN `email` TEXT, IN `direccion` TEXT, IN `productos` TEXT, IN `pago` TEXT)  INSERT INTO pedidos (estado,metodo,email,direccion,productos,pago)       
VALUES (estado,metodo,email,direccion,productos,pago)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarproducto` (IN `vari` TEXT)  select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta 
FROM productos p WHERE p.ruta like CONCAT('%', vari , '%') OR p.titulo like CONCAT('%', vari , '%')  OR p.titular like CONCAT('%', vari , '%')  OR p.descripcion like CONCAT('%', vari , '%') ORDER BY p.precio ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarproductodesc` (IN `vari` TEXT)  NO SQL
select p.id, p.portada,p.titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta 
FROM productos p WHERE p.ruta like CONCAT('%', vari , '%') OR p.titulo like CONCAT('%', vari , '%')  OR p.titular like CONCAT('%', vari , '%')  OR p.descripcion like CONCAT('%', vari , '%') ORDER BY p.precio DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Cambiarclave` (IN `mail` TEXT, IN `nclave` TEXT)  UPDATE clientes c
SET c.clave = nclave
WHERE c.email=mail$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cancelarpedido` (IN `cod` TEXT)  UPDATE pedidos p
SET p.estado = '3'
WHERE p.id=cod$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminardeseo` (IN `cod` TEXT, IN `mail` TEXT)  DELETE FROM deseos
WHERE deseos.id_producto=cod and deseos.email=mail$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ingresarcliente` (IN `mail` TEXT, IN `clave` TEXT)  SELECT c.nombre,c.documento,c.ruc,c.email,c.telefono,c.direccion,c.clave,c.fecha,c.modo,c.tipocliente from clientes c WHERE c.email=mail and c.clave=clave$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListaProductosxoferta` ()  select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta
FROM productos p where p.oferta=1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListaProductosxprecio` (IN `vari` TEXT)  IF vari="ASC" THEN
select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta FROM productos p 
ORDER BY p.precio ASC;
ELSE
select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta FROM productos p
ORDER BY p.precio DESC;
END IF$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListDeseo` (IN `vari` TEXT)  SELECT d.id,d.email,p.portada,p.descripcion as titulo,p.precio as precioac, d.id_producto,d.precio,d.fecha from deseos d inner join productos p on d.id_producto=p.id WHERE d.email=vari$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListDetalle` ()  SELECT		a.productos
	FROM		ventas a
	ORDER BY	id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listpedidos` (IN `vari` TEXT)  SELECT p.id,p.estado,p.metodo,p.email,p.direccion,p.productos,p.pago  from pedidos p WHERE p.email=vari$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListProductos` ()  select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta  FROM productos p$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ListarAlumno` (`id` INT)  select p.id, p.portada,p.titulo,p.precio 
FROM productos p where p.id=id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ListarCategorias` ()  SELECT	cat.id,	cat.categoria, cat.ruta FROM categorias cat
	ORDER BY	cat.categoria ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ListarProductoCategorias` (IN `vari` TEXT)  select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta
FROM productos p INNER JOIN categorias cat on p.id_categoria=cat.id
where cat.categoria=vari ORDER by p.precio ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ListarProductoCategoriasdesc` (IN `vari` TEXT)  NO SQL
select p.id, p.portada,p.descripcion as titulo,p.precio,p.oferta,p.precioOferta as precioferta,p.descuentoOferta as descuentoferta
FROM productos p INNER JOIN categorias cat on p.id_categoria=cat.id
where cat.categoria=vari ORDER by p.precio DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ultimopedido` ()  SELECT p.id,p.estado,p.metodo,p.email,p.direccion,p.productos,p.pago  from pedidos p ORDER by ID DESC LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verificar` (IN `mail` TEXT)  SELECT c.nombre,c.documento,c.ruc,c.email,c.telefono,c.direccion,c.clave,c.fecha,c.modo,c.tipocliente from clientes c WHERE c.email=mail$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombre`, `email`, `foto`, `password`, `perfil`, `estado`, `fecha`) VALUES
(1, 'admin', 'admin@gmail.com', 'vistas/img/perfiles/499.png', '$2a$07$asxx54ahjppf45sd87a5aunxs9bkpyGmGE/.vekdjFg83yRec789S', 'Administrador', 1, '2020-08-12 08:59:02'),
(3, 'Juan Gallo', 'juan@gmail.com', '', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Vendedor', 1, '2021-02-04 23:29:18'),
(4, 'john', 'john@gmail.com', '', '$2a$07$asxx54ahjppf45sd87a5aupzkPdLwyitSSyL6466yvrStV04YUkGi', 'Administrador', 1, '2020-08-10 08:44:08'),
(6, 'david', 'david@gmail.com', '', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Administrador', 1, '2021-02-08 11:04:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cabeceras`
--

CREATE TABLE `cabeceras` (
  `id` int(11) NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `palabrasClaves` text COLLATE utf8_spanish_ci NOT NULL,
  `portada` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cabeceras`
--

INSERT INTO `cabeceras` (`id`, `ruta`, `titulo`, `descripcion`, `palabrasClaves`, `portada`, `fecha`) VALUES
(1, 'inicio', 'Perutecsols', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam accusantium enim esse eos officiis sit officia', 'Lorem ipsum, dolor sit amet, consectetur, adipisicing, elit, Quisquam, accusantium, enim, esse', 'vistas/img/cabeceras/default.jpg', '2020-08-14 01:09:37'),
(2, 'desarrollo-web', 'Desarrollo Web', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam accusantium enim esse eos officiis sit officia', 'Lorem ipsum, dolor sit amet, consectetur, adipisicing, elit, Quisquam, accusantium, enim, esse', 'vistas/img/cabeceras/web.jpg', '2017-11-17 14:59:28'),
(3, 'peliculas', 'peliculas', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris felis velit, volutpat nec molestie id, tempus eu enim. V', 'lorem,ipsum,sit', 'vistas/img/cabeceras/peliculas.jpg', '2018-03-15 22:22:27'),
(4, 'medicina', 'Medicina', 'todo en medicina', 'medicina', 'vistas/img/cabeceras/medicina.png', '2020-08-02 05:29:50'),
(5, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:05:53'),
(6, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:05'),
(7, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:23'),
(8, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:30'),
(9, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:31'),
(10, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:31'),
(11, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:32'),
(12, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:06:32'),
(13, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:08:08'),
(14, 'asdsad', 'asdsad', 'asdas', 'asdas', 'vistas/img/cabeceras/asdsad.png', '2020-08-02 06:08:09'),
(15, 'asdasd', 'asdasd', 'asdasdas', 'dfgdfg', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:14:53'),
(16, 'asdasd', 'asdasd', 'asdasdas', 'dfgdfg', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:14:56'),
(17, 'asdasd', 'asdasd', 'asdasdas', 'dfgdfg', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:14:58'),
(18, 'asdasd', 'asdasd', 'asdasdas', 'dfgdfg', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:14:59'),
(19, 'asdasd', 'asdasd', 'asdasdas', 'dfgdfg', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:15:00'),
(20, 'assf', 'assf', 'asdasd', 'sdasf', 'vistas/img/cabeceras/assf.png', '2020-08-02 06:16:13'),
(21, 'assf', 'assf', 'asdasd', 'sdasf', 'vistas/img/cabeceras/assf.png', '2020-08-02 06:16:39'),
(22, 'assf', 'assf', 'asdasd', 'sdasf', 'vistas/img/cabeceras/assf.png', '2020-08-02 06:18:23'),
(23, 'asdasd', 'asdasd', 'asdas', 'asdas', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:19:04'),
(24, 'asdasd', 'asdasd', 'asdas', 'asdas', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:19:07'),
(25, 'asdasd', 'asdasd', 'asdas', 'asdas', 'vistas/img/cabeceras/asdasd.png', '2020-08-02 06:19:24'),
(26, 'sasdddddddddd', 'sasdddddddddd', 'asd', 'asdas', 'vistas/img/cabeceras/sasdddddddddd.png', '2020-08-02 06:20:30'),
(27, 'ewr', 'ewr', 'eeee', 'eeee', 'vistas/img/cabeceras/ewr.png', '2020-08-02 06:22:18'),
(31, 'aaaaaaaaa', 'aaaaaaaaa', 'aa', 'aaa', 'undefined', '2020-08-02 09:33:05'),
(32, 'aaaaaaaa', 'aaaaaaaa', 'sdfdsf', 'aaaaaa', 'vistas/img/cabeceras/aaaaaaaa.png', '2020-08-02 07:13:55'),
(36, 'asdas', 'asdas', '123fsdf', 'sdfsd', 'undefined', '2020-08-02 08:31:01'),
(37, 'fgfg', 'fgfg', 'dfsdf', 'dfgfdgd', 'vistas/img/cabeceras/default/default.jpg', '2020-08-02 08:42:24'),
(39, 'fhg', 'fhg', 'sdfdsgfgaaaaaaaaaa', 'sdfsd', 'vistas/img/cabeceras/fhg.png', '2020-08-02 09:02:53'),
(40, 'fgdffd', 'fgdffd', 'gfg', 'fgfg', 'undefined', '2020-08-02 09:33:40'),
(41, 'aaaaaaaaa', 'aaaaaaaaa', 'asdas', 'asdas', 'vistas/img/cabeceras/aaaaaaaaa.png', '2020-08-02 09:12:05'),
(43, 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'vistas/img/cabeceras/aaaaaaaa.png', '2020-08-10 06:44:19'),
(44, 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'vistas/img/cabeceras/aaaaaaaa.png', '2020-08-10 06:44:21'),
(45, 'memorias-y-discos-', 'Memorias y Discos ', 'todo memorias y discos', 'todo memorias y discos', 'vistas/img/cabeceras/memorias-y-discos-.png', '2020-08-10 08:18:31'),
(46, 'memorias-ram-kingston', 'Memorias Ram kingston', 'memorias Ram kingston', 'memorias kingston', 'vistas/img/cabeceras/memorias-ram-kingston.png', '2020-08-10 08:19:35'),
(47, 'memorias-ram-4-gb-memorias-kingston', 'memorias ram 4 gb memorias kingston', '4 ram ', 'memorias kingston 4 ram', 'undefined', '2020-08-10 08:23:13'),
(48, 'monitores', 'Monitores', 'Monitores', 'monitores', 'vistas/img/cabeceras/monitores.png', '2020-08-11 06:17:23'),
(49, 'monitores-gamer', 'monitores gamer', 'monitores gamer', 'monitores gamer', 'vistas/img/cabeceras/monitores-gamer.png', '2020-08-11 06:18:14'),
(50, 'monitor-gamer-asus', 'monitor gamer asus', 'monitores gamer asus 24', 'monitores gamer asus 24', 'undefined', '2021-02-04 06:23:37'),
(51, 'procesadores', 'PROCESADORES', 'procesadores', 'procesadores', 'vistas/img/cabeceras/procesadores.png', '2020-08-12 09:08:31'),
(52, 'procesadores-intel', 'Procesadores Intel', 'Procesadores Intel', 'Procesadores Intel', 'vistas/img/cabeceras/procesadores-intel.png', '2020-08-12 09:08:58'),
(53, 'procesadores-core-i3-6100', 'procesadores core i3 6100', 'procesadores core i3 6100', 'procesadores core i3 6100', 'vistas/img/cabeceras/procesadores-core-i3-6100.png', '2020-08-12 09:09:48'),
(54, 'placa-madre--motherboard-', 'PLACA MADRE  MOTHERBOARD ', 'PLACA MADRE ( MOTHERBOARD )', 'PLACA MADRE ( MOTHERBOARD )', 'vistas/img/cabeceras/placa-madre--motherboard-.png', '2020-08-13 23:23:33'),
(55, 'intel', 'INTEL', 'PLACA MADRE INTEL', 'PLACA MADRE INTEL', 'vistas/img/cabeceras/intel.png', '2020-08-13 23:24:07'),
(56, 'placa-madre-intel-b455', 'PLACA MADRE INTEL B455', 'PLACA MADRE INTEL B455', 'PLACA MADRE INTEL B455', 'undefined', '2021-02-06 08:02:33'),
(57, 'fuentes-de-poder', 'FUENTES DE PODER', 'FUENTES DE PODER', 'FUENTES DE PODER', 'vistas/img/cabeceras/fuentes-de-poder.png', '2020-08-13 23:25:57'),
(58, 'fuentes-de-poder-certificado', 'FUENTES DE PODER CERTIFICADO', 'FUENTES DE PODER CERTIFICADO', 'FUENTES DE PODER CERTIFICADO', 'vistas/img/cabeceras/fuentes-de-poder-certificado.png', '2020-08-13 23:26:38'),
(59, 'fuente-cooler-master-mwe-700-bronze-v2', 'FUENTE COOLER MASTER MWE 700 BRONZE V2', 'FUENTE COOLER MASTER MWE 700 BRONZE V2', 'FUENTE COOLER MASTER MWE 700 BRONZE V2', 'undefined', '2021-01-10 06:22:01'),
(60, 'impresoras', 'IMPRESORAS', 'IMPRESORAS', 'IMPRESORAS', 'vistas/img/cabeceras/impresoras.png', '2020-08-13 23:30:38'),
(61, 'impresora-tinta-y-cartucho', 'IMPRESORA TINTA Y CARTUCHO', 'IMPRESORA TINTA Y CARTUCHO', 'IMPRESORA TINTA Y CARTUCHO', 'vistas/img/cabeceras/impresora-tinta-y-cartucho.png', '2020-08-13 23:31:15'),
(62, 'impresora-multifuncional-todo-en-uno-smart-tank-hp-500', 'IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500', 'IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500', 'IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500', 'undefined', '2021-01-10 06:21:53'),
(63, 'procesadores-ryzen', 'PROCESADORES RYZEN', 'PROCESADORES RYZEN', 'PROCESADORES RYZEN', 'vistas/img/cabeceras/procesadores-ryzen.png', '2020-08-13 23:34:22'),
(64, 'procesador-ryzen-5-2600', 'PROCESADOR RYZEN 5 2600', 'PROCESADORES RYZEN 5 2600', 'PROCESADORES RYZEN 5 2600', 'undefined', '2021-01-10 06:03:46'),
(65, 'teclados--mouse', 'TECLADOS  MOUSE', 'TECLADOS MOUSE', 'TECLADOS MOUSE', 'vistas/img/cabeceras/teclados--mouse.png', '2020-08-13 23:37:29'),
(66, 'teclados', 'teclados', 'teclados', 'teclados', 'vistas/img/cabeceras/teclados.png', '2020-08-13 23:38:16'),
(68, 'mouse', 'mouse', 'mouse', 'mouse', 'vistas/img/cabeceras/mouse.png', '2020-08-13 23:41:47'),
(70, 'procesadores-core-i9', 'procesadores core i9', 'procesadores core i9 super potente', 'procesadores,core i9', 'undefined', '2021-01-10 06:03:36'),
(71, 'aaaaaaaadasd', 'aaaaaaaadasd', 'asd', 'asdas', 'undefined', '2021-01-05 00:39:28'),
(73, 'case', 'case', 'case', 'case', 'vistas/img/cabeceras/case.jpg', '2021-02-08 10:49:08'),
(74, 'case-barato', 'case barato', 'case barato', 'case barato', 'vistas/img/cabeceras/case-barato.jpg', '2021-02-08 10:49:43'),
(76, 'case-gambyte-gowa-argb', 'CASE GAMBYTE GOWA ARGB', 'CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO', 'CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO', 'vistas/img/cabeceras/case-gambyte-gowa-argb.jpg', '2021-02-08 10:52:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `oferta` int(11) NOT NULL,
  `precioOferta` float NOT NULL,
  `descuentoOferta` int(11) NOT NULL,
  `imgOferta` text COLLATE utf8_spanish_ci NOT NULL,
  `finOferta` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `ruta`, `estado`, `oferta`, `precioOferta`, `descuentoOferta`, `imgOferta`, `finOferta`, `fecha`) VALUES
(8, 'MEMORIAS Y DISCOS ', 'memorias-y-discos-', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-10 08:18:31'),
(9, 'MONITORES', 'monitores', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-11 06:17:23'),
(10, 'PROCESADORES', 'procesadores', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-12 09:08:31'),
(11, 'PLACA MADRE  MOTHERBOARD ', 'placa-madre--motherboard-', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:23:33'),
(12, 'FUENTES DE PODER', 'fuentes-de-poder', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:25:57'),
(13, 'IMPRESORAS', 'impresoras', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:30:38'),
(14, 'TECLADOS  MOUSE', 'teclados--mouse', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:37:29'),
(16, 'CASE', 'case', 1, 0, 0, 0, '', '0000-00-00 00:00:00', '2021-02-08 10:49:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `documento` int(8) DEFAULT NULL,
  `ruc` double DEFAULT NULL,
  `email` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `clave` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `modo` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipocliente` text COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `ruc`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`, `clave`, `modo`, `tipocliente`) VALUES
(9, 'ARIANA ALEXANDRA CAMACHO ORTIZ', 72172395, 0, 'ariana@gmail.com', '979804999', 'Sinchi Roca 1823, Chiclayito', '1999-09-09', 5, '2021-02-06 03:02:17', '2021-01-18 06:35:33', NULL, NULL, 'nouser'),
(11, 'IMPORTACIONES IMPACTO S.A.C.', 0, 20543886671, 'carlos@gmail.com', '979808888', 'AV. BOLIVIA NRO. 148 INT. 553 (FRENTE AL CENTRO CIVICO) - LIMA', '0000-00-00', 6, '2021-01-18 06:48:30', '2021-01-18 07:28:52', NULL, NULL, 'nouser'),
(15, 'juan', 695555, 0, 'juan@gmail.com', '622111', 'av lima 3423', NULL, 19, '2021-02-07 20:57:24', '2021-02-04 11:09:56', '123456', 'directo', 'usuario'),
(17, 'juan ', 285521, 0, 'juan01@gmail.com', '985474', 'av lima 34534', NULL, 0, '0000-00-00 00:00:00', '2021-02-06 06:52:30', '123456', 'directo', 'usuario'),
(20, 'PATRICIA SOLANGE HUANCA AGUILAR', 72172391, 0, 'pati@gmail.com', '356884545', 'av lima 342', '0000-00-00', 7, '2021-02-08 07:16:14', '2021-02-08 11:01:01', NULL, NULL, 'nouser'),
(21, 'john castillo', 77777887, 0, 'john@gmail.com', '99999999', 'Av lima 45623', NULL, 1, '2021-02-08 07:18:21', '2021-02-08 11:09:26', '123456', 'directo', 'usuario'),
(28, 'John castillo', 99999999, 0, 'john01@gmail.com', '99999999', 'Av lima 4676', NULL, 0, '0000-00-00 00:00:00', '2021-02-08 11:25:53', '123456', 'directo', 'usuario'),
(29, 'John casttillo', 98888888, 0, 'john2@gmail.com', '99999999', 'Av lima 245', NULL, 0, '0000-00-00 00:00:00', '2021-02-08 11:44:39', '123456', 'directo', 'usuario'),
(30, 'John castillo', 88888888, 0, 'john3@gmail.com', '999999999', 'Av lima 45677', NULL, 15, '2021-02-08 07:08:07', '2021-02-08 11:57:02', '123456', 'directo', 'usuario'),
(31, 'John castillo', 8888888, 0, 'john4@gmail.com', '99999999', 'Av lima 4566', NULL, 7, '2021-02-08 07:42:14', '2021-02-08 12:41:18', '123456', 'directo', 'usuario'),
(32, 'John castillo valencia', 99999999, 0, 'john5@gmail.com', '999999999', 'Av Piura 3466', NULL, 7, '2021-02-08 08:01:03', '2021-02-08 12:59:25', '123456', 'directo', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deseos`
--

CREATE TABLE `deseos` (
  `id` int(11) NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `deseos`
--

INSERT INTO `deseos` (`id`, `email`, `id_producto`, `precio`, `fecha`) VALUES
(13, 'juan01@gmail.com', 528, 318, '2021-02-06 01:52:38'),
(16, 'juan@gmail.com', 530, 700, '2021-02-08 06:11:27'),
(17, 'juan@gmail.com', 533, 230, '2021-02-08 06:11:32'),
(18, 'john4@gmail.com', 530, 700, '2021-02-08 12:44:29'),
(19, 'john4@gmail.com', 533, 230, '2021-02-08 12:44:31'),
(20, 'john4@gmail.com', 534, 12, '2021-02-08 12:44:32'),
(21, 'john4@gmail.com', 536, 300, '2021-02-08 12:44:33'),
(24, 'john5@gmail.com', 534, 12, '2021-02-08 13:02:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordencompra`
--

CREATE TABLE `ordencompra` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `codigoprovee` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_trabajador` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_trabajadorrecibe` int(11) DEFAULT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecharecibido` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ordencompra`
--

INSERT INTO `ordencompra` (`id`, `codigo`, `codigoprovee`, `id_trabajador`, `productos`, `impuesto`, `neto`, `total`, `fecha`, `id_trabajadorrecibe`, `id_proveedor`, `fecharecibido`, `estado`, `comentario`) VALUES
(8, 10008, '17', 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"2\",\"preciouni\":\"100\",\"stock\":\"NaN\",\"total\":\"200\"},{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"cantidad\":\"3\",\"preciouni\":\"200\",\"stock\":\"NaN\",\"total\":\"600\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"cantidad\":\"3\",\"preciouni\":\"500\",\"stock\":\"NaN\",\"total\":\"1500\"},{\"id\":\"533\",\"descripcion\":\"procesadores core i9 super potente\",\"cantidad\":\"3\",\"preciouni\":\"100\",\"stock\":\"NaN\",\"total\":\"300\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"5\",\"preciouni\":\"600\",\"stock\":\"NaN\",\"total\":\"3000\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\",\"cantidad\":\"1\",\"preciouni\":\"500\",\"total\":\"500\"},{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\",\"cantidad\":\"2\",\"preciouni\":\"150\",\"stock\":\"NaN\",\"total\":\"300\"},{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"3\",\"preciouni\":\"200\",\"stock\":\"NaN\",\"total\":\"600\"},{\"id\":\"534\",\"descripcion\":\"asd\",\"cantidad\":\"1\",\"preciouni\":\"300\",\"total\":\"300\"}]', 1314, 5986, 7300, '2021-02-08 09:50:54', NULL, 17, NULL, 0, NULL),
(9, 10009, '17', 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"2\",\"preciouni\":\"200\",\"stock\":\"NaN\",\"total\":\"400\"},{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"cantidad\":\"3\",\"preciouni\":\"100\",\"stock\":\"NaN\",\"total\":\"300\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"cantidad\":\"5\",\"preciouni\":\"200\",\"stock\":\"NaN\",\"total\":\"1000\"},{\"id\":\"533\",\"descripcion\":\"procesadores core i9 super potente\",\"cantidad\":\"5\",\"preciouni\":\"100\",\"stock\":\"NaN\",\"total\":\"500\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\",\"cantidad\":\"2\",\"preciouni\":\"200\",\"stock\":\"NaN\",\"total\":\"400\"},{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\",\"cantidad\":\"5\",\"preciouni\":\"100\",\"stock\":\"NaN\",\"total\":\"500\"}]', 558, 2542, 3100, '2021-02-08 09:50:57', NULL, 18, NULL, 0, NULL),
(10, 10010, '365855', 1, '[{\"id\":\"536\",\"descripcion\":\"CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO\",\"cantidad\":\"15\",\"preciouni\":\"250\",\"cantidadingreso\":\"10\",\"total\":\"2500\"}]', 450, 2050, 2500, '2021-02-08 10:54:28', 1, 19, '2021-02-08 05:54:28', 1, '5 estaban en mal estado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `metodo` text COLLATE utf8_spanish_ci NOT NULL,
  `pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `email`, `direccion`, `productos`, `estado`, `metodo`, `pago`, `fecha`) VALUES
(38, 'juan@gmail.com', 'av lima 123 ss', '[{\"cod_produc\":527,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/placa-madre-intel-b455.png\",\"product\":\"PLACA MADRE INTEL B455\",\"variant\":563.0}]', 3, 'transferencia movil', '563.0', '2021-02-06 06:39:15'),
(39, 'juan@gmail.com', 'av lima234 - aadasd', '[{\"cod_produc\":527,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/placa-madre-intel-b455.png\",\"product\":\"PLACA MADRE INTEL B455\",\"variant\":563.0}]', 3, 'transferencia movil', '563.0', '2021-02-06 06:41:27'),
(40, 'juan@gmail.com', 'sdfsd - fsdfds', '[{\"cod_produc\":527,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/placa-madre-intel-b455.png\",\"product\":\"PLACA MADRE INTEL B455\",\"variant\":563.0}]', 3, 'transferencia movil', '563.0', '2021-02-06 06:43:57'),
(41, 'juan@gmail.com', 'av lima 123 - por el colegio', '[{\"cod_produc\":527,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/placa-madre-intel-b455.png\",\"product\":\"PLACA MADRE INTEL B455\",\"variant\":563.0}]', 2, 'transferencia movil', '563.0', '2021-02-06 12:03:41'),
(46, 'john@gmail.com', 'Av lima 45623 - dsfsds', '[{\"cod_produc\":525,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/monitor-gamer-asus.png\",\"product\":\"monitores gamer asus 24\",\"variant\":850.0},{\"cod_produc\":533,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/procesadores-core-i9.png\",\"product\":\"procesadores core i9 super potente\",\"variant\":200.0}]', 3, 'transferencia movil', '1050.0', '2021-02-08 12:36:19'),
(47, 'john@gmail.com', 'Av lima 45623 - sdasda', '[{\"cod_produc\":529,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/impresora-multifuncional-todo-en-uno-smart-tank-hp-500.png\",\"product\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"variant\":350.0}]', 3, 'transferencia movil', '350.0', '2021-02-08 12:37:59'),
(48, 'john4@gmail.com', 'Av lima 4566 - costado de la pollería', '[{\"cod_produc\":525,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/monitor-gamer-asus.png\",\"product\":\"monitores gamer asus 24\",\"variant\":850.0},{\"cod_produc\":524,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/memorias-ram-4-gb-memorias-kingston.png\",\"product\":\"4 ram \",\"variant\":140.0},{\"cod_produc\":527,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/placa-madre-intel-b455.png\",\"product\":\"PLACA MADRE INTEL B455\",\"variant\":563.0},{\"cod_produc\":528,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/fuente-cooler-master-mwe-700-bronze-v2.png\",\"product\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"variant\":318.0},{\"cod_produc\":529,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/impresora-multifuncional-todo-en-uno-smart-tank-hp-500.png\",\"product\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"variant\":350.0},{\"cod_produc\":530,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/procesador-ryzen-5-2600.png\",\"product\":\"PROCESADORES RYZEN 5 2600\",\"variant\":700.0},{\"cod_produc\":536,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/case-gambyte-gowa-argb.jpg\",\"product\":\"CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO\",\"variant\":300.0}]', 2, 'transferencia movil', '3221.0', '2021-02-08 12:41:47'),
(49, 'john4@gmail.com', 'Av lima 4566 - esquina', '[{\"cod_produc\":530,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/procesador-ryzen-5-2600.png\",\"product\":\"PROCESADORES RYZEN 5 2600\",\"variant\":650.0}]', 3, 'transferencia movil', '650.0', '2021-02-08 12:45:30'),
(50, 'john5@gmail.com', 'Av Piura 3466 - al costado de la polleria', '[{\"cod_produc\":524,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/memorias-ram-4-gb-memorias-kingston.png\",\"product\":\"4 ram \",\"variant\":140.0},{\"cod_produc\":525,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/monitor-gamer-asus.png\",\"product\":\"monitores gamer asus 24\",\"variant\":850.0},{\"cod_produc\":527,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/placa-madre-intel-b455.png\",\"product\":\"PLACA MADRE INTEL B455\",\"variant\":563.0},{\"cod_produc\":528,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/fuente-cooler-master-mwe-700-bronze-v2.png\",\"product\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"variant\":318.0},{\"cod_produc\":529,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/impresora-multifuncional-todo-en-uno-smart-tank-hp-500.png\",\"product\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"variant\":350.0},{\"cod_produc\":530,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/procesador-ryzen-5-2600.png\",\"product\":\"PROCESADORES RYZEN 5 2600\",\"variant\":650.0},{\"cod_produc\":536,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/case-gambyte-gowa-argb.jpg\",\"product\":\"CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO\",\"variant\":300.0}]', 2, 'transferencia movil', '3171.0', '2021-02-08 13:00:25'),
(51, 'john5@gmail.com', 'Av Piura 3466 - al costado de la polleria', '[{\"cod_produc\":530,\"itemQuantity\":1,\"portada\":\"http://192.168.42.63/backend/vistas/img/productos/procesador-ryzen-5-2600.png\",\"product\":\"PROCESADORES RYZEN 5 2600\",\"variant\":600.0}]', 3, 'transferencia movil', '600.0', '2021-02-08 13:03:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--

CREATE TABLE `plantilla` (
  `id` int(11) NOT NULL,
  `barraSuperior` text COLLATE utf8_spanish_ci NOT NULL,
  `textoSuperior` text COLLATE utf8_spanish_ci NOT NULL,
  `colorFondo` text COLLATE utf8_spanish_ci NOT NULL,
  `colorTexto` text COLLATE utf8_spanish_ci NOT NULL,
  `logo` text COLLATE utf8_spanish_ci NOT NULL,
  `icono` text COLLATE utf8_spanish_ci NOT NULL,
  `redesSociales` text COLLATE utf8_spanish_ci NOT NULL,
  `apiFacebook` text COLLATE utf8_spanish_ci NOT NULL,
  `pixelFacebook` text COLLATE utf8_spanish_ci NOT NULL,
  `googleAnalytics` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `plantilla`
--

INSERT INTO `plantilla` (`id`, `barraSuperior`, `textoSuperior`, `colorFondo`, `colorTexto`, `logo`, `icono`, `redesSociales`, `apiFacebook`, `pixelFacebook`, `googleAnalytics`, `fecha`) VALUES
(1, '#000000', '#ffffff', 'rgb(1,94,160)', '#ffffff', 'vistas/img/plantilla/logo.png', 'vistas/img/plantilla/icono.png', '[{\"red\":\"fa-facebook\",\"estilo\":\"facebookBlanco\",\"url\":\"http://facebook.com/\",\"activo\":1},{\"red\":\"fa-youtube\",\"estilo\":\"youtubeBlanco\",\"url\":\"http://youtube.com/\",\"activo\":0},{\"red\":\"fa-twitter\",\"estilo\":\"twitterBlanco\",\"url\":\"http://twitter.com/\",\"activo\":0},{\"red\":\"fa-google-plus\",\"estilo\":\"google-plusBlanco\",\"url\":\"http://google.com/\",\"activo\":0},{\"red\":\"fa-instagram\",\"estilo\":\"instagramBlanco\",\"url\":\"http://instagram.com/\",\"activo\":0}]', '\r\n      		<script>   window.fbAsyncInit = function() {     FB.init({       appId      : \'131737410786111\',       cookie     : true,       xfbml      : true,       version    : \'v2.10\'     });            FB.AppEvents.logPageView();             };    (function(d, s, id){      var js, fjs = d.getElementsByTagName(s)[0];      if (d.getElementById(id)) {return;}      js = d.createElement(s); js.id = id;      js.src = \"https://connect.facebook.net/en_US/sdk.js\";      fjs.parentNode.insertBefore(js, fjs);    }(document, \'script\', \'facebook-jssdk\'));  </script>\r\n      		', '\r\n  			<!-- Facebook Pixel Code --> 	<script> 	  !function(f,b,e,v,n,t,s) 	  {if(f.fbq)return;n=f.fbq=function(){n.callMethod? 	  n.callMethod.apply(n,arguments):n.queue.push(arguments)}; 	  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\'; 	  n.queue=[];t=b.createElement(e);t.async=!0; 	  t.src=v;s=b.getElementsByTagName(e)[0]; 	  s.parentNode.insertBefore(t,s)}(window, document,\'script\', 	  \'https://connect.facebook.net/en_US/fbevents.js\'); 	  fbq(\'init\', \'131737410786111\'); 	  fbq(\'track\', \'PageView\'); 	</script> 	<noscript><img height=\"1\" width=\"1\" style=\"display:none\" 	  src=\"https://www.facebook.com/tr?id=149877372404434&ev=PageView&noscript=1\" 	/></noscript> <!-- End Facebook Pixel Code -->    \r\n  			', '  \r\n  				<!-- Global site tag (gtag.js) - Google Analytics --> 	<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-999999-1\"></script> 	<script> 	  window.dataLayer = window.dataLayer || []; 	  function gtag(){dataLayer.push(arguments);} 	  gtag(\'js\', new Date());  	  gtag(\'config\', \'UA-9999999-1\'); 	</script>      \r\n            \r\n            \r\n            \r\n      ', '2020-08-11 06:13:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `titular` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `multimedia` text COLLATE utf8_spanish_ci NOT NULL,
  `detalles` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` float NOT NULL,
  `portada` text COLLATE utf8_spanish_ci NOT NULL,
  `vistas` int(11) NOT NULL,
  `ventas` int(11) NOT NULL,
  `vistasGratis` int(11) NOT NULL,
  `ventasGratis` int(11) NOT NULL,
  `ofertadoPorCategoria` int(11) NOT NULL,
  `ofertadoPorSubCategoria` int(11) NOT NULL,
  `oferta` int(11) NOT NULL,
  `precioOferta` float NOT NULL,
  `descuentoOferta` int(11) NOT NULL,
  `imgOferta` text COLLATE utf8_spanish_ci NOT NULL,
  `finOferta` datetime NOT NULL,
  `peso` float NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `id_subcategoria`, `tipo`, `ruta`, `estado`, `titulo`, `titular`, `descripcion`, `multimedia`, `detalles`, `precio`, `portada`, `vistas`, `ventas`, `vistasGratis`, `ventasGratis`, `ofertadoPorCategoria`, `ofertadoPorSubCategoria`, `oferta`, `precioOferta`, `descuentoOferta`, `imgOferta`, `finOferta`, `peso`, `stock`, `fecha`) VALUES
(524, 8, 22, 'fisico', 'memorias-ram-4-gb-memorias-kingston', 1, 'memorias ram 4 gb memorias kingston', '4 ram ...', '4 ram ', '[{\"foto\":\"vistas/img/multimedia/memorias-ram-4-gb-memorias-kingston/ram.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 140, 'vistas/img/productos/memorias-ram-4-gb-memorias-kingston.png', 20, 23, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 0.5, 39, '2021-02-08 13:01:02'),
(525, 9, 23, 'fisico', 'monitor-gamer-asus', 1, 'monitor gamer asus', 'monitores gamer asus 24...', 'monitores gamer asus 24', '[{\"foto\":\"vistas/img/multimedia/monitor-gamer-asus/moni.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 850, 'vistas/img/productos/monitor-gamer-asus.png', 23, 12, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 19, '2021-02-08 13:01:02'),
(526, 10, 24, 'fisico', 'procesadores-core-i3-6100', 1, 'procesadores core i3 6100', 'procesadores core i3 6100...', 'procesadores core i3 6100', '[{\"foto\":\"vistas/img/multimedia/procesadores-core-i3-6100/kisspng-intel-core-i3-graphics-cards-video-adapters-cent-intel-core-i97980xe-5b3ac8a4ddb085.5771504015305791089081.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 750, 'vistas/img/productos/procesadores-core-i3-6100.png', 3, 5, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 0.5, 15, '2021-01-18 12:02:10'),
(527, 11, 25, 'fisico', 'placa-madre-intel-b455', 1, 'PLACA MADRE INTEL B455', 'PLACA MADRE INTEL B455...', 'PLACA MADRE INTEL B455', '[{\"foto\":\"vistas/img/multimedia/placa-madre-intel-b455/placa.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 563, 'vistas/img/productos/placa-madre-intel-b455.png', 0, 30, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 0.4, 12, '2021-02-08 13:01:03'),
(528, 12, 26, 'fisico', 'fuente-cooler-master-mwe-700-bronze-v2', 1, 'FUENTE COOLER MASTER MWE 700 BRONZE V2', 'FUENTE COOLER MASTER MWE 700 BRONZE V2...', 'FUENTE COOLER MASTER MWE 700 BRONZE V2', '[{\"foto\":\"vistas/img/multimedia/fuente-cooler-master-mwe-700-bronze-v2/FUENTEE.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 318, 'vistas/img/productos/fuente-cooler-master-mwe-700-bronze-v2.png', 2, 7, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 0.6, 3, '2021-02-08 13:01:03'),
(529, 13, 27, 'fisico', 'impresora-multifuncional-todo-en-uno-smart-tank-hp-500', 1, 'IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500', 'IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500...', 'IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500', '[{\"foto\":\"vistas/img/multimedia/impresora-multifuncional-todo-en-uno-smart-tank-hp-500/IMPRESO.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 350, 'vistas/img/productos/impresora-multifuncional-todo-en-uno-smart-tank-hp-500.png', 1, 8, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 2.4, 3, '2021-02-08 13:01:03'),
(530, 10, 28, 'fisico', 'procesador-ryzen-5-2600', 1, 'PROCESADOR RYZEN 5 2600', 'PROCESADORES RYZEN 5 2600...', 'PROCESADORES RYZEN 5 2600', '[{\"foto\":\"vistas/img/multimedia/procesador-ryzen-5-2600/PROCE.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 600, 'vistas/img/productos/procesador-ryzen-5-2600.png', 1, 11, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 0.7, 41, '2021-02-08 13:02:52'),
(533, 10, 24, 'fisico', 'procesadores-core-i9', 1, 'procesadores core i9', 'procesadores core i9 super potente...', 'procesadores core i9 super potente', '[{\"foto\":\"vistas/img/multimedia/procesadores-core-i9/placa-madre-intel-b455.png\"},{\"foto\":\" />\\n<b>Warning</b>:  mkdir(): File exists in <b>C:\\\\xampp\\\\htdocs\\\\backend\\\\controladores\\\\productos.controlador.php</b> on line <b>89</b><br />\\n../vistas/img/multimedia/procesadores-core-i9/procesador-ryzen-5-2600.png\"},{\"foto\":\" />\\n<b>Warning</b>:  mkdir(): File exists in <b>C:\\\\xampp\\\\htdocs\\\\backend\\\\controladores\\\\productos.controlador.php</b> on line <b>89</b><br />\\n../vistas/img/multimedia/procesadores-core-i9/procesadores-core-i3-6100.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 230, 'vistas/img/productos/procesadores-core-i9.png', 10, 11, 0, 0, 0, 0, 1, 200, 30, 'vistas/img/ofertas/procesadores-core-i9.png', '2020-12-19 23:59:59', 0.5, 9, '2021-02-08 12:18:21'),
(534, 14, 30, 'fisico', 'aaaaaaaadasd', 1, 'aaaaaaaadasd', 'asd...', 'asd', '[{\"foto\":\"vistas/img/multimedia/aaaaaaaadasd/placa-madre-intel-b455.png\"},{\"foto\":\"vistas/img/multimedia/aaaaaaaadasd/asdasd.png\"},{\"foto\":\"vistas/img/multimedia/aaaaaaaadasd/procesador.png\"},{\"foto\":\"vistas/img/multimedia/aaaaaaaadasd/asdsad.png\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 12, 'vistas/img/productos/aaaaaaaadasd.png', 1, 1, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 123, 10, '2021-02-08 12:05:01'),
(536, 16, 31, 'fisico', 'case-gambyte-gowa-argb', 1, 'CASE GAMBYTE GOWA ARGB', 'CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO...', 'CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO', '[{\"foto\":\"vistas/img/multimedia/case-gambyte-gowa-argb/HDJFBGROXGWYGDE16086758864.jpg\"}]', '{\"Talla\":\" \",\"Color\":\" \",\"Marca\":\" \"}', 300, 'vistas/img/productos/case-gambyte-gowa-argb.jpg', 0, 4, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1.5, 6, '2021-02-08 13:01:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `ruc` double NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `ruc`, `nombre`, `direccion`, `telefono`, `email`, `productos`) VALUES
(17, 20526306148, 'CHIFLERIA  KEYLITA   E.I.R.L.', 'AV. BOLOGNESI   2 ETAPA NRO. 674 INT. 03 (FRENTE  A  OVALO  BOLOGNESI - 1ER PISO) - PIURA', '8555522', 'keylita@gmail.com', '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\"},{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\"},{\"id\":\"533\",\"descripcion\":\"procesadores core i9 super potente\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\"},{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\"},{\"id\":\"524\",\"descripcion\":\"4 ram \"},{\"id\":\"534\",\"descripcion\":\"asd\"}]'),
(18, 20543886671, 'IMPORTACIONES IMPACTO S.A.C.', 'AV. BOLIVIA NRO. 148 INT. 553 (FRENTE AL CENTRO CIVICO) - LIMA', '99999999', 'impacto@gmail.com', '[{\"id\":\"524\",\"descripcion\":\"4 ram \"},{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\"},{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\"},{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\"}]'),
(19, 20109199835, 'INSTITUTO SUPERIOR TECNOLOGICO IDAT', 'AV. REPUBLICA DE CHILE NRO. 120 - LIMA', '38844412', 'idat@edu.idat.pe', '[{\"id\":\"536\",\"descripcion\":\"CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO\"},{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL,
  `subcategoria` text COLLATE utf8_spanish_ci NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ofertadoPorCategoria` int(11) NOT NULL,
  `oferta` int(11) NOT NULL,
  `precioOferta` float NOT NULL,
  `descuentoOferta` int(11) NOT NULL,
  `imgOferta` text COLLATE utf8_spanish_ci NOT NULL,
  `finOferta` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `subcategoria`, `id_categoria`, `ruta`, `estado`, `ofertadoPorCategoria`, `oferta`, `precioOferta`, `descuentoOferta`, `imgOferta`, `finOferta`, `fecha`) VALUES
(22, 'Memorias Ram kingston', 8, 'memorias-ram-kingston', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-10 08:19:35'),
(23, 'monitores gamer', 9, 'monitores-gamer', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-11 06:18:14'),
(24, 'Procesadores Intel', 10, 'procesadores-intel', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-12 09:08:58'),
(25, 'INTEL', 11, 'intel', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:24:07'),
(26, 'FUENTES DE PODER CERTIFICADO', 12, 'fuentes-de-poder-certificado', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:26:38'),
(27, 'IMPRESORA TINTA Y CARTUCHO', 13, 'impresora-tinta-y-cartucho', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:31:15'),
(28, 'PROCESADORES RYZEN', 10, 'procesadores-ryzen', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:34:22'),
(29, 'teclados', 14, 'teclados', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:38:16'),
(30, 'mouse', 14, 'mouse', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2020-08-13 23:41:47'),
(31, 'case barato', 16, 'case-barato', 1, 0, 0, 0, 0, '', '0000-00-00 00:00:00', '2021-02-08 10:49:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) DEFAULT NULL,
  `codigofac` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `codigofac`, `id_cliente`, `id_vendedor`, `productos`, `impuesto`, `neto`, `total`, `metodo_pago`, `fecha`) VALUES
(55, 0, 10001, 11, 1, '[{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"140\",\"total\":\"140\"},{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\",\"cantidad\":\"1\",\"stock\":\"28\",\"precio\":\"900\",\"total\":\"900\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\",\"cantidad\":\"1\",\"stock\":\"18\",\"precio\":\"750\",\"total\":\"750\"}]', 322.2, 1467.8, 1790, 'Efectivo', '2020-12-31 13:03:17'),
(56, 0, 10002, 11, 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"48\",\"precio\":\"700\",\"total\":\"700\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"563\",\"total\":\"563\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"750\",\"total\":\"750\"}]', 362.34, 1650.66, 2013, 'Efectivo', '2021-01-02 13:03:02'),
(57, 10019, 0, 9, 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"700\",\"total\":\"700\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"cantidad\":\"1\",\"stock\":\"8\",\"precio\":\"318\",\"total\":\"318\"}]', 183.24, 834.76, 1018, 'Efectivo', '2021-01-03 10:01:04'),
(59, 0, 10003, 11, 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"45\",\"precio\":\"700\",\"total\":\"700\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"17\",\"precio\":\"563\",\"total\":\"563\"}]', 227.34, 1035.66, 1263, 'Efectivo', '2021-01-04 10:02:31'),
(60, 0, 10004, 11, 1, '[{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\",\"cantidad\":\"1\",\"stock\":\"29\",\"precio\":\"900\",\"total\":\"900\"},{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"1\",\"stock\":\"49\",\"precio\":\"140\",\"total\":\"140\"}]', 187.2, 852.8, 1040, 'Efectivo', '2021-01-05 10:06:27'),
(61, 10021, 0, 9, 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"44\",\"precio\":\"700\",\"total\":\"700\"},{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"1\",\"stock\":\"48\",\"precio\":\"140\",\"total\":\"140\"}]', 151.2, 688.8, 840, 'Efectivo', '2021-01-07 10:06:59'),
(62, 0, 10005, 11, 1, '[{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"1\",\"stock\":\"47\",\"precio\":\"140\",\"total\":\"140\"}]', 25.2, 114.8, 140, 'Efectivo', '2021-01-13 11:02:38'),
(63, 0, 10006, 11, 1, '[{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"400\",\"total\":\"400\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"15\",\"precio\":\"563\",\"total\":\"563\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\",\"cantidad\":\"1\",\"stock\":\"16\",\"precio\":\"750\",\"total\":\"750\"}]', 308.34, 1404.66, 1713, 'Efectivo', '2021-01-17 11:48:30'),
(64, 10022, 0, 9, 1, '[{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"46\",\"precio\":\"700\",\"total\":\"700\"},{\"id\":\"526\",\"descripcion\":\"procesadores core i3 6100\",\"cantidad\":\"1\",\"stock\":\"15\",\"precio\":\"750\",\"total\":\"750\"}]', 261, 1189, 1450, 'Efectivo', '2021-01-18 12:00:32'),
(66, 10023, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-46456456', '2021-02-06 07:29:49'),
(67, 10024, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-4564564', '2021-02-06 07:47:12'),
(68, 10025, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-6456464', '2021-02-06 07:51:54'),
(69, 10026, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-86867', '2021-02-06 07:58:00'),
(70, 10027, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-787878', '2021-02-06 08:00:29'),
(71, 10028, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-890089', '2021-02-06 08:01:05'),
(72, 10029, 0, 9, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Efectivo', '2021-02-06 08:02:17'),
(73, 10030, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-6464645', '2021-02-06 08:19:04'),
(74, 10031, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-1\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-657567', '2021-02-06 08:22:40'),
(75, 10032, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-2\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Efectivo', '2021-02-06 08:26:46'),
(76, 10033, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-3\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-7899', '2021-02-06 08:31:47'),
(77, 10034, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-4\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Efectivo', '2021-02-06 08:32:17'),
(78, 10035, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-5\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'Paypal-4564564', '2021-02-06 08:33:04'),
(79, 10036, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-6\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'transferencia movil', '2021-02-06 08:39:02'),
(80, 10037, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-7\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'transferencia movil', '2021-02-06 08:50:47'),
(81, 10038, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-8\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'transferencia movil', '2021-02-06 08:50:59'),
(82, 10039, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-9\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'transferencia movil', '2021-02-06 08:53:26'),
(83, 10040, 0, 15, 1, '[{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"-10\",\"precio\":\"563\",\"total\":\"563\"}]', 101.34, 461.66, 563, 'transferencia movil', '2021-02-06 08:58:49'),
(92, 10041, 0, 31, 1, '[{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\",\"cantidad\":\"1\",\"stock\":\"20\",\"precio\":\"850\",\"total\":\"850\"},{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"1\",\"stock\":\"40\",\"precio\":\"140\",\"total\":\"140\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"13\",\"precio\":\"563\",\"total\":\"563\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"cantidad\":\"1\",\"stock\":\"4\",\"precio\":\"318\",\"total\":\"318\"},{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"cantidad\":\"1\",\"stock\":\"4\",\"precio\":\"350\",\"total\":\"350\"},{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"42\",\"precio\":\"700\",\"total\":\"700\"},{\"id\":\"536\",\"descripcion\":\"CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"300\",\"total\":\"300\"}]', 579.78, 2641.22, 3221, 'transferencia movil', '2021-02-08 12:42:14'),
(93, 10042, 0, 32, 1, '[{\"id\":\"524\",\"descripcion\":\"4 ram \",\"cantidad\":\"1\",\"stock\":\"39\",\"precio\":\"140\",\"total\":\"140\"},{\"id\":\"525\",\"descripcion\":\"monitores gamer asus 24\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"850\",\"total\":\"850\"},{\"id\":\"527\",\"descripcion\":\"PLACA MADRE INTEL B455\",\"cantidad\":\"1\",\"stock\":\"12\",\"precio\":\"563\",\"total\":\"563\"},{\"id\":\"528\",\"descripcion\":\"FUENTE COOLER MASTER MWE 700 BRONZE V2\",\"cantidad\":\"1\",\"stock\":\"3\",\"precio\":\"318\",\"total\":\"318\"},{\"id\":\"529\",\"descripcion\":\"IMPRESORA MULTIFUNCIONAL TODO EN UNO SMART TANK HP 500\",\"cantidad\":\"1\",\"stock\":\"3\",\"precio\":\"350\",\"total\":\"350\"},{\"id\":\"530\",\"descripcion\":\"PROCESADORES RYZEN 5 2600\",\"cantidad\":\"1\",\"stock\":\"41\",\"precio\":\"650\",\"total\":\"650\"},{\"id\":\"536\",\"descripcion\":\"CASE GAMBYTE GOWA ARGB FUENTE NEGRO 1 PANEL VIDRIO\",\"cantidad\":\"1\",\"stock\":\"6\",\"precio\":\"300\",\"total\":\"300\"}]', 570.78, 2600.22, 3171, 'transferencia movil', '2021-02-08 13:01:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cabeceras`
--
ALTER TABLE `cabeceras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deseos`
--
ALTER TABLE `deseos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cabeceras`
--
ALTER TABLE `cabeceras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `deseos`
--
ALTER TABLE `deseos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=537;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
