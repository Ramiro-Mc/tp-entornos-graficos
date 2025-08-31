<?php
include_once("../Includes/session.php");
include("../conexion.inc");
include("../Includes/funciones.php");

$mensaje = "";
$folder = "Principal";
$pestaña = "Login";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $vEmail = $_POST['email'];
  $vPassword = $_POST['password'];

  $vResultado = null;
  if ($vEmail === '' || $vPassword === '') {
    $mensaje = "<div class='alert alert-danger'>Completa todos los campos.</div>";
  // } elseif (!filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
  //   $mensaje = "<div class='alert alert-danger'>Email inválido.</div>";
  } else {
    $vResultado = consultaSQL("SELECT cod_usuario, clave FROM usuario WHERE email='$vEmail'");
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
        $resDueno = consultaSQL("SELECT cod_usuario, confirmado FROM dueño_local WHERE cod_usuario=$cod_usuario");
        if ($resDueno && mysqli_num_rows($resDueno) > 0) {
          $estadoDueno = mysqli_fetch_assoc($resDueno)['confirmado'];
          if($estadoDueno == 1){
            $tipo = "dueño";
          } else {
            $mensaje = "<div class='alert alert-warning'>El Administrador aun no confirmo su cuenta</div>";
          }
        }
        $resCliente = consultaSQL("SELECT cod_usuario, confirmado FROM cliente WHERE cod_usuario=$cod_usuario");
        if ($resCliente && mysqli_num_rows($resCliente) > 0) {
          $estadoCliente = mysqli_fetch_assoc($resCliente)['confirmado'];
          if($estadoCliente == 1){
            $tipo = "cliente";
            } else {
              $mensaje = "<div class='alert alert-warning'>Por favor confirma tu cuenta.</div>";  
          }
          
        }

        $_SESSION['tipo_usuario'] = $tipo; 

        if ($tipo == "administrador") {
          header("Location: ../Administrador/SeccionAdministrador.html");
          exit();
        } elseif ($tipo == "dueño") {
          header("Location: ../Dueño/SeccionDueñoLocal.php");
          exit();
        } elseif ($tipo == "cliente") {
          header("Location: ../Principal/Index.php");
          exit();
        } else {
          $mensaje = "<div class='alert alert-warning'>Tipo de usuario no reconocido.</div>";
        }
      } else {
        $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
      }
      mysqli_free_result($vResultado);
    } else {
      $mensaje = "<div class='alert alert-danger'>Usuario no encontrado.</div>";
      if ($vResultado) mysqli_free_result($vResultado);
    }
  }
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Login</title>


</head>


<body>

  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main style="background-image: url('../Images/Login-Register.jpg')" class="fondo-loginRegister">

    <section class="loginRegister-box">
      <h1>Inicio Sesión </h1>
      <?php echo $mensaje; ?>

      <form class="formulario-transparente" action="Login.php" method="POST" name="FormLogin">

        <p>Mail</p>
        <input type="text" name="email" size="100" placeholder="Correo electrónico" required />

        <p>Contraseña</p>
        <div style="position:relative;">
          <input type="password" name="password" id="password" size="8" placeholder="Contraseña" required />
          <span id="togglePassword" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
            <i class="bi bi-eye" id="iconEye"></i>
          </span>
        </div>
        <input type="submit" name="Login" value="Login" />
        <a href="Register.php"><button type="button">Registrarse</button></a>

        <a href="#">¿Olvido su contraseña?</a>
      </form>

    </section>

  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  <script>
  document.getElementById('togglePassword').addEventListener('click', function () {
  const passwordInput = document.getElementById('password');
  const icon = document.getElementById('iconEye');
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text'; //La pasa a texto y se ve
    icon.classList.remove('bi-eye');
    icon.classList.add('bi-eye-slash');
  } else {
    passwordInput.type = 'password'; //La pasa a password y no se ve
    icon.classList.remove('bi-eye-slash');
    icon.classList.add('bi-eye');
  }
});
</script>

</body>

</html>