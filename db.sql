CREATE TABLE `ghost`.`usuario` ( `nombre_usuario` VARCHAR(150) NOT NULL , `nombre` VARCHAR(150) NOT NULL , `correo_electronico` VARCHAR(150) NOT NULL , `contrasena` BLOB NOT NULL , PRIMARY KEY (`nombre_usuario`)) ENGINE = InnoDB;
CREATE TABLE `ghost`.`repositorio` ( `nombre` VARCHAR(200) NOT NULL , `descripcion` VARCHAR(500) NOT NULL , PRIMARY KEY (`nombre`)) ENGINE = InnoDB;

