<?php 
session_start();
require 'conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'D:/APPS/xampp/htdocs/gestion_contrasenas/PHPMailer/src/Exception.php';
require 'D:/APPS/xampp/htdocs/gestion_contrasenas/PHPMailer/src/PHPMailer.php';
require 'D:/APPS/xampp/htdocs/gestion_contrasenas/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar el nombre de usuario en el servidor
    if (preg_match('/[^a-z0-9]/', $username)) {
        echo "El nombre de usuario solo debe contener minúsculas y números, sin espacios.";
        exit();
    }

    // Modificar consulta para incluir el rol del usuario
    $sql = "SELECT id, password_hash, email, role FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash, $email, $role);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            // Almacenar los datos del usuario en la sesión
            $_SESSION['usuario_id'] = $user_id;
            $_SESSION['usuario_role'] = $role;
            $_SESSION['usuario_nombre'] = $username; // Guarda el nombre de usuario también

            // Redirigir según el rol del usuario
            if ($role === 'admin') {
                header("Location: ver_usuarios.php"); // Página para administradores
            } else {
                // Generar un código 2FA aleatorio para usuarios normales
                $codigo_2fa = rand(100000, 999999);
                $_SESSION['codigo_2fa'] = $codigo_2fa;

                // Enviar el código al correo electrónico del usuario usando PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'gestioncontrasenas1@gmail.com';
                    $mail->Password = 'dwwa fvmj wxvk uydo';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('gestioncontrasenas1@gmail.com', 'Sistema de Gestion de Contrasenas');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'CODIGO DE VERIFICACION 2FA';
                    $mail->Body = "Su código de verificación es: $codigo_2fa";

                    $mail->send();

                    // Redirigir a la página de verificación del código 2FA
                    header("Location: verificar_2fa.php");
                } catch (Exception $e) {
                    echo "No se pudo enviar el mensaje. Error de PHPMailer: {$mail->ErrorInfo}";
                }
            }
            exit();
        } else {
            // Redirigir a la página de login con el error de contraseña incorrecta
            header("Location: login.php?error=incorrect_password");
            exit();
        }
    } else {
        // Redirigir a la página de login con el error de usuario no encontrado
        header("Location: login.php?error=user_not_found");
        exit();
    }

    $stmt->close();
}
$conn->close();
?>