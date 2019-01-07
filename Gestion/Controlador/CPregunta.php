<?php
   session_start();
   require_once "../Modelo/MPregunta.php";

   $mantenimiento = new MPregunta();

   $idEncuesta=isset($_POST["idEncuesta"])?limpiarCadena($_POST["idEncuesta"]):"";
	$idPregunta=isset($_POST["idPregunta"])?limpiarCadena($_POST["idPregunta"]):"";
	$PreguntaTitulo=isset($_POST["PreguntaTitulo"])?limpiarCadena($_POST["PreguntaTitulo"]):"";
	$PreguntaTipo=isset($_POST["TipoPregunta"])?limpiarCadena($_POST["TipoPregunta"]):"";

	//$login_idLog=$_SESSION['idUsuario'];

    function BuscarEstado($reg){
        if($reg->Estado_idEstado=='1' || $reg->Estado_idEstado==1 ){
            return '<div class="badge badge-success">'.$reg->nombreEstado.'</div>';
        }elseif($reg->Estado_idEstado=='2' || $reg->Estado_idEstado==2){
            return '<div class="badge badge-danger">'.$reg->nombreEstado.'</div>';
        }else{
             return '<div class="badge badge-primary">'.$reg->nombreEstado.'</div>';
        }
    }
    function BuscarAccion($reg){
        if($reg->Estado_idEstado==1){
            return '
            <button type="button" title="Editar" class="btn btn-warning btn-sm" onclick="EditarPregunta('.$reg->idPregunta.')"><i class="fa fa-edit"></i></button>

            <button type="button"  title="Inabilitar" class="btn btn-primary btn-sm" onclick="InabilitarPregunta('.$reg->idPregunta.')"><i class="fa fa-arrow-circle-down"></i></button>

            <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarPregunta('.$reg->idPregunta.')"><i class="fa fa-trash"></i></button>
               ';
        }elseif($reg->Estado_idEstado==2){
            return '<button type="button"  title="Habilitar" class="btn btn-info btn-sm" onclick="HabilitarPregunta('.$reg->idPregunta.')"><i class="fa fa-arrow-circle-up"></i></button> <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarPregunta('.$reg->idPregunta.')"><i class="fa fa-trash"></i></button> ';
        }
    }

   switch($_GET['op']){
        case 'AccionPregunta':
		 	$rspta=array("Error"=>false,"Mensaje"=>"","Registro"=>false);
         if(empty($idPregunta)){

                /*--  validar si el numero de la factura ya se encuentra emitido  --*/
                $validarPregunta=$mantenimiento->ValidarPregunta($PreguntaTitulo,$idPregunta);
                if($validarPregunta>0){
                    $rspta["Mensaje"].="El Pregunta ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Pregunta.";
                }else{
                    $RespuestaRegistro=$mantenimiento->RegistroPregunta($idEncuesta,$idPregunta,$PreguntaTitulo,$PreguntaTipo);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Pregunta se registro Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Pregunta no se puede registrar comuniquese con el area de soporte.";
                    }
                }
            }else{

                 $validarPregunta=$mantenimiento->ValidarPregunta($PreguntaTitulo,$idPregunta);
                if($validarPregunta>0){
                    $rspta["Mensaje"].="El Pregunta ya se encuentra Registrada ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Pregunta.";
                }else{

                    $RespuestaRegistro=$mantenimiento->RegistroPregunta($idEncuesta,$idPregunta,$PreguntaTitulo,$PreguntaTipo);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Pregunta se Actualizo Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Pregunta no se puede Actualizar comuniquese con el area de soporte.";
                    }
                }
            }

         echo json_encode($rspta);
       break;


		case 'Listar_Pregunta':

         $rspta=$mantenimiento->Listar_Pregunta($idEncuesta);
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>BuscarEstado($reg),
               "2"=>$reg->DetallePregunta,
               "3"=>$reg->Detalle,
               "4"=>BuscarAccion($reg)
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;


      case 'listar_tiposPregunta':
            echo '<option value="0">-- SELECCIONAR --</option>';
      		$rpta = $mantenimiento->ListarTipoPregunta();
         	while ($reg = $rpta->fetch_object()){
					echo '<option   value=' . $reg->idTipoPregunta . '>' . $reg->Detalle . '</option>';
         	}
       break;

      case 'Eliminar_Pregunta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Pregunta($idPregunta);

         $rspta['Eliminar']?$rspta['Mensaje']="Pregunta Eliminado.":$rspta['Mensaje']="Pregunta no se pudo eliminar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Habilitar_Pregunta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Pregunta($idPregunta,1);

         $rspta['Eliminar']?$rspta['Mensaje']="Pregunta Habilitado.":$rspta['Mensaje']="Pregunta no se pudo habilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

     case 'Inhabilitar_Pregunta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Pregunta($idPregunta,2);

         $rspta['Eliminar']?$rspta['Mensaje']="Pregunta Inhabilitado.":$rspta['Mensaje']="Pregunta no se pudo inhabilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Recuperar_Pregunta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Pregunta($idPregunta,2,$login_idLog);

         $rspta['Eliminar']?$rspta['Mensaje']="Pregunta Restablecido.":$rspta['Mensaje']="Pregunta no se pudo Restablecer comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'RecuperarInformacion_Pregunta':
			$rspta=$mantenimiento->Recuperar_Pregunta($idPregunta);
         echo json_encode($rspta);
      break;

       case 'RecuperarDatosEncuesta':
         $rspta=$mantenimiento->RecuperarDatosEncuesta($idEncuesta);
         echo json_encode($rspta);
      break;


   }


?>
