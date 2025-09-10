<?php 
include_once("session.php");

if($folder == "Administrador"){
  $opciones = ["Seccion Administrador", "Administrar Promociones", "Administrar Novedades", "Administrar Locales", "Solicitudes De Registro", "Reporte Promociones"];
}elseif($folder == "Dueño"){
  $opciones = ["Seccion Dueño Local", "Crear Promocion", "Mis Promociones", "Administrar Solicitudes"];
}elseif($folder == "Principal" || $folder == "Cliente"){
  $opciones = ["Inicio", "Contacto", "Sobre Nosotros"];
}

$opciones_filtradas = array_filter($opciones, function($item) use ($pestaña) {
  return $item !== $pestaña;
});
$opciones_filtradas = array_values($opciones_filtradas); // Reindexa el array

$opciones_sin_espacios = array_map(function($item) {
  return str_replace(' ', '', $item);
}, $opciones_filtradas); //Saca los espacios

if(isset($_SESSION['tipo_usuario'])){
  if($_SESSION['tipo_usuario'] == "cliente"){
    $opciones_extra = ["Mi Perfil", "Mis Cupones", "Buscar Promociones"];
    
    $opciones_extra_filtradas = array_filter($opciones_extra, function($item) use ($pestaña) {
      return $item !== $pestaña;
    });
    $opciones_extra_filtradas = array_values($opciones_extra_filtradas); // Reindexa el array

    $opciones_extra_sin_espacios = array_map(function($item) {
      return str_replace(' ', '', $item);
    }, $opciones_extra_filtradas);


  }
}


?>

<h5 style="font-family: Math_Italic; font-size:2.5rem; color: #B9C3CD">Viventa Store</h5>

<div class="container d-flex flex-wrap justify-content-center gap-5 px-0">

  <!-- Redes sociales -->

    <?php if($folder != "Administrador" && $folder != "Dueño"): ?>

      <div class="iconos-redes-sociales d-flex flex-column gap-2 texto-footer">
        <h5 class="text-center">Redes Sociales</h5>
        <div class="d-flex gap-3">
          <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-instagram fs-4"></i>
          </a>
          <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-facebook fs-4"></i>
          </a>
          <a href="https://www.whatsapp.com/" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-whatsapp fs-4"></i>
          </a>
          <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-youtube fs-4"></i>
          </a>
        </div>
      </div>

    <?php endif; ?>

  <!-- Fin redes sociales -->

  <nav class="texto-footer">

    <h5>Mapa del sitio</h5>

    <ul>
      <?php 

      if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == "cliente"){
        foreach ($opciones_extra_filtradas as $key => $item) {
          echo "<li><a href='../Cliente/" . $opciones_extra_sin_espacios[$key] .".php'>". $item ."</a></li>";
        }
        foreach ($opciones_filtradas as $key => $item) {
          if($opciones_sin_espacios[$key] == "Inicio"){
            echo "<li><a href='../Principal/Index.php'>Inicio</a></li>";
          }else{
            echo "<li><a href='../Principal/" . $opciones_sin_espacios[$key] .".php'>". $item ."</a></li>";
          }
        }
      }else{
        foreach ($opciones_filtradas as $key => $item) {
          if($opciones_sin_espacios[$key] == "Inicio"){
            echo "<li><a href='../Principal/Index.php'>Inicio</a></li>";
          }else{
            echo "<li><a href='../Principal/" . $opciones_sin_espacios[$key] .".php'>". $item ."</a></li>";
          }
        }
      }
      ?>
    </ul>

  </nav>

  <!-- Contacto -->

    <?php if($folder != "Administrador"): ?>

      <section class="texto-footer">
        <h5>Contacto</h5>
        <p>
          Email:
          <a href="mailto:viventastore@gmail.com?subject=Consulta%20Viventa%20Store">viventastore@gmail.com</a>
        </p>
        <p>
          Teléfono:
          +54 9 55 5555-5555
        </p>
        <p>Dirección: Calle 123, Ciudad</p>
      </section>

    <?php endif; ?>

  <!-- Fin contacto -->

</div>

<p class="texto-footer text-center">© 2025 Viventa Store. Todos los derechos reservados.</p>
