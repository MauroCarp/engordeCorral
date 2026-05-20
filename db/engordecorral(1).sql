-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-05-2026 a las 02:51:32
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `engordecorral`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('engordecorral_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1779242906;', 1779242906),
('engordecorral_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1779242906);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

DROP TABLE IF EXISTS `insumos`;
CREATE TABLE IF NOT EXISTS `insumos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insumo` varchar(150) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `precio` float NOT NULL,
  `porceMS` int NOT NULL,
  `DMS` int DEFAULT NULL,
  `EE` int DEFAULT NULL,
  `Pr` int DEFAULT NULL,
  `PBa` int DEFAULT NULL,
  `PBb` int DEFAULT NULL,
  `H` int DEFAULT NULL,
  `NIDA` int DEFAULT NULL,
  `EM` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id`, `insumo`, `tipo`, `precio`, `porceMS`, `DMS`, `EE`, `Pr`, `PBa`, `PBb`, `H`, `NIDA`, `EM`, `created_at`, `updated_at`) VALUES
(1, 'Alfalfa prefloracion', 'FORRAJES FRESCOS', 2.5, 20, 67, 2, 24, 39, 44, 15, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Alfalfa pura, 10% de floracion', 'FORRAJES FRESCOS', 0, 22, 64, 2, 22, 25, 55, 15, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Alfalfa pura, 50% de floracion', 'FORRAJES FRESCOS', 0, 24, 62, 2, 19, 18, 61, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Alfalfa pura, 100% de floracion', 'FORRAJES FRESCOS', 0, 26, 59, 2, 16, 14, 60, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Gramineas templadas (65-70 DMS)', 'FORRAJES FRESCOS', 0, 20, 67, 2, 17, 34, 56, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Gramineas templadas (60-65 DMS)', 'FORRAJES FRESCOS', 0, 22, 63, 2, 15, 28, 57, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Gramineas templadas (57-60 DMS)', 'FORRAJES FRESCOS', 0, 25, 59, 2, 12, 16, 57, 8, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Gramineas megat alta cal(62-DMS)', 'FORRAJES FRESCOS', 0, 24, 65, 2, 12, 28, 59, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Gram Megat med calidad(59%DMS)', 'FORRAJES FRESCOS', 0, 26, 61, 2, 10, 22, 58, 8, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Gram Megatermica Dif(56 % DMS)', 'FORRAJES', 1, 80, 57, 2, 8, 16, 57, 8, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Verdeos invernales primer corte', 'FORRAJES FRESCOS', 0, 20, 66, 2, 20, 34, 57, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Verdeos invernales último corte', 'FORRAJES FRESCOS', 0, 24, 60, 2, 16, 38, 57, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Heno Alfalfa prefloracion', 'HENOS', 0, 85, 63, 2, 20, 25, 65, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Heno Alfalfa pura, 10% floracion', 'HENOS', 0, 85, 60, 2, 18, 20, 69, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Heno Alfalfa pura, 50% de floracion', 'HENOS', 0, 85, 58, 2, 15, 16, 71, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Heno Alfalfa pura, 100% de floracion', 'HENOS', 0, 85, 55, 2, 12, 12, 74, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Heno Moha vegetativo', 'HENOS', 0, 85, 60, 2, 10, 5, 70, 9, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Heno Moha grano pastoso', 'HENOS', 0, 85, 56, 1, 7, 4, 68, 7, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Cascara de Girasol', 'HENOS', 0, 90, 0, 2, 4, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Silaje Alfalfa, 10% floracion', 'SILAJES', 0, 34, 62, 3, 20, 66, 25, 17, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Silaje Alfalfa, 50% floracion ', 'SILAJES', 0, 34, 60, 3, 17, 60, 32, 17, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Silaje Maiz Bajo Grano', 'SILAJES', 10, 35, 60, 3, 8, 66, 19, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Silaje Maiz Medio Grano', 'SILAJES', 10, 35, 63, 3, 8, 66, 19, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Silaje Maiz Alto Grano', 'SILAJES', 0, 35, 66, 3, 8, 66, 19, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'Silaje Maiz Muy Alto Grano', 'SILAJES', 0, 35, 70, 3, 8, 66, 19, 10, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'Silaje Sorgo Granifero Bajo Grano', 'SILAJES', 0, 32, 55, 2, 8, 55, 28, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'Silaje Sorgo Granifero Medio Grano', 'SILAJES', 0, 32, 58, 2, 8, 55, 28, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Silaje Sorgo Granifero Alto Grano', 'SILAJES', 0, 32, 61, 3, 8, 55, 28, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'Silaje Sorgo Gra. Muy Alto Grano', 'SILAJES', 0, 32, 64, 3, 8, 55, 28, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'Silaje Sorgo forrajero tierno', 'SILAJES', 0, 28, 60, 2, 8, 60, 26, 14, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Silaje sorgo forrajero maduro ', 'SILAJES', 0, 28, 57, 2, 7, 55, 28, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'Silaje de cebada', 'SILAJES', 0, 39, 60, 2, 12, 60, 24, 10, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'Gluten feed pellet', 'CONCENTRADOS (C)', 0, 89, 78, 2, 23, 25, 65, 4, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'Gluten feed humedo', 'CONCENTRADOS (C)', 0, 45, 78, 2, 23, 49, 26, 12, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'Permeado de suero ', 'CONCENTRADOS (C)', 0, 18, 100, 0, 3, 100, 0, 0, 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'Urea', 'CONCENTRADOS (C)', 631, 98, 0, 0, 287, 100, 0, 0, 0, 0, '0000-00-00 00:00:00', '2026-05-12 05:50:31'),
(70, 'Algodon  expeller', 'CONCENTRADOS (C)', 0, 89, 74, 2, 37, 24, 76, 5, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'Girasol expeller', 'CONCENTRADOS (C)', 0, 89, 64, 3, 38, 30, 50, 12, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'Soja expeller', 'CONCENTRADOS (C)', 477, 89, 88, 2, 47, 20, 45, 11, 0, 3, '0000-00-00 00:00:00', '2026-05-12 05:50:17'),
(67, 'Soja grano ', 'CONCENTRADOS (C)', 34.2, 87, 88, 18, 36, 44, 31, 12, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'Pulpa de citricos', 'CONCENTRADOS (C)', 0, 92, 84, 4, 7, 41, 56, 6, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'Afrechillo de trigo', 'CONCENTRADOS (C)', 0, 88, 70, 4, 17, 30, 47, 12, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'Algodón semilla', 'CONCENTRADOS (C)', 0, 88, 88, 21, 21, 40, 30, 8, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'Trigo grano', 'CONCENTRADOS (C)', 0, 86, 90, 2, 13, 42, 54, 38, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'Cebada grano', 'CONCENTRADOS (C)', 0, 86, 84, 2, 13, 25, 70, 35, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'Avena grano', 'CONCENTRADOS (C)', 0, 86, 77, 5, 13, 39, 56, 33, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'Sorgo grano', 'CONCENTRADOS', 6.5, 87, 80, 3, 11, 12, 39, 6, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'Maiz Grano', 'CONCENTRADOS (C)', 260, 87, 88, 4, 10, 16, 35, 7, 0, 3, '0000-00-00 00:00:00', '2026-05-12 05:50:03'),
(75, 'Silaje Maiz grano humedo', 'CONCENTRADOS (C)', 0, 75, 89, 4, 10, 50, 31, 10, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'Silaje Sorgo grano húmedo', 'CONCENTRADOS (C)', 0, 72, 83, 3, 11, 57, 27, 8, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'Girasol expeller baja proteina', 'CONCENTRADOS (C)', 0, 89, 64, 3, 25, 30, 50, 12, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 'Orujo de  Uva', 'CONCENTRADOS (C)', 0, 90, 28, 7, 11, 0, 0, 0, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 'Premezcla Vit. Min. Con Monensina', 'Premix', 6, 99, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 'Agua', 'LIQUIDO', 0.1, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 'Ingreso s/atb', 'Premix', 90.2132, 88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'Ingreso C/ATB', 'Premix', 200, 99, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 'Terminacion', 'Premix', 74.2634, 99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 'Recria', 'Premix', 74.2634, 99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 'Cascara de Mani', 'Fibra', 80, 90, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '2026-05-12 05:49:30'),
(95, 'Insumo 1 ', 'SILAJES', 5, 50, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 'Gram Megat muy alta cal (65%DMS)', 'FORRAJES', 0, 22, NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 'Suplemento 1', 'Premix', 213.963, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 'Prueba', 'Premix', 1.5, 35, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-12 05:04:02', '2026-05-12 05:04:02'),
(99, 'Nucleo', 'CONCENTRADOS (C)', 1015, 99, 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-12 05:40:55', '2026-05-12 05:50:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_13_192325_create_modelos_table', 1),
(5, '2026_04_14_115528_create_dietas_table', 2),
(6, '2026_04_14_115528_create_insumos_table', 2),
(7, '2026_04_14_115529_create_racions_table', 2),
(8, '2026_04_19_000000_create_sanidad_estructuras_table', 2),
(9, '2026_04_19_000001_create_motivo_sanidad_estructuras_table', 3),
(10, '2026_05_11_130000_update_racions_table_for_composition_arrays', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

DROP TABLE IF EXISTS `modelos`;
CREATE TABLE IF NOT EXISTS `modelos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dieta_json` json DEFAULT NULL,
  `precio_venta_faena` decimal(10,2) NOT NULL COMMENT 'Precio venta a faena ($/kg)',
  `precio_compra_ternero` decimal(10,2) NOT NULL COMMENT 'Precio compra terneras/os destete ($/kg)',
  `precio_alimento_balanceado` decimal(10,2) NOT NULL COMMENT 'Precio tal cual alimento balanceado ($/kg)',
  `peso_neto_entrada` decimal(8,2) NOT NULL COMMENT 'Peso neto de entrada (kg)',
  `peso_neto_venta` decimal(8,2) NOT NULL COMMENT 'Peso neto venta (kg)',
  `mortandad` decimal(5,4) NOT NULL COMMENT 'Mortandad (ej: 0.01 = 1%)',
  `consumo_promedio_ms` decimal(5,4) NOT NULL COMMENT 'Consumo promedio MS en terminación (% PV)',
  `eficiencia_conversion` decimal(5,2) NOT NULL COMMENT 'Eficiencia conversión (kg MS/kg ganado)',
  `cabezas_jaula_terneros` int NOT NULL COMMENT 'Cabezas/jaula (Terneros/as)',
  `cabezas_jaula_gordos` int NOT NULL COMMENT 'Cabezas/jaula (Gordos/as)',
  `flete_compra_km` decimal(10,2) NOT NULL COMMENT 'Flete compra (km)',
  `flete_venta_km` decimal(10,2) NOT NULL COMMENT 'Flete venta (km)',
  `flete_compra_venta_precio` decimal(10,2) NOT NULL COMMENT 'Flete compra-venta - precio ($/km)',
  `gastos_compra` decimal(5,4) NOT NULL COMMENT 'Gastos de compra (ej: 0.03 = 3%)',
  `gastos_venta` decimal(5,4) NOT NULL COMMENT 'Gastos de venta (ej: 0.03 = 3%)',
  `tasa_anual` decimal(5,4) NOT NULL COMMENT 'Tasa anual (ej: 0.25 = 25%)',
  `plazo_compra_hacienda` int NOT NULL COMMENT 'Plazo compra hacienda (días)',
  `plazo_venta_hacienda` int NOT NULL COMMENT 'Plazo venta hacienda (días)',
  `dias_financiamiento_alimento` int NOT NULL COMMENT 'Días de financiamiento alimento',
  `capacidad_estructura` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `dieta_json`, `precio_venta_faena`, `precio_compra_ternero`, `precio_alimento_balanceado`, `peso_neto_entrada`, `peso_neto_venta`, `mortandad`, `consumo_promedio_ms`, `eficiencia_conversion`, `cabezas_jaula_terneros`, `cabezas_jaula_gordos`, `flete_compra_km`, `flete_venta_km`, `flete_compra_venta_precio`, `gastos_compra`, `gastos_venta`, `tasa_anual`, `plazo_compra_hacienda`, `plazo_venta_hacienda`, `dias_financiamiento_alimento`, `capacidad_estructura`, `created_at`, `updated_at`) VALUES
(1, 'Modelo General 2026', '[{\"racion_id\": 2, \"porcentaje\": 100}]', '5200.00', '6500.00', '196.00', '160.00', '380.00', '0.0100', '0.0300', '7.00', 65, 50, '600.00', '70.00', '3737.00', '0.0300', '0.0300', '0.2500', 30, 10, 60, 4000, '2026-04-23 00:22:12', '2026-04-23 00:22:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_sanidad_estructuras`
--

DROP TABLE IF EXISTS `motivo_sanidad_estructuras`;
CREATE TABLE IF NOT EXISTS `motivo_sanidad_estructuras` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `motivo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `motivo_sanidad_estructuras`
--

INSERT INTO `motivo_sanidad_estructuras` (`id`, `motivo`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Antibiotico', 'sanidad', '2026-04-20 04:20:46', '2026-04-20 04:20:46'),
(2, 'Antiparasitario', 'sanidad', '2026-04-20 04:20:46', '2026-04-20 04:20:46'),
(3, 'Hormonas', 'sanidad', '2026-04-20 04:20:46', '2026-04-20 04:20:46'),
(4, 'Vac. Respiratoria 2 ds', 'sanidad', '2026-04-20 04:20:46', '2026-04-20 04:20:46'),
(5, 'Vac. Triple (9) 2 ds', 'sanidad', '2026-04-20 04:20:46', '2026-04-20 04:20:46'),
(6, 'tulatromicina', 'sanidad', '2026-04-20 04:20:46', '2026-04-20 04:20:46'),
(7, 'Motivo estructura', 'estructura', '2026-04-20 04:54:24', '2026-04-20 04:54:24'),
(8, 'Motivo sanidad', 'sanidad', '2026-04-20 04:54:47', '2026-04-20 04:54:47'),
(9, 'Alquiler', 'estructura', '2026-04-20 05:31:05', '2026-04-20 05:31:05'),
(10, 'Sueldos', 'estructura', '2026-04-20 05:31:30', '2026-04-20 05:31:30'),
(11, 'Combustible', 'estructura', '2026-04-20 05:31:43', '2026-04-20 05:31:43'),
(12, 'Reparaciones', 'estructura', '2026-04-20 05:31:55', '2026-04-20 05:31:55'),
(13, 'Lubricantes', 'estructura', '2026-04-20 05:32:09', '2026-04-20 05:32:09'),
(14, 'Ferreteroa', 'estructura', '2026-04-20 05:32:20', '2026-04-20 05:32:20'),
(15, 'Art. Rurales', 'estructura', '2026-04-20 05:32:30', '2026-04-20 05:32:30'),
(16, 'Internet', 'estructura', '2026-04-20 05:32:42', '2026-04-20 05:32:42'),
(17, 'Cobre', 'sanidad', '2026-04-20 05:37:48', '2026-04-20 05:37:48'),
(18, 'Otros Gastos', 'sanidad', '2026-04-20 05:39:37', '2026-04-20 05:39:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `racions`
--

DROP TABLE IF EXISTS `racions`;
CREATE TABLE IF NOT EXISTS `racions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insumos` json DEFAULT NULL,
  `porcentajes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `racions`
--

INSERT INTO `racions` (`id`, `nombre`, `insumos`, `porcentajes`, `created_at`, `updated_at`) VALUES
(2, 'Ingreso', '[93, 59, 68, 71, 99]', '[30, 64, 4, 0.8, 1.2]', '2026-05-12 05:41:04', '2026-05-12 05:41:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sanidad_estructuras`
--

DROP TABLE IF EXISTS `sanidad_estructuras`;
CREATE TABLE IF NOT EXISTS `sanidad_estructuras` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `modelo_id` tinyint NOT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_mes` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sanidad_estructuras`
--

INSERT INTO `sanidad_estructuras` (`id`, `modelo_id`, `tipo`, `motivo`, `costo_mes`, `created_at`, `updated_at`) VALUES
(13, 1, 'sanidad', 'Antiparasitario', '640.00', '2026-04-20 05:40:29', '2026-04-20 05:40:29'),
(4, 1, 'estructura', 'Sueldos', '9000000.00', '2026-04-20 05:33:51', '2026-04-20 05:33:51'),
(3, 1, 'estructura', 'Alquiler', '15000000.00', '2026-04-20 05:31:17', '2026-04-20 05:31:17'),
(5, 1, 'estructura', 'Combustible', '4000000.00', '2026-04-20 05:34:10', '2026-04-20 05:34:10'),
(6, 1, 'estructura', 'Reparaciones', '5000000.00', '2026-04-20 05:34:27', '2026-04-20 05:34:27'),
(7, 1, 'estructura', 'Lubricantes', '5000000.00', '2026-04-20 05:34:46', '2026-04-20 05:34:46'),
(8, 1, 'sanidad', 'Antibiotico', '2040.00', '2026-04-20 05:37:18', '2026-04-20 05:37:18'),
(9, 1, 'sanidad', 'Cobre', '470.00', '2026-04-20 05:38:04', '2026-04-20 05:38:04'),
(10, 1, 'sanidad', 'Vac. Respiratoria 2 ds', '1784.00', '2026-04-20 05:38:28', '2026-04-20 05:38:28'),
(11, 1, 'sanidad', 'Vac. Triple (9) 2 ds', '740.00', '2026-04-20 05:38:46', '2026-04-20 05:38:46'),
(12, 1, 'sanidad', 'Otros Gastos', '1400.00', '2026-04-20 05:39:46', '2026-04-20 05:39:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('mq6GiR5emtu5PmhsIuyUbPbU7ggoOI3khvJmGTxp', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiS3pYOXRpelBvWE5VNnViRVRsVGFhTVlNdnFTdnp0eUNtQkxiMVVtbiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4iO3M6NToicm91dGUiO3M6MzA6ImZpbGFtZW50LmFkbWluLnBhZ2VzLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjI3ODhmYjNkNGVkMzFlYTI5ZDMyOWQ3NTBmZTExNDc0Mzc1MjA4MTBiMzIxMjQyZDFjMTUxZDA2MzZiNzZjNWIiO3M6MTg6InNlbGVjdGVkX21vZGVsb19pZCI7aToxO30=', 1779244213);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jorge', 'jorge@jorge.com', NULL, '$2y$12$/12rOhp52xha5K0XO8kNfevZiFHlBb4IP0QseOdHzXSYMrrRsiGW6', 'y4ht2L1kOpKIjspGyZjHS81Xa9TzVjHPRRbDRFDVf3ObKLAhmrKkFMP4WkS1', '2026-04-20 01:42:03', '2026-04-20 01:42:03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
