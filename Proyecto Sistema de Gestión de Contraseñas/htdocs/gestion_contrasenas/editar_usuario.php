<?php
session_start();
require 'conexion.php';

// Verifica si el usuario ha iniciado sesión y tiene permisos de administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nombre'] !== 'admin') {
    echo "Acceso denegado. No tienes permisos para ver esta página.";
    exit();
}

// Verifica si se pasa un ID de usuario para editar
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Obtener la información del usuario
    $sql = "SELECT username, email, role FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "No se especificó un ID de usuario.";
    exit();
}

// Si el formulario es enviado, actualizamos los datos del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // El campo 'username' ahora es un select
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Actualizar los datos del usuario
    $sql_update = "UPDATE usuarios SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $username, $email, $role, $user_id);

    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success' role='alert'>Usuario actualizado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al actualizar el usuario.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
        background-color: #4caf50; /* Verde para éxito */
        color: #ffffff;
    }
    .alert-danger {
        background-color: #f44336; /* Rojo para errores */
        color: #ffffff;
    }
</style>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container my-4">
        <!-- Mensaje de bienvenida -->
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">Editar Usuario</h4>
            <p>Actualiza la información del usuario seleccionado.</p>
        </div>

        <!-- Formulario para editar usuario -->
        <form method="POST">
            <!-- Lista desplegable para seleccionar el nombre de usuario -->
            <div class="mb-3">
                <label for="username" class="form-label">Selecciona el nombre de usuario:</label>
                <select class="form-select" name="username" id="username" onchange="getUserData()" required>
                    <?php
                    // Obtener todos los usuarios de la base de datos
                    $sql_users = "SELECT id, username FROM usuarios";
                    $stmt_users = $conn->prepare($sql_users);
                    $stmt_users->execute();
                    $result_users = $stmt_users->get_result();

                    // Mostrar los usuarios en el dropdown
                    while ($row_user = $result_users->fetch_assoc()) {
                        $selected = ($row_user['username'] == $user['username']) ? 'selected' : '';
                        echo "<option value='" . $row_user['username'] . "' $selected>" . htmlspecialchars($row_user['username']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rol:</label>
                <select class="form-select" name="role" id="role">
                    <option value="usuario" <?php echo ($user['role'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="administrador" <?php echo ($user['role'] == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </div>
        </form>

        <br>
        <div class="text-center">
            <a href="ver_usuarios.php" class="btn btn-secondary">Volver a la lista de usuarios</a>
        </div>
    </div>

    <!-- Agregar el script de Bootstrap y el script para la actualización dinámica -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getUserData() {
            var username = document.getElementById("username").value;
            if (username) {
                // Hacer la solicitud AJAX al archivo PHP para obtener los datos del usuario
                fetch('get_user_data.php?username=' + username)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar el correo y el rol en el formulario
                        document.getElementById("email").value = data.email;
                        document.getElementById("role").value = data.role;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>

<?php
// Cierra la conexión
$stmt->close();
$conn->close();
?>