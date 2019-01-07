<?php
   require_once '../../config/config.php';


   class MCliente{

      public function __construct(){
      }

	  public function Listar_Cliente(){
           $sql="CALL `SP_CLIENTE_LISTAR`();";
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
      public function ValidarCliente($ClienteRUC,$idCliente){
          $sql="";
          if($idCliente=='' || $idCliente==null || empty($idCliente)){
			   $sql="SELECT * FROM cliente WHERE RUC='$ClienteRUC';";
          }else{
             $sql="SELECT * FROM cliente WHERE idCliente!='$idCliente' and RUC='$ClienteRUC';";
          }
          return validarDatos($sql);
      }
      public function RegistroCliente($idCliente,$ClienteRazonSocial,$ClienteRUC,$ClienteContacto,$ClienteCorreo,$ClienteDireccion){
        $sql="";

        if($idCliente=="" || $idCliente==null || empty($idCliente)){
             $sql="CALL `SP_CLIENTE_REGISTRO`('$ClienteRazonSocial','$ClienteRUC','$ClienteContacto','$ClienteCorreo','$ClienteDireccion');";

        }else{

             $sql="CALL `SP_CLIENTE_EDITAR`('$ClienteRazonSocial','$ClienteRUC','$ClienteContacto','$ClienteCorreo','$ClienteDireccion','$idCliente');";
        }
         return ejecutarConsulta($sql);
      }

		public function Recuperar_Cliente($idCliente){
			$sql="CALL `SP_CLIENTE_RECUPERAR`('$idCliente');";
			return ejecutarConsultaSimpleFila($sql);
		}


   }

?>
