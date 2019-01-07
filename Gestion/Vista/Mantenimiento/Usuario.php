<!-- Inicio de Cabecera-->
<?php require_once('../Layaout/Header.php');?>
    <!-- Header -->
    <header id="header">
        <h2>Mantenimiento de Usuarios</h2> </header>
    <section>
        <div class="row aln-center">
            <div class="col-3 off-9 right_element">
                <button class="button primary " onclick="NuevoUsuario();">NUEVO USUARIO</button>
            </div>
        </div>

    <h4>Lista General de Usuario:</h4>
    <div class="row">

         <div class="col-12 col-12-xsmall center_element">
            <table class="table table-resposive w-100 table-hover table-sm dt-responsive nowrap" id="tablaUsuario">
                <thead class="thead-light text-center">
                    <tr>
                        <th data-priority="1">#</th>
                        <th>ESTADO</th>
                        <th>NOMBRE DE USUARIO</th>
                        <th>USUARIO</th>
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
            <div class="modal fade" id="ModalUsuario" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="FormularioUsuario" method="POST" autocomplete="off">
                                <input type="hidden" name="idUsuario" id="idUsuario">
                                <div class="row gtr-uniform">
                                    <div class="col-12 col-12-xsmall center_element">
                                        <h2 id="tituloModalUsuario"></h2>
                                        <hr> </div>
                                    <div class="col-6 col-12-xsmall">
                                        <input class="validarPanel" type="text" name="UsuarioNombre" id="UsuarioNombre" value="" placeholder="Nombre de Usuario" maxlength="150" data-message="- Nombre de Usuario"> </div>
                                    <div class="col-6 col-12-xsmall">
                                        </div>
                                    <div class="col-6 col-12-xsmall">
                                        <input class="validarPanel" type="text" name="UsuarioUsuario" id="UsuarioUsuario" value="" placeholder="Usuario" data-message="- Campo Usuario" maxlength="20"> </div>
                                    <div class="col-6 col-12-xsmall">
                                        <input class="validarPanel" type="text" name="UsuarioPass" id="UsuarioPass" value="" placeholder="Contraseña" data-message="- Campo Contraseña" maxlength="20"> </div>

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
            <script src="<?php echo $conexionConfig->rutaOP(); ?>Vista/js/Mantenimiento/Usuario.js"></script>
