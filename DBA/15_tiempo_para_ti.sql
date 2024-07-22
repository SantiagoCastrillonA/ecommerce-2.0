CREATE TABLE usuario_tiempo_para_ti ( `id` INT NOT NULL AUTO_INCREMENT , `id_usuario` INT NOT NULL , `fecha_solicitud` DATE NOT NULL , `horario` VARCHAR(32) NOT NULL , `estado` INT(1) NOT NULL , `fecha_aprobacion` DATE NULL , `id_aprobador` INT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `modulos` (`nombre`, `icono`, `estado`, `eliminar`, `variable`) VALUES
('Tiempo Para Ti', NULL, 1, 1, 'tiempo para ti');

INSERT INTO `modulos_cargos` (`id_cargo`, `id_modulo`, `crear`, `editar`, `eliminar`, `ver`) 
VALUES (1, 17, 1, 1, 1, 1),(2, 17, 1, 1, 1, 1),(3, 17, 1, 1, 1, 1),(6, 17, 1, 1, 1, 1)