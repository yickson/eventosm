<?php

/**
 * Librería que retorna el resultado
 */
Load::lib('libwebpay/webpay');
class Webpago
{
  public $urlR = 'https://localhost/eventosm/inscripcion/retorno'; //URL de llamada de Retorno
  public $urlF = 'https://localhost/eventosm/inscripcion/detalle_pasaje'; //URL de vista final segun caso
  public $urlR2 = 'https://www.localhost/eventosm/inscripcion/retorno'; //URL de llamada de Retorno
  public $urlF2 = 'https://www.localhost/eventosm/inscripcion/detalle_pasaje'; //URL de vista final segun caso
  public function inicioWebpay()
  {
    //Load::lib('libwebpay/configuration');
    $certificate = Load::lib('libwebpay/cert-normal');
    $configuration = new configuration();
    $configuration->setEnvironment($certificate->environment);
    $configuration->setCommerceCode($certificate->commerce_code);
    $configuration->setPrivateKey($certificate->private_key);
    $configuration->setPublicCert($certificate->public_cert);
    $configuration->setWebpayCert($certificate->webpay_cert);
    $webpay = new Webpay($configuration);
    $amount    = Session::get('total');//10990; //Input::post('total');
    $buyOrder  = WebpayTransaccion::generarOrden(10); //Generarorden();
    //$buyOrderSession = setcookie("buyOrderSM", $buyOrder,time()+86400*30);

    if(empty(Session::get('usuarios') || Session::get('usuarios') == " " ))
    {
    	Flash::error("Ha ocurrido un problema, su Sesión se ha perdido, intente nuevamente comprar los productos. Gracias");
    	Redirect::to('../', 5);
    }else{
	$sessionId = Session::get('idsolicitud'); //Random
	$urlReturn = ($_SERVER["HTTP_HOST"] == 'www.localhost')? $this->urlR2 : $this->urlR;
	$urlFinal  = ($_SERVER["HTTP_HOST"] == 'www.localhost')? $this->urlF2 : $this->urlF;
	return $webpay->getNormalTransaction()->initTransaction($amount, $buyOrder, $sessionId , $urlReturn, $urlFinal);
    }
  }

  public function retornoWebpay($token)
  {

    //Load::lib('libwebpay/configuration');
    $certificate = Load::lib('libwebpay/cert-normal');
    //Retorno
    $configuration = new configuration();
    $configuration->setEnvironment($certificate->environment);
    $configuration->setCommerceCode($certificate->commerce_code);
    $configuration->setPrivateKey($certificate->private_key);
    $configuration->setPublicCert($certificate->public_cert);
    $configuration->setWebpayCert($certificate->webpay_cert);

    $webpay = new Webpay($configuration);
    return $webpay->getNormalTransaction()->getTransactionResult($token);
  }
}


?>
