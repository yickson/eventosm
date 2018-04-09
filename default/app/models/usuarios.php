<?php
require_once APP_PATH ."extensions/helpers/datatable_acciones.php";
/**
 * Modelo para gestionar a los usuarios
 */
class Usuarios extends ActiveRecord
{
  public function procesar_usuarios()
  {
    //Se va recorriendo cada uno de los profesores
    $usuarios = array();
    $datos = Session::get('colegio');
    for ($i=0; $i < $datos['entradas']; $i++) {
      $usuarios[$i]['nombre'] = Input::post('nombre'.$i);
      $usuarios[$i]['telefono'] = Input::post('telefono'.$i);
      $usuarios[$i]['correo'] = Input::post('correo'.$i);
      $cargo = $this->validar_cargo(Input::post('cargo'.$i));
      $usuarios[$i]['cargo'] = $cargo;
      $usuarios[$i]['rbd'] = $datos['rbd'];
      $usuarios[$i]['fecha'] = date('Y-m-d H:i:s');
    }
    Session::set('usuarios', $usuarios);
  }

  public function ingresar()
  {
    $usuarios = Session::get('usuarios');
    foreach ($usuarios as $key => $valor) {
      
      $usuario = New Usuarios;
      $usuario->nombre = $valor['nombre'];
      $usuario->telefono = $valor['telefono'];
      $usuario->correo = $valor['correo'];
      $usuario->cargo = $valor['cargo'];
      $usuario->rbd = $valor['rbd'];
      $usuario->solicitud_id = Session::get('idsolicitud');
      $usuario->fecha = date('Y-m-d H:i:s');

      $usuario->save();
    }
  }

  public function validar_cargo($cargo)
  {
    $cargo_num = (int)$cargo; //Forzado a entero
    if($cargo_num != 0){
      return $cargo;
    }else{
      $cargos = New Cargos;
      $cargos->nombre = $cargo; //Paso el nombre que envío el usuario

      if($cargos->save()){
        return $cargos->id;
      }
    }
  }

  public function listar()
  {
    $datos = (New Usuarios)->find_all_by_sql("SELECT u.id, u.nombre, u.rbd, c.nombre as colegio, ca.nombre as cargo, u.telefono, u.correo, u.fecha FROM usuarios u INNER JOIN colegios c ON (u.rbd = c.rbd) INNER JOIN cargos ca ON (ca.id = u.cargo)");
    $usuarios = array();
    $i = 0;
    foreach ($datos as $key => $valor) {
      $usuarios[$i]['nombre'] = $valor->nombre;
      $usuarios[$i]['rbd'] = $valor->rbd;
      $usuarios[$i]['colegio'] = $valor->colegio;
      $usuarios[$i]['cargo'] = $valor->cargo;
      $usuarios[$i]['telefono'] = $valor->telefono;
      $usuarios[$i]['correo'] = $valor->correo;
      $usuarios[$i]['fecha'] = $valor->fecha;
      $usuarios[$i]['acciones'] = datatableAcciones::getBtnUsuario($valor->id);
      $i++;
    }

    return $usuarios;
  }

  public function sorteo()
  {
    //Resultado random
    $dato = (New Usuarios)->find_by_sql("SELECT nombre, correo, telefono FROM usuarios ORDER BY RAND() LIMIT 0, 1");
    return $dato;
  }

  public function cambio_rbd($rbd)
  {
    $usuarios = (New Usuarios)->find_by_rbd($rbd);
    if(!empty($usuarios)){
      foreach ($usuarios as $key => $valor) {
        $valor->rbd = $rbd;
      }
    }
  }
}



?>
