SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `registro` DEFAULT CHARACTER SET ucs2 COLLATE ucs2_spanish2_ci ;
USE `registro` ;

-- -----------------------------------------------------
-- Table `registro`.`Especialidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Especialidad` (
  `codigo` VARCHAR(5) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `Sort` (`nombre` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Encargado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Encargado` (
  `nombre` VARCHAR(80) NOT NULL,
  `parentesco` VARCHAR(12) NOT NULL,
  `DUI` VARCHAR(10) NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`DUI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Aspirante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Aspirante` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `foto` TEXT NOT NULL,
  `primerApellido` VARCHAR(15) NOT NULL,
  `segundoApellido` VARCHAR(15) NULL,
  `nombres` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  `fechaNac` DATE NOT NULL,
  `lugarNac` VARCHAR(100) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `Especialidad` VARCHAR(5) NOT NULL,
  `Encargado` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `1erApellido` (`primerApellido` ASC),
  INDEX `2doApellido` (`segundoApellido` ASC),
  INDEX `apellidos` (`segundoApellido` ASC, `primerApellido` ASC),
  INDEX `idx_Aspirante_Especialidad` (`Especialidad` ASC),
  INDEX `idx_Aspirante_Encargado` (`Encargado` ASC),
  CONSTRAINT `fk_Aspirante_Especialidad`
    FOREIGN KEY (`Especialidad`)
    REFERENCES `registro`.`Especialidad` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_Aspirante_Encargado`
    FOREIGN KEY (`Encargado`)
    REFERENCES `registro`.`Encargado` (`DUI`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Usuario` (
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(255) NOT NULL,
  `rol` LONGTEXT NOT NULL,
  `enabled` TINYINT(1) NOT NULL DEFAULT true,
  `locked` TINYINT(1) NULL DEFAULT false,
  `intents` TINYINT(4) NULL DEFAULT 0,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Empleado` (
  `nombres` VARCHAR(80) NOT NULL,
  `apellidos` VARCHAR(80) NOT NULL,
  `puesto` VARCHAR(60) NOT NULL,
  `fotografia` TEXT NULL,
  `DUI` VARCHAR(10) NOT NULL,
  `ISSS` VARCHAR(9) NOT NULL,
  `NIT` VARCHAR(17) NOT NULL,
  `NUP` VARCHAR(12) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `Usuario` VARCHAR(50) NOT NULL,
  INDEX `idx_Empleado_Usuario` (`Usuario` ASC),
  PRIMARY KEY (`DUI`),
  UNIQUE INDEX `ISSS_UNIQUE` (`ISSS` ASC),
  UNIQUE INDEX `NIT_UNIQUE` (`NIT` ASC),
  UNIQUE INDEX `NUP_UNIQUE` (`NUP` ASC),
  CONSTRAINT `fk_Empleado_Usuario1`
    FOREIGN KEY (`Usuario`)
    REFERENCES `registro`.`Usuario` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Bloqueo_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Bloqueo_usuarios` (
  `bloqueo` TIMESTAMP NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `desbloqueo` VARCHAR(45) NULL,
  PRIMARY KEY (`bloqueo`, `username`),
  INDEX `fk_bloqueo_usuario_idx` (`username` ASC),
  CONSTRAINT `fk_bloqueo_usuario`
    FOREIGN KEY (`username`)
    REFERENCES `registro`.`Usuario` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro`.`Alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro`.`Alumno` (
  `Aspirante` INT NOT NULL,
  `NIE` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Aspirante`, `NIE`),
  CONSTRAINT `fk_Alumno_Aspirante1`
    FOREIGN KEY (`Aspirante`)
    REFERENCES `registro`.`Aspirante` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `registro` ;

-- -----------------------------------------------------
-- procedure bloquear_usuario
-- -----------------------------------------------------

DELIMITER $$
USE `registro`$$
CREATE PROCEDURE `bloquear_usuario` (IN usuario VARCHAR(50))
BEGIN
	IF EXISTS (SELECT username FROM Usuario WHERE username = usuario) THEN
		UPDATE Usuario SET locked = TRUE, intents = 3 WHERE username = usuario;
		INSERT INTO Bloqueo_usuarios(bloqueo, username) VALUES(NOW(), usuario);
	END IF;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure desbloquear_usuario
-- -----------------------------------------------------

DELIMITER $$
USE `registro`$$
CREATE PROCEDURE `desbloquear_usuario` (IN usuario VARCHAR(50))
BEGIN
	IF EXISTS (SELECT username FROM Usuario WHERE username = usuario) THEN
		UPDATE Bloqueo_usuarios SET desbloqueo = NOW(), bloqueo = bloqueo WHERE username = usuario AND ISNULL(desbloqueo);
		UPDATE Usuario SET locked = FALSE, intents = 0 WHERE username = usuario;
	END IF;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure desbloquear_usuarios
-- -----------------------------------------------------

DELIMITER $$
USE `registro`$$
CREATE PROCEDURE `desbloquear_usuarios` ()
BEGIN
	DECLARE hecho BOOLEAN DEFAULT FALSE;
	DECLARE usuario VARCHAR(50);
	DECLARE bloqueos CURSOR FOR SELECT username FROM Bloqueo_usuarios WHERE bloqueo <= DATE_SUB(NOW(), INTERVAL 1 HOUR) AND ISNULL(desbloqueo);
	DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET hecho = TRUE;
	OPEN bloqueos;
	REPEAT
		FETCH bloqueos INTO usuario;
		CALL desbloquear_usuario(usuario);
	UNTIL hecho END REPEAT;
	CLOSE bloqueos;
END$$

DELIMITER ;
CREATE USER 'academico' IDENTIFIED BY 'R1N9ts!ru040ct3dc3nm1€0l';

GRANT DELETE, INSERT, SELECT, UPDATE, ALL ON TABLE `registro`.`Aspirante` TO 'academico';
GRANT DELETE, INSERT, SELECT, UPDATE, ALL ON TABLE `registro`.`Encargado` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE, ALL ON TABLE `registro`.`Usuario` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE, ALL ON TABLE `registro`.`Empleado` TO 'academico';
GRANT ALL, INSERT, SELECT, UPDATE, DELETE ON TABLE `registro`.`Especialidad` TO 'academico';
GRANT ALL, INSERT, SELECT, UPDATE, DELETE ON TABLE `registro`.`Bloqueo_usuarios` TO 'academico';
GRANT EXECUTE, ALL ON procedure `registro`.`bloquear_usuario` TO 'academico';
GRANT ALL, EXECUTE ON procedure `registro`.`desbloquear_usuario` TO 'academico';
GRANT ALL, EXECUTE ON procedure `registro`.`desbloquear_usuarios` TO 'academico';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `registro`.`Especialidad`
-- -----------------------------------------------------
START TRANSACTION;
USE `registro`;
INSERT INTO `registro`.`Especialidad` (`codigo`, `nombre`) VALUES ('ELTIA', 'Electrotecnia');
INSERT INTO `registro`.`Especialidad` (`codigo`, `nombre`) VALUES ('ELCA', 'Electrónica');
INSERT INTO `registro`.`Especialidad` (`codigo`, `nombre`) VALUES ('AUTO', 'Automotores');
INSERT INTO `registro`.`Especialidad` (`codigo`, `nombre`) VALUES ('MECA', 'Mecánica general');
INSERT INTO `registro`.`Especialidad` (`codigo`, `nombre`) VALUES ('DS', 'Desarrollo de software');
INSERT INTO `registro`.`Especialidad` (`codigo`, `nombre`) VALUES ('COMP', 'Mantenimiento de computadoras');

COMMIT;


-- -----------------------------------------------------
-- Data for table `registro`.`Usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `registro`;
INSERT INTO `registro`.`Usuario` (`username`, `password`, `salt`, `rol`, `enabled`, `locked`, `intents`) VALUES ('usuarioINTI', 'Uv9u6JM/NbN464qxZXpCzJomfYB2TWWCrI4MdT+S5C+N3EHP+TtvkA0lSA8ETyzZ/tcriC3aRy9YDPqr4Sa16Q==', 'l2gkhe40o5c44g8s8g4kw4w0o0sck0g', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 1, NULL, 0);
INSERT INTO `registro`.`Usuario` (`username`, `password`, `salt`, `rol`, `enabled`, `locked`, `intents`) VALUES ('desarrolladorUES', 'ok6HFgqr7/uwDPKRN7KfdOiiOedTYgpRdrfIfAQh5S1zubtz7O/+Rqg11IXU99h8jV8PI/d5SxcGIuAQqjSwfw==', 'pxzoid8tur4s440swgs0k84800scgk0', 'a:2:{i:0;s:9:\"ROLE_USER\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}', 1, NULL, 0);

COMMIT;

USE `registro`;

DELIMITER $$
USE `registro`$$
CREATE TRIGGER `verificar_bloqueo` BEFORE UPDATE ON `Usuario` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF NEW.intents >= 3 THEN
		SET NEW.locked = TRUE;
		INSERT INTO Bloqueo_usuarios(bloqueo, username) VALUES(NOW(), NEW.username);
	END IF;
END$$


DELIMITER ;
