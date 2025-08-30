<?php 
include_once("session.php");

if($folder == "Administrador"){
  $opciones = ["Inicio", "Administrar Promociones", "Administrar Novedades", "Administrar Locales", "Solicitudes De Registro", "Reportes De Uso Promociones", "Sobre Nosotros"];
}elseif($folder == "Dueño"){
  $opciones = ["Seccion Dueño Local", "Crear Promocion", "Mis Promociones", "Reporte Promociones"];
}elseif($folder == "Principal" || $folder == "Cliente"){
  $opciones = ["Index", "Contacto", "Sobre Nosotros"];
}

$opciones_filtradas = array_filter($opciones, function($item) use ($pestaña) {
  return $item !== $pestaña;
});
$opciones_filtradas = array_values($opciones_filtradas); // Reindexa el array

$opciones_sin_espacios = array_map(function($item) {
  return str_replace(' ', '', $item);
}, $opciones_filtradas);

if(isset($_SESSION['tipo_usuario'])){
  if($_SESSION['tipo_usuario'] == "cliente"){
    $opciones_extra = ["Mi Perfil", "Buscar Promociones", "Buscar Locales"];
    
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


<footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">
  <div class="container d-flex flex-wrap justify-content-center gap-5 px-0">
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

    <nav class="texto-footer">

      <h5>Mapa del sitio</h5>

      <ul>
        <?php 
        
        foreach ($opciones_filtradas as $key => $item) {
          echo "<li><a href='../Principal/" . $opciones_sin_espacios[$key] .".php'>". $item ."</a></li>";
        }

        if(isset($opciones_extra)){
          foreach ($opciones_extra_filtradas as $key => $item) {
            echo "<li><a href='../Cliente/" . $opciones_extra_sin_espacios[$key] .".php'>". $item ."</a></li>";
          }
        }
        ?>
      </ul>

    </nav>
    <section class="texto-footer">
      <h5>Contacto</h5>
      <p>
        Email:
        <a href="#">contacto@viventastore.com</a>
      </p>
      <p>
        Teléfono:
        <a href="#">+54 9 11 2345-6789</a>
      </p>
      <p>Dirección: Calle 123, Ciudad</p>
    </section>
  </div>

  <p class="texto-footer text-center">© 2025 Viventa Store. Todos los derechos reservados.</p>
</footer>
