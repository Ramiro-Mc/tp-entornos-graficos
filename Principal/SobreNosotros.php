<?php
include_once("../Includes/session.php");
$folder = "Principal";
$pestaña = "Sobre Nosotros";
?>


<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Sobre Nosotros</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main aria-label="Página Sobre Nosotros">
    <div class="contenedor" aria-label="Sección principal Sobre Nosotros">
      <div class="fondoSobreNosotros">
        <img src="../Imagenes/sobreNosotros.jpg" alt="Imagen de fondo Sobre Nosotros" aria-label="Imagen institucional de Viventa Shopping" />
      </div>
      <div class="contenido" aria-label="Contenido informativo Sobre Nosotros">
        <br />
        <div class="sobreNosotros container mt-5 mb-5" aria-label="Información sobre Viventa Shopping">
          <!-- Introducción -->
          <div class="row text-center mb-5 seccion-texto-blanco">
            <div class="col-12">
              <h1 class="display-4 fw-bold mb-3 titulo-blanco">Sobre Nosotros</h1>
              <p class="lead">Bienvenido a <strong>Viventa Shopping</strong>, el lugar donde la innovación, la variedad y la experiencia de compra se combinan para ofrecerte lo mejor.</p>
            </div>
          </div>
          
          <div class="row align-items-center mb-5 seccion-texto-blanco">
            <div class="col-md-6 mb-4 mb-md-0">
              <h3 class="fw-semibold">Nuestra Historia</h3>
              <p>Desde nuestros inicios, nos propusimos ser más que un simple centro comercial: queremos ser un espacio de encuentro, de inspiración y de disfrute para toda la familia. Por eso, en nuestras tiendas encontrarás productos de marcas líderes, tecnología de vanguardia, moda para todas las edades, gastronomía variada y opciones de entretenimiento para grandes y chicos.</p>
              <p>Nuestro compromiso con la calidad y el servicio nos ha permitido consolidarnos como el shopping preferido de la ciudad. Contamos con un equipo de profesionales capacitados para brindarte una atención personalizada, asegurando que cada visita sea una experiencia única y satisfactoria.</p>
            </div>
            <div class="col-md-6 border-start border-3 borde-separador ps-4">
              <h3 class="fw-semibold">Nuestra Misión</h3>
              <p>En <strong>Viventa Shopping</strong>, la comodidad de nuestros clientes es nuestra prioridad. Contamos con amplios estacionamientos, zonas de descanso, conexión Wi-Fi gratuita y un servicio de atención personalizada que nos distingue.</p>
              <p class="fw-bold">¡Te invitamos a visitarnos y descubrir por qué somos el shopping preferido de la ciudad. En Viventa Shopping, siempre hay algo nuevo para vos!</p>
            </div>
          </div>

          <hr class="my-5 linea-separadora">

          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-5">
                  <h2 class="card-title text-center fw-bold text-primary mb-4">Datos de Contacto</h2>
                  
                  <div class="row mt-4">
                    <div class="col-md-6 pt-2 pb-2">
                      <h5 class="fw-semibold"><i class="bi bi-geo-alt text-danger me-2"></i>Dirección</h5>
                      <p class="text-secondary mb-3">Av. Central 456, Ciudad Shopping, Buenos Aires, Argentina</p>
                      
                      <h5 class="fw-semibold"><i class="bi bi-telephone text-success me-2"></i>Teléfono</h5>
                      <p class="text-secondary mb-3">+54 9 11 2345 6789</p>
                      
                      <h5 class="fw-semibold"><i class="bi bi-envelope text-primary me-2"></i>Email</h5>
                      <p class="text-secondary mb-0">contacto@viventashopping.com</p>
                    </div>
                    
                    <div class="col-md-6 pt-2 pb-2">
                      <h5 class="fw-semibold"><i class="bi bi-clock text-warning me-2"></i>Horarios de atención</h5>
                      <ul class="list-unstyled text-secondary mb-3">
                        <li><i class="bi bi-check2 text-primary me-1"></i> Lunes a Sábado: 10:00 a 21:00 hs</li>
                        <li><i class="bi bi-check2 text-primary me-1"></i> Domingo y feriados: 11:00 a 20:00 hs</li>
                      </ul>
                      
                      <h5 class="fw-semibold"><i class="bi bi-info-circle text-info me-2"></i>Servicios</h5>
                      <ul class="list-unstyled text-secondary mb-0">
                        <li><i class="bi bi-car-front text-primary me-1"></i> Estacionamiento gratuito (2 niveles)</li>
                        <li><i class="bi bi-wifi text-primary me-1"></i> Wi-Fi libre en todo el predio</li>
                        <li><i class="bi bi-controller text-primary me-1"></i> Juegos, cines 4D y patio de comidas</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>