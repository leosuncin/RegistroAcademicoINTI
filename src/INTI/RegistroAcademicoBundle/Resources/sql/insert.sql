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
