-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-01-2019 a las 20:49:05
-- Versión del servidor: 5.7.19
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemaencuesta`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `SP_CLIENTE_EDITAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CLIENTE_EDITAR` (IN `nombreContacto` VARCHAR(150), IN `correoContacto` VARCHAR(150), IN `cargoU` VARCHAR(150), IN `idEntidadE` INT(11), IN `idClienteU` INT(11))  NO SQL
BEGIN 
 
UPDATE `cliente` SET `NombreContacto`=nombreContacto ,`CorreoContacto`=correoContacto,`Cargo`=cargoU WHERE `idCliente`=idClienteU and  `Entidad_idEntidad`=idEntidadE;

END$$

DROP PROCEDURE IF EXISTS `SP_CLIENTE_ELIMINAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CLIENTE_ELIMINAR` (IN `idClienteD` INT)  NO SQL
BEGIN

DELETE FROM `cliente` WHERE `idCliente`=idClienteD;

END$$

DROP PROCEDURE IF EXISTS `SP_CLIENTE_ESTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CLIENTE_ESTADO` (IN `idClienteU` INT(11), IN `accion` INT(11))  NO SQL
BEGIN 

IF(accion=1)THEN 

UPDATE `cliente` SET `Estado_idEstado`=1 WHERE `idCliente`=idClienteU;
 
ELSE 

UPDATE `cliente` SET `Estado_idEstado`=2 WHERE `idCliente`=idClienteU;

END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_CLIENTE_LISTAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CLIENTE_LISTAR` (IN `idEntidadE` INT(11))  NO SQL
BEGIN 

SELECT c.idCliente,en.RazonSocial,en.RUC,c.NombreContacto,c.CorreoContacto,en.Direccion,c.Cargo,DATE_FORMAT(c.fechaRegistro,"%d/%m/%Y") as fechaRegistro,c.Estado_idEstado,e.nombreEstado FROM cliente c INNER JOIN entidad en ON en.idEntidad=c.Entidad_idEntidad INNER JOIN estado e ON e.idEstado=c.Estado_idEstado where c.Entidad_idEntidad=idEntidadE ORDER BY c.idCliente DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_CLIENTE_RECUPERAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CLIENTE_RECUPERAR` (IN `idClienteR` INT(11))  NO SQL
BEGIN 

SELECT c.idCliente,en.RazonSocial,en.RUC,c.NombreContacto,c.CorreoContacto,en.Direccion,c.Cargo,DATE_FORMAT(c.fechaRegistro,"%d/%m/%Y") as fechaRegistro,c.Estado_idEstado,e.nombreEstado FROM cliente c INNER JOIN entidad en ON en.idEntidad=c.Entidad_idEntidad INNER JOIN estado e ON e.idEstado=c.Estado_idEstado where c.idCliente=idClienteR  ORDER BY c.idCliente DESC;
END$$

DROP PROCEDURE IF EXISTS `SP_CLIENTE_REGISTRO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CLIENTE_REGISTRO` (IN `nombreContacto` VARCHAR(150), IN `correoContacto` VARCHAR(150), IN `cargoR` VARCHAR(150), IN `idEntidadR` INT(11))  NO SQL
BEGIN 
 
INSERT INTO `cliente`(`idCliente`, `NombreContacto`, `CorreoContacto`,`Cargo`,`fechaRegistro`, `Entidad_idEntidad`, `Estado_idEstado`) VALUES (NULL,nombreContacto,correoContacto,cargoR,NOW(),idEntidadR,1);

END$$

DROP PROCEDURE IF EXISTS `SP_ENCUESTA_EDITAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENCUESTA_EDITAR` (IN `TituloU` VARCHAR(150), IN `DetalleU` TEXT, IN `idEncuestaU` INT(11))  NO SQL
BEGIN 
 
UPDATE `encuesta` SET `TituloEncuesta`=TituloU,`DetalleEncuesta`=DetalleU  WHERE `idEncuesta`=idEncuestaU;

END$$

DROP PROCEDURE IF EXISTS `SP_ENCUESTA_ELIMINAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENCUESTA_ELIMINAR` (IN `idEncuestaD` INT)  NO SQL
BEGIN

DELETE FROM `encuesta` WHERE `idEncuesta`=idEncuestaD;

END$$

DROP PROCEDURE IF EXISTS `SP_ENCUESTA_ESTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENCUESTA_ESTADO` (IN `idEncuestaU` INT(11), IN `accion` INT(11))  NO SQL
BEGIN 

IF(accion=1)THEN 

UPDATE `encuesta` SET `Estado_idEstado`=1 WHERE `idEncuesta`=idEncuestaU;
 
ELSE 

UPDATE `encuesta` SET `Estado_idEstado`=2 WHERE `idEncuesta`=idEncuestaU;

END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_ENCUESTA_LISTAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENCUESTA_LISTAR` ()  NO SQL
BEGIN 

SELECT en.idEncuesta,en.TituloEncuesta,en.DetalleEncuesta,DATE_FORMAT(en.fechaRegistro,"%d/%m/%Y") AS fechaRegistro,en.Estado_idEstado,e.nombreEstado,e.TipoEstado,
(SELECT COUNT(*) FROM pregunta pre WHERE pre.Encuesta_idEncuesta=en.idEncuesta) as CantidadPreguntas
FROM  encuesta en INNER JOIN estado e ON e.idEstado=en.Estado_idEstado ORDER BY en.idEncuesta DESC; 

END$$

DROP PROCEDURE IF EXISTS `SP_ENCUESTA_RECUPERAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENCUESTA_RECUPERAR` (IN `idEncuestaR` INT)  NO SQL
BEGIN 

SELECT e.idEncuesta,e.TituloEncuesta,e.DetalleEncuesta,e.Estado_idEstado FROM encuesta e where e.idEncuesta=idEncuestaR;

