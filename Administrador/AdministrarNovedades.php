<?php

$folder = "Administrador";
$pestaña = "Administrar Novedades";

include("../conexion.inc");

// Traer todas las novedades
$result = $link->query("SELECT * FROM novedades ORDER BY fecha_desde_novedad DESC");
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Administrar Novedades</title>

  </head>
  <body>
    <header>

      <?php include("../Includes/header.php"); ?>
      
    </header>

    <main class="FondoDueñoAdministrador">
      <div class="container-fluid filtraderos justify-content-end mb-3">
        <a href="CrearNovedad.php" class="btn btn-success">
          <i class="bi bi-plus-circle"></i> Crear
        </a>
        <button class="btn btn-info">
          <i class="bi bi-arrow-down-up"></i> Ordenar
        </button>
      </div>

      <div class="promociones">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($n = $result->fetch_assoc()): ?>
            <div class="promocion">
              <div class="infoTarjeta">
                <h3><?= htmlspecialchars($n['textoNovedad']) ?></h3>
                <p>#<?= $n['cod_novedad'] ?></p>
                <p><small>Desde: <?= $n['fecha_desde_novedad'] ?> | Hasta: <?= $n['fecha_hasta_novedad'] ?></small></p>
              </div>
              <div class="acciones">
                <a href="VerNovedad.php?cod_novedad=<?= $n['cod_novedad'] ?>" class="btn btn-primary btn-sm">VER DETALLES</a>
                <a href="EditarNovedad.php?cod_novedad=<?= $n['cod_novedad'] ?>" class="btn btn-secondary btn-sm">EDITAR</a>
                <button 
                  class="btn btn-danger btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#eliminarModal<?= $n['cod_novedad'] ?>">
                  ELIMINAR
                </button>
              </div>
            </div>

            <!-- Modal de confirmación -->
            <div class="modal fade" id="eliminarModal<?= $n['cod_novedad'] ?>" tabindex="-1" aria-labelledby="eliminarModalLabel<?= $n['cod_novedad'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminarModalLabel<?= $n['cod_novedad'] ?>">Confirmar eliminación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta novedad?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="EliminarNovedad.php?cod_novedad=<?= $n['cod_novedad'] ?>" class="btn btn-danger">Eliminar</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center">No hay novedades cargadas.</p>
        <?php endif; ?>
      </div>

      <!-- Paginación ejemplo (opcional) -->
      <div aria-label="Page navigation example" class="mt-4">
        <ul class="pagination justify-content-center">
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
    ></script>
  </body>
</html>
