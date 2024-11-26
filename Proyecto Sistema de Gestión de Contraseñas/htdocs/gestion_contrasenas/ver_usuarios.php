<?php  
session_start();
require 'conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Consulta el rol del usuario logueado
$user_id = $_SESSION['usuario_id'];
$sql = "SELECT role FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Verifica si el usuario tiene rol de administrador
if ($_SESSION['usuario_nombre'] !== 'admin') {
    // Si no es administrador, redirige o muestra un mensaje de error
    echo "Acceso denegado. No tienes permisos para ver esta página.";
    exit();
}

// Si el usuario es administrador, continúa con el resto del código
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <!-- Agregar los enlaces de Bootstrap -->
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
        max-width: 700px;
    }
    h2 {
        color: #4a90e2; 
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
    }
    .alert-info {
        background-color: #a1c4fd; 
        color: #ffffff;
        border-radius: 8px;
    }
    .alert-info h4 {
        color: #4a90e2; 
    }
    .form-label {
        color: #4a90e2; 
    }
    .btn {
        border-radius: 5px;
    }
    .btn-primary {
        background-color: #4a90e2; 
        border-color: #4a90e2;
    }
    .btn-primary:hover {
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
    .form-select {
        background-color: #f0f8ff; 
        border: 1px solid #d1e7fd;
    }
    .form-control {
        background-color: #f0f8ff; 
        border: 1px solid #d1e7fd;
    }
    .alert-success {
        background-color: #4caf50; 
        color: #ffffff;
    }
    .alert-danger {
        background-color: #f44336; 
        color: #ffffff;
    }
</style>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container my-4">
        <!-- Mensaje de bienvenida -->
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">¡Bienvenido, Administrador!</h4>
            <p>Desde aquí puedes gestionar los usuarios registrados en el sistema.</p>
        </div>

        <!-- Encabezado -->
        <h3 class="text-center">Lista de usuarios registrados</h3>
        
        <!-- Tabla de usuarios -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta todos los usuarios registrados
                    $sql = "SELECT id, username, email, role FROM usuarios";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Mostrar la lista de usuarios
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['username'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['role'] . "</td>
                                <td>
                                    <a href='eliminar_usuario.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                                    <a href='editar_usuario.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Botón para cerrar sesión -->
        <div class="text-center mt-3">
            <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>
        </div>
    </div>

    <!-- Agregar el script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cierra la conexión
$stmt->close();
$conn->close();
?>