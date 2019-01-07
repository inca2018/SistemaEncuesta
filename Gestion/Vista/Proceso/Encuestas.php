<!-- Inicio de Cabecera-->
<?php require_once('../Layaout/Header.php');?>
<!-- Header -->
<header id="header">
    <h2>Encuestas</h2>
</header>
<section>
    <div class="row aln-center">
        <div class="col-3 off-9 right_element">
            <button class="button primary " onclick="NuevoEncuesta();">NUEVA ENCUESTA</button>
        </div>
    </div>
    <h4>Lista General de Encuestas:</h4>
    <div class="row">
        <div class="col-12 col-12-xsmall center_element">
            <table class="table table-resposive table-hover table-sm dt-responsive" id="tablaEncuesta">
                <thead class="thead-light text-center">
                    <tr>
                        <th width="5%" data-priority="1">#</th>
                        <th width="5%">ESTADO</th>
                        <th width="20%">TITULO</th>
                        <th width="20%">DETALLE</th>
                        <th width="10%">PREGUNTAS</th>
                        <th width="10%">F.REGISTRO</th>
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
<div class="modal fade" id="ModalEncuesta" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <form id="FormularioEncuesta" method="POST" autocomplete="off">
                    <input type="hidden" name="idEncuesta" id="idEncuesta">
                    <div class="row gtr-uniform">
                        <div class="col-12 col-12-xsmall center_element">
                            <h2 id="tituloModalEncuesta"></h2>
                            <hr>
                        </div>
                        <div class="col-12 col-12-xsmall">
                            <input class="validarPanel" type="text" name="EncuestaTitulo" id="EncuestaTitulo" value="" placeholder="Titulo de Encuesta" maxlength="150" data-message="- Titulo de Encuesta"> </div>
                        <!-- Break -->
                        <div class="col-12">
                            <textarea class="validarPanel" name="EncuestaDetalle" id="EncuestaDetalle" placeholder="Ingrese Detalle" rows="6" data-message="- Campo  Detalle de Encuesta"></textarea>
                        </div>
                        <!-- Break -->
                        <div class="col-12">
                            <ul class="actions">
                                <li>
                                    <input type="submit" value="GUARDAR" class="primary"> </li>
                                <li>
                                    <input type="button" value="CANCELAR" onclick="Cancelar();"> </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalVistaPrevia" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
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
    </div>
</div>
<script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Proceso/Encuesta.js"></script>
