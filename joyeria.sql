-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-06-2026 a las 14:02:34
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
-- Base de datos: `joyeria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(5, 'Anillos', NULL),
(6, 'Pendientes', NULL),
(7, 'Collares', NULL),
(8, 'Pulseras', NULL),
(9, 'Piezas exclusivas', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(31, 26, 38, 1, 59.95),
(32, 27, 41, 1, 42.95);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_destinatario` varchar(150) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `pais` varchar(100) DEFAULT 'España',
  `telefono` varchar(20) DEFAULT NULL,
  `principal` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `id_usuario`, `nombre_destinatario`, `direccion`, `ciudad`, `provincia`, `codigo_postal`, `pais`, `telefono`, `principal`) VALUES
(1, 2, '', 'Calle Mayor 10', 'Madrid', 'Madrid', '28001', 'España', NULL, 1),
(2, 2, '', 'Avenida Europa 25', 'Madrid', 'Madrid', '28023', 'España', NULL, 0),
(3, 2, '', 'Calle Serrano 120', 'Madrid', 'Madrid', '28006', 'España', NULL, 0),
(4, 3, '', 'Calle Colón 15', 'Valencia', 'Valencia', '46004', 'España', NULL, 1),
(5, 3, '', 'Avenida del Puerto 88', 'Valencia', 'Valencia', '46024', 'España', NULL, 0),
(6, 3, '', 'Calle San Vicente 42', 'Valencia', 'Valencia', '46002', 'España', NULL, 0),
(7, 4, '', 'Calle Sierpes 18', 'Sevilla', 'Sevilla', '41004', 'España', NULL, 1),
(8, 4, '', 'Avenida de la Buhaira 12', 'Sevilla', 'Sevilla', '41018', 'España', NULL, 0),
(9, 4, '', 'Calle Betis 35', 'Sevilla', 'Sevilla', '41010', 'España', NULL, 0),
(10, 5, '', 'Plaza Circular 7', 'Murcia', 'Murcia', '30008', 'España', NULL, 1),
(11, 5, '', 'Avenida Juan Carlos I 55', 'Murcia', 'Murcia', '30009', 'España', NULL, 0),
(12, 5, '', 'Calle Trapería 22', 'Murcia', 'Murcia', '30001', 'España', NULL, 0),
(13, 6, '', 'Calle Castaños 14', 'Alicante', 'Alicante', '03001', 'España', NULL, 1),
(14, 6, '', 'Avenida de Denia 90', 'Alicante', 'Alicante', '03016', 'España', NULL, 0),
(15, 6, '', 'Calle Pintor Sorolla 8', 'Alicante', 'Alicante', '03003', 'España', NULL, 0),
(16, 7, '', 'Calle Mayor 12', 'Alicante', 'Alicante', '03001', 'España', NULL, 1),
(17, 8, '', 'Avenida Libertad 34', 'Elche', 'Alicante', '03201', 'España', NULL, 1),
(18, 9, '', 'Calle Sol 8', 'Elda', 'Alicante', '03600', 'España', NULL, 1),
(19, 10, '', 'Calle Jardín 15', 'Petrer', 'Alicante', '03610', 'España', NULL, 1),
(20, 11, '', 'Avenida Constitución 21', 'Novelda', 'Alicante', '03660', 'España', NULL, 1),
(21, 12, '', 'Calle San Juan 7', 'Aspe', 'Alicante', '03680', 'España', NULL, 1),
(22, 13, '', 'Calle Cervantes 18', 'Monóvar', 'Alicante', '03640', 'España', NULL, 1),
(23, 14, '', 'Plaza España 3', 'Villena', 'Alicante', '03400', 'España', NULL, 1),
(24, 15, '', 'Calle Iglesia 22', 'Pinoso', 'Alicante', '03650', 'España', NULL, 1),
(25, 16, '', 'Avenida Rey Juan Carlos I 40', 'Crevillente', 'Alicante', '03330', 'España', NULL, 1),
(26, 1, 'Admin prueba', 'Calle Antonio Pascual Quiles 12', 'Elche', 'Comunidad Valenciana', '03205', 'España', '618636923', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `id_imagen` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagenes_producto`
--

INSERT INTO `imagenes_producto` (`id_imagen`, `id_producto`, `imagen`, `fecha_subida`) VALUES
(5, 26, 'img/productos/1780649400_Anillo Aurora 2.png', '2026-06-05 08:50:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagado','enviado','cancelado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `id_direccion`, `fecha_pedido`, `total`, `estado`) VALUES
(1, 2, 1, '2026-06-05 12:25:03', 45.00, 'pendiente'),
(2, 3, 4, '2026-06-05 12:25:03', 83.00, 'pagado'),
(3, 4, 7, '2026-06-05 12:25:03', 52.00, 'enviado'),
(4, 5, 10, '2026-06-05 12:25:03', 95.00, ''),
(5, 6, 13, '2026-06-05 12:25:03', 152.00, 'pagado'),
(6, 7, 16, '2026-06-05 13:42:32', 59.95, 'pendiente'),
(7, 8, 17, '2026-06-05 13:42:32', 34.95, 'pagado'),
(8, 9, 18, '2026-06-05 13:42:32', 64.95, 'enviado'),
(9, 10, 19, '2026-06-05 13:42:32', 42.95, ''),
(10, 11, 20, '2026-06-05 13:42:32', 95.00, 'pagado'),
(11, 12, 21, '2026-06-05 13:42:32', 120.00, 'pendiente'),
(12, 13, 22, '2026-06-05 13:42:32', 52.00, ''),
(13, 14, 23, '2026-06-05 13:42:32', 83.00, 'enviado'),
(14, 15, 24, '2026-06-05 13:42:32', 45.00, 'pagado'),
(15, 16, 25, '2026-06-05 13:42:32', 152.00, ''),
(16, 7, 16, '2026-06-05 13:45:00', 59.95, 'pendiente'),
(17, 8, 17, '2026-06-05 13:45:00', 34.95, 'pagado'),
(18, 9, 18, '2026-06-05 13:45:00', 64.95, 'enviado'),
(19, 10, 19, '2026-06-05 13:45:00', 42.95, 'pendiente'),
(20, 11, 20, '2026-06-05 13:45:00', 95.00, 'pagado'),
(21, 12, 21, '2026-06-05 13:45:00', 120.00, 'pendiente'),
(22, 13, 22, '2026-06-05 13:45:00', 52.00, ''),
(23, 14, 23, '2026-06-05 13:45:00', 83.00, 'enviado'),
(24, 15, 24, '2026-06-05 13:45:00', 45.00, 'cancelado'),
(25, 16, 25, '2026-06-05 13:45:00', 152.00, ''),
(26, 1, 26, '2026-06-05 15:34:44', 59.95, 'enviado'),
(27, 1, 26, '2026-06-07 11:18:35', 42.95, 'enviado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piedras`
--

CREATE TABLE `piedras` (
  `id_piedra` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `piedras`
--

INSERT INTO `piedras` (`id_piedra`, `nombre`, `descripcion`) VALUES
(7, 'Amatista', NULL),
(8, 'Cuarzo rosa', NULL),
(9, 'Ónix', NULL),
(10, 'Labradorita', NULL),
(11, 'Turquesa', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `exclusivo` tinyint(1) DEFAULT 0,
  `limite_reservas` int(11) DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `id_piedra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `imagen`, `stock`, `exclusivo`, `limite_reservas`, `id_categoria`, `activo`, `fecha_creacion`, `id_piedra`) VALUES
(26, '1', '1', 12.00, 'img/productos/1780649393_Anillo Aurora.png', 1, 0, 0, 5, 0, '2026-06-05 10:07:00', 7),
(30, '', '', 0.00, 'anillo-aurora.jpg', NULL, 1, 3, 9, 0, '2026-06-05 10:07:00', 10),
(32, 'Anillo Luna', 'Anillo artesanal de plata con amatista.', 45.00, 'img/productos/1780652109_Anillo Luna.png', 10, 0, 0, 5, 1, '2026-06-05 11:34:31', 7),
(33, 'Pendientes Alba', 'Pendientes de plata con cuarzo rosa.', 38.00, 'img/productos/1780652154_Pendientes Alba.png', 8, 0, 0, 6, 1, '2026-06-05 11:34:31', 8),
(34, 'Collar Noche', 'Collar artesanal con ónix.', 52.00, 'img/productos/1780652138_Collar noche.png', 5, 0, 0, 7, 1, '2026-06-05 11:34:31', 9),
(35, 'Pulsera Mar', 'Pulsera con turquesa natural.', 32.00, 'img/productos/1780652180_Pulsera mar.png', 12, 0, 0, 8, 1, '2026-06-05 11:34:31', 11),
(36, 'Anillo Exclusivo Aurora', 'Pieza única de plata con labradorita.', 95.00, 'img/productos/1780652097_Anillo Aurora.png', 1, 1, 3, 9, 1, '2026-06-05 11:34:31', 10),
(37, 'Collar Exclusivo Eclipse', 'Collar exclusivo hecho a mano.', 120.00, 'img/productos/1780652126_Collar Eclipse.png', 1, 1, 2, 9, 1, '2026-06-05 11:34:31', 9),
(38, 'Anillo Boreal', 'Anillo de plata de ley con labradorita natural.', 59.95, 'img/productos/1780656868_Anillo boreal.png', 5, 0, 0, 5, 1, '2026-06-05 12:46:27', 10),
(39, 'Pendientes Estrella', 'Pendientes minimalistas de plata con amatista.', 34.95, 'img/productos/1780657241_Pendientes Estrella.png', 10, 0, 0, 6, 1, '2026-06-05 12:46:27', 7),
(40, 'Collar Aurora', 'Collar artesanal de plata con cuarzo rosa.', 64.95, 'img/productos/1780657223_Collar aura.png', 4, 0, 0, 7, 1, '2026-06-05 12:46:27', 8),
(41, 'Pulsera Eclipse', 'Pulsera de plata oxidada con ónix.', 42.95, 'img/productos/1780657260_Pulsera eclipse.png', 6, 0, 0, 8, 1, '2026-06-05 12:46:27', 9),
(42, 'Anillo Nebula', 'Pieza exclusiva realizada a mano con turquesa.', 115.00, 'img/productos/1780656989_anillo nebula.png', 1, 1, 4, 9, 1, '2026-06-05 12:46:27', 11),
(43, 'Colgante Celeste', 'Colgante exclusivo de plata con amatista tallada.', 135.00, 'img/productos/1780657189_Colgante celeste.png', 1, 1, 2, 9, 1, '2026-06-05 12:46:27', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha_reserva` datetime DEFAULT current_timestamp(),
  `estado` enum('activa','pendiente_pago','completada','cancelada') NOT NULL DEFAULT 'activa',
  `fecha_limite_pago` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_producto`, `fecha_reserva`, `estado`, `fecha_limite_pago`) VALUES
(5, 2, 30, '2026-06-05 10:08:05', 'pendiente_pago', '2026-06-07 11:50:29'),
(6, 3, 30, '2026-06-05 10:08:05', 'cancelada', NULL),
(14, 1, 37, '2026-06-05 11:50:07', 'activa', NULL),
(15, 1, 42, '2026-06-07 10:57:20', 'completada', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('user','admin') DEFAULT 'user',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `email`, `password`, `rol`, `fecha_registro`, `activo`) VALUES
(1, 'Admin', 'Principal', 'admin@joyeria.com', '$2y$10$AB2Vgw1UcYpk95sLPD56dO8FeNt9Q4/hM9pOLUKrM.r3qgIeFj2Jq', 'admin', '2026-03-30 20:44:38', 1),
(2, 'Ana', 'Martinez', 'ana@test.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 09:56:39', 1),
(3, 'Carlos', 'Lopez', 'carlos@test.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 09:56:39', 1),
(4, 'Lucia', 'Garcia', 'lucia@test.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 09:56:39', 1),
(5, 'David', 'Sanchez', 'david@test.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 09:56:39', 1),
(6, 'Maria', 'Fernandez', 'maria@test.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 09:56:39', 1),
(7, 'Javier', 'Moreno López', 'javier@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(8, 'Marta', 'Serrano Ruiz', 'marta@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(9, 'Pablo', 'Gil Torres', 'pablo@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(10, 'Laura', 'Navarro Pérez', 'laura@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(11, 'Sergio', 'Martín Gómez', 'sergio@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(12, 'Elena', 'Vega Ramos', 'elena@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(13, 'Raúl', 'Cano Ortiz', 'raul@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(14, 'Sara', 'Ibáñez León', 'sara@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(15, 'Miguel', 'Fuentes Díaz', 'miguel@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1),
(16, 'Andrea', 'Campos Vidal', 'andrea@joyeria.com', '$2y$10$GpEvN0dbEivb8TcGRFYz2uOmSVB.sf4/JXJuycNvOobcYKsR.DCxu', 'user', '2026-06-05 13:30:14', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `idx_detalle_pedido` (`id_pedido`),
  ADD KEY `idx_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `idx_direcciones_usuario` (`id_usuario`);

--
-- Indices de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `idx_pedidos_usuario` (`id_usuario`),
  ADD KEY `idx_pedidos_direccion` (`id_direccion`);

--
-- Indices de la tabla `piedras`
--
ALTER TABLE `piedras`
  ADD PRIMARY KEY (`id_piedra`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_productos_categoria` (`id_categoria`),
  ADD KEY `idx_productos_piedra` (`id_piedra`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD UNIQUE KEY `unique_reserva_usuario_producto` (`id_usuario`,`id_producto`),
  ADD KEY `idx_reservas_usuario` (`id_usuario`),
  ADD KEY `idx_reservas_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `piedras`
--
ALTER TABLE `piedras`
  MODIFY `id_piedra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_direcciones_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_direccion` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_piedra` FOREIGN KEY (`id_piedra`) REFERENCES `piedras` (`id_piedra`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reservas_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
