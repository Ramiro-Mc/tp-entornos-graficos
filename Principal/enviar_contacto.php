<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $consulta = $_POST['consulta'];

    $to = "contacto@viventastore.com";
    $subject = "Consulta desde el formulario de contacto";
    $message = "Nombre: $nombre $apellido\nEmail: $email\nConsulta:\n$consulta";
    $headers = "From: $email";

    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('¡Consulta enviada!'); window.location.href='Contacto.html';</script>";
    } else {
        echo "<script>alert('Error al enviar la consulta.'); window.location.href='Contacto.html';</script>";
    }
}
?>