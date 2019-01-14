<?php
   session_start();
   require_once "../Modelo/MCliente.php";

   $mantenimiento = new MCliente();


	$idCliente=isset($_POST["idCliente"])?limpiarCadena($_POST["idCliente"]):"";
	$ClienteContacto=isset($_POST["ClienteContacto"])?limpiarCadena($_POST["ClienteContacto"]):"";
	$ClienteCorreo=isset($_POST["ClienteCorreo"])?limpiarCadena($_POST["ClienteCorreo"]):"";
   $ClienteCargo=isset($_POST["ClienteCargo"])?limpiarCadena($_POST["ClienteCargo"]):"";

   $idEntidad=isset($_POST["idEntidad"])?limpiarCadena($_POST["idEntidad"]):"";
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
            <button type="button" title="Editar" class="btn btn-warning btn-sm" onclick="EditarCliente('.$reg->idCliente.')"><i class="fa fa-edit"></i></button>
            <button type="button"  title="Inabilitar" class="btn btn-primary btn-sm" onclick="InabilitarCliente('.$reg->idCliente.')"><i class="fa fa-arrow-circle-down"></i></button>
               <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarCliente('.$reg->idCliente.')"><i class="fa fa-trash"></i></button>
               ';
        }elseif($reg->Estado_idEstado==2){
            return '<button type="button"  title="Habilitar" class="btn btn-info btn-sm" onclick="HabilitarCliente('.$reg->idCliente.')"><i class="fa fa-arrow-circle-up"></i></button> <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarCliente('.$reg->idCliente.')"><i class="fa fa-trash"></i></button> ';
        }
    }

   switch($_GET['op']){
        case 'AccionCliente':
		 	$rspta=array("Error"=>false,"Mensaje"=>"","Registro"=>false);
         if(empty($idCliente)){

                /*--  validar si el numero de la factura ya se encuentra emitido  --*/
                $validarCliente=$mantenimiento->ValidarCliente($ClienteContacto,$idEntidad,$idCliente);
                if($validarCliente>0){
                    $rspta["Mensaje"].="El Cliente ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Cliente.";
                }else{
                    $RespuestaRegistro=$mantenimiento->RegistroCliente($idCliente,$ClienteContacto,$ClienteCorreo,$ClienteCargo,$idEntidad);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Cliente se registro Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Cliente no se puede registrar comuniquese con el area de soporte.";
                    }
                }
            }else{

                 $validarCliente=$mantenimiento->ValidarCliente($ClienteContacto,$idEntidad,$idCliente);
                if($validarCliente>0){
                    $rspta["Mensaje"].="El Cliente ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Cliente.";
                }else{

                    $RespuestaRegistro=$mantenimiento->RegistroCliente($idCliente,$ClienteContacto,$ClienteCorreo,$ClienteCargo,$idEntidad);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Cliente se Actualizo Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Cliente no se puede Actualizar comuniquese con el area de soporte.";
                    }
                }
            }

         echo json_encode($rspta);
       break;


		case 'Listar_Cliente':
         $rspta=$mantenimiento->Listar_Cliente($idEntidad);
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>BuscarEstado($reg),
               "2"=>$reg->NombreContacto,
               "3"=>$reg->CorreoContacto,
               "4"=>$reg->Cargo,
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

      case 'Eliminar_Cliente':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Cliente($idCliente);

         $rspta['Eliminar']?$rspta['Mensaje']="Cliente Eliminado.":$rspta['Mensaje']="Cliente no se pudo eliminar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Habilitar_Cliente':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Cliente($idCliente,1);

         $rspta['Eliminar']?$rspta['Mensaje']="Cliente Habilitado.":$rspta['Mensaje']="Cliente no se pudo habilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

     case 'Inhabilitar_Cliente':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Cliente($idCliente,2);

         $rspta['Eliminar']?$rspta['Mensaje']="Cliente Inhabilitado.":$rspta['Mensaje']="Cliente no se pudo inhabilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Recuperar_Cliente':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Cliente($idCliente,2,$login_idLog);

         $rspta['Eliminar']?$rspta['Mensaje']="Cliente Restablecido.":$rspta['Mensaje']="Cliente no se pudo Restablecer comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'RecuperarInformacion_Cliente':
			$rspta=$mantenimiento->Recuperar_Cliente($idCliente);
         echo json_encode($rspta);
      break;
       case 'RecuperarEntidadDatos':
        $rspta=$mantenimiento->RecuperarEntidadDatos($idEntidad);
         echo json_encode($rspta);
      break;


   }


?>
