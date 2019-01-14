<?php
   session_start();
   require_once "../Modelo/MEntidad.php";

   $mantenimiento = new MEntidad();


	$idEntidad=isset($_POST["idEntidad"])?limpiarCadena($_POST["idEntidad"]):"";
	$EntidadRazonSocial=isset($_POST["EntidadRazonSocial"])?limpiarCadena($_POST["EntidadRazonSocial"]):"";
	$EntidadRUC=isset($_POST["EntidadRUC"])?limpiarCadena($_POST["EntidadRUC"]):"";
   $EntidadDireccion=isset($_POST["EntidadDireccion"])?limpiarCadena($_POST["EntidadDireccion"]):"";

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
            return '<button type="button" title="Clientes" class="btn btn-primary btn-sm" onclick="Clientes('.$reg->idEntidad.')"><i class="fa fa-male"></i></button>
            <button type="button" title="Editar" class="btn btn-warning btn-sm" onclick="EditarEntidad('.$reg->idEntidad.')"><i class="fa fa-edit"></i></button>
            <button type="button"  title="Inabilitar" class="btn btn-primary btn-sm" onclick="InabilitarEntidad('.$reg->idEntidad.')"><i class="fa fa-arrow-circle-down"></i></button>
               <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarEntidad('.$reg->idEntidad.')"><i class="fa fa-trash"></i></button>
               ';
        }elseif($reg->Estado_idEstado==2){
            return '<button type="button"  title="Habilitar" class="btn btn-info btn-sm" onclick="HabilitarEntidad('.$reg->idEntidad.')"><i class="fa fa-arrow-circle-up"></i></button> <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarEntidad('.$reg->idEntidad.')"><i class="fa fa-trash"></i></button> ';
        }
    }

   switch($_GET['op']){
        case 'AccionEntidad':
		 	$rspta=array("Error"=>false,"Mensaje"=>"","Registro"=>false);
         if(empty($idEntidad)){

                /*--  validar si el numero de la factura ya se encuentra emitido  --*/
                $validarEntidad=$mantenimiento->ValidarEntidad($EntidadRUC,$idEntidad);
                if($validarEntidad>0){
                    $rspta["Mensaje"].="El Entidad ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Entidad.";
                }else{
                    $RespuestaRegistro=$mantenimiento->RegistroEntidad($idEntidad,$EntidadRazonSocial,$EntidadRUC,$EntidadDireccion);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Entidad se registro Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Entidad no se puede registrar comuniquese con el area de soporte.";
                    }
                }
            }else{

                 $validarEntidad=$mantenimiento->ValidarEntidad($EntidadRUC,$idEntidad);
                if($validarEntidad>0){
                    $rspta["Mensaje"].="El Entidad ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Entidad.";
                }else{

                    $RespuestaRegistro=$mantenimiento->RegistroEntidad($idEntidad,$EntidadRazonSocial,$EntidadRUC,$EntidadDireccion);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Entidad se Actualizo Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Entidad no se puede Actualizar comuniquese con el area de soporte.";
                    }
                }
            }

         echo json_encode($rspta);
       break;


		case 'Listar_Entidad':

         $rspta=$mantenimiento->Listar_Entidad();
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>BuscarEstado($reg),
               "2"=>$reg->RUC,
               "3"=>$reg->RazonSocial,
               "4"=>$reg->Direccion,
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

      case 'Eliminar_Entidad':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Entidad($idEntidad);

         $rspta['Eliminar']?$rspta['Mensaje']="Entidad Eliminado.":$rspta['Mensaje']="Entidad no se pudo eliminar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Habilitar_Entidad':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Entidad($idEntidad,1);

         $rspta['Eliminar']?$rspta['Mensaje']="Entidad Habilitado.":$rspta['Mensaje']="Entidad no se pudo habilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

     case 'Inhabilitar_Entidad':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Entidad($idEntidad,2);

         $rspta['Eliminar']?$rspta['Mensaje']="Entidad Inhabilitado.":$rspta['Mensaje']="Entidad no se pudo inhabilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Recuperar_Entidad':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Entidad($idEntidad,2,$login_idLog);

         $rspta['Eliminar']?$rspta['Mensaje']="Entidad Restablecido.":$rspta['Mensaje']="Entidad no se pudo Restablecer comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'RecuperarInformacion_Entidad':
			$rspta=$mantenimiento->Recuperar_Entidad($idEntidad);
         echo json_encode($rspta);
      break;


   }


?>
