<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de incluir PHPMailer desde tu proyecto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["Name"]));
    $email = filter_var(trim($_POST["Email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["Subject"]));
    $message = trim($_POST["Message"]);

    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Por favor completa todos los campos del formulario.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        //Configuración del servidor SMTP de Google
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nahuelalaniz80@gmail.com'; // Reemplaza con tu dirección de correo
        $mail->Password = 'Informacion.10'; // Reemplaza con tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Destinatario
        $mail->setFrom($email, $name);
        $mail->addAddress('nahuelalaniz80@gmail.com'); // Reemplaza con tu dirección de correo

        //Contenido del mensaje
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "Nombre: $name\nEmail: $email\n\nMensaje:\n$message";

        $mail->send();
        http_response_code(200);
        echo '¡Gracias! Tu mensaje ha sido enviado.';
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Hubo un problema al enviar tu mensaje. Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Hubo un problema con tu solicitud. Por favor, intenta de nuevo.";
}
?>
