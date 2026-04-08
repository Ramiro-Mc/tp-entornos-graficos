<?php
require "../Includes/conexion.inc";
include_once("../Includes/funciones.php");
include_once("../Includes/session.php");
sesionIniciada();

$tipo = $_GET['tipo'] ?? '';
$error = null;
$exito = null;

if (!in_array($tipo, ['local', 'novedad'])) {
    header("Location: index.php?mensaje=tipo_invalido");
    exit;
}

$rutaMultimedia = null;
$folder = "Administrador";
$pestaña = "Crear " . ucfirst($tipo);
$archivosVolver = [
    'local' => 'AdministrarLocales.php',
    'novedad' => 'AdministrarNovedades.php'
];

if ($tipo === 'local') {
    $rubros = ['Accesorios', 'Deportes', 'Electro', 'Estetica', 'Gastronomia', 'Calzado', 'Indumentaria', 'Varios'];
    $resUsuarios = mysqli_query($link, "SELECT cod_usuario, nombre_usuario FROM usuario") or die(mysqli_error($link));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // VAMOS A VER QUÉ ERROR TIRA PHP AL SUBIR EL ARCHIVO
    if (isset($_FILES['archivoMultimedia'])) {
        $errorSubida = $_FILES['archivoMultimedia']['error'];

        if ($errorSubida === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['archivoMultimedia']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'];

            if (!in_array($ext, $permitidos)) {
                $error = "Formato de imagen no permitido. Solo se aceptan JPG, PNG, GIF o WEBP.";
            } else {
                $nuevoNombre = $tipo . "_" . uniqid() . "." . $ext;
                $destino = "../uploads/" . $nuevoNombre;

                // Verificamos si la carpeta existe
                if (!is_dir("../uploads/")) {
                    $error = "¡ERROR CRÍTICO! La carpeta '../uploads/' no existe en tu proyecto. Tenés que crearla manualmente en XAMPP.";
                } else if (move_uploaded_file($_FILES['archivoMultimedia']['tmp_name'], $destino)) {
                    $rutaMultimedia = "uploads/" . $nuevoNombre;
                } else {
                    $error = "Hubo un error al guardar la imagen. Verificá los permisos de la carpeta uploads.";
                }
            }
        } else if ($errorSubida === UPLOAD_ERR_INI_SIZE || $errorSubida === UPLOAD_ERR_FORM_SIZE) {
            $error = "El archivo es demasiado grande (supera el límite de tu php.ini).";
        } else if ($errorSubida === UPLOAD_ERR_NO_FILE) {
            $error = "Es obligatorio subir una foto para crear el registro.";
        } else {
            $error = "Error desconocido al subir el archivo (Código de error PHP: $errorSubida).";
        }
    } else {
        $error = "El formulario no envió el archivo. Verificá el enctype del form.";
    }

    if (!$error) {
        if ($tipo === 'local') {
            $nombre = $_POST['nombre_local'];
            $ubicacion = $_POST['ubicacion_local'];
            $rubro = $_POST['rubro_local'];
            $codUsuario = $_POST['cod_usuario'];

            $sql = $link->prepare("SELECT COUNT(*) as cantidad FROM locales WHERE nombre_local=?");
            $sql->bind_param("s", $nombre);
            $sql->execute();
            $vResultado = $sql->get_result()->fetch_assoc();

            if ($vResultado['cantidad'] > 0) {
                $error = "El local ya existe.";
            } else {
                $sql = $link->prepare("INSERT INTO locales (nombre_local, ubicacion_local, rubro_local, cod_usuario, foto_local) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param("sssis", $nombre, $ubicacion, $rubro, $codUsuario, $rutaMultimedia);
                $exito = $sql->execute() ? "El local se creó correctamente." : "Error al crear: " . $sql->error;
                $sql->close();
            }
        } elseif ($tipo === 'novedad') {
            $texto = $_POST['texto_novedad'];
            $desde = $_POST['fecha_desde_novedad'];
            $hasta = $_POST['fecha_hasta_novedad'];
            $tipo_usuario = $_POST['tipo_usuario'];

            // EL ESCUDO PROTECTOR: Verificamos si la sesión sigue activa
            $codUsuarioLogueado = $_SESSION['cod_usuario'] ?? null;

            if (!$codUsuarioLogueado) {
                $error = "Tu sesión ha expirado por inactividad. Por favor, vuelve a iniciar sesión para crear la novedad.";
            } elseif ($hasta < $desde) {
                $error = "La fecha de fin no puede ser menor que la de inicio.";
            } else {
                // Actualizamos la consulta para que coincida con las columnas reales de tu BD
                $sql = $link->prepare("INSERT INTO novedades (texto_novedad, fecha_desde_novedad, fecha_hasta_novedad, tipo_usuario, foto_novedad, cod_usuario) VALUES (?, ?, ?, ?, ?, ?)");

                $sql->bind_param("sssssi", $texto, $desde, $hasta, $tipo_usuario, $rutaMultimedia, $codUsuarioLogueado);

                $exito = $sql->execute() ? "La novedad se creó correctamente." : "Error al crear: " . $sql->error;
                $sql->close();
            }
        }
    }
} // <-- Fin del if ($_SERVER['REQUEST_METHOD'] === 'POST')
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../Includes/head.php"); ?>
    <title>Crear <?= ucfirst($tipo) ?></title>
</head>

<body>
    <header>
        <?php include("../Includes/header.php"); ?>
    </header>

    <main class="FondoDueñoAdministrador">
        <section class="form-register">
            <h4>Crear <?= ucfirst($tipo) ?></h4>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($exito): ?>
                <div class="alert alert-success" id="mensaje-exito"><?= htmlspecialchars($exito) ?></div>
                <script>
                    setTimeout(() => {
                        window.location.href = "<?= $archivosVolver[$tipo] ?>";
                    }, 1000);
                </script>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">

                <?php if ($tipo === 'local'): ?>
                    <p>Nombre Local</p>
                    <input type="text" name="nombre_local" required class="controls" value="<?= htmlspecialchars($_POST['nombre_local'] ?? '') ?>">

                    <p>Ubicación</p>
                    <select name="ubicacion_local" class="form-control controls" required>
                        <?php foreach (['Ala A', 'Ala B', 'Ala C', 'Ala D', 'Ala E'] as $opcion): ?>
                            <option value="<?= $opcion ?>" <?= (($_POST['ubicacion_local'] ?? '') === $opcion) ? 'selected' : '' ?>><?= $opcion ?></option>
                        <?php endforeach; ?>
                    </select>

                    <p>Rubro del Local</p>
                    <select name="rubro_local" class="form-control controls" required>
                        <?php foreach ($rubros as $rubro): ?>
                            <option value="<?= $rubro ?>" <?= (($_POST['rubro_local'] ?? '') === $rubro) ? 'selected' : '' ?>><?= $rubro ?></option>
                        <?php endforeach; ?>
                    </select>

                    <p>Dueño del Local</p>
                    <select name="cod_usuario" class="form-control controls" required>
                        <option value="">Seleccione un dueño</option>
                        <?php while ($duenio = mysqli_fetch_assoc($resUsuarios)): ?>
                            <option value="<?= $duenio['cod_usuario'] ?>" <?= (($_POST['cod_usuario'] ?? '') == $duenio['cod_usuario']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($duenio['nombre_usuario']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                <?php elseif ($tipo === 'novedad'): ?>
                    <p>Descripción</p>
                    <textarea name="texto_novedad" class="controls" rows="3" maxlength="200" required><?= htmlspecialchars($_POST['texto_novedad'] ?? '') ?></textarea>

                    <p>Vigencia</p>
                    <label for="fechaini">Fecha de inicio</label>
                    <input type="date" name="fecha_desde_novedad" id="fechaini" class="controls" value="<?= $_POST['fecha_desde_novedad'] ?? '' ?>" required>
                    <label for="fechafin">Fecha de fin</label>
                    <input type="date" name="fecha_hasta_novedad" id="fechafin" class="controls" value="<?= $_POST['fecha_hasta_novedad'] ?? '' ?>" required>

                    <p>Tipo de Usuario</p>
                    <select name="tipo_usuario" class="form-control controls" required>
                        <option value="inicial" <?= (($_POST['tipo_usuario'] ?? '') === 'inicial') ? 'selected' : '' ?>>Inicial</option>
                        <option value="medium" <?= (($_POST['tipo_usuario'] ?? '') === 'medium') ? 'selected' : '' ?>>Medium</option>
                        <option value="premium" <?= (($_POST['tipo_usuario'] ?? '') === 'premium') ? 'selected' : '' ?>>Premium</option>
                    </select>
                <?php endif; ?>

                <p>Archivo Multimedia</p>
                <input type="file" name="archivoMultimedia" class="form-control controls" required>

                <div class="text-center mt-3">
                    <button class="btn btn-success boton-enviar" type="submit">Crear</button>
                    <a href="<?= $archivosVolver[$tipo] ?>" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </section>
    </main>
    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
        <?php include("../Includes/footer.php"); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>