<?php

$folder = "Administrador";
$pestaña = "Seccion Administrador";
include_once("../Includes/funciones.php");
sesionIniciada();
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Seccion Administrador</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="FondoDueñoAdministrador d-flex align-items-center py-5">
    <div class="container">
      <h1 class="text-center fw-bolder mb-5" style="color: #1e293b; text-shadow: 2px 2px 4px rgba(255,255,255,0.7);"><i class="bi bi-speedometer2 me-3"></i>Panel de Control</h1>
      
      <div class="row g-4 justify-content-center">
        
        <!-- Administrar Promociones -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="AdministrarPromociones.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-primary bg-opacity-10 mb-3">
                  <i class="bi bi-tags-fill text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Promociones</h4>
                <p class="text-muted small mb-0">Gestioná y moderá las promociones activas.</p>
              </div>
            </div>
          </a>
        </div>

        <!-- Administrar Novedades -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="AdministrarNovedades.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-success bg-opacity-10 mb-3">
                  <i class="bi bi-newspaper text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Novedades</h4>
                <p class="text-muted small mb-0">Administrá las noticias y anuncios globales.</p>
              </div>
            </div>
          </a>
        </div>

        <!-- Administrar Locales -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="AdministrarLocales.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-danger bg-opacity-10 mb-3">
                  <i class="bi bi-shop text-danger" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Locales</h4>
                <p class="text-muted small mb-0">Controlá los comercios registrados en el sistema.</p>
              </div>
            </div>
          </a>
        </div>

        <!-- Solicitudes de Registro -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="SolicitudesRegistro.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-warning bg-opacity-10 mb-3">
                  <i class="bi bi-person-lines-fill text-warning" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Solicitudes</h4>
                <p class="text-muted small mb-0">Revisá altas de nuevos dueños de local.</p>
              </div>
            </div>
          </a>
        </div>

        <!-- Reportes de Uso -->
        <div class="col-12 col-sm-6 col-lg-4">
          <a href="ReportePromociones.php" class="text-decoration-none">
            <div class="card h-100 border-0 rounded-4 shadow-sm admin-card text-center">
              <div class="card-body p-4">
                <div class="icon-box bg-info bg-opacity-10 mb-3">
                  <i class="bi bi-bar-chart-fill text-info" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Reportes</h4>
                <p class="text-muted small mb-0">Estadísticas y métricas de uso de promociones.</p>
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