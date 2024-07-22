-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-05-2024 a las 20:47:27
-- Versión del servidor: 10.11.7-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u144865085_quindisistem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergias`
--

CREATE TABLE `alergias` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes`
--

CREATE TABLE `antecedentes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` int(2) NOT NULL,
  `nombre_cargo` varchar(64) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `historias` int(1) NOT NULL DEFAULT 1,
  `soporte` int(1) NOT NULL DEFAULT 1,
  `id_jefe` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre_cargo`, `descripcion`, `estado`, `historias`, `soporte`, `id_jefe`) VALUES
(1, 'Super Administrador', NULL, 1, 1, 1, 3),
(2, 'Administrador Sistema', NULL, 1, 1, 1, 3),
(3, 'Gerente', 'Aqui las funciones de la gerencia', 1, 1, 1, 3),
(4, 'Coordinador@ Administrativ@ de Salas', '', 1, 1, 1, 3),
(5, 'Coordinador@ Administrativ@ y Contable', '', 1, 1, 1, 12),
(6, 'Jefe de Recursos Humanos', 'Funciones del cargo de jefe de recursos humanos', 1, 1, 1, 3),
(7, 'Asistente de Gerencia', '', 1, 0, 0, 3),
(8, 'Tesoreria y Suministros', '', 1, 0, 0, 3),
(9, 'Jefe de Bodega y logística', '', 1, 1, 1, 3),
(10, 'Ejecutivo Comercial Externo', '', 1, 0, 0, 3),
(11, 'Auxiliar Administrativ@', '', 1, 0, 0, 4),
(12, 'Contador', '', 1, 0, 0, 3),
(13, 'Seguridad y Salud en el Trabajo', '', 1, 0, 0, 3),
(14, 'Conductor', '', 1, 0, 0, 3),
(15, 'Asesor Comercial', '', 1, 0, 0, 4),
(16, 'Auxiliar de Bodega', '', 1, 0, 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cirugias`
--

CREATE TABLE `cirugias` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaboradores_mes`
--

CREATE TABLE `colaboradores_mes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `mes` varchar(16) NOT NULL,
  `ano` int(4) NOT NULL,
  `tipo` varchar(64) NOT NULL,
  `mes_num` int(2) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario_historia`
--

CREATE TABLE `comentario_historia` (
  `id` int(11) NOT NULL,
  `id_autor` int(8) NOT NULL,
  `id_historia` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compensacion_detalle`
--

CREATE TABLE `compensacion_detalle` (
  `id` int(11) NOT NULL,
  `id_compensacion` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `dias` int(2) NOT NULL,
  `tipo` varchar(32) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conexiones`
--

CREATE TABLE `conexiones` (
  `id` int(8) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `id_usuario` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `logo_blanco` text DEFAULT NULL,
  `faticon` text DEFAULT NULL,
  `img_login` text DEFAULT NULL,
  `driver` varchar(8) DEFAULT NULL,
  `cifrado` varchar(8) DEFAULT NULL,
  `host` varchar(128) DEFAULT NULL,
  `port` int(4) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `pass_email` text DEFAULT NULL,
  `url_back` text DEFAULT NULL,
  `url_front` text DEFAULT NULL,
  `hosting` date DEFAULT NULL,
  `nit` varchar(16) DEFAULT NULL,
  `email_carta` varchar(128) DEFAULT NULL,
  `direccion` varchar(128) DEFAULT NULL,
  `tel_contacto` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `logo`, `logo_blanco`, `faticon`, `img_login`, `driver`, `cifrado`, `host`, `port`, `email`, `pass_email`, `url_back`, `url_front`, `hosting`, `nit`, `email_carta`, `direccion`, `tel_contacto`) VALUES
(1, 'QuindiPisos', '662ada5b8c45b-logo_nuevo.png', '662ada66c614d-logo_nuevo.png', '662ada81562f2-icono.png', NULL, 'smtp', 'SSL', 'smtp.hostinger.com', 465, 'quindisistem@quindipisos.com', 'Quindisistem2024*', 'http://localhost/', 'https://quindipisos.com/', '2024-04-21', '801.139.454-3', 'nomina@quindipisos.com', 'Villa Carolina 1 etapa mz i casa 24', '3136464151 ext 15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `id_contrato` varchar(16) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `tipo_contrato` varchar(64) DEFAULT NULL,
  `salario` float DEFAULT 0,
  `duracion` varchar(128) DEFAULT NULL,
  `jornada_laboral` varchar(128) DEFAULT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `adjunto` text DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  `motivo_terminacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `institucion` varchar(200) NOT NULL,
  `descripcion` varchar(240) NOT NULL,
  `horas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`, `codigo`) VALUES
