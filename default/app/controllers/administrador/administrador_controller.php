<?php

/**
 * Controlador para gestionar los administradores de la plataforma web
 */
class AdministradorController extends AppController
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

    public function crear()
    {
      $this->nivel = (New Niveles)->find();
    }

    public function editar($id)
    {
      $this->usuario = (New Administrador)->find($id);
      $this->nivel = (New Niveles)->find();
    }

    public function eliminar()
    {
      View::template(null);
    }

    //Métodos AJAX para este controlador

    public function listar_usuarios()
    {
      $datos = (New Administrador)->getAdministrador();
      $this->data = $datos;
      View::select(null, 'json');
    }

    public function editar_usuario()
    {
      $id = Input::post('id');
      $nombre = Input::post('nombre');
      $correo = Input::post('correo');
      $nivel = Input::post('nivel');

      $usuario = (New Administrador)->find($id);
      $usuario->nombre = $nombre;
      $usuario->correo = $correo;
      $usuario->nivel = $nivel;
      if($usuario->save()){
        $this->data = 1;
      }else{
        $this->data = 2;
      }
      View::select(null, 'json');
    }

    public function crear_usuario()
    {
      $id = Input::post('id');
      $nombre = Input::post('nombre');
      $correo = Input::post('correo');
      $nivel = Input::post('nivel');
      $clave = md5(Input::post('clave').'Smc0mpr4');

      $usuario = (New Administrador);
      $usuario->nombre = $nombre;
      $usuario->correo = $correo;
      $usuario->nivel = $nivel;
      $usuario->clave = $clave;
      if($usuario->save()){
        $this->data = 1;
      }else{
        $this->data = 2;
      }
      View::select(null, 'json');
    }
}


?>
