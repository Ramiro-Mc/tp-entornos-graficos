<?php
session_start();
if (!isset($_SESSION['cod_usuario'])) {
    header("Location: ../login.php");
    exit;
}

include("../conexion.inc"); 
include("../functions/funciones.php");
$cod_usuario = $_SESSION['cod_usuario'];

$res = consultaSQL("SELECT nombre FROM usuario WHERE cod_usuario = '$cod_usuario'");
$row = mysqli_fetch_assoc($res); //Para pasarlo a valor, no recurso
$vnombre_usuario = $row['nombre'] ?? ''; 
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Importar BootStrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <!-- Importar iconos BootStrap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <!-- Metadatos -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../styles/style-general.css" />

    <title>Dueño Local</title>
    <link rel="icon" type="image/x-icon" href="../Images/Logo.png" />
  </head>

  <body>
    <header>
      <div class="top-bar">
        <a href="SeccionDueñoLocal.html">
          <img class="logo" src="../Images/logo.png" alt="FotoShopping" />
        </a>
        <nav>
          <p style="color:white">Bienvenido! <?php echo $vnombre_usuario ?></p> 
          <a href="../Principal/CerrarSesion.php">Cerrar sesion</a>
        </nav>
      </div>
    </header>

    <main class="FondoDueñoAdministrador align-items-center ">
      
      <div class="botonesDueñoAdministrador container-fluid">
        <a href="CrearPromocion.php"><button>Crear nueva promocion</button></a>
        <a href="MisPromociones.html"><button>Mis promociones</button></a>
        <a href="ReportePromocionesDue.html"
          ><button>Generar reporte</button></a
        >
      </div>
    </main>

    <footer
      class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4"
    >
      <div class="d-flex w-100 justify-content-center gap-5 px-5">
        <nav class="texto-footer">
          <h5>Mapa del sitio</h5>
          <div class="mb-2"><a href="SeccionDueñoLocal.html">Inicio</a></div>
          <div class="mb-2">
            <a href="CrearPromocion.html">crear Nueva Promocion</a>
          </div>
          <div class="mb-2">
            <a href="MisPromociones.html">Mis Promociones</a>
          </div>
          <div class="mb-2">
            <a href="ReportePromocionesDue.html">Generar Reporte</a>
          </div>
        </nav>
          <section class="texto-footer">
          <h5>Contacto</h5>
          <p>Email: <a href="#">contacto@viventastore.com</a></p>
          <p>Teléfono: <a href="#">+54 9 11 2345-6789</a></p>
          <p>Dirección: Calle 123, Ciudad</p>
        </section>

      </div>
      <p class="texto-footer text-center">
        © 2025 Viventa Store. Todos los derechos reservados.
      </p>
    </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
