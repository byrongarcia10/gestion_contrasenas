<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Nueva Contraseña</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Fondo con degradado en tonos suaves de azul */
    body {
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb); /
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
    .form-label {
        color: #4a90e2; 
    }
    .btn {
        border-radius: 5px;
    }
    .btn-success {
        background-color: #4a90e2; 
        border-color: #4a90e2;
    }
    .btn-success:hover {
        background-color: #357abd;
        border-color: #357abd;
    }
    .btn-primary {
        background-color: #a1c4fd; 
        border-color: #a1c4fd;
    }
    .btn-primary:hover {
        background-color: #7ba8d5;
        border-color: #7ba8d5;
    }
    .alert-danger {
        background-color: #f5a623; 
        color: #ffffff;
    }
    .alert-danger a {
        color: #ffffff;
    }
</style>
<script>
        // Validación del formulario en JavaScript
        function validarFormulario() {
            let nombreCuenta = document.getElementById('nombre_cuenta').value;
            let contrasena = document.getElementById('contrasena').value;
            let mensaje = '';

            // Validación de campos vacíos
            if (nombreCuenta === '') {
                mensaje += 'El nombre de la cuenta es obligatorio.\n';
            }

            if (contrasena === '') {
                mensaje += 'La contraseña es obligatoria.\n';
            } else {
                // Validación de la contraseña (mínimo 8 caracteres, al menos una letra mayúscula, un número y un carácter especial)
                let regex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
                if (!regex.test(contrasena)) {
                    mensaje += 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial.\n';
                }
            }

            // Mostrar mensaje de error
            if (mensaje !== '') {
                alert(mensaje);
                return false; // No enviar el formulario
            }

            return true; // Enviar el formulario
        }
    </script>
</head>
<body>
    <div class="container my-4">
        <h2 class="text-center mb-4">Guardar Nueva Contraseña</h2>
        
        <!-- Mostrar errores si existen -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para guardar contraseña -->
        <form action="procesar_guardar_contrasena.php" method="POST" onsubmit="return validarFormulario()" class="needs-validation">
            <div class="mb-3">
                <label for="nombre_cuenta" class="form-label">Nombre de la cuenta:</label>
                <input type="text" id="nombre_cuenta" name="nombre_cuenta" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">URL (opcional):</label>
                <input type="url" id="url" name="url" class="form-control">
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Guardar Contraseña</button>
        </form>

        <!-- Enlace para volver a ver contraseñas guardadas -->
        <div class="mt-4 text-center">
            <a href="ver_contrasenas.php" class="btn btn-primary">Ver Contraseñas Guardadas</a>
        </div>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>