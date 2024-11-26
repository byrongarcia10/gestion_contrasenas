<?php
// Iniciar sesión
session_start();

// Destruir la sesión
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de Sesión</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Fondo con degradado en tonos suaves de azul */
    body {
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb); /* Azul suave a azul claro */
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        color: #333333; /* Color de texto oscuro para mejor contraste */
    }
    .container {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 90%;
        max-width: 500px;
        text-align: center;
    }
    h4 {
        color: #4a90e2; /* Azul suave para el título */
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
    }
    .alert-success {
        background-color: #4caf50; /* Verde para éxito */
        color: #ffffff;
        border-radius: 8px;
    }
    .alert p {
        margin-bottom: 0;
    }
    .btn-primary {
        background-color: #4a90e2; /* Azul suave para el botón */
        border-color: #4a90e2;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background-color: #357abd;
        border-color: #357abd;
    }
</style>
</head>
<body>
    <div class="container text-center my-5">
        <!-- Mensaje de confirmación -->
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Sesión cerrada con éxito</h4>
            <p>Has cerrado sesión correctamente. Esperamos verte de nuevo pronto.</p>
            <hr>
            <p class="mb-0">Haz clic en el botón de abajo para regresar al inicio de sesión.</p>
        </div>
        
        <!-- Botón para redirigir a login -->
        <a href="login.php" class="btn btn-primary mt-3">Ir al inicio de sesión</a>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>