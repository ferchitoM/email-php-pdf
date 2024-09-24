<?php

/*
RECORDAR QUE SI NO ENVÍA EL EMAIL PUEDE ESTAR MAL:
- EL CORREO
- LA CONTRASEÑA DE APLICACIÓN QUE ARROJA GMAIL
O LA RED WIFI DEL HOGAR TIENE LOS PUERTOS BLOQUEADOS (PROBAR CON LOS DATOS DEL TELÉFONO)
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['to'])) {

    $from = 'tucorreodegmail@gmail.com';                        //cuenta de gmail
    $sender_name = 'Wolfitos Pro Max Team';                     //Nombre que aparece de quién envía

    $to = $_POST['to'];                                         //correo destinatario
    $subject = $_POST['subject'];                               //asunto
    $message = $_POST['message'];                               //mensaje

    //mail config
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host         = 'smtp.gmail.com';                 //no cambiar
        $mail->Port         = 587;                              //no cambiar
        $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;   //no cambiar
        $mail->SMTPAuth     = true;                             //no cambiar
        $mail->Username     = $from;
        $mail->Password     = 'contraseñadeaplicacióngmail';    //la que arroja https://myaccount.google.com/apppasswords

        $mail->setFrom(address: $from, name: $sender_name);     //no cambiar
        $mail->addAddress(address: $to);                        //no cambiar
        $mail->Subject = $subject;                              //no cambiar

        //Por si se quiere enviar un archivo en el correo:
        // $ubicacionArchivo = './carpeta/archivo.pdf';
        // if (file_exists($ubicacionArchivo)) {
        //     $mail->addAttachment($ubicacionArchivo, 'nuevo_nombre.pdf');
        // }

        $mail->isHTML(true);
        $mail->Body = file_get_contents('modelo_email.html'); //pueden probar el diseño del correo hasta que les guste (se debe hacer con tablas)

        //luego cuando les guste copian el código html y lo pegan entre las comillas y le agregan las variables php que necesiten:
        //$mail->Body = ''

        $mail->send();
        echo 'El mensaje se envío exitosamente';
    } catch (Exception $e) {
        echo "El mensaje no pudeo ser enviado. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send email</title>
</head>
<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<body>
    <h1>Email con html & imagenes</h1>
    <form action="send_email.php" method="post">
        <span>Email destinatario: </span>
        <input type="email" name="to" required value="">
        <span>Asunto: </span>
        <input type="text" name="subject" required value="">
        <span>Mensaje: </span>
        <textarea name="message" rows="5" cols="20" required>Esto es una prueba!</textarea>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>