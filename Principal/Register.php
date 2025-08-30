<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $vEmail = $_POST['email'];
  $vPassword = $_POST['password'];
  $vTipoUsuario = $_POST['tipoUsuario'];
  if ($vTipoUsuario == 'cliente') {
    $vCategoriaCliente = "Inicial";
  }

  if ($vEmail === '' || $vPassword === '' || $vTipoUsuario === '') {
    $errores[] = "Completa todos los campos.";
  }
  if (!filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Email inválido.";
  }
  if (strlen($vPassword) < 8) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres.";
  }
  if (!in_array($vTipoUsuario, ['cliente', 'duenio'])) {
    $errores[] = "Tipo de usuario inválido.";
  }

    if (!$errores) {
        include("../conexion.inc");
        // Verificar si el usuario ya existe
        $vResultado = mysqli_query($link, "SELECT COUNT(*) as cantidad FROM usuario WHERE nombre='$vEmail'");
        $vCantUsuario = mysqli_fetch_assoc($vResultado);
        if ($vCantUsuario['cantidad'] != 0) {
            $errores[] = "El usuario ya existe.";
        } else {
            // Hashear la contraseña antes de guardar
            $hashedPassword = password_hash($vPassword, PASSWORD_DEFAULT);

            // Insertar usuario en la tabla usuario
            $insertUsuario = mysqli_query($link, "INSERT INTO usuario (nombre, clave) VALUES ('$vEmail', '$hashedPassword')");
            if ($insertUsuario) {
                $vCodUsuario = mysqli_insert_id($link);
                if ($vTipoUsuario == 'cliente') {
                    $vCategoriaCliente = "Inicial";
                    mysqli_query($link, "INSERT INTO cliente (cod_usuario, categoria_cliente) VALUES ('$vCodUsuario', '$vCategoriaCliente')");
                } elseif ($vTipoUsuario == 'duenio') {
                    mysqli_query($link, "INSERT INTO dueño_local (cod_usuario) VALUES ('$vCodUsuario')");
                }
                $mensaje = "<div class='alert alert-success'>El usuario fue registrado.</div>";
            } else {
                $errores[] = "Error al registrar usuario.";
            }
        }
        if ($vResultado) {
            mysqli_free_result($vResultado);
        }
        mysqli_close($link);
    }
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
    <title>Register</title>
  </head>
  <body>

    <header>

      <?php

      $folder = "Principal";
      $pestaña = "Register";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>
      

    </header>

    <main
      style="background-image: url('../Images/Login-Register.jpg')"
      class="fondo-loginRegister"
    >
      <section class="loginRegister-box">
        <h1>Crear una nueva cuenta</h1>
        <h2>Es rápido y fácil.</h2>
        <form
          class="formulario-transparente"
          action="Register.php"
          method="POST"
          name="formRegister"
        >
          <p>Mail</p>
          <input
            type="email"
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
          <p style="text-align: center" class="mb-2">Tipo de usuario</p>
          <div class="d-flex justify-content-center gap-3">
            <input
              type="radio"
              class="btn-check"
              name="tipoUsuario"
              id="cliente"
              value="cliente"
              autocomplete="off"
              required
            />
            <label class="btn-radio" for="cliente">Cliente</label>

            <input
              type="radio"
              class="btn-check"
              name="tipoUsuario"
              id="duenio"
              value="duenio"
              autocomplete="off"
            />
            <label class="btn-radio" for="duenio">Dueño</label>
          </div>
          <input type="submit" name="Login" value="Únete" />
          <a href="Login.php">¿Ya tienes una cuenta?</a>
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
