<?php
require_once "conexion.php";

class Login{
   //Implementamos nuestro constructor
   public function __construct()
   {

   }
   public function password($usuario){
     $sql="Select password from usuario where usuario='$usuario'";
     return ejecutarConsultaSimpleFila($sql);
   }
   public function idusu($usuario){
     $sql="Select idUsuario  from usuario where usuario='$usuario'";
     return ejecutarConsultaSimpleFila($sql);
   }
   public function datosUsuario($usuario){
     $sql="select u.idUsuario,u.NombreUsuario,u.usuario FROM usuario u WHERE u.idUsuario='$usuario';";
     return ejecutarConsulta($sql);
   }
   public function validaUsuario($valor){
     $sql="SELECT * FROM usuario where usuario='$valor'";
     return validarDatos($sql);
   }

  public function VerificarEncuesta($Envio){
       $sql="SELECT COUNT(*) as Encontrado FROM resultado where Envio_idEnvio=".$Envio;;
       return ejecutarConsultaSimpleFila($sql);
   }
}
?>
