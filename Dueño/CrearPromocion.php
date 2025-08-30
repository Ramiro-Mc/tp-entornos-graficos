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
$errores = [];
$estado = "pendiente";

$sqlLocales = "SELECT cod_local, nombre_local FROM locales WHERE cod_usuario = '$cod_usuario'";
$locales = consultaSQL($sqlLocales);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vTitulo = trim($_POST['texto_promocion'] ?? '');
    $vFechaInicio = $_POST['fechaini'] ?? '';
    $vFechaFin = $_POST['fechafin'] ?? '';
    $vCategoria = $_POST['Categoria'] ?? '';
    $vCodLocal = $_POST['cod_local'] ?? '';
    $vArchivo = "";

 if ($vTitulo === '') $errores[] = "Título requerido";
    if ($vFechaInicio === '' || $vFechaFin === '') $errores[] = "Fechas requeridas";
    if ($vFechaInicio && $vFechaFin && $vFechaFin < $vFechaInicio) $errores[] = "Rango de fechas inválido";
    if ($vCategoria === '') $errores[] = "Categoría requerida";
    if ($vCodLocal === '') $errores[] = "Debe seleccionar un local";



      if (!$errores) {

        $vTituloEscaped = mysqli_real_escape_string($link, $vTitulo);
        $vCategoriaEscaped = mysqli_real_escape_string($link, $vCategoria);

      $sql = "INSERT INTO promociones ( texto_promocion, fecha_desde_promocion, fecha_hasta_promocion, categoria_cliente, estado_promo, cod_local )
              VALUES ('$vTitulo', '$vFechaInicio', '$vFechaFin', '$vCategoria','$estado', '$vCodLocal' )";
      if (consultaSQL($sql)) {
          $mensaje = "Promoción creada";
          $vTitulo = $vDescripcion = $vCategoria = "";
          $vFechaInicio = $vFechaFin = "";
      } else {
          $errores[] = "Error BD: " . mysqli_error($link);
      }
  }
}
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
    <link rel="stylesheet" href="../Styles/style.css" />
    <link rel="stylesheet" href="../Styles/style-general.css" />
    <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
    <title>Crear Nueva Promocion</title>
  </head>
  <body>
    <header>

      <?php

      $folder = "Dueño";
      $pestaña = "Crear Promocion";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>

    </header>

    <main class="FondoDueñoAdministrador">
      <section class="form-register">
        <h4>Formulario Promoción</h4>
          <form method="POST" name="FormPromocion" action="CrearPromocion.php">
            <p>Titulo</p>
            <input
              class="controls"
              type="text"
              name="texto_promocion"
              placeholder="Ingrese el titulo de la nueva promocion"
              required
            />
            <p>Vigencia de la promocion</p>
            <label for="fechaini">Fecha de inicio</label>
            <input
              class="controls"
              type="date"
              name="fechaini"
              id="fechaini"
              required
            />
            <label for="fechafin">Fecha de fin</label>
            <input
              class="controls"
              type="date"
              id="fechafin"
              name="fechafin"
              required
            />
            <p>Categoria</p>
            <div class="position-relative">
              <select
                class="form-control controls"
                id="exampleFormControlSelect1"
                required
                name="Categoria"
              >
                <option>Inicial</option>
                <option>Medium</option>
                <option>Premium</option>
              
              </select>
                <p>Local asignado</p>
            <div class="position-relative">
              <select
                class="form-control controls"
                id="exampleFormControlSelect1"
                required
                name="cod_local"
              >
                  <option value="">Seleccione un local</option>
                    <?php while ($row = mysqli_fetch_assoc($locales)): ?>
                  <option value="<?php echo $row['cod_local']; ?>">
                  <?php echo htmlspecialchars($row['nombre_local']); ?>
                    </option>
                  <?php endwhile; ?>
              </select>
              <i class="bi bi-chevron-down position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: white;"></i>
            </div>
            
            <!-- <p>Archivo Multimedia</p>
            <div class="mb-3">
              <input class="form-control controls" type="file" id="formFile" />
            </div> -->
            <button class="btn btn-success boton-enviar" type="submit">Enviar</button>
          </form>
      </section>
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
