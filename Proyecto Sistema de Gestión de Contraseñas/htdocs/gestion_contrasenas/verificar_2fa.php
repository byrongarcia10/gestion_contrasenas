<?php 
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['codigo_2fa'])) {
    header("Location: login.php");
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo_ingresado = $_POST['codigo_2fa'];

    // Verificar si el código ingresado coincide con el generado
    if ($codigo_ingresado == $_SESSION['codigo_2fa']) {
        unset($_SESSION['codigo_2fa']); // Remover el código de la sesión tras el éxito

        // Redirigir según el nombre de usuario
        if (isset($_SESSION['usuario_nombre']) && $_SESSION['usuario_nombre'] === 'admin') {
            header("Location: ver_usuarios.php"); // Página para el usuario admin
        } else {
            header("Location: ver_contrasenas.php"); // Página para otros usuarios
        }
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Código incorrecto. Por favor, intente nuevamente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación en Dos Pasos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Verificación en Dos Pasos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="codigo_2fa" class="form-label">Ingrese el código enviado a su correo:</label>
                                <input type="text" name="codigo_2fa" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Verificar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>