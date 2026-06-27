<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
sesionIniciada();

if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/InicioSesion.php");
  exit;
}

$folder = "Dueño";
$pestaña = "Crear Promocion";

$cod_usuario = $_SESSION['cod_usuario'];
include("../Includes/conexion.inc");
$mensaje = "";

$diasSemanaNombre = [
  1 => "Lunes",
  2 => "Martes",
  3 => "Miércoles",
  4 => "Jueves",
  5 => "Viernes",
  6 => "Sábado",
  7 => "Domingo"
];
$estado = "pendiente";

$sqlLocales = "SELECT cod_local, nombre_local FROM locales WHERE cod_usuario = '$cod_usuario'";
$locales = consultaSQL($sqlLocales);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $vTitulo = trim($_POST['texto_promocion'] ?? '');
  $vFechaInicio = $_POST['fechaini'] ?? '';
  $vFechaFin = $_POST['fechafin'] ?? '';
  $vCategoria = $_POST['Categoria'] ?? '';
  $vCodLocal = $_POST['cod_local'] ?? '';
  $diasSeleccionados = $_POST['cod_dia'] ?? [];
  
  $rutaMultimedia = ""; 

  // LÓGICA DE SUBIDA DE ARCHIVO UNIFICADA (Guarda en la carpeta uploads)
  if (isset($_FILES['imagen'])) {
      $errorSubida = $_FILES['imagen']['error'];
      
      if ($errorSubida === UPLOAD_ERR_OK) {
          $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
          $permitidos = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

          if (!in_array($ext, $permitidos)) {
              $mensaje = "<div class='alert alert-danger'>Formato de imagen no permitido. Solo JPG, PNG, GIF o WEBP.</div>";
          } else {
              $nuevoNombre = "promocion_" . uniqid() . "." . $ext;
              $destino = "../uploads/" . $nuevoNombre;

              if (!is_dir("../uploads/")) {
                  $mensaje = "<div class='alert alert-danger'>La carpeta '../uploads/' no existe. Debe estar creada en la raíz del proyecto.</div>";
              } else if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                  $rutaMultimedia = "uploads/" . $nuevoNombre;
              } else {
                  $mensaje = "<div class='alert alert-danger'>Hubo un error al guardar la imagen en el servidor. Verifique permisos.</div>";
              }
          }
      } else if ($errorSubida !== UPLOAD_ERR_NO_FILE) {
          $mensaje = "<div class='alert alert-danger'>Error al subir el archivo (Código PHP: $errorSubida).</div>";
      }
  }

  // Validaciones
  if ($vTitulo === '' && !$mensaje) $mensaje = "<div class='alert alert-danger'>Título requerido</div>";
  if (($vFechaInicio === '' || $vFechaFin === '') && !$mensaje) $mensaje = "<div class='alert alert-danger'>Fechas requeridas</div>";
  if ($vFechaInicio && $vFechaFin && $vFechaFin < $vFechaInicio && !$mensaje) $mensaje = "<div class='alert alert-danger'>Rango de fechas inválido</div>";
  if ($vCategoria === '' && !$mensaje) $mensaje = "<div class='alert alert-danger'>Categoría requerida</div>";
  if ($vCodLocal === '' && !$mensaje) $mensaje = "<div class='alert alert-danger'>Debe seleccionar un local</div>";
  if (empty($diasSeleccionados) && !$mensaje) $mensaje = "<div class='alert alert-danger'>Debe seleccionar al menos un día.</div>";
  if ($rutaMultimedia === '' && !$mensaje) $mensaje = "<div class='alert alert-danger'>Debe subir una imagen.</div>";

  // Inserción en Base de Datos
  if (!$mensaje) {
    // Guardamos la ruta física ($rutaMultimedia) en lugar del Base64 gigante
    $sql = "INSERT INTO promociones ( texto_promocion, fecha_desde_promocion, fecha_hasta_promocion, categoria_cliente, estado_promo, cod_local, foto_promocion )
              VALUES ('$vTitulo', '$vFechaInicio', '$vFechaFin', '$vCategoria','$estado', '$vCodLocal', '$rutaMultimedia')";
    
    if (mysqli_query($link, $sql)) {
      $idPromocion = mysqli_insert_id($link);

      if ($idPromocion > 0) {
        $sqlDias = "INSERT INTO promocion_dia (cod_promocion, cod_dia) VALUES ";
        foreach ($diasSeleccionados as $codDia) {
          $codDia = intval($codDia);
          $sqlDias .= "($idPromocion, $codDia),";
        }
        $sqlDias = rtrim($sqlDias, ',');
        
        if (!consultaSQL($sqlDias)) {
          $mensaje = "<div class='alert alert-danger'>Error al guardar los días.</div>";
        } else {
          $mensaje = "<div class='alert alert-success'>La promoción fue creada. Redirigiendo a tus locales...</div>";
          $destino = "SeccionDueñoLocal.php";
          header("Refresh: 3; url=" . urlencode($destino));
        }
      } else {
        $mensaje = "<div class='alert alert-danger'>Error al obtener el ID de la promoción.</div>";
      }
    } else {
      $mensaje = "<div class='alert alert-danger'>Error BD: " . mysqli_error($link) . "</div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <?php include("../Includes/head.php"); ?>
  <title>Crear Nueva Promocion</title>
</head>
<body>
  <header>
    <?php include("../Includes/header.php"); ?>
  </header>

  <main class="FondoDueñoAdministrador">
    <section class="form-register">
      <h4>Formulario Promoción</h4>
      <?php echo $mensaje; ?>
      <form method="POST" enctype="multipart/form-data" action="CrearPromocion.php">
        <label for="texto_promocion">Titulo</label>
        <input class="controls" type="text" id="texto_promocion" name="texto_promocion" placeholder="Título de la promoción" required />
        
        <p>Vigencia</p>
        <label for="fechaini">Inicio</label>
        <input class="controls" type="date" name="fechaini" id="fechaini" required />
        
        <label for="fechafin">Fin</label>
        <input class="controls" type="date" id="fechafin" name="fechafin" required />
        
        <label for="categoria">Categoría</label>
        <select class="form-control controls" id="categoria" required name="Categoria">
          <option>Inicial</option>
          <option>Medium</option>
          <option>Premium</option>
        </select>

        <label for="cod_local">Local asignado</label>
        <select class="form-control controls" id="cod_local" required name="cod_local">
          <option value="">Seleccione un local</option>
          <?php while ($row = mysqli_fetch_assoc($locales)): ?>
            <option value="<?php echo $row['cod_local']; ?>"><?php echo htmlspecialchars($row['nombre_local']); ?></option>
          <?php endwhile; ?>
        </select>

        <label>Días disponibles</label>
        <div class="mb-3">
          <?php foreach ($diasSemanaNombre as $codDia => $nombreDia): ?>
            <label style="display: block; margin-bottom: 5px;">
              <input type="checkbox" name="cod_dia[]" value="<?php echo $codDia; ?>">
              <?php echo htmlspecialchars($nombreDia); ?>
            </label>
          <?php endforeach; ?>
        </div>

        <label for="formFile">Imagen de la promoción</label>
        <input class="form-control controls" type="file" id="formFile" name="imagen" accept="image/*" required />
        
        <button class="btn btn-success boton-enviar" type="submit">Crear Promoción</button>
      </form>
    </section>
  </main>

  <footer class="seccion-footer">
    <?php include("../Includes/footer.php") ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>