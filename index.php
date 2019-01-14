<?php
  require "php/Mlogin.php";
   $gestion = new Login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="System">
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
    <title>Encuesta</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="vendor/datatables.css" />
    <link rel="stylesheet" href="vendor/sweetalert/dist/sweetalert.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    if(isset($_GET['env']) && isset($_GET['cli']) && isset($_GET['enc'])){
        $idEnvio=$_GET['env'];
        $respuesta=$gestion->VerificarEncuesta($idEnvio);
        if($respuesta["Encontrado"]>0){
            echo '<div class="row">
        <div class="col-12 col-12-small">
            <div class="row cabecera">
                <div class=" col-3 col-10-xsmall col-10-small">
                    <img class="logo" src="images/logo2.png"> </div>
            </div>
            <div class="row cabecera">
                <div class="col-3 col-10-xsmall col-10-small">
                    <h4 id="tituloEncuesta"></h4>
                </div>
            </div>
            <div class="row center_element" style="text-align: center;">
                <h3 class="col-6 m-5">YA SE REALIZO LA ENCUESTA!</h3>
            </div>
        </div>
    </div>';

        }else{
    ?>

    <form id="FormularioEncuesta" method="POST" autocomplete="off" style="margin:0;">
        <input type="hidden" id="idEncuesta" value="<?php echo $_GET['enc'];?>">
        <input type="hidden" id="idEnviado" value="<?php echo $_GET['env'];?>">
        <input type="hidden" id="idCliente" value="<?php echo $_GET['cli'];?>">
        <div class="row cabecera">
            <div class=" col-3 col-10-xsmall col-10-small">
                <img class="logo" src="images/logo2.png"> </div>
        </div>
        <div class="row cabecera">
            <div class="col-3 col-10-xsmall col-10-small">
                <h4 id="tituloEncuesta"></h4>
            </div>
        </div>

        <img class="componente" src="images/componente1.png" alt="">
        <div class="row center_element" style="margin-left:0;">

            <div id="contenedor" class="col-8 col-10-xsmall col-10-small">
                <div class="row center_element">
                    <div class="col-10 col-10-xsmall" style="margin-top:20px;">
                        <em>
                            <p id="DetalleEncuesta"></p>
                        </em>
                    </div>
                </div>

                <div class="row">
                    <div id="CuerpoEncuesta" class="col-12 col-12-small col-xsmall">
                    </div>
                </div>
            </div>
        </div>
        <div class="row pie_pagina">
            <div class="col-4 col-6-small col-6-xsmall boton">
                <button class="button primary boton_envio" type="submit">ENVIAR RESULTADOS</button>
            </div>
        </div>

    </form>

    <div id="ModuloRespuesta" class="" style="display:none;">
        <div class="col-12 col-12-small">
            <div class="row cabecera">
                <div class=" col-3 col-10-xsmall col-10-small">
                    <img class="logo" src="images/logo2.png"> </div>
            </div>
            <div class="row cabecera">
                <div class="col-3 col-10-xsmall col-10-small">
                    <h4 id="tituloEncuesta"></h4>
                </div>
            </div>
            <div class="row center_element" style="text-align: center;">
                <h3 class="m-5 col-6">GRACIAS POR SUS RESPUESTAS, SE ENVIO LOS RESULTADOS A NUESTRO SISTEMA.</h3>
            </div>

        </div>
    </div>

    <?php
    }

    }else{

    ?>
    <div class="row ">
       <div class="col-12 col-12-small">
            <div class="row cabecera">
                <div class=" col-3 col-10-xsmall col-10-small">
                    <img class="logo" src="images/logo2.png"> </div>
            </div>
            <div class="row cabecera">
                <div class="col-3 col-10-xsmall col-10-small">
                    <h4 id="tituloEncuesta"></h4>
                </div>
            </div>
            <div class="row center_element" style="text-align: center;">
                <h3 class="m-5 col-6">SE ENCONTRO UN ERROR EN LA BUSQUEDA DE LA ENCUESTA</h3>
            </div>

        </div>

    </div>
    <?php } ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="Encuesta.js"></script>
</body>


</html>
