<?php
require 'conexion.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT email, role FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user); // Enviar los datos en formato JSON
    } else {
        echo json_encode(array('email' => '', 'role' => ''));
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>