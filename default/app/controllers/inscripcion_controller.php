<?php
//require __DIR__ . '../../../../vendor/autoload.php';
/**
 * Controlador para gestionar las inscripciones
 */
class InscripcionController extends AppController
{
  public $receiver_id = 168377; //121544; //168377
  public $secret = "dd6027e9b8da033cf04dcee0009705767b2dc8d1";//"47bf824e3e2477d8c56d3db016975bbb3daf147d";
  public $return_url = 'https://localhost/eventosm/inscripcion/regreso';
  public $notify_url = 'https://serviciosm.cl/evento/notificacion';

  function before_filter()
  {
    View::template('eventosm');
  }

  public function index()
  {
    //Formulario para inscripcion
    $this->region = (New Regiones)->find();
    $this->colegios = (New Colegios)->find();
    if(Session::has('idsolicitud')){
        Session::delete('idsolicitud');
    }
  }

  public function vistaprueba()
  {
    View::template('eventosm');
  }

  public function invitados()
  {
    //Nombre de acompañantes
    $this->cargo = (New Cargos)->find();
    $dato = Session::get('colegio');
    $this->entradas = $dato['entradas'];
  }

  public function procesar_usuarios()
  {
    $datos = (New Usuarios)->procesar_usuarios();
    //$solicitud = (New Solicitud)->ingresar(); //Esta línea esta demasiado pronto, corroborar pago o solicitud real
    if(!empty(Session::get('usuarios'))){
      Redirect::toAction('pago');
    }else{
      Flash::error('Error en almacenar usuarios');
      Redirect::toAction('invitados');
    }

    View::select(null, null);
  }

  public function pago()
  {
    //Muestra detalle de lo que va a pagar el usuario
    //$compra = Session::get('compra');
    $this->datos = Session::get('colegio');
    $this->conf = (New Configuracion)->find(1);
    if($this->conf->precio == 0){
      $total = 0;
    }else{
      $total = $this->datos['entradas'] * $this->conf->precio;
      Session::set('total', $total);
    }
  }

  public function solicitar()
  {
    //Metodo para solicitar entradas cuando es gratis el evento

    $cantidad = Session::get('colegio')['entradas'];

    //Realizar la inserción de los datos
    $solicitud = (New Solicitud)->ingresar(); //Ingreso de solicitud
    $usuarios = (New Usuarios)->ingresar(); //Ingreso de los invitados
    $conteo = (New Configuracion)->contador_cupos($usuarios);
    if($cantidad == $usuarios){
      Email::gratis();
    }
    $this->data = 1;
    View::select(null, 'json');
  }

  public function detalle_gratis()
  {
    $this->usuarios = Session::get('usuarios');
    $this->colegio = (New Colegios)->find_by_rbd(Session::get('colegio')['rbd'])->nombre;
  }

  public function pasarela()
  {
    //Formulario de webpay
    $this->conf = (New Configuracion)->find(1);
    Load::lib('webpago');
    $webpay = New Webpago;
    $result = $webpay->inicioWebpay();
    if(is_object($result)){
      $this->result = $webpay->inicioWebpay();
    }else{
      Redirect::to('../');
    }

    View::template(null);
  }

  public function retorno()
  {
    //Captura de respuesta de webpay
    Load::lib('webpago');
    $webpay = New Webpago;

    $this->token = $_POST['token_ws'];
    try {
      $this->result = $webpay->retornoWebpay($this->token);
      if($this->result->detailOutput->responseCode != 0) {
        $this->errorpay = true;
        $transaccion = (New WebpayTransaccion)->ingresar($this->result);
        Redirect::to('inscripcion/error');
      }else{
        $this->errorpay = false;
        $solicitud = (New Solicitud)->ingresar();
        $usuarios = (New Usuarios)->ingresar();
        //print_r($this->result);die();
        $transaccion = (New WebpayTransaccion)->ingresar($this->result); //Webpay
        $pedido = (New Pedidos)->ingresar($transaccion, $this->result); // Pedidos Master

        //Contador
        $cantidad = Session::get('colegio')['entradas'];
        $conteo = (New Configuracion)->contador_cupos($cantidad);
        //View::template(null);
      }
    }
    catch(Exception $ex) {
      echo $ex->getMessage();
    }
  }

  public function detalle_pasaje()
  {
    $this->token = Input::post('token_ws');
    if($this->token == '' or $this->token == null){
      $webpay = (New WebpayTransaccion)->anulado();
      Redirect::toAction('anulado');
    }else{
      Redirect::toAction('detalle');
    }
  }

