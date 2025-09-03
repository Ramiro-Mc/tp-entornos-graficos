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

      <?php include("../Includes/header.php");?>

    </header>

    <main>
      <div class="contenedor">
        <div class="fondoSobreNosotros">
          <img src="../Images/sobreNosotros.jpg" alt="Fondo" />
        </div>
        <div class="contenido">
          <br />
          <div class="sobreNosotros container mt-5">
            <h2>Sobre Nosotros</h2>
            <p>
              Bienvenido a Viventa Shopping, el lugar donde la innovación, la
              variedad y la experiencia de compra se combinan para ofrecerte lo
              mejor.
            </p>
            <p>
              Desde nuestros inicios, nos propusimos ser más que un simple
              centro comercial: queremos ser un espacio de encuentro, de
              inspiración y de disfrute para toda la familia. Por eso, en
              nuestras tiendas encontrarás productos de marcas líderes,
              tecnología de vanguardia, moda para todas las edades, gastronomía
              variada y opciones de entretenimiento para grandes y chicos.
            </p>
            <p>
              Nuestro compromiso con la calidad y el servicio nos ha permitido
              consolidarnos como el shopping preferido de la ciudad. Contamos
              con un equipo de profesionales capacitados para brindarte una
              atención personalizada, asegurando que cada visita sea una
              experiencia única y satisfactoria.
            </p>
            <p>
              En Viventa Shopping, la comodidad de nuestros clientes es nuestra
              prioridad. Contamos con amplios estacionamientos, zonas de
              descanso, conexión Wi-Fi gratuita y un servicio de atención
              personalizada que nos distingue.
            </p>
            <p>
              Te invitamos a visitarnos y descubrir por qué somos el shopping
              preferido de la ciudad. ¡En Viventa Shopping, siempre hay algo
              nuevo para vos!
            </p>
            <br />
            <h2>Datos de Contacto</h2>
            <p>
               Dirección: Av. Central 456, Ciudad Shopping, Buenos Aires,
              Argentina
            </p>
            <p> Teléfono: +54 9 11 2345 6789</p>
            <p> Email: contacto@viventashopping.com</p>
            <p> Horarios de atención:</p>
            <p> 🕘 Lunes a Sábado: 10:00 a 21:00 hs</p>
            <p> 🕘 Domingo y feriados: 11:00 a 20:00 hs</p>
            <p>
               Estacionamiento: 2 niveles cubiertos y descubiertos gratuitos.
            </p>
            <br />
            <p> Wi-Fi: Libre y gratuito en todo el predio.</p>
            <p>
               Servicios adicionales: Zona de juegos infantiles, patio de
              comidas, salas de cine 4D, cajeros automáticos, atención al
              cliente.
            </p>
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
