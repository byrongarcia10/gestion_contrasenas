<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require 'conexion.php';

// Verificar si se recibió el parámetro 'id'
if (isset($_GET['id'])) {
    $id_contrasena = $_GET['id'];

    // Preparar la consulta SQL para eliminar la contraseña
    $sql = "DELETE FROM contrasenas_guardadas WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_contrasena, $_SESSION['usuario_id']);

    // Ejecutar la consulta y verificar si la eliminación fue exitosa
    if ($stmt->execute()) {
        echo "Contraseña eliminada correctamente.";
    } else {
        echo "Error al eliminar la contraseña.";
    }

    // Cerrar la conexión
    $stmt->close();
} else {
    echo "No se ha proporcionado un ID válido.";
}

$conn->close();

// Redirigir a la página de contraseñas guardadas
header("Location: ver_contrasenas.php");
exit;
?>