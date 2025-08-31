<?php
include_once("../Includes/session.php");
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/login.php");
  exit;
}


$cod_usuario = $_SESSION['cod_usuario'];
include("../conexion.inc");
include("../Includes/funciones.php");
$mensaje = "";

$orden = ($_GET['orden'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codPromoEliminar = intval($_POST['eliminar']);
    $sqlEliminar = "DELETE FROM promociones WHERE cod_promocion = $codPromoEliminar AND cod_local IN (SELECT cod_local FROM locales WHERE cod_usuario = '$cod_usuario')";
    if (consultaSQL($sqlEliminar)) {
        $mensaje = "<div class='alert alert-success'>Promoción eliminada correctamente.</div>";
    } else {
         $mensaje = "<div class='alert alert-danger'>Error al eliminar la promoción.</div>";
    }
}

$sqlLocal = "SELECT cod_local, nombre_local FROM locales WHERE cod_usuario = '$cod_usuario'";
$localResult = consultaSQL($sqlLocal);
$local = mysqli_fetch_assoc($localResult);//Para pasarlo a array
$codLoc = $local['cod_local'];

$sqlPromociones = "SELECT * FROM promociones INNER JOIN locales ON promociones.cod_local = locales.cod_local WHERE promociones.cod_local = '$codLoc' ORDER BY promociones.cod_promocion $orden";
$promociones = consultaSQL($sqlPromociones);

?>

<!DOCTYPE html>
<html lang="es ">
  <head>
    <?php include("../Includes/head.php"); ?>
    <title>Mis Promociones</title>
  </head>
  <body>
    <header>

      <?php

      $folder = "Dueño";
      $pestaña = "Mis Promociones";
      include("../Includes/header.php");

      ?>

    </header>

    <main class="FondoDueñoAdministrador">

      <div class="container-fluid filtraderos justify-content-end">
        <a href="CrearPromocion.php"><button class="btn btn-success"><i class="bi bi-plus-circle"></i> Crear </button></a>
          <form method="GET" class="d-inline">
            <select name="orden" class="form-select d-inline w-auto mx-2" onchange="this.form.submit()">
              <option value="" disabled <?php if(!isset($_GET['orden'])) echo 'selected'; ?>>Ordenar por</option>
              <option value="asc" <?php if(($_GET['orden'] ?? '') == 'asc') echo 'selected'; ?>>Código Ascendente</option>
              <option value="desc" <?php if(($_GET['orden'] ?? '') == 'desc') echo 'selected'; ?>>Código Descendente</option>
            </select>
          </form>
      </div>


    <?php
      if ($mensaje) echo $mensaje;
    ?>
      <div class="promociones">
  <?php if ($promociones && mysqli_num_rows($promociones) > 0): ?>
    <?php while ($promo = mysqli_fetch_assoc($promociones)): ?>
      <div class="promocion">
        <div class="infoTarjeta">
          <h3><?php echo htmlspecialchars($promo['texto_promocion']); ?></h3>
          <?php if (!empty($promo['foto_promocion'])): ?>
            <img src="data:image/png;base64,<?php echo $promo['foto_promocion']; ?>" alt="Imagen promoción" style="max-width:150px;max-height:150px;">
          <?php endif; ?>
          <p><b>Codigo:</b> <?php echo $promo['cod_promocion']; ?></p>
          <p><b>Vigencia:</b> <?php echo htmlspecialchars($promo['fecha_desde_promocion']); ?> al <?php echo htmlspecialchars($promo['fecha_hasta_promocion']); ?></p>
          <p><b>Categoria Cliente:</b> <?php echo htmlspecialchars($promo['categoria_cliente']); ?></p>
          <p><b>Estado Promocion:</b> <?php echo htmlspecialchars($promo['estado_promo']); ?></p>
          <p><b>Nombre Local:</b> <?php echo htmlspecialchars($promo['nombre_local']); ?></p>
        </div>
          <div class="acciones">
            <form method="POST" style="display:inline;">
              <input type="hidden" name="eliminar" value="<?php echo $promo['cod_promocion']; ?>">
              <button type="submit" class="btn btn-danger Eliminar" onclick="return confirm('¿Seguro que quieres eliminar esta promoción?');">ELIMINAR</button>
          </form>
          </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No hay promociones registradas.</p>
  <?php endif; ?>
</div>

      </div>
      <div aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
