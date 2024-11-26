<?php
require 'conexion.php'; // Conexión a la base de datos

// Datos del nuevo administrador
$username = 'admin'; 
$email = 'byl.garcia@gmail.com'; 
$password = 'angelito1**'; 
$role = 'admin'; // Rol del usuario

// Generar hash de la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Consulta para insertar al usuario
$sql = "INSERT INTO usuarios (username, email, password_hash, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssss", $username, $email, $password_hash, $role);
    if ($stmt->execute()) {
        echo "Usuario administrador creado con éxito.";
    } else {
        echo "Error al crear el usuario administrador: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error en la consulta: " . $conn->error;
}

$conn->close();
?>