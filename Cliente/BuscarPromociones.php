<?php
$folder = "Cliente";
$pestaña = "Buscar Promociones";
?>

<!DOCTYPE html>
<html lang="es">

  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Buscar Promociones</title>

  </head>

  <body>

    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main class="main-no-center">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-3 filtros d-none d-lg-block">
            <h3>Filtros</h3>

            <p>Local</p>

            <select class="filtros-categoria" name="local" id="">local</select>

            <p>Tipo cliente</p>

            <div class="filtros-categoria">
              <label><input type="checkbox" name="filtro" value="oficial" checked /><span>Premium</span></label>
              <label><input type="checkbox" name="filtro" value="workshop" /><span>Medium</span></label>
              <label><input type="checkbox" name="filtro" value="mis-fondos" checked /><span>Inicial</span></label>
            </div>

            <p>Filtrar por categoria</p>

            <ul>
              <li><a href="">Accesorios</a></li>
              <li><a href="">Deportes</a></li>
              <li><a href="">Electrónica</a></li>
              <li><a href="">Estética</a></li>
              <li><a href="">Gastronomía</a></li>
              <li><a href="">Calzado</a></li>
              <li><a href="">Indumentaria</a></li>
            </ul>

            <form>
              <div>
                <p>Fecha Desde</p>
                <input type="date" class="form-control id=" fechaDesde" required>
              </div>
              <div>
                <p>Fecha Hasta</p>
                <input type="date" class="form-control id=" fechaHasta" required>
              </div>
            </form>
          </div>

          <div class="col-lg-9 col-12 listado-promociones">
            <button
              class="btn btn-light boton-filtros d-lg-none"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#staticBackdrop"
              aria-controls="staticBackdrop">
              <i class="bi bi-funnel"></i> Filtros
            </button>

            <div
              class="offcanvas offcanvas-start"
              data-bs-backdrop="static"
              tabindex="-1"
              id="staticBackdrop"
              aria-labelledby="staticBackdropLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="staticBackdropLabel">
                  Filtros
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="offcanvas"
                  aria-label="Close"></button>
              </div>
              <div class="offcanvas-body filtros-desp">
                <div>
                  <!-- ACA ESTA EL OFFCANVAS DE FILTROS -->
                  <p>Local</p>

                  <select class="filtros-categoria" name="local" id="">
                    <option value="">Seleccionar local</option>
                    <option value="nike">Nike Store</option>
                    <option value="adidas">Adidas Originals</option>
                  </select>

                  <p>Tipo cliente</p>

                  <div class="filtros-categoria">
                    <label><input type="checkbox" name="filtro" value="oficial" checked /><span>Premium</span></label>
                    <label><input type="checkbox" name="filtro" value="workshop" /><span>Medium</span></label>
                    <label><input type="checkbox" name="filtro" value="mis-fondos" checked /><span>Inicial</span></label>
                  </div>

                  <p>Filtrar por categoria</p>

                  <ul>
                    <li><a href="">Accesorios</a></li>
                    <li><a href="">Deportes</a></li>
                    <li><a href="">Electrónica</a></li>
                    <li><a href="">Estética</a></li>
                    <li><a href="">Gastronomía</a></li>
                    <li><a href="">Calzado</a></li>
                    <li><a href="">Indumentaria</a></li>
                  </ul>

                  <form>
                    <div>
                      <p>Fecha Desde</p><input type="date" class="form-control id=" fechaDesde" required>
                    </div>
                    <div>
                      <p>Fecha Hasta</p><input type="date" class="form-control id=" fechaHasta" required>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Esto hay que printearlo dentro de una iteracion -->
            <div class="promocion-cli container-fluid">
              <div class="row">
                <div class="col-4 col-md-3 col-lg-4 col-xl-3"><img src="../Images/Carrusel1.png" /></div>
                <div class="col-8 col-md-9 col-lg-8 col-xl-9 d-flex justify-content-between align-items-center">
                  <div class="info">
                    <h3>Promoción 1</h3>
                    <p>Local:</p>
                    <p>Tipo de Cliente:</p>
                    <p class="descripcion-promocion">Descripción breve de la promoción 1</p>
                  </div><button type="button " class="boton-codigo btn btn-secondary btn-lg">Generar <br />Código</button><button type="button" class="boton-codigo-chico"><i class="bi bi-qr-code"></i></button>
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

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

      <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>

</html>