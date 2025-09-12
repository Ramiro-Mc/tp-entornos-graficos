<?php
include_once("../Includes/session.php");
$folder = "Principal";
$pestaña = "Contacto";

//Php mailer

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_SESSION['consulta_enviada'])) {
  echo "<script>alert('Consulta enviada');</script>";
  unset($_SESSION['consulta_enviada']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email = $_POST['email'];
  $consulta = $_POST['consulta'];

  $subject = "Consulta desde el formulario de contacto";
  $message = "
      <div style='font-family: Arial, sans-serif; background: #f9f9f9; padding: 24px; border-radius: 8px; color: #222;'>
        <h2 style='color: #2c3e50;'>Nueva consulta desde el formulario de contacto</h2>
        <hr style='border: none; border-top: 1px solid #eee; margin: 16px 0;'/>
        <p><strong>Nombre:</strong> $nombre $apellido</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Consulta:</strong></p>
        <div style='background: #fff; border: 1px solid #eee; padding: 16px; border-radius: 6px; color: #444;'>
          " . nl2br(htmlspecialchars($consulta)) . "
        </div>
        <hr style='border: none; border-top: 1px solid #eee; margin: 24px 0 8px 0;'/>
        <p style='font-size: 0.95em; color: #888;'>Este mensaje fue enviado automáticamente desde el formulario de contacto de Viventa Store.</p>
      </div>
    ";

  $mail = new PHPMailer(true);

  try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'viventastore@gmail.com';                     //SMTP username
    $mail->Password   = 'vfpm zaxi qbws oyub';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('viventastore@gmail.com', 'Viventa Store');
    $mail->addAddress('viventastore@gmail.com', 'Mensaje Contacto');     //Add a recipient
    $mail->addReplyTo($email, "$nombre $apellido");

    /* 
      //Attachments
      $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();
    $_SESSION['consulta_enviada'] = true;
    header("Location: Contacto.php");
    exit;
  } catch (Exception $e) {
    echo "<script>alert('Error al enviar la consulta.');</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Contacto</title>

</head>

<body>

  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="fondo-formulario-contacto" aria-label="Formulario de contacto">
    <div class="formulario-contacto text-center">
      <h2 class="seccion-titulo">Escribinos</h2>

      <form action="" method="POST" class="mx-auto" style="max-width: 600px;" aria-label="Formulario para enviar consulta">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="nombre" class="form-label"><b>Nombre:</b></label>
            <input type="text" class="form-control inputContacto" id="nombre" name="nombre" required aria-label="Nombre">
          </div>
          <div class="col-md-6">
            <label for="apellido" class="form-label "><b>Apellido:</b></label>
            <input type="text" class="form-control inputContacto" id="apellido" name="apellido" required aria-label="Apellido">
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label"><b>E-mail:</b></label>
          <input type="email" class="form-control inputContacto" id="email" name="email" required aria-label="Correo electrónico">
        </div>

        <div class="mb-3">
          <label for="consulta" class="form-label"><b>Consulta:</b></label>
          <textarea class="form-control inputContacto" id="consulta" name="consulta" rows="6" required aria-label="Escribe tu consulta"></textarea>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-success me-2 boton-enviar" aria-label="Enviar consulta">ENVIAR</button>
          <button type="reset" class="btn btn-secondary" aria-label="Borrar formulario">BORRAR</button>
        </div>
      </form>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>

</html>