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
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="vendor/datatables.css" />
    <link rel="stylesheet" href="vendor/sweetalert/dist/sweetalert.css" />

</head>

<body>
    <?php
    if(isset($_GET['env']) && isset($_GET['cli']) && isset($_GET['enc'])){
        $idEnvio=$_GET['env'];
        $respuesta=$gestion->VerificarEncuesta($idEnvio);
        if($respuesta["Encontrado"]>0){
            echo '<div class="row m-5 center_element ">
        <div class="col-6 col-12-small">
            <img class="mt-4" src="qsystem.png" width="60%" height="80%">
            <h3 class="mt-4">LA ENCUESTA YA SE REALIZO!</h3>
        </div>
    </div>';

        }else{
    ?>

    <form id="FormularioEncuesta" method="POST" autocomplete="off">
        <input type="hidden" id="idEncuesta" value="<?php echo $_GET['enc'];?>">
        <input type="hidden" id="idEnviado" value="<?php echo $_GET['env'];?>">
        <input type="hidden" id="idCliente" value="<?php echo $_GET['cli'];?>">
        <div class="row m-5">
            <div class="col-12">
                <div class="row gtr-uniform">
                    <div class="col-12 col-12-xsmall center_element">
                        <h2 id="tituloEncuesta"></h2>
                        <p id="DetalleEncuesta"></p>
                    </div>
                </div>
                <hr>
                <div id="CuerpoEncuesta">

                </div>
            </div>
        </div>
        <div class="row center_element">
            <div class="col-3">
              <button class="button primary" type="submit">ENVIAR RESULTADOS</button>
            </div>
        </div>
    </form>

    <div id="ModuloRespuesta" class="row m-5 center_element" style="display:none;">
         <div class="col-6 col-12-small">
            <img class="mt-4" src="qsystem.png" width="60%" height="80%">
            <h3  class="mt-4">GRACIAS POR SUS RESPUESTAS, SE ENVIO LOS RESULTADOS A NUESTRO SISTEMA.</h3>
        </div>
    </div>

    <?php
    }

    }else{

    ?>
    <div class="row m-5 center_element ">
        <div cl  ass="col-6 col-12-small">
            <img class="mt-4" src="qsystem.png" width="60%" height="80%">
            <h3  class="mt-4">SE ENCONTRO UN ERROR EN LA BUSQUEDA DE LA ENCUESTA</h3>
        </div>

    </div>
    <?php } ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="Encuesta.js"></script>
</body>


</html>
