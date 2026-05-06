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
        <div class="sobreNosotros container mt-5 mb-5" aria-label="Preguntas frecuentes sobre Viventa Store">
          
          <!-- Encabezado con estilo de Sobre Nosotros -->
          <div class="row text-center mb-5 seccion-texto-blanco">
            <div class="col-12">
              <h1 class="display-4 fw-bold mb-3 titulo-blanco">Preguntas Frecuentes</h1>
              <p class="lead">Aquí encontrarás las respuestas a las consultas más comunes sobre <strong>Viventa Store</strong>.</p>
            </div>
          </div>
          
          <!-- Acordeón de FAQs -->
          <div class="row justify-content-center">
            <div class="col-lg-10">
              <div class="accordion shadow-sm" id="accordionFAQ">
                
                <!-- Pregunta 1 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      <i class="bi bi-clock me-3 fs-5"></i> ¿Cuáles son los horarios de atención del shopping?
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-calendar-day text-primary me-2"></i><strong>Lunes a Sábado:</strong> 10:00 a 21:00 hs</li>
                        <li class="mb-2"><i class="bi bi-calendar-event text-primary me-2"></i><strong>Domingo y feriados:</strong> 11:00 a 20:00 hs</li>
                        <li class="small mt-3 text-muted border-top pt-2"><i class="bi bi-info-circle me-1"></i> Los horarios pueden variar en fechas especiales y feriados.</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 2 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <i class="bi bi-p-circle me-3 fs-5"></i> ¿El estacionamiento es gratuito?
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Sí</strong>, contamos con estacionamiento gratuito en 2 niveles cubiertos y descubiertos.</p>
                      <p class="mb-0"><i class="bi bi-car-front text-primary me-2"></i> Tenemos más de 800 espacios disponibles para mayor comodidad de nuestros visitantes.</p>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 3 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <i class="bi bi-wifi me-3 fs-5"></i> ¿Hay Wi-Fi disponible en el shopping?
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Sí</strong>, ofrecemos conexión Wi-Fi libre y gratuita en todo el predio.</p>
                      <p class="mb-0"><i class="bi bi-phone text-primary me-2"></i> La red se llama <strong>"Viventa_WiFi_Free"</strong> y no requiere contraseña.</p>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 4 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      <i class="bi bi-people me-3 fs-5"></i> ¿Qué servicios tienen para familias con niños?
                    </button>
                  </h2>
                  <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-3">Contamos con diversos servicios pensados para la mayor comodidad familiar:</p>
                      <div class="row">
                        <div class="col-md-6 mb-2"><i class="bi bi-controller text-primary me-2"></i> Zona de juegos infantiles</div>
                        <div class="col-md-6 mb-2"><i class="bi bi-person-hearts text-primary me-2"></i> Cambiadores en todos los baños</div>
                        <div class="col-md-6 mb-2"><i class="bi bi-cup-hot text-primary me-2"></i> Lactario equipado</div>
                        <div class="col-md-6 mb-2"><i class="bi bi-cart text-primary me-2"></i> Carritos especiales para niños</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 5 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      <i class="bi bi-shop me-3 fs-5"></i> ¿Dónde puedo comer en el shopping?
                    </button>
                  </h2>
                  <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-3">Tenemos un amplio patio de comidas con <strong>más de 15 opciones gastronómicas</strong>:</p>
                      <ul class="list-unstyled mb-0 row">
                        <li class="col-md-6 mb-2"><i class="bi bi-bag-heart text-primary me-2"></i> Comida rápida (hamburguesas, pizza)</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-flower1 text-success me-2"></i> Opciones saludables y vegetarianas</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-cup-straw text-primary me-2"></i> Cafeterías y heladerías</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-star text-warning me-2"></i> Restaurantes temáticos</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 6 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                      <i class="bi bi-film me-3 fs-5"></i> ¿Hay cines en el shopping?
                    </button>
                  </h2>
                  <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Sí</strong>, contamos con un complejo de cines con tecnología 4D y salas premium.</p>
                      <p class="mb-0"><i class="bi bi-camera-reels text-primary me-2"></i> Tenemos 8 salas con los últimos estrenos y funciones durante todo el día.</p>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 7 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                      <i class="bi bi-bus-front me-3 fs-5"></i> ¿Cómo llego al shopping en transporte público?
                    </button>
                  </h2>
                  <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-3">Puedes llegar fácilmente desde distintos puntos de la ciudad:</p>
                      <ul class="list-group list-group-flush border-0">
                        <li class="list-group-item bg-transparent px-0 border-0 mb-1"><i class="bi bi-bus-front-fill text-primary me-2"></i> <strong>Líneas de colectivo:</strong> 154, 128, 145, 112 y 134</li>
                        <li class="list-group-item bg-transparent px-0 border-0 mb-1"><i class="bi bi-train-front-fill text-primary me-2"></i> <strong>Subte:</strong> Línea B - Estación Central (a 3 cuadras)</li>
                        <li class="list-group-item bg-transparent px-0 border-0 mb-1"><i class="bi bi-taxi-front-fill text-primary me-2"></i> <strong>Taxis/Remis:</strong> Paradas exclusivas en la puerta principal</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 8 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                      <i class="bi bi-bank me-3 fs-5"></i> ¿Hay cajeros automáticos disponibles?
                    </button>
                  </h2>
                  <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Sí</strong>, contamos con cajeros automáticos de los principales bancos (Nación, Provincia, BBVA, Santander, etc).</p>
                      <p class="mb-0"><i class="bi bi-map text-primary me-2"></i> Están ubicados estratégicamente en <strong>planta baja</strong> y <strong>primer piso</strong>.</p>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 9 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                      <i class="bi bi-tags me-3 fs-5"></i> ¿Ofrecen algún programa de descuentos o beneficios?
                    </button>
                  </h2>
                  <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <ul class="list-unstyled mb-0 row">
                        <li class="col-md-6 mb-2"><i class="bi bi-credit-card-2-front text-primary me-2"></i> Tarjeta <strong>Viventa Club</strong> con descuentos</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-envelope-paper text-primary me-2"></i> Newsletter con promos semanales</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-person-check text-primary me-2"></i> Días especiales p/estudiantes y jubilados</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-calendar-star text-warning me-2"></i> Promociones en fechas especiales</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 10 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                      <i class="bi bi-shield-check me-3 fs-5"></i> ¿Qué medidas de seguridad tienen?
                    </button>
                  </h2>
                  <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <p class="mb-3">La seguridad de nuestros visitantes es primordial:</p>
                      <ul class="list-unstyled mb-0 row">
                        <li class="col-md-6 mb-2"><i class="bi bi-shield-fill-check text-success me-2"></i> Seguridad privada las 24 horas</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-camera-video text-primary me-2"></i> Circuito de cámaras en todo el predio</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-fire text-danger me-2"></i> Sistemas anti-incendios integrados</li>
                        <li class="col-md-6 mb-2"><i class="bi bi-heart-pulse text-danger me-2"></i> Personal de primeros auxilios</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Pregunta 11 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                  <h2 class="accordion-header" id="headingEleven">
                    <button class="accordion-button collapsed fw-bold text-primary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                      <i class="bi bi-headset me-3 fs-5"></i> ¿Cómo puedo contactarlos para consultas o reclamos?
                    </button>
                  </h2>
                  <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body text-secondary bg-light rounded-bottom border-top">
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <p class="mb-2"><i class="bi bi-telephone mb-1 me-2 text-primary"></i> <strong>Teléfono:</strong> +54 9 55 5555-5555</p>
                          <p class="mb-2"><i class="bi bi-whatsapp mb-1 me-2 text-success"></i> <strong>WhatsApp:</strong> +54 9 11 2345 6789</p>
                          <p class="mb-2"><i class="bi bi-envelope mb-1 me-2 text-danger"></i> <strong>Email:</strong> viventastore@gmail.com</p>
                          <p class="mb-0"><i class="bi bi-geo-alt mb-1 me-2 text-info"></i> Oficina de Atención al Cliente (PB, Local 101)</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- Footer CTA -->
              <div class="card mt-5 border-0 shadow-lg bg-light text-center p-4 rounded-4">
                <div class="card-body">
                  <h3 class="fw-bold text-primary mb-3"><i class="bi bi-question-circle text-warning me-2"></i>¿No encontraste la respuesta que buscabas?</h3>
                  <p class="text-secondary mb-4 fs-5">Nuestro equipo de atención al cliente estará encantado de ayudarte con cualquier consulta adicional.</p>
                  <a href="Contacto.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm transition-transform"><i class="bi bi-envelope-paper me-2"></i>Ir a Contacto</a>
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