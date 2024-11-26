<?php 
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require 'conexion.php';
$usuario_id = $_SESSION['usuario_id'];

// Consultar contraseñas guardadas
$sql = "SELECT id, nombre_cuenta, url, contrasena FROM contrasenas_guardadas WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Contraseñas Guardadas</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Fondo con degradado en tonos suaves de azul */
    body {
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb); 
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333333; 
    }
    .container {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 80%;
        max-width: 900px;
    }
    h2 {
        color: #4a90e2; 
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
    }
    .table {
        background-color: #f9f9f9;
        border-radius: 10px;
    }
    .table-dark {
        background-color: #4a90e2; 
        color: #ffffff;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn {
        border-radius: 5px;
    }
    .btn-danger {
        background-color: #e64a19; 
        border-color: #e64a19;
    }
    .btn-danger:hover {
        background-color: #c43e12;
        border-color: #c43e12;
    }
    .btn-warning {
        background-color: #f5a623; 
        border-color: #f5a623;
    }
    .btn-warning:hover {
        background-color: #e6892a;
        border-color: #e6892a;
    }
    .btn-success {
        background-color: #4a90e2; 
        border-color: #4a90e2;
    }
    .btn-success:hover {
        background-color: #357abd;
        border-color: #357abd;
    }
    .btn-secondary {
        background-color: #a1c4fd; 
        border-color: #a1c4fd;
    }
    .btn-secondary:hover {
        background-color: #7ba8d5;
        border-color: #7ba8d5;
    }
    .alert-info {
        background-color: #a1c4fd; 
        color: #333333;
    }
</style>
</head>
<body>
    <div class="container my-4">
        <h2 class="text-center">Mis Contraseñas Guardadas</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Cuenta</th>
                            <th>URL</th>
                            <th>Contraseña</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nombre_cuenta']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank"><?php echo htmlspecialchars($row['url']); ?></a></td>
                                <td><?php echo htmlspecialchars($row['contrasena']); ?></td>
                                <td>
                                    <a href="borrar_contrasena.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    <a href="editar_contrasena.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No tienes contraseñas guardadas.
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mt-4">
            <a href="guardar_contrasena.php" class="btn btn-success">Guardar nueva contraseña</a>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
$stmt->close();
$conn->close();
?>