<?php

/**
 * Controlador principal
 */
class IndexController extends AppController
{
  function before_filter()
  {
    View::template('main');
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
    View::template('admin');
  }

  public function entrar()
  {
    if(Input::hasPost('correo', 'clave')){
      $auth = (New Administrador)->login();
      if($auth){
        Redirect::to('administrador');
      }
    }
  }

  public function cerrar()
  {
    View::template(NULL);
    $auth = (New Administrador)->logout();
    Redirect::to('administrador/entrar');
  }
}


?>
