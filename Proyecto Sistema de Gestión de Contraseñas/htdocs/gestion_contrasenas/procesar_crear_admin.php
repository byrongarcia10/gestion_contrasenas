<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = 'administrador';

        $sql = "INSERT INTO usuarios (username, email, password_hash, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $username, $email, $password_hash, $role);
            if ($stmt->execute()) {
                echo "Administrador creado exitosamente.";
            } else {
                echo "Error al crear el administrador: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    } else {
        echo "Datos incompletos.";
    }
} else {
    echo "Método no permitido.";
}
$conn->close();
?>