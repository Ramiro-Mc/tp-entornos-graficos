<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
require_once("../Includes/env.php");
load_env(dirname(__DIR__) . '/.env');

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

sesionIniciada();
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/InicioSesion.php");
  exit;
}

$folder = "Dueño";
$pestaña = "Administrar Solicitudes";

$cod_usuario = $_SESSION['cod_usuario'];
include("../Includes/conexion.inc");
$mensaje = "";

// 1. Lógica de ordenamiento actualizada (Estilo Administrar Locales)
$order = 'uso.cod_promocion ASC'; // Orden por defecto

if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'texto_asc':
      $order = 'prom.texto_promocion ASC';
      break;
    case 'texto_desc':
      $order = 'prom.texto_promocion DESC';
      break;
    case 'cod_desc':
      $order = 'uso.cod_promocion DESC';
      break;
    case 'cod_asc':
    default:
      $order = 'uso.cod_promocion ASC';
      break;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_promocion'], $_POST['eliminar_usuario'])) {
  $codPromo = intval($_POST['eliminar_promocion']);
  $codUsuario = intval($_POST['eliminar_usuario']);
  $sqlEliminar = "UPDATE uso_promociones SET estado = 'rechazada' WHERE cod_promocion = $codPromo AND cod_usuario = $codUsuario";
  if (consultaSQL($sqlEliminar)) {
    $mensaje = "<div class='alert alert-success'>Solicitud rechazada correctamente.</div>";

    //notificar por mail al cliente
    $sqlDatosMail = "SELECT u.email, u.nombre_usuario, p.texto_promocion, l.nombre_local
    FROM uso_promociones up
    INNER JOIN usuario u ON up.cod_usuario = u.cod_usuario
    INNER JOIN promociones p ON up.cod_promocion = p.cod_promocion
    INNER JOIN locales l ON p.cod_local = l.cod_local
    WHERE up.cod_promocion = $codPromo AND up.cod_usuario = $codUsuario
    LIMIT 1";
    $resDatosMail = consultaSQL($sqlDatosMail);

    if ($resDatosMail && mysqli_num_rows($resDatosMail) > 0) {
      $datosMail = mysqli_fetch_assoc($resDatosMail);
      $emailCliente = $datosMail['email'] ?? '';

      if ($emailCliente !== '') {
        $smtpHost = env('SMTP_HOST', 'smtp.gmail.com');
        $smtpPort = (int) env('SMTP_PORT', '465');
        $smtpUser = env('SMTP_USERNAME', '');
        $smtpPass = env('SMTP_PASSWORD', '');
        $smtpFromName = env('SMTP_FROM_NAME', 'Viventa Store');
        $smtpEncryption = strtolower(env('SMTP_ENCRYPTION', 'smtps'));
        $smtpSecure = $smtpEncryption === 'starttls'
          ? PHPMailer::ENCRYPTION_STARTTLS
          : PHPMailer::ENCRYPTION_SMTPS;

        $nombreCliente = htmlspecialchars($datosMail['nombre_usuario'] ?? 'Cliente', ENT_QUOTES, 'UTF-8');
        $textoPromocion = htmlspecialchars($datosMail['texto_promocion'] ?? 'Promocion', ENT_QUOTES, 'UTF-8');
        $nombreLocal = htmlspecialchars($datosMail['nombre_local'] ?? 'Viventa Store', ENT_QUOTES, 'UTF-8');

        $mail = new PHPMailer(true);

        try {
          if ($smtpUser === '' || $smtpPass === '') {
            throw new Exception('Faltan credenciales SMTP en variables de entorno.');
          }

          $mail->isSMTP();
          $mail->Host = $smtpHost;
          $mail->SMTPAuth = true;
          $mail->Username = $smtpUser;
          $mail->Password = $smtpPass;
          $mail->SMTPSecure = $smtpSecure;
          $mail->Port = $smtpPort;

          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

          $mail->setFrom($smtpUser, $smtpFromName);
          $mail->addAddress($emailCliente, $datosMail['nombre_usuario']);
          $mail->isHTML(true);
          $mail->Subject = "Tu solicitud de promocion fue rechazada";
          $mail->Body = "
            <div style='font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; border-radius: 8px; color: #222;'>
              <h2 style='color: #2c3e50;'>Hola {$nombreCliente}</h2>
              <p>Tu solicitud para usar la promocion no fue aprobada en esta oportunidad.</p>
              <p><strong>Promocion:</strong> {$textoPromocion}</p>
              <p><strong>Local:</strong> {$nombreLocal}</p>
              <p>Podes seguir explorando otras promociones disponibles en Viventa Store.</p>
              <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0 8px 0;'/>
              <p style='font-size: 0.95em; color: #888;'>Este mensaje fue enviado automaticamente desde Viventa Store.</p>
            </div>
          ";
          $mail->AltBody = "Hola " . ($datosMail['nombre_usuario'] ?? 'Cliente') . ", tu solicitud para usar la promocion fue rechazada.";

          $mail->send();
        } catch (Exception $e) {
          $mensaje .= "<div class='alert alert-warning'>Solicitud rechazada, pero no se pudo enviar el correo al cliente.</div>";
        }
      }
    }
  } else {
    $mensaje = "<div class='alert alert-danger'>Error al rechazar la solicitud.</div>";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aceptar_promocion'], $_POST['aceptar_usuario'])) {
  $codPromo = intval($_POST['aceptar_promocion']);
  $codUsuario = intval($_POST['aceptar_usuario']);
  $sqlEliminar = "UPDATE uso_promociones SET estado = 'aceptada' WHERE cod_promocion = $codPromo AND cod_usuario = $codUsuario";
  if (consultaSQL($sqlEliminar)) {
    $mensaje = "<div class='alert alert-success'>Solicitud aceptada correctamente.</div>";

    //actualizar categoria cliente
    $res = consultaSQL("SELECT * From uso_promociones up WHERE cod_usuario = $codUsuario AND estado = 'aceptada'");
    if ($res && mysqli_num_rows($res) >= 3 && mysqli_num_rows($res) < 6) {
      consultaSQL("UPDATE cliente SET categoria_cliente = 'medium' WHERE cod_usuario = $codUsuario");
    } elseif ($res && mysqli_num_rows($res) >= 6) {
      consultaSQL("UPDATE cliente SET categoria_cliente = 'premium' WHERE cod_usuario = $codUsuario");
    }

    //notificar por mail al cliente
    $sqlDatosMail = "SELECT u.email, u.nombre_usuario, p.texto_promocion, l.nombre_local
    FROM uso_promociones up
    INNER JOIN usuario u ON up.cod_usuario = u.cod_usuario
    INNER JOIN promociones p ON up.cod_promocion = p.cod_promocion
    INNER JOIN locales l ON p.cod_local = l.cod_local
    WHERE up.cod_promocion = $codPromo AND up.cod_usuario = $codUsuario
    LIMIT 1";
    $resDatosMail = consultaSQL($sqlDatosMail);

    if ($resDatosMail && mysqli_num_rows($resDatosMail) > 0) {
      $datosMail = mysqli_fetch_assoc($resDatosMail);
      $emailCliente = $datosMail['email'] ?? '';

      if ($emailCliente !== '') {
        $smtpHost = env('SMTP_HOST', 'smtp.gmail.com');
        $smtpPort = (int) env('SMTP_PORT', '465');
        $smtpUser = env('SMTP_USERNAME', '');
        $smtpPass = env('SMTP_PASSWORD', '');
        $smtpFromName = env('SMTP_FROM_NAME', 'Viventa Store');
        $smtpEncryption = strtolower(env('SMTP_ENCRYPTION', 'smtps'));
        $smtpSecure = $smtpEncryption === 'starttls'
          ? PHPMailer::ENCRYPTION_STARTTLS
          : PHPMailer::ENCRYPTION_SMTPS;

        $nombreCliente = htmlspecialchars($datosMail['nombre_usuario'] ?? 'Cliente', ENT_QUOTES, 'UTF-8');
        $textoPromocion = htmlspecialchars($datosMail['texto_promocion'] ?? 'Promocion', ENT_QUOTES, 'UTF-8');
        $nombreLocal = htmlspecialchars($datosMail['nombre_local'] ?? 'Viventa Store', ENT_QUOTES, 'UTF-8');

        $mail = new PHPMailer(true);

        try {
          if ($smtpUser === '' || $smtpPass === '') {
            throw new Exception('Faltan credenciales SMTP en variables de entorno.');
          }

          $mail->isSMTP();
          $mail->Host = $smtpHost;
          $mail->SMTPAuth = true;
          $mail->Username = $smtpUser;
          $mail->Password = $smtpPass;
          $mail->SMTPSecure = $smtpSecure;
          $mail->Port = $smtpPort;

          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

          $mail->setFrom($smtpUser, $smtpFromName);
          $mail->addAddress($emailCliente, $datosMail['nombre_usuario']);
          $mail->isHTML(true);
          $mail->Subject = "Tu promocion fue aprobada";
          $mail->Body = "
            <div style='font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; border-radius: 8px; color: #222;'>
              <h2 style='color: #2c3e50;'>Hola {$nombreCliente}</h2>
              <p>Tu solicitud para usar la promocion ya fue aprobada.</p>
              <p><strong>Promocion:</strong> {$textoPromocion}</p>
              <p><strong>Local:</strong> {$nombreLocal}</p>
              <p>Ya podes usarla. Te esperamos.</p>
              <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0 8px 0;'/>
              <p style='font-size: 0.95em; color: #888;'>Este mensaje fue enviado automaticamente desde Viventa Store.</p>
            </div>
          ";
          $mail->AltBody = "Hola " . ($datosMail['nombre_usuario'] ?? 'Cliente') . ", tu solicitud para usar la promocion fue aprobada. Ya podes usarla.";

          $mail->send();
        } catch (Exception $e) {
          $mensaje .= "<div class='alert alert-warning'>Solicitud aceptada, pero no se pudo enviar el correo al cliente.</div>";
        }
      }
    }
  } else {
    $mensaje = "<div class='alert alert-danger'>Error al aceptar la solicitud.</div>";
  }
}

