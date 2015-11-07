CREATE TABLE `ghost`.`usuario` ( `nombre_usuario` VARCHAR(150) NOT NULL , `nombre` VARCHAR(150) NOT NULL , `correo_electronico` VARCHAR(150) NOT NULL , `contrasena` BLOB NOT NULL , PRIMARY KEY (`nombre_usuario`)) ENGINE = InnoDB;
CREATE TABLE `ghost`.`repositorio` ( `nombre` VARCHAR(200) NOT NULL , `descripcion` VARCHAR(500) NOT NULL , PRIMARY KEY (`nombre`)) ENGINE = InnoDB;
ALTER TABLE `usuario` ADD `tipo` VARCHAR(20) NOT NULL AFTER `contrasena`;

CREATE TABLE `ghost`.`paquete` ( `nombre` VARCHAR(200) NOT NULL , `arquitectura` VARCHAR(100) NOT NULL , `version` DECIMAL NOT NULL , `descripcion` VARCHAR(500) NOT NULL , `tamano_comprimido` INT(10) NOT NULL , `tamano_instalado` INT(10) NOT NULL , `fecha_subida` VARCHAR(20) NOT NULL, `fecha_ultima_actualizada` VARCHAR(20) NOT NULL, `repositorio` VARCHAR(200) NOT NULL , PRIMARY KEY (`nombre`), 
 CONSTRAINT p_r FOREIGN KEY (repositorio) REFERENCES repositorio(nombre) ON DELETE CASCADE ON UPDATE CASCADE ) ENGINE = InnoDB;
ALTER TABLE `usuario` CHANGE `contrasena` `contrasena` VARCHAR(256) NOT NULL; 