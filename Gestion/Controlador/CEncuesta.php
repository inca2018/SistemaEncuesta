<?php
   session_start();
   require_once "../Modelo/MEncuesta.php";

   $mantenimiento = new MEncuesta();


	$idEncuesta=isset($_POST["idEncuesta"])?limpiarCadena($_POST["idEncuesta"]):"";
	$EncuestaTitulo=isset($_POST["EncuestaTitulo"])?limpiarCadena($_POST["EncuestaTitulo"]):"";
	$EncuestaDetalle=isset($_POST["EncuestaDetalle"])?limpiarCadena($_POST["EncuestaDetalle"]):"";
   $ArregloClientes=isset($_POST["ArregloClientes"])?limpiarCadena($_POST["ArregloClientes"]):"";
	//$login_idLog=$_SESSION['idUsuario'];
	$codigoEnvio=isset($_POST["CodigoEnvio"])?limpiarCadena($_POST["CodigoEnvio"]):"";
	$idPregunta=isset($_POST["idPregunta"])?limpiarCadena($_POST["idPregunta"]):"";

   $CodigoEnvio=isset($_POST["CodigoEnvio"])?limpiarCadena($_POST["CodigoEnvio"]):"";
   $ArregloRespuesta=isset($_POST["ArregloRespuesta"])?limpiarCadena($_POST["ArregloRespuesta"]):"";

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
            <button type="button" title="Vista Previa" class="btn btn-success btn-sm" onclick="Ver('.$reg->idEncuesta.')"><i class="fa fa-eye"></i></button>

            <button type="button" title="Gestionar Encuesta" class="btn btn-info btn-sm" onclick="Preguntas('.$reg->idEncuesta.')"><i class="fa fa-question"></i></button>

            <button type="button" title="Editar" class="btn btn-warning btn-sm" onclick="EditarEncuesta('.$reg->idEncuesta.')"><i class="fa fa-edit"></i></button>

            <button type="button"  title="Inabilitar" class="btn btn-primary btn-sm" onclick="InabilitarEncuesta('.$reg->idEncuesta.')"><i class="fa fa-arrow-circle-down"></i></button>

            <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarEncuesta('.$reg->idEncuesta.')"><i class="fa fa-trash"></i></button>
               ';
        }elseif($reg->Estado_idEstado==2){
            return '<button type="button"  title="Habilitar" class="btn btn-info btn-sm" onclick="HabilitarEncuesta('.$reg->idEncuesta.')"><i class="fa fa-arrow-circle-up"></i></button> <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarEncuesta('.$reg->idEncuesta.')"><i class="fa fa-trash"></i></button> ';
        }
    }
    function VerificarEstadoEnvio($reg){
        $numeroClientes=$reg->NuMClientes;
        $cantidadResultado=$reg->CantidadResultado;
        if($cantidadResultado==0){
            return '<div class="badge badge-danger">0.00 %</div>';
        }else if($cantidadResultado==$numeroClientes){
            return '<div class="badge badge-success">100.00 %</div>';
        }else{
            $respuesta=number_format($cantidadResultado*100/$numeroClientes,2);
            return '<div class="badge badge-warning" style="color:white;">'.$respuesta.' %</div>';
        }
    }
    function VerificarResultados($reg){

             return '<button type="button"  title="Resultados" class="btn btn-info btn-sm" onclick="ResultadoEnvio('.$reg->Codigo.')"><i class="fa fa-bar-chart"></i></button>';

    }

   function VerificarResultadoCliente($reg){
       if($reg->ResultadoCliente==0){
            return '<div class="badge badge-danger" title="Encuesta no Resuelta"><i class="fa fa-times"></i></div>';
       }else{
            return '<div class="badge badge-success" title="Encuesta Resuelta"><i class="fa fa-check"></i></div>';
       }
   }


   function  EnviarCorreo($link,$RazonSocial,$ContactoNombre,$ContactoCorreo){

       $asunto = "Encuesta de Satisfacción.";
        $cuerpo='<html>
                    <head>
                        <title>Prueba de correo</title>
                    </head>
                    <body>
                        <div style="text-align: center;">
                             <img src="http://encuesta.qsystemdevs.com/qsystem.png" width="10%" height="10%">
                            <h3>Estimado(a)!</h3>
                            <h2>'.$ContactoNombre.'</h2>
                            <h4>'.$RazonSocial.'</h4>
                            <p>
                                 Te saludamos de parte de QSYSTEM SAC y te invitamos a completar la siguiente encuesta:<br>
                                    '.$link.'
                            </p>
                            <p>Muchas Gracias.</p>
                        </div>
                    </body>
                </html>
                ';
       $headers = "MIME-Version: 1.0\r\n";
       $headers .= "Content-type: text/html; charset=UTF-8\r\n";
       $headers .= "From: Qsystem Sac <kevin.calderon@qsystem.com.pe>\r\n";

       mail($ContactoCorreo,$asunto,$cuerpo,$headers);

   }

   switch($_GET['op']){
        case 'AccionEncuesta':
		 	$rspta=array("Error"=>false,"Mensaje"=>"","Registro"=>false);
         if(empty($idEncuesta)){

                /*--  validar si el numero de la factura ya se encuentra emitido  --*/
                $validarEncuesta=$mantenimiento->ValidarEncuesta($EncuestaTitulo,$idEncuesta);
                if($validarEncuesta>0){
                    $rspta["Mensaje"].="El Encuesta ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Encuesta.";
                }else{
                    $RespuestaRegistro=$mantenimiento->RegistroEncuesta($idEncuesta,$EncuestaTitulo,$EncuestaDetalle);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Encuesta se registro Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Encuesta no se puede registrar comuniquese con el area de soporte.";
                    }
                }
            }else{

                 $validarEncuesta=$mantenimiento->ValidarEncuesta($EncuestaTitulo,$idEncuesta);
                if($validarEncuesta>0){
                    $rspta["Mensaje"].="El Encuesta ya se encuentra Registrada ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Encuesta.";
                }else{

                    $RespuestaRegistro=$mantenimiento->RegistroEncuesta($idEncuesta,$EncuestaTitulo,$EncuestaDetalle);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Encuesta se Actualizo Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Encuesta no se puede Actualizar comuniquese con el area de soporte.";
                    }
                }
            }

         echo json_encode($rspta);
       break;


		case 'Listar_Encuesta':

         $rspta=$mantenimiento->Listar_Encuesta();
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>BuscarEstado($reg),
               "2"=>$reg->TituloEncuesta,
               "3"=>$reg->DetalleEncuesta,
               "4"=>$reg->CantidadPreguntas,
               "5"=>$reg->fechaRegistro,
               "6"=>BuscarAccion($reg)
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;


       case 'ListarClientesDisponibles':

         $rspta=$mantenimiento->ListarClientesDisponibles();
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>$reg->RazonSocial,
               "2"=>$reg->RUC,
               "3"=>'<div class="col-12 col-12-small">
                                <input type="checkbox" class="Seleccionar" data-id="'.$reg->idCliente.'" id="Cliente-'.$reg->idCliente.'" name="Check'.$reg->idCliente.'">
                                <label for="Cliente-'.$reg->idCliente.'">Seleccione</label>
                    </div>'
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
        break;

        case 'ListarEnviosRealizados':

         $rspta=$mantenimiento->ListarEnviosRealizados();
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>VerificarEstadoEnvio($reg),
               "2"=>$reg->TituloEncuesta,
               "3"=>$reg->NuMClientes,
               "4"=>"(".$reg->NuMClientes." Envios / ".$reg->CantidadResultado." Resueltos)",
               "5"=>$reg->FechaEnvio,
               "6"=>VerificarResultados($reg)
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;

      case 'ListarResultadosCliente':

         $rspta=$mantenimiento->ListarResultadosCliente($codigoEnvio);
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>$reg->RazonSocial,
               "2"=>$reg->FechaResultado,
               "3"=>VerificarResultadoCliente($reg)

            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;

      case 'ListarResultadosPregunta':

         $rspta=$mantenimiento->ListarResultadosPregunta($codigoEnvio);
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>$reg->DetallePregunta,
               "2"=>$reg->Detalle,
               "3"=>number_format($reg->CantidadPregunta,2),
               "4"=>'<button type="button"  title="Resultados por Pregunta" class="btn btn-info btn-sm" onclick="InformacionPregunta('.$reg->idPregunta.','.$reg->CodigoPregunta.')"><i class="fa fa-bar-chart"></i></button>'
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;




      case 'ListarEncuestasDisponibles':
            echo '<option value="0">-- SELECCIONAR --</option>';
      		$rpta = $mantenimiento->ListarEncuestasDisponibles();
         	while ($reg = $rpta->fetch_object()){
					echo '<option   value=' . $reg->idEncuesta . '>' . $reg->TituloEncuesta . '</option>';
         	}
       break;


       case 'Enviar_Encuesta':

             $rspta = array("Mensaje"=>"","Enviar"=>false,"Error"=>false,"CodigoEnvio"=>0);

             $rpt=$mantenimiento->Enviar_Encuesta($idEncuesta,$ArregloClientes);
             if($rpt['CodigoEnvio']>0){
                 $rspta['Enviar']=true;
                 $rspta['CodigoEnvio']=$rpt['CodigoEnvio'];
             }else{
                 $rspta['Enviar']=false;
             }
             /** RECUPERAR ARREGLO Y ENVIAR POR CORREO $ArregloClientes **/

             $rspta['Enviar']?$rspta['Mensaje']="Encuesta Enviada.":$rspta['Mensaje']="Encuesta no se pudo enviar comuniquese con el area de soporte";
             echo json_encode($rspta);

        break;

        case 'Enviar_Correo_Cliente':
             $rpta = array("Mensaje"=>"","Enviar"=>false,"Error"=>false);

             $rspta=$mantenimiento->Recuperar_Informacion_Para_Envio($codigoEnvio);

            if($rspta){
                  while ($reg=$rspta->fetch_object()){
                       EnviarCorreo($reg->link,$reg->RazonSocial,$reg->NombreContacto,$reg->CorreoContacto);
                    }
                  $rpta['Enviar']=true;
            }else{
                 $rpta['Enviar']=false;
            }

             $rpta['Enviar']?$rpta['Mensaje']="Encuesta Enviada con Exito!.":$rpta['Mensaje']="Encuesta no se pudo enviar comuniquese con el area de soporte";
             echo json_encode($rpta);

        break;


      case 'Eliminar_Encuesta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Encuesta($idEncuesta);

         $rspta['Eliminar']?$rspta['Mensaje']="Encuesta Eliminado.":$rspta['Mensaje']="Encuesta no se pudo eliminar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Habilitar_Encuesta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Encuesta($idEncuesta,1);

         $rspta['Eliminar']?$rspta['Mensaje']="Encuesta Habilitado.":$rspta['Mensaje']="Encuesta no se pudo habilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

     case 'Inhabilitar_Encuesta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Encuesta($idEncuesta,2);

         $rspta['Eliminar']?$rspta['Mensaje']="Encuesta Inhabilitado.":$rspta['Mensaje']="Encuesta no se pudo inhabilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Recuperar_Encuesta':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Encuesta($idEncuesta,2,$login_idLog);

         $rspta['Eliminar']?$rspta['Mensaje']="Encuesta Restablecido.":$rspta['Mensaje']="Encuesta no se pudo Restablecer comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'RecuperarInformacion_Encuesta':
			$rspta=$mantenimiento->Recuperar_Encuesta($idEncuesta);
         echo json_encode($rspta);
      break;
      case 'RecuperarEncuestaCompleta':
       $rspta=$mantenimiento->RecuperarEncuestaCompleta($idEncuesta);
         echo json_encode($rspta);
      break;

       case 'RecuperarGraficoResultado':
        $rspta=$mantenimiento->RecuperarGraficoResultado($codigoEnvio);
         echo json_encode($rspta);
      break;
       case 'RecuperarGraficoResultadoPregunta1':
         $rspta=$mantenimiento->RecuperarGraficoResultadoPregunta1($codigoEnvio,$idPregunta);
         echo json_encode($rspta);
      break;
      case 'RecuperarGraficoResultadoPregunta2':
         $rspta=$mantenimiento->RecuperarGraficoResultadoPregunta2($codigoEnvio,$idPregunta);
         echo json_encode($rspta);
      break;
      case 'RecuperarGraficoResultadoPregunta3':

         $rspta=$mantenimiento->RecuperarGraficoResultadoPregunta3($codigoEnvio,$idPregunta);
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>$reg->RazonSocial,
               "2"=>$reg->RespuestaTexto
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;

     case 'RegistrarResultados':
         $rspta = array("Mensaje"=>"","Respuesta"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Respuesta']=$mantenimiento->RegistrarResultados($codigoEnvio,$ArregloRespuesta);

         $rspta['Respuesta']?$rspta['Mensaje']="Encuesta Enviada Correctamente!.":$rspta['Mensaje']="Encuesta no se pudo enviar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;
   }


?>
