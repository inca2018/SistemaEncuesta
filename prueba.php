DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_CLIENTE_RECUPERAR`(IN `idClienteR` INT(11))
    NO SQL
BEGIN

SELECT c.idCliente,en.RazonSocial,en.RUC,c.NombreContacto,c.CorreoContacto,en.Direccion,c.Cargo,DATE_FORMAT(c.fechaRegistro,"%d/%m/%Y") as fechaRegistro,c.Estado_idEstado,e.nombreEstado FROM cliente c INNER JOIN entidad en ON en.idEntidad=c.Entidad_idEntidad INNER JOIN estado e ON e.idEstado=c.Estado_idEstado where c.idCliente=idClienteR  ORDER BY c.idCliente DESC;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_CLIENTE_EDITAR`(IN `nombreContacto` VARCHAR(150), IN `correoContacto` VARCHAR(150), IN `cargoU` VARCHAR(150), IN `idEntidadE` INT(11), IN `idClienteU` INT(11))
    NO SQL
BEGIN

UPDATE `cliente` SET `NombreContacto`=nombreContacto ,`CorreoContacto`=correoContacto,`Cargo`=cargoU WHERE `idCliente`=idClienteU and  `Entidad_idEntidad`=idEntidadE;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_CLIENTE_LISTAR`(IN `idEntidadE` INT(11))
    NO SQL
BEGIN

SELECT c.idCliente,en.RazonSocial,en.RUC,c.NombreContacto,c.CorreoContacto,en.Direccion,c.Cargo,DATE_FORMAT(c.fechaRegistro,"%d/%m/%Y") as fechaRegistro,c.Estado_idEstado,e.nombreEstado FROM cliente c INNER JOIN entidad en ON en.idEntidad=c.Entidad_idEntidad INNER JOIN estado e ON e.idEstado=c.Estado_idEstado where c.Entidad_idEntidad=idEntidadE ORDER BY c.idCliente DESC;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_CLIENTE_ESTADO`(IN `idClienteU` INT(11), IN `accion` INT(11))
    NO SQL
BEGIN

IF(accion=1)THEN

UPDATE `cliente` SET `Estado_idEstado`=1 WHERE `idCliente`=idClienteU;

ELSE

UPDATE `cliente` SET `Estado_idEstado`=2 WHERE `idCliente`=idClienteU;

END IF;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_CLIENTE_REGISTRO`(IN `nombreContacto` VARCHAR(150), IN `correoContacto` VARCHAR(150), IN `cargoR` VARCHAR(150), IN `idEntidadR` INT(11))
    NO SQL
BEGIN

INSERT INTO `cliente`(`idCliente`, `NombreContacto`, `CorreoContacto`,`Cargo`,`fechaRegistro`, `Entidad_idEntidad`, `Estado_idEstado`) VALUES (NULL,nombreContacto,correoContacto,cargoR,NOW(),idEntidadR,1);

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_CLIENTE_ELIMINAR`(IN `idClienteD` INT)
    NO SQL
BEGIN

DELETE FROM `cliente` WHERE `idCliente`=idClienteD;

END$$
DELIMITER ;