END$$

DROP PROCEDURE IF EXISTS `SP_ENCUESTA_REGISTRO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENCUESTA_REGISTRO` (IN `TituloR` VARCHAR(150), IN `DetalleR` TEXT)  NO SQL
BEGIN 
 
INSERT INTO `encuesta`(`idEncuesta`, `TituloEncuesta`, `DetalleEncuesta`, `fechaRegistro`, `Estado_idEstado`) VALUES (NULL,TituloR,DetalleR,NOW(),1);
END$$

DROP PROCEDURE IF EXISTS `SP_ENTIDAD_EDITAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENTIDAD_EDITAR` (IN `razonSocial` VARCHAR(150), IN `ruc` CHAR(11), IN `direccion` TEXT, IN `idEntidadU` INT(11))  NO SQL
BEGIN 
 
UPDATE `entidad` SET `RazonSocial`=razonSocial,`RUC`=ruc,`Direccion`=direccion WHERE `idEntidad`=idEntidadU;

END$$

DROP PROCEDURE IF EXISTS `SP_ENTIDAD_ELIMINAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENTIDAD_ELIMINAR` (IN `idEntidadD` INT)  NO SQL
BEGIN

 
DELETE FROM `entidad` WHERE `idEntidad`=idEntidadD;

END$$

DROP PROCEDURE IF EXISTS `SP_ENTIDAD_ESTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENTIDAD_ESTADO` (IN `idEntiadadU` INT(11), IN `accion` INT(11))  NO SQL
BEGIN 

IF(accion=1)THEN 

UPDATE `entidad` SET `Estado_idEstado`=1 WHERE `idEntidad`=idEntiadadU;
 
ELSE 

UPDATE `entidad` SET `Estado_idEstado`=2 WHERE `idEntidad`=idEntiadadU;

END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_ENTIDAD_LISTAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENTIDAD_LISTAR` ()  NO SQL
BEGIN 

SELECT en.idEntidad,en.RazonSocial,en.RUC,en.Direccion,en.Estado_idEstado,e.nombreEstado, DATE_FORMAT(en.fechaRegistro,"%d/%m/%Y") as fechaRegistro FROM entidad en inner join estado e ON e.idEstado=en.Estado_idEstado;

END$$

DROP PROCEDURE IF EXISTS `SP_ENTIDAD_RECUPERAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENTIDAD_RECUPERAR` (IN `idEntidadC` INT(11))  NO SQL
BEGIN 

SELECT en.idEntidad,en.RazonSocial,en.RUC,en.Direccion,en.Estado_idEstado,e.nombreEstado, DATE_FORMAT(en.fechaRegistro,"%d/%m/%Y") as fechaRegistro FROM entidad en inner join estado e ON e.idEstado=en.Estado_idEstado where en.idEntidad=idEntidadC;
END$$

DROP PROCEDURE IF EXISTS `SP_ENTIDAD_REGISTRO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENTIDAD_REGISTRO` (IN `razonSocial` VARCHAR(150), IN `ruc` CHAR(11), IN `direccion` TEXT)  NO SQL
BEGIN 

INSERT INTO `entidad`(`idEntidad`, `RazonSocial`, `RUC`, `Direccion`, `Estado_idEstado`, `fechaRegistro`) VALUES (NULL,UPPER(razonSocial),ruc,UPPER(direccion),1,NOW());
END$$

DROP PROCEDURE IF EXISTS `SP_ENVIAR_ENCUESTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ENVIAR_ENCUESTA` (IN `idEncuestaE` BIGINT(11), IN `lista_clientes` TEXT, OUT `CodigoEnvio` INT(11))  NO SQL
BEGIN 

SET @leng=length(lista_clientes); 
SET @Examinar=lista_clientes;
SET @PosicionActual=1;
SET @CODIGO=0;
SET @Envios=(SELECT COUNT(*) FROM envios);
SET @ruta=(SELECT para.raiz FROM parametros para WHERE para.id=1);
SET @archivo=(SELECT para.archivo FROM parametros para WHERE para.id=1);


 IF(@Envios=0)THEN 
 SET @CODIGO=1; 
 else 
 Set @CantEnvios=(SELECT COUNT(DISTINCT(en.codigo))  FROM envios en );
 SET @CODIGO=@CantEnvios+1;
 end if;
 
 SET @Tempo=LOCATE('-',@Examinar,@PosicionActual);

if(@Tempo=0) then 
INSERT INTO `envios`(`idEnvios`, `Codigo`, `Encuesta_idEncuesta`, `Cliente_idCliente`, `fechaEnvio`) VALUES (NULL,@CODIGO,idEncuestaE,lista_clientes,NOW());
 
SET @rutaU=(SELECT para.raiz FROM parametros para WHERE para.id=1);
SET @archivoU=(SELECT para.archivo FROM parametros para WHERE para.id=1);
SET @id_envioU=LAST_INSERT_ID();
SET @link=CONCAT(@rutaU,@archivoU,'?env=',@id_envioU,'&&cli=',lista_clientes,'&&enc=',idEncuestaE);
UPDATE `envios` SET `link`=@link WHERE `idEnvios`=@id_envioU;

 else 
 
 WHILE @PosicionActual <= @leng DO
  
    SET @Encontro=LOCATE('-',@Examinar,@PosicionActual);

    IF(@Encontro=0)then 
    
        SET @RecuperadoFin=SUBSTRING(@Examinar,@PosicionActual,(@leng+1)-@PosicionActual); 
        
         INSERT INTO `envios`(`idEnvios`, `Codigo`, `Encuesta_idEncuesta`, `Cliente_idCliente`, `fechaEnvio`) VALUES (NULL,@CODIGO,idEncuestaE,@RecuperadoFin,NOW());

         SET @id_envioFin=LAST_INSERT_ID();
         
         SET @linkFin=CONCAT(@ruta,@archivo,'?env=', @id_envioFin,'&&cli=',@RecuperadoFin,'&&enc=',idEncuestaE);
         UPDATE `envios` SET `link`=@linkFin WHERE `idEnvios`= @id_envioFin;
        
        SET @PosicionActual=@leng+1;
   
    else 
    
        SET @Recuperado=SUBSTRING(@Examinar,@PosicionActual,@Encontro-@PosicionActual); 
        
 
        INSERT INTO `envios`(`idEnvios`, `Codigo`, `Encuesta_idEncuesta`, `Cliente_idCliente`, `fechaEnvio`) VALUES (NULL,@CODIGO,idEncuestaE,@Recuperado,NOW());
        
         SET @id_envio=LAST_INSERT_ID();
         SET @link=CONCAT(@ruta,@archivo,'?env=',@id_envio,'&&cli=',@Recuperado,'&&enc=',idEncuestaE);
         UPDATE `envios` SET `link`=@link WHERE `idEnvios`=@id_envio;
        
        SET @PosicionActual=@Encontro+1;
  

    end if;

END WHILE;
 
 end if;
 

SET CodigoEnvio=@CODIGO;

END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CLIENTES_DISPONIBLES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CLIENTES_DISPONIBLES` ()  NO SQL
BEGIN 

