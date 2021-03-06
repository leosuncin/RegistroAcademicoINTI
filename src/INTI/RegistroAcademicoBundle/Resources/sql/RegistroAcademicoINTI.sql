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
  `DUI` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(80) NOT NULL,
  `parentesco` VARCHAR(12) NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`DUI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Aspirante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Aspirante` (
  `NIE` INT NOT NULL,
  `foto` LONGTEXT NOT NULL,
  `primer_apellido` VARCHAR(15) NOT NULL,
  `segundo_apellido` VARCHAR(15) NULL,
  `nombres` VARCHAR(50) NOT NULL,
  `direccion` TEXT NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  `fecha_nac` DATE NOT NULL,
  `lugar_nac` VARCHAR(40) NOT NULL,
  `sexo` CHAR NOT NULL,
  `Especialidad` VARCHAR(5) NOT NULL,
  `Encargado` VARCHAR(10) NOT NULL,
  `class_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`NIE`),
  INDEX `1erApellido` (`primer_apellido` ASC),
  INDEX `2doApellido` (`segundo_apellido` ASC),
  INDEX `apellidos` (`segundo_apellido` ASC, `primer_apellido` ASC),
  INDEX `idx_Aspirante_Especialidad` (`Especialidad` ASC),
  INDEX `fk_Aspirante_Encargado1_idx` (`Encargado` ASC),
  CONSTRAINT `fk_Aspirante_Especialidad`
    FOREIGN KEY (`Especialidad`)
    REFERENCES `Especialidad` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_Aspirante_Encargado`
    FOREIGN KEY (`Encargado`)
    REFERENCES `Encargado` (`DUI`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
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
  `intents` INT NULL DEFAULT 0,
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
  `Responsabilidad` VARCHAR(5) NULL,
  INDEX `idx_Empleado_Usuario` (`Usuario` ASC),
  PRIMARY KEY (`DUI`),
  UNIQUE INDEX `ISSS_UNIQUE` (`ISSS` ASC),
  UNIQUE INDEX `NIT_UNIQUE` (`NIT` ASC),
  UNIQUE INDEX `NUP_UNIQUE` (`NUP` ASC),
  INDEX `fk_Empleado_Especialidad1_idx` (`Responsabilidad` ASC),
  CONSTRAINT `fk_Empleado_Usuario`
    FOREIGN KEY (`Usuario`)
    REFERENCES `Usuario` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Empleado_Especialidad`
    FOREIGN KEY (`Responsabilidad`)
    REFERENCES `Especialidad` (`codigo`)
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
-- Table `Codigo_especialidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Codigo_especialidad` (
  `codigo` CHAR(5) NOT NULL,
  `anho` INT NOT NULL,
  `seccion` CHAR NOT NULL,
  `Especialidad` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_Codigo_especialidad_Especialidad1_idx` (`Especialidad` ASC),
  CONSTRAINT `fk_Codigo_especialidad_Especialidad`
    FOREIGN KEY (`Especialidad`)
    REFERENCES `Especialidad` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Alumno` (
  `NIE` INT NOT NULL,
  `condicion` CHAR(2) NOT NULL,
  `Usuario` VARCHAR(50) NOT NULL,
  `Codigo_especialidad` CHAR(5) NOT NULL,
  PRIMARY KEY (`NIE`),
  INDEX `fk_Alumno_Usuario1_idx` (`Usuario` ASC),
  INDEX `fk_Alumno_Codigo_especialidad1_idx` (`Codigo_especialidad` ASC),
  CONSTRAINT `fk_Alumno_Usuario`
    FOREIGN KEY (`Usuario`)
    REFERENCES `Usuario` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Alumno_Codigo_especialidad`
    FOREIGN KEY (`Codigo_especialidad`)
    REFERENCES `Codigo_especialidad` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_Alumno_Aspirante`
    FOREIGN KEY (`NIE`)
    REFERENCES `Aspirante` (`NIE`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Empresa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `contacto` VARCHAR(80) NOT NULL,
  `telefono` VARCHAR(8) NOT NULL,
  `direccion` TEXT NOT NULL,
  `email` VARCHAR(40) NULL,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC),
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Anho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Anho` (
  `anho` INT NOT NULL,
  `inicio` DATE NOT NULL,
  `fin` DATE NULL,
  `en_curso` TINYINT(1) NOT NULL,
  PRIMARY KEY (`anho`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Periodo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Periodo` (
  `periodo` INT NOT NULL,
  `inicio` DATE NOT NULL,
  `fin` DATE NULL,
  `en_curso` TINYINT(1) NOT NULL,
  `Anho` INT NOT NULL,
  PRIMARY KEY (`periodo`),
  INDEX `fk_Periodo_Anho1_idx` (`Anho` ASC),
  CONSTRAINT `fk_Periodo_Anho`
    FOREIGN KEY (`Anho`)
    REFERENCES `Anho` (`anho`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = ucs2
COLLATE = ucs2_spanish2_ci;


-- -----------------------------------------------------
-- Table `Practica_profesional`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Practica_profesional` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `horario` CHAR NOT NULL,
  `inicio` DATE NOT NULL,
  `fin` DATE NULL,
  `evaluacion` DOUBLE NULL,
  `Alumno` INT NOT NULL,
  `Empresa` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Practica_profesional_Alumno1_idx` (`Alumno` ASC),
  UNIQUE INDEX `UNIQUE` (`Alumno` ASC, `Empresa` ASC),
  INDEX `fk_Practica_profesional_Empresa1_idx` (`Empresa` ASC),
  CONSTRAINT `fk_Practica_profesional_Alumno`
    FOREIGN KEY (`Alumno`)
    REFERENCES `Alumno` (`NIE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Practica_profesional_Empresa`
    FOREIGN KEY (`Empresa`)
    REFERENCES `Empresa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Materia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Materia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` INT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `profesor` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Nota`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Nota` (
  `Alumno` INT NOT NULL,
  `Materia` INT NOT NULL,
  `Periodo` INT NOT NULL,
  `valor` DOUBLE(2,2) NOT NULL,
  PRIMARY KEY (`Alumno`, `Materia`, `Periodo`),
  INDEX `fk_Nota_Materia1_idx` (`Materia` ASC),
  INDEX `fk_Nota_Periodo1_idx` (`Periodo` ASC),
  CONSTRAINT `fk_Nota_Alumno`
    FOREIGN KEY (`Alumno`)
    REFERENCES `Alumno` (`NIE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nota_Materia`
    FOREIGN KEY (`Materia`)
    REFERENCES `Materia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nota_Periodo`
    FOREIGN KEY (`Periodo`)
    REFERENCES `Periodo` (`periodo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Servicio_social`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Servicio_social` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `horas_realizadas` DOUBLE NOT NULL,
  `Alumno` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Servicio_social_Alumno1_idx` (`Alumno` ASC),
  CONSTRAINT `fk_Servicio_social_Alumno`
    FOREIGN KEY (`Alumno`)
    REFERENCES `Alumno` (`NIE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Encargado_proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Encargado_proyecto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(80) NOT NULL,
  `rol` VARCHAR(20) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Proyecto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NOT NULL,
  `descripcion` TINYTEXT NULL,
  `Encargado` INT NOT NULL,
  `Servicio_social` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Proyecto_Encargado_proyecto1_idx` (`Encargado` ASC),
  INDEX `fk_Proyecto_Servicio_social1_idx` (`Servicio_social` ASC),
  CONSTRAINT `fk_Proyecto_Encargado_proyecto`
    FOREIGN KEY (`Encargado`)
    REFERENCES `Encargado_proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proyecto_Servicio_social`
    FOREIGN KEY (`Servicio_social`)
    REFERENCES `Servicio_social` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Placeholder table for view `Alumno_inscrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Alumno_inscrito` (`nie` INT, `foto` INT, `nombre_completo` INT, `direccion` INT, `telefono` INT, `edad` INT, `lugar_nac` INT, `sexo` INT, `codigo` INT);

DELIMITER $$
USE `registro`$$
-- -----------------------------------------------------
-- procedure bloquear_usuario
-- -----------------------------------------------------

CREATE PROCEDURE `bloquear_usuario` (IN usuario VARCHAR(50))
BEGIN
	IF EXISTS (SELECT username FROM Usuario WHERE username = usuario) THEN
		UPDATE Usuario SET locked = TRUE, intents = 3 WHERE username = usuario;
		INSERT INTO Bloqueo_usuarios(bloqueo, username) VALUES(NOW(), usuario);
	END IF;
END$$

-- -----------------------------------------------------
-- procedure desbloquear_usuario
-- -----------------------------------------------------

CREATE PROCEDURE `desbloquear_usuario` (IN usuario VARCHAR(50))
BEGIN
	IF EXISTS (SELECT username FROM Usuario WHERE username = usuario) THEN
		UPDATE Bloqueo_usuarios SET desbloqueo = NOW(), bloqueo = bloqueo WHERE username = usuario AND ISNULL(desbloqueo);
		UPDATE Usuario SET locked = FALSE, intents = 0 WHERE username = usuario;
	END IF;
END$$

-- -----------------------------------------------------
-- procedure desbloquear_usuarios
-- -----------------------------------------------------

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

-- -----------------------------------------------------
-- function edad
-- -----------------------------------------------------

CREATE FUNCTION `edad` (fecha DATE) RETURNS INT DETERMINISTIC
	RETURN DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(fecha)), '%Y') + 0;$$

-- -----------------------------------------------------
-- function periodo_actual
-- -----------------------------------------------------

CREATE FUNCTION `periodo_actual` () RETURNS INT DETERMINISTIC
BEGIN
DECLARE p_actual INT;
SELECT MAX(periodo) INTO p_actual FROM Periodo WHERE en_curso = TRUE;
RETURN p_actual;
END$$

-- -----------------------------------------------------
-- function anho_actual
-- -----------------------------------------------------

CREATE FUNCTION `anho_actual` () RETURNS INT DETERMINISTIC
BEGIN
DECLARE a_actual INT;
SELECT MAX(anho) INTO a_actual FROM Anho WHERE en_curso = TRUE;
RETURN a_actual;
END$$

-- -----------------------------------------------------
-- View `Alumno_inscrito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Alumno_inscrito`;
USE `registro`;
CREATE  OR REPLACE VIEW `Alumno_inscrito` AS
SELECT
	ap.nie,
	ap.foto,
	CONCAT_WS(' ', ap.nombres, ap.primer_apellido, ap.segundo_apellido) AS nombre_completo,
	ap.direccion,
	ap.telefono,
	edad(ap.fecha_nac) AS edad,
	ap.lugar_nac,
	ap.sexo,
	al.Codigo_especialidad
FROM
	Aspirante ap,
	Alumno al
WHERE
	al.NIE = ap.NIE;

CREATE USER 'academico' IDENTIFIED BY 'R1N9ts!ru040ct3dc3nm1€0l';

GRANT DELETE, INSERT, SELECT, UPDATE ON TABLE `registro`.`Aspirante` TO 'academico';
GRANT DELETE, INSERT, SELECT, UPDATE ON TABLE `registro`.`Encargado` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Usuario` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Empleado` TO 'academico';
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE `registro`.`Especialidad` TO 'academico';
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE `registro`.`Bloqueo_usuarios` TO 'academico';
GRANT EXECUTE ON procedure `registro`.`bloquear_usuario` TO 'academico';
GRANT EXECUTE ON procedure `registro`.`desbloquear_usuario` TO 'academico';
GRANT EXECUTE ON procedure `registro`.`desbloquear_usuarios` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Alumno` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Anho` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Codigo_especialidad` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Empresa` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Materia` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Nota` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Periodo` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Practica_profesional` TO 'academico';
GRANT EXECUTE ON function `registro`.`periodo_actual` TO 'academico';
GRANT EXECUTE ON function `registro`.`anho_actual` TO 'academico';
GRANT INSERT, UPDATE, SELECT, DELETE ON TABLE `registro`.`Encargado_proyecto` TO 'academico';
GRANT DELETE, INSERT, SELECT, UPDATE ON TABLE `registro`.`Proyecto` TO 'academico';
GRANT UPDATE, SELECT, INSERT, DELETE ON TABLE `registro`.`Servicio_social` TO 'academico';
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE `registro`.`Alumno_inscrito` TO 'academico';
GRANT EXECUTE ON function `registro`.`edad` TO 'academico';

FLUSH PRIVILEGES;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `Especialidad`
-- -----------------------------------------------------
START TRANSACTION;
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
INSERT INTO `Usuario` (`username`, `password`, `salt`, `rol`, `enabled`, `locked`, `intents`) VALUES ('usuarioINTI', 'Uv9u6JM/NbN464qxZXpCzJomfYB2TWWCrI4MdT+S5C+N3EHP+TtvkA0lSA8ETyzZ/tcriC3aRy9YDPqr4Sa16Q==', 'l2gkhe40o5c44g8s8g4kw4w0o0sck0g', 'a:1:{i:0;s:9:\"ROLE_USER\";}', 1, NULL, 0);
INSERT INTO `Usuario` (`username`, `password`, `salt`, `rol`, `enabled`, `locked`, `intents`) VALUES ('desarrolladorUES', 'ok6HFgqr7/uwDPKRN7KfdOiiOedTYgpRdrfIfAQh5S1zubtz7O/+Rqg11IXU99h8jV8PI/d5SxcGIuAQqjSwfw==', 'pxzoid8tur4s440swgs0k84800scgk0', 'a:2:{i:0;s:9:\"ROLE_USER\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}', 1, NULL, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Codigo_especialidad`
-- -----------------------------------------------------
START TRANSACTION;
USE `registro`;
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT1A', 1, 'A', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT1B', 1, 'B', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT1C', 1, 'C', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT2A', 2, 'A', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT2B', 2, 'B', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT3A', 3, 'A', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('ELT3B', 3, 'B', 'ELTIA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL1A', 1, 'A', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL1B', 1, 'B', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL1C', 1, 'C', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL1D', 1, 'D', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL1E', 1, 'E', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL2A', 2, 'A', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL2B', 2, 'B', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL2C', 2, 'C', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL2D', 2, 'D', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL2E', 2, 'E', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL3A', 3, 'A', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL3B', 3, 'B', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL3C', 3, 'C', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('EL3D', 3, 'D', 'ELCA');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A1A', 1, 'A', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A1B', 1, 'B', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A1C', 1, 'C', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A1D', 1, 'D', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A1E', 1, 'E', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A2A', 2, 'A', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A2B', 2, 'B', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A2C', 2, 'C', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A2D', 2, 'D', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A3A', 3, 'A', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A3B', 3, 'B', 'AUTO');
INSERT INTO `Codigo_especialidad` (`codigo`, `anho`, `seccion`, `Especialidad`) VALUES ('A3C', 3, 'C', 'AUTO');

COMMIT;

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

CREATE TRIGGER `Eliminar_Usuario_Empleado` AFTER DELETE ON `Empleado` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
DELETE FROM Usuario WHERE username = OLD.Usuario;$$

CREATE TRIGGER `Eliminar_Usuario_Alumno` AFTER DELETE ON `Alumno` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
DELETE FROM Usuario WHERE username = OLD.Usuario;$$

CREATE TRIGGER `check_enCurso_anho` BEFORE INSERT ON `Anho` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF ISNULL(NEW.inicio) THEN
		SET NEW.inicio = CURDATE();
	END IF;
	IF ISNULL(NEW.fin) THEN
		SET NEW.en_curso = TRUE;
	END IF;
	SET NEW.anho = YEAR(NEW.inicio);
END$$

CREATE TRIGGER `check_close_anho` BEFORE UPDATE ON `Anho` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF NEW.inicio > NEW.fin THEN
		SIGNAL SQLSTATE '45000' SET message_text = 'La fecha de cierre no puede ser antes de la de apertura';
	END IF;
	IF ISNULL(NEW.fin) THEN
		SET NEW.en_curso = TRUE;
	ELSE
		SET NEW.en_curso = FALSE;
	END IF;
END$$

CREATE TRIGGER `check_enCurso_periodo` BEFORE INSERT ON `Periodo` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF ISNULL(NEW.inicio) THEN
		SET NEW.inicio = CURDATE();
	END IF;
	IF ISNULL(NEW.fin) THEN
		SET NEW.en_curso = TRUE;
	ELSE
		SET NEW.en_curso = FALSE;
	END IF;
END$$

CREATE TRIGGER `check_close_periodo` BEFORE UPDATE ON `Periodo` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF NEW.inicio > NEW.fin THEN
		SIGNAL SQLSTATE '45000' SET message_text = 'La fecha de cierre no puede ser antes de la de apertura';
	END IF;
	IF ISNULL(NEW.fin) THEN
		SET NEW.en_curso = TRUE;
	ELSE
		SET NEW.en_curso = FALSE;
	END IF;
END$$

CREATE EVENT `actualizar_bloqueo_usuarios` ON SCHEDULE EVERY 1 HOUR DO CALL desbloquear_usuarios()$$

DELIMITER ;

SET @@global.event_scheduler = ON;
