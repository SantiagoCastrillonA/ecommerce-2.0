CREATE TABLE contratos_adjuntos ( `id` INT NOT NULL AUTO_INCREMENT, `id_contrato` INT NOT NULL , `nombre` VARCHAR(64) NOT NULL , `tipo` VARCHAR(32) NOT NULL , `archivo` TEXT NOT NULL , `id_autor` INT NOT NULL , `fecha_creacion` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `contratos` ADD `fecha_retiro` DATE NULL AFTER `motivo_terminacion`;