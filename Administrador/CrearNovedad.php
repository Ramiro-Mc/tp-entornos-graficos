<?php

$folder = "Administrador";
$pestaña = "Crear Novedad";

include("../conexion.inc");
$mensaje = "";

// Traigo usuarios para el combo
$sqlUsuarios = "SELECT cod_usuario, nombre_usuario, tipo_usuario FROM usuarios";
$resUsuarios = mysqli_query($link, $sqlUsuarios) or die(mysqli_error($link));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $texto = $_POST['textoNovedad'];
  $desde = $_POST['fecha_desde_novedad'];
  $hasta = $_POST['fecha_hasta_novedad'];
  $tipoUsuario = $_POST['tipo_usuario'];
  $codUsuario = $_POST['cod_usuario'];

  $sql = "INSERT INTO novedades (textoNovedad, fecha_desde_novedad, fecha_hasta_novedad, tipo_usuario, cod_usuario)
          VALUES (?, ?, ?, ?, ?)";
  $stmt = $link->prepare($sql);
  $stmt->bind_param("ssssi", $texto, $desde, $hasta, $tipoUsuario, $codUsuario);

  if ($stmt->execute()) {
    $mensaje = "La novedad fue registrada correctamente.";
  } else {
    $mensaje = "Error al registrar: " . $link->error;
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Crear Nueva Novedad</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="FondoDueñoAdministrador">
    <section class="form-register">
      <h4>Formulario Novedad</h4>

      <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
      <?php endif; ?>

      <form method="post">
        <p>Descripción</p>
        <textarea class="controls" name="textoNovedad" rows="3" maxlength="200" style="resize: none; overflow-y: hidden" required></textarea>

        <p>Vigencia de la promoción</p>
        <label for="fechaini">Fecha de inicio</label>
        <input class="controls" type="date" id="fechaini" name="fecha_desde_novedad" required />
        <label for="fechafin">Fecha de fin</label>
        <input class="controls" type="date" id="fechafin" name="fecha_hasta_novedad" required />

        <p>Tipo Usuario</p>
        <select class="form-control controls" name="tipo_usuario" required>
          <option value="dueño">Dueño</option>
          <option value="cliente">Cliente</option>
          <option value="administrador">Administrador</option>
        </select>

        <p>Usuario</p>
        <div class="position-relative">
          <select class="form-control controls" name="cod_usuario" required>
            <option value="">Seleccione un usuario</option>
            <?php while ($u = mysqli_fetch_assoc($resUsuarios)): ?>
              <option value="<?= $u['cod_usuario'] ?>"><?= htmlspecialchars($u['nombre_usuario']) ?> (<?= $u['tipo_usuario'] ?>)</option>
            <?php endwhile; ?>
          </select>
          <i class="bi bi-chevron-down position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: white;"></i>
        </div>

        <div class="d-flex justify-content-between mt-3">
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