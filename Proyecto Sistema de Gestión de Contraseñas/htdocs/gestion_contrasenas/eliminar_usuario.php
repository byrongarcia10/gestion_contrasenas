<?php 
session_start();
require 'conexion.php';

// Verificar que el usuario esté autenticado como administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nombre'] !== 'admin') {
    echo "<div class='alert alert-danger text-center'>Acceso no autorizado.</div>";
    exit();
}

// Verificar que se pase el ID del usuario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <?php 
        if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Validar que el ID sea un número
            $user_id = intval($_GET['id']); // Asegurar que sea un entero

            // Prepara la consulta para eliminar al usuario
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $user_id);

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        echo "
                        <div class='alert alert-success text-center' role='alert'>
                            Usuario eliminado exitosamente.
                        </div>
                        ";
                    } else {
                        echo "
                        <div class='alert alert-warning text-center' role='alert'>
                            No se encontró un usuario con ese ID.
                        </div>
                        ";
                    }
                } else {
                    echo "
                    <div class='alert alert-danger text-center' role='alert'>
                        Error al ejecutar la consulta: " . htmlspecialchars($stmt->error) . "
                    </div>
                    ";
                }

                $stmt->close();
            } else {
                echo "
                <div class='alert alert-warning text-center' role='alert'>
                    Error en la preparación de la consulta: " . htmlspecialchars($conn->error) . "
                </div>
                ";
            }
        } else {
            echo "
            <div class='alert alert-info text-center' role='alert'>
                No se especificó un ID válido para el usuario.
            </div>
            ";
        }

        $conn->close();
        ?>
        <!-- Botón para regresar -->
        <div class="text-center mt-4">
            <a href="ver_usuarios.php" class="btn btn-secondary">Volver a la lista de usuarios</a>
        </div>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>