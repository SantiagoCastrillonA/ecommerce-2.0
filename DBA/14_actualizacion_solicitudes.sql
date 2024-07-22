ALTER TABLE `usuario_solicitudes` ADD `cantidad_horas` INT(1) NOT NULL AFTER `observaciones_aprobador`;

CREATE TABLE solicitud_adjunto ( `id` INT NOT NULL AUTO_INCREMENT , `id_solicitud` INT NOT NULL , `adjunto` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;