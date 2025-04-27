-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-01-2025 a las 23:04:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `eliminado` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `correo`, `pass`, `eliminado`) VALUES
(1, '', '', '', '', 0),
(2, 'Cliente', '1', 'cliente1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(3, 'Cliente', '2', 'cliente1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(4, 'Cliente', '3', 'cliente1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(5, 'cliente', '4', 'cliente1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(6, 'cliente', '5', 'cliente1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(7, 'Cliente', '6', 'cliente1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(8, 'Cliente ', '10', 'cliente2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `apellidos` varchar(128) NOT NULL,
  `correo` varchar(128) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `rol` int(1) NOT NULL,
  `archivo_nombre` varchar(255) NOT NULL,
  `archivo_file` varchar(255) NOT NULL,
  `eliminado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellidos`, `correo`, `pass`, `rol`, `archivo_nombre`, `archivo_file`, `eliminado`) VALUES
(1, 'Prueba Nueva', 'Base de datos edicion 2', 'nuevabase@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 1),
(2, 'prueba nueva 2', 'base datos', 'prueba2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, '', '', 0),
(3, 'prueba 3', 'Nueva Base', 'prueba3@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, '', '', 0),
(4, 'Prueba4', 'Nueva Base', 'prueba4@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, '', '', 0),
(5, 'Prueba5', 'Nueva Base', 'prueba5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, '', '', 0),
(6, 'Prueba6', 'Base Nueva', 'prueba5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(7, 'Prueba6', 'Base Nueva', 'prueba5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(8, 'Prueba6', 'Base Nueva', 'prueba5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(9, 'Prueba7', 'Base NUVEA', 'prueba5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(10, 'Prueba8', 'Base NUVEA', 'prueba5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(11, 'Prueba', '11', 'prueba6@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 'jon.jpg', '588dfd1b5a3c4734e6b98446f2c5fed2.jpg', 0),
(12, 'Prueba', '9', 'prueba6@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(13, 'Prueba', 'Verifica correo', 'prrueba7@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(14, 'Prueba Verifica', 'Correo 2', 'prueba7@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(15, 'prueba Verifica', 'Correo 3', 'prueba8@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(16, 'Prueba', 'Video', 'prueba9@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(17, 'Prueba', 'login', '123@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(18, 'Prueba', 'MD5', 'pruebamd5@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(19, 'Prueba', 'Imagen', 'pruebaimagen@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 'test3.png', 'ec750ede216bf919bce372a307796ef7.png', 0),
(20, 'imagen', 'b6 imagen', 'pruebab6@gmail.com', '25d55ad283aa400af464c76d713c07ad', 2, 'test4.jpg', '898d080ceb567838e9363e65f42fee2f.jpg', 0),
(21, 'prueba', 'correo repetido', 'prueba1000@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 'jon.jpg', '588dfd1b5a3c4734e6b98446f2c5fed2.jpg', 0),
(22, 'prueba Nuevo35', 'Nuevo', 'nuevo@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 'test3.png', 'ec750ede216bf919bce372a307796ef7.png', 0),
(23, 'prueba', 'timeout', 'timeout@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(24, 'prueba2', 'timeout', 'timeout2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(25, 'Prueba ', '22/nov', '19nov@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 0),
(26, 'Prueba 2', '18/nov', '18nov2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `total`, `status`, `fecha`) VALUES
(9, 2, 1015.00, 1, '2024-12-04 23:04:29'),
(10, 2, NULL, 1, '2024-12-04 16:36:00'),
(11, 2, NULL, 1, '2024-12-04 16:36:32'),
(12, 2, 35.00, 1, '2024-12-04 16:40:27'),
(13, 2, 60.00, 1, '2024-12-04 17:15:58'),
(14, 2, 3097.00, 1, '2024-12-04 17:16:24'),
(15, 2, 170.00, 1, '2024-12-04 17:28:24'),
(16, 2, 1199.00, 1, '2024-12-05 00:42:05'),
(17, 2, 899.00, 1, '2024-12-04 17:48:11'),
(18, 2, 64.00, 1, '2024-12-04 18:16:57'),
(19, 2, 1199.00, 1, '2024-12-04 18:25:19'),
(20, 2, 48.00, 1, '2025-01-22 09:08:56'),
(21, 2, 1079.00, 1, '2025-01-23 04:34:29'),
(22, 2, 100.00, 0, '2025-01-22 21:48:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_productos`
--

CREATE TABLE `pedidos_productos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_productos`
--

INSERT INTO `pedidos_productos` (`id`, `pedido_id`, `producto_id`, `cantidad`, `subtotal`) VALUES
(22, 9, 7, 1, 999.00),
(23, 10, 9, 1, 1199.00),
(24, 10, 8, 1, 899.00),
(25, 11, 8, 1, 899.00),
(26, 12, 2, 1, 35.00),
(27, 13, 6, 1, 60.00),
(28, 14, 7, 1, 999.00),
(29, 14, 9, 1, 1199.00),
(30, 14, 8, 1, 899.00),
(31, 15, 2, 2, 70.00),
(32, 15, 5, 2, 100.00),
(34, 16, 9, 1, 1199.00),
(35, 17, 8, 1, 899.00),
(36, 18, 1, 1, 48.00),
(37, 18, 3, 1, 16.00),
(38, 19, 9, 1, 1199.00),
(39, 20, 4, 1, 48.00),
(40, 21, 6, 3, 180.00),
(41, 21, 8, 1, 899.00),
(42, 22, 10, 1, 100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `codigo` varchar(32) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` double NOT NULL,
  `stock` int(11) NOT NULL,
  `archivo_n` varchar(128) NOT NULL,
  `archivo` varchar(128) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `codigo`, `descripcion`, `costo`, `stock`, `archivo_n`, `archivo`, `eliminado`) VALUES
(1, 'Leche fresa', '1', 'Leche alpura de fresa', 48, 15, 'leche.jpg', 'fad1e405b077adc87cbcb98f9f65bb2f.jpg', 0),
(2, 'Chokis', '2', 'Caja de galletas chokis', 35, 10, 'chokis.jfif', '9d67fee49130ed2b5f882fd14c76a009.jfif', 0),
(3, 'Mini Chokis', '3', 'Sobre de mini chokis', 16, 25, 'mini_chokis.jfif', '594becebe75b4ea5456eee30e3b8ef0c.jfif', 0),
(4, 'Leche chocolate', '4', 'Leche alpura de chocolate', 48, 15, 'leche_chocolate.jfif', '041bbd545a31bd252956517e9856c8fa.jfif', 0),
(5, 'Agua', '5', 'Garrafón de agua', 50, 15, 'agua.jfif', 'd7a2ee03edf53b33d92de484c1d9038b.jfif', 0),
(6, 'Cafe', '6', 'Café Nescafé', 60, 15, 'cafe2.jfif', '7c90dc303f3f45c575471d7de81534bc.jfif', 0),
(7, 'Teclado Gamer', '7', 'Teclado RAZER ', 999, 10, 'teclado.jpg', '208752faa4f9ba70a87e4fc25417f495.jpg', 0),
(8, 'Mouse Gamer', '8', 'Mouse gamer razer', 899, 20, 'mouse.jpg', '8ab5119bfbdeba415a118671274d6e35.jpg', 0),
(9, 'Micrófono Gamer', '9', 'Micrófono HyperX', 1199, 15, 'microfono.jpg', 'be770630976c8843241a9018be650d86.jpg', 0),
(10, 'carro control remoto', '10', 'carro control remoto rojo', 100, 10, 'carro.jpg', 'c4a5f306e78411cd8010c794c409952d.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `archivo` varchar(64) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nombre`, `archivo`, `eliminado`) VALUES
(1, 'Café con sobres y taza conmemorativa', '5f9c6612ec85413ee85ed0b7bf3068ab.JPG', 1),
(2, 'kit gamer', '9222e587114afb5165bae3ae0baa0252.jpg', 1),
(3, 'Kiit de leche ', '841372aef32c0ad72bb3821fa478a686.jpg', 1),
(4, 'Kit de galletas', 'd32828f2ce8dc4190cdecb53b5d3f5ca.png', 1),
(5, 'Meses ', '8f275d2e2fd611d382811ffabe20674d.png', 0),
(6, 'hotsale', '8a98ef54b83e33b8f76dfa49ace105ce.jpg', 0),
(7, 'descuento', 'd74892f6d6548fa39ff3c41d3c761321.jpg', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD CONSTRAINT `pedidos_productos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `pedidos_productos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
