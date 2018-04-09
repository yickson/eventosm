<?php
require_once APP_PATH ."extensions/helpers/datatable_acciones.php";
/**
 * Modelo para gestionar los colegios
 */
class Colegios extends ActiveRecord
{
  public function crear()
  {
    $rbd = Input::post('rbd');
    $nombre = Input::post('nombre');

    $colegio = (New Colegios);
    $colegio->rbd = $rbd;
    $colegio->nombre = $nombre;
    $colegio->pais = 'CL';
    if($colegio->save()){
      return 1; //Guardado exitoso
    }else{
      return 2; //Error en el almacenado
    }
  }

  public function editar()
  {
    $id = Input::post('id');
    $rbd = Input::post('rbd');
    $nombre = Input::post('nombre');

    $colegio = (New Colegios)->find($id);
    //Buscar si existen usuarios asociados para actualizar el codigo RBD
    $usuarios = (New Usuarios)->sql("UPDATE usuarios SET rbd = $rbd WHERE rbd = $colegio->rbd");
    $colegio->rbd = $rbd;
    $colegio->nombre = $nombre;
    $colegio->pais = 'CL';
    if($colegio->save()){
      return 1; //Guardado exitoso
    }else{
      return 2; //Error en el almacenado
    }
  }

  public function listar()
  {
    $colegios = (New Colegios)->find();
    $datos = array();
    $i = 0;
    foreach ($colegios as $key => $valor) {
      $datos[$i]['rbd'] = $valor->rbd;
      $datos[$i]['nombre'] = $valor->nombre;
      $conteo = (New Usuarios)->count("rbd = '$valor->rbd'");
      $datos[$i]['cupos'] = DatatableAcciones::getBtnCupos($conteo);
      $datos[$i]['acciones'] = DatatableAcciones::getBtnColegio($valor->id);
      $i++;
    }

    return $datos;
  }
}


?>
