<?php
include_once("../Includes/session.php");
include("../conexion.inc");
include("../Includes/funciones.php");
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vEmail = $_POST['email'];
    $vPassword = $_POST['password'];

    if ($vEmail === '' || $vPassword === '') {
        $mensaje = "<div class='alert alert-danger'>Completa todos los campos.</div>";
    } elseif (!filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "<div class='alert alert-danger'>Email inválido.</div>";
    } else {
        $vResultado = consultaSQL("SELECT cod_usuario, clave FROM usuario WHERE nombre='$vEmail'");
    }

    if ($vResultado && mysqli_num_rows($vResultado) > 0) {
        $usuario = mysqli_fetch_assoc($vResultado);
        if ($usuario['clave'] === $vPassword ) {
          // if (password_verify($vPassword, $usuario['clave'])) { IMPLEMENTARLO DESPUES (ES PARA HASHEAR LAS CONTRASEÑAS)
            $cod_usuario = $usuario['cod_usuario'];
            $_SESSION['cod_usuario'] = $cod_usuario; 

            $tipo = "desconocido";

            $resAdmin = consultaSQL("SELECT cod_usuario FROM administrador WHERE cod_usuario=$cod_usuario");

            if ($resAdmin && mysqli_num_rows($resAdmin) > 0) {
                $tipo = "administrador";
            }
            $resDueno = consultaSQL("SELECT cod_usuario FROM dueño_local WHERE cod_usuario=$cod_usuario");
            if ($resDueno && mysqli_num_rows($resDueno) > 0) {
                $tipo = "dueño";
            }
            $resCliente = consultaSQL("SELECT cod_usuario FROM cliente WHERE cod_usuario=$cod_usuario");
            if ($resCliente && mysqli_num_rows($resCliente) > 0) {
                $tipo = "cliente";
            }

            $_SESSION['tipo_usuario'] = $tipo; 

            if ($tipo == "administrador") {
                header("Location: ../Administrador/SeccionAdministrador.html");
                exit();
            } elseif ($tipo == "dueño") {
                header("Location: ../Dueño/SeccionDueñoLocal.php");
                exit();
            } elseif ($tipo == "cliente") {
                header("Location: ../Cliente/SeccionCliente.php");
                exit();
            } else {
                $mensaje = "<div class='alert alert-warning'>Tipo de usuario no reconocido.</div>";
            }
        } else {
            $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Usuario no encontrado.</div>";
    }

    mysqli_free_result($vResultado);
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Importar BootStrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />
    <!-- Importar iconos BootStrap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <!-- Metadatos -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=, initial-scale=1.0" />
    <link rel="stylesheet" href="../Styles/style.css" />
    <link rel="stylesheet" href="../styles/style-general.css" />
    <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
    <title>Login</title>
  </head>
  <body>

    <header>

      <?php

      $folder = "Principal";
      $pestaña = "Login";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>

    </header>

    <main
      style="background-image: url('../Images/Login-Register.jpg')"
      class="fondo-loginRegister"
    >
      <section class="loginRegister-box">
        <h1>Inicio Sesión</h1>
        <?php echo $mensaje; ?>
        <form
          class="formulario-transparente"
          action="Login.php"
          method="POST"
          name="FormLogin"
        >
          <p>Mail</p>
          <input
            type="text"
            name="email"
            size="100"
            placeholder="Correo electrónico"
            required
          />
          <p>Contraseña</p>
          <input
            type="password"
            name="password"
            size="8"
            placeholder="Contraseña"
            required
          />
          <input type="submit" name="Login" value="Login" />
          <a href="Register.php">
            <button type="button">Registrarse</button>
          </a>
          <a href="#">¿Olvido su contraseña?</a>
        </form>
      </section>
    </main>
    <footer
      class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4"
    >
      <div class="d-flex w-100 justify-content-center gap-5 px-5">
        <div
          class="iconos-redes-sociales d-flex flex-column gap-2 texto-footer"
        >
          <h5 class="text-center">Redes Sociales</h5>
          <div class="d-flex gap-3">
            <a
              href="https://www.instagram.com"
              target="_blank"
              rel="noopener noreferrer"
            >
              <i class="bi bi-instagram fs-4"></i>
            </a>
            <a
              href="https://www.facebook.com/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <i class="bi bi-facebook fs-4"></i>
            </a>
            <a
              href="https://www.whatsapp.com/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <i class="bi bi-whatsapp fs-4"></i>
            </a>
            <a
              href="https://www.youtube.com/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <i class="bi bi-youtube fs-4"></i>
            </a>
          </div>
        </div>
        <nav class="texto-footer">
          <h5>Mapa del sitio</h5>
          <div class="mb-2"><a href="Index.html">Inicio</a></div>
          <div class="mb-2"><a href="#">Locales</a></div>
          <div class="mb-2"><a href="#">Novedades</a></div>
          <div class="mb-2"><a href="Contacto.html">Contacto</a></div>
          <div class="mb-2">
            <a href="SobreNosotros.html">Sobre Nosotros</a>
          </div>
        </nav>
        <section class="texto-footer">
          <h5>Contacto</h5>
          <p>Email: <a href="#">contacto@viventastore.com</a></p>
          <p>Teléfono: <a href="#">+54 9 11 2345-6789</a></p>
          <p>Dirección: Calle 123, Ciudad</p>
        </section>
      </div>
      <p class="texto-footer text-center">
        © 2025 Viventa Store. Todos los derechos reservados.
      </p>
    </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>