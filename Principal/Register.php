<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
$folder = "Principal";
$pestaña = "Register";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $vEmail = $_POST['email'];
  $vPassword = $_POST['password'];
  $vTipoUsuario = $_POST['tipoUsuario'];
  $vNombreUsuario = $_POST['nombre'];
  if ($vTipoUsuario == 'cliente') {
    $vCategoriaCliente = "Inicial";
  }

  if ($vEmail === '' || $vPassword === '' || $vTipoUsuario === '' || $vNombreUsuario === '') {
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

    if (!isset($errores)) {
        include("../conexion.inc");
        // Verificar si el usuario ya existe
        $vResultado = mysqli_query($link, "SELECT COUNT(*) as cantidad FROM usuario WHERE nombre='$vEmail'");
        $vCantUsuario = mysqli_fetch_assoc($vResultado);
        if ($vCantUsuario['cantidad'] != 0) {
            $errores[] = "El usuario ya existe.";
        } else {
            // Hashear la contraseña antes de guardar
            //$hashedPassword = password_hash($vPassword, PASSWORD_DEFAULT);

            // Insertar usuario en la tabla usuario
            $insertUsuario = mysqli_query($link, "INSERT INTO usuario (nombre, clave, nombre_usuario) VALUES ('$vEmail', '$vPassword', '$vNombreUsuario')");
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
    }else{
    foreach ($errores as $error) {
    echo "<div class='alert alert-danger'>$error</div>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Importar BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />

    <!-- Importar iconos BootStrap -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

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

      <?php include("../Includes/header.php"); ?>

    </header>

    <main style="background-image: url('../Images/Login-Register.jpg')" class="fondo-loginRegister">
      <section class="loginRegister-box">
        <h1>Crear una nueva cuenta</h1>
        <h2>Es rápido y fácil.</h2>
        <form class="formulario-transparente" action="Register.php" method="POST" name="formRegister">

          <p>Nombre</p>
          <input type="text" name="nombre" size="100" placeholder="Nombre" required />

          <p>Mail</p>
          <input type="email" name="email" size="100" placeholder="Correo electrónico" required />

          <p>Contraseña</p>
          <input type="password" name="password" size="8" placeholder="Contraseña" required />

          <p style="text-align: center" class="mb-2">Tipo de usuario</p>
          <div class="d-flex justify-content-center gap-3">
            <input type="radio" class="btn-check" name="tipoUsuario" id="cliente" value="cliente" autocomplete="off" required />
            <label class="btn-radio" for="cliente">Cliente</label>
            <input type="radio" class="btn-check" name="tipoUsuario" id="duenio" value="duenio" autocomplete="off" />
            <label class="btn-radio" for="duenio">Dueño</label>
          </div>

          <input type="submit" name="Login" value="Únete" />
          <a href="Login.php">¿Ya tienes una cuenta?</a>
        </form>
      </section>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

      <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  </body>

</html>