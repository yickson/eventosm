<?php

/**
 * Controlador para gestionar las estadisticas
 */
class EstadisticasController extends AppController
{

  function before_filter()
  {
    View::template('admin');
    $auth = (New Administrador)->logged();
    $accion = $this->action_name;
    if(!$auth and $accion != 'entrar'){
      Redirect::to('administrador/entrar');
    }
    else{
      $this->nombre = Session::get('nombre', 'administrador');
    }
  }

  public function index()
  {

  }

  //Metodos AJAX

  public function pagos()
  {
    View::select(null, 'json');
  }
}


?>
