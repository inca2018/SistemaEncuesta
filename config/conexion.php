<?php

class Conexion {
   public function ruta(){
      return "http://localhost/SistemaEncuesta/";
   }
   public function rutaOP(){
      return "http://localhost/SistemaEncuesta/Gestion/";
   }
   public function convertir($string){
	   $cant=strlen($string);
		if($cant>1){
			   switch ($string){
					case '10':
						 $string='OCTUBRE';
					 	break;
					case '11':
						 $string='NOVIEMBRE';
					 	break;
					case '12':
						 $string='DICIEMBRE';
					 	break;
				}
		}else{
			  $string = str_replace(
				array('1', '2', '3', '4', '5', '6', '7', '8', '9'),
				array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE'),
				$string
				);
		}

   return $string;
   }


   public function upload_documento($tipo,$dni,$nombre) {
      // ubicar el de recurso
      $linkDocumento='../../vista/FotosAlumno/';
      if(!file_exists($linkDocumento)){
         mkdir("$linkDocumento",0777);
      }
      $linkRecurso='../../vista/FotosAlumno/'.$dni."/";
      if(!file_exists($linkRecurso)){
         mkdir("$linkRecurso",0777);
      }
       if($tipo==2){
           //editar

           $linkRecurso2='../../vista/FotosAlumno/'.$dni.'/'.$nombre.'.jpg';
            if(file_exists($linkRecurso2)){
                 unlink($linkRecurso2);
              }
               if(isset($_FILES["adjuntar_documento"])){

                 $extension = explode('.', $_FILES['adjuntar_documento']['name']);
                 $destination ='../../vista/FotosAlumno/'.$dni.'/'.$nombre.'.jpg';
                 $subida = move_uploaded_file($_FILES['adjuntar_documento']['tmp_name'], $destination);
                 return $subida;

            }


       }else{
           //registrar
            if(isset($_FILES["adjuntar_documento"])){

                 $extension = explode('.', $_FILES['adjuntar_documento']['name']);
                 $destination ='../../vista/FotosAlumno/'.$dni.'/'.$nombre.'.jpg';
                 $subida = move_uploaded_file($_FILES['adjuntar_documento']['tmp_name'], $destination);
                 return $subida;
              }
       }

   }


}


?>
