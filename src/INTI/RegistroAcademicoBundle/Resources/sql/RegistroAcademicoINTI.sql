SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `registro` DEFAULT CHARACTER SET ucs2 COLLATE ucs2_spanish2_ci ;
USE `registro` ;

-- -----------------------------------------------------
-- Table `Encargado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Encargado` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(80) NOT NULL ,
  `Parentesco` VARCHAR(12) NOT NULL ,
  `DUI` VARCHAR(10) NOT NULL ,
  `telefono` VARCHAR(8) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Aspirante`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Aspirante` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `foto` MEDIUMBLOB NOT NULL ,
  `primerApellido` VARCHAR(15) NOT NULL ,
  `segundoApellido` VARCHAR(15) NULL ,
  `nombres` VARCHAR(50) NOT NULL ,
  `especialidad` VARCHAR(30) NOT NULL ,
  `direccion` VARCHAR(100) NOT NULL ,
  `telefono` VARCHAR(8) NOT NULL ,
  `fechaNac` DATE NOT NULL ,
  `lugarNac` VARCHAR(100) NOT NULL ,
  `sexo` CHAR(1) NOT NULL ,
  `Encargado_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `1erApellido` (`primerApellido` ASC) ,
  INDEX `2doApellido` (`segundoApellido` ASC) ,
  INDEX `apellidos` (`segundoApellido` ASC, `primerApellido` ASC) ,
  INDEX `fk_Aspirante_Encargado` (`Encargado_id` ASC) ,
  CONSTRAINT `fk_Aspirante_Encargado`
    FOREIGN KEY (`Encargado_id` )
    REFERENCES `Encargado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `salt` VARCHAR(255) NOT NULL ,
  `rol` LONGTEXT NOT NULL ,
  `enabled` TINYINT(1) NOT NULL DEFAULT true ,
  `lock` TINYINT(1) NULL DEFAULT false ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Empleado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Empleado` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombres` VARCHAR(80) NOT NULL ,
  `apellidos` VARCHAR(80) NOT NULL ,
  `puesto` VARCHAR(60) NOT NULL ,
  `fotografia` MEDIUMBLOB NULL ,
  `DUI` VARCHAR(8) NOT NULL ,
  `ISSS` VARCHAR(9) NOT NULL ,
  `NIT` VARCHAR(17) NOT NULL ,
  `NUP` VARCHAR(12) NOT NULL ,
  `sexo` CHAR(1) NOT NULL ,
  `Usuario_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `index_doc` (`DUI` ASC, `ISSS` ASC, `NIT` ASC, `NUP` ASC) ,
  INDEX `fk_Empleado_Usuario1` (`Usuario_id` ASC) ,
  UNIQUE INDEX `Usuario_id_UNIQUE` (`Usuario_id` ASC) ,
  CONSTRAINT `fk_Empleado_Usuario1`
    FOREIGN KEY (`Usuario_id` )
    REFERENCES `Usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE USER `academico` IDENTIFIED BY 'R1N9ts!ru040ct3dc3nm1€0l';

grant DELETE on TABLE `registro`.`Aspirante` to academico;
grant INSERT on TABLE `registro`.`Aspirante` to academico;
grant SELECT on TABLE `registro`.`Aspirante` to academico;
grant UPDATE on TABLE `registro`.`Aspirante` to academico;
grant ALL on TABLE `registro`.`Aspirante` to academico;
grant DELETE on TABLE `registro`.`Encargado` to academico;
grant INSERT on TABLE `registro`.`Encargado` to academico;
grant SELECT on TABLE `registro`.`Encargado` to academico;
grant UPDATE on TABLE `registro`.`Encargado` to academico;
grant ALL on TABLE `registro`.`Encargado` to academico;
grant UPDATE on TABLE `registro`.`Usuario` to academico;
grant SELECT on TABLE `registro`.`Usuario` to academico;
grant INSERT on TABLE `registro`.`Usuario` to academico;
grant DELETE on TABLE `registro`.`Usuario` to academico;
grant ALL on TABLE `registro`.`Usuario` to academico;
grant UPDATE on TABLE `registro`.`Empleado` to academico;
grant SELECT on TABLE `registro`.`Empleado` to academico;
grant INSERT on TABLE `registro`.`Empleado` to academico;
grant DELETE on TABLE `registro`.`Empleado` to academico;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `Usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `registro`;
INSERT INTO `Usuario` (`id`, `username`, `password`, `salt`, `rol`, `enabled`, `lock`) VALUES (-1, 'usuarioINTI', 'Uv9u6JM/NbN464qxZXpCzJomfYB2TWWCrI4MdT+S5C+N3EHP+TtvkA0lSA8ETyzZ/tcriC3aRy9YDPqr4Sa16Q==', 'l2gkhe40o5c44g8s8g4kw4w0o0sck0g', 'a:2:{i:0;s:9:\"ROLE_USER\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}', 1, NULL);
INSERT INTO `Usuario` (`id`, `username`, `password`, `salt`, `rol`, `enabled`, `lock`) VALUES (0, 'desarrolladorUES', 'ok6HFgqr7/uwDPKRN7KfdOiiOedTYgpRdrfIfAQh5S1zubtz7O/+Rqg11IXU99h8jV8PI/d5SxcGIuAQqjSwfw==', 'pxzoid8tur4s440swgs0k84800scgk0', 'a:2:{i:0;s:9:\"ROLE_USER\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}', 1, NULL);

COMMIT;
