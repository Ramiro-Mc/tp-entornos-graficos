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
      <section class="mb-5">
        <h2 class="seccion-titulo">Datos del Usuario</h2>
        <div class="datos-usuario text-start mx-auto panel-estilo" style="max-width: 600px;">
          <p><strong>Nombre:</strong> <?= $vnombre_usuario ?></p>
          <p><strong>Email:</strong> <?= $vemail ?></p>
          <p><strong>Tipo de Cliente:</strong> <?= $vcategoria_cliente ?></p>
          <button class="btn btn-success me-2 boton-enviar">Editar Perfil</button>
        </div></div>
      </section>

      <section>
        <h2 class="seccion-titulo">Historial de Compras</h2>
        <div class="datos-usuario text-start mx-auto panel-estilo" style="max-width: 600px; ">
            <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Local</th>
                <th>Producto</th>
                <th>Monto</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>10/07/2025</td>
                <td>Musimundo</td>
                <td>Lavarropas </td>
                <td>$12.000</td>
              </tr>
              <tr>
                <td>2</td>
                <td>22/06/2025</td>
                <td>Adidas</td>
                <td>Zapatillas </td>
                <td>$25.000</td>
              </tr>
           
            </tbody>
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
