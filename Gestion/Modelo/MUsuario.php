<?php
   require_once '../../config/config.php';


   class MUsuario{

      public function __construct(){
      }

	  public function Listar_Usuario(){
           $sql="CALL `SP_USUARIO_LISTAR`();";
           return ejecutarConsulta($sql);
       }
      public function Eliminar_Usuario($idUsuario){
           $sql="CALL `SP_USUARIO_ELIMINAR`('$idUsuario')";
           return ejecutarConsulta($sql);
       }

        public function Estado_Usuario($idUsuario,$accion){
           $sql="CALL `SP_USUARIO_ESTADO`('$idUsuario','$accion');";
           return ejecutarConsulta($sql);
       }
      public function ValidarUsuario($UsuarioU,$idUsuario){
          $sql="";
          if($idUsuario=='' || $idUsuario==null || empty($idUsuario)){
			   $sql="SELECT * FROM usuario WHERE usuario='$UsuarioU';";
          }else{
             $sql="SELECT * FROM usuario WHERE idUsuario!='$idUsuario' and usuario='$UsuarioU';";
          }
          return validarDatos($sql);
      }
      public function RegistroUsuario($idUsuario,$UsuarioNombre,$UsuarioUsuario,$UsuarioPass){
        $sql="";

        if($idUsuario=="" || $idUsuario==null || empty($idUsuario)){
             $sql="CALL `SP_USUARIO_REGISTRO`('$UsuarioNombre','$UsuarioUsuario','$UsuarioPass','1');";

        }else{

             $sql="CALL `SP_USUARIO_EDITAR`('$UsuarioNombre','$UsuarioUsuario','$UsuarioPass','$idUsuario');";
        }

         return ejecutarConsulta($sql);
      }

		public function Recuperar_Usuario($idUsuario){
			$sql="CALL `SP_USUARIO_RECUPERAR`('$idUsuario');";
			return ejecutarConsultaSimpleFila($sql);
		}


   }

?>