SELECT en.RazonSocial,en.RUC,cli.idCliente,cli.NombreContacto FROM cliente cli INNER JOIN  entidad en ON en.idEntidad=cli.Entidad_idEntidad where cli.Estado_idEstado=1;

END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ENCUESTAS_DISPONIBLES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ENCUESTAS_DISPONIBLES` ()  NO SQL
BEGIN 

SELECT * FROM encuesta en WHERE en.Estado_idEstado=1;

END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ENVIOS_ACTUALES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ENVIOS_ACTUALES` ()  NO SQL
BEGIN 


SELECT 
encu.TituloEncuesta,
COUNT(env.Cliente_idCliente) TotalClientes,
(SELECT COUNT(re.Envio_idEnvio) FROM resultado re inner join envios envi on envi.idEnvios=re.Envio_idEnvio WHERE envi.idEnvios=env.idEnvios) as CantidadResultado 
FROM envios env 
INNER JOIN encuesta encu 
On encu.idEncuesta=env.Encuesta_idEncuesta GROUP BY env.Codigo;

END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ENVIOS_REALIZADOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ENVIOS_REALIZADOS` ()  NO SQL
BEGIN 

SELECT
(SELECT enc.TituloEncuesta FROM encuesta enc WHERE enc.idEncuesta=env.Encuesta_idEncuesta) as TituloEncuesta,
env.Codigo,
COUNT(env.Cliente_idCliente) as NuMClientes,
(SELECT COUNT(DISTINCT(resu.Envio_idEnvio)) FROM resultado resu INNER JOIN envios env2 ON env2.idEnvios=resu.Envio_idEnvio WHERE env2.Codigo=env.Codigo) as CantidadResultado,
DATE_FORMAT(env.fechaEnvio,"%d/%m/%Y") as FechaEnvio  
FROM envios env
GROUP BY env.Codigo;

END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_TIPO_PREGUNTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TIPO_PREGUNTA` ()  NO SQL
BEGIN

SELECT * FROM tipopregunta;
END$$

DROP PROCEDURE IF EXISTS `SP_PREGUNTA_EDITAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PREGUNTA_EDITAR` (IN `idEncuestaU` INT(11), IN `PreguntaU` TEXT, IN `TipoPreU` INT(11), IN `idPreguntaU` INT(11))  NO SQL
BEGIN 

UPDATE `pregunta` SET `DetallePregunta`=PreguntaU,`TipoPregunta_idTipoPregunta`=TipoPreU WHERE `idPregunta`=idPreguntaU and `Encuesta_idEncuesta`=idEncuestaU;

END$$

DROP PROCEDURE IF EXISTS `SP_PREGUNTA_ELIMINAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PREGUNTA_ELIMINAR` (IN `idPreguntaD` INT(11))  NO SQL
BEGIN 


DELETE FROM `pregunta` WHERE idPregunta=idPreguntaD;

END$$

DROP PROCEDURE IF EXISTS `SP_PREGUNTA_ESTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PREGUNTA_ESTADO` (IN `idPreguntU` INT(11), IN `accion` INT(11))  NO SQL
BEGIN 

IF(accion=1)THEN 

UPDATE `pregunta` SET `Estado_idEstado`=1 WHERE `idPregunta`=idPreguntU;
 
ELSE 

UPDATE `pregunta` SET `Estado_idEstado`=2 WHERE `idPregunta`=idPreguntU;

END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_PREGUNTA_LISTAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PREGUNTA_LISTAR` (IN `idEncuestaE` INT(11))  NO SQL
BEGIN

SELECT pre.idPregunta,pre.DetallePregunta,pre.PesoPregunta,tip.idTipoPregunta,tip.Detalle,pre.Estado_idEstado,e.nombreEstado FROM pregunta pre INNER JOIN tipopregunta tip ON tip.idTipoPregunta=pre.TipoPregunta_idTipoPregunta INNER JOIN estado e On e.idEstado=pre.Estado_idEstado WHERE pre.Encuesta_idEncuesta=idEncuestaE ORDER BY pre.idPregunta DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_PREGUNTA_RECUPERAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PREGUNTA_RECUPERAR` (IN `idpreguntaER` INT(11))  NO SQL
BEGIN


