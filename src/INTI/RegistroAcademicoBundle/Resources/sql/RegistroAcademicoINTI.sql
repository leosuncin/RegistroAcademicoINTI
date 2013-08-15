SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `registro` DEFAULT CHARACTER SET ucs2 COLLATE ucs2_spanish2_ci ;
USE `registro` ;

-- -----------------------------------------------------
-- Table `registro`.`Encargado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `registro`.`Encargado` (
  `id` INT NOT NULL ,
  `nombre` VARCHAR(80) NOT NULL ,
  `Parentesco` VARCHAR(12) NOT NULL ,
  `DUI` VARCHAR(10) NOT NULL ,
  `telefono` VARCHAR(8) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Aspirante`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `registro`.`Aspirante` (
  `id` INT NOT NULL ,
  `foto` TEXT NOT NULL ,
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
    REFERENCES `registro`.`Encargado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `registro`.`Usuario` (
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


CREATE USER `academico` IDENTIFIED BY 'R1N9ts!ru040ct3dc3nm1€0l';

grant DELETE on TABLE `registro`.`Aspirante` to academico;
grant INSERT on TABLE `registro`.`Aspirante` to academico;
grant SELECT on TABLE `registro`.`Aspirante` to academico;
grant UPDATE on TABLE `registro`.`Aspirante` to academico;
grant DELETE on TABLE `registro`.`Encargado` to academico;
grant INSERT on TABLE `registro`.`Encargado` to academico;
grant SELECT on TABLE `registro`.`Encargado` to academico;
grant UPDATE on TABLE `registro`.`Encargado` to academico;
grant UPDATE on TABLE `registro`.`Usuario` to academico;
grant SELECT on TABLE `registro`.`Usuario` to academico;
grant INSERT on TABLE `registro`.`Usuario` to academico;
grant DELETE on TABLE `registro`.`Usuario` to academico;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
