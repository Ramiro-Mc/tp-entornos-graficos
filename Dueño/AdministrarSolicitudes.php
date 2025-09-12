<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
sesionIniciada();
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/InicioSesion.php");
  exit;
}

$folder = "Dueño";
$pestaña = "Reporte Promociones";

$cod_usuario = $_SESSION['cod_usuario'];
include("../conexion.inc");
$mensaje = "";

$orden = ($_GET['orden'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_promocion'], $_POST['eliminar_usuario'])) {
  $codPromo = intval($_POST['eliminar_promocion']);
  $codUsuario = intval($_POST['eliminar_usuario']);
  $sqlEliminar = "UPDATE uso_promociones SET estado = 'rechazada' WHERE cod_promocion = $codPromo AND cod_usuario = $codUsuario";
  if (consultaSQL($sqlEliminar)) {
    $mensaje = "<div class='alert alert-success'>Solicitud rechazada correctamente.</div>";
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
  } else {
    $mensaje = "<div class='alert alert-danger'>Error al aceptar la solicitud.</div>";
  }

  //actualizar categoria cliente

  $res = consultaSQL("SELECT * From uso_promociones up WHERE cod_usuario = $codUsuario AND estado = 'aceptada'");
  if (mysqli_num_rows($res) >= 3 && mysqli_num_rows($res) < 6) {
    consultaSQL("UPDATE cliente SET categoria_cliente = 'medium' WHERE cod_usuario = $codUsuario");
  } elseif (mysqli_num_rows($res) >= 6) {
    consultaSQL("UPDATE cliente SET categoria_cliente = 'premium' WHERE cod_usuario = $codUsuario");
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



//El uso de promociones enviadas de los locales
$sqlUsoPromociones = "SELECT uso.cod_promocion, loc.nombre_local, uso.cod_usuario,  usu.nombre_usuario, uso.estado, prom.texto_promocion
FROM uso_promociones uso
INNER JOIN promociones prom ON uso.cod_promocion = prom.cod_promocion
INNER JOIN usuario usu on uso.cod_usuario = usu.cod_usuario
INNER JOIN locales loc on prom.cod_local = loc.cod_local
WHERE prom.cod_local IN (" . implode(',', $codigoslocales) . ") and uso.estado = 'enviada'";
$usoPromociones = consultaSQL($sqlUsoPromociones);




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
      <form method="GET" class="d-inline" aria-label="Ordenar solicitudes">
        <select name="orden" class="form-select bg-primary text-white d-inline w-auto mx-2" onchange="this.form.submit()" aria-label="Seleccionar orden de solicitudes">
          <option class="text_white" value="" disabled <?php if (!isset($_GET['orden'])) echo 'selected'; ?>>Ordenar por</option>
          <option value="asc" <?php if (($_GET['orden'] ?? '') == 'asc') echo 'selected'; ?>>Código Ascendente</option>
          <option value="desc" <?php if (($_GET['orden'] ?? '') == 'desc') echo 'selected'; ?>>Código Descendente</option>
        </select>
      </form>

      <?php
      if ($mensaje) echo $mensaje;
      ?>
    </div>
    <div class="promociones" aria-label="Listado de solicitudes de promociones">
      <?php if ($usoPromociones && mysqli_num_rows($usoPromociones) > 0): ?>
        <?php while ($usopromo = mysqli_fetch_assoc($usoPromociones)): ?>
          <div class="promocion" aria-label="Tarjeta de solicitud de promoción">
            <div class="infoTarjeta">
              <h3><?php echo htmlspecialchars($usopromo['texto_promocion']); ?></h3>
              <p><b>Codigo Promocion:</b> <?php echo $usopromo['cod_promocion']; ?></p>
              <p><b>Local:</b> <?php echo $usopromo['nombre_local']; ?></p>
              <p><b>Codigo Usuario:</b> <?php echo $usopromo['cod_usuario']; ?></p>
              <p><b>Nombre Usuario:</b> <?php echo $usopromo['nombre_usuario']; ?></p>
              <p><b>Estado:</b> <?php echo $usopromo['estado']; ?></p>
            </div>
            <div class="acciones-reporte align-items-center d-flex justify-content-center acciones" aria-label="Acciones de la solicitud">
              <form method="POST" style="display:inline;" aria-label="Aceptar solicitud">
                <input type="hidden" name="aceptar_promocion" value="<?php echo $usopromo['cod_promocion']; ?>">
                <input type="hidden" name="aceptar_usuario" value="<?php echo $usopromo['cod_usuario']; ?>">
                <button type="submit" class="btn btn-success" style="padding: 18px 18px;" aria-label="Aceptar solicitud">ACEPTAR</button>
              </form>
              <form method="POST" style="display:inline;" aria-label="Rechazar solicitud">
                <input type="hidden" name="eliminar_promocion" value="<?php echo $usopromo['cod_promocion']; ?>">
                <input type="hidden" name="eliminar_usuario" value="<?php echo $usopromo['cod_usuario']; ?>">
                <button type="submit" class="btn btn-danger" style="padding: 18px 18px;" onclick="return confirm('¿Seguro que quieres Rechazar esta solicitud?');" aria-label="Rechazar solicitud">RECHAZAR</button>
              </form>
            </div>
          </div>
        <?php endwhile; ?>
    </div>
  <?php else: ?>
    <h3 aria-label="Sin solicitudes pendientes">No hay solicitudes pendientes para sus locales.</h3>
  <?php endif; ?>
  </main>


  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>