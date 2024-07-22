ALTER TABLE `sedes` ADD `ip` VARCHAR(16) NULL AFTER `estado`;

CREATE TABLE usuario_asistencia ( `id` INT NOT NULL , `id_usuario` INT NOT NULL , `fecha_hora` DATETIME NOT NULL , `tipo` VARCHAR(16) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Asistencia', NULL, 1, 1, 'asistencia');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 18, 1, 1, 1, 1),(2, 18, 1, 1, 1, 1),(3, 18, 1, 1, 1, 1),(4, 18, 1, 1, 1, 1),(5, 18, 1, 1, 1, 1),(6, 18, 1, 1, 1, 1),(7, 18, 1, 1, 1, 1),(8, 18, 1, 1, 1, 1),(9, 18, 1, 1, 1, 1),(10, 18, 1, 1, 1, 1),(11, 18, 1, 1, 1, 1),(12, 18, 1, 1, 1, 1),(13, 18, 1, 1, 1, 1),(14, 18, 1, 1, 1, 1),(15, 18, 1, 1, 1, 1),(16, 18, 1, 1, 1, 1)