<?php 
include_once("session.php");
include_once("../functions/funciones.php");

if(isset($_SESSION['tipo_usuario'])){
  $tipo_usuario = $_SESSION['tipo_usuario'];
  $estaLogueado = "logueado";

  $cod_usuario = $_SESSION['cod_usuario'];
  $res = consultaSQL("SELECT nombre FROM usuario WHERE cod_usuario = '$cod_usuario'");
  $row = mysqli_fetch_assoc($res); 
  $vnombre_usuario = $row['nombre'] ?? ''; 

}else{
  $estaLogueado = "noLogueado";
}

if($pestaña == "Login" or $pestaña == "Register"){
  $estaLogueado = "logueandose";
}

if ( $folder == "Admin" or $folder == "Cliente" or $folder == "DueñoLocal" or $folder == "Principal"){
  $rutaSalirCarpeta = "..";
} else {
  $rutaSalirCarpeta = ".";
}


?>



<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid top-bar">

    <!-- Logo y boton de desplegado de menu (igual para todas las pestañas) -->

      <a class="navbar-brand" href="<?= $rutaSalirCarpeta ?>/Principal/Index.php">
        <img
          class="logo"
          src="<?= $rutaSalirCarpeta ?>/Images/Logo.png"
          alt="Logo de la pagina web"
        />
      </a>

      <button class="navbar-toggler boton-menu"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
    
    <!-- Fin Logo y boton de desplegado de menu -->


    <div class="collapse navbar-collapse flex-direction-row justify-content-end colapsado" id="navbarNav">

      <ul class="navbar-nav">

        <!-- Opciones para homepage -->

          <?php if($pestaña == "homepage"): ?>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#locales">
                <p>Locales</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#novedades">
                <p>Novedades</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#promociones">
                <p>Promociones</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="<?= $rutaSalirCarpeta ?>/Principal/Contacto.php">
                <p>Contacto</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $rutaSalirCarpeta ?>/Principal/SobreNosotros.php">
                <p>Sobre Nosotros</p>
              </a>
            </li>

          <?php endif; ?>

        <!-- Fin de opciones para la homepage -->

        <!-- Opciones por si esta logueado -->

          <?php if($estaLogueado == "logueado"): ?>

            <li class="nav-item">
              <p style="color:white">Bienvenido! <?= $vnombre_usuario ?></p> 
            </li>
            <li class="nav-item">
              <a href="<?= $rutaSalirCarpeta ?>/Principal/CerrarSesion.php">Cerrar sesion</a>
            </li>

          <?php endif; ?>

        <!-- Fin de opciones por si esta logueado -->

        <!-- Opciones por si no esta logueado -->

          <?php if($estaLogueado == "noLogueado"): ?>

            <li class="nav-item">
              <a href="<?= $rutaSalirCarpeta ?>/Principal/Login.php">
                <button type="button" class="boton-nav btn btn-light">
                  Iniciar sesion
                </button>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $rutaSalirCarpeta ?>/Principal/Register.php">
                <button type="button" class="boton-nav btn btn-light">
                  Registrar
                </button>
              </a>
            </li>

          <?php endif; ?>

        <!-- Fin de Opciones por si no esta logueado -->

      </ul>
    </div>
  </div>
</nav>