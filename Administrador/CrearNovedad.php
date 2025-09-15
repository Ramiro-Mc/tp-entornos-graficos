<?php
$folder = "Administrador";
$pestaña = "Crear Novedad";
include_once("../Includes/funciones.php");
include("../conexion.inc");
sesionIniciada();
$error = null;
$exito = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $texto = $_POST['texto_novedad'];
  $desde = $_POST['fecha_desde_novedad'];
  $hasta = $_POST['fecha_hasta_novedad'];
  $catCliente = $_POST['categoria_cliente'];
  $rutaMultimedia = null;
  if (!empty($_FILES['archivoMultimedia']['name']) && $_FILES['archivoMultimedia']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['archivoMultimedia']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'pdf'])) $error = "Formato no permitido.";
    else if (!move_uploaded_file($_FILES['archivoMultimedia']['tmp_name'], $destino = "../uploads/novedad_" . uniqid() . ".$ext")) $error = "Error al subir archivo.";
    else $rutaMultimedia = "uploads/" . basename($destino);
  }

  if ($hasta < $desde) $error = "La fecha de fin no puede ser menor que la de inicio.";
  if (!$error) {
    $stmt = $link->prepare("INSERT INTO novedades (texto_novedad, fecha_desde_novedad, fecha_hasta_novedad, categoria_cliente, foto_novedad) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
      $exito = $stmt->execute([$texto, $desde, $hasta, $catCliente, $rutaMultimedia]) ? "La novedad se guardó correctamente." : "Error al registrar: " . $stmt->error;
      $stmt->close();
    } else $error = "Error al preparar consulta: " . $link->error;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>
  <link rel="stylesheet" href="../Styles/style-general.css">
  <link rel="stylesheet" href="../Styles/style.css">
  <title>Crear Nueva Novedad</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="FondoDueñoAdministrador">
    <section class="form-register">
      <h4>Formulario Novedad</h4>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php elseif ($exito): ?>
        <div class="alert alert-success" id="mensaje-exito"><?= htmlspecialchars($exito) ?></div>
        <script>
          setTimeout(() => window.location.href = "AdministrarNovedades.php", 1000);
        </script>
      <?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <p>Descripción</p>
        <textarea class="controls" name="texto_novedad" rows="3" maxlength="200" required></textarea>
        <p>Vigencia de la promoción</p>
        <label for="fechaini">Fecha de inicio</label>
        <input class="controls" type="date" id="fechaini" name="fecha_desde_novedad" required />
        <label for="fechafin">Fecha de fin</label>
        <input class="controls" type="date" id="fechafin" name="fecha_hasta_novedad" required />

        <p>Categoria Cliente</p>
        <select class="form-control controls" name="categoria_cliente" required>
          <option value="inicial">Inicial</option>
          <option value="medium">Medium</option>
          <option value="premium">Premium</option>
        </select>
        <p>Archivo Multimedia</p>
        <div class="mb-3">
          <input
            class="form-control controls"
            type="file"
            name="archivoMultimedia" />
        </div>
        <div class="text-center mt-3">
          <button class="btn btn-success boton-enviar" type="submit">Crear</button>
          <a href="AdministrarNovedades.php" class="btn btn-secondary">Volver</a>
        </div>
      </form>
    </section>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>