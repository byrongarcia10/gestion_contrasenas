<?php
session_start();
require 'conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos enviados por el formulario
    $contrasena_id = $_POST['contrasena_id'] ?? null;
    $url = $_POST['url'] ?? null;
    $nueva_contrasena = $_POST['contrasena'] ?? null;

    // Validar que los campos obligatorios no estén vacíos
    if (empty($contrasena_id)) {
        echo "Debe seleccionar una cuenta.";
        exit();
    }

    if (empty($url)) {
        echo "La URL no puede estar vacía.";
        exit();
    }

    if (empty($nueva_contrasena)) {
        echo "La contraseña no puede estar vacía.";
        exit();
    }

    // Obtener el ID del usuario actual
    $usuario_id = $_SESSION['usuario_id'];

    // Consulta para verificar si la contraseña pertenece al usuario actual
    $sql_verify = "SELECT id FROM contrasenas_guardadas WHERE id = ? AND usuario_id = ?";
    $stmt_verify = $conn->prepare($sql_verify);
    $stmt_verify->bind_param("ii", $contrasena_id, $usuario_id);
    $stmt_verify->execute();
    $result_verify = $stmt_verify->get_result();

    if ($result_verify->num_rows === 0) {
        echo "No tienes permisos para editar esta contraseña.";
        exit();
    }

    // Actualizar los datos de la contraseña
    $sql_update = "UPDATE contrasenas_guardadas SET url = ?, contrasena = ? WHERE id = ? AND usuario_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssii", $url, $nueva_contrasena, $contrasena_id, $usuario_id);

    if ($stmt_update->execute()) {
        // Redirigir con éxito
        header("Location: ver_contrasenas.php?mensaje=Contraseña actualizada exitosamente");
        exit();
    } else {
        echo "Error al actualizar la contraseña.";
    }

    $stmt_update->close();
    $stmt_verify->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}