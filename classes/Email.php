<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email,$nombre,$token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        //Crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'ef6a9a1e486bd4';
        $mail->Password = 'b3676691e81bc5';

        $mail->setFrom('acristeacsb2@gmail.com');
        $mail->addAddress('acristeacsb2@gmail.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .="<p><strong> Hola " . $this->nombre . " </strong> Has creado tu cuenta en AppSalon, debes confirmarla presionando en el siguiente enlace</p>";
        $contenido .="<p> Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'> Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solictaste esta cuenta, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'ef6a9a1e486bd4';
        $mail->Password = 'b3676691e81bc5';

        $mail->setFrom('acristeacsb2@gmail.com');
        $mail->addAddress('acristeacsb2@gmail.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu contraseña';

        //Set HTML

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .="<p><strong> Hola " . $this->nombre . " </strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo</p>";
        $contenido .="<p> Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'> Reestablecer Contraseña</a> </p>";
        $contenido .= "<p>Si tu no solictaste esta cuenta, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();

    }
}

?>
