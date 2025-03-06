-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2025 a las 04:36:46
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
-- Base de datos: `concesionario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id_alquiler` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `id_coche` int(10) UNSIGNED DEFAULT NULL,
  `prestado` datetime DEFAULT NULL,
  `devuelto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`id_alquiler`, `id_usuario`, `id_coche`, `prestado`, `devuelto`) VALUES
(9, 1, 11, '2025-02-11 09:09:03', NULL),
(10, 1, 1, '2025-02-11 09:57:59', '2025-02-11 10:14:09'),
(13, 1, 12, '2025-02-19 12:46:53', NULL),
(14, 4, 13, '2025-03-05 17:02:31', NULL),
(15, 4, 10, '2025-03-05 18:35:47', '2025-03-06 03:36:31'),
(16, 4, 20, '2025-03-06 04:16:09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id_coche` int(10) UNSIGNED NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `alquilado` tinyint(1) DEFAULT NULL,
  `foto` varchar(300) DEFAULT NULL,
  `id_vendedor` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id_coche`, `modelo`, `marca`, `color`, `precio`, `alquilado`, `foto`, `id_vendedor`) VALUES
(14, 's40', 'Volvo', 'GRIS', 12000, NULL, 'src/img/uploads/volvos40gris.png', 5),
(16, 'Beetle', 'Volkswagen', 'blanco', 1200, NULL, 'src/img/uploads/Volkswagenbeetle.png', 5),
(17, 'Super Deluxe', 'Ford', 'Vino', 3000, NULL, 'src/img/uploads/ford-superdeluxecoupe.png', 6),
(18, 'SL300', 'Mercedes Benz', 'Plateado', 4597, NULL, 'src/img/uploads/mercedes_sl300.png', 6),
(19, 'DKW', 'AUDI', 'Azul', 1500, NULL, 'src/img/uploads/audi_dkw.png', 6),
(20, '1936 Supercharged Speedster', 'Auburn', 'Blanco', 10550, 1, 'src/img/uploads/AuburnSuperchargedSpeedster.png', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `tipo_usuario` enum('comprador','vendedor','admin') NOT NULL DEFAULT 'comprador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `password`, `nombre`, `apellidos`, `dni`, `saldo`, `tipo_usuario`) VALUES
(2, '$2y$10$N1PJ71RPjfKI75NrSIobkes6n/TvPSC.vbw9Fh1wb1CcAqP5AwO8G', 'root', 'Administrador', '1111', 0, 'admin'),
(4, '$2y$10$/pK9SFOaZM6L9UFdcW5Ur.EN5JT9.JPel2B1WLTv7BrjL1SYv8L0q', 'astrid1', 'arenalessss', '123', 34451, 'comprador'),
(5, '$2y$10$NqSjqwTOaQRGbpsGtYts4OYVy/laRXSXeyOPV0UCZIWxZ6jM0.pgG', 'david', 'santafe', '1234', 0, 'vendedor'),
(6, '$2y$10$yEFAlTpGWKZf7mL83DfVB.44ipWto5dEn9E91NRHynT0MVCAfY7Wq', 'Elsa', 'Pato', '12345', 0, 'vendedor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`);

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id_coche`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id_coche` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
