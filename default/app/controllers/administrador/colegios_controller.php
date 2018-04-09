<?php

/**
 * Controlador de colegios
 */
class ColegiosController extends AppController
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
    //Mostrar todos los colegios y los cupos correspondientes

  }

  public function crear()
  {
    //Crear nuevo colegio
  }

  public function editar($id)
  {
    //Editar colegio
    $this->colegio = (New Colegios)->find($id);
  }

  //Metodos AJAX

  public function listar_colegios()
  {
    $datos = (New Colegios)->listar();
    $this->data = $datos;
    View::select(null, 'json');
  }

  public function crear_colegio()
  {
    $datos = (New Colegios)->crear();
    $this->data = $datos;
    View::select(null, 'json');
  }

  public function editar_colegio()
  {
    $datos = (New Colegios)->editar();
    $this->data = $datos;
    View::select(null, 'json');
  }

  public function eliminar()
  {
    $id = Input::post('id');
    $dato = (New Colegios)->find($id);
    if($dato->delete()){
      $this->data = 1;
    }else{
      $this->data = 2;
    }
    View::select(null, 'json');
  }
}


?>
