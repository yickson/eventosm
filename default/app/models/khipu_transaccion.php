<?php

/**
 * Modelo para gestionar los pagos de Khipu (Solo transferencias)
 */
class KhipuTransaccion extends ActiveRecord
{
  public function ingresar()
  {
    $datos = (New KhipuTransaccion);
    $datos->usuario_id = Session::get('compra');
    $datos->orden_compra = Session::get('idpago');
    $datos->monto = Session::get('total');
    $datos->estado = 1;
    $datos->fecha = date('Y-m-d H:i:s');

    $orden = (New KhipuTransaccion)->find_by_orden_compra(Session::get('idpago'));
    if(empty($orden)){
      if($datos->save()){
        return $datos->id;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
}


?>
