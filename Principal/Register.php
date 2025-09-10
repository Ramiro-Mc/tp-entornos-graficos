<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
sesionIniciada();
$folder = "Principal";
$pestaña = "Register";
$token = bin2hex(random_bytes(32));
$mensaje = "";



//Php mailer

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $vEmail = $_POST['email'];
  $vPassword = $_POST['password'];
  $vTipoUsuario = $_POST['tipoUsuario'];
  $vNombreUsuario = $_POST['nombre'];

  /* validaciones */

  if ($vEmail === '' || $vPassword === '' || $vTipoUsuario === '' || $vNombreUsuario === '') {
    $mensaje = "<div class='alert alert-danger'>Completa todos los campos.</div>";
  }
  if (!filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
    $mensaje = "<div class='alert alert-danger'>Email inválido.</div>";
  }
  if (strlen($vPassword) < 8) {
    $mensaje = "<div class='alert alert-danger'>La contraseña debe tener al menos 8 caracteres.</div>";
  }
  if (!in_array($vTipoUsuario, ['cliente', 'duenio'])) {
    $mensaje = "<div class='alert alert-danger'>Tipo de usuario inválido.</div>";
  }

  /* registro en base de datos */

  if ($mensaje === "") {
    include("../conexion.inc");

    $vResultado = mysqli_query($link, "SELECT COUNT(*) as cantidad FROM usuario WHERE email='$vEmail'");
    $vCantUsuario = mysqli_fetch_assoc($vResultado);

    if ($vCantUsuario['cantidad'] != 0) {
      $mensaje = "<div class='alert alert-danger'>El usuario ya existe.</div>";
    } else {
      // Hashear la contraseña antes de guardar
      $hashedPassword = password_hash($vPassword, PASSWORD_DEFAULT);

      // Insertar usuario en la tabla usuario
      $insertUsuario = mysqli_query($link, "INSERT INTO usuario (email, clave, nombre_usuario) VALUES ('$vEmail', '$hashedPassword', '$vNombreUsuario')");
      if ($insertUsuario) {
        $vCodUsuario = mysqli_insert_id($link);
        if ($vTipoUsuario == 'cliente') {
          $vCategoriaCliente = "Inicial";
          mysqli_query($link, "INSERT INTO cliente (cod_usuario, categoria_cliente, confirmado, token_confirmacion) VALUES ('$vCodUsuario', '$vCategoriaCliente', 0, '$token')");

          //Mandamos mail de confirmacion 

          /* $enlace = "http://localhost/Repositorio/tp-entornos-graficos/Principal/Confirmar.php?token=$token"; */
          $enlace = "http://localhost/paginas/tp-entornos-graficos/Principal/Confirmar.php?token=$token";
          $asunto = "Confirma tu cuenta";
          $mensajeMail = "
            <div style='font-family: Arial, sans-serif; background: #f9f9f9; padding: 24px; border-radius: 8px; color: #222;'>
              <h2 style='color: #2c3e50;'>¡Bienvenido a Viventa Store, $vNombreUsuario!</h2>
              <hr style='border: none; border-top: 1px solid #eee; margin: 16px 0;'/>
              <p>Gracias por registrarte. Para activar tu cuenta, por favor haz clic en el siguiente botón:</p>
              <div style='margin: 24px 0;'>
                <a href='$enlace' style='display: inline-block; background: #2c3e50; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;'>
                  Confirmar cuenta
                </a>
              </div>
              <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
              <div style='background: #fff; border: 1px solid #eee; padding: 10px; border-radius: 6px; color: #444; word-break: break-all;'>
                $enlace
              </div>
              <hr style='border: none; border-top: 1px solid #eee; margin: 24px 0 8px 0;'/>
              <p style='font-size: 0.95em; color: #888;'>Este mensaje fue enviado automáticamente desde Viventa Store.</p>
            </div>
          ";

          $mail = new PHPMailer(true);

          try {
            //Server settings
            /* $mail->SMTPDebug = SMTP::DEBUG_SERVER;  */                     //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'viventastore@gmail.com';                     //SMTP username
            $mail->Password   = 'vfpm zaxi qbws oyub';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('viventastore@gmail.com', 'Viventa Store');
            $mail->addAddress($vEmail, $vNombreUsuario);     //Add a recipient
            $mail->addReplyTo('viventastore@gmail.com', 'Information');

            /* 
            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensajeMail;
            $mail->AltBody = $mensajeMail;

            $mail->send();
            $mensaje = "<div class='alert alert-success'>Su solicitud de registro fue enviada. Esperando confirmación por correo.</div>";
          } catch (Exception $e) {
            $mensaje = "<div class='alert alert-danger'>No se pudo enviar el correo de confirmación. Error: {$mail->ErrorInfo}</div>";
          }
        } elseif ($vTipoUsuario == 'duenio') {
          mysqli_query($link, "INSERT INTO dueño_local (cod_usuario, estado) VALUES ('$vCodUsuario', 'pendiente')");
          $mensaje = "<div class='alert alert-warning'>Se registro como dueño de local. Pendiente de aprobación.</div>";
        }
      } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar usuario.</div>";
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

  <?php include("../Includes/head.php"); ?>

  <title>Register</title>

</head>

<body>

  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main style="background-image: url('../Imagenes/Fondo.jpg')" class="fondo-loginRegister">
    <section class="loginRegister-box">
      <h1>Crear una nueva cuenta</h1>
      <h2>Es rápido y fácil.</h2>
      <?php echo $mensaje; ?>
      <form class="formulario-transparente" action="Register.php" method="POST" name="formRegister">

        <p>Nombre</p>
        <input type="text" name="nombre" size="100" placeholder="Nombre" required />

        <p>Mail</p>
        <input type="email" name="email" size="100" placeholder="Correo electrónico" required />

        <p>Contraseña</p>
        <div style="position:relative;">
          <input type="password" name="password" id="password" size="8" placeholder="Contraseña" required />
          <span id="togglePassword" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
            <i class="bi bi-eye" id="iconEye"></i>
          </span>
        </div>

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

  <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
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