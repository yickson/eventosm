<?php

/**
 * Controlador para gestionar los conferencistas
 */
class ConferencistasController extends AppController
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

  public function crear()
  {
    if(Input::hasPost('nombre')){
      $conferencista = Input::post('nombre');
      $descripcion = Input::post('descripcion');
      $imagen = Upload::factory('imagen', 'image');
      $imagen ->setExtensions(array('jpg', 'jpeg', 'png', 'gif'));
      if($imagen->isUploaded()){
        $nombre = $imagen->saveRandom();
        $ruta = PUBLIC_PATH.'img/upload/'.$nombre;
        $datos = (New Conferencistas);
        $datos->nombre = $conferencista;
        $datos->contenido = $descripcion;
        $datos->imagen = $ruta;
        $datos->fecha = date('Y-m-d H:i:s');
        if($datos->save()){
          return 1;
        }else{
          return 2;
        }
      }
    }
  }

  public function editar($id)
  {
    $this->usuario = (New Conferencistas)->find($id);
    if(Input::hasPost('nombre')){
      $id = Input::post('id');
      $nombre = Input::post('nombre');
      $descripcion = Input::post('descripcion');
      $datos = (New Conferencistas)->find($id);
      if($_FILES['imagen']['tmp_name'] != ""){
        $imagen = 'imagen';
        $ruta = (New Conferencistas)->modificar_imagen($id, $imagen);
        $datos->nombre = $nombre;
        $datos->contenido = $descripcion;
        $datos->imagen = $ruta;
        $datos->fecha = date('Y-m-d H:i:s');
        if($datos->save()){
          Flash::valid('Editado correctamente');
          Redirect::toAction("editar/$id");
        }else{
          Flash::error('Error en la edición');
        }
      }else{
        $datos->nombre = $nombre;
        $datos->contenido = $descripcion;
        $datos->fecha = date('Y-m-d H:i:s');
        if($datos->save()){
          Flash::valid('Editado correctamente');
          Redirect::toAction("editar/$id");
        }else{
          Flash::error('Error en la edición');
        }
      }
    }
  }

  //Métodos AJAX
  public function listar_usuarios()
  {
    $datos = (New Conferencistas)->listar();
    $this->data = $datos;
    View::select(null, 'json');
  }

  public function crear_usuario()
  {
    $dato = (New Conferencistas)->crear();
    $this->data = $dato;
    View::select(null, 'json');
  }

  public function editar_usuario()
  {
    $datos = (New Conferencistas)->editar();
    $this->data = $datos;
    View::select(null, 'json');
  }

  public function eliminar_usuario($id)
  {
    $datos = (New Conferencistas)->find($id);
    if($datos->imagen){
      $ruta = '/home/servic57/public_html/evento/img/'.$datos->imagen;
      unlink($ruta);
    }
    if($datos->delete()){
      $this->data = 1;
    }else {
      $this->data = 2;
    }
    View::select(null, 'json');
  }

}


?>
