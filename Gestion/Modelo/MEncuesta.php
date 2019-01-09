<?php
   require_once '../../config/config.php';
   class MEncuesta{

      public function __construct(){
      }

	  public function Listar_Encuesta(){
           $sql="CALL `SP_ENCUESTA_LISTAR`();";
           return ejecutarConsulta($sql);
       }
      public function Eliminar_Encuesta($idEncuesta){
           $sql="CALL `SP_ENCUESTA_ELIMINAR`('$idEncuesta')";
           return ejecutarConsulta($sql);
       }

        public function Estado_Encuesta($idEncuesta,$accion){
           $sql="CALL `SP_ENCUESTA_ESTADO`('$idEncuesta','$accion');";
           return ejecutarConsulta($sql);
       }
      public function ValidarEncuesta($EncuestaTitulo,$idEncuesta){
          $sql="";
          if($idEncuesta=='' || $idEncuesta==null || empty($idEncuesta)){
			   $sql="SELECT * FROM encuesta WHERE TituloEncuesta='$EncuestaTitulo';";
          }else{
             $sql="SELECT * FROM encuesta WHERE idEncuesta!='$idEncuesta' and TituloEncuesta='$EncuestaTitulo';";
          }
          return validarDatos($sql);
      }
      public function RegistroEncuesta($idEncuesta,$EncuestaTitulo,$EncuestaDetalle){
        $sql="";

        if($idEncuesta=="" || $idEncuesta==null || empty($idEncuesta)){

             $sql="CALL `SP_ENCUESTA_REGISTRO`('$EncuestaTitulo','$EncuestaDetalle');";

        }else{

             $sql="CALL `SP_ENCUESTA_EDITAR`('$EncuestaTitulo','$EncuestaDetalle','$idEncuesta');";
        }
         return ejecutarConsulta($sql);
      }

		public function Recuperar_Encuesta($idEncuesta){
			$sql="CALL `SP_ENCUESTA_RECUPERAR`('$idEncuesta');";
			return ejecutarConsultaSimpleFila($sql);
		}
       public function RecuperarEncuestaCompleta($idEncuesta){
			$sql="CALL `SP_RECUPERAR_ENCUESTA_COMPLETA`('$idEncuesta');";
			return ejecutarConsultaSimpleFila($sql);
		}

       public function ListarEncuestasDisponibles(){
            $sql="CALL `SP_LISTAR_ENCUESTAS_DISPONIBLES`();";
           return ejecutarConsulta($sql);
       }

       public function ListarClientesDisponibles(){
            $sql="CALL `SP_LISTAR_CLIENTES_DISPONIBLES`();";
           return ejecutarConsulta($sql);
       }

       public function Enviar_Encuesta($idEncuesta,$cadena){
           $sql1=ejecutarConsulta("CALL `SP_ENVIAR_ENCUESTA`('$idEncuesta','$cadena',@p2);");
           $sql="SELECT @p2 AS `CodigoEnvio`;";
           return ejecutarConsultaSimpleFila($sql);
       }

        public function Recuperar_Informacion_Para_Envio($codigoEnvio){
            $sql="CALL `SP_RECUPERAR_CONTACTOS_ENVIO`('$codigoEnvio');";
           return ejecutarConsulta($sql);
       }

       public function ListarEnviosRealizados(){
           $sql="CALL `SP_LISTAR_ENVIOS_REALIZADOS`();";
           return ejecutarConsulta($sql);
       }
       public function RecuperarGraficoResultado($codigoEnvio){
          $sql="CALL `SP_RECUPERAR_PARAMETROS_RESULTADO`('$codigoEnvio');";
			return ejecutarConsultaSimpleFila($sql);
       }

       public function RecuperarGraficoResultadoPregunta1($codigoEnvio,$idPregunta){
          $sql="CALL `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA1`('$codigoEnvio','$idPregunta');";
			return ejecutarConsultaSimpleFila($sql);
       }
        public function RecuperarGraficoResultadoPregunta2($codigoEnvio,$idPregunta){
          $sql="CALL `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA2`('$codigoEnvio','$idPregunta');";
			return ejecutarConsultaSimpleFila($sql);
       }

        public function RecuperarGraficoResultadoPregunta3($codigoEnvio,$idPregunta){
          $sql="CALL `SP_RECUPERAR_PARAMETROS_RESULTADO_PREGUNTA3`('$codigoEnvio','$idPregunta');";
			return ejecutarConsulta($sql);
       }

       public function ListarResultadosCliente($codigoEnvio){
            $sql="CALL `SP_RESULTADO_POR_CLIENTES`('$codigoEnvio');";
           return ejecutarConsulta($sql);
       }

       public function ListarResultadosPregunta($codigoEnvio){
           $sql="CALL `SP_RESULTADO_POR_PREGUNTA`('$codigoEnvio');";
           return ejecutarConsulta($sql);
       }

       public function RegistrarResultados($codigoEnvio,$ArregloRespuesta){
           $sql="CALL `SP_REGISTRO_RESULTADOS`('$codigoEnvio','$ArregloRespuesta');";
           return ejecutarConsulta($sql);
       }

   }

?>
