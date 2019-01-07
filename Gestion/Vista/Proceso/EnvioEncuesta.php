<!-- Inicio de Cabecera-->
<?php require_once('../Layaout/Header.php');?>

<!-- Header -->
<header id="header">
    <a href="#" class="logo"><strong>Envió de Encuestas</strong></a>
</header>

<section>
        <div class="row aln-center">
            <div class="col-3 off-9 right_element">
                <button class="button primary " onclick="NuevoEnvio();">NUEVO ENVIO</button>
            </div>
        </div>
        <h4>Lista de Envios:</h4>
        <div class="row">
            <div class="col-12 col-12-xsmall center_element">
                <table class="table table-resposive table-hover table-sm dt-responsive" id="tablaEnviosRealizados">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%" data-priority="1">#</th>
                            <th width="5%">ESTADO</th>
                            <th width="40%">ENCUESTA</th>
                            <th width="20%">CANTIDAD DE CLIENTES</th>
                            <th width="20%">ENVIOS/RESPUESTAS</th>
                            <th width="10%">F.ENVIO</th>
                            <th width="10%">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
</section>

<?php require_once('../Layaout/Nav.php');?>

<?php require_once('../Layaout/Footer.php');?>

  <script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Proceso/EnvioEncuesta.js"></script>
