<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registro de usuario</h4>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar mensaje de éxito si el registro fue exitoso -->
                        <?php if (isset($_GET['registro_exitoso']) && $_GET['registro_exitoso'] == 1): ?>
                            <div class="alert alert-success text-center" role="alert">
                                Usuario registrado exitosamente. ¡Ahora puedes iniciar sesión!
                            </div>
                        <?php endif; ?>

                        <form action="procesar_registro.php" method="POST" onsubmit="return validarFormulario()">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrar</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="index.php">¿Ya tienes cuenta? Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validarFormulario() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var usernameRegex = /^[a-z0-9]+$/;
            if (!usernameRegex.test(username)) {
                alert("El nombre de usuario solo puede contener minúsculas y números.");
                return false;
            }
            var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password)) {
                alert("La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un número y un carácter especial.");
                return false;
            }
            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>