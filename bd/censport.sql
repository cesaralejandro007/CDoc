-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2024 a las 17:12:41
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `censport`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id_area` int(11) NOT NULL,
  `id_division` int(11) NOT NULL,
  `nombre_area` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id_area`, `id_division`, `nombre_area`) VALUES
(1, 1, 'Informatica'),
(2, 1, 'Área de Recursos Humanos'),
(3, 1, 'Área de Bienes Nacionales'),
(4, 1, 'Despacho de la División de Administración'),
(5, 1, 'Área de Compras'),
(6, 1, 'Área de Almacén'),
(7, 1, 'Área de Presupuesto'),
(8, 1, 'Área de Contabilidad'),
(9, 1, 'Área de Tesorería'),
(10, 1, 'Coordinación de Infraestructura y Servicios'),
(11, 1, 'Área de Viáticos'),
(12, 2, 'Despacho de Gerencia'),
(13, 2, 'Resguardo'),
(14, 2, 'Seguridad'),
(15, 3, 'Despacho Asistencia al Contribuyente'),
(16, 3, 'Área de Prensa'),
(17, 4, 'Área De Cobranzas'),
(18, 4, 'Modulo de Inserción'),
(19, 4, 'Modulo Exoneración'),
(20, 4, 'Modulo de Remisión'),
(21, 4, 'Registro de Cta./Corriente'),
(22, 4, 'Despacho División de Recaudación'),
(23, 4, 'Modulo de Retenciones'),
(24, 4, 'Entes Públicos'),
(25, 4, 'Área de Sucesiones'),
(26, 4, 'Modulo Investigación Patrimonial'),
(27, 4, 'Área de Rif'),
(28, 4, 'Área de Licores'),
(29, 4, 'Liquidación'),
(30, 4, 'Reintegro y Devoluciones'),
(31, 4, 'Timbres Fiscales'),
(32, 5, 'Despacho Fiscalización'),
(33, 5, 'Fiscalización General'),
(34, 5, 'Avaluo'),
(35, 5, 'Selección Previa'),
(36, 5, 'Deberes Formales'),
(37, 5, 'Beneficios Fiscales'),
(38, 5, 'Fondo y Semi Fondo'),
(39, 5, 'Planificación y Control de Gestión'),
(40, 6, 'Despacho División de Sumario'),
(41, 6, 'Área de Sustanciación de Sumario'),
(42, 7, 'Área Cobro Judicial'),
(43, 7, 'Recursos Administrativo y Jurídico'),
(44, 7, 'Despacho de la División'),
(45, 7, 'Contencioso Tributario'),
(46, 7, 'Sustanciación'),
(47, 8, 'Área de Notificación'),
(48, 8, 'Área de Vivienda Principal'),
(49, 8, 'Área de Archivo General'),
(50, 8, 'Área de Correspondencia'),
(51, 8, 'Despacho de la División'),
(52, 9, 'Área Control de Obligación'),
(53, 9, 'Cobranza'),
(54, 9, 'Área Control Bancario'),
(55, 9, 'Asistencia al Contribuyente'),
(56, 9, 'Despacho de la División'),
(57, 9, 'Modulo de Correcciones y Análisis de Cuentas'),
(58, 9, 'Contribuyentes Especiales Punto Fijo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deportes`
--

CREATE TABLE `deportes` (
  `id_deporte` int(11) NOT NULL,
  `nombre_deporte` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `deportes`
--

INSERT INTO `deportes` (`id_deporte`, `nombre_deporte`) VALUES
(1, 'Fútbol'),
(2, 'Baloncesto'),
(3, 'Tenis'),
(4, 'Natación'),
(5, 'Atletismo'),
(6, 'Voleibol'),
(7, 'Golf'),
(8, 'Béisbol'),
(9, 'Rugby'),
(10, 'Ciclismo'),
(11, 'Boxeo'),
(12, 'Hockey'),
(13, 'Escalada'),
(14, 'Surf'),
(15, 'Esquí'),
(16, 'Taekwondo'),
(17, 'Karate'),
(18, 'Judo'),
(20, 'Patinaje'),
(21, 'Gimnasia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones`
--

CREATE TABLE `divisiones` (
  `id_division` int(11) NOT NULL,
  `nombre_division` text NOT NULL,
  `descripcion_division` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `divisiones`
--

INSERT INTO `divisiones` (`id_division`, `nombre_division`, `descripcion_division`) VALUES
(1, 'Administracion', 'ADM'),
(2, 'Gerencia Regional de Tributos Internos', 'GTI'),
(3, 'División Asistencia al Contribuyente', 'AC'),
(4, 'División de Recaudación', 'RE'),
(5, 'División de Fiscalizacíon', 'FI'),
(6, 'División de Sumario Administrativo', 'SA'),
(7, 'División de Jurídico Tributario ', 'JT'),
(8, 'División de Tramitaciones', 'TR'),
(9, 'División de Contribuyentes Especiales', 'CE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_deportivos`
--

CREATE TABLE `grupos_deportivos` (
  `id_grupo_deportivo` int(11) NOT NULL,
  `nombre_grupo` text NOT NULL,
  `descripcion_grupo` text NOT NULL,
  `estado` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `cedula` varchar(11) NOT NULL,
  `nombres` varchar(25) NOT NULL,
  `apellidos` varchar(25) NOT NULL,
  `sexo` varchar(9) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_ingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `id_area`, `cedula`, `nombres`, `apellidos`, `sexo`, `telefono`, `fecha_nacimiento`, `fecha_ingreso`) VALUES
(81, 1, '20784563', 'Juliana', 'Martínez Pérez', 'Femenino', '0412-1234567', '1995-08-10', '2020-11-15'),
(82, 2, '18459632', 'Andrés Felipe', 'Gómez López', 'Masculino', '0416-9876543', '1988-04-25', '2019-10-03'),
(83, 3, '31587421', 'Carolina', 'Rodríguez García', 'Femenino', '0424-4567890', '1990-12-15', '2018-05-20'),
(84, 4, '26298547', 'José Luis', 'Fernández Pérez', 'Masculino', '0412-3698521', '1982-07-08', '2017-08-30'),
(85, 5, '19574563', 'Valeria', 'Hernández Vargas', 'Femenino', '0426-9876543', '1998-02-18', '2016-03-10'),
(86, 6, '30497456', 'Diego Alejandro', 'Sánchez González', 'Masculino', '0412-6549873', '1987-09-20', '2015-06-25'),
(87, 7, '21548796', 'Laura Daniela', 'García Pérez', 'Femenino', '0424-1234567', '1993-05-30', '2014-09-12'),
(88, 8, '28965478', 'Pedro José', 'Ramírez Rodríguez', 'Masculino', '0416-7890123', '1980-11-05', '2013-12-01'),
(89, 9, '27489631', 'Isabella', 'López Martínez', 'Femenino', '0426-4567890', '1996-03-12', '2012-02-22'),
(90, 1, '28741592', 'Gabriel Alejandro', 'Santos Pérez', 'Masculino', '0412-6543210', '1991-09-28', '2020-01-14'),
(91, 2, '19987456', 'Valentina', 'Fernández Gómez', 'Femenino', '0416-1234567', '1985-06-17', '2019-04-03'),
(92, 3, '30124589', 'Andrés', 'Gutiérrez Martínez', 'Masculino', '0424-7890123', '1977-03-05', '2018-07-18'),
(93, 4, '26897451', 'Camila', 'Pérez González', 'Femenino', '0412-9876543', '1997-11-23', '2017-10-27'),
(94, 5, '20874563', 'Diego', 'Martínez Rodríguez', 'Masculino', '0426-4567890', '1992-08-12', '2016-01-09'),
(95, 6, '30216547', 'Valeria', 'Gómez Hernández', 'Femenino', '0412-3698521', '1983-12-30', '2015-04-22'),
(96, 7, '28547136', 'Javier', 'López Sánchez', 'Masculino', '0424-6549873', '1994-04-19', '2014-08-05'),
(97, 8, '29874512', 'Lucía', 'Ramírez Pérez', 'Femenino', '0416-1237890', '1989-10-08', '2013-11-30'),
(98, 9, '27148963', 'Mateo', 'Hernández González', 'Masculino', '0426-9876543', '1994-07-15', '2012-03-16'),
(99, 1, '28459613', 'María Fernanda', 'García López', 'Femenino', '0412-4567890', '1990-04-02', '2021-02-15'),
(100, 2, '29785412', 'José Manuel', 'Rodríguez Martínez', 'Masculino', '0416-9876543', '1986-11-29', '2020-09-23'),
(101, 3, '31625478', 'Daniela', 'García Rodríguez', 'Femenino', '0424-7890123', '1981-06-05', '2019-12-11'),
(102, 4, '25987456', 'Carlos Andrés', 'Martínez González', 'Masculino', '0412-1234567', '1979-10-20', '2018-03-25'),
(103, 6, '29584721', 'María Alejandra', 'Gómez Hernández', 'Femenino', '0412-3698521', '1982-04-30', '2017-06-28'),
(104, 7, '28451796', 'Andrés', 'Martínez Rodríguez', 'Masculino', '0424-6549873', '1991-09-12', '2016-09-13'),
(105, 8, '28741596', 'Laura', 'Ramírez Pérez', 'Femenino', '0416-1237890', '1985-12-08', '2015-12-18'),
(106, 9, '29314526', 'Santiago', 'Hernández González', 'Masculino', '0426-9876543', '1989-07-05', '2015-03-02'),
(107, 1, '28497125', 'Ana Sofía', 'García López', 'Femenino', '0412-4567890', '1992-06-04', '2014-04-15'),
(108, 2, '29789523', 'Alejandro', 'Rodríguez Martínez', 'Masculino', '0416-9876543', '1984-11-21', '2013-06-28'),
(109, 3, '31478259', 'María José', 'García Rodríguez', 'Femenino', '0424-7890123', '1976-06-15', '2012-08-10'),
(110, 4, '26897457', 'Juan David', 'Martínez González', 'Masculino', '0412-1234567', '1973-10-20', '2011-09-23'),
(111, 5, '20874567', 'Valeria', 'Hernández Vargas', 'Femenino', '0426-4567890', '1998-05-14', '2010-11-05'),
(112, 6, '30784598', 'Santiago', 'López Sánchez', 'Masculino', '0412-3698521', '1978-08-28', '2009-12-19'),
(113, 7, '29548715', 'Valentina', 'Ramírez Pérez', 'Femenino', '0424-6549873', '1985-01-17', '2008-11-02'),
(114, 8, '28136947', 'Manuel', 'Gómez Martínez', 'Masculino', '0416-1237890', '1980-12-10', '2007-12-15'),
(115, 9, '27345897', 'Valeria', 'Martínez López', 'Femenino', '0426-9876543', '1983-07-25', '2007-01-30'),
(116, 1, '28647127', 'Sebastián', 'Rodríguez Sánchez', 'Masculino', '0412-4567890', '1988-04-12', '2006-03-14'),
(117, 2, '29785429', 'Isabella', 'Hernández Pérez', 'Femenino', '0416-9876543', '1981-11-29', '2005-05-27'),
(118, 3, '31478260', 'Juan Pablo', 'Gómez Rodríguez', 'Masculino', '0424-7890123', '1974-06-15', '2004-07-10'),
(119, 4, '26897458', 'Valentina', 'López González', 'Femenino', '0412-1234567', '1999-11-23', '2003-09-24'),
(120, 5, '21548797', 'Daniel', 'Martínez Rodríguez', 'Masculino', '0426-4567890', '1993-08-12', '2002-11-07'),
(121, 6, '30216548', 'María Alejandra', 'Gómez Hernández', 'Femenino', '0412-3698521', '1982-12-30', '2001-12-20'),
(122, 7, '28547137', 'Andrés', 'López Sánchez', 'Masculino', '0424-6549873', '1989-04-19', '2000-12-04'),
(123, 8, '29874513', 'Laura', 'Ramírez Pérez', 'Femenino', '0416-1237890', '1984-10-08', '1999-10-17'),
(124, 9, '27148964', 'Santiago', 'Hernández González', 'Masculino', '0426-9876543', '1988-07-15', '1998-09-30'),
(125, 1, '28459614', 'Ana Sofía', 'García López', 'Femenino', '0412-4567890', '1991-04-02', '1997-11-12'),
(126, 2, '29785414', 'Alejandro', 'Rodríguez Martínez', 'Masculino', '0416-9876543', '1985-11-29', '1996-12-25'),
(127, 3, '31625479', 'María José', 'García Rodríguez', 'Femenino', '0424-7890123', '1977-06-05', '1996-02-07'),
(128, 4, '25987457', 'Juan David', 'Martínez González', 'Masculino', '0412-1234567', '1975-10-20', '1995-03-21'),
(129, 5, '20874564', 'Valeria', 'Hernández Vargas', 'Femenino', '0426-4567890', '1996-05-14', '1994-05-05'),
(130, 6, '30784597', 'Santiago', 'López Sánchez', 'Masculino', '0412-3698521', '1981-08-28', '1993-06-19'),
(131, 7, '29548714', 'Valentina', 'Ramírez Pérez', 'Femenino', '0424-6549873', '1988-01-17', '1992-05-02'),
(132, 8, '28136946', 'Manuel', 'Gómez Martínez', 'Masculino', '0416-1237890', '1984-12-10', '1991-04-15'),
(133, 9, '27345898', 'Valeria', 'Martínez López', 'Femenino', '0426-9876543', '1987-07-25', '1990-03-29'),
(134, 1, '28647126', 'Sebastián', 'Rodríguez Sánchez', 'Masculino', '0412-4567890', '1990-04-12', '1989-02-12'),
(135, 2, '29785424', 'Isabella', 'Hernández Pérez', 'Femenino', '0416-9876543', '1983-11-29', '1988-01-23'),
(136, 3, '31478257', 'Juan Pablo', 'Gómez Rodríguez', 'Masculino', '0424-7890123', '1976-06-15', '1987-03-07'),
(137, 4, '26897459', 'Valentina', 'López González', 'Femenino', '0412-1234567', '1978-11-23', '1986-04-21'),
(138, 5, '21548798', 'Daniel', 'Martínez Rodríguez', 'Masculino', '0426-4567890', '1983-08-12', '1985-06-05'),
(139, 6, '30216549', 'María Alejandra', 'Gómez Hernández', 'Femenino', '0412-3698521', '1982-12-30', '1984-07-18'),
(140, 7, '28547138', 'Andrés', 'López Sánchez', 'Masculino', '0424-6549873', '1989-04-19', '1983-08-31'),
(141, 8, '29874514', 'Laura', 'Ramírez Pérez', 'Femenino', '0416-1237890', '1984-10-08', '1982-10-14'),
(142, 9, '27148965', 'Santiago', 'Hernández González', 'Masculino', '0426-9876543', '1988-07-15', '1981-12-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas_grupos`
--

CREATE TABLE `personas_grupos` (
  `id_persona_grupo` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_deporte` int(11) NOT NULL,
  `id_grupo_deportivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula` text NOT NULL,
  `nombres` text NOT NULL,
  `apellidos` text NOT NULL,
  `cargo` text NOT NULL,
  `contrasenna` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `cargo`, `contrasenna`) VALUES
(4, '28055655', 'Cesar Alejandro', 'Vides Gonzalez', 'Administrador', '$2y$10$EX4.HdhpjsoGfidaNChyCuZfhA1Ki/esrlYhH422r0Kq.gwAlHdWq');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `id_division` (`id_division`);

--
-- Indices de la tabla `deportes`
--
ALTER TABLE `deportes`
  ADD PRIMARY KEY (`id_deporte`);

--
-- Indices de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  ADD PRIMARY KEY (`id_division`);

--
-- Indices de la tabla `grupos_deportivos`
--
ALTER TABLE `grupos_deportivos`
  ADD PRIMARY KEY (`id_grupo_deportivo`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `personas_grupos`
--
ALTER TABLE `personas_grupos`
  ADD PRIMARY KEY (`id_persona_grupo`),
  ADD KEY `id_deporte` (`id_deporte`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_grupo_deportivo` (`id_grupo_deportivo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `deportes`
--
ALTER TABLE `deportes`
  MODIFY `id_deporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  MODIFY `id_division` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `grupos_deportivos`
--
ALTER TABLE `grupos_deportivos`
  MODIFY `id_grupo_deportivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `personas_grupos`
--
ALTER TABLE `personas_grupos`
  MODIFY `id_persona_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`id_division`) REFERENCES `divisiones` (`id_division`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id_area`);

--
-- Filtros para la tabla `personas_grupos`
--
ALTER TABLE `personas_grupos`
  ADD CONSTRAINT `personas_grupos_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `personas_grupos_ibfk_2` FOREIGN KEY (`id_deporte`) REFERENCES `deportes` (`id_deporte`),
  ADD CONSTRAINT `personas_grupos_ibfk_3` FOREIGN KEY (`id_grupo_deportivo`) REFERENCES `grupos_deportivos` (`id_grupo_deportivo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
