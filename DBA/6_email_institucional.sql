ALTER TABLE `usuarios` ADD `correo_institucional` VARCHAR(255) NOT NULL AFTER `cesantias`, ADD `clave_email_institucional` VARCHAR(64) NOT NULL AFTER `correo_institucional`;
ALTER TABLE `usuarios` CHANGE `correo_institucional` `correo_institucional` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `clave_email_institucional` `clave_email_institucional` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `usuarios` ADD `arl` VARCHAR(32) NULL AFTER `cesantias`;
