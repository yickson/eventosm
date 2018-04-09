<?php

/**
 * Modelo para gestionar la transacciones de Webpay
 */
class WebpayTransaccion extends ActiveRecord
{
  public static function generarOrden($n)
  {
    //Generamos la orden de la compra
    //SM1701281611
    $key = '';
    $pattern = '1234567890';
    $max = strlen($pattern)-1;
    for($i=0;$i < $n;$i++) $key .= $pattern{mt_rand(0,$max)};
    $datos = (New Codigo)->find(1);
    $cadena = $datos->indice.$key;
    $orden = (New WebpayTransaccion)->find_by_numero_compra($cadena);
    if(empty($orden)){
      return $cadena;
    }
    else{
      self::generarOrden($n);
    }
  }

  public function ingresar($pago)
  {
    //Metodo para ingresar la transaccion
    $transaccion = New WebpayTransaccion;
    $transaccion->solicitud_id = Session::get('idsolicitud');
    $transaccion->numero_compra = $pago->detailOutput->buyOrder;
    $transaccion->numero_tarjeta = $pago->cardDetail->cardNumber;
    $transaccion->cuotas = $pago->detailOutput->sharesNumber;
    $transaccion->tipo_pago = $pago->detailOutput->paymentTypeCode;
    $transaccion->respuesta = $pago->detailOutput->responseCode;
    $transaccion->monto = $pago->detailOutput->amount;
    $transaccion->fecha = date("Y-m-d H:i:s");
    $transaccion->vci = $pago->VCI;

    if($transaccion->save()){
      return $transaccion->id;
    }
    else{
      return false;
    }
  }

  public function anulado()
  {
    //Metodo para ingresar la transaccion
    $transaccion = New WebpayTransaccion;
    $transaccion->solicitud_id = Session::get('idsolicitud');
    $transaccion->buyOrder = 'SM0001112223';
    $transaccion->cardNumber = '1111';
    $transaccion->cuotas = '';
    $transaccion->tipoPago = '';
    $transaccion->codigoRespuesta = '-9';
    $transaccion->monto = Session::get('total');
    $transaccion->fecha = date("Y-m-d H:i:s");
    $transaccion->VCI = 'ANUL';

    if($transaccion->save()){
      return $transaccion->id;
    }
    else{
      return false;
    }
  }

  public function listar()
  {
    $datos = (New WebpayTransaccion)->find_all_by_sql("SELECT wt.*, u.nombre FROM webpay_transaccion wt INNER JOIN usuarios u ON(u.id = wt.solicitud_id) WHERE wt.respuesta = 0");
    $data = array();
    $i = 0;
    foreach ($datos as $key => $valor) {
      $data[$i]['id'] = $valor->solicitud_id;
      $data[$i]['orden'] = $valor->numero_compra;
      $data[$i]['cuotas'] = $valor->cuotas;
      $data[$i]['monto'] = $valor->monto;
      $data[$i]['nombre'] = $valor->nombre;
      $data[$i]['fecha'] = $valor->fecha;
      $i++;
    }

    return $data;
  }

  public function todas()
  {
    $datos = (New WebpayTransaccion)->find_all_by_sql("SELECT wt.*, u.nombre FROM webpay_transaccion wt INNER JOIN usuarios u ON(u.id = wt.usuario_id)");
    $data = array();
    $i = 0;
    foreach ($datos as $key => $valor) {
      $data[$i]['id'] = $valor->usuario_id;
      $data[$i]['orden'] = $valor->numero_compra;
      $data[$i]['cuotas'] = $valor->cuotas;
      $data[$i]['monto'] = $valor->monto;
      $data[$i]['nombre'] = $valor->nombre;
      $data[$i]['fecha'] = $valor->fecha;
      $i++;
    }

    return $data;
  }
}


?>
