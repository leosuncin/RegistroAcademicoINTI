SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `registro` DEFAULT CHARACTER SET ucs2 COLLATE ucs2_spanish2_ci ;
USE `registro` ;

-- -----------------------------------------------------
-- Table `Especialidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Especialidad` (
  `codigo` VARCHAR(5) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `Sort` (`nombre` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Encargado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Encargado` (
  `nombre` VARCHAR(80) NOT NULL,
  `parentesco` VARCHAR(12) NOT NULL,
  `DUI` VARCHAR(10) NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`DUI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Aspirante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Aspirante` (
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
    REFERENCES `Especialidad` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_Aspirante_Encargado`
    FOREIGN KEY (`Encargado`)
    REFERENCES `Encargado` (`DUI`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Usuario` (
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
-- Table `Empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Empleado` (
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
    REFERENCES `Usuario` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Bloqueo_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Bloqueo_usuarios` (
  `bloqueo` TIMESTAMP NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `desbloqueo` VARCHAR(45) NULL,
  PRIMARY KEY (`bloqueo`, `username`),
  INDEX `fk_bloqueo_usuario_idx` (`username` ASC),
  CONSTRAINT `fk_bloqueo_usuario`
    FOREIGN KEY (`username`)
    REFERENCES `Usuario` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Alumno` (
  `Aspirante` INT NOT NULL,
  `NIE` INT NOT NULL,
  PRIMARY KEY (`NIE`, `Aspirante`),
  UNIQUE INDEX `Aspirante_UNIQUE` (`Aspirante` ASC),
  CONSTRAINT `fk_Alumno_Aspirante1`
    FOREIGN KEY (`Aspirante`)
    REFERENCES `Aspirante` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Empresa` (
  `nombre` VARCHAR(50) NOT NULL,
  `contacto` VARCHAR(80) NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  `direccion` TEXT NOT NULL,
  `email` VARCHAR(40) NULL,
  PRIMARY KEY (`nombre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Practica_profesional`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Practica_profesional` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `horario` VARCHAR(10) NOT NULL,
  `inicio` DATE NOT NULL,
  `fin` DATE NULL,
  `evaluacion` DOUBLE(2,2) NULL,
  `Alumno` INT NOT NULL,
  `Empresa` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`, `Alumno`, `Empresa`),
  INDEX `fk_Practica_profesional_Alumno1_idx` (`Alumno` ASC),
  INDEX `fk_Practica_profesional_Empresa1_idx` (`Empresa` ASC),
  CONSTRAINT `fk_Practica_profesional_Alumno1`
    FOREIGN KEY (`Alumno`)
    REFERENCES `Alumno` (`NIE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Practica_profesional_Empresa1`
    FOREIGN KEY (`Empresa`)
    REFERENCES `Empresa` (`nombre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Aspectos_practica_profesional`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Aspectos_practica_profesional` (
  `practica_profesional` INT NOT NULL,
  `aspecto` VARCHAR(80) NOT NULL,
  `valoracion` CHAR(2) NULL,
  `observacion` TINYTEXT NULL,
  INDEX `fk_Aspectos_practica_profesional_idx` (`practica_profesional` ASC),
  PRIMARY KEY (`aspecto`, `practica_profesional`),
  CONSTRAINT `fk_Aspectos_practica_profesional`
    FOREIGN KEY (`practica_profesional`)
    REFERENCES `Practica_profesional` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
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
GRANT EXECUTE, ALL ON procedure `bloquear_usuario` TO 'academico';
GRANT ALL, EXECUTE ON procedure `desbloquear_usuario` TO 'academico';
GRANT ALL, EXECUTE ON procedure `desbloquear_usuarios` TO 'academico';

FLUSH PRIVILEGES;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `Especialidad`
-- -----------------------------------------------------
START TRANSACTION;
USE `registro`;
INSERT INTO `Especialidad` (`codigo`, `nombre`) VALUES ('ELTIA', 'Electrotecnia');
INSERT INTO `Especialidad` (`codigo`, `nombre`) VALUES ('ELCA', 'Electrónica');
INSERT INTO `Especialidad` (`codigo`, `nombre`) VALUES ('AUTO', 'Automotores');
INSERT INTO `Especialidad` (`codigo`, `nombre`) VALUES ('MECA', 'Mecánica general');
INSERT INTO `Especialidad` (`codigo`, `nombre`) VALUES ('DS', 'Desarrollo de software');
INSERT INTO `Especialidad` (`codigo`, `nombre`) VALUES ('COMP', 'Mantenimiento de computadoras');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `registro`;
INSERT INTO `Usuario` (`username`, `password`, `salt`, `rol`, `enabled`, `locked`, `intents`) VALUES ('usuarioINTI', 'Uv9u6JM/NbN464qxZXpCzJomfYB2TWWCrI4MdT+S5C+N3EHP+TtvkA0lSA8ETyzZ/tcriC3aRy9YDPqr4Sa16Q==', 'l2gkhe40o5c44g8s8g4kw4w0o0sck0g', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 1, NULL, 0);
INSERT INTO `Usuario` (`username`, `password`, `salt`, `rol`, `enabled`, `locked`, `intents`) VALUES ('desarrolladorUES', 'ok6HFgqr7/uwDPKRN7KfdOiiOedTYgpRdrfIfAQh5S1zubtz7O/+Rqg11IXU99h8jV8PI/d5SxcGIuAQqjSwfw==', 'pxzoid8tur4s440swgs0k84800scgk0', 'a:2:{i:0;s:9:\"ROLE_USER\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}', 1, NULL, 0);

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

USE `registro`$$
CREATE TRIGGER `Eliminar_Usuario_Empleado` AFTER DELETE ON `Empleado` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
DELETE FROM Usuario WHERE username = OLD.Usuario;$$


DELIMITER ;
