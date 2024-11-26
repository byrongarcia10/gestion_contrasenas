<?php
// Incluir la librería de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar autoload de Composer
require 'vendor/autoload.php';

$mail = new PHPMailer(true); // Instancia de PHPMailer

try {
    // Configuración del servidor SMTP
    $mail->isSMTP(); 
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true; /
    $mail->Username = 'gestioncontrasenas1@gmail.com'; 
    $mail->Password = 'wwa fvmj wxvk uydo'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port = 587; 

    // Remitente y destinatario
    $mail->setFrom('gestioncontrasenas1@gmail.com', 'Gestion_Contrasenas');
    $mail->addAddress('destinatario@example.com', 'Destinatario'); 

    // Contenido del correo
    $mail->isHTML(true); 
    $mail->Subject = 'Código de Verificación 2FA';
    $mail->Body    = 'Su código de verificación es: ' . $_SESSION['codigo_2fa'];
    
    // Enviar correo
    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
}
?>