SELECT pre.idPregunta,pre.DetallePregunta,pre.PesoPregunta,tip.idTipoPregunta,tip.Detalle,pre.Estado_idEstado,e.nombreEstado FROM pregunta pre INNER JOIN tipopregunta tip ON tip.idTipoPregunta=pre.TipoPregunta_idTipoPregunta INNER JOIN estado e On e.idEstado=pre.Estado_idEstado WHERE pre.idPregunta=idpreguntaER;

END$$

DROP PROCEDURE IF EXISTS `SP_PREGUNTA_REGISTRO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PREGUNTA_REGISTRO` (IN `idEncuestaR` INT(11), IN `PreguntaR` TEXT, IN `idTipo` INT(11))  NO SQL
BEGIN

INSERT INTO `pregunta`(`idPregunta`, `Encuesta_idEncuesta`, `DetallePregunta`, `PesoPregunta`, `TipoPregunta_idTipoPregunta`, `Estado_idEstado`) VALUES (NULL,idEncuestaR,PreguntaR,1,idTipo,1);

END$$

DROP PROCEDURE IF EXISTS `SP_RECUPERAR_CONTACTOS_ENVIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_CONTACTOS_ENVIO` (IN `CodigoEnvio` INT(11))  NO SQL
BEGIN 


SELECT env.link,ent.RazonSocial,cli.NombreContacto,cli.CorreoContacto FROM envios env INNER JOIN cliente cli On cli.idCliente=env.Cliente_idCliente INNER JOIN entidad ent on ent.idEntidad=cli.Entidad_idEntidad WHERE env.Codigo=CodigoEnvio; 


END$$

DROP PROCEDURE IF EXISTS `SP_RECUPERAR_ENCUESTA_COMPLETA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_ENCUESTA_COMPLETA` (IN `idEncuestaR` INT(11))  NO SQL
BEGIN
DECLARE done INT DEFAULT FALSE;
DECLARE v_idPregunta BIGINT;
DECLARE v_DetPregunta text;
DECLARE v_idTipPregunta BIGINT;
DECLARE contador BIGINT;

DECLARE EncuestaNombre VARCHAR(150);
DECLARE EncuestaDetalle text;
DECLARE Preguntas text;

DECLARE CursorEncuesta CURSOR FOR 
SELECT pre.idPregunta,pre.DetallePregunta,pre.TipoPregunta_idTipoPregunta FROM pregunta pre WHERE pre.Encuesta_idEncuesta=idEncuestaR and pre.Estado_idEstado=1;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

SET Preguntas="";
SET contador=1;

open CursorEncuesta;
bucle: LOOP

FETCH CursorEncuesta into v_idPregunta,v_DetPregunta,v_idTipPregunta;
IF done THEN
LEAVE bucle;
END IF;

SET Preguntas=CONCAT(Preguntas,v_idPregunta,'|',contador,'.- ',v_DetPregunta,'|',v_idTipPregunta,'&'); 

SET contador=contador+1;
END LOOP;
CLOSE CursorEncuesta; 



SET EncuestaNombre=(SELECT en.TituloEncuesta FROM encuesta en WHERE en.idEncuesta=idEncuestaR);

SET EncuestaDetalle=(SELECT en.DetalleEncuesta FROM encuesta en WHERE en.idEncuesta=idEncuestaR);

SELECT EncuestaNombre,EncuestaDetalle,Preguntas;

END$$

DROP PROCEDURE IF EXISTS `SP_RECUPERAR_PARAMETROS_RESULTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_PARAMETROS_RESULTADO` (IN `codigo` INT(11))  NO SQL
BEGIN 

SELECT
env.Codigo,
enc.TituloEncuesta,
COUNT(env.Cliente_idCliente) as NuMClientes,
(SELECT COUNT(DISTINCT(resu.Envio_idEnvio)) FROM resultado resu INNER JOIN envios v On v.idEnvios=resu.Envio_idEnvio  WHERE v.Codigo=env.Codigo) as CantidadResultado,
DATE_FORMAT(env.fechaEnvio,"%d/%m/%Y") as FechaEnvio  
FROM envios env
INNER JOIN encuesta enc On enc.idEncuesta=env.Encuesta_idEncuesta WHERE env.Codigo=codigo;
 
END$$

DROP PROCEDURE IF EXISTS `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA1`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA1` (IN `codigo` INT(11), IN `idPregunta` INT(11))  NO SQL
BEGIN 

SELECT 
pre.DetallePregunta,
COUNT(*) as TotalRespuestas,
COUNT(IF(resu.RespuestaValor=1,resu.idResultado,NULL)) as Opcion1,
COUNT(IF(resu.RespuestaValor=2,resu.idResultado,NULL)) as Opcion2,
COUNT(IF(resu.RespuestaValor=3,resu.idResultado,NULL)) as Opcion3,
COUNT(IF(resu.RespuestaValor=4,resu.idResultado,NULL)) as Opcion4,
COUNT(IF(resu.RespuestaValor=5,resu.idResultado,NULL)) as Opcion5

FROM envios
env INNER JOIN resultado resu ON env.idEnvios=resu.Envio_idEnvio INNER JOIN pregunta pre ON pre.idPregunta=resu.Pregunta_idPregunta where env.Codigo=codigo and resu.Pregunta_idPregunta=idPregunta;



END$$

DROP PROCEDURE IF EXISTS `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA2` (IN `codigo` INT(11), IN `idPregunta` INT(11))  NO SQL
BEGIN 

SELECT 
pre.DetallePregunta,
COUNT(*) as TotalRespuestas,
COUNT(IF(resu.RespuestaValor=1,resu.idResultado,NULL)) as Opcion1,
COUNT(IF(resu.RespuestaValor=2,resu.idResultado,NULL)) as Opcion2,
COUNT(IF(resu.RespuestaValor=3,resu.idResultado,NULL)) as Opcion3

FROM envios
env INNER JOIN resultado resu ON env.idEnvios=resu.Envio_idEnvio INNER JOIN pregunta pre ON pre.idPregunta=resu.Pregunta_idPregunta where env.Codigo=codigo and resu.Pregunta_idPregunta=idPregunta;



END$$

DROP PROCEDURE IF EXISTS `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA3`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA3` (IN `codigo` INT(11), IN `idPregunta` INT(11))  NO SQL
BEGIN 

