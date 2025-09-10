<?php
include_once("session.php");
include_once("../Includes/funciones.php");
sesionIniciada();
$rutaExtra = "";

if (isset($_SESSION['tipo_usuario']) && isset($_SESSION['cod_usuario'])) {
  $tipo_usuario = $_SESSION['tipo_usuario'];
  $estaLogueado = "logueado";

  $cod_usuario = $_SESSION['cod_usuario'];
  $res = consultaSQL("SELECT nombre_usuario FROM usuario WHERE cod_usuario = '$cod_usuario'");
  $row = mysqli_fetch_assoc($res);
  $vnombre_usuario = $row['nombre_usuario'] ?? '';

  if ($_SESSION['tipo_usuario'] == "cliente") {
    $res = consultaSQL("SELECT categoria_cliente FROM cliente WHERE cod_usuario = '$cod_usuario'");
    $row = mysqli_fetch_assoc($res);
    $categoria_cliente = $row['categoria_cliente'] ?? '';
  }

  if ($_SESSION['tipo_usuario'] == "administrador") {
    $rutaExtra = "/Administrador/SeccionAdministrador.php";
    $LinkExtra = "Seccion Administrador";
  }
  if ($_SESSION['tipo_usuario'] == "dueño") {
    $rutaExtra = "/Dueño/SeccionDueñoLocal.php";
    $LinkExtra = "Seccion Dueño";
  }
} else {
  $estaLogueado = "noLogueado";
}

if ($pestaña == "Login" or $pestaña == "Register") {
  $estaLogueado = "logueandose";
}

if ($folder == "Administrador" or $folder == "Cliente" or $folder == "Dueño" or $folder == "Principal") {
  $rutaSalirCarpeta = "..";
} else {
  $rutaSalirCarpeta = ".";
}

if ($folder == "Administrador") {
  $rutaLogo = "/Administrador/SeccionAdministrador.php";
} elseif ($folder == "Dueño") {
  $rutaLogo = "/Dueño/SeccionDueñoLocal.php";
} else {
  $rutaLogo = "/Principal/Index.php";
}


?>



<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid top-bar">

    <!-- Logo y boton de desplegado de menu (igual para todas las pestañas) -->

    <a class="navbar-brand" href="<?= $rutaSalirCarpeta ?><?= $rutaLogo ?>">
      <img class="logo" src="<?= $rutaSalirCarpeta ?>/Imagenes/Logo-titulo.png" alt="Logo de la pagina web" />
    </a>

    <button class="navbar-toggler boton-menu" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Fin Logo y boton de desplegado de menu -->


    <div class="collapse navbar-collapse flex-direction-row justify-content-end colapsado" id="navbarNav">

      <ul class="navbar-nav">

        <!-- Opciones para Index -->

        <?php if ($pestaña == "Index"): ?>

          <?php if ($rutaExtra != ""): ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="<?= $rutaSalirCarpeta ?><?= $rutaExtra ?>">
                <p><?= $LinkExtra ?></p>
              </a>
            </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#novedades">
              <p>Novedades</p>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#locales">
              <p>Locales</p>
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

          <?php if ($estaLogueado == "noLogueado"): ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#promociones">
                <p>Promociones</p>
              </a>
            </li>
          <?php endif; ?>
        <?php endif; ?>



        <!-- Fin de opciones para la homepage -->

        <!-- Opciones por si esta logueado -->

        <?php if ($estaLogueado == "logueado"): ?>

          <!-- Categoria de cliente -->

          <?php if ($tipo_usuario == "cliente"): ?>

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="<?= $rutaSalirCarpeta ?>/Cliente/BuscarPromociones.php">
                <p>¡Usar Promociones!</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="<?= $rutaSalirCarpeta ?>/Cliente/MisSolicitudesDePromociones.php">
                <p>Mis Solicitudes De Promociones</p>
              </a>
            </li>

            <li class="nav-item">
              <p style="color:white">Bienvenido! <a href="<?= $rutaSalirCarpeta ?>/Cliente/MiPerfil.php"><?= $vnombre_usuario ?></a></p>
            </li>

            <li class="nav-item">
              <img style="" class="imagen_categoria_cliente" src="<?= $rutaSalirCarpeta ?>/Imagenes/categoria-<?= $categoria_cliente ?>.png" alt="Categoria cliente <?= $categoria_cliente ?>">
            </li>

          <?php else: ?>

            <li class="nav-item">
              <p style="color:white">Bienvenido! <b><?= $vnombre_usuario ?></b></p>
            </li>

          <?php endif; ?>

          <!-- Fin de Categoria de cliente  -->


          <li class="nav-item">

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cerrar-sesion">cerrar sesion</button>

          </li>

        <?php endif; ?>

        <!-- Modal de eliminacion -->

        <div class="modal fade " id="cerrar-sesion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header ">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="margin: auto; font-size: 1.6rem;">Cerrando sesion</h1>
              </div>
              <div class="modal-body text-center">
                <p style="font-size: 1.2rem; color:black;">¿Seguro que quiere cerrar sesion?</p>
              </div>
              <div class="modal-footer d-flex justify-content-around">
                <a style="margin-left: 5px;" href="<?= $rutaSalirCarpeta ?>/Principal/CerrarSesion.php">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar sesion</button>
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Fin del Modal de eliminacion -->

        <!-- Fin de opciones por si esta logueado -->

        <!-- Opciones por si no esta logueado -->

        <?php if ($estaLogueado == "noLogueado" && $pestaña != "Confirmar"): ?>

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