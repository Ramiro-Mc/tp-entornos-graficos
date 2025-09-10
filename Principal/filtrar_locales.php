<?php 

  include_once("../Includes/session.php");
  include_once("../Includes/funciones.php");

  $cat = $_POST['categoria'];

  if($cat == "Todos"){
    $result =  consultaSQL("SELECT foto_local, nombre_local, rubro_local, ubicacion_local FROM locales");
  }else{
    $result =  consultaSQL("SELECT foto_local, nombre_local, rubro_local, ubicacion_local FROM locales where rubro_local='$cat'");
  }
?>

<?php if ($result->num_rows > 0): ?>

  <?php while ($row = $result->fetch_assoc()): ?>

    <?php $imagenLocal = $row['foto_local']; 
    $nombre_local = $row['nombre_local']; ?>

    <div class="container-fluid">
      <div class="col-12 col-md-6 col-lg-4 ">
        <div class="promocion-index">
          <img src="data:image/jpeg;base64<?= $imagenLocal ?>" alt="Imagen <?= $nombre_local ?>" />
          <div class="overlay">
            <p><?= $nombre_local ?></p>
          </div>
        </div>
      </div>
    </div>

  <?php endwhile; ?>

<?php else: ?>
  <div class="notificacion-no-promociones">
    <h3>¡Vaya!</h3>
    <p style="margin: 0;">Aun no hay locales para esta categoria</p>
  </div>
<?php endif; ?>
