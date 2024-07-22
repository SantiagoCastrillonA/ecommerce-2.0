ALTER TABLE usuarios ADD `id_area` INT(2) NOT NULL AFTER `id_sede`;

CREATE TABLE areas ( `id` INT NOT NULL AUTO_INCREMENT , `estado` INT(1) NOT NULL COMMENT '1 activa, 2 inactiva' , `nombre` VARCHAR(32) NOT NULL , `descripcion` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE notas ADD `id_area` INT(2) NULL AFTER `id_sede`;

ALTER TABLE archivo ADD `id_area` INT(2) NULL AFTER `id_usuario`;