<?php

/**
 * Controlador para gestionar el banner de la presentación
 */
class BannerController extends AppController
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

  public function editar()
  {
    //Carga del nuevo banner y borrado del antiguo
    $respuesta = (New Banner)->editar_imagen();
    switch ($respuesta) {
      case 1:
        Flash::valid('Guardado exitoso');
        Redirect::to('', 3);
        break;

      case 2:
        Flash::error('Error almacenando archivo');
        break;

      case 3:
        Flash::error('No hay archivo en el input file');
        break;
    }
  }
}


?>
