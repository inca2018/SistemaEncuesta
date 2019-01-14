<?php
   require_once '../../config/config.php';


   class MEntidad{

      public function __construct(){
      }

	  public function Listar_Entidad(){
           $sql="CALL `SP_ENTIDAD_LISTAR`();";
           return ejecutarConsulta($sql);
       }
      public function Eliminar_Entidad($idEntidad){
           $sql="CALL `SP_ENTIDAD_ELIMINAR`('$idEntidad')";
           return ejecutarConsulta($sql);
       }

        public function Estado_Entidad($idEntidad,$accion){
           $sql="CALL `SP_ENTIDAD_ESTADO`('$idEntidad','$accion');";
           return ejecutarConsulta($sql);
       }
      public function ValidarEntidad($EntidadRUC,$idEntidad){
          $sql="";
          if($idEntidad=='' || $idEntidad==null || empty($idEntidad)){
			   $sql="SELECT * FROM entidad WHERE RUC='$EntidadRUC';";
          }else{
             $sql="SELECT * FROM entidad WHERE idEntidad!='$idEntidad' and RUC='$EntidadRUC';";
          }
          return validarDatos($sql);
      }
      public function RegistroEntidad($idEntidad,$EntidadRazonSocial,$EntidadRUC,$EntidadDireccion){
        $sql="";

        if($idEntidad=="" || $idEntidad==null || empty($idEntidad)){
             $sql="CALL `SP_ENTIDAD_REGISTRO`('$EntidadRazonSocial','$EntidadRUC','$EntidadDireccion');";

        }else{

             $sql="CALL `SP_ENTIDAD_EDITAR`('$EntidadRazonSocial','$EntidadRUC','$EntidadDireccion','$idEntidad');";
        }
         return ejecutarConsulta($sql);
      }
		public function Recuperar_Entidad($idEntidad){
			$sql="CALL `SP_ENTIDAD_RECUPERAR`('$idEntidad');";
			return ejecutarConsultaSimpleFila($sql);
		}


   }

?>
