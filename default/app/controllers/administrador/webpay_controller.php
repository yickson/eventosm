<?php

/**
 * Controlador para gestionar las transacciones y pagos con webpay
 */
class WebpayController extends AppController
{

  function before_filter()
  {
    View::template('admin');
    $auth = (New Administrador)->logged();
    $accion = $this->action_name;
    if(!$auth and $accion != 'entrar'){
      Redirect::to('administrador/index/entrar');
    }
    else{
      $this->nombre = Session::get('nombre', 'administrador');
    }
  }

  public function index()
  {

  }

  //Métodos AJAX
  public function listar_operaciones()
  {
    $dato = (New WebpayTransaccion)->listar();
    $this->data = $dato;
    View::select(null, 'json');
  }

}



?>
