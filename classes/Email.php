<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('soporte@noesis.com', 'Noesis');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $url_confirmacion = $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token;

        $contenido = "<html>";
        $contenido .= "<body style='margin: 0; padding: 0; background-color: #f6f9fc; font-family: Arial, sans-serif;'>";
        $contenido .= "  <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f6f9fc; padding: 20px;'>";
        $contenido .= "    <tr>";
        $contenido .= "      <td align='center'>";
        $contenido .= "        <table width='600' border='0' cellspacing='0' cellpadding='0' style='background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";
        $contenido .= "          ";
        $contenido .= "          <tr>";
        $contenido .= "            <td style='padding: 20px; background-color: #ffffff; border-bottom: 1px solid #eeeeee;'>";
        $contenido .= "              <h2 style='margin: 0; color: #001f3f; font-size: 24px;'>NOESIS</h2>";
        $contenido .= "            </td>";
        $contenido .= "          </tr>";
        $contenido .= "          ";
        $contenido .= "          <tr>";
        $contenido .= "            <td style='padding: 40px; text-align: center;'>";
        $contenido .= "              <div style='background-color: #eef5ff; width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: table;'>";
        $contenido .= "                <span style='display: table-cell; vertical-align: middle; font-size: 40px;'>🛡️</span>";
        $contenido .= "              </div>";
        $contenido .= "              <h1 style='color: #1a1a1a; font-size: 24px; margin-bottom: 10px;'>Verifica tu cuenta</h1>";
        $contenido .= "              <p style='color: #555555; font-size: 16px; line-height: 1.5;'>Hola <strong>" . $this->nombre . "</strong>,</p>";
        $contenido .= "              <p style='color: #555555; font-size: 16px; line-height: 1.5; margin-bottom: 30px;'>Hemos creado tu cuenta en Noesis. Para comenzar a utilizar la plataforma y asegurar tu acceso, por favor confirma tu dirección de correo electrónico.</p>";
        $contenido .= "              ";
        $contenido .= "              <a href='" . $url_confirmacion . "' style='background-color: #007bff; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; display: inline-block;'>Confirmar Cuenta</a>";
        $contenido .= "            </td>";
        $contenido .= "          </tr>";
        $contenido .= "          ";
        $contenido .= "          <tr>";
        $contenido .= "            <td style='padding: 20px 40px; background-color: #fafafa; border-top: 1px solid #eeeeee;'>";
        $contenido .= "              <p style='color: #888888; font-size: 13px; margin: 0;'><strong>¿Por qué recibí esto?</strong> Si no solicitaste la creación de una cuenta en Noesis, puedes ignorar este mensaje de forma segura.</p>";
        $contenido .= "            </td>";
        $contenido .= "          </tr>";
        $contenido .= "        </table>";
        $contenido .= "        <p style='color: #aaaaaa; font-size: 12px; margin-top: 20px;'>© " . date('Y') . " Noesis - Todos los derechos reservados.</p>";
        $contenido .= "      </td>";
        $contenido .= "    </tr>";
        $contenido .= "  </table>";
        $contenido .= "</body>";
        $contenido .= "</html>";

/*        $contenido = "<html>";
        $contenido .="<p><strong>Hola " . $this->nombre . "</strong> Hemos creado tu cuenta en Noesis, solo debes confirmar tu cuenta presionando el siguiente enlace</p>";
        $contenido .="<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] ."/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";*/

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('cuentas@appsalon.com', 'Mailer');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Restablece tu Password';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .="<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer tu Password, sigue el siguiente enlace para hacerlo</p>";
        $contenido .="<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] ."/recuperar?token=". $this->token ."'>Restablecer Password</a></p>";
        $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
}