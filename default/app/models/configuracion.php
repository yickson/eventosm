<?php

/**
 * Modelo para gestionar las configuraciones del evento
 */
class Configuracion extends ActiveRecord
{
  public function editar()
  {
    $id = 1;
    $titulo = Input::post('nombre');
    $subtitulo = Input::post('subtitulo');
    $precio = Input::post('precio');
    $cupos = Input::post('cupos');
    $fecha = Input::post('fecha');
    $hora_in = Input::post('hora_in');
    $hora_fi = Input::post('hora_fi');
    $lugar = Input::post('lugar');
    $latitud = Input::post('latitud');
    $longitud = Input::post('longitud');
    $objetivo = Input::post('objetivo');

    $datos = (New Configuracion)->find($id);
    $datos->nombre = $titulo;
    $datos->subtitulo = $subtitulo;
    $datos->precio = $precio;
    $datos->cupos = $cupos;
    $datos->fecha = $fecha;
    $datos->hora_inicio = $hora_in;
    $datos->hora_final = $hora_fi;
    $datos->lugar = $lugar;
    $datos->latitud = $latitud;
    $datos->longitud = $longitud;
    $datos->objetivo = $objetivo;
    if($datos->save()){
      return 1;
    }else{
      return 2;
    }
  }

  public function contador_cupos($cantidad)
  {
    $datos = (New Configuracion)->find(1);
    $entradas = $datos->cupos - $cantidad;
    $datos->cupos = $entradas;

    if($datos->save()){
      return true;
    }else{
      return false;
    }
  }
}


?>
