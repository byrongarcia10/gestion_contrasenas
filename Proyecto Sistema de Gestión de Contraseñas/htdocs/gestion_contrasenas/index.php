<!DOCTYPE html> 
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Gestión de Contraseñas - Inicio de Sesión</title>
  <!-- Vinculando Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  /* Fondo con degradado */
  body {
    background: linear-gradient(135deg, #007bff, #6c757d);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    color: #ffffff;
  }

  /* Tarjeta de inicio de sesión */
  .card {
    border-radius: 15px;
    background: #f8f9fa;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .card-header {
    background: #007bff;
    border-bottom: none;
    color: #ffffff;
    font-size: 1.5rem;
    font-weight: bold;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
  }

  /* Títulos principales */
  .main-title {
    font-size: 2.5rem;
    font-weight: bold;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
    margin-bottom: 0.5rem;
  }

  .text-center p {
    font-size: 1rem;
    color: #eaeaea;
  }

  /* Botones */
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
    font-size: 1.1rem;
    font-weight: bold;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  /* Campos de entrada */
  .form-control {
    border-radius: 8px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #ced4da;
  }

  .form-label {
    font-size: 1rem;
    color: #333333;
  }

  /* Enlaces */
  a {
    color: #007bff;
    text-decoration: none;
  }

  a:hover {
    text-decoration: underline;
  }

  /* Alertas */
  .alert-danger {
    background-color: #dc3545;
    color: #ffffff;
    border-radius: 5px;
    font-weight: bold;
  }
</style>
  </script>
</head>
<body>
  <div class="container">
    <div class="text-center mb-4">
      <h1 class="main-title">Sistema de Gestión de Contraseñas</h1>
      <p>Gestiona tus contraseñas de manera segura y eficiente</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h4 class="header-title mb-0">Iniciar sesión</h4>
          </div>
          <div class="card-body">
            <!-- Mensaje de error que aparece si la contraseña es incorrecta -->
            <?php if (isset($_GET['error']) && $_GET['error'] == 'incorrect_password'): ?>
              <div class="alert alert-danger text-center mb-3" role="alert">
                Contraseña incorrecta. Por favor, inténtalo nuevamente.
              </div>
            <?php endif; ?>
            
            <form action="procesar_login.php" method="POST" onsubmit="return validarFormulario()">
              <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
            </form>
            <div class="mt-3 text-center">
              <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Vinculando Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>