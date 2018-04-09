<?php

/**
 * Modelo para gestionar las imagenes que van en el banner
 */
class Banner extends ActiveRecord
{

  public function editar_banner()
  {
    if($_FILES['banner']['tmp_name'] != ""){
      $ruta = $this->modificar_imagen();
      $banner = New Banner;
      $banner->nombre = $ruta;
      if($banner->save()){
        return 1; //Exitoso
      }else{
        return 2; //Error en guardar
      }
    }else{
      return 3; //Input File vacio
    }
  }

  public function modificar_imagen()
  {
    $archivo = 'banner';
    $datos = $this->find(1);
    if($datos->nombre != 'defecto.png'){
      $path = '/home/servic57/public_html/evento/img/upload';
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
