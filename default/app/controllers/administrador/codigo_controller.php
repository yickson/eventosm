<?php

/**
 * Controlador para gestionar el indice del evento
 */
class CodigoController extends AppController
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
    $this->codigo = (New Codigo)->find(1);
  }

  public function editar()
  {
    $this->codigo = (New Codigo)->find(1);
  }

  public function crear()
  {

  }

  //Metodos Ajax

  public function editar_codigo()
  {
    $datos = (New Codigo)->editar();
    $this->data = $datos;
    View::select(null, 'json');
  }
}


?>
