CREATE TABLE vehiculos ( `id` INT NOT NULL AUTO_INCREMENT , `placa` VARCHAR(8) NOT NULL , `tipo_vehiculo` VARCHAR(32) NULL , `marca` VARCHAR(32) NULL , `modelo` VARCHAR(32) NULL , `capacidad_carga` VARCHAR(32) NULL , `kilometraje` INT NULL , `estado` VARCHAR(32) NULL , `fecha_mantenimiento` DATE NULL , `fecha_adquisicion` DATE NULL , `ejes` INT(2) NULL , `color` VARCHAR(32) NULL , `numero_chasis` VARCHAR(128) NULL , `id_responsable` INT NULL , `tipo_combustible` VARCHAR(32) NULL , `observaciones` TEXT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Vehiculos', NULL, 1, 1, 'vehiculos');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 13, 1, 1, 1, 1),(2, 13, 1, 1, 1, 1),(3, 13, 1, 1, 1, 1),(9, 13, 1, 1, 1, 1),(14, 13, 1, 1, 1, 1);


CREATE TABLE version_check_list_vehiculo ( `id` INT NOT NULL AUTO_INCREMENT , `version` VARCHAR(16) NOT NULL , `estado` INT(1) NOT NULL, `fecha` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE opciones_check_list_vehiculos ( `id` INT NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(255) NOT NULL , `estado` INT(1) NOT NULL , `id_version` INT(2) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE check_list_vehiculo ( `id` INT NOT NULL AUTO_INCREMENT , `id_usuario` INT NOT NULL , `id_version` INT(2) NOT NULL , `estado` INT(1) NOT NULL , `id_vehiculo` INT(4) NULL , `fecha` DATE NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE opcion_check_vehiculos ( `id` INT NOT NULL AUTO_INCREMENT , `id_check_vehiculo` INT NOT NULL , `opcion` VARCHAR(255) NOT NULL , `estado` INT(1) NOT NULL , `observaciones` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Check Vehiculos', NULL, 1, 1, 'check vehiculos');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 14, 1, 1, 1, 1),(2, 14, 1, 1, 1, 1),(3, 14, 1, 1, 1, 1),(9, 14, 1, 1, 1, 1),(14, 14, 1, 1, 1, 1);

INSERT INTO `version_check_list_vehiculo` (`id`, `version`, `estado`, `fecha`) VALUES (NULL, '001', '1', '2023-01-14')


--- Actualizacion vehiculos

ALTER TABLE `vehiculos` ADD `proximo_mantenimiento` DATE NULL AFTER `observaciones`, ADD `tecnicomecanica` DATE NULL AFTER `proximo_mantenimiento`, ADD `soat` DATE NULL AFTER `tecnicomecanica`;