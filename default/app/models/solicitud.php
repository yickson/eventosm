<?php

/**
 * Modelo para gestionar la solicitudes de los colegios
 */
class Solicitud extends ActiveRecord
{
  public function inscribir($region, $comuna, $rbd, $entradas, $correo)
  {
    //Limitar
    $disponible = $this->verificar_compra($rbd, $entradas);
    $rbd = $this->validar_rbd($rbd);
    $tipo_var = gettype($disponible);

    if($tipo_var == 'array'){

      if($disponible[0] == 'd'){
        $colegio = array();
        $colegio['region'] = $region;
        $colegio['comuna'] = $comuna;
        $colegio['rbd'] = $rbd;
        $colegio['entradas'] = $entradas;
        $colegio['correo'] = $correo;
        Session::set('colegio', $colegio);
        return array(4, $disponible[1]); //Aun le queda disponibilidad
      }

      if($disponible[0] == 'c'){
        return array(3, $disponible[1]); //Tiene disponibilidad pero supera por la cantidad que pide
      }
    }else{

      if($disponible == 'a'){
        $colegio = array();
        $colegio['region'] = $region;
        $colegio['comuna'] = $comuna;
        $colegio['rbd'] = $rbd;
        $colegio['entradas'] = $entradas;
        $colegio['correo'] = $correo;
        Session::set('colegio', $colegio);
        return array(1, 3); //No ha comprado ni una entrada le quedan todos los cupos disponibles por colegio
      }

      if($disponible == 'b'){
        return array(2, 3); //No puede hacer más adquisición de entradas
      }

      if($disponible == 'e'){
        return array(6, 6); //No puede realizar ninguna compra en la plataforma
      }
    }
  }

  public function verificar_compra($rbd, $entradas)
  {
    //Metodo para validar compra de colegio
    $conteo = (New Usuarios)->count("rbd = '$rbd'");
    $cantidad = (New Configuracion)->find(1)->limite_colegio;
    $cupos = (New Configuracion)->find(1)->cupos;
    //El numero puede ser una variable de configuracion en el backend(3)
    if($cupos >= $entradas){
      //La cantidad de cupos es mayor por lo cual pueden hacer una solicitud
      if($conteo > $cantidad){
        return 'b'; //Error Cupo superado de entradas por colegio
      }else{
        if($conteo < 1 and $entradas < $cantidad){
          return 'a'; //No ha comprado ninguna entrada
        }else{
          $dispo = $cantidad - $conteo; //Operacion de entradas disponibles para este colegio
          if($dispo >= $entradas){
            return array('d', $dispo); //Las entradas no superan las disponibles
          }else{
            return array('c', $dispo); //Las entradas superan las disponibles
          }
        }
      }
    }else{
      //No puede realizar la compra
      return 'e';
    }
  }

  public function ingresar()
  {
    $datos = Session::get('colegio');
    $solicitud = New Solicitud;
    $solicitud->region_id = $datos['region'];
    $solicitud->comuna_id = $datos['comuna'];
    $solicitud->rbd = $datos['rbd'];
    $solicitud->entradas = $datos['entradas'];
    $solicitud->correo = $datos['correo'];

    if($solicitud->save()){
      Session::set('idsolicitud', $solicitud->id);
      return 1; //Exitoso
    }else{
      return 2; //Error en almacenar
    }
  }

  public function validar_rbd($rbd)
  {
    //Metodo para validar que el tipo del RBD sea numerico
    $rbd_num = (int)$rbd;

    if(is_numeric($rbd_num) and $rbd_num != 0){
      $dato = (New Colegios)->find_by_rbd($rbd_num);
      if(!empty($dato)){
         return $rbd_num;
      }else{
        $rbd_nuevo = $this->generarRbd();
        $colegio = New Colegios;
        $colegio->rbd = $rbd_nuevo;
        $colegio->nombre = $rbd;
        $colegio->pais = 'NA';
        if($colegio->save()){
           return $rbd_nuevo;
        }
      }
    }else{
      $rbd_nuevo = $this->generarRbd();
      $colegio = New Colegios;
      $colegio->rbd = $rbd_nuevo;
      $colegio->nombre = $rbd;
      $colegio->pais = 'NA';
      if($colegio->save()){
        return $rbd_nuevo;
      }
    }
  }

  public static function generarRbd($n = 4)
  {
    //Generamos la orden de la compra
    //SM1701281611
    $key = '';
    $pattern = '1234567890';
    $max = strlen($pattern)-1;
    for($i=0;$i < $n;$i++) $key .= $pattern{mt_rand(0,$max)};
    $rbdfake = 987;
    $rbdnew = $rbdfake.$key;
    $rbd = (New Colegios)->find_by_rbd($rbdnew);
    if(empty($rbd)){
      return $rbdnew;
    }
    else{
      self::generarRbd($n);
    }
  }
}


?>
