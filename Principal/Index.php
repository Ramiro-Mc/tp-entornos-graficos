<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");
sesionIniciada();

$folder = "Principal";
$pestaña = "Inicio";

$res = consultaSQL("SELECT foto_novedad, texto_novedad FROM novedades");

?>


<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Viventa Store</title>

</head>

<body>

  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main aria-label="Contenido principal">

    <!-- Seccion Presentacion -->

    <section class="presentacion" aria-label="Presentación Viventa Store">
      <div id="carouselExampleAutoplaying" class="carousel slide presentacion-carrousel" data-bs-ride="carousel" data-bs-pause="false" aria-label="Carrusel de imágenes de presentación">
        <div class="carousel-inner">
          <div class="carousel-item carousel-item-presentacion active">
            <img src="../Imagenes/Carrusel1.png" class="d-block w-100" alt="Imagen del shopping 1" />
          </div>
          <div class="carousel-item carousel-item-presentacion">
            <img src="../Imagenes/Carrusel2.png" class="d-block w-100" alt="Imagen del shopping 2" />
          </div>
          <div class="carousel-item carousel-item-presentacion">
            <img src="../Imagenes/Carrusel3.png" class="d-block w-100" alt="Imagen del shopping 3" />
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev" aria-label="Imagen anterior"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next" aria-label="Imagen siguiente"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
      </div>
      <div class="container descripcion-presentacion">
        <h2 class="mb-4 seccion-titulo"><strong>Viventa Store</strong></h2>
        <p class="mb-3">
          ¡El lugar donde la moda, la tecnología y la innovación se encuentran
          para transformar tu experiencia de compra en algo único!
        </p>
        <p class="mb-3">
          En Viventa Store no solo reunimos las mejores marcas nacionales e
          internacionales, sino que también creamos un espacio pensado para
          toda la familia: gastronomía, entretenimiento, servicios y ofertas
          exclusivas que hacen de cada visita una vivencia inolvidable.
          Descubrí nuestros locales con las últimas tendencias.
        </p>
        <p class="mb-3">
          Aprovechá las promociones que renovamos cada semana. Porque en
          Viventa Store, tu estilo de vida se convierte en una experiencia
          completa.
        </p>
      </div>
    </section>

    <!-- Seccion locales -->

    <section id="locales" class="locales seccion-oscura" aria-label="Locales">
      <h2 class="seccion-titulo"><strong>Nuestros Locales</strong></h2>

      <div class="container categoria-botones text-center">
        <form id="categorias" method="POST" action="filtrarLocales.php" class="d-inline" aria-label="Filtrar locales por categoría">
          <button type="submit" name="categoria" value="Todos" class="btn btn-secondary" aria-label="Ver todos los locales">Todos</button>
          <button type="submit" name="categoria" value="Accesorios" class="btn btn-secondary" aria-label="Ver locales de Accesorios">Accesorios</button>
          <button type="submit" name="categoria" value="Deportes" class="btn btn-secondary" aria-label="Ver locales de Deportes">Deportes</button>
          <button type="submit" name="categoria" value="Electro" class="btn btn-secondary" aria-label="Ver locales de Electro">Electro</button>
          <button type="submit" name="categoria" value="Estetica" class="btn btn-secondary" aria-label="Ver locales de Estética">Estetica</button>
          <button type="submit" name="categoria" value="Gastronomía" class="btn btn-secondary" aria-label="Ver locales de Gastronomía">Gastronomía</button>
          <button type="submit" name="categoria" value="Calzado" class="btn btn-secondary" aria-label="Ver locales de Calzado">Calzado</button>
          <button type="submit" name="categoria" value="Indumentaria" class="btn btn-secondary" aria-label="Ver locales de Indumentaria">Indumentaria</button>
          <button type="submit" name="categoria" value="Varios" class="btn btn-secondary" aria-label="Ver locales de Varios">Varios</button>
        </form>
      </div>

      <script>
        let categoriaSeleccionada = null;
        document.querySelectorAll('#categorias button').forEach(btn => {
          btn.addEventListener('click', function(e) {
            categoriaSeleccionada = this.value;
          });
        });

        document.getElementById('categorias').addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData();
          formData.append('categoria', categoriaSeleccionada);


          fetch(this.action, {
              method: 'POST',
              body: formData
            })
            .then(response => response.text())
            .then(data => {
              document.getElementById("respuesta").innerHTML = data;
              document.getElementById("locales-iniciales").style.display = "none";
            });
        });
      </script>

      <div class="container-fluid">
        <div id="locales-iniciales">
          <?php
          $result =  consultaSQL("SELECT foto_local, nombre_local, rubro_local, ubicacion_local FROM locales");

          if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
              $imagenLocal = $row['foto_local'];
              $nombre_local = $row['nombre_local']; ?>

              <div class="container-fluid">
                <div class="col-12 col-md-6 col-lg-4 ">
                  <div class="promocion-index">
                    <img src="data:image/jpeg;base64<?= $imagenLocal ?>" alt="Imagen de local <?= $nombre_local ?>" />
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

        </div>


        <div id="respuesta"></div>


      </div>

    </section>

    <!-- Seccion novedades -->

    <section id="novedades" class="novedades" aria-label="Novedades">
      <h2 class="seccion-titulo"><strong>¡Enterate de nuestras novedades!</strong></h2>
      <div id="carouselExampleIndicators" class="carousel slide ">
        <div class="carousel-indicators ">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <?php if ($res->num_rows > 0): ?>

            <?php while ($row = $res->fetch_assoc()): ?>

              <?php
              $foto_novedad = $row['foto_novedad'];
              $texto_novedad = $row['texto_novedad'];
              ?>

              <div class="carousel-item active carousel-item-novedades">
                <img src="data:image/jpeg;base64,<?= $foto_novedad ?>" class="d-block w-100" alt="Imagen de novedad: <?= $texto_novedad ?>" />
              </div>

            <?php endwhile; ?>

          <?php else: ?>
            No hay novedades vigentes.
          <?php endif; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
      </div>
    </section>

    <!-- seccion promociones -->

    <section id="promociones" class="promociones seccion-oscura" aria-label="Promociones">
      <h2 class="seccion-titulo"><strong>¡Promociones para morirse!</strong></h2>
      <div class="container text-center proyectos-contenedor">
        <div class="row">

          <?php
          if (isset($_SESSION['categoria_cliente'])) {
            $result =  consultaSQL("SELECT texto_promocion, foto_promocion, cod_local FROM promociones where categoria_cliente='{$_SESSION['categoria_cliente']}'");
          } else {
            $result =  consultaSQL("SELECT texto_promocion, foto_promocion, cod_local FROM promociones ");
          }

          $cantidad = 0; ?>

          <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()):  ?>

              <?php if ($cantidad < 6): ?>

                <?php $texto_promocion = $row['texto_promocion'];
                $foto_promocion = $row['foto_promocion'];
                $cantidad = $cantidad + 1; ?>
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="promocion-index"><img src="data:image/jpeg;base64,<?= $foto_promocion ?>" alt="Imagen de promoción: <?= $texto_promocion ?>" />
                    <div class="overlay">
                      <p><?= $texto_promocion ?></p>
                    </div>
                  </div>
                </div>

              <?php endif; ?>

            <?php endwhile; ?>

          <?php else: ?>
            <p>No hay promociones registradas.</p>
          <?php endif; ?>

        </div>
      </div>

      <div class="d-flex justify-content-center boton-vermas"><a href="../Cliente/BuscarPromociones.php" rel="noopener noreferer"><button type="button" class="btn btn-dark" aria-label="Ver más promociones">Ver mas promociones <i class="bi bi-arrow-right-circle"></i></button></a></div>
    </section>
  </main>

  <!-- Seccion Mapa Google Maps -->

  <section class="mapa-google" aria-label="Ubicación en Google Maps">
    <h2 class="seccion-titulo"><strong>Encontranos </strong></h2>
    <div class="mapa-container"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3593.617347374075!2d-80.263616524057!3d25.750164909080794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9ba2ed5cfe615%3A0xad638083c8eb0c89!2sViventa%20Miami!5e0!3m2!1ses-419!2sar!4v1750373072030!5m2!1ses-419!2sar" width="100%" height="100%" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa de Viventa Store"></iframe></div>
  </section>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>