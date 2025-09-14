<?php

$folder = "Administrador";
$pestaña = "Crear Novedad";
include_once("../Includes/funciones.php");
include("../conexion.inc");
sesionIniciada();
$mensaje = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $texto = $_POST['textoNovedad'];
  $desde = $_POST['fecha_desde_novedad'];
  $hasta = $_POST['fecha_hasta_novedad'];
  $catCliente = $_POST['categoria_cliente'];

  
    if ($hasta < $desde) {
        $error = "La fecha de fin no puede ser menor que la fecha de inicio.";
    } else {
        $sql = "INSERT INTO novedades (texto_novedad, fecha_desde_novedad, fecha_hasta_novedad, categoria_cliente)
                VALUES (?, ?, ?, ?)";

  $stmt = $link->prepare($sql);
  $stmt->bind_param("ssss", $texto, $desde, $hasta, $catCliente);

  if ($stmt->execute()) {
    $mensaje = "La novedad fue registrada correctamente.";
  } else {
    $mensaje = "Error al registrar: " . $link->error;
  }
  $stmt->close();
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
          <div class="alert <?= ($hasta < $desde) ? 'alert-danger' : 'alert-success' ?>">
              <?= htmlspecialchars($error) ?>
          </div>
      <?php endif; ?>

      <form method="post">
        <p>Descripción</p>
        <textarea class="controls" name="textoNovedad" rows="3" maxlength="200" required></textarea>

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
        <p>Podemos poner foto</p>
        <div class="text-center mt-3">
          <button class="btn btn-success boton-enviar" type="submit">Guardar</button>
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