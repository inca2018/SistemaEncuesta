DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_ENTIDAD_REGISTRO`(IN `razonSocial` VARCHAR(150), IN `ruc` CHAR(11), IN `direccion` TEXT)
    NO SQL
BEGIN

INSERT INTO `entidad`(`idEntidad`, `RazonSocial`, `RUC`, `Dirección`, `Estado_idEstado`, `fechaRegistro`) VALUES (NULL,UPPER(razonSocial),ruc,UPPER(direccion),1,NOW());
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_ENTIDAD_EDITAR`(IN `razonSocial` VARCHAR(150), IN `ruc` CHAR(11), IN `direccion` TEXT, IN `idEntidadU` INT(11))
    NO SQL
BEGIN

UPDATE `entidad` SET `RazonSocial`=razonSocial,`RUC`=ruc,`Dirección`=direccion WHERE `idEntidad`=idEntidadU;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_ENTIDAD_ELIMINAR`(IN `idEntidadD` INT)
    NO SQL
BEGIN


DELETE FROM `entidad` WHERE `idEntidad`=idEntidadD;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_ENTIDAD_RECUPERAR`(IN `idEntidadC` INT(11))
    NO SQL
BEGIN

SELECT en.RazonSocial,en.RUC,en.Dirección,en.Estado_idEstado,e.nombreEstado, DATE_FORMAT(en.fechaRegistro,"%d/%m/%Y") as fechaRegistro FROM entidad en inner join estado e ON e.idEstado=en.Estado_idEstado where en.idEntidad=idEntidadC;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_ENTIDAD_ESTADO`(IN `idEntiadadU` INT(11), IN `accion` INT(11))
    NO SQL
BEGIN

IF(accion=1)THEN

UPDATE `entidad` SET `Estado_idEstado`=1 WHERE `idEntidad`=idEntiadadU;

ELSE

UPDATE `entidad` SET `Estado_idEstado`=2 WHERE `idEntidad`=idEntiadadU;

END IF;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`cpses_siyxz72pr2`@`localhost` PROCEDURE `SP_ENTIDAD_LISTAR`()
    NO SQL
BEGIN

SELECT en.RazonSocial,en.RUC,en.Dirección,en.Estado_idEstado,e.nombreEstado, DATE_FORMAT(en.fechaRegistro,"%d/%m/%Y") as fechaRegistro FROM entidad en inner join estado e ON e.idEstado=en.Estado_idEstado;

END$$
DELIMITER ;
