<?php
   session_start();
   require_once "../Modelo/MUsuario.php";

   require_once "../../php/PasswordHash.php";

   $mantenimiento = new MUsuario();


	$idUsuario=isset($_POST["idUsuario"])?limpiarCadena($_POST["idUsuario"]):"";
	$UsuarioNombre=isset($_POST["UsuarioNombre"])?limpiarCadena($_POST["UsuarioNombre"]):"";
	$UsuarioUsuario=isset($_POST["UsuarioUsuario"])?limpiarCadena($_POST["UsuarioUsuario"]):"";
	$UsuarioPass=isset($_POST["UsuarioPass"])?limpiarCadena($_POST["UsuarioPass"]):"";

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
            <button type="button" title="Editar" class="btn btn-warning btn-sm" onclick="EditarUsuario('.$reg->idUsuario.')"><i class="fa fa-edit"></i></button>
            <button type="button"  title="Inabilitar" class="btn btn-primary btn-sm" onclick="InabilitarUsuario('.$reg->idUsuario.')"><i class="fa fa-arrow-circle-down"></i></button>
               <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarUsuario('.$reg->idUsuario.')"><i class="fa fa-trash"></i></button>
               ';
        }elseif($reg->Estado_idEstado==2){
            return '<button type="button"  title="Habilitar" class="btn btn-info btn-sm" onclick="HabilitarUsuario('.$reg->idUsuario.')"><i class="fa fa-arrow-circle-up"></i></button> <button type="button"  title="Eliminar" class="btn btn-danger btn-sm" onclick="EliminarUsuario('.$reg->idUsuario.')"><i class="fa fa-trash"></i></button> ';
        }
    }

   switch($_GET['op']){
        case 'AccionUsuario':
		 	$rspta=array("Error"=>false,"Mensaje"=>"","Registro"=>false);
         if(empty($idUsuario)){

                /*--  validar si el numero de la factura ya se encuentra emitido  --*/
                $validarUsuario=$mantenimiento->ValidarUsuario($UsuarioUsuario,$idUsuario);
                if($validarUsuario>0){
                    $rspta["Mensaje"].="El Usuario ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Usuario.";
                }else{

                    $hasher= new PasswordHash(8,FALSE);
                    $UsuarioPass = $hasher->HashPassword($UsuarioPass);


                    $RespuestaRegistro=$mantenimiento->RegistroUsuario($idUsuario,$UsuarioNombre,$UsuarioUsuario,$UsuarioPass);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Usuario se registro Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Usuario no se puede registrar comuniquese con el area de soporte.";
                    }
                }
            }else{

                 $validarUsuario=$mantenimiento->ValidarUsuario($UsuarioUsuario,$idUsuario);
                if($validarUsuario>0){
                    $rspta["Mensaje"].="El Usuario ya se encuentra Registrado ";
                    $rspta["Error"]=true;
                }
                if($rspta["Error"]){
                    $rspta["Mensaje"].="Por estas razones no se puede Registrar el Usuario.";
                }else{
                     if($UsuarioPass!=''){
                        $hasher= new PasswordHash(8,FALSE);
                        $UsuarioPass = $hasher->HashPassword($UsuarioPass);
                    }else{
                        $UsuarioPass='-1';
                    }

                    $RespuestaRegistro=$mantenimiento->RegistroUsuario($idUsuario,$UsuarioNombre,$UsuarioUsuario,$UsuarioPass);
                    if($RespuestaRegistro){
                        $rspta["Registro"]=true;
                        $rspta["Mensaje"]="Usuario se Actualizo Correctamente.";
                    }else{
                        $rspta["Registro"]=false;
                        $rspta["Mensaje"]="Usuario no se puede Actualizar comuniquese con el area de soporte.";
                    }
                }
            }

         echo json_encode($rspta);
       break;


		case 'Listar_Usuario':

         $rspta=$mantenimiento->Listar_Usuario();
         $data= array();
         while ($reg=$rspta->fetch_object()){
         $data[]=array(
               "0"=>'',
               "1"=>BuscarEstado($reg),
               "2"=>$reg->NombreUsuario,
               "3"=>$reg->usuario,
               "4"=>$reg->fechaRegistro,
               "5"=>BuscarAccion($reg)
            );
         }
         $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
         echo json_encode($results);
      break;

      case 'Eliminar_Usuario':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Usuario($idUsuario);

         $rspta['Eliminar']?$rspta['Mensaje']="Usuario Eliminado.":$rspta['Mensaje']="Usuario no se pudo eliminar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Habilitar_Usuario':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Usuario($idUsuario,1);

         $rspta['Eliminar']?$rspta['Mensaje']="Usuario Habilitado.":$rspta['Mensaje']="Usuario no se pudo habilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

     case 'Inhabilitar_Usuario':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Estado_Usuario($idUsuario,2);

         $rspta['Eliminar']?$rspta['Mensaje']="Usuario Inhabilitado.":$rspta['Mensaje']="Usuario no se pudo inhabilitar comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'Recuperar_Usuario':
         $rspta = array("Mensaje"=>"","Eliminar"=>false,"Error"=>false);
         /*------ Cuando el usuario ya se esta facturando, ya no se puede eliminar --------*/
         $rspta['Eliminar']=$mantenimiento->Eliminar_Usuario($idUsuario,2,$login_idLog);

         $rspta['Eliminar']?$rspta['Mensaje']="Usuario Restablecido.":$rspta['Mensaje']="Usuario no se pudo Restablecer comuniquese con el area de soporte";
         echo json_encode($rspta);
      break;

      case 'RecuperarInformacion_Usuario':
			$rspta=$mantenimiento->Recuperar_Usuario($idUsuario);
         echo json_encode($rspta);
      break;


   }


?>
