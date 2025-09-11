<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
sesionIniciada();
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/InicioSesion.php");
  exit;
}

$diasSemanaNombre = [
    1 => "Lunes",
    2 => "Martes",
    3 => "Miércoles",
    4 => "Jueves",
    5 => "Viernes",
    6 => "Sábado",
    7 => "Domingo"
];



$folder = "Dueño";
$pestaña = "Mis Promociones";

$cod_usuario = $_SESSION['cod_usuario'];
include("../conexion.inc");

$mensaje = "";
$cantPagina = 8;
$pagina = isset($_GET["pagina"]) ?  max(1, intval($_GET["pagina"])): 1;
$principio = ($pagina-1) * $cantPagina;


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
 //Me traigo los codigos de locales del dueño
$codigoslocales = [];
$sqlLocal = "SELECT cod_local, nombre_local FROM locales WHERE cod_usuario = '$cod_usuario'";
$localResult = consultaSQL($sqlLocal);
if ($localResult && mysqli_num_rows($localResult) > 0) {
    while ($row = mysqli_fetch_assoc($localResult)) {
        $codigoslocales[] = $row['cod_local'];
    }
}

//Me traigo las promociones de esos locales
$sqlPromociones = "SELECT * FROM promociones p INNER JOIN locales l ON p.cod_local = l.cod_local
 WHERE p.cod_local IN (" . implode(',', $codigoslocales) . ") ORDER BY p.cod_promocion $orden
 LIMIT $cantPagina OFFSET $principio";
$promociones = consultaSQL($sqlPromociones);


//Total promociones

$sqlTotal = "SELECT COUNT(DISTINCT p.cod_promocion) as total
FROM promociones p
INNER JOIN locales l ON p.cod_local = l.cod_local
WHERE p.cod_local IN (" . implode(',', $codigoslocales) . ")";

$total = consultaSQL($sqlTotal);
$totalPromos = mysqli_fetch_assoc($total)['total'];
$totalPaginas = ceil($totalPromos / $cantPagina); 

//Los dias de la semana para cada promocion de los locales
$sqlDias = "SELECT * FROM promociones INNER JOIN promocion_dia ON promociones.cod_promocion = promocion_dia.cod_promocion
 WHERE promociones.cod_local IN (" . implode(',', $codigoslocales) . ")";
 $dias = consultaSQL($sqlDias);

$diasPorPromo = [];
if ($dias && mysqli_num_rows($dias) > 0) {
    while ($row = mysqli_fetch_assoc($dias)) {
        $codPromo = $row['cod_promocion'];
        $diaCodigo = $row['cod_dia']; 
        if (!isset($diasPorPromo[$codPromo])) $diasPorPromo[$codPromo] = [];
        $diasPorPromo[$codPromo][] = $diaCodigo;
    }
}

//El uso de promociones aceptadas de los locales 
$sqlUsoPromociones = "SELECT uso.cod_promocion, uso.cod_usuario, uso.estado, prom.texto_promocion, COUNT(*) AS uso_count FROM uso_promociones uso
INNER JOIN promociones prom ON uso.cod_promocion = prom.cod_promocion
WHERE prom.cod_local IN (" . implode(',', $codigoslocales) . ") and uso.estado = 'aceptada'
GROUP BY uso.cod_promocion, uso.cod_usuario, uso.estado, prom.texto_promocion";
$usoPromociones = consultaSQL($sqlUsoPromociones);


?>

<!DOCTYPE html>
<html lang="es ">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Mis Promociones</title>

  </head>
  <body>
    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main class="FondoDueñoAdministrador">

      <div class="container-fluid filtraderos justify-content-end">
        <a href="CrearPromocion.php"><button class="btn btn-success "><i class="bi bi-plus-circle"></i> Crear </button></a>
       
          <form method="GET" class="d-inline">
              <select name="orden" class="form-select bg-primary text-white d-inline w-auto mx-2" onchange="this.form.submit()">
                <option  class="text_white" value="" disabled <?php if(!isset($_GET['orden'])) echo 'selected'; ?>>Ordenar por</option>
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
            <img src="data:image/png;base64,<?php echo $promo['foto_promocion']; ?>" alt="Imagen promoción <?php echo $promo['cod_promocion']; ?>" style="max-width:150px;max-height:150px;">
          <?php endif; ?>
          <p><b>Codigo:</b> <?php echo $promo['cod_promocion']; ?></p>
          <p><b>Vigencia:</b> <?php echo htmlspecialchars($promo['fecha_desde_promocion']); ?> al <?php echo htmlspecialchars($promo['fecha_hasta_promocion']); ?></p>
          <p><b>Categoria Cliente:</b> <?php echo htmlspecialchars($promo['categoria_cliente']); ?></p>
          <p><b>Estado Promocion:</b> <?php echo htmlspecialchars($promo['estado_promo']); ?></p>
          <p><b>Nombre Local:</b> <?php echo htmlspecialchars($promo['nombre_local']); ?></p>
          
          <p><b>Dias de la semana disponible: </b> <?php  $diasPromo = $diasPorPromo[$promo['cod_promocion']] ?? [];
          if ($diasPromo) {
              $nombres = array_map(function($codigo) use ($diasSemanaNombre) {
                  return $diasSemanaNombre[$codigo] ?? $codigo;
              }, $diasPromo);
              echo implode(', ', $nombres);
          } else {
              echo "No tiene días asignados";
          } ?></p>

          <p><b>Usos: </b> <?php if($usoPromociones && mysqli_num_rows($usoPromociones) > 0){ 
            $uso = mysqli_fetch_assoc($usoPromociones);
            echo isset($uso['uso_count']) ? $uso['uso_count'] : 0;
          } else {
            echo 0;
          } ?></p>
        </div>
          <div class="acciones">
             <button type="button" class="btn btn-danger Eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-cod="<?php echo $promo['cod_promocion']; ?>">
            ELIMINAR
          </button>
          </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No hay promociones registradas.</p>
  <?php endif; ?>
</div>

      <div class="row">
          <div class="col-3"></div>
          <div class="col-9">
                        <?php
              $ordenParam = isset($_GET['orden']) ? '&orden=' . $_GET['orden'] : '';
            ?>
            <div class="paginacion" aria-label="Page navigation example">
              <ul class="pagination">
                <?php if ($pagina > 1): ?>
                  <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina-1 . $ordenParam ?>"><i class="bi bi-arrow-left-short"></i></a>
                  </li>
                <?php endif; ?>

                <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
                  <li class="page-item <?= $i == $pagina ? 'active' : ''?>">
                    <a class="page-link" href="?pagina=<?= $i . $ordenParam ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                  <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina + 1 . $ordenParam ?>"><i class="bi bi-arrow-right-short"></i></a>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  
          <script>
      document.addEventListener('DOMContentLoaded', function() {
        var modalEliminar = document.getElementById('modalEliminar');
        modalEliminar.addEventListener('show.bs.modal', function (event) {
          var button = event.relatedTarget;
          var codPromo = button.getAttribute('data-cod');
          document.getElementById('inputEliminar').value = codPromo;
        });
      });
      </script>


      <!-- Modal de confirmación de eliminación -->
      <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              ¿Seguro que quieres eliminar esta promoción?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <form id="formEliminar" method="POST" style="display:inline;">
                <input type="hidden" name="eliminar" id="inputEliminar">
                <button type="submit" class="btn btn-danger">Eliminar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>
