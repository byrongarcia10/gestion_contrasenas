<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $contrasena_id = $_GET['id'];
    session_start();
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "SELECT url, contrasena FROM contrasenas_guardadas WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $contrasena_id, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['success' => true, 'url' => $data['url'], 'contrasena' => $data['contrasena']]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>