<?php
session_start();
require 'conexion.php';

// Asegúrate de que el método de solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asegúrate de que se reciban los campos del formulario
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validación del nombre de usuario
        if (preg_match('/[^a-z0-9]/', $username)) {
            echo "El nombre de usuario solo debe contener minúsculas y números, sin espacios.";
            exit();
        }

        // Validación de la contraseña
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            echo "La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, un número y un carácter especial.";
            exit();
        }

        // Verificar si el nombre de usuario o el correo ya existen
        $sql = "SELECT id FROM usuarios WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "El nombre de usuario o el correo electrónico ya están registrados.";
            $stmt->close();
            exit();
        }

        // Si es único, procedemos a guardar el usuario
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepara la consulta para insertar el usuario
        $sql = "INSERT INTO usuarios (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $password_hash);
            if ($stmt->execute()) {
                // Redirigir al formulario de registro con el mensaje de éxito
                header("Location: registro.php?registro_exitoso=1");
                exit();
            } else {
                echo "Error al registrar el usuario.";
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