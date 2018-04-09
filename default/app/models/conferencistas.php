<?php
require_once APP_PATH ."extensions/helpers/datatable_acciones.php";
/**
 * Modelo para gestionar a los Conferencistas del evento
 */
class Conferencistas extends ActiveRecord
{
  public function listar()
  {
    $usuarios = array();
    $datos = (New Conferencistas)->find();
    $i = 0;
    foreach ($datos as $key => $valor) {
      $usuarios[$i]['id'] = $valor->id;
      $usuarios[$i]['nombre'] = $valor->nombre;
      $usuarios[$i]['acciones'] = DatatableAcciones::getBtnAdm($valor->id);
      $i++;
    }
    return $usuarios;
  }
  public function crear()
  {
    if(Input::hasPost('nombre')){
      $nombre = Input::post('nombre');
      $descripcion = Input::post('descripcion');
      $imagen = Upload::factory('imagen', 'image');
      $imagen ->setExtensions(array('jpg', 'jpeg', 'png', 'gif'));
      if($imagen->isUploaded()){
        $nombre = $imagen->saveRandom();
        $ruta = PUBLIC_PATH.'img/upload/'.$nombre;
        $datos = (New Conferencistas);
        $datos->nombre = $nombre;
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

  public function editar()
  {
    $id = Input::post('id');
    $nombre = Input::post('nombre');
    $descripcion = Input::post('descripcion');
    $datos = (New Conferencistas)->find($id);
    if($_FILES['imagen']['tmp_name'] != ""){
      $imagen = 'imagen';
      $datos->imagen = (New Conferencistas)->modificar_imagen($id, $nombre);
    }
    $datos->nombre = $nombre;
    $datos->contenido = $descripcion;
    $datos->fecha = date('Y-m-d H:i:s');
    if($datos->save()){
      return 1;
    }else{
      return 2;
    }
  }

  public function modificar_imagen($id, $archivo)
  {
    $conferencista = (New Conferencistas)->find($id);
    if($conferencista->imagen){
      $path = 'http://localhost/evento/default/public/'.$conferencista->imagen; // /home/servic57/public_html/evento/img/upload
      unlink($path);
    }

    $imagen = Upload::factory($archivo, 'image');
    $imagen->setExtensions(array('jpg', 'jpeg', 'png', 'gif'));
    if($imagen->isUploaded()){
      $nombre = $imagen->saveRandom();
      $ruta = 'upload/'.$nombre;
      return $ruta;
    }
  }
}


?>
