<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require 'conexion.php';

$usuario_id = $_SESSION['usuario_id'];
$nombre_cuenta = $_POST['nombre_cuenta'];
$url = $_POST['url'];
$contrasena = $_POST['contrasena'];

// Preparar la consulta SQL para insertar la contraseña
$sql = "INSERT INTO contrasenas_guardadas (usuario_id, nombre_cuenta, url, contrasena) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

// Enlazar los parámetros
$stmt->bind_param("isss", $usuario_id, $nombre_cuenta, $url, $contrasena);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a la página de ver contraseñas después de guardar
    header("Location: ver_contrasenas.php");
    exit;
} else {
    // Mostrar error en caso de que la ejecución falle
    echo "Error al guardar la contraseña: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>