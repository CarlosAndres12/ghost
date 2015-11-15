


CREATE TABLE paquetexusuario
(
 paquete             VARCHAR (200) NOT NULL ,
repositorio VARCHAR (20) NOT NULL ,
 usuario    VARCHAR (150) NOT NULL
) ;
ALTER TABLE paquetexusuario ADD CONSTRAINT paquetexusuario_PK PRIMARY KEY ( paquete,repositorio, usuario) ;


CREATE TABLE depedencia
(
 paquete  VARCHAR (200 ) NOT NULL ,
 dependencia VARCHAR (200 ) NOT NULL ,
 repositorio     VARCHAR (20 ) NOT NULL
) ;
ALTER TABLE depedencia ADD CONSTRAINT depedencia_PK PRIMARY KEY ( paquete, dependencia, repositorio ) ;


CREATE TABLE licencia
(
 paquete VARCHAR (200 ) NOT NULL ,
 valor          VARCHAR (100 ) NOT NULL ,
 repositorio    VARCHAR (20 ) NOT NULL
) ;
ALTER TABLE licencia ADD CONSTRAINT licencia_PK PRIMARY KEY ( paquete, repositorio, valor ) ;


CREATE TABLE paquete
(
 nombre                   VARCHAR (200 ) NOT NULL ,
 arquitectura             VARCHAR (100 ) NOT NULL ,
 version                  NUMERIC (10,5) NOT NULL ,
 descripcion              VARCHAR (500 ) NOT NULL ,
 tamano_comprimido        INTEGER NOT NULL ,
 tamano_instalado         INTEGER NOT NULL ,
 fecha_subida             VARCHAR (20 ) NOT NULL ,
 fecha_ultima_actualizada VARCHAR (20 ) NOT NULL ,
 repositorio       VARCHAR (20 ) NOT NULL
) ;
ALTER TABLE paquete ADD CONSTRAINT paquete_PK PRIMARY KEY ( nombre, repositorio ) ;


CREATE TABLE repositorio
(
 nombre      VARCHAR (20 ) NOT NULL ,
 descripcion VARCHAR (500) NOT NULL
) ;
ALTER TABLE repositorio ADD CONSTRAINT repositorio_PK PRIMARY KEY ( nombre ) ;


CREATE TABLE usuario
(
 nombre_usuario     VARCHAR (150 ) NOT NULL ,
 nombre             VARCHAR (150) NOT NULL ,
 correo_electronico VARCHAR (150 ) NOT NULL ,
 contrasena BLOB NOT NULL ,
 tipo VARCHAR (20 ) NOT NULL
) ;
ALTER TABLE usuario ADD CONSTRAINT usuario_PK PRIMARY KEY ( nombre_usuario ) ;


ALTER TABLE depedencia ADD CONSTRAINT depedencia_paquete_FK FOREIGN KEY ( paquete, repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE depedencia ADD CONSTRAINT depedencia_paquete_FKv1 FOREIGN KEY ( dependencia, repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE licencia ADD CONSTRAINT licencia_paquete_FK FOREIGN KEY ( paquete, repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE paquete ADD CONSTRAINT paquete_repositorio_FK FOREIGN KEY ( repositorio ) REFERENCES repositorio ( nombre ) ;

ALTER TABLE paquetexusuario ADD CONSTRAINT paquetexusuario_paquete_FK FOREIGN KEY ( paquete,repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE paquetexusuario ADD CONSTRAINT paquetexusuario_usuario_FK FOREIGN KEY ( usuario) REFERENCES usuario ( nombre_usuario ) ;
