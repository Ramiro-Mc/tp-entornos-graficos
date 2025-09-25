<?php
include_once("../Includes/session.php");
$folder = "Principal";
$pestaña = "Preguntas Frecuentes";
?>


<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Preguntas Frecuentes</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

 <main aria-label="Preguntas frecuentes">
    <div class="contenedor" aria-label="Sección de preguntas frecuentes">
      <div class="fondoSobreNosotros">
        <img src="../Imagenes/sobreNosotros.jpg" alt="Imagen de fondo Preguntas Frecuentes" aria-label="Imagen de Viventa Store" />
      </div>
      <div class="contenido" aria-label="Contenido de preguntas frecuentes">
        <br />
        <div class="sobreNosotros container mt-5" aria-label="Preguntas frecuentes sobre Viventa Store">
          <h2>Preguntas Frecuentes</h2>
          <p class="text-center">Aquí encontrarás las respuestas a las consultas más comunes sobre Viventa Store.</p>
          <br>
          
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Cuáles son los horarios de atención del shopping?</h4>
            <label>Nuestros horarios son:</label>
            <label>Lunes a Sábado: 10:00 a 21:00 hs</label>
            <label>Domingo y feriados: 11:00 a 20:00 hs</label>
            <label>Los horarios pueden variar en fechas especiales y feriados.</label>
          </div>
              <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿El estacionamiento es gratuito?</h4>
            <label>Sí, contamos con estacionamiento gratuito en 2 niveles cubiertos y descubiertos.</label>
            <label>Tenemos más de 800 espacios disponibles para mayor comodidad de nuestros visitantes.</label>
          </div>
               <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Hay Wi-Fi disponible en el shopping?</h4>
            <label>Sí, ofrecemos conexión Wi-Fi libre y gratuita en todo el predio.</label>
            <label>La red se llama "Viventa_WiFi_Free" y no requiere contraseña.</label>
          </div>
             <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Qué servicios tienen para familias con niños?</h4>
            <label>Contamos con diversos servicios para familias:</label>
            <label>Zona de juegos infantiles</label>
            <label>Cambiadores en todos los baños</label>
            <label>Lactario equipado</label>
            <label>Carritos especiales para niños</label>
          </div>
             <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Dónde puedo comer en el shopping?</h4>
            <label>Tenemos un amplio patio de comidas con más de 15 opciones gastronómicas:</label>
            <label>Comida rápida (hamburguesas, pizza, sushi)</label>
            <label>Opciones saludables y vegetarianas</label>
            <label>Cafeterías y heladerías</label>
            <label>Restaurantes temáticos</label>
          </div>
                  <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Hay cines en el shopping?</h4>
            <label>Sí, contamos con un complejo de cines con tecnología 4D y salas premium.</label>
            <label>Tenemos 8 salas con los últimos estrenos y funciones durante todo el día.</label>
          </div>
            <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Cómo llego al shopping en transporte público?</h4>
            <label>Puedes llegar fácilmente:</label>
            <label>Líneas de colectivo: 154, 128, 145, 112 y 134</label>
            <label>Estación de subte más cercana: Línea B - Estación Central (3 cuadras)</label>
            <label>También contamos con servicio de remis y taxis en la puerta principal</label>
          </div>
                  <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Hay cajeros automáticos disponibles?</h4>
            <label>Sí, contamos con cajeros automáticos de los principales bancos:</label>
            <label>Banco Nación, Banco Provincia, BBVA, Santander y más</label>
            <label>Ubicados en planta baja y primer piso para tu comodidad.</label>
          </div>
                 <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Ofrecen algún programa de descuentos o beneficios?</h4>
            <label>Sí, tenemos varios programas de beneficios:</label>
            <label>Tarjeta Viventa Club con descuentos exclusivos</label>
            <label>Newsletter con promociones semanales</label>
            <label>Descuentos especiales para estudiantes y jubilados</label>
            <label>Promociones en fechas especiales</label>
          </div>
               <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Qué medidas de seguridad tienen?</h4>
            <label>La seguridad de nuestros visitantes es primordial:</label>
            <label>Seguridad privada las 24 horas</label>
            <label>Circuito cerrado de cámaras en todas las áreas</label>
            <label>Sistemas de alarma y detección de incendios</label>
            <label>Personal de primeros auxilios</label>
          </div>
              <br>
          <div class="pregunta-respuesta mb-4">
            <h4 class="text-center">¿Cómo puedo contactarlos para consultas o reclamos?</h4>
            <label>Puedes contactarnos por diversos medios:</label>
            <label>Teléfono: +54 9 55 5555-5555</label>
            <label>Email: viventastore@gmail.com</label>
            <label>Oficina de Atención al Cliente (Planta Baja, Local 101)</label>
            <label>WhatsApp: +54 9 11 2345 6789</label>
          </div>
            <br>
          <br />
          <p class="text-center"><strong>¿No encontraste la respuesta que buscabas?</strong></p>
          <label>No dudes en <a href="Contacto.php">contactarnos</a>. Nuestro equipo de atención al cliente estará encantado de ayudarte.</label>
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