CREATE TABLE `usuario_compensacion_horas` 
( `id` INT NOT NULL AUTO_INCREMENT , `id_usuario` INT NOT NULL 
, `fecha_solicitud` DATE NOT NULL , `horas_solicitadas` INT(2) NOT NULL 
, `fecha_laboradas` DATE NOT NULL , `id_aprobador` INT NULL , `horas_aprobadas` INT(2) NULL 
, `fecha_aprobacion` DATE NULL , `fecha_compensacion` DATE NULL 
, `estado` INT(1) NOT NULL, 
`nota` TEXT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;