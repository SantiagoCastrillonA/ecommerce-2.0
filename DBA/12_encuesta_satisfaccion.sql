-- Encuesta satisfaccion bodega
CREATE TABLE encuesta_satisfaccion ( `id` INT NOT NULL AUTO_INCREMENT , `fecha` DATE NOT NULL , `comentarios` TEXT NOT NULL , `preg1` INT(1) NOT NULL , `preg2` INT(1) NOT NULL , `preg3` INT(1) NOT NULL , `recomendaria` VARCHAR(2) NOT NULL , `calificacion_global` INT(1) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Encuesta satisfaccion servicio en salas
CREATE TABLE encuesta_satisfaccion_servicio ( `id` INT NOT NULL AUTO_INCREMENT , `fecha` DATE NOT NULL , `comentarios` TEXT NOT NULL , `preg1` INT(1) NOT NULL , `recomendaria` VARCHAR(2) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Encuesta Satisfacción', NULL, 1, 1, 'encuesta satisfaccion');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 16, 1, 1, 1, 1),(2, 16, 1, 1, 1, 1)

-- actualizacion con sede

ALTER TABLE `encuesta_satisfaccion_servicio` ADD `id_asesor` INT NULL AFTER `recomendaria`, ADD `id_sede` INT NOT NULL AFTER `id_asesor`;
