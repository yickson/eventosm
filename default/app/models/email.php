<?php
//require_once '/home/servic57/vendor/autoload.php';
/**
 *
 */
class Email
{

  public static function enviar($compra, $usuario)
  {
    //$destino = "yicksonr@gmail.com";
    $encoding = "utf-8";
    $from_name = "Ediciones SM";
    $from_mail = "no-responder@servicio.cl";
    // Preferences for Subject field
    $subject_preferences = array(
        "input-charset" => $encoding,
        "output-charset" => $encoding,
        "line-length" => 76,
        "line-break-chars" => "\r\n"
    );

    // Mail header
    $header = "Content-type: text/html; charset=".$encoding." \r\n";
    $header .= "From: ".$from_name." <".$from_mail."> \r\n";
    $header .= "MIME-Version: 1.0 \r\n";
    $header .= "Content-Transfer-Encoding: 8bit \r\n";
    $header .= "Date: ".date("r (T)")." \r\n";
    $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

    $asunto = "Detalles de su compra";
    $html = (New Plantillas)->usuario($compra, $usuario); //Carga de template

    mail($usuario->correo, $asunto, $html, $header) or die("Su mensaje no pudo enviarse.");
  }

  public static function gratis()
  {
    $usuarios = Session::get('usuarios');
    $correo = Session::get('colegio')['correo'];

    $encoding = "utf-8";
    $from_name = "Ediciones SM";
    $from_mail = "no-responder@servicio.cl";
    // Preferences for Subject field
    $subject_preferences = array(
        "input-charset" => $encoding,
        "output-charset" => $encoding,
        "line-length" => 76,
        "line-break-chars" => "\r\n"
    );

    // Mail header
    $header = "Content-type: text/html; charset=".$encoding." \r\n";
    $header .= "From: ".$from_name." <".$from_mail."> \r\n";
    $header .= "MIME-Version: 1.0 \r\n";
    $header .= "Content-Transfer-Encoding: 8bit \r\n";
    $header .= "Date: ".date("r (T)")." \r\n";
    $header .= iconv_mime_encode("Subject", 'Correo de prueba', $subject_preferences);

    $asunto = "Detalles de la entrada";
    $html = (New Plantillas)->gratis($usuarios); //Carga de template

    mail($correo, $asunto, $html, $header) or die("Su mensaje no pudo enviarse.");

    // Create the Transport
    /*$transport = (new Swift_SmtpTransport('mail.smcompra.cl', 587))
      ->setUsername('evento@serviciosm.cl')
      ->setPassword('chile2468');

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    $usuario = (New Usuarios)->find_by_email($destino);

    // Create a message
    $message = (new Swift_Message('Detalle Compra'))
      ->setFrom(['compras@smcompra.cl' => 'SMCompra'])
      ->setTo([$destino, 'no-responder@smcompra.cl', 'lorena.nanco@ediciones-sm.cl' => 'Detalle Compra'])
      ->setBody((New Plantillas)->profesor($detalles, $direccion, $usuario), "text/html");

    // Send the message
    $result = $mailer->send($message);*/
  }


}


?>
