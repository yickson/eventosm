<?php

/**
 * Modelo para gestionar el indice de la orden de compra
 */
class Codigo extends ActiveRecord
{
  public function editar()
  {
    $indice = Input::post('indice');

    $datos = (New Codigo)->find(1);
    $datos->indice = $indice;
    $datos->fecha = date('Y-m-d H:i:s');

    if($datos->save()){
      return 1;
    }else{
      return 2;
    }
  }
}


?>
