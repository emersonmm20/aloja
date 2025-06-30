drop database mydb;

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8mb3 ;
USE `mydb` ;
SHOW COLUMNS FROM HABITACIONES LIKE 'DESCRIPCION';




-- -----------------------------------------------------
-- Table `mydb`.`administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`administrador` (
  `idADMINISTRADOR` INT NOT NULL AUTO_INCREMENT,
  `NOMBRE_COMPLETO` VARCHAR(45) NULL DEFAULT NULL,
  `USUARIO` VARCHAR(45) NULL DEFAULT NULL,
  `PASSWORD` VARCHAR(45) NULL DEFAULT NULL,
  `ROL` ENUM('ADMIN', 'EMPLEADO') NULL DEFAULT NULL,
  PRIMARY KEY (`idADMINISTRADOR`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`comentarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`comentarios` (
  `id_comentario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `comentario` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_comentario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;



-- -----------------------------------------------------
-- Table `mydb`.`habitaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`habitaciones` (
  `idHABITACIONES` INT NOT NULL AUTO_INCREMENT,
  `NUMERO` INT NOT NULL unique,
  `CAPACIDAD` INT NULL DEFAULT NULL,
  `ESTADO` ENUM('OCUPADA', 'DESOCUPADA', 'FUERA_DE_SERVICIO') NULL,
  PRIMARY KEY (`idHABITACIONES`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;
ALTER TABLE habitaciones 
ADD COLUMN  IF NOT EXISTS DESCRIPCION TEXT,
ADD COLUMN PRECIO DECIMAL(10,2);
SELECT * FROM habitaciones WHERE ESTADO != 'FUERA_DE_SERVICIO';









-- -----------------------------------------------------
-- Table `mydb`.`estadia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`estadia` (
  `idESTADIA` INT NOT NULL AUTO_INCREMENT,
  `FECHA_INICIO` DATE NULL DEFAULT NULL,
  `FECHA_FIN` DATE NULL DEFAULT NULL,
  `FECHA_REGISTRO` DATETIME NULL DEFAULT NULL,
  `COSTO` DOUBLE NULL DEFAULT NULL,
  `HABITACIONES_idHABITACIONES` INT NOT NULL,
  PRIMARY KEY (`idESTADIA`),
  INDEX `fk_ESTADIA_HABITACIONES1_idx` (`HABITACIONES_idHABITACIONES` ASC),
  CONSTRAINT `fk_ESTADIA_HABITACIONES1`
    FOREIGN KEY (`HABITACIONES_idHABITACIONES`)
    REFERENCES `mydb`.`habitaciones` (`idHABITACIONES`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;

ALTER TABLE estadia ADD COLUMN idHUESPED INT;



-- -----------------------------------------------------
-- Table `mydb`.`huesped`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`huesped` (
  `idHUESPED` INT NOT NULL AUTO_INCREMENT,
  `NOMBRECOMPLETO` VARCHAR(45) NULL DEFAULT NULL,
  `TIPODOCUMENTO` VARCHAR(45) NULL DEFAULT NULL,
  `DOCUMENTO` int not NULL,
  `TELEFONOHUESPED` VARCHAR(45) NULL DEFAULT NULL,
  `EMAIL` VARCHAR(255) null DEFAULT NULL,
  `OBSEVACIONES` VARCHAR(45) NULL DEFAULT NULL,

  PRIMARY KEY (`idHUESPED`)
  )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`huesped_has_estadia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`huesped_has_estadia` (
  `HUESPED_idHUESPED` INT NOT NULL,
  `ESTADIA_idESTADIA` INT NOT NULL,
  PRIMARY KEY (`HUESPED_idHUESPED`, `ESTADIA_idESTADIA`),
  INDEX `fk_HUESPED_has_ESTADIA_ESTADIA1_idx` (`ESTADIA_idESTADIA` ASC),
  INDEX `fk_HUESPED_has_ESTADIA_HUESPED1_idx` (`HUESPED_idHUESPED` ASC),
  CONSTRAINT `fk_HUESPED_has_ESTADIA_ESTADIA1`
    FOREIGN KEY (`ESTADIA_idESTADIA`)
    REFERENCES `mydb`.`estadia` (`idESTADIA`),
  CONSTRAINT `fk_HUESPED_has_ESTADIA_HUESPED1`
    FOREIGN KEY (`HUESPED_idHUESPED`)
    REFERENCES `mydb`.`huesped` (`idHUESPED`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`novedades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`novedades` (
  `idNOVEDADES` INT NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` VARCHAR(200) NULL DEFAULT NULL,
  `ESTADIA_idESTADIA` INT NOT NULL,
  PRIMARY KEY (`idNOVEDADES`),
  INDEX `fk_NOVEDADES_ESTADIA1_idx` (`ESTADIA_idESTADIA` ASC),
  CONSTRAINT `fk_NOVEDADES_ESTADIA1`
    FOREIGN KEY (`ESTADIA_idESTADIA`)
    REFERENCES `mydb`.`estadia` (`idESTADIA`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`pagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`pagos` (
  `idPAGOS` INT NOT NULL AUTO_INCREMENT,
  `FECHA_PAGO` VARCHAR(45) NULL DEFAULT NULL,
  `MONTO` int not null,
  `HUESPED_idHUESPED` INT NOT NULL,
  `ESTADIA_idESTADIA` INT NOT NULL,
  PRIMARY KEY (`idPAGOS`, `HUESPED_idHUESPED`),
  INDEX `fk_PAGOS_HUESPED1_idx` (`HUESPED_idHUESPED` ASC),
  INDEX `fk_PAGOS_ESTADIA1_idx` (`ESTADIA_idESTADIA` ASC),
  CONSTRAINT `fk_PAGOS_ESTADIA1`
    FOREIGN KEY (`ESTADIA_idESTADIA`)
    REFERENCES `mydb`.`estadia` (`idESTADIA`),
  CONSTRAINT `fk_PAGOS_HUESPED1`
    FOREIGN KEY (`HUESPED_idHUESPED`)
    REFERENCES `mydb`.`huesped` (`idHUESPED`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`tarifa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tarifas` (
  idTARIFAS INT AUTO_INCREMENT PRIMARY KEY,
  idHABITACIONES INT NOT NULL,
  CAPACIDAD INT NOT NULL,
  PRECIOPORNOCHE DECIMAL(10, 2) NOT NULL,
  DESCRIPCION TEXT,
  FOREIGN KEY (idHABITACIONES) REFERENCES habitaciones(idHABITACIONES)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

SELECT t.idTARIFAS, h.NUMERO, t.CAPACIDAD, t.PRECIOPORNOCHE, t.DESCRIPCION
FROM tarifas t
JOIN habitaciones h ON t.idHABITACIONES = h.idHABITACIONES;





-- -----------------------------------------------------
-- Table `mydb`.`servicios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`. `servicios` (
  idSERVICIOS INT AUTO_INCREMENT PRIMARY KEY,
  NOMBRE VARCHAR(100), -- nuevo campo para mostrar como título (ej. "Escapada Romántica")
  DESCRIPCION TEXT,     -- para el párrafo visible
  DETALLE TEXT,         -- para el texto que se muestra en el modal
  ESTADO VARCHAR(20),
  IMAGEN VARCHAR(255)
);

-- -----------------------------------------------------
-- Table `mydb`.`informes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS informes (
  idINFORMES INT AUTO_INCREMENT PRIMARY KEY,
  NOMBRE VARCHAR(100),
  FECHA_CHECKIN DATE,
  FECHA_CHECKOUT DATE,
  IDHABITACIONES INT,
  NOCHES INT,
  DESAYUNO TINYINT(1),
  SPA TINYINT(1),
  TOTAL DECIMAL(10,2),
  FOREIGN KEY (IDHABITACIONES) REFERENCES habitaciones(idHABITACIONES)
);

SELECT 
  i.idINFORMES, 
  i.NOMBRE, 
  i.FECHA_CHECKIN, 
  i.FECHA_CHECKOUT, 
  i.NOCHES, 
  i.DESAYUNO, 
  i.SPA, 
  i.TOTAL, 
  h.NUMERO
FROM informes AS i
JOIN habitaciones AS h ON i.IDHABITACIONES = h.idHABITACIONES
ORDER BY i.idINFORMES DESC;


-- -----------------------------------------------------
-- Table `mydb`cancelaciones
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`cancelacion`  (
  idCANCELACION INT AUTO_INCREMENT PRIMARY KEY,
  idESTADIA INT,
  idHUESPED INT,
  FECHACANCELACION DATE,
  MOTIVOCANCELACION VARCHAR(255),
  PORCENTAJEREEMBOLSO DECIMAL(5,2),
  MONTOREEMBOLSADO DECIMAL(10,2),
  ESTADO VARCHAR(50),
  OBSERVACIONES TEXT,
  FOREIGN KEY (idESTADIA) REFERENCES estadia(idESTADIA),
  FOREIGN KEY (idHUESPED) REFERENCES huesped(idHUESPED)
);







SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



INSERT INTO `mydb`.`habitaciones` (`NUMERO`, `CAPACIDAD`, `ESTADO`) VALUES
(1, 2, 'DESOCUPADA'),
(2, 2, 'OCUPADA'),
(3, 3, 'DESOCUPADA'),
(4, 3, 'FUERA_DE_SERVICIO'),
(5, 4, 'DESOCUPADA'),
(6, 4, 'OCUPADA'),
(7, 5, 'DESOCUPADA'),
(8, 5, 'OCUPADA'),
(9, 6, 'DESOCUPADA'),
(10, 6, 'FUERA_DE_SERVICIO');



INSERT INTO `administrador` (`idADMINISTRADOR`, `NOMBRE_COMPLETO`, `USUARIO`, `PASSWORD`, `ROL`) VALUES (NULL, 'Emerson Gonzalez', 'admin123', '273df39e7dc60b5c891f768a7f1ab6f0', 'ADMIN');
-- admin123, contraseña: Admin-111


-- INSERT INTO `mydb`.`EMPLEADO`  (NOMBRE_COMPLETO, USUARIO, PASSWORD, ROL) 
-- VALUES 
-- ('Juan Pérez', 'admin123', 'Admin-111', 'ADMIN'),
-- ('María Gómez', 'empleado123', 'Empleado-111', 'EMPLEADO');





USE `mydb` ;

DROP TABLE IF EXISTS servicios;