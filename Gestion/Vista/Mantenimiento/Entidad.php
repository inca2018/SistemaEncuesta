<!-- Inicio de Cabecera-->
<?php require_once('../Layaout/Header.php');?>
    <!-- Header -->
    <header id="header">
        <h2>Mantenimiento de Entidades</h2> </header>
    <section>
        <div class="row aln-center">
            <div class="col-3 off-9 right_element">
                <button class="button primary " onclick="NuevoEntidad();">NUEVA ENTIDAD</button>
            </div>
        </div>
        <h4>Lista General de Entidades:</h4>
        <div class="row">
            <div class="col-12 col-12-xsmall center_element">
                <table class="table table-resposive w-100 table-hover table-sm dt-responsive nowrap" id="tablaEntidad">
                    <thead class="thead-light text-center">
                        <tr>
                            <th data-priority="1">#</th>
                            <th>ESTADO</th>
                            <th>RUC</th>
                            <th>RAZON SOCIAL</th>
                            <th>DIRECCION</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php require_once('../Layaout/Nav.php');?>
        <?php require_once('../Layaout/Footer.php');?>
            <div class="modal fade" id="ModalEntidad" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="FormularioEntidad" method="POST" autocomplete="off">
                                <input type="hidden" name="idEntidad" id="idEntidad">
                                <div class="row gtr-uniform">
                                    <div class="col-12 col-12-xsmall center_element">
                                        <h2 id="tituloModalEntidad"></h2>
                                        <hr> </div>
                                    <div class="col-6 col-12-xsmall">
                                        <input class="validarPanel" type="text" name="EntidadRazonSocial" id="EntidadRazonSocial" value="" placeholder="Razón Social" maxlength="150" data-message="- Campo Razón Social"> </div>
                                    <div class="col-6 col-12-xsmall">
                                        <input class="validarPanel" type="text" name="EntidadRUC" id="EntidadRUC" value="" placeholder="RUC" onkeypress="return SoloNumerosModificado(event,11,this.id);" data-message="- Campo RUC"> </div>
                                    <!-- Break -->
                                    <div class="col-12">
                                        <textarea class="validarPanel" name="EntidadDireccion" id="EntidadDireccion" placeholder="Ingrese Dirección" rows="6" data-message="- Campo  Dirección de Entidad"></textarea>
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
            <script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Mantenimiento/Entidad.js"></script>
