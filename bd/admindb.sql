-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2025 a las 01:04:35
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
-- Base de datos: `admindb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `telefono`, `email`, `contrasena`) VALUES
(1, 'Empresa XYZ S.A.', 'Calle Falsa 123', '3001234567', 'contacto@xyz.com', '123'),
(2, 'Juan Pérez', 'Carrera 45 #67-89', '3107654321', 'juan.perez@gmail.com', ''),
(3, 'Distribuidora ABC', 'Av. Siempre Viva 742', '3129876543', 'ventas@abc.com', ''),
(4, 'ale', 'calle 11 2-52 centro historico', '31268777', 'ale@gmail.com', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_emision` datetime NOT NULL DEFAULT current_timestamp(),
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `estado` enum('pendiente','emitida','pagada','cancelada') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `cliente_id`, `usuario_id`, `fecha_emision`, `subtotal`, `total`, `estado`) VALUES
(1, 1, 1, '2025-05-10 16:40:37', 4500.00, 4500.00, 'emitida'),
(2, 2, 2, '2025-05-10 16:40:37', 10000.00, 10000.00, 'pendiente'),
(3, 3, 1, '2025-05-10 16:40:37', 3000.00, 3000.00, 'pagada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_items`
--

CREATE TABLE `factura_items` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` decimal(10,3) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `factura_items`
--

INSERT INTO `factura_items` (`id`, `factura_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 10, 1.500, 3000.00),
(2, 1, 11, 1.000, 2000.00),
(3, 2, 11, 5.000, 2000.00),
(4, 3, 10, 1.000, 3000.00);

--
-- Disparadores `factura_items`
--
DELIMITER $$
CREATE TRIGGER `trg_validate_insert_item` BEFORE INSERT ON `factura_items` FOR EACH ROW BEGIN
  DECLARE tp ENUM('unidad','lb');
  SELECT tipo INTO tp FROM productos WHERE id = NEW.producto_id;
  IF tp = 'unidad' THEN
    IF NEW.cantidad <> FLOOR(NEW.cantidad) OR NEW.cantidad < 1 THEN
      SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Para productos por unidad, cantidad debe ser entero ≥ 1';
    END IF;
  ELSE
    IF NEW.cantidad <= 0 THEN
      SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Para productos por libra, cantidad debe ser > 0';
    END IF;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_validate_update_item` BEFORE UPDATE ON `factura_items` FOR EACH ROW BEGIN
  DECLARE tp ENUM('unidad','lb');
  SELECT tipo INTO tp FROM productos WHERE id = NEW.producto_id;
  IF tp = 'unidad' THEN
    IF NEW.cantidad <> FLOOR(NEW.cantidad) OR NEW.cantidad < 1 THEN
      SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Para productos por unidad, cantidad debe ser entero ≥ 1';
    END IF;
  ELSE
    IF NEW.cantidad <= 0 THEN
      SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Para productos por libra, cantidad debe ser > 0';
    END IF;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(12,2) NOT NULL,
  `tipo` enum('unidad','lb') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `tipo`) VALUES
(10, 'arroz', 'arroz', 3000.00, 'lb'),
(11, 'manzanas', 'manza', 2000.00, 'unidad'),
(12, '1', '223', 1000.00, 'unidad'),
(13, 'naranja mecanica', 'una naranja mecanica', 12222.00, 'unidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'cajero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `username`, `password_hash`, `role_id`) VALUES
(1, 'Administrador del Sistema', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'Pedro Perez', 'pedroperez@gmail.com', '202cb962ac59075b964b07152d234b70', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `factura_items`
--
ALTER TABLE `factura_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura_items`
--
ALTER TABLE `factura_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `factura_items`
--
ALTER TABLE `factura_items`
  ADD CONSTRAINT `factura_items_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `factura_items_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
