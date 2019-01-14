<!-- Footer -->
<!--<footer id="footer">
        <p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
    </footer>-->
</div>
</div>
<div id="sidebar">
    <div class="inner">
        <!-- Search -->
        <?php
         if(isset($_SESSION['NombreUsuario'])){
        ?>
        <section id="search" class="alt">
            <h3>Bienvenido:</h3>
            <h2>
                <?php echo  $_SESSION['NombreUsuario']; ?>
            </h2>
        </section>
        <?php
         }else{

         }
        ?>
        <nav id="menu">
            <header class="major">
                <h2>Menu</h2>
            </header>
            <ul>
                <li><a href="<?php echo  $conexionConfig->rutaOP().'Vista/Menu/index.php';?>">Inicio</a></li>

                <li> <span class="opener">Gestión de Encuesta</span>
                    <ul>
                        <li><a href="<?php echo  $conexionConfig->rutaOP().'Vista/Proceso/Encuestas.php';?>">Encuestas Generadas</a></li>
                        <li><a href="<?php echo  $conexionConfig->rutaOP().'Vista/Proceso/EnvioEncuesta.php';?>">Envios Realizados</a></li>
                    </ul>
                </li>
                <li> <span class="opener">Mantenimientos</span>
                    <ul>
                        <li><a href="<?php echo  $conexionConfig->rutaOP().'Vista/Mantenimiento/Usuario.php';?>">Usuarios</a></li>
                        <li><a href="<?php echo  $conexionConfig->rutaOP().'Vista/Mantenimiento/Entidad.php';?>">Clientes</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo  $conexionConfig->rutaOP().'Vista/Menu/Logout.php';?>">Salir</a></li>
            </ul>
        </nav>
    </div>
</div>
