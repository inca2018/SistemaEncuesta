<?php
   require_once '../../config/config.php';


   class MCliente{

      public function __construct(){
      }

	  public function Listar_Cliente($idEntidad){
           $sql="CALL `SP_CLIENTE_LISTAR`('$idEntidad');";
           return ejecutarConsulta($sql);
       }
      public function Eliminar_Cliente($idCliente){
           $sql="CALL `SP_CLIENTE_ELIMINAR`('$idCliente')";
           return ejecutarConsulta($sql);
       }

        public function Estado_Cliente($idCliente,$accion){
           $sql="CALL `SP_CLIENTE_ESTADO`('$idCliente','$accion');";
           return ejecutarConsulta($sql);
       }
      public function ValidarCliente($ClienteContacto,$idEntidad,$idCliente){
          $sql="";
          if($idCliente=='' || $idCliente==null || empty($idCliente)){
			   $sql="SELECT * FROM cliente WHERE Entidad_idEntidad='$idEntidad' and NombreContacto='$ClienteContacto';";
          }else{
             $sql="SELECT * FROM cliente WHERE Entidad_idEntidad='$idEntidad' and idCliente!='$idCliente' and NombreContacto='$ClienteContacto';";
          }
          return validarDatos($sql);
      }
      public function RegistroCliente($idCliente,$ClienteContacto,$ClienteCorreo,$ClienteCargo,$idEntidad){
        $sql="";

        if($idCliente=="" || $idCliente==null || empty($idCliente)){
             $sql="CALL `SP_CLIENTE_REGISTRO`('$ClienteContacto','$ClienteCorreo','$ClienteCargo','$idEntidad');";

        }else{

             $sql="CALL `SP_CLIENTE_EDITAR`('$ClienteContacto','$ClienteCorreo','$ClienteCargo','$idEntidad','$idCliente');";
        }

         return ejecutarConsulta($sql);
      }

		public function Recuperar_Cliente($idCliente){
			$sql="CALL `SP_CLIENTE_RECUPERAR`('$idCliente');";
			return ejecutarConsultaSimpleFila($sql);
		}
      public function RecuperarEntidadDatos($idEntidad){
			$sql="CALL `SP_ENTIDAD_RECUPERAR`('$idEntidad');";
			return ejecutarConsultaSimpleFila($sql);
		}


   }

?>
