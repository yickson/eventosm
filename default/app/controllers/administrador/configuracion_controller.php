<?php

/**
 * Controlador para gestionar la configuración básica del evento
 */
class ConfiguracionController extends AppController
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
    $this->evento = (New Configuracion)->find(1);
  }

  public function editar()
  {
    $this->evento = (New Configuracion)->find(1);
  }

  //Métodos AJAX

  public function editar_configuracion()
  {
    $dato = (New Configuracion)->editar();
    $this->data = $dato;
    View::select(null, 'json');
  }

}


?>