  public function detalle()
  {
    //Vista final con el pago y envio de correo con el detalle
    $id = Session::get('idsolicitud');
    $this->id = $id;
      $this->usuario = Session::get('colegio');
      $comprapay = (New WebpayTransaccion)->find_by_sql("SELECT * FROM webpay_transaccion WHERE solicitud_id = ".$id." ORDER BY id DESC LIMIT 1");
      $this->comprapay = $comprapay; //id de comprapay
      //$pedido = (New Pedidos)->find_by_sql("SELECT id FROM pedidos WHERE transaccion_id = $comprapay->id");
      //Email::usuario($comprapay, $this->usuario);
  }

  public function anulado()
  {

  }

  public function error()
  {
    //Vista con los errores según lo que haya dado webpay
  }

  public function khipu()
  {
    $this->receiver_id;
    $this->secret;
  }

  public function procesar_pago()
  {
    $configuration = new Khipu\Configuration();
    $configuration->setReceiverId($this->receiver_id);
    $configuration->setSECRET($this->secret);
    // $configuration->setDebug(true);

    $client = new Khipu\ApiClient($configuration);
    $payments = new Khipu\Client\PaymentsApi($client);


    try {
        $opts = array(
            "body" => "Este es un pago de pruebas para usar la biblioteca khipu.",
            "bank_id" => Input::post('banco'),
            "payer_email" => Input::post('correo'),
            "return_url" => $this->return_url,
            //"notify_url" => $this->NOTIFY_URL,
            "notify_api_version" => "1.3"
        );
        $response = $payments->paymentsPost("Compra de entradas para el evento" //Motivo de la compra
            , "CLP" //Moneda
            , Session::get('total') //Monto
            , $opts );
            $this->respuesta = $response;
        Redirect::to('inscripcion/proceso/'.$response->getPaymentId());
    } catch (\Khipu\ApiException $e) {
        echo print_r($e->getResponseBody(), TRUE);
    }
  }

  public function proceso($idpago)
  {
    $this->idpago = $idpago;
    Session::set('idpago', $idpago); //Esto es el ID del pago único de Khipu
    $this->urlpago = 'https://khipu.com/payment/info/'.$idpago;
    $this->terminal = 1;
  }

  public function regreso()
  {
    $this->idpago = Session::get('idpago');
  }

  public function detalle_khipu()
  {
    $id = Session::get('compra');
    $this->usuario = (New Usuarios)->find($id);
    $comprapay = (New KhipuTransaccion)->find_by_sql("SELECT * FROM khipu_transaccion WHERE usuario_id = ".$id." ORDER BY id DESC LIMIT 1");
    $this->comprapay = $comprapay; //id de comprapay
    $pedido = (New Pedidos)->find_by_sql("SELECT id FROM pedidos WHERE transaccion_id = $comprapay->id");
      //Email::usuario($comprapay, $this->usuario);
  }

  //Métodos AJAX

  public function datos()
  {
    View::select(null, 'json');
  }

  public function cargarComunas()
  {
    $region = Input::post("region");
  	$comunas = (new Comunas)->find_all_by_id_region($region);
  	$this->data = $comunas;
  	View::select(null, "json");
  }

  public function solicitarInscripcion()
  {
    $region = Input::post("region"); //Region del colegio
    $comuna = Input::post("comuna"); //Comuna del colegio
    $colegio = Input::post("colegio"); //ID del colegio en nuestra base de datos  pero optare por el RBD
    $entrada = Input::post("entradas"); //Cantidad de entradas que va a comprar ese colegio
    $correo = Input::post("correo");
    $datos = (New Solicitud)->inscribir($region, $comuna, $colegio, $entrada, $correo);
    $this->data = $datos;
    View::select(null, 'json');
  }

  public function bancos_khipu()
  {
    Load::lib('khipup');
    $Khipu = new Khipu();
    // Nos identificamos
    $Khipu->authenticate($this->receiver_id, $this->secret);
    $service = $Khipu->loadService('ReceiverBanks');
    $this->data = $service->consult();

    View::select(null, 'json');
  }

  public function notificacion()
  {
    Load::lib('khipup');
    $Khipu = new Khipu();
              // Nos identificamos
              $Khipu->authenticate($this->receiver_id, $this->secret);
              $data = array(
                'payment_id' => Session::get('idpago'),
              );
              $service = $Khipu->loadService('PaymentStatus');
              $service->setParameters($data);
              $consult = $service->consult();
              if ($consult) {
                $khipu_id = (New KhipuTransaccion)->ingresar();//Hacer captura de la transaccion
                if($khipu_id != false){
                  $pedido = (New Pedidos)->ingresar_khipu($khipu_id);//Captura del pedido
                  //Contador
                  $cantidad = (New Usuarios)->find(Session::get('compra'))->cantidad;
                  $conteo = (New Configuracion)->contador_cupos($cantidad);
                }
              $this->data = $consult;
              }
              else {
                $this->data = 2;
              }
    View::select(null, 'json');
  }
}



?>
