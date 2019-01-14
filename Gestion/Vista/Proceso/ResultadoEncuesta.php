<?php
    if(isset($_POST['CodigoEnvio'])){

    }else{
        header('Location: EnvioEncuesta.php');
    }
?>
<!-- Inicio de Cabecera-->
<?php require_once('../Layaout/Header.php');?>
<!-- Header -->
<header id="header"> <a href="#" class="logo"><strong>Resultado de Encuestas</strong></a> </header>
<section>
    <input type="hidden" id="CodigoEnvio" value="<?php echo $_POST['CodigoEnvio']; ?>">
    <div class="row">
        <div class="col-6 col-12-xsmall">
            <h4>Encuesta Enviada:</h4>
            <p id="EncuestaNombre"></p>
        </div>
        <div class="col-6 col-12-xsmall">
            <h4>Estado Actual de Envio:</h4>
            <p id="EncuestaEstado"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-3 col-12-xsmall">
            <button class="button primary " onclick="RegresarEnvios();">LISTA DE ENVIOS</button>
        </div>
    </div>
    <hr>
    <div class="row aln-center">
        <div class="col-5 col-12-xsmall">
            <h4>Grafico Estadistico de Resultados:</h4>
            <canvas style="margin-top:50px;" id="chart-area"></canvas>
        </div>
        <div class="col-7 col-12-xsmall">
            <h4>Resultado por Clientes:</h4>
            <table class="table table-resposive table-hover table-sm dt-responsive" id="tablaClientesResultados">
                <thead class="thead-light text-center">
                    <tr>
                        <th width="10%" data-priority="1">#</th>
                        <th width="30%">ENTIDAD</th>
                        <th width="30%">CLIENTE</th>
                        <th width="20%">FECHA DE RESULTADO</th>
                        <th width="10%">RESULTADO</th>
                    </tr>
                </thead>
                <tbody> </tbody>
            </table>
        </div>
    </div>
    <hr>

    <div class="row aln-center">
        <div class="col-12 col-12-xsmall">
            <h4>Resultado por Preguntas:</h4>
            <table class="table table-resposive table-hover table-sm dt-responsive" id="tablaPreguntasResultados">
                <thead class="thead-light text-center">
                    <tr>
                        <th width="10%" data-priority="1">#</th>
                        <th width="35%">PREGUNTA</th>
                        <th width="35%">TIPO DE PREGUNTA</th>
                        <th width="10%">PROMEDIO</th>
                        <th width="10%">INFORMACIÓN</th>
                    </tr>
                </thead>
                <tbody> </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once('../Layaout/Nav.php');?>
<?php require_once('../Layaout/Footer.php');?>
<div class="modal fade" id="ModalResultado" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div id="tipo_pregunta_1" class="container" style="display:none;">
                    <div class="row">
                        <div class="col-12 centrar_texto col-12-xsmall">
                            <h4>Resultados:</h4>
                            <p id="PreguntaNombre"></p>
                            <canvas id="chartResultado"></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción 1:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion1"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción 2:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion2"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción 3:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion3"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción 4:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion4"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción 5:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion5"></p>
                        </div>
                    </div>
                </div>

                <div id="tipo_pregunta_2" class="container" style="display:none;">
                    <div class="row">
                        <div class="col-12 centrar_texto col-12-xsmall">
                            <h4>Resultados:</h4>
                            <p id="PreguntaNombre2"></p>
                            <canvas id="chartResultado2"></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción SI:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion1B"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción NO:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion2B"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción NO SABE:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion3B"></p>
                        </div>
                    </div>


                </div>

                <div id="tipo_pregunta_3" class="container" style="display:none;">
                    <div class="row">
                        <div class="col-12 centrar_texto col-12-xsmall">
                            <h4>Resultados:</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-12-xsmall">
                            <table class="table table-resposive table-hover table-sm dt-responsive" id="tablaResultadosTipo3">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th width="10%" data-priority="1">#</th>
                                        <th width="45%">CLIENTE</th>
                                        <th width="45%">RESPUESTA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="tipo_pregunta_4" class="container" style="display:none;">
                    <div class="row">
                        <div class="col-12 centrar_texto col-12-xsmall">
                            <h4>Resultados:</h4>
                            <p id="PreguntaNombre4"></p>
                            <canvas id="chartResultado4"></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción MALO:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion14"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción REGULAR:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion24"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción BUENO:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion34"></p>
                        </div>
                    </div>
                    <div class="row aln-center">
                        <div class="col-4 col-12-xsmall">
                            <h5>Opción MUY BUENO:</h5>
                        </div>
                        <div class="col-4 col-12-xsmall">
                            <p id="respuesta_opcion44"></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Proceso/ResultadoEncuesta.js"></script>
