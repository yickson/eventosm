<?php

/**
 * Controlador para gestionar el programa
 */
class ProgramaController extends AppController
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
    $this->programa = (New Programa)->find(1);
  }

  public function editar()
  {
    $this->programa = (New Programa)->find(1);
  }

  public function crear()
  {

  }

  public function eliminar()
  {

  }

  //Métodos AJAX

  public function editar_programa()
  {
    $dato = (New Programa)->editar();
    $this->data = $dato;
    View::select(null, 'json');
  }
}


?>
