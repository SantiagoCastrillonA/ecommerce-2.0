CREATE TABLE vacantes ( `id` INT NOT NULL AUTO_INCREMENT , `nombre_vacante` VARCHAR(255) NOT NULL , `fecha` DATE NOT NULL , `modalidad` VARCHAR(32) NOT NULL , `descripcion` TEXT NOT NULL , `estado` INT(1) NOT NULL , `conocimientos` TEXT NULL , `habilidades` TEXT NULL, `horario` VARCHAR(255) NULL , `salario` VARCHAR(128) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE postulado_vacante ( `id` INT NOT NULL AUTO_INCREMENT , `id_vacante` INT(8) NOT NULL , `estado` varchar(32) NOT NULL , `fecha_hora` DATETIME NOT NULL , `nombre_postulado` VARCHAR(255) NOT NULL , `email` VARCHAR(128) NOT NULL , `telefono` VARCHAR(32) NOT NULL , `hv` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


CREATE TABLE proceso_seleccion (
  `id` int(11) NOT NULL,
  `id_hv` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `paso1` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_1` text,
  `fecha_paso_1` date DEFAULT NULL,
  `paso2` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_2` text,
  `fecha_paso_2` date DEFAULT NULL,
  `paso3` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_3` text,
  `fecha_paso_3` date DEFAULT NULL,
  `paso4` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_4` text,
  `fecha_paso_4` date DEFAULT NULL,
  `paso5` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_5` text,
  `fecha_paso_5` date DEFAULT NULL,
  `paso6` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_6` text,
  `fecha_paso_6` date DEFAULT NULL,
  `paso7` varchar(64) DEFAULT 'Pendiente',
  `nota_paso_7` text,
  `fecha_paso_7` date DEFAULT NULL,
  `psicotecnica` text,
  `wartegg` text,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE proceso_seleccion ADD PRIMARY KEY (`id`);

ALTER TABLE proceso_seleccion MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;COMMIT;

CREATE TABLE estado_proceso_seleccion (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO estado_proceso_seleccion (`id`, `nombre`, `descripcion`) VALUES
(1, 'Paso 1: Revisión Hoja de vida', ''),
(2, 'Paso 2: Llamada de contacto', ''),
(3, 'Paso 3: Prueba psicotécnica', ''),
(4, 'Paso 4: Test wartegg', ''),
(5, 'Paso 5: Entrevista semiestructurada', ''),
(6, 'Paso 6: Entrevista Gerencia', ''),
(7, 'Paso 7: Llamada aceptación', ''),
(8, 'Aceptado', ''),
(9, 'No aceptado\r\n', '');


ALTER TABLE estado_proceso_seleccion
  ADD PRIMARY KEY (`id`);

  
ALTER TABLE estado_proceso_seleccion
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;