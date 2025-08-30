<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Importar BootStrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <!-- Importar iconos BootStrap -->

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <!-- Metadatos -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Styles/style.css" />
    <link rel="stylesheet" href="../Styles/style-general.css" />
    <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
    <title>Buscar Locales</title>
  </head>

  <body>
    <header>

      <?php

      $folder = "Cliente";
      $pestaña = "BuscarLocales";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>

    </header>

    <main class="main-no-center">
  <div class="container-fluid">
    <div class="row">
      <div class="col-3 filtros d-none d-lg-block">
        <h3>Filtros</h3>

        <p>Local</p>
        <select class="filtros-categoria" name="local" id="">
          <option value="">Seleccionar local</option>
          <option value="local1">Local 1</option>
        </select>

        <p>Tipo cliente</p>
        <div class="filtros-categoria">
          <label><input type="checkbox" name="filtro" value="oficial" checked /> <span>Premium</span></label>
          <label><input type="checkbox" name="filtro" value="workshop" /> <span>Medium</span></label>
          <label><input type="checkbox" name="filtro" value="mis-fondos" checked /> <span>Inicial</span></label>
        </div>

        <p>Filtrar por categoria</p>
        <ul>
          <li><a href="#">Accesorios</a></li>
          <li><a href="#">Deportes</a></li>
          <li><a href="#">Electrónica</a></li>
          <li><a href="#">Estética</a></li>
          <li><a href="#">Gastronomía</a></li>
          <li><a href="#">Calzado</a></li>
          <li><a href="#">Indumentaria</a></li>
        </ul>

         <p>Ubicación</p>
        <select name="ubicacion" class="form-select">
        <option value="">Todas</option>
        <option value="a">Ala A</option>
        <option value="b">Ala B</option>
        <option value="c">Ala C</option>
         <option value="d">Ala D</option>
        <option value="e">Ala E</option>
        </select>

        <p>Tamaño del Local</p>
        <select name="tamano" class="form-select">
        <option value="">Cualquiera</option>
        <option value="pequeno">Pequeño</option>
        <option value="mediano">Mediano</option>
        <option value="grande">Grande</option>
        </select>
      </div>
      
        

      
      <div class="col-lg-9 col-12 listado-promociones">
        <button class="btn btn-light boton-filtros d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
          <i class="bi bi-funnel"></i> Filtros
        </button>

        <!-- Offcanvas -->
        <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">Filtros</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body filtros-desp">
            <p>Local</p>
            <select class="filtros-categoria" name="local" id="">
              <option value="">Seleccionar local</option>
              <option value="local1">Local 1</option>
            </select>

            <p>Tipo cliente</p>
            <div class="filtros-categoria">
              <label><input type="checkbox" name="filtro" value="oficial" checked /> <span>Premium</span></label>
              <label><input type="checkbox" name="filtro" value="workshop" /> <span>Medium</span></label>
              <label><input type="checkbox" name="filtro" value="mis-fondos" checked /> <span>Inicial</span></label>
            </div>

            <p>Filtrar por categoria</p>
            <ul>
              <li><a href="#">Accesorios</a></li>
              <li><a href="#">Deportes</a></li>
              <li><a href="#">Electrónica</a></li>
              <li><a href="#">Estética</a></li>
              <li><a href="#">Gastronomía</a></li>
              <li><a href="#">Calzado</a></li>
              <li><a href="#">Indumentaria</a></li>
            </ul>

            <p>Ubicación</p>
            <select class="form-select filtros-categoria" name="ubicacion">
            <option value="">Todas</option>
            <option value="a">Ala A</option>
            <option value="b">Ala B</option>
            <option value="c">Ala C</option>
            <option value="d">Ala D</option>
            <option value="e">Ala E</option>

            </select>

            <p>Tamaño del Local</p>
            <select class="form-select filtros-categoria" name="tamano">
            <option value="">Cualquiera</option>
            <option value="pequeno">Pequeño</option>
            <option value="mediano">Mediano</option>
            <option value="grande">Grande</option>
            </select>
          </div>
        </div>
      

      
        <div class="promocion-cli container-fluid">
          <div class="row">
            <div class="col-4 col-md-3 col-lg-4 col-xl-3">
              <img src="../Images/Carrusel1.png" />
            </div>
            <div class="col-8 col-md-9 col-lg-8 col-xl-9 d-flex justify-content-between align-items-center">
              <div class="info">
                <h3>Local 1</h3>
                <p>Local:</p>
                <p>Tipo de Cliente:</p>
                <p class="descripcion-promocion">Descripción breve del local:</p>
              </div>
              <button type="button" class="boton-codigo btn btn-secondary btn-lg">Ver <br /> Detalles</button>
              <button type="button" class="boton-codigo-chico"><i class="bi bi-qr-code"></i></button>
            </div>
          </div>
        </div>

       
        <div class="paginacion" aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>

    
    

     <footer
      class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4"
    >
      <div class="d-flex w-100 justify-content-center gap-5 px-5">
        <nav class="texto-footer">
          <h5>Mapa del sitio</h5>
          <div class="mb-2">
            <a href="../Principal/Index.html">Inicio</a>
          </div>
        </nav>

        <section class="texto-footer">
          <h5>Contacto</h5>
          <p>Email: <a href="#">contacto@viventastore.com</a></p>
          <p>Teléfono: <a href="#">+54 9 11 2345-6789</a></p>
          <p>Dirección: Calle 123, Ciudad</p>
        </section>
      </div>
      <p class="texto-footer text-center">
        © 2025 Viventa Store. Todos los derechos reservados.
      </p>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
