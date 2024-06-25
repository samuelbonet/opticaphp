-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-06-2024 a las 09:41:07
-- Versión del servidor: 8.0.26
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `opticaphp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `derechoEsfera` decimal(4,2) DEFAULT NULL,
  `derechoCilindro` decimal(4,2) DEFAULT NULL,
  `derechoEje` int DEFAULT NULL,
  `izquierdoEsfera` decimal(4,2) DEFAULT NULL,
  `izquierdoCilindro` decimal(4,2) DEFAULT NULL,
  `izquierdoEje` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `telefono`, `derechoEsfera`, `derechoCilindro`, `derechoEje`, `izquierdoEsfera`, `izquierdoCilindro`, `izquierdoEje`) VALUES
(1, 'Samuel', '976283838', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Antonio', '976283839', -1.00, -1.25, 90, -1.50, -1.55, 85);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduadas`
--

CREATE TABLE `graduadas` (
  `id` int NOT NULL,
  `persona` enum('hombre','mujer','niños') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `numero_serie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `color` enum('negro','marron','gris','azul','verde','rojo','blanco','dorado','plateado','morado','rosa','amarillo','naranja') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tratamiento` set('antirreflejantes','endurecido','antirreflejante azul') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `cliente_id` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `graduadas`
--

INSERT INTO `graduadas` (`id`, `persona`, `numero_serie`, `color`, `tratamiento`, `cliente_id`, `precio`, `created_at`) VALUES
(1, 'hombre', '2323244', 'naranja', 'endurecido', 1, 23.00, '2024-06-23 16:36:22'),
(2, 'hombre', '232323', 'gris', 'endurecido', 1, 59.00, '2024-06-24 09:08:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sol`
--

CREATE TABLE `sol` (
  `id` int NOT NULL,
  `persona` enum('hombre','mujer','niños') COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `numero_serie` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `color` enum('negro','marron','gris','azul','verde','rojo','blanco','dorado','plateado','morado','rosa','amarillo','naranja') COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tratamiento` enum('polarizadas','progresivas') COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `cliente_id` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `sol`
--

INSERT INTO `sol` (`id`, `persona`, `numero_serie`, `color`, `tratamiento`, `cliente_id`, `precio`, `created_at`) VALUES
(1, 'hombre', '232323', 'azul', 'polarizadas', 1, 23.00, '2024-06-20 17:14:49'),
(2, 'hombre', '232321', 'negro', 'polarizadas', 2, 54.00, '2024-06-20 17:14:49'),
(3, 'hombre', '2323244', 'verde', 'progresivas', 1, 59.00, '2024-06-23 16:59:15'),
(4, 'hombre', '2323244', 'verde', 'progresivas', 1, 599.00, '2024-06-24 08:59:03'),
(5, 'hombre', '232321', 'azul', 'progresivas', 1, 59.00, '2024-06-24 09:10:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(4, 'admin', '$2y$10$.6MrOqWfioRKMX5QXWbmwupI3R0Tan0HncQ4/ySgKi8NPQBQPIinG'),
(5, 'optico1', '$2y$10$fae0ANYrHZbAgge4B4dA4umc.Zfczoj6PEHnC3px8BEqogOd5Io8W');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `graduadas`
--
ALTER TABLE `graduadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sol`
--
ALTER TABLE `sol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `graduadas`
--
ALTER TABLE `graduadas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sol`
--
ALTER TABLE `sol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sol`
--
ALTER TABLE `sol`
  ADD CONSTRAINT `sol_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
