<?php

/**
 * Modelo para gestionar los pedidos
 */
class Pedidos extends ActiveRecord
{
  public function ingresar($idtransaccion, $webpay)
  {
    //Datos del pedido
    $datos = New Pedidos;
    $datos->solicitud_id = Session::get('idsolicitud');
    $datos->transaccion_id = $idtransaccion;
    $datos->monto = $webpay->detailOutput->amount;
    $datos->fecha = date("Y-m-d H:i:s");

    if($datos->save()){
      return $datos->id;
    }
    else{
      return false;
    }
  }

  public function ingresar_khipu($idtransaccion)
  {
    //Datos del pedido
    $datos = New Pedidos;
    $datos->solicitud_id = Session::get('idsolicitud');
    $datos->transaccion_id = $idtransaccion;
    $datos->monto = Session::get('total');
    $datos->fecha = date("Y-m-d H:i:s");

    if($datos->save()){
      return $datos->id;
    }
    else{
      return false;
    }
  }
}


?>