$codigoslocales = [];
$sqlLocal = "SELECT cod_local, nombre_local FROM locales WHERE cod_usuario = '$cod_usuario'";
$localResult = consultaSQL($sqlLocal);
if ($localResult && mysqli_num_rows($localResult) > 0) {
  while ($row = mysqli_fetch_assoc($localResult)) {
    $codigoslocales[] = $row['cod_local'];
  }
}

if (!empty($codigoslocales)) {
  // 2. Se aplicó el "ORDER BY $order" al final de esta consulta (antes no estaba)
  $sqlUsoPromociones = "SELECT uso.cod_promocion, loc.nombre_local, uso.cod_usuario,  usu.nombre_usuario, uso.estado, prom.texto_promocion
  FROM uso_promociones uso
  INNER JOIN promociones prom ON uso.cod_promocion = prom.cod_promocion
  INNER JOIN usuario usu on uso.cod_usuario = usu.cod_usuario
  INNER JOIN locales loc on prom.cod_local = loc.cod_local
  WHERE prom.cod_local IN (" . implode(',', $codigoslocales) . ") and uso.estado = 'enviada'
  ORDER BY $order";
  
  $usoPromociones = consultaSQL($sqlUsoPromociones);
} else {
  // Si no tiene locales, la consulta es nula (no explota)
  $usoPromociones = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Administrar solicitudes</title>
</head>

<body>
  <header>
    <?php include("../Includes/header.php"); ?>
  </header>

  <main class="FondoDueñoAdministrador" aria-label="Panel de administración de solicitudes">
    <div class="container-fluid filtraderos justify-content-end" aria-label="Acciones de filtrado y orden">
      
      <div class="dropdown mx-2">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-arrow-down-up"></i> Ordenar
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="?order=texto_asc">Promoción ↑</a></li>
          <li><a class="dropdown-item" href="?order=texto_desc">Promoción ↓</a></li>
          <li><a class="dropdown-item" href="?order=cod_asc">Código ↑</a></li>
          <li><a class="dropdown-item" href="?order=cod_desc">Código ↓</a></li>
        </ul>
      </div>
    </div> 
    <?php if (!empty($mensaje)): ?>
      <div id="contenedor-mensaje" class="d-flex justify-content-center my-3 w-100">
        <div class="text-center">
          <?php echo $mensaje; ?>
        </div>
      </div>
      <script>
        setTimeout(function() {
          let mensaje = document.getElementById('contenedor-mensaje');
          if (mensaje) {
            mensaje.style.transition = "opacity 0.5s ease";
            mensaje.style.opacity = "0";
            setTimeout(function() {
              mensaje.style.display = "none";
            }, 500);
          }
        }, 2000); // 3000 milisegundos = 3 segundos. Puedes cambiar este número.
      </script>
    <?php endif; ?>
    <div class="promociones" aria-label="Listado de solicitudes de promociones">
      <?php if ($usoPromociones && mysqli_num_rows($usoPromociones) > 0): ?>
        <?php while ($usopromo = mysqli_fetch_assoc($usoPromociones)): ?>
          <div class="promocion-cli container-fluid bg-white rounded-4 shadow-sm mb-4 p-3 dueño-promo-card" aria-label="Tarjeta de solicitud de promoción">
            <div class="row align-items-center">
              
              <div class="col-8 col-md-9 col-lg-10 d-flex justify-content-between align-items-center w-100">
                <div class="info ps-2">
                  <h4 class="dueño-promo-title mb-1"><?php echo htmlspecialchars($usopromo['texto_promocion']); ?></h4>
                  
                  <div class="d-flex flex-wrap gap-3 mt-2 text-muted dueño-solicitud-detalles">
                    <div class="d-flex align-items-center"><i class="bi bi-hash text-secondary me-2"></i> <b>Promo #<?php echo $usopromo['cod_promocion']; ?></b></div>
                    <div class="d-flex align-items-center"><i class="bi bi-shop text-primary me-2"></i> <?php echo htmlspecialchars($usopromo['nombre_local']); ?></div>
                    <div class="d-flex align-items-center"><i class="bi bi-person-circle text-info me-2"></i> <?php echo htmlspecialchars($usopromo['nombre_usuario']); ?> <small class="ms-1 text-secondary">(Id: <?php echo $usopromo['cod_usuario']; ?>)</small></div>
                    <div class="d-flex align-items-center"><span class="badge rounded-pill badge-estado-en-espera px-3 py-1 shadow-sm"><i class="bi bi-hourglass-split me-1"></i>En Espera</span></div>
                  </div>
                </div>

                <div class="acciones ms-3 d-flex gap-2">
                  <button type="button" class="btn btn-outline-success d-flex align-items-center justify-content-center rounded-circle shadow-sm btn-dueño-action" title="Aceptar Solicitud" data-bs-toggle="modal" data-bs-target="#modal-aceptar-<?php echo htmlspecialchars($usopromo['cod_promocion'].$usopromo['cod_usuario']); ?>">
                    <i class="bi bi-check-lg btn-dueño-delete-icon"></i>
                  </button>
                  <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-circle shadow-sm btn-dueño-action" title="Rechazar Solicitud" data-bs-toggle="modal" data-bs-target="#modal-rechazar-<?php echo htmlspecialchars($usopromo['cod_promocion'].$usopromo['cod_usuario']); ?>">
                    <i class="bi bi-x-lg btn-dueño-delete-icon"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-center">No hay solicitudes pendientes para sus locales.</p>
  <?php endif; ?>
  </main>

  <!-- MODALES FUERA DEL MAIN PARA EVITAR PROBLEMAS DE Z-INDEX/PANTALLA OSCURA -->
  <?php if ($usoPromociones && mysqli_num_rows($usoPromociones) > 0): ?>
    <?php mysqli_data_seek($usoPromociones, 0); ?>
    <?php while ($usopromo = mysqli_fetch_assoc($usoPromociones)): ?>
      
      <!-- Modal Aceptar -->
      <div class="modal fade" id="modal-aceptar-<?php echo htmlspecialchars($usopromo['cod_promocion'].$usopromo['cod_usuario']); ?>" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" style="margin: auto; font-size: 1.6rem;">Aceptar solicitud</h1>
            </div>
            <div class="modal-body text-center">
              <p style="font-size: 1.2rem;">¿Seguro que quiere aceptar esta solicitud?</p>
            </div>
            <div class="modal-footer d-flex justify-content-around">
              <form method="POST" class="m-0">
                <input type="hidden" name="aceptar_promocion" value="<?php echo htmlspecialchars($usopromo['cod_promocion']); ?>">
                <input type="hidden" name="aceptar_usuario" value="<?php echo htmlspecialchars($usopromo['cod_usuario']); ?>">
                <button type="submit" class="btn btn-success">¡Aceptar!</button>
              </form>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Rechazar -->
      <div class="modal fade" id="modal-rechazar-<?php echo htmlspecialchars($usopromo['cod_promocion'].$usopromo['cod_usuario']); ?>" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" style="margin: auto; font-size: 1.6rem;">Rechazar solicitud</h1>
            </div>
            <div class="modal-body text-center">
              <p style="font-size: 1.2rem;">¿Seguro que quiere rechazar esta solicitud?</p>
              <p class="informacion"><i class="bi bi-info-circle"></i> Al rechazar, notificaremos al usuario de la decisión</p>
            </div>
            <div class="modal-footer d-flex justify-content-around">
              <form method="POST" class="m-0">
                <input type="hidden" name="eliminar_promocion" value="<?php echo htmlspecialchars($usopromo['cod_promocion']); ?>">
                <input type="hidden" name="eliminar_usuario" value="<?php echo htmlspecialchars($usopromo['cod_usuario']); ?>">
                <button type="submit" class="btn btn-danger">Rechazar</button>
              </form>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      
    <?php endwhile; ?>
  <?php endif; ?>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
    <?php include("../Includes/footer.php") ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>