SELECT
cli.RazonSocial,
resu.RespuestaTexto
FROM envios
env INNER JOIN resultado resu ON env.idEnvios=resu.Envio_idEnvio INNER JOIN pregunta pre ON pre.idPregunta=resu.Pregunta_idPregunta inner join  cliente cli ON cli.idCliente=env.Cliente_idCliente where env.Codigo=codigo and resu.Pregunta_idPregunta=idPregunta;



END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRO_RESULTADOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRO_RESULTADOS` (IN `idEnvio` INT(11), IN `Resultados` TEXT)  NO SQL
BEGIN 
 
DECLARE Encontro INT(11);
DECLARE PreguntaRecuperada TEXT;
SET @leng=length(Resultados); 
SET @Examinar=Resultados;
SET @PosicionActual=1;

SET Encontro=0;
SET PreguntaRecuperada="";

SET @contador=1;

SET @Tempo=LOCATE('-',@Examinar,@PosicionActual);

if(@Tempo=0) then 
    
 INSERT INTO `resultado`(`idResultado`, `Envio_idEnvio`, `Pregunta_idPregunta`, `RespuestaTexto`, `RespuestaValor`, `FechaRespuesta`) VALUES (NULL,idEnvio,FN_RECU_PREGUNTA(@Examinar),FN_RECU_PRE_RESP1(@Examinar),FN_RECU_PRE_RESP2(@Examinar),NOW());

ELSE
  
 WHILE @PosicionActual < @leng DO
    SET Encontro=LOCATE('-',Resultados,@PosicionActual);     
    IF(Encontro!=0)then 
    SET PreguntaRecuperada=SUBSTRING(@Examinar,@PosicionActual,Encontro-@PosicionActual);  
      SET @pregunta=FN_RECU_PREGUNTA(PreguntaRecuperada);
      SET @r1=FN_RECU_PRE_RESP1(PreguntaRecuperada);
      SET @r2=FN_RECU_PRE_RESP2(PreguntaRecuperada);     
      SET @pregunta=@pregunta*1;
   
  INSERT INTO `resultado`(`idResultado`, `Envio_idEnvio`, `Pregunta_idPregunta`, `RespuestaTexto`, `RespuestaValor`, `FechaRespuesta`) VALUES (NULL,idEnvio,@pregunta,@r1,@r2,NOW());  
 
        SET @PosicionActual=Encontro+1;    
    else 
 
        SET PreguntaRecuperada=SUBSTRING(@Examinar,@PosicionActual,(@leng+1)-@PosicionActual); 
        
      SET @pregunta=FN_RECU_PREGUNTA(PreguntaRecuperada);
      SET @r1=FN_RECU_PRE_RESP1(PreguntaRecuperada);
      SET @r2=FN_RECU_PRE_RESP2(PreguntaRecuperada);
      
      SET @pregunta=@pregunta*1;
    
 INSERT INTO `resultado`(`idResultado`, `Envio_idEnvio`, `Pregunta_idPregunta`, `RespuestaTexto`, `RespuestaValor`, `FechaRespuesta`) VALUES (NULL,idEnvio,@pregunta,@r1,@r2,NOW()); 
 
       SET @PosicionActual=@leng;

    end if;
   
 END WHILE;
 
 end if;
 


END$$

DROP PROCEDURE IF EXISTS `SP_RESULTADO_POR_CLIENTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESULTADO_POR_CLIENTES` (IN `codigo` INT(11))  NO SQL
BEGIN

select cli.NombreContacto,ent.RazonSocial,
(SELECT COUNT(DISTINCT(resu.Envio_idEnvio)) FROM resultado resu WHERE resu.Envio_idEnvio=en.idEnvios) as ResultadoCliente, 
IFNULL((SELECT DATE_FORMAT(resu2.FechaRespuesta,"%d/%m/%Y") FROM resultado resu2 WHERE resu2.Envio_idEnvio=en.idEnvios LIMIT 1) ,"")as FechaResultado from envios en inner join cliente cli On cli.idCliente=en.Cliente_idCliente inner join entidad ent ON ent.idEntidad=cli.Entidad_idEntidad WHERE en.Codigo=codigo;


END$$

DROP PROCEDURE IF EXISTS `SP_RESULTADO_POR_PREGUNTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESULTADO_POR_PREGUNTA` (IN `codigo` INT(11))  NO SQL
BEGIN 

SELECT 
pre.DetallePregunta,
tip.Detalle,
pre.idPregunta as idPregunta,
pre.TipoPregunta_idTipoPregunta as CodigoPregunta,
(SELECT AVG(resu.RespuestaValor) FROM resultado resu WHERE resu.Pregunta_idPregunta=pre.idPregunta) as CantidadPregunta 
FROM encuesta enc 
INNER JOIN envios env ON enc.idEncuesta=env.Encuesta_idEncuesta
INNER JOIN pregunta pre ON enc.idEncuesta=pre.Encuesta_idEncuesta
INNER JOIN tipopregunta tip ON pre.TipoPregunta_idTipoPregunta=tip.idTipoPregunta WHERE env.Codigo=codigo GROUP BY pre.idPregunta;

END$$

DROP PROCEDURE IF EXISTS `SP_USUARIO_EDITAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_USUARIO_EDITAR` (IN `nombreUsuarioU` VARCHAR(150), IN `usuarioU` VARCHAR(50), IN `PassU` TEXT, IN `idUsuarioU` INT(11))  NO SQL
BEGIN 

if(PassU='-1')then 

UPDATE `usuario` SET `NombreUsuario`=nombreUsuarioU,`usuario`=usuarioU  WHERE `idUsuario`=idUsuarioU;

else 

UPDATE `usuario` SET `NombreUsuario`=nombreUsuarioU,`usuario`=usuarioU,`password`=PassU  WHERE `idUsuario`=idUsuarioU;

end if;

END$$

DROP PROCEDURE IF EXISTS `SP_USUARIO_ELIMINAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_USUARIO_ELIMINAR` (IN `idUsuarioD` INT(11))  NO SQL
BEGIN

DELETE FROM `usuario` WHERE `idUsuario`=idUsuarioD;

END$$

DROP PROCEDURE IF EXISTS `SP_USUARIO_ESTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_USUARIO_ESTADO` (IN `idUsuarioU` INT(11), IN `accion` INT(11))  NO SQL
BEGIN 

IF(accion=1)THEN 

UPDATE `usuario` SET `Estado_idEstado`=1 WHERE `idUsuario`=idUsuarioU;
 
ELSE 

UPDATE `usuario` SET `Estado_idEstado`=2 WHERE `idUsuario`=idUsuarioU;

END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_USUARIO_LISTAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_USUARIO_LISTAR` ()  NO SQL
BEGIN 

