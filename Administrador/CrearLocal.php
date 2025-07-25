    <?php
    include("../conexion.inc");
    $vId = uniqid();
    $vNombre = $_POST['nombreLocal'];
    $vUbicacion = $_POST['ubicacion'];
    $vRubro = $_POST['rubro'];
    $vCodUsuario = $_POST['NO SE COMO TRAER ESTO'];
    $vMultimedia = $_POST['archivoMultimedia'];
    $vSql = "SELECT COUNT(*) as cantidad FROM Local WHERE Id='$vId'";
    $vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));
    $vCantLocales = mysqli_fetch_assoc($vResultado);
    if ($vCantLocales['cantidad'] != 0) {
        echo ("El local ya Existe<br>");
        // hacer html
    } else {
        $vSql = "INSERT INTO Local (Id, NombreLocal, UbicacionLocal, RubroLocal, CodUsuario, Multimedia)  
      VALUES ('$vId', '$vNombre', '$vUbicacion', '$vRubro', '$vCodUsuario', '$vMultimedia')";
        mysqli_query($link, $vSql) or die(mysqli_error($link));
        echo ("El local fue Registrada");
        echo ("<A href='Menu.html'>VOLVER AL MENU</A>");
        // hacer html
    }
    mysqli_free_result($vResultado);
    mysqli_close($link);
    ?></body>

    </html>