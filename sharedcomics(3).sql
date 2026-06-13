-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2026 a las 15:30:00
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
-- Base de datos: `sharedcomics`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comics`
--

CREATE TABLE `comics` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `pdf_comic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comics`
--

INSERT INTO `comics` (`id`, `titulo`, `descripcion`, `portada`, `usuario_id`, `fecha_subida`, `pdf_comic`) VALUES
(1, 'BATMAN', 'un comic de batman', 'imagenes/comics_portada/batman.jpg', NULL, '2026-06-13 09:04:24', ''),
(2, 'Spiderman', 'un comic de spiderman', 'imagenes/comics_portada/el-asombroso-spiderman-7.jpg', NULL, '2026-06-13 09:04:24', ''),
(33, 'Dragon Ball Super Vol. 1', 'Comienza la nueva era de los Guerreros Z.', 'imagenes/comics_portada/dragonball1.jpg', NULL, '2026-06-13 09:27:58', ''),
(34, 'One Piece Vol. 100', 'Luffy y su tripulación en el clímax de Wano.', 'imagenes/comics_portada/onepiece100.jpg', NULL, '2026-06-13 09:27:58', ''),
(35, 'My Hero Academia Vol. 1', 'Un mundo donde tener superpoderes es lo normal.', 'imagenes/comics_portada/mha1.jpg', NULL, '2026-06-13 09:27:58', ''),
(36, 'Jujutsu Kaisen Vol. 0', 'La precuela de la gran historia de maldiciones.', 'imagenes/comics_portada/jujutsu0.jpg', NULL, '2026-06-13 09:27:58', ''),
(37, 'Chainsaw Man Vol. 1', 'Denji, un cazador de demonios con una motosierra.', 'imagenes/comics_portada/chainsaw1.jpg', NULL, '2026-06-13 09:27:58', ''),
(38, 'Tokyo Revengers Vol. 1', 'Viajes en el tiempo para salvar a su antigua novia.', 'imagenes/comics_portada/tokyo1.jpg', NULL, '2026-06-13 09:27:58', ''),
(39, 'Demon Slayer Vol. 1', 'Tanjiro busca una cura para su hermana Nezuko.', 'imagenes/comics_portada/demonslayer1.jpg', NULL, '2026-06-13 09:27:58', ''),
(40, 'Attack on Titan Vol. 1', 'La humanidad resiste dentro de los muros.', 'imagenes/comics_portada/aot1.jpg', NULL, '2026-06-13 09:27:58', ''),
(42, 'Death Note Vol. 1', 'Un cuaderno capaz de matar a cualquiera cuyo nombre se escriba.', 'imagenes/comics_portada/deathnote1.jpg', NULL, '2026-06-13 09:27:58', ''),
(43, 'Berserk Vol. 1', 'El viaje oscuro de Guts, el guerrero negro.', 'imagenes/comics_portada/berserk1.jpg', NULL, '2026-06-13 09:27:58', ''),
(44, 'Naruto Vol. 1', 'El inicio del camino para convertirse en Hokage.', 'imagenes/comics_portada/naruto1.jpg', NULL, '2026-06-13 09:27:58', ''),
(45, 'Bleach Vol. 1', 'Ichigo Kurosaki recibe los poderes de un Shinigami.', 'imagenes/comics_portada/bleach1.jpg', NULL, '2026-06-13 09:27:58', ''),
(46, 'Hunter x Hunter Vol. 1', 'Gon inicia el examen para convertirse en cazador.', 'imagenes/comics_portada/hunter1.jpg', NULL, '2026-06-13 09:27:58', ''),
(47, 'Fullmetal Alchemist Vol. 1', 'Dos hermanos buscan la piedra filosofal.', 'imagenes/comics_portada/fma1.jpg', NULL, '2026-06-13 09:27:58', ''),
(48, 'Batman: Año Uno', 'Los primeros pasos de Bruce Wayne como el caballero oscuro.', 'imagenes/comics_portada/batman_ano1.jpg', NULL, '2026-06-13 09:27:58', ''),
(49, 'The Amazing Spider-Man #1', 'El trepamuros comienza su patrullaje por Nueva York.', 'imagenes/comics_portada/spiderman1.jpg', NULL, '2026-06-13 09:27:58', ''),
(50, 'Watchmen', '¿Quién vigila a los vigilantes? Obra maestra del cómic.', 'imagenes/comics_portada/watchmen.jpg', NULL, '2026-06-13 09:27:58', ''),
(51, 'Saga Vol. 1', 'Una odisea espacial de una familia que busca su lugar.', 'imagenes/comics_portada/saga1.jpg', NULL, '2026-06-13 09:27:58', ''),
(52, 'The Walking Dead Vol. 1', 'Rick Grimes despierta en un mundo infestado de muertos.', 'imagenes/comics_portada/twd1.jpg', NULL, '2026-06-13 09:27:58', ''),
(53, 'Invincible Vol. 1', 'El hijo del superhéroe más poderoso descubre sus poderes.', 'imagenes/comics_portada/invincible1.jpg', NULL, '2026-06-13 09:27:58', ''),
(54, 'Black Clover Vol. 1', 'Asta busca convertirse en el Rey Mago sin tener magia.', 'imagenes/comics_portada/blackclover1.jpg', NULL, '2026-06-13 09:27:58', ''),
(55, 'Solo Leveling Vol. 1', 'El cazador más débil del mundo recibe una segunda oportunidad.', 'imagenes/comics_portada/sololeveling1.jpg', NULL, '2026-06-13 09:27:58', ''),
(56, 'Haikyuu!! Vol. 1', 'Shoyo Hinata vuela alto en la cancha de voleibol.', 'imagenes/comics_portada/haikyuu1.jpg', NULL, '2026-06-13 09:27:58', ''),
(57, 'One Punch Man Vol. 1', 'Saitama derrota a todos sus enemigos de un solo golpe.', 'imagenes/comics_portada/onepunch1.jpg', NULL, '2026-06-13 09:27:58', ''),
(58, 'Akira Vol. 1', 'Neo-Tokyo está al borde del colapso en este clásico cyberpunk.', 'imagenes/comics_portada/akira1.jpg', NULL, '2026-06-13 09:27:58', ''),
(59, 'Evangelion Vol. 1', 'Shinji Ikari debe pilotar el EVA-01 contra los Ángeles.', 'imagenes/comics_portada/evangelion1.jpg', NULL, '2026-06-13 09:27:58', ''),
(60, 'Monster Vol. 1', 'El doctor Tenma persigue al monstruo que él mismo salvó.', 'imagenes/comics_portada/monster1.jpg', NULL, '2026-06-13 09:27:58', ''),
(61, 'Kingdom Vol. 1', 'La épica unificación de la antigua China.', 'imagenes/comics_portada/kingdom1.jpg', NULL, '2026-06-13 09:27:58', ''),
(62, 'Slam Dunk Vol. 1', 'Hanamichi Sakuragi se une al equipo de baloncesto.', 'imagenes/comics_portada/slamdunk1.jpg', NULL, '2026-06-13 09:27:58', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comic_categoria`
--