SELECT u.idUsuario,u.NombreUsuario,u.usuario,u.Estado_idEstado,DATE_FORMAT(u.fechaRegistro,"%d/%m/%Y") as fechaRegistro,e.nombreEstado,e.idEstado FROM usuario u INNER JOIN estado e ON e.idEstado=u.Estado_idEstado ORDER BY u.idUsuario DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_USUARIO_RECUPERAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_USUARIO_RECUPERAR` (IN `idUsuarioR` INT(11))  NO SQL
BEGIN 

SELECT u.idUsuario,u.NombreUsuario,u.usuario,u.Estado_idEstado,u.fechaRegistro FROM usuario u WHERE u.idUsuario=idUsuarioR;
END$$

DROP PROCEDURE IF EXISTS `SP_USUARIO_REGISTRO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_USUARIO_REGISTRO` (IN `NombreUsuarioR` VARCHAR(150), IN `UsuarioR` VARCHAR(50), IN `PassR` TEXT, IN `estado` INT(11))  NO SQL
BEGIN 
 
INSERT INTO `usuario`(`idUsuario`, `NombreUsuario`, `usuario`, `password`, `Estado_idEstado`, `fechaRegistro`) VALUES (NULL,UPPER(NombreUsuarioR),UsuarioR,PassR,estado,NOW());

END$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `FN_RECU_PREGUNTA`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `FN_RECU_PREGUNTA` (`Cadena` TEXT) RETURNS TEXT CHARSET latin1 NO SQL
BEGIN 


 SET @Encontro=LOCATE('|',Cadena,1);
 
 SET @Recuperado=SUBSTRING(Cadena,1,@Encontro-1); 

 RETURN  @Recuperado;
 
END$$

DROP FUNCTION IF EXISTS `FN_RECU_PRE_RESP1`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `FN_RECU_PRE_RESP1` (`Cadena` TEXT) RETURNS TEXT CHARSET latin1 NO SQL
BEGIN 

 SET @Inicio=1;
 
 SET @Encontro=LOCATE('|',Cadena,@Inicio);
 
 SET @Inicio=@Encontro+1;
 
 SET @Encontro=LOCATE('|',Cadena,@Inicio);
 
 SET @Recuperado=SUBSTRING(Cadena,@Inicio,@Encontro-@Inicio); 


 RETURN  @Recuperado;
 
END$$

DROP FUNCTION IF EXISTS `FN_RECU_PRE_RESP2`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `FN_RECU_PRE_RESP2` (`Cadena` TEXT) RETURNS INT(11) NO SQL
BEGIN 

 SET @Inicio=1;
 
 SET @Encontro=LOCATE('|',Cadena,@Inicio);
 
 SET @Inicio=@Encontro+1;
 
 SET @Encontro=LOCATE('|',Cadena,@Inicio);
 
 SET @Inicio=@Encontro+1;
  
 SET @Recuperado=SUBSTRING(Cadena,@Inicio,length(Cadena)+1); 


 RETURN  @Recuperado;
 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `NombreContacto` varchar(150) NOT NULL,
  `CorreoContacto` varchar(150) NOT NULL,
  `Cargo` varchar(150) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `Entidad_idEntidad` int(11) NOT NULL,
  `Estado_idEstado` int(11) NOT NULL,
  PRIMARY KEY (`idCliente`),
  KEY `FK_CLIENTE_ESTADO` (`Estado_idEstado`),
  KEY `FK_Entidad_Cliente` (`Entidad_idEntidad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `NombreContacto`, `CorreoContacto`, `Cargo`, `fechaRegistro`, `Entidad_idEntidad`, `Estado_idEstado`) VALUES
