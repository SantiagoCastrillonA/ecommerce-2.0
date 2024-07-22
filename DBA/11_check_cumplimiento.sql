CREATE TABLE check_cumplimiento ( `id` INT NOT NULL AUTO_INCREMENT , `id_colaborador` INT NOT NULL , `id_encargado` INT NOT NULL , `fecha` DATE NOT NULL , `estado` INT(1) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Check Evaluación', NULL, 1, 1, 'check evaluacion');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 15, 1, 1, 1, 1),(2, 15, 1, 1, 1, 1)

CREATE TABLE opciones_check_cumplimiento ( `id` INT NOT NULL AUTO_INCREMENT , `id_check_cumplimiento` INT NOT NULL , `actividad` VARCHAR(255) NOT NULL , `evaluacion` INT(1) NOT NULL , `porcentaje` INT(2) NOT NULL , `observaciones` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE opciones_cumplimiento ( `id` INT NOT NULL AUTO_INCREMENT , `actividad` VARCHAR(255) NOT NULL , `porcentaje` INT(2) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
