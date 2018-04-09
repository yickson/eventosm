<?php

/**
 * Controlador para gestionar el archivo de la presentación
 */
class ArchivoController extends AppController
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
    //Archivo cargado en la vista principal
  }

  public function subir()
  {
    //Subir archivo de la presentación
  }

  public function editar()
  {
    //Edicion del archivo, si existe alguno eliminarlo
  }

  public function eliminar()
  {
    //Eliminar el archivo en caso de existir
  }
}


?>
