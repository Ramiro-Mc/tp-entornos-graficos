<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");

$folder = "Cliente";
$pestaña = "Buscar Promociones";

if(!isset($_POST['rubro']) and isset($_POST['rubroAnterior'])){
  $rubro = $_POST['rubroAnterior'];
}elseif(isset($_POST['rubro'])){
  $rubro = $_POST['rubro'];
}

$vlocales = consultaSQL("SELECT nombre_local FROM locales");

$where = [];
if (isset($rubro) && $rubro != "Todos") {
    $where[] = "l.rubro_local = '{$rubro}'";
}
if (isset($_POST['categoria']) && $_POST['categoria'] != "Cualquiera") {
    $where[] = "p.categoria_cliente = '{$_POST['categoria']}'";
}
if (isset($_POST['local']) && $_POST['local'] != "Cualquiera") {
    $where[] = "l.nombre_local = '{$_POST['local']}'";
}

$where_sql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT 
    p.texto_promocion, 
    p.categoria_cliente, 
    p.foto_promocion, 
    l.nombre_local
FROM promociones p
INNER JOIN locales l ON p.cod_local = l.cod_local
{$where_sql}";

$result = consultaSQL($sql);
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

            <form id="filtros-promociones" method="POST" action="">
              <p>Local </p>

              <select class="select-filtros" name="local">

                <option name="local" value="Cualquiera">Cualquiera</option>

                <?php if ($vlocales->num_rows > 0): ?>

                  <?php while ($row = $vlocales->fetch_assoc()): ?>

                    <?php $nombre_local = $row['nombre_local']; ?>

                    <option name="local" value="<?= $nombre_local ?>" <?= (isset($_POST['local']) && $_POST['local'] == $nombre_local) ? "selected" : ""?>><?= $nombre_local ?></option>

                  <?php endwhile; ?>

                <?php else: ?>
                  No hay locales registrados.
                <?php endif; ?>
              </select>

              <p>Tipo cliente</p>

              <select class="select-filtros" name="categoria" id="">
                <option name="categoria" value="Cualquiera">Cualquiera</option>
                <option name="categoria" value="Premium" <?= (isset($_POST['categoria']) && $_POST['categoria'] == "Premium") ? "selected" : ""?>>Premium</option>
                <option name="categoria" value="Medium" <?= (isset($_POST['categoria']) && $_POST['categoria'] == "Medium") ? "selected" : ""?>>Medium</option>
                <option name="categoria" value="Inicial" <?= (isset($_POST['categoria']) && $_POST['categoria'] == "Inicial") ? "selected" : ""?>>Inicial</option>
              </select>

              <input type="submit" >


              <p>Filtrar por categoria</p>

              <ul>
                <li><button type="submit" name="rubro" value="Todos" class="btn <?= (isset($rubro) && $rubro == "Todos") ? "rubro_seleccionado" : ""?><?= (!isset($rubro)) ? "rubro_seleccionado" : ""?>">Todos</button></li>
                <li><button type="submit" name="rubro" value="Accesorios" class="btn <?= (isset($rubro) && $rubro == "Accesorios") ? "rubro_seleccionado" : ""?>">Accesorios</button></li>
                <li><button type="submit" name="rubro" value="Deportes" class="btn <?= (isset($rubro) && $rubro == "Deportes") ? "rubro_seleccionado" : ""?>">Deportes</button></li>
                <li><button type="submit" name="rubro" value="Electro" class="btn <?= (isset($rubro) && $rubro == "Electro") ? "rubro_seleccionado" : ""?>">Electro</button></li>
                <li><button type="submit" name="rubro" value="Estetica" class="btn <?= (isset($rubro) && $rubro == "Estetica") ? "rubro_seleccionado" : ""?>">Estetica</button></li>
                <li><button type="submit" name="rubro" value="Gastronomía" class="btn <?= (isset($rubro) && $rubro == "Gastronomía") ? "rubro_seleccionado" : ""?>">Gastronomía</button></li>
                <li><button type="submit" name="rubro" value="Calzado" class="btn <?= (isset($rubro) && $rubro == "Calzado") ? "rubro_seleccionado" : ""?>">Calzado</button></li>
                <li><button type="submit" name="rubro" value="Indumentaria" class="btn <?= (isset($rubro) && $rubro == "Indumentaria") ? "rubro_seleccionado" : ""?>">Indumentaria</button></li>
                <li><button type="submit" name="rubro" value="Varios" class="btn <?= (isset($rubro) && $rubro == "Varios") ? "rubro_seleccionado" : ""?>">Varios</button></li>
              </ul>

              <?php 
              
              if(isset($_POST['rubro'])){
                $rubroAnterior = $_POST['rubro'];
              }elseif(isset($_POST['rubroAnterior'])){
                $rubroAnterior = $_POST['rubroAnterior'];
              }else{
                $rubroAnterior = "Todos";
              }
              
              ?>

              <input type="hidden" name="rubroAnterior" value="<?= $rubroAnterior ?>">


              <!-- <div>
                <p>Fecha Desde</p>
                <input type="date" class="form-control id=" fechaDesde" required>
              </div>
              <div>
                <p>Fecha Hasta</p>
                <input type="date" class="form-control id=" fechaHasta" required>
              </div> -->
            </form>

          </div>

          <div class="col-lg-9 col-12 listado-promociones">
            <button class="btn btn-light boton-filtros d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop"><i class="bi bi-funnel"></i> Filtros</button>

            <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="staticBackdropLabel">
                  Filtros
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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

            <!-- Promociones -->

            <?php if ($result->num_rows > 0): ?>

              <?php while ($row = $result->fetch_assoc()): ?> 

                <?php $texto_promocion = $row['texto_promocion'];
                $categoria_cliente = $row['categoria_cliente']; 
                $foto_promocion = $row['foto_promocion']; 
                $nombre_local = $row['nombre_local'];?> 

                <div class="promocion-cli container-fluid">
                  <div class="row">
                      
                    <div class="col-4 col-md-3 col-lg-4 col-xl-3">
                      <img src="data:image/jpeg;base64<?= $foto_promocion ?>" />
                    </div>
                    <div class="col-8 col-md-9 col-lg-8 col-xl-9 d-flex justify-content-between align-items-center">

                      <div class="info">
                        <h3><?= $texto_promocion ?></h3>
                        <p>Local: <?= $nombre_local ?></p>
                        <p>Categoria cliente: <?= $categoria_cliente ?></p>
                        <!-- <p class="descripcion-promocion">Descripción breve de la promoción 1</p> -->
                      </div>
                      <button type="button " class="boton-codigo btn btn-secondary btn-lg">Generar <br />Código</button>
                      <button type="button" class="boton-codigo-chico"><i class="bi bi-qr-code"></i></button>
                    </div>
                  </div>
                </div>

              <?php endwhile; ?>

            <?php else: ?>
              <p>No hay promociones registradas.</p>
            <?php endif; ?>


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