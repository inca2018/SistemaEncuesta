<?php
    if(isset($_POST['idEntidad'])){

    }else{
        header('Location: Entidad.php');
    }
?>
    <!-- Inicio de Cabecera-->
    <?php require_once('../Layaout/Header.php');?>
        <!-- Header -->
        <header id="header">
            <h2>Mantenimiento de Clientes</h2> </header>
        <section>
            <input type="hidden" id="idEntidad" value="<?php echo $_POST['idEntidad']; ?>">
            <div class="row">
                <div class="col-6 col-12-xsmall">
                    <h4>RUC:</h4>
                    <p id="EntidadRUC"></p>
                </div>
                <div class="col-6 col-12-xsmall">
                    <h4>Entidad:</h4>
                    <p id="EntidadNombre"></p>
                </div>
            </div>
            <hr>
            <div class="row aln-center">
                <div class="col-3 col-12-xsmall">
                    <button class="button secondary" onclick="volver();">VOLVER</button>
                </div>
                <div class="col-3 off-6 right_element col-12-xsmall">
                    <button class="button primary" onclick="NuevoCliente();">NUEVO CLIENTE</button>
                </div>
            </div>
               <hr>
            <h4>Lista General de Cliente:</h4>
            <div class="row">
                <div class="col-12 col-12-xsmall center_element">
                    <table class="table table-resposive w-100 table-hover table-sm  nowrap" id="tablaCliente">
                        <thead class="thead-light text-center">
                            <tr>
                                <th width="5%" data-priority="1">#</th>
                                <th width="10%">ESTADO</th>
                                <th width="20%">CONTACTO</th>
                                <th width="20%">CORREO CONTACTO</th>
                                <th width="15%">CARGO</th>
                                <th width="10%">FECHA DE REGISTRO</th>
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
                <div class="modal fade" id="ModalCliente" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form id="FormularioCliente" method="POST" autocomplete="off">
                                    <input type="hidden" name="idCliente" id="idCliente">
                                    <div class="row gtr-uniform">
                                        <div class="col-12 col-12-xsmall center_element">
                                            <h2 id="tituloModalCliente"></h2>
                                            <hr> </div>
                                        <div class="col-6 col-12-xsmall">
                                            <input class="validarPanel" type="text" name="ClienteContacto" id="ClienteContacto" value="" placeholder="Contacto" data-message="- Campo Nombre del Contacto" maxlength="150"> </div>
                                        <div class="col-6 col-12-xsmall">
                                            <input class="validarPanel" type="email" name="ClienteCorreo" id="ClienteCorreo" value="" placeholder="Correo de Contacto" data-message="- Campo Correo del Contacto" maxlength="150"> </div>
                                        <div class="col-6 col-12-xsmall">
                                            <input class="validarPanel" type="text" name="ClienteCargo" id="ClienteCargo" value="" placeholder="Cargo" data-message="- Campo Cargo del Contacto" maxlength="150"> </div>
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
                <script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Mantenimiento/Cliente.js"></script>
