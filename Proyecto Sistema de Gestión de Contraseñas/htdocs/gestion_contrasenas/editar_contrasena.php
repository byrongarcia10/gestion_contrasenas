<?php 
session_start();
require 'conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener las contraseñas guardadas para el menú desplegable
$sql_cuentas = "SELECT id, nombre_cuenta FROM contrasenas_guardadas WHERE usuario_id = ?";
$stmt_cuentas = $conn->prepare($sql_cuentas);
$stmt_cuentas->bind_param("i", $usuario_id);
$stmt_cuentas->execute();
$result_cuentas = $stmt_cuentas->get_result();

$stmt_cuentas->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contraseña</title>
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
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    h2 {
        color: #4a90e2; 
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
    }
    .form-label {
        color: #4a90e2; 
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
</style>
    <script>
        // Función para alternar la visibilidad de la contraseña
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('contrasena');
            const toggleButton = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.innerText = 'Ocultar';
            } else {
                passwordField.type = 'password';
                toggleButton.innerText = 'Mostrar';
            }
        }

        // Función para cargar datos del usuario seleccionado
        function cargarDatos() {
            const contrasenaId = document.getElementById('contrasena_id').value;

            if (contrasenaId) {
                // Realizar una solicitud AJAX para obtener los datos
                fetch(`obtener_datos_contrasena.php?id=${contrasenaId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('url').value = data.url || '';
                            document.getElementById('contrasena').value = data.contrasena || '';
                        } else {
                            alert('No se pudieron cargar los datos. Intente nuevamente.');
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los datos:', error);
                        alert('Ocurrió un error al cargar los datos.');
                    });
            } else {
                // Limpiar los campos si no hay selección
                document.getElementById('url').value = '';
                document.getElementById('contrasena').value = '';
            }
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Editar Contraseña</h2>

        <form method="POST" action="procesar_editar_contrasena.php">
            <div class="mb-3">
                <label for="contrasena_id" class="form-label">Selecciona la cuenta:</label>
                <select name="contrasena_id" id="contrasena_id" class="form-select" onchange="cargarDatos()" required>
                    <option value="">Seleccionar cuenta</option>
                    <?php while ($row = $result_cuentas->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['nombre_cuenta']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">URL:</label>
                <input type="url" name="url" id="url" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Nueva Contraseña:</label>
                <div class="input-group">
                    <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">Mostrar</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
        </form>

        <div class="text-center mt-4">
            <a href="ver_contrasenas.php" class="btn btn-secondary">Volver a ver contraseñas</a>
        </div>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>