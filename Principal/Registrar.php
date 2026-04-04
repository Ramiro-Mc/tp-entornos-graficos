<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
require_once("../Includes/env.php");
load_env(dirname(__DIR__) . '/.env');
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
  $smtpHost = env('SMTP_HOST', 'smtp.gmail.com');
  $smtpPort = (int) env('SMTP_PORT', '465');
  $smtpUser = env('SMTP_USERNAME', '');
  $smtpPass = env('SMTP_PASSWORD', '');
  $smtpFromName = env('SMTP_FROM_NAME', 'Viventa Store');
  $appUrl = rtrim(env('APP_URL', ''), '/');
  $smtpEncryption = strtolower(env('SMTP_ENCRYPTION', 'smtps'));
  $smtpSecure = $smtpEncryption === 'starttls'
    ? PHPMailer::ENCRYPTION_STARTTLS
    : PHPMailer::ENCRYPTION_SMTPS;

  if ($appUrl === '') {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $isHttps ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $projectBasePath = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
    $appUrl = $scheme . '://' . $host . $projectBasePath;
  }

  $vEmail = $_POST['email'];
  $vPassword = $_POST['password'];
  $vTipoUsuario = $_POST['tipoUsuario'];
  $vNombreUsuario = $_POST['nombre'];

  /* validaciones */
  if ($vEmail === '' || $vPassword === '' || $vTipoUsuario === '' || $vNombreUsuario === '') {
    $mensaje = "<div class='alert alert-danger'>Completa todos los campos.</div>";
  } elseif (!filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
    $mensaje = "<div class='alert alert-danger'>Email inválido.</div>";
  } elseif (strlen($vPassword) < 8) {
    $mensaje = "<div class='alert alert-danger'>La contraseña debe tener al menos 8 caracteres.</div>";
  } elseif (!in_array($vTipoUsuario, ['cliente', 'duenio'])) {
    $mensaje = "<div class='alert alert-danger'>Tipo de usuario inválido.</div>";
  }

  /* registro en base de datos */
  if ($mensaje === "") {
    include("../Includes/conexion.inc");

    // 1. Verificamos si el correo ya está registrado
    $vResultado = mysqli_query($link, "SELECT COUNT(*) as cantidad FROM usuario WHERE email='$vEmail'");
    $vCantUsuario = mysqli_fetch_assoc($vResultado);

    if ($vCantUsuario['cantidad'] != 0) {
      $mensaje = "<div class='alert alert-danger'>El usuario ya existe con ese correo.</div>";
    } else {
      // 2. Hasheamos la contraseña por seguridad
      $hashedPassword = password_hash($vPassword, PASSWORD_DEFAULT);

      // 3. Insertamos SIEMPRE primero en la tabla padre: 'usuario'
      $queryUsuario = "INSERT INTO usuario (email, clave, nombre_usuario) VALUES ('$vEmail', '$hashedPassword', '$vNombreUsuario')";
      $insertUsuario = mysqli_query($link, $queryUsuario);
      
      if ($insertUsuario) {
        // Obtenemos el ID que se acaba de generar para usarlo en las tablas hijas
        $vCodUsuario = mysqli_insert_id($link);
        
        // --- FLUJO CLIENTE ---
        if ($vTipoUsuario == 'cliente') {
          $vCategoriaCliente = "Inicial";
          
          // Insertamos en la tabla 'cliente' según tu diagrama
          $queryCliente = "INSERT INTO cliente (cod_usuario, categoria_cliente, confirmado, token_confirmacion) VALUES ('$vCodUsuario', '$vCategoriaCliente', 0, '$token')";
          mysqli_query($link, $queryCliente);

          // Mandamos mail de confirmacion 
          $enlace = "http://localhost:8012/Repositorio/tp-entornos-graficos/Principal/Confirmar.php?token=$token";
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
                $mail->isSMTP();
                // Usamos las variables cargadas del .env arriba
                $mail->Host       = $smtpHost;
                $mail->SMTPAuth   = true;
                $mail->Username   = $smtpUser; // Aquí tomará 'viventastore1@gmail.com'
                $mail->Password   = $smtpPass; // Aquí tomará tu contraseña de aplicación
                $mail->SMTPSecure = $smtpSecure;
                $mail->Port       = $smtpPort;

                // Configuración para evitar errores de certificado en servidores locales (XAMPP)
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom($smtpUser, $smtpFromName);
                $mail->addAddress($vEmail, $vNombreUsuario);
                $mail->addReplyTo($smtpUser, 'Information');

                $mail->isHTML(true);
                $mail->Subject = $asunto;
                $mail->Body    = $mensajeMail;
                $mail->AltBody = strip_tags($mensajeMail); // Mejor usar strip_tags para el cuerpo plano

                $mail->send();
                $mensaje = "<div class='alert alert-success'>Su solicitud de registro fue enviada. Revisa tu correo para confirmar.</div>";
            } catch (Exception $e) {
            $mensaje = "<div class='alert alert-danger'>No se pudo enviar el correo de confirmación. Error: {$mail->ErrorInfo}</div>";
          }

        // --- FLUJO DUEÑO ---
        } elseif ($vTipoUsuario == 'duenio') {
          // Insertamos en la tabla 'dueño_local' con estado Pendiente (eliminamos la tabla solicitudes)
          $queryDuenio = "INSERT INTO dueño_local (cod_usuario, estado) VALUES ('$vCodUsuario', 'Pendiente')";
          mysqli_query($link, $queryDuenio);
          
          $mensaje = "<div class='alert alert-warning'>Te registraste como dueño de local. Tu cuenta está pendiente de aprobación por un administrador.</div>";
        }

      } else {
        $mensaje = "<div class='alert alert-danger'>Error al crear el usuario en la base de datos.</div>";
      }
    }
    
    if (isset($vResultado) && $vResultado) {
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

  <main style="background-image: url('../Imagenes/Fondo.jpg')" class="fondo-loginRegister pb-5 pt-5 d-flex justify-content-center align-items-center" aria-label="Página de registro">
    <section class="loginRegister-box" aria-label="Formulario de registro">
      <h1>Crear una nueva cuenta</h1>
      <h2>Es rápido y fácil.</h2>
      
      <?php echo $mensaje; ?>
      
      <form class="formulario-transparente" action="" method="POST" name="formRegister" aria-label="Formulario para crear una cuenta">

        <label for="nombre" style="display:block;">Nombre <span class="campo-obligatorio">*</span></label>
        <input type="text" id="nombre" name="nombre" size="100" placeholder="Nombre" required aria-label="Nombre" />

        <label for="email" style="display:block;">Mail <span class="campo-obligatorio">*</span></label>
        <input type="email" id="email" name="email" size="100" placeholder="Correo electrónico" required aria-label="Correo electrónico" />

        <label for="password" style="display:block;">Contraseña <span class="campo-obligatorio">*</span></label>
        <div style="position:relative;">
          <input type="password" name="password" id="password" size="8" placeholder="Contraseña" required aria-label="Contraseña" />
          <span id="togglePassword" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;" aria-label="Mostrar u ocultar contraseña" tabindex="0" role="button">
            <i class="bi bi-eye" id="iconEye"></i>
          </span>
        </div>

        <p style="text-align: center" class="mb-2 mt-3">Tipo de usuario</p>
        <div class="d-flex justify-content-center gap-3" aria-label="Selecciona el tipo de usuario">
          <input type="radio" class="btn-check" name="tipoUsuario" id="cliente" value="cliente" autocomplete="off" required aria-label="Cliente" />
          <label class="btn-radio" for="cliente">Cliente</label>
          <input type="radio" class="btn-check" name="tipoUsuario" id="duenio" value="duenio" autocomplete="off" aria-label="Dueño" />
          <label class="btn-radio" for="duenio">Dueño</label>
        </div>

        <input type="submit" style="margin-top: 1.5rem;" name="Login" value="Únete" aria-label="Crear cuenta" />
        <a href="InicioSesion.php" aria-label="Ir a inicio de sesión">¿Ya tienes una cuenta?</a>
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
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    });
  </script>

</body>
</html>