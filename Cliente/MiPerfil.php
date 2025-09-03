<?php

include_once("../Includes/session.php");
include_once("../Includes/funciones.php");

if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/login.php");
  exit;
}

$folder = "Cliente";
$pestaña = "Mi Perfil";

$cod_usuario = $_SESSION['cod_usuario'];

$res = consultaSQL("SELECT nombre_usuario, email FROM usuario WHERE cod_usuario = '$cod_usuario'");
$row = mysqli_fetch_assoc($res); 
$vnombre_usuario = $row['nombre_usuario'] ?? ''; 
$vemail = $row['email'] ?? '';

$res = consultaSQL("SELECT categoria_cliente FROM cliente WHERE cod_usuario = '$cod_usuario'");
$row = mysqli_fetch_assoc($res); 
$vcategoria_cliente = $row['categoria_cliente'] ?? '';


$result = consultaSQL("
  SELECT 
  pro.texto_promocion, sol.fecha_uso_promocion, loc.nombre_local 
  FROM uso_promociones sol
  INNER JOIN promociones pro ON sol.cod_promocion = pro.cod_promocion
  INNER JOIN locales loc ON pro.cod_local = loc.cod_local
  WHERE sol.cod_usuario = {$cod_usuario} AND estado ='aceptada'"
);
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Mi Perfil</title>

  </head>
  
  <body>
    <header>

      <?php include("../Includes/header.php");?>

    </header>

    <main class="fondo-formulario-contacto">

      <div class="formulario-contacto text-center">
        <h2 class="seccion-titulo">Datos del Usuario</h2>
        <div class="datos-usuario text-start mx-auto panel-estilo">
          <p><strong>Nombre:</strong> <?= $vnombre_usuario ?></p>
          <p><strong>Email:</strong> <?= $vemail ?></p>
          <p><strong>Tipo de Cliente:</strong> <?= $vcategoria_cliente ?></p>
          <button class="btn btn-success me-2 boton-enviar">Editar Perfil</button>
        </div>
      </div>

      <section>
        <h2 class="seccion-titulo">Historial de Promociones Usadas</h2>
        <div class="datos-usuario text-center mx-auto panel-estilo mb-5">
          <table class="table table-striped table-dark">
          
            <?php if ($result->num_rows > 0): ?>
              <?php $nro_promo = 1; ?>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Promocion</th>
                  <th>Local</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody>

                <?php while ($row = $result->fetch_assoc()): ?>

                  <?php
                  $vfecha_uso_promocion = $row['fecha_uso_promocion'] ?? '';
                  $vtexto_promocion = $row['texto_promocion'] ?? '';
                  $vnombre_local = $row['nombre_local'] ?? '';?>

                  <tr>
                    <td><?= $nro_promo ?></td>
                    <td><?= $vtexto_promocion ?></td>
                    <td><?= $vnombre_local ?></td>
                    <td><?= $vfecha_uso_promocion ?></td>
                  </tr>

                  <?php $nro_promo ++; ?>
                <?php endwhile; ?>
              </tbody>

            <?php else: ?>
              <p style="margin: 0;" class="pt-2">Aun no has usado ninguna promocion</p>
              <a href="../Cliente/BuscarPromociones.php">Usar una promocion</a>
            <?php endif; ?>
           
          </table>
        </div>
      </section>
    </main>


    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

      <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
