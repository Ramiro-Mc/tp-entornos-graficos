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
        <div class="sobreNosotros container mt-5" aria-label="Información sobre Viventa Shopping">
          <h2>Sobre Nosotros</h2>
          <label>Bienvenido a Viventa Shopping, el lugar donde la innovación, la variedad y la experiencia de compra se combinan para ofrecerte lo mejor.</label>
          <label>Desde nuestros inicios, nos propusimos ser más que un simple centro comercial: queremos ser un espacio de encuentro, de inspiración y de disfrute para toda la familia. Por eso, en nuestras tiendas encontrarás productos de marcas líderes, tecnología de vanguardia, moda para todas las edades, gastronomía variada y opciones de entretenimiento para grandes y chicos.</label>
          <label>Nuestro compromiso con la calidad y el servicio nos ha permitido consolidarnos como el shopping preferido de la ciudad. Contamos con un equipo de profesionales capacitados para brindarte una atención personalizada, asegurando que cada visita sea una experiencia única y satisfactoria.</label>
          <label>En Viventa Shopping, la comodidad de nuestros clientes es nuestra prioridad. Contamos con amplios estacionamientos, zonas de descanso, conexión Wi-Fi gratuita y un servicio de atención personalizada que nos distingue.</label>
          <label>Te invitamos a visitarnos y descubrir por qué somos el shopping preferido de la ciudad. ¡En Viventa Shopping, siempre hay algo nuevo para vos!</label>
          <br />
          <h2>Datos de Contacto</h2>
          <label>Dirección: Av. Central 456, Ciudad Shopping, Buenos Aires, Argentina</label>
          <label>Teléfono: +54 9 11 2345 6789</label>
          <label>Email: contacto@viventashopping.com</label>
          <label>Horarios de atención:</label>
          <label>🕘 Lunes a Sábado: 10:00 a 21:00 hs</label>
          <label>🕘 Domingo y feriados: 11:00 a 20:00 hs</label>
          <label>Estacionamiento: 2 niveles cubiertos y descubiertos gratuitos.</label>
          <br />
          <label>Wi-Fi: Libre y gratuito en todo el predio.</label>
          <label>Servicios adicionales: Zona de juegos infantiles, patio de comidas, salas de cine 4D, cajeros automáticos, atención al cliente.</label>
          <br />
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