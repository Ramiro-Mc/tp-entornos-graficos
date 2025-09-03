<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");
sesionIniciada();

$folder = "Cliente";
$pestaña = "Buscar Promociones";




date_default_timezone_set('America/Argentina/Buenos_Aires');
$numeroDiaHoy = date('N');

if(isset($_SESSION['cod_usuario'])){
  $cod_usuario = $_SESSION['cod_usuario'];
  $res = consultaSQL("SELECT categoria_cliente FROM cliente WHERE cod_usuario = '$cod_usuario'");
  $row = mysqli_fetch_assoc($res); 
  $categoria_cliente_log = $row['categoria_cliente'] ?? ''; 
}

if(!isset($_GET['rubro']) and isset($_GET['rubroAnterior'])){
  $rubro = $_GET['rubroAnterior'];
}elseif(isset($_GET['rubro'])){
  $rubro = $_GET['rubro'];
}

$vlocales = consultaSQL("SELECT nombre_local FROM locales");

$where = [];
if (isset($rubro) && $rubro != "Todos") {
    $where[] = "l.rubro_local = '{$rubro}'";
}
if (isset($_GET['categoria']) && $_GET['categoria'] != "Cualquiera") {
    $where[] = "p.categoria_cliente = '{$_GET['categoria']}'";
}
if (isset($_GET['local']) && $_GET['local'] != "Cualquiera") {
    $where[] = "l.nombre_local = '{$_GET['local']}'";
}

$where_sql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$cantPagina = 2;
$pagina = isset($_GET["pagina"]) ?  max(1, intval($_GET["pagina"])): 1;
$principio = ($pagina-1) * $cantPagina;


$sql = "SELECT 
    p.cod_promocion,
    p.texto_promocion, 
    p.categoria_cliente, 
    p.foto_promocion, 
    l.nombre_local
FROM promociones p
INNER JOIN locales l ON p.cod_local = l.cod_local
INNER JOIN promocion_dia pd ON pd.cod_promocion = p.cod_promocion
{$where_sql}
AND pd.cod_dia = '$numeroDiaHoy'
LIMIT $cantPagina OFFSET $principio";

$result = consultaSQL($sql);



?>


<?php 

$sqlTotal = "SELECT COUNT(DISTINCT p.cod_promocion) as total
FROM promociones p
INNER JOIN locales l ON p.cod_local = l.cod_local
INNER JOIN promocion_dia pd ON pd.cod_promocion = p.cod_promocion
{$where_sql}
AND pd.cod_dia = '$numeroDiaHoy'";

