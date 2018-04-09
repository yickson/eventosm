<?php

/**
 * Controlador para gestionar los usuarios
 */
class UsuariosController extends AppController
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

  //Metodos Ajax

  public function listar_usuarios()
  {
    $usuarios = (New Usuarios)->listar();
    $this->data = $usuarios;
    View::select(null, 'json');
  }

  public function eliminar()
  {
    $id = Input::post('id');
    $dato = (New Usuarios)->find($id);
    if($dato->delete()){
      $config = (New Configuracion)->find(1);
      $config->cupos = ++$config->cupos;
      $config->save();
      $this->data = 1;
    }else{
      $this->data = 2;
    }
    View::select(null, 'json');
  }
}



?>
