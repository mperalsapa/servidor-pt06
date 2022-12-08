-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2022 a las 15:43:52
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pt06_marc_peral`
--
CREATE DATABASE IF NOT EXISTS `pt06_marc_peral` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pt06_marc_peral`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producte`
--

DROP TABLE IF EXISTS `producte`;
CREATE TABLE `producte` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `sn` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `input` varchar(20) NOT NULL,
  `descripcio` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producte`
--

INSERT INTO `producte` (`id`, `nom`, `model`, `sn`, `data`, `input`, `descripcio`) VALUES
(1, 'SanDisk', 'SDSSDE60-250G', 'MSIP-REM-WDT-SDSSDE60', '2022-12-02', '5V - 500mA', 'SanDisk Extreme Portable SDSSDE60-250G-G25 External 250GB Portable SED USB Type C / USB 3.1 Solid State Drive - Brand New. The rugged SanDisk® Extreme Portable SSD delivers high-speed transfers with up to 550MB/s read speeds. This makes it perfect for saving and editing hi-res photos and videos. With an IP55 rating, it also stands up to rain, splashes, spills and dust.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `producte`
--
ALTER TABLE `producte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_serial_number` (`sn`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `producte`
--
ALTER TABLE `producte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
