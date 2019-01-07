<!-- Inicio de Cabecera-->
<?php require_once('../Layaout/Header.php');?>

<!-- Header -->
<header id="header">
    <a href="#" class="logo"><strong>Envió de Encuestas</strong></a>
</header>

<section>
        <div class="row">
                <div class="col-6 col-12-xsmall">
                    <h4>Seleccione Encuesta Disponible:</h4>
                    <select id="EncuestasDisponibles"></select>
                </div>
        </div>
        <div class="row">
              <div class="col-6 col-12-xsmall">
                    <button style="margin-top:15px;"  class="button secondary" onclick="EnviarEncuesta();">ENVIAR ENCUESTA</button>
                </div>
        </div>
        <hr>

        <h4>Lista de Clientes Disponibles:</h4>
        <div class="row">
            <div class="col-12 col-12-xsmall center_element">
                <table class="table table-resposive table-hover table-sm dt-responsive" id="tablaClientesSeleccion">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="10%" data-priority="1">#</th>
                            <th width="30%">CLIENTE</th>
                            <th width="30%">RUC</th>
                            <th width="30%">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
</section>

<?php require_once('../Layaout/Nav.php');?>
<?php require_once('../Layaout/Footer.php');?>

<script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Proceso/EnvioClientes.js"></script>
