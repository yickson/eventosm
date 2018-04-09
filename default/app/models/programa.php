<?php

/**
 * Modelo para gestionar el programa del evento
 */
class Programa extends ActiveRecord
{
  public function editar()
  {
    $programa = Input::post('programa');
    $datos = (New Programa)->find(1);
    $datos->contenido = $programa;
    $datos->fecha = date('Y-m-d H:i:s');
    if($datos->save()){
      return 1;
    }else{
      return 2;
    }
  }
}



?>
