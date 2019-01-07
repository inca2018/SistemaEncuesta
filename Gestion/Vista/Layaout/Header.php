<?php
session_start();

require_once ('../../../config/conexion.php');


/* indentifiacion del usuario */
 if(isset($_SESSION['idUsuario'])){

 }else{
   header("Location: ../../../index.php");
 }

$conexionConfig = new Conexion();

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="System">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title>Sistema de Encuesta</title>
   <link rel="stylesheet" href="<?php echo $conexionConfig->ruta(); ?>assets/css/main.css" />
   <link rel="stylesheet" href="<?php echo $conexionConfig->ruta(); ?>vendor/datatables.css" />
   <link rel="stylesheet" href="<?php echo $conexionConfig->ruta(); ?>vendor/sweetalert/dist/sweetalert.css" />

</head>

<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">
