<?php
   require_once '../../config/config.php';


   class MPregunta{

      public function __construct(){
      }

     public function ListarTipoPregunta(){
         $sql="CALL `SP_LISTAR_TIPO_PREGUNTA`();";
          return ejecutarConsulta($sql);
     }
	  public function Listar_Pregunta($idEncuesta){
           $sql="CALL `SP_PREGUNTA_LISTAR`($idEncuesta);";
           return ejecutarConsulta($sql);
       }
      public function Eliminar_Pregunta($idPregunta){
           $sql="CALL `SP_PREGUNTA_ELIMINAR`('$idPregunta')";
           return ejecutarConsulta($sql);
       }

        public function Estado_Pregunta($idPregunta,$accion){
           $sql="CALL `SP_PREGUNTA_ESTADO`('$idPregunta','$accion');";
           return ejecutarConsulta($sql);
       }
      public function ValidarPregunta($PreguntaTitulo,$idPregunta){
          $sql="";
          if($idPregunta=='' || $idPregunta==null || empty($idPregunta)){
			   $sql="SELECT * FROM pregunta WHERE DetallePregunta='$PreguntaTitulo';";
          }else{
             $sql="SELECT * FROM pregunta WHERE idPregunta!='$idPregunta' and DetallePregunta='$PreguntaTitulo';";
          }
          return validarDatos($sql);
      }
      public function RegistroPregunta($idEncuesta,$idPregunta,$PreguntaTitulo,$PreguntaTipo){
        $sql="";

        if($idPregunta=="" || $idPregunta==null || empty($idPregunta)){

             $sql="CALL `SP_PREGUNTA_REGISTRO`('$idEncuesta','$PreguntaTitulo','$PreguntaTipo');";

        }else{

             $sql="CALL `SP_PREGUNTA_EDITAR`('$idEncuesta','$PreguntaTitulo','$PreguntaTipo','$idPregunta');";
        }
         return ejecutarConsulta($sql);
      }

		public function Recuperar_Pregunta($idPregunta){
			$sql="CALL `SP_PREGUNTA_RECUPERAR`('$idPregunta');";
			return ejecutarConsultaSimpleFila($sql);
		}
      public function RecuperarDatosEncuesta($idEncuesta){
        $sql="CALL `SP_ENCUESTA_RECUPERAR`('$idEncuesta');";
			return ejecutarConsultaSimpleFila($sql);
      }


   }

?>