$total = consultaSQL($sqlTotal);
$totalPromos = mysqli_fetch_assoc($total)['total'];
$totalPaginas = ceil($totalPromos / $cantPagina); 


  // Guardo los filtros activos en variables
  $rubroParam = isset($rubro) ? '&rubro=' . urlencode($rubro) : '';
  $categoriaParam = isset($_GET['categoria']) ? '&categoria=' . urlencode($_GET['categoria']) : '';
  $localParam = isset($_GET['local']) ? '&local=' . urlencode($_GET['local']) : '';
  $rubroAnteriorParam = isset($rubroAnterior) ? '&rubroAnterior=' . urlencode($rubroAnterior) : '';
  $filtrosURL = $rubroParam . $categoriaParam . $localParam . $rubroAnteriorParam;

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

            <hr/>

            <form id="filtros-promociones" method="GET" action="">
              <p style="padding-top: 0;">Local </p>

              <select class="select-filtros" name="local">

                <option name="local" value="Cualquiera">Cualquiera</option>

                <?php if ($vlocales->num_rows > 0): ?>

                  <?php while ($row = $vlocales->fetch_assoc()): ?>

                    <?php $nombre_local = $row['nombre_local']; ?>

                    <option name="local" value="<?= $nombre_local ?>" <?= (isset($_GET['local']) && $_GET['local'] == $nombre_local) ? "selected" : ""?>><?= $nombre_local ?></option>

                  <?php endwhile; ?>

                <?php else: ?>
                  No hay locales registrados.
                <?php endif; ?>
              </select>

              <p style="padding-top: 0;">Tipo cliente</p>

              <select class="select-filtros" name="categoria" id="">
                <option name="categoria" value="Cualquiera">Cualquiera</option>
                <option name="categoria" value="Premium" <?= (isset($_GET['categoria']) && $_GET['categoria'] == "Premium") ? "selected" : ""?>>Premium</option>
                <option name="categoria" value="Medium" <?= (isset($_GET['categoria']) && $_GET['categoria'] == "Medium") ? "selected" : ""?>>Medium</option>
                <option name="categoria" value="Inicial" <?= (isset($_GET['categoria']) && $_GET['categoria'] == "Inicial") ? "selected" : ""?>>Inicial</option>
              </select>
              
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-outline-success" >Filtrar</button>
              </div>
              
              <hr/>

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
              
              if(isset($_GET['rubro'])){
                $rubroAnterior = $_GET['rubro'];
              }elseif(isset($_GET['rubroAnterior'])){
                $rubroAnterior = $_GET['rubroAnterior'];
              }else{
                $rubroAnterior = "Todos";
              }
              
              ?>

              <input type="hidden" name="rubroAnterior" value="<?= $rubroAnterior ?>">
            </form>

          </div>

          <div class="col-lg-9 col-12 listado-promociones ">
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
                $nombre_local = $row['nombre_local'];
                $cod_promocion = $row['cod_promocion'];
                             
                $modalId = 'modal_' . md5($texto_promocion . $nombre_local); ?> 

                <div class="promocion-cli container-fluid">
                  <div class="row">
                    
                    <div class="col-4 col-md-3 col-lg-4 col-xl-3">
                      <img src="data:image/jpeg;base64,<?= $foto_promocion ?>" />
                    </div>
                    <div class="col-8 col-md-9 col-lg-8 col-xl-9 d-flex justify-content-between align-items-center">

                      <div class="info">
                        <h3><?= $texto_promocion ?></h3>
                        <p>Local: <?= $nombre_local ?></p>
                        <p>Categoria cliente: <?= $categoria_cliente ?></p>
                      </div>

                      <?php if(isset($_SESSION['cod_usuario'])): ?>
                        <?php  
                          $res = consultaSQL("SELECT * FROM uso_promociones WHERE cod_usuario = '$cod_usuario' AND cod_promocion = '$cod_promocion'");
                          if ($res->num_rows > 0): ?>

                          <div class="text-center">
                            <p>Ya utilizaste <br> esta promocion </p>
                          </div>

                        <?php else: ?>
                          <?php if(($categoria_cliente_log === "Inicial" && ($categoria_cliente === "medium" || $categoria_cliente === "premium")) || ($categoria_cliente_log === "Medium" && $categoria_cliente === "premium")): ?>
                            <div class="text-center">
                              <p>No disponible para <br> su categoria actual </p>
                            </div>
                          <?php else: ?>
                            <button type="button " class="boton-codigo btn btn-secondary btn-lg" 
                            onclick="solicitarPromocion('<?= $cod_promocion ?>', '<?= $cod_usuario ?>', '<?= $modalId ?>')"
                            data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                            Solicitar <br />Descuento</button>
                            
                            <button type="button" class="boton-codigo-chico"><i class="bi bi-qr-code"></i></button>
                          <?php endif ?>
                        <?php endif; ?>
                      <?php else: ?>
                        <div class="text-center">
                          <p>Inicie sesion para <br> usar promociones </p>
                        </div>
                      <?php endif; ?>
                    
                      <!-- Modal -->

                      <div class="modal fade " id="<?= $modalId ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                                            
                            <div class="modal-content">
                              <div class="modal-header ">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="margin: auto;">¡Promocion Solicitada!</h1>
                              </div>
                              <div class="modal-body text-center">
                                <p style="font-size: 1.2rem;">Le notificaremos a su direccion de correo electronico cuando el estado de su solicitud se actualice</p>
                                <p style="margin: 0;">Puede ver el estado de sus solicitudes aqui:</p>
                                <a href="../Cliente/MisSolicitudesDePromociones.php">Mis solicitudes</a>
                              </div>
                              
                              <div class="modal-footer">
                                <button style="margin: auto;" onclick="location.reload();" class="btn btn-secondary" data-bs-dismiss="modal">¡De acuerdo!</button>
                              </div>
                              
                            </div>
                        </div>
                      </div>
                    
                    </div>
                    
                  </div>
                </div>

              <?php endwhile; ?>

            <?php else: ?>
              <div class="notificacion-no-promociones">
                <h3>¡Lo sentimos!</h3>
                <p>No hay promociones registradas para los filtros ingresados</p>
              </div>
            <?php endif; ?>

          </div>
        </div>

        <div class="row">
          <div class="col-3"></div>
          <div class="col-9">
              <div class="paginacion" aria-label="Page navigation example">
            <ul class="pagination">
              <?php if ($pagina > 1): ?>
                <li class="page-item">
                  <a class="page-link" href="?pagina=<?= $pagina-1 . $filtrosURL ?>"><i class="bi bi-arrow-left-short"></i></a>
                </li>
              <?php endif; ?>

              <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $pagina ? 'active' : ''?>">
                  <a class="page-link" href="?pagina=<?= $i . $filtrosURL ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>

              <?php if ($pagina < $totalPaginas): ?>
                <li class="page-item">
                  <a class="page-link" href="?pagina=<?= $pagina + 1 . $filtrosURL ?>"><i class="bi bi-arrow-right-short"></i></a>
                </li>
              <?php endif; ?>
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

    <script>
      function solicitarPromocion(codigoPromocion, codigoUsuario, modalId){
        fetch('solicitarPromocion.php', {
          method: 'GET',
          body: new URLSearchParams({
            cod_promocion: codigoPromocion,
            cod_usuario: codigoUsuario
          })
        })
        .then(response => response.json())
      }
    </script>

  </body>

</html>