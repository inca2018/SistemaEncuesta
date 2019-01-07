<?php

//require_once ('../../modelo/usuario/mlogin.php');
require_once('../Layaout/Header.php');

  // $login = new login();
   // capturamos el id del usuario
//   $idusu=$_SESSION['idUsuario'];

   // capturamos la hora de session
  // date_default_timezone_set('America/Lima');
//   $horacierre=date("Y-m-d H:i:s");
   // calculamos la hora de cierre
//   $ipser=$_SERVER['REMOTE_ADDR'];

  // echo "IP: (".$ipser.")";

//   $cierreSession=$login->cierreacceso($idusu,$horacierre,$ipser);

  // if($cierreSession){
      header("Refresh:3; url=../../../index.php");
      session_unset();
      session_destroy();
 //  }

?>
    <!-- Header -->
    <header id="header"> <a href="#" class="logo"><strong>Salir</strong></a> </header>
    <section class="center_element">

        <h2 class="text-thin">Cerrando Sesión</h2>
        <div class="col-12 col-12-xsmall center_element"> <i class="fa fa-spinner fa-pulse fa-3x fa-fw text-info"></i> <span class="sr-only">Loading...</span> </div>
    </section>
    <?php require_once('../Layaout/Nav.php');?>
    <?php require_once('../Layaout/Footer.php');?>
