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
-- Table `mydb`.`empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`empleado` (
  `idEMPLEADO` INT NOT NULL AUTO_INCREMENT,
  `NOMBRE_COMPLETO` VARCHAR(45) NULL DEFAULT NULL,
  `USUARIO` VARCHAR(45) NULL DEFAULT NULL,
  `PASSWORD` VARCHAR(45) NULL DEFAULT NULL,
  `ROL` ENUM('ADMIN', 'EMPLEADO') NULL DEFAULT NULL,
  PRIMARY KEY (`idEMPLEADO`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `mydb`.`habitaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`habitaciones` (
  `idHABITACIONES` INT NOT NULL AUTO_INCREMENT,
  `NUMERO` INT NOT NULL,
  `CAPACIDAD` INT NULL DEFAULT NULL,
  `ESTADO` ENUM('OCUPADA', 'DESOCUPADA', 'FUERA_DE_SERVICIO') NULL,
  PRIMARY KEY (`idHABITACIONES`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


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
  INDEX `fk_ESTADIA_HABITACIONES1_idx` (`HABITACIONES_idHABITACIONES` ASC) VISIBLE,
  CONSTRAINT `fk_ESTADIA_HABITACIONES1`
    FOREIGN KEY (`HABITACIONES_idHABITACIONES`)
    REFERENCES `mydb`.`habitaciones` (`idHABITACIONES`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


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
  INDEX `fk_HUESPED_has_ESTADIA_ESTADIA1_idx` (`ESTADIA_idESTADIA` ASC) VISIBLE,
  INDEX `fk_HUESPED_has_ESTADIA_HUESPED1_idx` (`HUESPED_idHUESPED` ASC) VISIBLE,
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
  INDEX `fk_NOVEDADES_ESTADIA1_idx` (`ESTADIA_idESTADIA` ASC) VISIBLE,
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
  `EMPLEADO_idEMPLEADO` INT NOT NULL,
  PRIMARY KEY (`idPAGOS`, `HUESPED_idHUESPED`),
  INDEX `fk_PAGOS_HUESPED1_idx` (`HUESPED_idHUESPED` ASC) VISIBLE,
  INDEX `fk_PAGOS_ESTADIA1_idx` (`ESTADIA_idESTADIA` ASC) VISIBLE,
  INDEX `fk_PAGOS_EMPLEADO1_idx` (`EMPLEADO_idEMPLEADO` ASC) VISIBLE,
  CONSTRAINT `fk_PAGOS_EMPLEADO1`
    FOREIGN KEY (`EMPLEADO_idEMPLEADO`)
    REFERENCES `mydb`.`empleado` (`idEMPLEADO`),
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
CREATE TABLE IF NOT EXISTS `mydb`.`tarifa` (
  `idTARIFA` INT NOT NULL AUTO_INCREMENT,
  `MODALIDA` VARCHAR(50) NULL DEFAULT NULL,
  `NROHUESPEDES` INT NULL DEFAULT NULL,
  `VALOR` DOUBLE NULL DEFAULT NULL,
  `HABITACIONES_idHABITACIONES` INT NOT NULL,
  PRIMARY KEY (`idTARIFA`),
  INDEX `fk_TARIFA_HABITACIONES_idx` (`HABITACIONES_idHABITACIONES` ASC) VISIBLE,
  CONSTRAINT `fk_TARIFA_HABITACIONES`
    FOREIGN KEY (`HABITACIONES_idHABITACIONES`)
    REFERENCES `mydb`.`habitaciones` (`idHABITACIONES`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
