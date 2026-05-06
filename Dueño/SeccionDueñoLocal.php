<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");
sesionIniciada();
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/InicioSesion.php");
  exit;
}

$folder = "Dueño";
$pestaña = "Seccion Dueño Local";
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Dueño Local</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="FondoDueñoAdministrador d-flex align-items-center py-5" aria-label="Panel principal de dueño de local">
    <div class="container" aria-label="Acciones para dueño de local">
      <h1 class="text-center fw-bolder mb-5" style="color: #1e293b; text-shadow: 2px 2px 4px rgba(255,255,255,0.7);"><i class="bi bi-shop-window me-3"></i>Panel de Dueño</h1>
      
      <div class="row g-4 justify-content-center">
        
        <!-- Crear nueva promoción -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="CrearPromocion.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-success bg-opacity-10 mb-3">
                  <i class="bi bi-plus-circle text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Crear Promoción</h4>
                <p class="text-muted small mb-0">Agregá nuevas promociones para tus locales.</p>
              </div>
            </div>
          </a>
        </div>

        <!-- Mis promociones -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="MisPromociones.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-primary bg-opacity-10 mb-3">
                  <i class="bi bi-tags-fill text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Mis Promociones</h4>
                <p class="text-muted small mb-0">Visualizá y gestioná tus promociones activas.</p>
              </div>
            </div>
          </a>
        </div>

        <!-- Administrar solicitudes -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="AdministrarSolicitudes.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-warning bg-opacity-10 mb-3">
                  <i class="bi bi-clipboard2-check text-warning" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Administrar Solicitudes</h4>
                <p class="text-muted small mb-0">Revisá las solicitudes de uso de promociones.</p>
              </div>
            </div>
          </a>
        </div>

      </div>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>