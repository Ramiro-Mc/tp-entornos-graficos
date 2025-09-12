<?php
include_once("../Includes/session.php");
include("../conexion.inc");
include("../Includes/funciones.php");



sesionIniciada();
$mensaje = "";
$folder = "Principal";
$pestaña = "Login";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $vEmail = $_POST['email'];
  $vPassword = $_POST['password'];

  $vResultado = null;
  if ($vEmail === '' || $vPassword === '') {
    $mensaje = "<div class='alert alert-danger'>Completa todos los campos.</div>";
  } else {
    $vResultado = consultaSQL("SELECT cod_usuario, clave  FROM usuario WHERE email='$vEmail'");
    if ($vResultado && mysqli_num_rows($vResultado) > 0) {
      $usuario = mysqli_fetch_assoc($vResultado);
      $contraseñaBD = $usuario['clave'];
      if (password_verify($vPassword, $contraseñaBD)) {
        $cod_usuario = $usuario['cod_usuario'];
        $_SESSION['cod_usuario'] = $cod_usuario;


        $tipo = "desconocido";

        $resAdmin = consultaSQL("SELECT cod_usuario FROM administrador WHERE cod_usuario=$cod_usuario");
        if ($resAdmin && mysqli_num_rows($resAdmin) > 0) {
          $tipo = "administrador";
        }
        $resDueno = consultaSQL("SELECT cod_usuario FROM dueño_local WHERE cod_usuario=$cod_usuario");
        //and estado='aprobado'
        if ($resDueno && mysqli_num_rows($resDueno) > 0) {
          $estadoDueno = mysqli_fetch_assoc($resDueno)['estado'];
          if ($estadoDueno == 'rechazado') {
            $mensaje = "<div class='alert alert-warning'>El Administrador rechazó tu solicitud. Porfavor comuniquese con soporte</div>";
          }
          if ($resDueno && mysqli_num_rows($resDueno) > 0) {
            $tipo = "dueño";
          }
        }

        $resCliente = consultaSQL("SELECT cod_usuario FROM cliente WHERE cod_usuario=$cod_usuario AND confirmado= '1'");
        if ($resCliente && mysqli_num_rows($resCliente) > 0) {
          $tipo = "cliente";
        }

        if (isset($_POST['mantenerSesionIniciada']) && $_POST['mantenerSesionIniciada'] === 'si') {
          setcookie('usuario_recordado', $cod_usuario, time() + (60 * 60 * 24 * 365), "/");
          setcookie('tipo_usuario_recordado', $tipo, time() + (60 * 60 * 24 * 365), "/");
        }

        $_SESSION['tipo_usuario'] = $tipo;

        if ($tipo == "administrador") {
          header("Location: ../Administrador/SeccionAdministrador.php");
          exit();
        } elseif ($tipo == "dueño") {
          header("Location: ../Dueño/SeccionDueñoLocal.php");
          exit();
        } elseif ($tipo == "cliente") {
          header("Location: ../Principal/Index.php");
          exit();
        } else {
          $mensaje = "<div class='alert alert-warning'>Tipo de usuario no reconocido o pendiente de confirmacion.</div>";
        }
      } else {
        $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
      }
      mysqli_free_result($vResultado);
    } else {
      $mensaje = "<div class='alert alert-danger'>Usuario no encontrado.</div>";
      if ($vResultado) mysqli_free_result($vResultado);
    }

    mysqli_close($link);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Iniciar sesión</title>
</head>

<body>

  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main style="background-image: url('../Imagenes/Fondo.jpg')" class="fondo-loginRegister pb-5 pt-5" aria-label="Página de inicio de sesión">

    <section class="loginRegister-box" aria-label="Formulario de inicio de sesión">
      <h1>Inicio Sesión </h1>
      <?php echo $mensaje; ?>

      <form class="formulario-transparente" action="InicioSesion.php" method="POST" name="FormLogin" aria-label="Formulario para iniciar sesión">

        <label for="email" style="display:block;">Mail</label>
        <input type="text" id="email" name="email" size="100" placeholder="ejemplo@correo.com" required aria-label="Correo electrónico" />

        <label for="password" style="display:block;">Contraseña</label>
        <div style="position:relative;">
          <input type="password" name="password" id="password" size="8" placeholder="********" required aria-label="Contraseña" />
          <span id="togglePassword" style="position:absolute; right:8px; top:40%; transform:translateY(-50%); cursor:pointer;" aria-label="Mostrar u ocultar contraseña" tabindex="0" role="button">
            <i class="bi bi-eye" id="iconEye"></i>
          </span>
        </div>

        <div class="contenedor-recuerdame">
          <label style="font-size: 0.9rem; user-select: none;" class="form-check-label" for="mantenerSesionIniciada">Recuérdame</label>
          <input type="checkbox" class="checkbox-recordar" id="mantenerSesionIniciada" name="mantenerSesionIniciada" value="si" aria-label="Mantener sesión iniciada">
        </div>

        <input type="submit" name="Login" value="Login" aria-label="Iniciar sesión" />
        <a href="Registrar.php"><button type="button" style="color: black" aria-label="Ir a registro">Registrarse</button></a>

        <a href="#" aria-label="Recuperar contraseña">¿Olvidó su contraseña?</a>
      </form>

    </section>

  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('iconEye');
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          passwordInput.type = 'password';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      });
    });
  </script>
</body>

</html>