CREATE TABLE `comic_categoria` (
  `comic_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE `paginas` (
  `id` int(11) NOT NULL,
  `comic_id` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `numero_pagina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paginas`
--

INSERT INTO `paginas` (`id`, `comic_id`, `ruta_imagen`, `numero_pagina`) VALUES
(1, 1, 'imagenes/paginascomics/BATMAN/pagina1.jpg', 1),
(2, 1, 'imagenes/paginascomics/BATMAN/pagina2.jpg', 2),
(3, 1, 'imagenes/paginascomics/BATMAN/pagina3.jpg', 3),
(4, 1, 'imagenes/paginascomics/BATMAN/pagina4.jpg', 4),
(5, 1, 'imagenes/paginascomics/BATMAN/pagina5.jpg', 5),
(6, 1, 'imagenes/paginascomics/BATMAN/pagina6.jpg', 6),
(7, 1, 'imagenes/paginascomics/BATMAN/pagina7.jpg', 7),
(8, 1, 'imagenes/paginascomics/BATMAN/pagina8.jpg', 8),
(9, 1, 'imagenes/paginascomics/BATMAN/pagina9.jpg', 9),
(10, 1, 'imagenes/paginascomics/BATMAN/pagina10.jpg', 10),
(11, 1, 'imagenes/paginascomics/BATMAN/pagina11.jpg', 11),
(12, 1, 'imagenes/paginascomics/BATMAN/pagina12.jpg', 12),
(13, 1, 'imagenes/paginascomics/BATMAN/pagina13.jpg', 13),
(14, 1, 'imagenes/paginascomics/BATMAN/pagina14.jpg', 14),
(15, 1, 'imagenes/paginascomics/BATMAN/pagina15.jpg', 15),
(16, 1, 'imagenes/paginascomics/BATMAN/pagina16.jpg', 16),
(17, 1, 'imagenes/paginascomics/BATMAN/pagina17.jpg', 17),
(18, 1, 'imagenes/paginascomics/BATMAN/pagina18.jpg', 18),
(19, 1, 'imagenes/paginascomics/BATMAN/pagina19.jpg', 19),
(20, 1, 'imagenes/paginascomics/BATMAN/pagina20.jpg', 20),
(21, 1, 'imagenes/paginascomics/BATMAN/pagina21.jpg', 21),
(22, 1, 'imagenes/paginascomics/BATMAN/pagina22.jpg', 22),
(23, 1, 'imagenes/paginascomics/BATMAN/pagina23.jpg', 23),
(24, 1, 'imagenes/paginascomics/BATMAN/pagina24.jpg', 24),
(25, 1, 'imagenes/paginascomics/BATMAN/pagina25.jpg', 25),
(26, 1, 'imagenes/paginascomics/BATMAN/pagina26.jpg', 26),
(27, 1, 'imagenes/paginascomics/BATMAN/pagina27.jpg', 27),
(28, 1, 'imagenes/paginascomics/BATMAN/pagina28.jpg', 28),
(29, 1, 'imagenes/paginascomics/BATMAN/pagina29.jpg', 29),
(30, 1, 'imagenes/paginascomics/BATMAN/pagina30.jpg', 30),
(31, 1, 'imagenes/paginascomics/BATMAN/pagina31.jpg', 31),
(32, 1, 'imagenes/paginascomics/BATMAN/pagina32.jpg', 32),
(33, 1, 'imagenes/paginascomics/BATMAN/pagina33.jpg', 33),
(34, 1, 'imagenes/paginascomics/BATMAN/pagina34.jpg', 34),
(35, 1, 'imagenes/paginascomics/BATMAN/pagina35.jpg', 35),
(36, 1, 'imagenes/paginascomics/BATMAN/pagina36.jpg', 36),
(37, 1, 'imagenes/paginascomics/BATMAN/pagina37.jpg', 37),
(38, 1, 'imagenes/paginascomics/BATMAN/pagina38.jpg', 38),
(39, 1, 'imagenes/paginascomics/BATMAN/pagina39.jpg', 39),
(40, 1, 'imagenes/paginascomics/BATMAN/pagina40.jpg', 40),
(41, 1, 'imagenes/paginascomics/BATMAN/pagina41.jpg', 41),
(42, 1, 'imagenes/paginascomics/BATMAN/pagina42.jpg', 42),
(43, 1, 'imagenes/paginascomics/BATMAN/pagina43.jpg', 43),
(44, 1, 'imagenes/paginascomics/BATMAN/pagina44.jpg', 44),
(45, 1, 'imagenes/paginascomics/BATMAN/pagina45.jpg', 45),
(46, 1, 'imagenes/paginascomics/BATMAN/pagina46.jpg', 46),
(47, 1, 'imagenes/paginascomics/BATMAN/pagina47.jpg', 47),
(48, 1, 'imagenes/paginascomics/BATMAN/pagina48.jpg', 48),
(49, 1, 'imagenes/paginascomics/BATMAN/pagina49.jpg', 49),
(50, 1, 'imagenes/paginascomics/BATMAN/pagina50.jpg', 50),
(51, 1, 'imagenes/paginascomics/BATMAN/pagina51.jpg', 51),
(52, 1, 'imagenes/paginascomics/BATMAN/pagina52.jpg', 52),
(53, 1, 'imagenes/paginascomics/BATMAN/pagina53.jpg', 53);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `fecha_registro`) VALUES
(9, 'manolo', 'manololama@gmail.com', '$2y$10$8XMOBKMnYHoICTzFofW0iOdl44RmZXWLRyuri6WqBqxnGNIMy29xu', '2026-06-12 17:24:17'),
(10, 'prueba', 'prueba@prueba.es', '$2y$10$gzRbPgAqUBuSAAcFiQmsEuDjfcZxUpW/KBkOMz3sPM6QtAAfxjLJa', '2026-06-13 10:18:27');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_completa_sharedcomics`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_completa_sharedcomics` (
`comic_id` int(11)
,`comic_titulo` varchar(150)
,`comic_descripcion` text
,`comic_portada` varchar(255)
,`comic_pdf` varchar(255)
,`comic_fecha_subida` timestamp
,`usuario_id` int(11)
,`usuario_nombre` varchar(50)
,`usuario_email` varchar(100)
,`categoria_id` int(11)
,`categoria_nombre` varchar(50)
,`pagina_id` int(11)
,`pagina_numero` int(11)
,`pagina_ruta_imagen` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_completa_sharedcomics`
--
DROP TABLE IF EXISTS `vista_completa_sharedcomics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_completa_sharedcomics`  AS SELECT `c`.`id` AS `comic_id`, `c`.`titulo` AS `comic_titulo`, `c`.`descripcion` AS `comic_descripcion`, `c`.`portada` AS `comic_portada`, `c`.`pdf_comic` AS `comic_pdf`, `c`.`fecha_subida` AS `comic_fecha_subida`, `u`.`id` AS `usuario_id`, `u`.`username` AS `usuario_nombre`, `u`.`email` AS `usuario_email`, `cat`.`id` AS `categoria_id`, `cat`.`nombre` AS `categoria_nombre`, `p`.`id` AS `pagina_id`, `p`.`numero_pagina` AS `pagina_numero`, `p`.`ruta_imagen` AS `pagina_ruta_imagen` FROM ((((`comics` `c` left join `usuarios` `u` on(`c`.`usuario_id` = `u`.`id`)) left join `comic_categoria` `cc` on(`c`.`id` = `cc`.`comic_id`)) left join `categorias` `cat` on(`cc`.`categoria_id` = `cat`.`id`)) left join `paginas` `p` on(`c`.`id` = `p`.`comic_id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `comics`
--
ALTER TABLE `comics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `comic_categoria`
--
ALTER TABLE `comic_categoria`
  ADD PRIMARY KEY (`comic_id`,`categoria_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comic_id` (`comic_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comics`
--
ALTER TABLE `comics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comics`
--
ALTER TABLE `comics`
  ADD CONSTRAINT `comics_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `comic_categoria`
--
ALTER TABLE `comic_categoria`
  ADD CONSTRAINT `comic_categoria_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comic_categoria_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `paginas`
--
ALTER TABLE `paginas`
  ADD CONSTRAINT `paginas_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