(1, 'Antioquia', 5),
(2, 'Atlantico', 8),
(3, 'D. C. Santa Fe de Bogotá', 11),
(4, 'Bolivar', 13),
(5, 'Boyaca', 15),
(6, 'Caldas', 17),
(7, 'Caqueta', 18),
(8, 'Cauca', 19),
(9, 'Cesar', 20),
(10, 'Cordoba', 23),
(11, 'Cundinamarca', 25),
(12, 'Choco', 27),
(13, 'Huila', 41),
(14, 'La Guajira', 44),
(15, 'Magdalena', 47),
(16, 'Meta', 50),
(17, 'Nariño', 52),
(18, 'Norte de Santander', 54),
(19, 'Quindio', 63),
(20, 'Risaralda', 66),
(21, 'Santander', 68),
(22, 'Sucre', 70),
(23, 'Tolima', 73),
(24, 'Valle', 76),
(25, 'Arauca', 81),
(26, 'Casanare', 85),
(27, 'Putumayo', 86),
(28, 'San Andres', 88),
(29, 'Amazonas', 91),
(30, 'Guainia', 94),
(31, 'Guaviare', 95),
(32, 'Vaupes', 97),
(33, 'Vichada', 99),
(34, 'Extranjero', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `id_autor` int(8) NOT NULL,
  `create_date` date NOT NULL,
  `tipo_encuesta` varchar(64) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermedades`
--

CREATE TABLE `enfermedades` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_correos`
--

CREATE TABLE `envio_correos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(128) NOT NULL,
  `destinatarios` text NOT NULL,
  `fecha_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudios`
--

CREATE TABLE `estudios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nivel` varchar(80) NOT NULL,
  `tipo_nivel` varchar(80) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `institucion` varchar(200) NOT NULL,
  `ano` int(4) NOT NULL,
  `ciudad` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia`
--

CREATE TABLE `historia` (
  `id` int(11) NOT NULL,
  `id_autor` int(8) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `texto` text NOT NULL,
  `imagen` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `documento` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incapacidades`
--

CREATE TABLE `incapacidades` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `tipo` varchar(128) NOT NULL,
  `duracion` int(4) NOT NULL,
  `descripcion` text NOT NULL,
  `diagnostico` text DEFAULT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lesiones`
--

CREATE TABLE `lesiones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(32) NOT NULL,
  `nombre` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `indicaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `icono` varchar(128) DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `eliminar` int(1) NOT NULL,
  `variable` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
(1, 'Administrativo', NULL, 1, 0, 'administrativo'),
(2, 'Modulos', NULL, 1, 0, 'modulos'),
(3, 'Cargos', NULL, 1, 0, 'cargos'),
(4, 'Usuarios', NULL, 1, 0, 'usuarios'),
(5, 'Sedes', NULL, 1, 0, 'sedes'),
(6, 'Talento Humano', NULL, 1, 0, 'talento humano'),
(7, 'Notas de Inicio', NULL, 1, 1, 'notas de inicio'),
(8, 'Agenda', NULL, 1, 1, 'agenda'),
(9, 'Biblioteca', NULL, 1, 1, 'biblioteca'),
(10, 'Calificacion Servicio', NULL, 1, 0, 'calificacion servicio'),
(11, 'Contratos', NULL, 1, 0, 'contratos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_cargos`
--

CREATE TABLE `modulos_cargos` (
  `id` int(11) NOT NULL,
  `id_cargo` int(2) NOT NULL,
  `id_modulo` int(2) NOT NULL,
  `crear` int(1) NOT NULL DEFAULT 0,
  `editar` int(1) NOT NULL DEFAULT 0,
  `eliminar` int(1) NOT NULL DEFAULT 0,
  `ver` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `modulos_cargos`
--

INSERT INTO `modulos_cargos` (`id`, `id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) VALUES
(13, 1, 1, 1, 1, 1, 1),
(14, 1, 2, 1, 1, 1, 1),
(15, 1, 3, 1, 1, 1, 1),
(16, 1, 4, 1, 1, 1, 1),
(17, 1, 5, 0, 0, 0, 0),
(18, 3, 1, 1, 1, 0, 1),
(19, 3, 2, 1, 1, 0, 1),
(20, 3, 3, 1, 1, 0, 1),
(21, 3, 4, 1, 1, 0, 1),
(22, 3, 5, 1, 1, 0, 1),
(24, 6, 3, 1, 1, 0, 1),
(25, 6, 4, 1, 1, 0, 1),
(26, 1, 6, 0, 0, 0, 0),
(27, 1, 7, 0, 0, 0, 0),
(28, 1, 8, 0, 0, 0, 0),
(29, 1, 9, 0, 0, 0, 0),
(30, 1, 10, 0, 0, 0, 0),
(31, 3, 6, 1, 1, 0, 1),
(32, 3, 7, 1, 1, 1, 1),
(33, 3, 8, 1, 1, 1, 1),
(34, 3, 9, 1, 1, 1, 1),
(35, 3, 10, 1, 1, 0, 1),
(36, 6, 6, 1, 1, 0, 1),
(37, 6, 7, 1, 1, 1, 1),
(38, 6, 8, 1, 1, 1, 1),
(39, 6, 9, 1, 1, 1, 1),
(40, 6, 10, 1, 1, 0, 1),
(41, 15, 8, 1, 1, 1, 1),
(42, 15, 9, 0, 0, 0, 1),
(43, 7, 4, 0, 0, 0, 1),
(44, 7, 6, 0, 0, 0, 1),
(45, 7, 7, 1, 1, 1, 1),
(46, 7, 8, 1, 1, 1, 1),
(47, 7, 9, 1, 1, 1, 1),
(48, 16, 8, 1, 1, 1, 1),
(49, 16, 9, 0, 0, 0, 1),
(50, 14, 8, 0, 0, 0, 1),
(51, 14, 9, 0, 0, 0, 1),
(52, 12, 8, 0, 0, 0, 1),
(53, 12, 9, 0, 0, 0, 1),
(54, 4, 8, 1, 1, 1, 1),
(55, 4, 9, 0, 0, 0, 1),
(56, 5, 8, 0, 0, 0, 1),
(57, 5, 9, 0, 0, 0, 1),
(58, 4, 7, 1, 1, 1, 1),
(59, 10, 8, 0, 0, 0, 1),
(60, 10, 9, 0, 0, 0, 1),
(61, 9, 7, 1, 1, 1, 1),
(62, 9, 9, 1, 1, 1, 1),
(63, 9, 8, 1, 1, 1, 1),
(64, 13, 6, 0, 1, 0, 1),
(65, 13, 7, 1, 1, 1, 1),
(66, 13, 8, 1, 1, 1, 1),
(67, 13, 9, 1, 1, 1, 1),
(68, 13, 10, 1, 1, 0, 1),
(69, 8, 8, 1, 1, 1, 1),
(70, 8, 9, 0, 0, 0, 1),
(71, 1, 11, 0, 0, 0, 0),
(72, 3, 11, 1, 1, 0, 1),
(73, 6, 11, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `departamento_id`, `codigo`, `nombre`) VALUES
(1, 1, 1, 'MEDELLIN'),
(2, 1, 2, 'ABEJORRAL'),
(3, 1, 4, 'ABRIAQUI'),
(4, 1, 21, 'ALEJANDRIA'),
(5, 1, 30, 'AMAGA'),
(6, 1, 31, 'AMALFI'),
(7, 1, 34, 'ANDES'),
(8, 1, 36, 'ANGELOPOLIS'),
(9, 1, 38, 'ANGOSTURA'),
(10, 1, 40, 'ANORI'),
(11, 1, 42, 'ANTIOQUIA'),
(12, 1, 44, 'ANZA'),
(13, 1, 45, 'APARTADO'),
(14, 1, 51, 'ARBOLETES'),
(15, 1, 55, 'ARGELIA'),
(16, 1, 59, 'ARMENIA'),
(17, 1, 79, 'BARBOSA'),
(18, 1, 86, 'BELMIRA'),
(19, 1, 88, 'BELLO'),
(20, 1, 91, 'BETANIA'),
(21, 1, 93, 'BETULIA'),
(22, 1, 101, 'BOLIVAR'),
(23, 1, 107, 'BRICEÑO'),
(24, 1, 113, 'BURITICA'),
(25, 1, 120, 'CACERES'),
(26, 1, 125, 'CAICEDO'),
(27, 1, 129, 'CALDAS'),
(28, 1, 134, 'CAMPAMENTO'),
(29, 1, 138, 'CAÑASGORDAS'),
(30, 1, 142, 'CARACOLI'),
(31, 1, 145, 'CARAMANTA'),
(32, 1, 147, 'CAREPA'),
(33, 1, 148, 'CARMEN DE VIBORAL'),
(34, 1, 150, 'CAROLINA'),
(35, 1, 154, 'CAUCASIA'),
(36, 1, 172, 'CHIGORODO'),
(37, 1, 190, 'CISNEROS'),
(38, 1, 197, 'COCORNA'),
(39, 1, 206, 'CONCEPCION'),
(40, 1, 209, 'CONCORDIA'),
(41, 1, 212, 'COPACABANA'),
(42, 1, 234, 'DABEIBA'),
(43, 1, 237, 'DON MATIAS'),
(44, 1, 240, 'EBEJICO'),
(45, 1, 250, 'EL BAGRE'),
(46, 1, 264, 'ENTRERRIOS'),
(47, 1, 266, 'ENVIGADO'),
(48, 1, 282, 'FREDONIA'),
(49, 1, 284, 'FRONTINO'),
(50, 1, 306, 'GIRALDO'),
(51, 1, 308, 'GIRARDOTA'),
(52, 1, 310, 'GOMEZ PLATA'),
(53, 1, 313, 'GRANADA'),
(54, 1, 315, 'GUADALUPE'),
(55, 1, 318, 'GUARNE'),
(56, 1, 321, 'GUATAPE'),
(57, 1, 347, 'HELICONIA'),
(58, 1, 353, 'HISPANIA'),
(59, 1, 360, 'ITAGUI'),
(60, 1, 361, 'ITUANGO'),
(61, 1, 364, 'JARDIN'),
(62, 1, 368, 'JERICO'),
(63, 1, 376, 'LA CEJA'),
(64, 1, 380, 'LA ESTRELLA'),
(65, 1, 390, 'LA PINTADA'),
(66, 1, 400, 'LA UNION'),
(67, 1, 411, 'LIBORINA'),
(68, 1, 425, 'MACEO'),
(69, 1, 440, 'MARINILLA'),
(70, 1, 467, 'MONTEBELLO'),
(71, 1, 475, 'MURINDO'),
(72, 1, 480, 'MUTATA'),
(73, 1, 483, 'NARIÑO'),
(74, 1, 490, 'NECOCLI'),
(75, 1, 495, 'NECHI'),
(76, 1, 501, 'OLAYA'),
(77, 1, 541, 'PEÑOL'),
(78, 1, 543, 'PEQUE'),
(79, 1, 576, 'PUEBLORRICO'),
(80, 1, 579, 'PUERTO BERRIO'),
(81, 1, 585, 'PUERTO NARE (LA MAGDALENA)'),
(82, 1, 591, 'PUERTO TRIUNFO'),
(83, 1, 604, 'REMEDIOS'),
(84, 1, 607, 'RETIRO'),
(85, 1, 615, 'RIONEGRO'),
(86, 1, 628, 'SABANALARGA'),
(87, 1, 631, 'SABANETA'),
(88, 1, 642, 'SALGAR'),
(89, 1, 647, 'SAN ANDRES'),
(90, 1, 649, 'SAN CARLOS'),
(91, 1, 652, 'SAN FRANCISCO'),
(92, 1, 656, 'SAN JERONIMO'),
(93, 1, 658, 'SAN JOSE DE LA MONTAÑA'),
(94, 1, 659, 'SAN JUAN DE URABA'),
(95, 1, 660, 'SAN LUIS'),
(96, 1, 664, 'SAN PEDRO'),
(97, 1, 665, 'SAN PEDRO DE URABA'),
(98, 1, 667, 'SAN RAFAEL'),
(99, 1, 670, 'SAN ROQUE'),
(100, 1, 674, 'SAN VICENTE'),
(101, 1, 679, 'SANTA BARBARA'),
(102, 1, 686, 'SANTA ROSA DE OSOS'),
(103, 1, 690, 'SANTO DOMINGO'),
(104, 1, 697, 'SANTUARIO'),
(105, 1, 736, 'SEGOVIA'),
(106, 1, 756, 'SONSON'),
(107, 1, 761, 'SOPETRAN'),
(108, 1, 789, 'TAMESIS'),
(109, 1, 790, 'TARAZA'),
(110, 1, 792, 'TARSO'),
(111, 1, 809, 'TITIRIBI'),
(112, 1, 819, 'TOLEDO'),
(113, 1, 837, 'TURBO'),
(114, 1, 842, 'URAMITA'),
(115, 1, 847, 'URRAO'),
(116, 1, 854, 'VALDIVIA'),
(117, 1, 856, 'VALPARAISO'),
(118, 1, 858, 'VEGACHI'),
(119, 1, 861, 'VENECIA'),
(120, 1, 873, 'VIGIA DEL FUERTE'),
(121, 1, 885, 'YALI'),
(122, 1, 887, 'YARUMAL'),
(123, 1, 890, 'YOLOMBO'),
(124, 1, 893, 'YONDO'),
(125, 1, 895, 'ZARAGOZA'),
(126, 2, 1, 'BARRANQUILLA (DISTRITO ESPECIAL INDUSTRIAL Y PORTUARIO DE BARRANQUILLA)'),
(127, 2, 78, 'BARANOA'),
(128, 2, 137, 'CAMPO DE LA CRUZ'),
(129, 2, 141, 'CANDELARIA'),
(130, 2, 296, 'GALAPA'),
(131, 2, 372, 'JUAN DE ACOSTA'),
(132, 2, 421, 'LURUACO'),
(133, 2, 433, 'MALAMBO'),
(134, 2, 436, 'MANATI'),
(135, 2, 520, 'PALMAR DE VARELA'),
(136, 2, 549, 'PIOJO'),
(137, 2, 558, 'POLO NUEVO'),
(138, 2, 560, 'PONEDERA'),
(139, 2, 573, 'PUERTO COLOMBIA'),
(140, 2, 606, 'REPELON'),
(141, 2, 634, 'SABANAGRANDE'),
(142, 2, 638, 'SABANALARGA'),
(143, 2, 675, 'SANTA LUCIA'),
(144, 2, 685, 'SANTO TOMAS'),
(145, 2, 758, 'SOLEDAD'),
(146, 2, 770, 'SUAN'),
(147, 2, 832, 'TUBARA'),
(148, 2, 849, 'USIACURI'),
(149, 3, 1, 'Santa Fe de Bogotá'),
(150, 3, 1, 'USAQUEN'),
(151, 3, 2, 'CHAPINERO'),
(152, 3, 3, 'SANTA FE'),
(153, 3, 4, 'SAN CRISTOBAL'),
(154, 3, 5, 'USME'),
(155, 3, 6, 'TUNJUELITO'),
(156, 3, 7, 'BOSA'),
(157, 3, 8, 'KENNEDY'),
(158, 3, 9, 'FONTIBON'),
(159, 3, 10, 'ENGATIVA'),
(160, 3, 11, 'SUBA'),
(161, 3, 12, 'BARRIOS UNIDOS'),
(162, 3, 13, 'TEUSAQUILLO'),
(163, 3, 14, 'MARTIRES'),
(164, 3, 15, 'ANTONIO NARIÑO'),
(165, 3, 16, 'PUENTE ARANDA'),
(166, 3, 17, 'CANDELARIA'),
(167, 3, 18, 'RAFAEL URIBE'),
(168, 3, 19, 'CIUDAD BOLIVAR'),
(169, 3, 20, 'SUMAPAZ'),
(170, 4, 1, 'CARTAGENA (DISTRITO TURISTICO Y CULTURAL DE CARTAGENA)'),
(171, 4, 6, 'ACHI'),
(172, 4, 30, 'ALTOS DEL ROSARIO'),
(173, 4, 42, 'ARENAL'),
(174, 4, 52, 'ARJONA'),
(175, 4, 62, 'ARROYOHONDO'),
(176, 4, 74, 'BARRANCO DE LOBA'),
(177, 4, 140, 'CALAMAR'),
(178, 4, 160, 'CANTAGALLO'),
(179, 4, 188, 'CICUCO'),
(180, 4, 212, 'CORDOBA'),
(181, 4, 222, 'CLEMENCIA'),
(182, 4, 244, 'EL CARMEN DE BOLIVAR'),
(183, 4, 248, 'EL GUAMO'),
(184, 4, 268, 'EL PEÑON'),
(185, 4, 300, 'HATILLO DE LOBA'),
(186, 4, 430, 'MAGANGUE'),
(187, 4, 433, 'MAHATES'),
(188, 4, 440, 'MARGARITA'),
(189, 4, 442, 'MARIA LA BAJA'),
(190, 4, 458, 'MONTECRISTO'),
(191, 4, 468, 'MOMPOS'),
(192, 4, 473, 'MORALES'),
(193, 4, 549, 'PINILLOS'),
(194, 4, 580, 'REGIDOR'),
(195, 4, 600, 'RIO VIEJO'),
(196, 4, 620, 'SAN CRISTOBAL'),
(197, 4, 647, 'SAN ESTANISLAO'),
(198, 4, 650, 'SAN FERNANDO'),
(199, 4, 654, 'SAN JACINTO'),
(200, 4, 655, 'SAN JACINTO DEL CAUCA'),
(201, 4, 657, 'SAN JUAN NEPOMUCENO'),
(202, 4, 667, 'SAN MARTIN DE LOBA'),
(203, 4, 670, 'SAN PABLO'),
(204, 4, 673, 'SANTA CATALINA'),
(205, 4, 683, 'SANTA ROSA'),
(206, 4, 688, 'SANTA ROSA DEL SUR'),
(207, 4, 744, 'SIMITI'),
(208, 4, 760, 'SOPLAVIENTO'),
(209, 4, 780, 'TALAIGUA NUEVO'),
(210, 4, 810, 'TIQUISIO (PUERTO RICO)'),
(211, 4, 836, 'TURBACO'),
(212, 4, 838, 'TURBANA'),
(213, 4, 873, 'VILLANUEVA'),
(214, 4, 894, 'ZAMBRANO'),
(215, 5, 1, 'TUNJA'),
(216, 5, 22, 'ALMEIDA'),
(217, 5, 47, 'AQUITANIA'),
(218, 5, 51, 'ARCABUCO'),
(219, 5, 87, 'BELEN'),
(220, 5, 90, 'BERBEO'),
(221, 5, 92, 'BETEITIVA'),
(222, 5, 97, 'BOAVITA'),
(223, 5, 104, 'BOYACA'),
(224, 5, 106, 'BRICEÑO'),
(225, 5, 109, 'BUENAVISTA'),
(226, 5, 114, 'BUSBANZA'),
(227, 5, 131, 'CALDAS'),
(228, 5, 135, 'CAMPOHERMOSO'),
(229, 5, 162, 'CERINZA'),
(230, 5, 172, 'CHINAVITA'),
(231, 5, 176, 'CHIQUINQUIRA'),
(232, 5, 180, 'CHISCAS'),
(233, 5, 183, 'CHITA'),
(234, 5, 185, 'CHITARAQUE'),
(235, 5, 187, 'CHIVATA'),
(236, 5, 189, 'CIENEGA'),
(237, 5, 204, 'COMBITA'),
(238, 5, 212, 'COPER'),
(239, 5, 215, 'CORRALES'),
(240, 5, 218, 'COVARACHIA'),
(241, 5, 223, 'CUBARA'),
(242, 5, 224, 'CUCAITA'),
(243, 5, 226, 'CUITIVA'),
(244, 5, 232, 'CHIQUIZA'),
(245, 5, 236, 'CHIVOR'),
(246, 5, 238, 'DUITAMA'),
(247, 5, 244, 'EL COCUY'),
(248, 5, 248, 'EL ESPINO'),
(249, 5, 272, 'FIRAVITOBA'),
(250, 5, 276, 'FLORESTA'),
(251, 5, 293, 'GACHANTIVA'),
(252, 5, 296, 'GAMEZA'),
(253, 5, 299, 'GARAGOA'),
(254, 5, 317, 'GUACAMAYAS'),
(255, 5, 322, 'GUATEQUE'),
(256, 5, 325, 'GUAYATA'),
(257, 5, 332, 'GUICAN'),
(258, 5, 362, 'IZA'),
(259, 5, 367, 'JENESANO'),
(260, 5, 368, 'JERICO'),
(261, 5, 377, 'LABRANZAGRANDE'),
(262, 5, 380, 'LA CAPILLA'),
(263, 5, 401, 'LA VICTORIA'),
(264, 5, 403, 'LA UVITA'),
(265, 5, 407, 'VILLA DE LEIVA'),
(266, 5, 425, 'MACANAL'),
(267, 5, 442, 'MARIPI'),
(268, 5, 455, 'MIRAFLORES'),
(269, 5, 464, 'MONGUA'),
(270, 5, 466, 'MONGUI'),
(271, 5, 469, 'MONIQUIRA'),
(272, 5, 476, 'MOTAVITA'),
(273, 5, 480, 'MUZO'),
(274, 5, 491, 'NOBSA'),
(275, 5, 494, 'NUEVO COLON'),
(276, 5, 500, 'OICATA'),
(277, 5, 507, 'OTANCHE'),
(278, 5, 511, 'PACHAVITA'),
(279, 5, 514, 'PAEZ'),
(280, 5, 516, 'PAIPA'),
(281, 5, 518, 'PAJARITO'),
(282, 5, 522, 'PANQUEBA'),
(283, 5, 531, 'PAUNA'),
(284, 5, 533, 'PAYA'),
(285, 5, 537, 'PAZ DEL RIO'),
(286, 5, 542, 'PESCA'),
(287, 5, 550, 'PISBA'),
(288, 5, 572, 'PUERTO BOYACA'),
(289, 5, 580, 'QUIPAMA'),
(290, 5, 599, 'RAMIRIQUI'),
(291, 5, 600, 'RAQUIRA'),
(292, 5, 621, 'RONDON'),
(293, 5, 632, 'SABOYA'),
(294, 5, 638, 'SACHICA'),
(295, 5, 646, 'SAMACA'),
(296, 5, 660, 'SAN EDUARDO'),
(297, 5, 664, 'SAN JOSE DE PARE'),
(298, 5, 667, 'SAN LUIS DE GACENO'),
(299, 5, 673, 'SAN MATEO'),
(300, 5, 676, 'SAN MIGUEL DE SEMA'),
(301, 5, 681, 'SAN PABLO DE BORBUR'),
(302, 5, 686, 'SANTANA'),
(303, 5, 690, 'SANTA MARIA'),
(304, 5, 693, 'SANTA ROSA DE VITERBO'),
(305, 5, 696, 'SANTA SOFIA'),
(306, 5, 720, 'SATIVANORTE'),
(307, 5, 723, 'SATIVASUR'),
(308, 5, 740, 'SIACHOQUE'),
(309, 5, 753, 'SOATA'),
(310, 5, 755, 'SOCOTA'),
(311, 5, 757, 'SOCHA'),
(312, 5, 759, 'SOGAMOSO'),
(313, 5, 761, 'SOMONDOCO'),
(314, 5, 762, 'SORA'),
(315, 5, 763, 'SOTAQUIRA'),
(316, 5, 764, 'SORACA'),
(317, 5, 774, 'SUSACON'),
(318, 5, 776, 'SUTAMARCHAN'),
(319, 5, 778, 'SUTATENZA'),
(320, 5, 790, 'TASCO'),
(321, 5, 798, 'TENZA'),
(322, 5, 804, 'TIBANA'),
(323, 5, 806, 'TIBASOSA'),
(324, 5, 808, 'TINJACA'),
(325, 5, 810, 'TIPACOQUE'),
(326, 5, 814, 'TOCA'),
(327, 5, 816, 'TOGUI'),
(328, 5, 820, 'TOPAGA'),
(329, 5, 822, 'TOTA'),
(330, 5, 832, 'TUNUNGUA'),
(331, 5, 835, 'TURMEQUE'),
(332, 5, 837, 'TUTA'),
(333, 5, 839, 'TUTASA'),
(334, 5, 842, 'UMBITA'),
(335, 5, 861, 'VENTAQUEMADA'),
(336, 5, 879, 'VIRACACHA'),
(337, 5, 897, 'ZETAQUIRA'),
(338, 6, 1, 'MANIZALES'),
(339, 6, 13, 'AGUADAS'),
(340, 6, 42, 'ANSERMA'),
(341, 6, 50, 'ARANZAZU'),
(342, 6, 88, 'BELALCAZAR'),
(343, 6, 174, 'CHINCHINA'),
(344, 6, 272, 'FILADELFIA'),
(345, 6, 380, 'LA DORADA'),
(346, 6, 388, 'LA MERCED'),
(347, 6, 433, 'MANZANARES'),
(348, 6, 442, 'MARMATO'),
(349, 6, 444, 'MARQUETALIA'),
(350, 6, 446, 'MARULANDA'),
(351, 6, 486, 'NEIRA'),
(352, 6, 495, 'NORCASIA'),
(353, 6, 513, 'PACORA'),
(354, 6, 524, 'PALESTINA'),
(355, 6, 541, 'PENSILVANIA'),
(356, 6, 614, 'RIOSUCIO'),
(357, 6, 616, 'RISARALDA'),
(358, 6, 653, 'SALAMINA'),
(359, 6, 662, 'SAMANA'),
(360, 6, 665, 'SAN JOSE'),
(361, 6, 777, 'SUPIA'),
(362, 6, 867, 'VICTORIA'),
(363, 6, 873, 'VILLAMARIA'),
(364, 6, 877, 'VITERBO'),
(365, 7, 1, 'FLORENCIA'),
(366, 7, 29, 'ALBANIA'),
(367, 7, 94, 'BELEN DE LOS ANDAQUIES'),
(368, 7, 150, 'CARTAGENA DEL CHAIRA'),
(369, 7, 205, 'CURILLO'),
(370, 7, 247, 'EL DONCELLO'),
(371, 7, 256, 'EL PAUJIL'),
(372, 7, 410, 'LA MONTAÑITA'),
(373, 7, 460, 'MILAN'),
(374, 7, 479, 'MORELIA'),
(375, 7, 592, 'PUERTO RICO'),
(376, 7, 610, 'SAN JOSE DE FRAGUA'),
(377, 7, 753, 'SAN VICENTE DEL CAGUAN'),
(378, 7, 756, 'SOLANO'),
(379, 7, 785, 'SOLITA'),
(380, 7, 860, 'VALPARAISO'),
(381, 8, 1, 'POPAYAN'),
(382, 8, 22, 'ALMAGUER'),
(383, 8, 50, 'ARGELIA'),
(384, 8, 75, 'BALBOA'),
(385, 8, 100, 'BOLIVAR'),
(386, 8, 110, 'BUENOS AIRES'),
(387, 8, 130, 'CAJIBIO'),
(388, 8, 137, 'CALDONO'),
(389, 8, 142, 'CALOTO'),
(390, 8, 212, 'CORINTO'),
(391, 8, 256, 'EL TAMBO'),
(392, 8, 290, 'FLORENCIA'),
(393, 8, 318, 'GUAPI'),
(394, 8, 355, 'INZA'),
(395, 8, 364, 'JAMBALO'),
(396, 8, 392, 'LA SIERRA'),
(397, 8, 397, 'LA VEGA'),
(398, 8, 418, 'LOPEZ (MICAY)'),
(399, 8, 450, 'MERCADERES'),
(400, 8, 455, 'MIRANDA'),
(401, 8, 473, 'MORALES'),
(402, 8, 513, 'PADILLA'),
(403, 8, 517, 'PAEZ (BELALCAZAR)'),
(404, 8, 532, 'PATIA (EL BORDO)'),
(405, 8, 533, 'PIAMONTE'),
(406, 8, 548, 'PIENDAMO'),
(407, 8, 573, 'PUERTO TEJADA'),
(408, 8, 585, 'PURACE (COCONUCO)'),
(409, 8, 622, 'ROSAS'),
(410, 8, 693, 'SAN SEBASTIAN'),
(411, 8, 698, 'SANTANDER DE QUILICHAO'),
(412, 8, 701, 'SANTA ROSA'),
(413, 8, 743, 'SILVIA'),
(414, 8, 760, 'SOTARA (PAISPAMBA)'),
(415, 8, 780, 'SUAREZ'),
(416, 8, 807, 'TIMBIO'),
(417, 8, 809, 'TIMBIQUI'),
(418, 8, 821, 'TORIBIO'),
(419, 8, 824, 'TOTORO'),
(420, 8, 845, 'VILLARICA'),
(421, 9, 1, 'VALLEDUPAR'),
(422, 9, 11, 'AGUACHICA'),
(423, 9, 13, 'AGUSTIN CODAZZI'),
(424, 9, 32, 'ASTREA'),
(425, 9, 45, 'BECERRIL'),
(426, 9, 60, 'BOSCONIA'),
(427, 9, 175, 'CHIMICHAGUA'),
(428, 9, 178, 'CHIRIGUANA'),
(429, 9, 228, 'CURUMANI'),
(430, 9, 238, 'EL COPEY'),
(431, 9, 250, 'EL PASO'),
(432, 9, 295, 'GAMARRA'),
(433, 9, 310, 'GONZALEZ'),
(434, 9, 383, 'LA GLORIA'),
(435, 9, 400, 'LA JAGUA IBIRICO'),
(436, 9, 443, 'MANAURE (BALCON DEL CESAR)'),
(437, 9, 517, 'PAILITAS'),
(438, 9, 550, 'PELAYA'),
(439, 9, 570, 'PUEBLO BELLO'),
(440, 9, 614, 'RIO DE ORO'),
(441, 9, 621, 'LA PAZ (ROBLES)'),
(442, 9, 710, 'SAN ALBERTO'),
(443, 9, 750, 'SAN DIEGO'),
(444, 9, 770, 'SAN MARTIN'),
(445, 9, 787, 'TAMALAMEQUE'),
(446, 10, 1, 'MONTERIA'),
(447, 10, 68, 'AYAPEL'),
(448, 10, 79, 'BUENAVISTA'),
(449, 10, 90, 'CANALETE'),
(450, 10, 162, 'CERETE'),
(451, 10, 168, 'CHIMA'),
(452, 10, 182, 'CHINU'),
(453, 10, 189, 'CIENAGA DE ORO'),
(454, 10, 300, 'COTORRA'),
(455, 10, 350, 'LA APARTADA'),
(456, 10, 417, 'LORICA'),
(457, 10, 419, 'LOS CORDOBAS'),
(458, 10, 464, 'MOMIL'),
(459, 10, 466, 'MONTELIBANO'),
(460, 10, 500, 'MOÑITOS'),
(461, 10, 555, 'PLANETA RICA'),
(462, 10, 570, 'PUEBLO NUEVO'),
(463, 10, 574, 'PUERTO ESCONDIDO'),
(464, 10, 580, 'PUERTO LIBERTADOR'),
(465, 10, 586, 'PURISIMA'),
(466, 10, 660, 'SAHAGUN'),
(467, 10, 670, 'SAN ANDRES SOTAVENTO'),
(468, 10, 672, 'SAN ANTERO'),
(469, 10, 675, 'SAN BERNARDO DEL VIENTO'),
(470, 10, 678, 'SAN CARLOS'),
(471, 10, 686, 'SAN PELAYO'),
(472, 10, 807, 'TIERRALTA'),
(473, 10, 855, 'VALENCIA'),
(474, 11, 1, 'AGUA DE DIOS'),
(475, 11, 19, 'ALBAN'),
(476, 11, 35, 'ANAPOIMA'),
(477, 11, 40, 'ANOLAIMA'),
(478, 11, 53, 'ARBELAEZ'),
(479, 11, 86, 'BELTRAN'),
(480, 11, 95, 'BITUIMA'),
(481, 11, 99, 'BOJACA'),
(482, 11, 120, 'CABRERA'),
(483, 11, 123, 'CACHIPAY'),
(484, 11, 126, 'CAJICA'),
(485, 11, 148, 'CAPARRAPI'),
(486, 11, 151, 'CAQUEZA'),
(487, 11, 154, 'CARMEN DE CARUPA'),
(488, 11, 168, 'CHAGUANI'),
(489, 11, 175, 'CHIA'),
(490, 11, 178, 'CHIPAQUE'),
(491, 11, 181, 'CHOACHI'),
(492, 11, 183, 'CHOCONTA'),
(493, 11, 200, 'COGUA'),
(494, 11, 214, 'COTA'),
(495, 11, 224, 'CUCUNUBA'),
(496, 11, 245, 'EL COLEGIO'),
(497, 11, 258, 'EL PEÑON'),
(498, 11, 260, 'EL ROSAL'),
(499, 11, 269, 'FACATATIVA'),
(500, 11, 279, 'FOMEQUE'),
(501, 11, 281, 'FOSCA'),
(502, 11, 286, 'FUNZA'),
(503, 11, 288, 'FUQUENE'),
(504, 11, 290, 'FUSAGASUGA'),
(505, 11, 293, 'GACHALA'),
(506, 11, 295, 'GACHANCIPA'),
(507, 11, 297, 'GACHETA'),
(508, 11, 299, 'GAMA'),
(509, 11, 307, 'GIRARDOT'),
(510, 11, 312, 'GRANADA'),
(511, 11, 317, 'GUACHETA'),
(512, 11, 320, 'GUADUAS'),
(513, 11, 322, 'GUASCA'),
(514, 11, 324, 'GUATAQUI'),
(515, 11, 326, 'GUATAVITA'),
(516, 11, 328, 'GUAYABAL DE SIQUIMA'),
(517, 11, 335, 'GUAYABETAL'),
(518, 11, 339, 'GUTIERREZ'),
(519, 11, 368, 'JERUSALEN'),
(520, 11, 372, 'JUNIN'),
(521, 11, 377, 'LA CALERA'),
(522, 11, 386, 'LA MESA'),
(523, 11, 394, 'LA PALMA'),
(524, 11, 398, 'LA PEÑA'),
(525, 11, 402, 'LA VEGA'),
(526, 11, 407, 'LENGUAZAQUE'),
(527, 11, 426, 'MACHETA'),
(528, 11, 430, 'MADRID'),
(529, 11, 436, 'MANTA'),
(530, 11, 438, 'MEDINA'),
(531, 11, 473, 'MOSQUERA'),
(532, 11, 483, 'NARIÑO'),
(533, 11, 486, 'NEMOCON'),
(534, 11, 488, 'NILO'),
(535, 11, 489, 'NIMAIMA'),
(536, 11, 491, 'NOCAIMA'),
(537, 11, 506, 'VENECIA (OSPINA PEREZ)'),
(538, 11, 513, 'PACHO'),
(539, 11, 518, 'PAIME'),
(540, 11, 524, 'PANDI'),
(541, 11, 530, 'PARATEBUENO'),
(542, 11, 535, 'PASCA'),
(543, 11, 572, 'PUERTO SALGAR'),
(544, 11, 580, 'PULI'),
(545, 11, 592, 'QUEBRADANEGRA'),
(546, 11, 594, 'QUETAME'),
(547, 11, 596, 'QUIPILE'),
(548, 11, 599, 'APULO (RAFAEL REYES)'),
(549, 11, 612, 'RICAURTE'),
(550, 11, 645, 'SAN ANTONIO DEL TEQUENDAMA'),
(551, 11, 649, 'SAN BERNARDO'),
(552, 11, 653, 'SAN CAYETANO'),
(553, 11, 658, 'SAN FRANCISCO'),
(554, 11, 662, 'SAN JUAN DE RIOSECO'),
(555, 11, 718, 'SASAIMA'),
(556, 11, 736, 'SESQUILE'),
(557, 11, 740, 'SIBATE'),
(558, 11, 743, 'SILVANIA'),
(559, 11, 745, 'SIMIJACA'),
(560, 11, 754, 'SOACHA'),
(561, 11, 758, 'SOPO'),
(562, 11, 769, 'SUBACHOQUE'),
(563, 11, 772, 'SUESCA'),
(564, 11, 777, 'SUPATA'),
(565, 11, 779, 'SUSA'),
(566, 11, 781, 'SUTATAUSA'),
(567, 11, 785, 'TABIO'),
(568, 11, 793, 'TAUSA'),
(569, 11, 797, 'TENA'),
(570, 11, 799, 'TENJO'),
(571, 11, 805, 'TIBACUY'),
(572, 11, 807, 'TIBIRITA'),
(573, 11, 815, 'TOCAIMA'),
(574, 11, 817, 'TOCANCIPA'),
(575, 11, 823, 'TOPAIPI'),
(576, 11, 839, 'UBALA'),
(577, 11, 841, 'UBAQUE'),
(578, 11, 843, 'UBATE'),
(579, 11, 845, 'UNE'),
(580, 11, 851, 'UTICA'),
(581, 11, 862, 'VERGARA'),
(582, 11, 867, 'VIANI'),
(583, 11, 871, 'VILLAGOMEZ'),
(584, 11, 873, 'VILLAPINZON'),
(585, 11, 875, 'VILLETA'),
(586, 11, 878, 'VIOTA'),
(587, 11, 885, 'YACOPI'),
(588, 11, 898, 'ZIPACON'),
(589, 11, 899, 'ZIPAQUIRA'),
(590, 12, 1, 'QUIBDO (SAN FRANCISCO DE QUIBDO)'),
(591, 12, 6, 'ACANDI'),
(592, 12, 25, 'ALTO BAUDO (PIE DE PATO)'),
(593, 12, 50, 'ATRATO'),
(594, 12, 73, 'BAGADO'),
(595, 12, 75, 'BAHIA SOLANO (MUTIS)'),
(596, 12, 77, 'BAJO BAUDO (PIZARRO)'),
(597, 12, 99, 'BOJAYA (BELLAVISTA)'),
(598, 12, 135, 'CANTON DE SAN PABLO (MANAGRU)'),
(599, 12, 205, 'CONDOTO'),
(600, 12, 245, 'EL CARMEN DE ATRATO'),
(601, 12, 250, 'LITORAL DEL BAJO SAN JUAN (SANTA GENOVEVA DE DOCORDO)'),
(602, 12, 361, 'ISTMINA'),
(603, 12, 372, 'JURADO'),
(604, 12, 413, 'LLORO'),
(605, 12, 425, 'MEDIO ATRATO'),
(606, 12, 430, 'MEDIO BAUDO'),
(607, 12, 491, 'NOVITA'),
(608, 12, 495, 'NUQUI'),
(609, 12, 600, 'RIOQUITO'),
(610, 12, 615, 'RIOSUCIO'),
(611, 12, 660, 'SAN JOSE DEL PALMAR'),
(612, 12, 745, 'SIPI'),
(613, 12, 787, 'TADO'),
(614, 12, 800, 'UNGUIA'),
(615, 12, 810, 'UNION PANAMERICANA'),
(616, 13, 1, 'NEIVA'),
(617, 13, 6, 'ACEVEDO'),
(618, 13, 13, 'AGRADO'),
(619, 13, 16, 'AIPE'),
(620, 13, 20, 'ALGECIRAS'),
(621, 13, 26, 'ALTAMIRA'),
(622, 13, 78, 'BARAYA'),
(623, 13, 132, 'CAMPOALEGRE'),
(624, 13, 206, 'COLOMBIA'),
(625, 13, 244, 'ELIAS'),
(626, 13, 298, 'GARZON'),
(627, 13, 306, 'GIGANTE'),
(628, 13, 319, 'GUADALUPE'),
(629, 13, 349, 'HOBO'),
(630, 13, 357, 'IQUIRA'),
(631, 13, 359, 'ISNOS (SAN JOSE DE ISNOS)'),
(632, 13, 378, 'LA ARGENTINA'),
(633, 13, 396, 'LA PLATA'),
(634, 13, 483, 'NATAGA'),
(635, 13, 503, 'OPORAPA'),
(636, 13, 518, 'PAICOL'),
(637, 13, 524, 'PALERMO'),
(638, 13, 530, 'PALESTINA'),
(639, 13, 548, 'PITAL'),
(640, 13, 551, 'PITALITO'),
(641, 13, 615, 'RIVERA'),
(642, 13, 660, 'SALADOBLANCO'),
(643, 13, 668, 'SAN AGUSTIN'),
(644, 13, 676, 'SANTA MARIA'),
(645, 13, 770, 'SUAZA'),
(646, 13, 791, 'TARQUI'),
(647, 13, 797, 'TESALIA'),
(648, 13, 799, 'TELLO'),
(649, 13, 801, 'TERUEL'),
(650, 13, 807, 'TIMANA'),
(651, 13, 872, 'VILLAVIEJA'),
(652, 13, 885, 'YAGUARA'),
(653, 14, 1, 'RIOHACHA'),
(654, 14, 78, 'BARRANCAS'),
(655, 14, 90, 'DIBULLA'),
(656, 14, 98, 'DISTRACCION'),
(657, 14, 110, 'EL MOLINO'),
(658, 14, 279, 'FONSECA'),
(659, 14, 378, 'HATONUEVO'),
(660, 14, 420, 'LA JAGUA DEL PILAR'),
(661, 14, 430, 'MAICAO'),
(662, 14, 560, 'MANAURE'),
(663, 14, 650, 'SAN JUAN DEL CESAR'),
(664, 14, 847, 'URIBIA'),
(665, 14, 855, 'URUMITA'),
(666, 14, 874, 'VILLANUEVA'),
(667, 15, 1, 'SANTA MARTA (DISTRITO TURISTICO CULTURAL E HISTORICO DE SANTA MARTA)'),
(668, 15, 30, 'ALGARROBO'),
(669, 15, 53, 'ARACATACA'),
(670, 15, 58, 'ARIGUANI (EL DIFICIL)'),
(671, 15, 161, 'CERRO SAN ANTONIO'),
(672, 15, 170, 'CHIVOLO'),
(673, 15, 189, 'CIENAGA'),
(674, 15, 205, 'CONCORDIA'),
(675, 15, 245, 'EL BANCO'),
(676, 15, 258, 'EL PIÑON'),
(677, 15, 268, 'EL RETEN'),
(678, 15, 288, 'FUNDACION'),
(679, 15, 318, 'GUAMAL'),
(680, 15, 541, 'PEDRAZA'),
(681, 15, 545, 'PIJIÑO DEL CARMEN (PIJIÑO)'),
(682, 15, 551, 'PIVIJAY'),
(683, 15, 555, 'PLATO'),
(684, 15, 570, 'PUEBLOVIEJO'),
(685, 15, 605, 'REMOLINO'),
(686, 15, 660, 'SABANAS DE SAN ANGEL'),
(687, 15, 675, 'SALAMINA'),
(688, 15, 692, 'SAN SEBASTIAN DE BUENAVISTA'),
(689, 15, 703, 'SAN ZENON'),
(690, 15, 707, 'SANTA ANA'),
(691, 15, 745, 'SITIONUEVO'),
(692, 15, 798, 'TENERIFE'),
(693, 16, 1, 'VILLAVICENCIO'),
(694, 16, 6, 'ACACIAS'),
(695, 16, 110, 'BARRANCA DE UPIA'),
(696, 16, 124, 'CABUYARO'),
(697, 16, 150, 'CASTILLA LA NUEVA'),
(698, 16, 223, 'SAN LUIS DE CUBARRAL'),
(699, 16, 226, 'CUMARAL'),
(700, 16, 245, 'EL CALVARIO'),
(701, 16, 251, 'EL CASTILLO'),
(702, 16, 270, 'EL DORADO'),
(703, 16, 287, 'FUENTE DE ORO'),
(704, 16, 313, 'GRANADA'),
(705, 16, 318, 'GUAMAL'),
(706, 16, 325, 'MAPIRIPAN'),
(707, 16, 330, 'MESETAS'),
(708, 16, 350, 'LA MACARENA'),
(709, 16, 370, 'LA URIBE'),
(710, 16, 400, 'LEJANIAS'),
(711, 16, 450, 'PUERTO CONCORDIA'),
(712, 16, 568, 'PUERTO GAITAN'),
(713, 16, 573, 'PUERTO LOPEZ'),
(714, 16, 577, 'PUERTO LLERAS'),
(715, 16, 590, 'PUERTO RICO'),
(716, 16, 606, 'RESTREPO'),
(717, 16, 680, 'SAN CARLOS DE GUAROA'),
(718, 16, 683, 'SAN JUAN DE ARAMA'),
(719, 16, 686, 'SAN JUANITO'),
(720, 16, 689, 'SAN MARTIN'),
(721, 16, 711, 'VISTAHERMOSA'),
(722, 17, 1, 'PASTO (SAN JUAN DE PASTO)'),
(723, 17, 19, 'ALBAN (SAN JOSE)'),
(724, 17, 22, 'ALDANA'),
(725, 17, 36, 'ANCUYA'),
(726, 17, 51, 'ARBOLEDA (BERRUECOS)'),
(727, 17, 79, 'BARBACOAS'),
(728, 17, 83, 'BELEN'),
(729, 17, 110, 'BUESACO'),
(730, 17, 203, 'COLON (GENOVA)'),
(731, 17, 207, 'CONSACA'),
(732, 17, 210, 'CONTADERO'),
(733, 17, 215, 'CORDOBA'),
(734, 17, 224, 'CUASPUD (CARLOSAMA)'),
(735, 17, 227, 'CUMBAL'),
(736, 17, 233, 'CUMBITARA'),
(737, 17, 240, 'CHACHAGUI'),
(738, 17, 250, 'EL CHARCO'),
(739, 17, 254, 'EL PEÑOL'),
(740, 17, 256, 'EL ROSARIO'),
(741, 17, 258, 'EL TABLON'),
(742, 17, 260, 'EL TAMBO'),
(743, 17, 287, 'FUNES'),
(744, 17, 317, 'GUACHUCAL'),
(745, 17, 320, 'GUAITARILLA'),
(746, 17, 323, 'GUALMATAN'),
(747, 17, 352, 'ILES'),
(748, 17, 354, 'IMUES'),
(749, 17, 356, 'IPIALES'),
(750, 17, 378, 'LA CRUZ'),
(751, 17, 381, 'LA FLORIDA'),
(752, 17, 385, 'LA LLANADA'),
(753, 17, 390, 'LA TOLA'),
(754, 17, 399, 'LA UNION'),
(755, 17, 405, 'LEIVA'),
(756, 17, 411, 'LINARES'),
(757, 17, 418, 'LOS ANDES (SOTOMAYOR)'),
(758, 17, 427, 'MAGUI (PAYAN)'),
(759, 17, 435, 'MALLAMA (PIEDRANCHA)'),
(760, 17, 473, 'MOSQUERA'),
(761, 17, 490, 'OLAYA HERRERA (BOCAS DE SATINGA)'),
(762, 17, 506, 'OSPINA'),
(763, 17, 520, 'FRANCISCO PIZARRO (SALAHONDA)'),
(764, 17, 540, 'POLICARPA'),
(765, 17, 560, 'POTOSI'),
(766, 17, 565, 'PROVIDENCIA'),
(767, 17, 573, 'PUERRES'),
(768, 17, 585, 'PUPIALES'),
(769, 17, 612, 'RICAURTE'),
(770, 17, 621, 'ROBERTO PAYAN (SAN JOSE)'),
(771, 17, 678, 'SAMANIEGO'),
(772, 17, 683, 'SANDONA'),
(773, 17, 685, 'SAN BERNARDO'),
(774, 17, 687, 'SAN LORENZO'),
(775, 17, 693, 'SAN PABLO'),
(776, 17, 694, 'SAN PEDRO DE CARTAGO'),
(777, 17, 696, 'SANTA BARBARA (ISCUANDE)'),
(778, 17, 699, 'SANTA CRUZ (GUACHAVES)'),
(779, 17, 720, 'SAPUYES'),
(780, 17, 786, 'TAMINANGO'),
(781, 17, 788, 'TANGUA'),
(782, 17, 835, 'TUMACO'),
(783, 17, 838, 'TUQUERRES'),
(784, 17, 885, 'YACUANQUER'),
(785, 18, 1, 'CUCUTA'),
(786, 18, 3, 'ABREGO'),
(787, 18, 51, 'ARBOLEDAS'),
(788, 18, 99, 'BOCHALEMA'),
(789, 18, 109, 'BUCARASICA'),
(790, 18, 125, 'CACOTA'),
(791, 18, 128, 'CACHIRA'),
(792, 18, 172, 'CHINACOTA'),
(793, 18, 174, 'CHITAGA'),
(794, 18, 206, 'CONVENCION'),
(795, 18, 223, 'CUCUTILLA'),
(796, 18, 239, 'DURANIA'),
(797, 18, 245, 'EL CARMEN'),
(798, 18, 250, 'EL TARRA'),
(799, 18, 261, 'EL ZULIA'),
(800, 18, 313, 'GRAMALOTE'),
(801, 18, 344, 'HACARI'),
(802, 18, 347, 'HERRAN'),
(803, 18, 377, 'LABATECA'),
(804, 18, 385, 'LA ESPERANZA'),
(805, 18, 398, 'LA PLAYA'),
(806, 18, 405, 'LOS PATIOS'),
(807, 18, 418, 'LOURDES'),
(808, 18, 480, 'MUTISCUA'),
(809, 18, 498, 'OCAÑA'),
(810, 18, 518, 'PAMPLONA'),
(811, 18, 520, 'PAMPLONITA'),
(812, 18, 553, 'PUERTO SANTANDER'),
(813, 18, 599, 'RAGONVALIA'),
(814, 18, 660, 'SALAZAR'),
(815, 18, 670, 'SAN CALIXTO'),
(816, 18, 673, 'SAN CAYETANO'),
(817, 18, 680, 'SANTIAGO'),
(818, 18, 720, 'SARDINATA'),
(819, 18, 743, 'SILOS'),
(820, 18, 800, 'TEORAMA'),
(821, 18, 810, 'TIBU'),
(822, 18, 820, 'TOLEDO'),
(823, 18, 871, 'VILLACARO'),
(824, 18, 874, 'VILLA DEL ROSARIO'),
(825, 19, 1, 'ARMENIA'),
(826, 19, 111, 'BUENAVISTA'),
(827, 19, 130, 'CALARCA'),
(828, 19, 190, 'CIRCASIA'),
(829, 19, 212, 'CORDOBA'),
(830, 19, 272, 'FILANDIA'),
(831, 19, 302, 'GENOVA'),
(832, 19, 401, 'LA TEBAIDA'),
(833, 19, 470, 'MONTENEGRO'),
(834, 19, 548, 'PIJAO'),
(835, 19, 594, 'QUIMBAYA'),
(836, 19, 690, 'SALENTO'),
(837, 20, 1, 'PEREIRA'),
(838, 20, 45, 'APIA'),
(839, 20, 75, 'BALBOA'),
(840, 20, 88, 'BELEN DE UMBRIA'),
(841, 20, 170, 'DOS QUEBRADAS'),
(842, 20, 318, 'GUATICA'),
(843, 20, 383, 'LA CELIA'),
(844, 20, 400, 'LA VIRGINIA'),
(845, 20, 440, 'MARSELLA'),
(846, 20, 456, 'MISTRATO'),
(847, 20, 572, 'PUEBLO RICO'),
(848, 20, 594, 'QUINCHIA'),
(849, 20, 682, 'SANTA ROSA DE CABAL'),
(850, 20, 687, 'SANTUARIO'),
(851, 21, 1, 'BUCARAMANGA'),
(852, 21, 13, 'AGUADA'),
(853, 21, 20, 'ALBANIA'),
(854, 21, 51, 'ARATOCA'),
(855, 21, 77, 'BARBOSA'),
(856, 21, 79, 'BARICHARA'),
(857, 21, 81, 'BARRANCABERMEJA'),
(858, 21, 92, 'BETULIA'),
(859, 21, 101, 'BOLIVAR'),
(860, 21, 121, 'CABRERA'),
(861, 21, 132, 'CALIFORNIA'),
(862, 21, 147, 'CAPITANEJO'),
(863, 21, 152, 'CARCASI'),
(864, 21, 160, 'CEPITA'),
(865, 21, 162, 'CERRITO'),
(866, 21, 167, 'CHARALA'),
(867, 21, 169, 'CHARTA'),
(868, 21, 176, 'CHIMA'),
(869, 21, 179, 'CHIPATA'),
(870, 21, 190, 'CIMITARRA'),
(871, 21, 207, 'CONCEPCION'),
(872, 21, 209, 'CONFINES'),
(873, 21, 211, 'CONTRATACION'),
(874, 21, 217, 'COROMORO'),
(875, 21, 229, 'CURITI'),
(876, 21, 235, 'EL CARMEN DE CHUCURY'),
(877, 21, 245, 'EL GUACAMAYO'),
(878, 21, 250, 'EL PEÑON'),
(879, 21, 255, 'EL PLAYON'),
(880, 21, 264, 'ENCINO'),
(881, 21, 266, 'ENCISO'),
(882, 21, 271, 'FLORIAN'),
(883, 21, 276, 'FLORIDABLANCA'),
(884, 21, 296, 'GALAN'),
(885, 21, 298, 'GAMBITA'),
(886, 21, 307, 'GIRON'),
(887, 21, 318, 'GUACA'),
(888, 21, 320, 'GUADALUPE'),
(889, 21, 322, 'GUAPOTA'),
(890, 21, 324, 'GUAVATA'),
(891, 21, 327, 'GUEPSA'),
(892, 21, 344, 'HATO'),
(893, 21, 368, 'JESUS MARIA'),
(894, 21, 370, 'JORDAN'),
(895, 21, 377, 'LA BELLEZA'),
(896, 21, 385, 'LANDAZURI'),
(897, 21, 397, 'LA PAZ'),
(898, 21, 406, 'LEBRIJA'),
(899, 21, 418, 'LOS SANTOS'),
(900, 21, 425, 'MACARAVITA'),
(901, 21, 432, 'MALAGA'),
(902, 21, 444, 'MATANZA'),
(903, 21, 464, 'MOGOTES'),
(904, 21, 468, 'MOLAGAVITA'),
(905, 21, 498, 'OCAMONTE'),
(906, 21, 500, 'OIBA'),
(907, 21, 502, 'ONZAGA'),
(908, 21, 522, 'PALMAR'),
(909, 21, 524, 'PALMAS DEL SOCORRO'),
(910, 21, 533, 'PARAMO'),
(911, 21, 547, 'PIEDECUESTA'),
(912, 21, 549, 'PINCHOTE'),
(913, 21, 572, 'PUENTE NACIONAL'),
(914, 21, 573, 'PUERTO PARRA'),
(915, 21, 575, 'PUERTO WILCHES'),
(916, 21, 615, 'RIONEGRO'),
(917, 21, 655, 'SABANA DE TORRES'),
(918, 21, 669, 'SAN ANDRES'),
(919, 21, 673, 'SAN BENITO'),
(920, 21, 679, 'SAN GIL'),
(921, 21, 682, 'SAN JOAQUIN'),
(922, 21, 684, 'SAN JOSE DE MIRANDA'),
(923, 21, 686, 'SAN MIGUEL'),
(924, 21, 689, 'SAN VICENTE DE CHUCURI'),
(925, 21, 705, 'SANTA BARBARA'),
(926, 21, 720, 'SANTA HELENA DEL OPON'),
(927, 21, 745, 'SIMACOTA'),
(928, 21, 755, 'SOCORRO'),
(929, 21, 770, 'SUAITA'),
(930, 21, 773, 'SUCRE'),
(931, 21, 780, 'SURATA'),
(932, 21, 820, 'TONA'),
(933, 21, 855, 'VALLE SAN JOSE'),
(934, 21, 861, 'VELEZ'),
(935, 21, 867, 'VETAS'),
(936, 21, 872, 'VILLANUEVA'),
(937, 21, 895, 'ZAPATOCA'),
(938, 22, 1, 'SINCELEJO'),
(939, 22, 110, 'BUENAVISTA'),
(940, 22, 124, 'CAIMITO'),
(941, 22, 204, 'COLOSO (RICAURTE)'),
(942, 22, 215, 'COROZAL'),
(943, 22, 230, 'CHALAN'),
(944, 22, 235, 'GALERAS (NUEVA GRANADA)'),
(945, 22, 265, 'GUARANDA'),
(946, 22, 400, 'LA UNION'),
(947, 22, 418, 'LOS PALMITOS'),
(948, 22, 429, 'MAJAGUAL'),
(949, 22, 473, 'MORROA'),
(950, 22, 508, 'OVEJAS'),
(951, 22, 523, 'PALMITO'),
(952, 22, 670, 'SAMPUES'),
(953, 22, 678, 'SAN BENITO ABAD'),
(954, 22, 702, 'SAN JUAN DE BETULIA'),
(955, 22, 708, 'SAN MARCOS'),
(956, 22, 713, 'SAN ONOFRE'),
(957, 22, 717, 'SAN PEDRO'),
(958, 22, 742, 'SINCE'),
(959, 22, 771, 'SUCRE'),
(960, 22, 820, 'TOLU'),
(961, 22, 823, 'TOLUVIEJO'),
(962, 23, 1, 'IBAGUE'),
(963, 23, 24, 'ALPUJARRA'),
(964, 23, 26, 'ALVARADO'),
(965, 23, 30, 'AMBALEMA'),
(966, 23, 43, 'ANZOATEGUI'),
(967, 23, 55, 'ARMERO (GUAYABAL)'),
(968, 23, 67, 'ATACO'),
(969, 23, 124, 'CAJAMARCA'),
(970, 23, 148, 'CARMEN APICALA'),
(971, 23, 152, 'CASABIANCA'),
(972, 23, 168, 'CHAPARRAL'),
(973, 23, 200, 'COELLO'),
(974, 23, 217, 'COYAIMA'),
(975, 23, 226, 'CUNDAY'),
(976, 23, 236, 'DOLORES'),
(977, 23, 268, 'ESPINAL'),
(978, 23, 270, 'FALAN'),
(979, 23, 275, 'FLANDES'),
(980, 23, 283, 'FRESNO'),
(981, 23, 319, 'GUAMO'),
(982, 23, 347, 'HERVEO'),
(983, 23, 349, 'HONDA'),
(984, 23, 352, 'ICONONZO'),
(985, 23, 408, 'LERIDA'),
(986, 23, 411, 'LIBANO'),
(987, 23, 443, 'MARIQUITA'),
(988, 23, 449, 'MELGAR'),
(989, 23, 461, 'MURILLO'),
(990, 23, 483, 'NATAGAIMA'),
(991, 23, 504, 'ORTEGA'),
(992, 23, 520, 'PALOCABILDO'),
(993, 23, 547, 'PIEDRAS'),
(994, 23, 555, 'PLANADAS'),
(995, 23, 563, 'PRADO'),
(996, 23, 585, 'PURIFICACION'),
(997, 23, 616, 'RIOBLANCO'),
(998, 23, 622, 'RONCESVALLES'),
(999, 23, 624, 'ROVIRA'),
(1000, 23, 671, 'SALDAÑA'),
(1001, 23, 675, 'SAN ANTONIO'),
(1002, 23, 678, 'SAN LUIS'),
(1003, 23, 686, 'SANTA ISABEL'),
(1004, 23, 770, 'SUAREZ'),
(1005, 23, 854, 'VALLE DE SAN JUAN'),
(1006, 23, 861, 'VENADILLO'),
(1007, 23, 870, 'VILLAHERMOSA'),
(1008, 23, 873, 'VILLARRICA'),
(1009, 24, 1, 'CALI (SANTIAGO DE CALI)'),
(1010, 24, 20, 'ALCALA'),
(1011, 24, 36, 'ANDALUCIA'),
(1012, 24, 41, 'ANSERMANUEVO'),
(1013, 24, 54, 'ARGELIA'),
(1014, 24, 100, 'BOLIVAR'),
(1015, 24, 109, 'BUENAVENTURA'),
(1016, 24, 111, 'BUGA'),
(1017, 24, 113, 'BUGALAGRANDE'),
(1018, 24, 122, 'CAICEDONIA'),
(1019, 24, 126, 'CALIMA (DARIEN)'),
(1020, 24, 130, 'CANDELARIA'),
(1021, 24, 147, 'CARTAGO'),
(1022, 24, 233, 'DAGUA'),
(1023, 24, 243, 'EL AGUILA'),
(1024, 24, 246, 'EL CAIRO'),
(1025, 24, 248, 'EL CERRITO'),
(1026, 24, 250, 'EL DOVIO'),
(1027, 24, 275, 'FLORIDA'),
(1028, 24, 306, 'GINEBRA'),
(1029, 24, 318, 'GUACARI'),
(1030, 24, 364, 'JAMUNDI'),
(1031, 24, 377, 'LA CUMBRE'),
(1032, 24, 400, 'LA UNION'),
(1033, 24, 403, 'LA VICTORIA'),
(1034, 24, 497, 'OBANDO'),
(1035, 24, 520, 'PALMIRA'),
(1036, 24, 563, 'PRADERA'),
(1037, 24, 606, 'RESTREPO'),
(1038, 24, 616, 'RIOFRIO'),
(1039, 24, 622, 'ROLDANILLO'),
(1040, 24, 670, 'SAN PEDRO'),
(1041, 24, 736, 'SEVILLA'),
(1042, 24, 823, 'TORO'),
(1043, 24, 828, 'TRUJILLO'),
(1044, 24, 834, 'TULUA'),
(1045, 24, 845, 'ULLOA'),
(1046, 24, 863, 'VERSALLES'),
(1047, 24, 869, 'VIJES'),
(1048, 24, 890, 'YOTOCO'),
(1049, 24, 892, 'YUMBO'),
(1050, 24, 895, 'ZARZAL'),
(1051, 25, 1, 'ARAUCA'),
(1052, 25, 65, 'ARAUQUITA'),
(1053, 25, 220, 'CRAVO NORTE'),
(1054, 25, 300, 'FORTUL'),
(1055, 25, 591, 'PUERTO RONDON'),
(1056, 25, 736, 'SARAVENA'),
(1057, 25, 794, 'TAME'),
(1058, 26, 1, 'YOPAL'),
(1059, 26, 10, 'AGUAZUL'),
(1060, 26, 15, 'CHAMEZA'),
(1061, 26, 125, 'HATO COROZAL'),
(1062, 26, 136, 'LA SALINA'),
(1063, 26, 139, 'MANI'),
(1064, 26, 162, 'MONTERREY'),
(1065, 26, 225, 'NUNCHIA'),
(1066, 26, 230, 'OROCUE'),
(1067, 26, 250, 'PAZ DE ARIPORO'),
(1068, 26, 263, 'PORE'),
(1069, 26, 279, 'RECETOR'),
(1070, 26, 300, 'SABANALARGA'),
(1071, 26, 315, 'SACAMA'),
(1072, 26, 325, 'SAN LUIS DE PALENQUE'),
(1073, 26, 400, 'TAMARA'),
(1074, 26, 410, 'TAURAMENA'),
(1075, 26, 430, 'TRINIDAD'),
(1076, 26, 440, 'VILLANUEVA'),
(1077, 27, 1, 'MOCOA'),
(1078, 27, 219, 'COLON'),
(1079, 27, 320, 'ORITO'),
(1080, 27, 568, 'PUERTO ASIS'),
(1081, 27, 569, 'PUERTO CAICEDO'),
(1082, 27, 571, 'PUERTO GUZMAN'),
(1083, 27, 573, 'PUERTO LEGUIZAMO'),
(1084, 27, 749, 'SIBUNDOY'),
(1085, 27, 755, 'SAN FRANCISCO'),
(1086, 27, 757, 'SAN MIGUEL (LA DORADA)'),
(1087, 27, 760, 'SANTIAGO'),
(1088, 27, 865, 'LA HORMIGA (VALLE DEL GUAMUEZ)'),
(1089, 27, 885, 'VILLAGARZON'),
(1090, 28, 1, 'SAN ANDRES'),
(1091, 28, 564, 'PROVIDENCIA'),
(1092, 29, 1, 'LETICIA'),
(1093, 29, 263, 'EL ENCANTO'),
(1094, 29, 405, 'LA CHORRERA'),
(1095, 29, 407, 'LA PEDRERA'),
(1096, 29, 430, 'LA VICTORIA'),
(1097, 29, 460, 'MIRITI-PARANA'),
(1098, 29, 530, 'PUERTO ALEGRIA'),
(1099, 29, 536, 'PUERTO ARICA'),
(1100, 29, 540, 'PUERTO NARIÑO'),
(1101, 29, 669, 'PUERTO SANTANDER'),
(1102, 29, 798, 'TARAPACA'),
(1103, 30, 1, 'PUERTO INIRIDA'),
(1104, 30, 343, 'BARRANCO MINAS'),
(1105, 30, 883, 'SAN FELIPE'),
(1106, 30, 884, 'PUERTO COLOMBIA'),
(1107, 30, 885, 'LA GUADALUPE'),
(1108, 30, 886, 'CACAHUAL'),
(1109, 30, 887, 'PANA PANA (CAMPO ALEGRE)'),
(1110, 30, 888, 'MORICHAL (MORICHAL NUEVO)'),
(1111, 31, 1, 'SAN JOSE DEL GUAVIARE'),
(1112, 31, 15, 'CALAMAR'),
(1113, 31, 25, 'EL RETORNO'),
(1114, 31, 200, 'MIRAFLORES'),
(1115, 32, 1, 'MITU'),
(1116, 32, 161, 'CARURU'),
(1117, 32, 511, 'PACOA'),
(1118, 32, 666, 'TARAIRA'),
(1119, 32, 777, 'PAPUNAUA (MORICHAL)'),
(1120, 32, 889, 'YAVARATE'),
(1121, 33, 1, 'PUERTO CARREÑO'),
(1122, 33, 524, 'LA PRIMAVERA'),
(1123, 33, 572, 'SANTA RITA'),
(1124, 33, 666, 'SANTA ROSALIA'),
(1125, 33, 760, 'SAN JOSE DE OCUNE'),
(1126, 33, 773, 'CUMARIBO'),
(1127, 34, 2000, 'No aplica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nominados`
--

CREATE TABLE `nominados` (
  `id` int(11) NOT NULL,
  `id_form` int(8) NOT NULL,
  `id_nominado` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `tipo_nota` varchar(80) NOT NULL,
  `dirigido` varchar(80) NOT NULL,
  `id_cargo` int(2) NOT NULL,
  `id_sede` int(2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion_nota` text NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `direccion` varchar(128) DEFAULT NULL,
  `telefono` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `id_municipio` int(11) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre`, `direccion`, `telefono`, `email`, `id_municipio`, `estado`) VALUES
(1, 'Armenia (Principal)', 'CARRERA 18 # 12-25', '67107857', 'gerencia@quindipisos.com', 825, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte`
--

CREATE TABLE `soporte` (
  `id` int(11) NOT NULL,
  `id_autor` int(8) NOT NULL,
  `id_modulo` int(2) NOT NULL,
  `estado` varchar(64) NOT NULL DEFAULT 'Nuevo',
  `tipo` varchar(64) NOT NULL,
  `imagen` text NOT NULL,
  `descripcion` text NOT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

CREATE TABLE `tipo_usuarios` (
  `id` int(11) NOT NULL,
  `nombre_tipo` varchar(64) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuarios`
--

INSERT INTO `tipo_usuarios` (`id`, `nombre_tipo`, `descripcion`, `estado`) VALUES
(1, 'Super Administrador', 'El súper administrador tiene acceso total a todos los módulos', 1),
(2, 'Administrador', 'El administrador tiene acceso total a todos los módulos\r\n\r\nNo puede asignar todos los roles excepto administradores', 1),
(3, 'Colaborador', NULL, 1),
(4, 'Cliente', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(8) NOT NULL,
  `estado` int(1) NOT NULL,
  `id_cargo` int(2) NOT NULL,
  `id_sede` int(2) NOT NULL,
  `id_tipo_usuario` int(2) NOT NULL,
  `nombre_completo` varchar(128) NOT NULL,
  `doc_id` varchar(32) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(32) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(32) DEFAULT NULL,
  `avatar` text NOT NULL,
  `usuario_login` varchar(255) NOT NULL,
  `pass_login` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `ciudad_residencia` int(11) DEFAULT NULL,
  `facebook` text DEFAULT NULL,
  `instagram` text DEFAULT NULL,
  `youtube` text DEFAULT NULL,
  `tiktok` text DEFAULT NULL,
  `inf_usuario` text DEFAULT NULL,
  `firma_digital` text NOT NULL,
  `menu` int(1) NOT NULL DEFAULT 0,
  `contacto_emergencia` varchar(128) DEFAULT NULL,
  `parentezco_contacto` varchar(64) DEFAULT NULL,
  `telefono_contacto` varchar(16) DEFAULT NULL,
  `eps` varchar(32) DEFAULT NULL,
  `tipo_sangre` varchar(16) DEFAULT NULL,
  `nivel_academico` varchar(32) DEFAULT NULL,
  `profesion` varchar(128) DEFAULT NULL,
  `experiencia` int(2) DEFAULT NULL,
  `fondo` varchar(32) DEFAULT NULL,
  `cesantias` varchar(32) DEFAULT NULL,
  `nombre_madre` varchar(64) DEFAULT NULL,
  `telefono_madre` varchar(10) DEFAULT NULL,
  `nombre_padre` varchar(64) DEFAULT NULL,
  `telefono_padre` varchar(32) DEFAULT NULL,
  `estrato` int(6) DEFAULT NULL,
  `estado_civil` varchar(16) DEFAULT NULL,
  `grupo_etnico` varchar(32) DEFAULT NULL,
  `personas_cargo` int(2) DEFAULT NULL,
  `cabeza_familia` int(1) DEFAULT NULL,
  `hijos` int(2) DEFAULT NULL,
  `fuma` int(1) DEFAULT NULL,
  `fuma_frecuencia` varchar(128) DEFAULT NULL,
  `bebidas` int(1) DEFAULT NULL,
  `bebidas_frecuencia` varchar(128) DEFAULT NULL,
  `deporte` varchar(128) DEFAULT NULL,
  `talla_camisa` varchar(32) DEFAULT NULL,
  `talla_pantalon` varchar(32) DEFAULT NULL,
  `talla_calzado` varchar(32) DEFAULT NULL,
  `tipo_vivienda` varchar(32) DEFAULT NULL,
  `licencia_conduccion` int(1) DEFAULT NULL,
  `licencia_descr` varchar(64) DEFAULT NULL,
  `act_tiempo_libre` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `estado`, `id_cargo`, `id_sede`, `id_tipo_usuario`, `nombre_completo`, `doc_id`, `direccion`, `telefono`, `fecha_nacimiento`, `genero`, `avatar`, `usuario_login`, `pass_login`, `email`, `fecha_creacion`, `ciudad_residencia`, `facebook`, `instagram`, `youtube`, `tiktok`, `inf_usuario`, `firma_digital`, `menu`, `contacto_emergencia`, `parentezco_contacto`, `telefono_contacto`, `eps`, `tipo_sangre`, `nivel_academico`, `profesion`, `experiencia`, `fondo`, `cesantias`, `nombre_madre`, `telefono_madre`, `nombre_padre`, `telefono_padre`, `estrato`, `estado_civil`, `grupo_etnico`, `personas_cargo`, `cabeza_familia`, `hijos`, `fuma`, `fuma_frecuencia`, `bebidas`, `bebidas_frecuencia`, `deporte`, `talla_camisa`, `talla_pantalon`, `talla_calzado`, `tipo_vivienda`, `licencia_conduccion`, `licencia_descr`, `act_tiempo_libre`) VALUES
(1, 1, 1, 1, 1, 'Super Administrador', '', '', '', '1984-12-06', 'Masculino', 'superman.gif', 'Administrador', 'ca504360e97fb6fd9024e080f4f3fbba', 'jpfb1206@gmail.com', '2023-09-05 00:00:00', 825, NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_compensacion`
--

CREATE TABLE `usuario_compensacion` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `dias` int(2) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_dias_compensar`
--

CREATE TABLE `usuario_dias_compensar` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cant_dias` int(2) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_personas_cargo`
--

CREATE TABLE `usuario_personas_cargo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `fecha_nac` date NOT NULL,
  `parentezco` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_solicitudes`
--

CREATE TABLE `usuario_solicitudes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(32) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `estado` int(1) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date DEFAULT NULL,
  `cantidad` int(2) NOT NULL,
  `compensados` int(2) DEFAULT 0,
  `observaciones` text NOT NULL,
  `id_aprobador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voto_nominacion`
--

CREATE TABLE `voto_nominacion` (
  `id` int(11) NOT NULL,
  `id_autor_respuesta` int(8) NOT NULL,
  `id_nominado` int(8) NOT NULL,
  `fecha` date NOT NULL,
  `id_encuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alergias`
--
ALTER TABLE `alergias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `antecedentes`
--
ALTER TABLE `antecedentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cirugias`
--
ALTER TABLE `cirugias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colaboradores_mes`
--
ALTER TABLE `colaboradores_mes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario_historia`
--
ALTER TABLE `comentario_historia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_autor_historia` (`id_autor`),
  ADD KEY `fk_id_historia` (`id_historia`);

--
-- Indices de la tabla `compensacion_detalle`
--
ALTER TABLE `compensacion_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conexiones`
--
ALTER TABLE `conexiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conexion_usuario` (`id_usuario`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `envio_correos`
--
ALTER TABLE `envio_correos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudios`
--
ALTER TABLE `estudios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historia`
--
ALTER TABLE `historia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `incapacidades`
--
ALTER TABLE `incapacidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lesiones`
--
ALTER TABLE `lesiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulos_cargos`
--
ALTER TABLE `modulos_cargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modulo_cargo` (`id_cargo`),
  ADD KEY `fk_cargo_modulo` (`id_modulo`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_departamento_municipio` (`departamento_id`);

--
-- Indices de la tabla `nominados`
--
ALTER TABLE `nominados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_encuesta` (`id_form`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_autor_fk` (`id_autor`),
  ADD KEY `nota_usuario_fk` (`id_usuario`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modulo_soporte` (`id_modulo`),
  ADD KEY `fk_soporte_usuario` (`id_autor`);

--
-- Indices de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cargo_usuario` (`id_cargo`),
  ADD KEY `fk_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `fk_municipio_usuario` (`ciudad_residencia`);

--
-- Indices de la tabla `usuario_compensacion`
--
ALTER TABLE `usuario_compensacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_dias_compensar`
--
ALTER TABLE `usuario_dias_compensar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_personas_cargo`
--
ALTER TABLE `usuario_personas_cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_solicitudes`
--
ALTER TABLE `usuario_solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `voto_nominacion`
--
ALTER TABLE `voto_nominacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nominado` (`id_nominado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alergias`
--
ALTER TABLE `alergias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `antecedentes`
--
ALTER TABLE `antecedentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cirugias`
--
ALTER TABLE `cirugias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `colaboradores_mes`
--
ALTER TABLE `colaboradores_mes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentario_historia`
--
ALTER TABLE `comentario_historia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compensacion_detalle`
--
ALTER TABLE `compensacion_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conexiones`
--
ALTER TABLE `conexiones`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio_correos`
--
ALTER TABLE `envio_correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudios`
--
ALTER TABLE `estudios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historia`
--
ALTER TABLE `historia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incapacidades`
--
ALTER TABLE `incapacidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lesiones`
--
ALTER TABLE `lesiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `modulos_cargos`
--
ALTER TABLE `modulos_cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1128;

--
-- AUTO_INCREMENT de la tabla `nominados`
--
ALTER TABLE `nominados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `soporte`
--
ALTER TABLE `soporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario_compensacion`
--
ALTER TABLE `usuario_compensacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_dias_compensar`
--
ALTER TABLE `usuario_dias_compensar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_personas_cargo`
--
ALTER TABLE `usuario_personas_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_solicitudes`
--
ALTER TABLE `usuario_solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `voto_nominacion`
--
ALTER TABLE `voto_nominacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `conexiones`
--
ALTER TABLE `conexiones`
  ADD CONSTRAINT `fk_conexion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `modulos_cargos`
--
ALTER TABLE `modulos_cargos`
  ADD CONSTRAINT `fk_cargo_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`),
  ADD CONSTRAINT `fk_modulo_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`);

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `fk_departamento_municipio` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`);

--
-- Filtros para la tabla `nominados`
--
ALTER TABLE `nominados`
  ADD CONSTRAINT `fk_encuesta` FOREIGN KEY (`id_form`) REFERENCES `encuesta` (`id`);

--
-- Filtros para la tabla `soporte`
--
ALTER TABLE `soporte`
  ADD CONSTRAINT `fk_modulo_soporte` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`),
  ADD CONSTRAINT `fk_soporte_usuario` FOREIGN KEY (`id_autor`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_cargo_usuario` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`),
  ADD CONSTRAINT `fk_municipio_usuario` FOREIGN KEY (`ciudad_residencia`) REFERENCES `municipios` (`id`),
  ADD CONSTRAINT `fk_tipo_usuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuarios` (`id`);

--
-- Filtros para la tabla `voto_nominacion`
--
ALTER TABLE `voto_nominacion`
  ADD CONSTRAINT `fk_nominado` FOREIGN KEY (`id_nominado`) REFERENCES `nominados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
