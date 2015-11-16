-- Generated by Oracle SQL Developer Data Modeler 4.1.1.888
--   at:        2015-11-14 13:30:40 COT
--   site:      Oracle Database 11g
--   type:      Oracle Database 11g



CREATE TABLE paquetexusuario
(
 paquete             VARCHAR (200) NOT NULL ,
repositorio VARCHAR (20) NOT NULL ,
 usuario    VARCHAR (150) NOT NULL
) ;
ALTER TABLE paquetexusuario ADD CONSTRAINT paquetexusuario_PK PRIMARY KEY ( paquete,repositorio, usuario) ;


CREATE TABLE dependencia
(
 paquete  VARCHAR (200 ) NOT NULL ,
 dependencia VARCHAR (200 ) NOT NULL ,
 repositorio     VARCHAR (20 ) NOT NULL
) ;
ALTER TABLE dependencia ADD CONSTRAINT depedencia_PK PRIMARY KEY ( paquete, dependencia, repositorio ) ;


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
 version                  NUMERIC (10,10) NOT NULL ,
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


ALTER TABLE dependencia ADD CONSTRAINT depedencia_paquete_FK FOREIGN KEY ( paquete, repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE dependencia ADD CONSTRAINT depedencia_paquete_FKv1 FOREIGN KEY ( dependencia, repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE licencia ADD CONSTRAINT licencia_paquete_FK FOREIGN KEY ( paquete, repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE paquete ADD CONSTRAINT paquete_repositorio_FK FOREIGN KEY ( repositorio ) REFERENCES repositorio ( nombre ) ;

ALTER TABLE paquetexusuario ADD CONSTRAINT paquetexusuario_paquete_FK FOREIGN KEY ( paquete,repositorio ) REFERENCES paquete ( nombre, repositorio ) ;

ALTER TABLE paquetexusuario ADD CONSTRAINT paquetexusuario_usuario_FK FOREIGN KEY ( usuario) REFERENCES usuario ( nombre_usuario ) ;



-- Oracle SQL Developer Data Modeler Summary Report: 
-- 
-- CREATE TABLE                             5
-- CREATE INDEX                             0
-- ALTER TABLE                             10
-- CREATE VIEW                              0
-- ALTER VIEW                               0
-- CREATE PACKAGE                           0
-- CREATE PACKAGE BODY                      0
-- CREATE PROCEDURE                         0
-- CREATE FUNCTION                          0
-- CREATE TRIGGER                           0
-- ALTER TRIGGER                            0
-- CREATE COLLECTION TYPE                   0
-- CREATE STRUCTURED TYPE                   0
-- CREATE STRUCTURED TYPE BODY              0
-- CREATE CLUSTER                           0
-- CREATE CONTEXT                           0
-- CREATE DATABASE                          0
-- CREATE DIMENSION                         0
-- CREATE DIRECTORY                         0
-- CREATE DISK GROUP                        0
-- CREATE ROLE                              0
-- CREATE ROLLBACK SEGMENT                  0
-- CREATE SEQUENCE                          0
-- CREATE MATERIALIZED VIEW                 0
-- CREATE SYNONYM                           0
-- CREATE TABLESPACE                        0
-- CREATE USER                              0
-- 
-- DROP TABLESPACE                          0
-- DROP DATABASE                            0
-- 
-- REDACTION POLICY                         0
-- 
-- ORDS DROP SCHEMA                         0
-- ORDS ENABLE SCHEMA                       0
-- ORDS ENABLE OBJECT                       0
-- 
-- ERRORS                                   0
-- WARNINGS                                 0