(1, 'JESUS INCA CARDENAS', 'jesus.inca@qsystem.com.pe', 'ANALISTA', '2018-12-18 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
CREATE TABLE IF NOT EXISTS `encuesta` (
  `idEncuesta` int(11) NOT NULL AUTO_INCREMENT,
  `TituloEncuesta` varchar(150) NOT NULL,
  `DetalleEncuesta` text NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `Estado_idEstado` int(11) NOT NULL,
  PRIMARY KEY (`idEncuesta`),
  KEY `FK_ENCUESTA_ESTADO` (`Estado_idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`idEncuesta`, `TituloEncuesta`, `DetalleEncuesta`, `fechaRegistro`, `Estado_idEstado`) VALUES
(1, 'ENCUESTA DE SATISFACCIÓN DEL SERVICIO QSYSTEM SAC', 'EJEMPLO DE ENCUESTA Nº 1', '2018-12-18 00:00:00', 1),
(3, 'ENCUESTA DE CONDICIÓN  QSYSTEM SAC', 'ENCUESTA  DE PRUEBA Nº 2', '2018-12-18 17:59:39', 1),
(4, 'ENCUESTA DESCRIPTIVA QSYSTEM SAC', 'ENCUESTA DE PRUEBA Nº 3', '2018-12-19 09:40:19', 1),
(5, 'ENCUESTA MIXTA EJEMPLO', 'ENCUESTA DE PRUEBA Nº 4', '2018-12-19 09:48:11', 1),
(6, 'ENCUESTA PRUEBA 5', 'DETALLE ENCUESTA', '2018-12-19 15:13:49', 1),
(7, 'Encuesta de Satisfacción al Cliente', 'Encuesta realizada para medir la satisfacción del desempeño de los clientes.', '2019-01-07 14:26:31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

DROP TABLE IF EXISTS `entidad`;
CREATE TABLE IF NOT EXISTS `entidad` (
  `idEntidad` int(11) NOT NULL AUTO_INCREMENT,
  `RazonSocial` text NOT NULL,
  `RUC` char(11) NOT NULL,
  `Direccion` text NOT NULL,
  `Estado_idEstado` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  PRIMARY KEY (`idEntidad`),
  KEY `FK_Estado_Entidad` (`Estado_idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`idEntidad`, `RazonSocial`, `RUC`, `Direccion`, `Estado_idEstado`, `fechaRegistro`) VALUES
(1, 'Q SYSTEM SAC', '20508843411', 'Cal. los Ruiseñores Nro. 198', 1, '2018-12-18 00:00:00'),
(4, 'SAGA FALLABELLA SAC', '1212121212', 'SEFQWEFQWFQWFW', 1, '2019-01-14 12:41:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

DROP TABLE IF EXISTS `envios`;
CREATE TABLE IF NOT EXISTS `envios` (
  `idEnvios` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` int(11) NOT NULL,
  `Encuesta_idEncuesta` int(11) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL,
  `link` text,
  `fechaEnvio` datetime NOT NULL,
  PRIMARY KEY (`idEnvios`),
  KEY `FK_CLIENTE` (`Cliente_idCliente`),
  KEY `FK_ENCUESTAS_ENVIO` (`Encuesta_idEncuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `envios`
--

INSERT INTO `envios` (`idEnvios`, `Codigo`, `Encuesta_idEncuesta`, `Cliente_idCliente`, `link`, `fechaEnvio`) VALUES
(1, 1, 1, 1, 'http://localhost/SistemaEncuesta/index.php?env=1&&cli=1&&enc=1', '2019-01-14 14:13:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `nombreEstado` varchar(50) NOT NULL,
  `TipoEstado` int(11) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idEstado`, `nombreEstado`, `TipoEstado`) VALUES
(1, 'HABILITADO', 1),
(2, 'INABILITADO', 1),
(3, 'NUEVO', 2),
(4, 'ENVIADO', 2),
(5, 'ANULADO', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

DROP TABLE IF EXISTS `parametros`;
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raiz` text NOT NULL,
  `archivo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`id`, `raiz`, `archivo`) VALUES
(1, 'http://localhost/SistemaEncuesta/', 'index.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
CREATE TABLE IF NOT EXISTS `pregunta` (
  `idPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `Encuesta_idEncuesta` int(11) NOT NULL,
  `DetallePregunta` text NOT NULL,
  `PesoPregunta` int(11) NOT NULL,
  `TipoPregunta_idTipoPregunta` int(11) NOT NULL,
  `Estado_idEstado` int(11) NOT NULL,
  PRIMARY KEY (`idPregunta`),
  KEY `FK_TIPOPREGUNTA_PREGUNTA` (`TipoPregunta_idTipoPregunta`),
  KEY `FK_EstadoPregunta` (`Estado_idEstado`),
  KEY `FK_Encuesta_Pregunta` (`Encuesta_idEncuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idPregunta`, `Encuesta_idEncuesta`, `DetallePregunta`, `PesoPregunta`, `TipoPregunta_idTipoPregunta`, `Estado_idEstado`) VALUES
(9, 1, 'Pregunta de Ejemplo nº 1', 1, 1, 1),
(10, 1, 'Pregunta de Ejemplo nº 2', 1, 1, 1),
(11, 1, 'Pregunta de Ejemplo nº 3', 1, 1, 1),
(12, 1, 'Pregunta de Ejemplo nº 4', 1, 1, 1),
(13, 1, 'Pregunta de Ejemplo nº 5', 1, 1, 1),
(14, 3, 'Pregunta Condición Nº 1', 1, 2, 1),
(15, 3, 'Pregunta Condición Nº 2', 1, 2, 1),
(16, 3, 'Pregunta Condición Nº 3', 1, 2, 1),
(17, 3, 'Pregunta Condición Nº 4', 1, 2, 1),
(18, 3, 'Pregunta Condición Nº 5', 1, 2, 1),
(19, 4, 'Pregunta Descriptiva Nº 1', 1, 3, 1),
(20, 4, 'Pregunta Descriptiva Nº 2', 1, 3, 1),
(21, 4, 'Pregunta Descriptiva Nº 3', 1, 3, 1),
(22, 4, 'Pregunta Descriptiva Nº 4', 1, 3, 1),
(23, 4, 'Pregunta Descriptiva Nº 5', 1, 3, 1),
(24, 5, 'Pregunta Mixta Nº 1', 1, 1, 1),
(25, 5, 'Pregunta Mixta Nº 2', 1, 2, 1),
(26, 5, 'Pregunta Mixta Nº 3', 1, 3, 1),
(27, 5, 'Pregunta Mixta Nº 4', 1, 1, 1),
(28, 5, 'Pregunta Mixta Nº 5', 1, 2, 1),
(29, 5, 'Pregunta Mixta Nº 6', 1, 3, 1),
(30, 6, 'PREGUNTA PRUEBA 1', 1, 1, 1),
(31, 6, 'PREGUNTA PRUEBA 2', 1, 2, 1),
(32, 6, 'PREGUNTA PRUEBA 3', 1, 3, 1),
(33, 7, '¿Qué opina de la proactividad del Colaborador?', 1, 4, 1),
(34, 7, '¿Considera que el desempeño del  Colaborador es?', 1, 4, 1),
(35, 7, '¿Qué opina de la capacidad de trabajo en equipo y/o bajo presion del colaborador?', 1, 4, 1),
(36, 7, '¿Qué opina del Cumplimiento de procesos dentro del rol del Colaborador?', 1, 4, 1),
(37, 7, '¿Qué opina sobre las habilidades blandas del Colaborador?', 1, 4, 1),
(38, 7, '¿Qué opina de la Calidad de los Entregables elaborados por los Colaboradores?', 1, 4, 1),
(39, 7, '¿Qué opina del grado de responsabilidad del Analista?', 1, 4, 1),
(40, 7, '¿Cómo define la efectividad del servicio?', 1, 4, 1),
(41, 7, '¿Qué percepción tiene usted en cuanto a la comunicación?', 1, 4, 1),
(42, 7, '¿Cómo define la atención de nuestros servicios?', 1, 4, 1),
(43, 7, 'Sugerencias o Comentarios:', 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado`
--

DROP TABLE IF EXISTS `resultado`;
CREATE TABLE IF NOT EXISTS `resultado` (
  `idResultado` int(11) NOT NULL AUTO_INCREMENT,
  `Envio_idEnvio` int(11) NOT NULL,
  `Pregunta_idPregunta` int(11) NOT NULL,
  `RespuestaTexto` text NOT NULL,
  `RespuestaValor` int(11) NOT NULL,
  `FechaRespuesta` datetime NOT NULL,
  PRIMARY KEY (`idResultado`),
  KEY `FK_ResultadoEnvio` (`Envio_idEnvio`),
  KEY `FK_PREGUNTA_RESULTADO` (`Pregunta_idPregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopregunta`
--

DROP TABLE IF EXISTS `tipopregunta`;
CREATE TABLE IF NOT EXISTS `tipopregunta` (
  `idTipoPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `Detalle` varchar(150) NOT NULL,
  PRIMARY KEY (`idTipoPregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipopregunta`
--

INSERT INTO `tipopregunta` (`idTipoPregunta`, `Detalle`) VALUES
(1, 'Pregunta de Satisfacción (1 al 5)'),
(2, 'Pregunta de Condición (SI - NO - NO SABE )'),
(3, 'Pregunta Descriptiva (Respuesta Con Texto)'),
(4, 'Pregunta de Satisfacción (Malo-Regular-Bueno-MuyBueno)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `NombreUsuario` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `Estado_idEstado` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `FK_USUARIO_ESTADO` (`Estado_idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `NombreUsuario`, `usuario`, `password`, `Estado_idEstado`, `fechaRegistro`) VALUES
(1, 'Adminstrador General', 'admin', '$2a$08$Vo4zFrwFG.k2ZHhln/fQVu5NoeJdzJUSG6HOVA6fBCknS/umS0bki', 1, '2018-12-18 00:00:00'),
(3, 'JESUS INCA CARDENAS', 'jincac', '$2a$08$qJ14V2XYR5zhgq3icRSE0uzVAlOBbSWH3sg1Xq3SO7YwtqgfNwTNG', 1, '2018-12-18 16:17:11');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_CLIENTE_ESTADO` FOREIGN KEY (`Estado_idEstado`) REFERENCES `estado` (`idEstado`),
  ADD CONSTRAINT `FK_Entidad_Cliente` FOREIGN KEY (`Entidad_idEntidad`) REFERENCES `entidad` (`idEntidad`);

--
-- Filtros para la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD CONSTRAINT `FK_ENCUESTA_ESTADO` FOREIGN KEY (`Estado_idEstado`) REFERENCES `estado` (`idEstado`);

--
-- Filtros para la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD CONSTRAINT `FK_Estado_Entidad` FOREIGN KEY (`Estado_idEstado`) REFERENCES `estado` (`idEstado`);

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `FK_CLIENTE` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `FK_ENCUESTAS_ENVIO` FOREIGN KEY (`Encuesta_idEncuesta`) REFERENCES `encuesta` (`idEncuesta`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_Encuesta_Pregunta` FOREIGN KEY (`Encuesta_idEncuesta`) REFERENCES `encuesta` (`idEncuesta`),
  ADD CONSTRAINT `FK_EstadoPregunta` FOREIGN KEY (`Estado_idEstado`) REFERENCES `estado` (`idEstado`),
  ADD CONSTRAINT `FK_TIPOPREGUNTA_PREGUNTA` FOREIGN KEY (`TipoPregunta_idTipoPregunta`) REFERENCES `tipopregunta` (`idTipoPregunta`);

--
-- Filtros para la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD CONSTRAINT `FK_PREGUNTA_RESULTADO` FOREIGN KEY (`Pregunta_idPregunta`) REFERENCES `pregunta` (`idPregunta`),
  ADD CONSTRAINT `FK_ResultadoEnvio` FOREIGN KEY (`Envio_idEnvio`) REFERENCES `envios` (`idEnvios`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_USUARIO_ESTADO` FOREIGN KEY (`Estado_idEstado`) REFERENCES `estado` (`idEstado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
