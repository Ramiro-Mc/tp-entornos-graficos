<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");
include_once("../Includes/head.php");

$cat = $_POST['categoria'];

if ($cat == "Todos") {
  $result =  consultaSQL("SELECT foto_local, nombre_local, rubro_local, ubicacion_local FROM locales");
} else {
  $result =  consultaSQL("SELECT foto_local, nombre_local, rubro_local, ubicacion_local FROM locales where rubro_local='$cat'");
}
?>

<?php if ($result->num_rows > 0): ?>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

    <?php while ($row = $result->fetch_assoc()): ?>

      <?php
      $imagenLocal = $row['foto_local'];
      $nombre_local = $row['nombre_local'];
      ?>

      <div class="col">
        <div class="promocion-index">
          <img src="../<?= $imagenLocal ?>" alt="<?= $nombre_local ?>">
          <div class="overlay">
            <p><?= $nombre_local ?></p>
          </div>
        </div>
      </div>

    <?php endwhile; ?>

  </div> <?php else: ?>

  <div class="col-12">
    <div class="notificacion-no-promociones">
      <h3>¡Vaya!</h3>
      <p style="margin: 0;">Aun no hay locales para esta categoria</p>
    </div>
  </div>

<?php endif; ?>