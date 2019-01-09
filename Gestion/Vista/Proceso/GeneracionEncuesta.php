<?php
    if(isset($_POST['idEncuesta'])){

    }else{
        header('Location: Encuestas.php');
    }
?>
    <!-- Inicio de Cabecera-->
    <?php require_once('../Layaout/Header.php');?>
        <!-- Header -->
        <header id="header">
            <h2>Generación de Pregunta</h2> </header>
        <section>
            <input type="hidden" id="idEncuesta" value="<?php echo $_POST['idEncuesta']; ?>">
            <div class="row">
                <div class="col-6 col-12-xsmall">
                    <h4>Encuesta:</h4>
                    <p id="EncuestaNombre"></p>
                </div>
                <div class="col-6 col-12-xsmall">
                    <h4>Detalle:</h4>
                    <p id="EncuestaDetalle"></p>
                </div>
            </div>
            <hr>
            <div class="row aln-center">
                <div class="col-3 col-12-xsmall">
                    <button class="button secondary" onclick="volver();">VOLVER</button>
                </div>
                <div class="col-3 off-6 right_element col-12-xsmall">
                    <button class="button primary" onclick="NuevaPregunta();">AGREGAR PREGUNTA</button>
                </div>
            </div>
            <hr>
            <h4>Lista de Preguntas:</h4>
            <div class="row">
                <div class="col-12 col-12-xsmall center_element">
                    <table class="table table-resposive w-100 table-hover table-sm " id="tablaPregunta">
                        <thead class="thead-light text-center">
                            <tr>
                                <th width="5%" data-priority="1">#</th>
                                <th width="15%">ESTADO</th>
                                <th width="20%">PREGUNTA</th>
                                <th width="20%">TIPO PREGUNTA</th>
                                <th width="20%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
        </section>
        <?php require_once('../Layaout/Nav.php');?>
            <?php require_once('../Layaout/Footer.php');?>
                <div class="modal fade" id="ModalPregunta" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form id="FormularioPregunta" method="POST" autocomplete="off">
                                    <input type="hidden" name="idPregunta" id="idPregunta">
                                    <div class="row gtr-uniform">
                                        <div class="col-12 col-12-xsmall center_element">
                                            <h2 id="tituloModalPregunta"></h2>
                                            <hr> </div>
                                        <div class="col-12 col-12-xsmall">
                                            <textarea class="validarPanel" name="PreguntaTitulo" id="PreguntaTitulo" placeholder="Titulo de Pregunta" rows="3" data-message="- Campo  Titulo de Pregunta"></textarea>
                                        </div>
                                        <div class="col-6 col-12-xsmall">
                                            <select name="TipoPregunta" id="TipoPregunta"> </select>
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
                <script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Proceso/Pregunta.js"></script>
