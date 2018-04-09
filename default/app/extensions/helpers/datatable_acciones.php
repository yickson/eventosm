<?php

/**
 * Clase agregar botones a la tabla datatable
 * @category   Kumbia
 * @package    BtnAcciones
 */
class datatableAcciones
{

    public function __construct() {

    }
    /**
     * Visualiza sugerencia en base a lo escrito
     *
     * @param int $id id registro
     */
     public static function getBtnCarrito($alumno, $id)
     {
       $botones = "<button  data-alumno='$alumno' data-prod='$id' class='btn btn-danger eliminar' data-toggle='modal' data-target='#Buscar'>
                     Eliminar <i class='fa fa-trash'></i>
                   </button>";
         return $botones;
     }

    public static function getBtnHijos($usuario, $hijos){
	$btn = "<button data-id='".$usuario."' class='btn btn-info hijos'> <span class='badge'>$hijos</span></button>";
	return $btn;
    }
    public static function getBtnEstados($estado){
	$badge = null;
	switch($estado):
	    case 0:
		$badge = "<span class='label label-success' style='font-size:0.9em'>Disponible</span>";
	    break;
	    case 1:
		$badge = "<span class='label label-danger' style='font-size:0.9em'>Comprado</span>";
	    break;
	endswitch;
	return $badge;
    }

    public function getBtnUser($id)
    {
      $btn = "<button value='$id' class='btn btn-success editar'>
                     <i class='fa fa-edit'></i>
                   </button>";
      return $btn;
    }

    public static function getBtnProd($id)
    {
      $btn = "<button value='$id' class='btn btn-success editar'><i class='fa fa-edit'></i></button>";
      return $btn;
    }

    public static function getBtnAdm($id)
    {
      $btn = "<button value='$id' class='btn btn-success editar'><i class='fa fa-edit'></i></button>";
      return $btn;
    }

    public static function getBtnUsuario($id)
    {
      $btn = "<button value='$id' class='btn btn-danger eliminar'><i class='fa fa-trash'></i></button>";
      return $btn;
    }

    public static function getBtnCupos($uso)
     {
       $tope_uso = (New Configuracion)->find(1)->limite_colegio;
       switch($uso):
         case ($uso < 1):
           $color = "success";
         break;
         case ($uso >= 1 and $uso < 3):
           $color = "warning";
         break;
         case ($uso >= 3 and $uso <= 5):
           $color = "danger";
         break;
         default:
       endswitch;
       $botones = "<span  class='label label-$color'>" .$uso. "/" .$tope_uso. "</span>";
         return $botones;
     }

     public static function getBtnColegio($id)
     {
       $btn = "<button value='$id' class='btn btn-success editar'><i class='fa fa-edit'></i></button>
               <button value='$id' class='btn btn-danger eliminar'><i class='fa fa-trash'></i></button>";
       return $btn;
     }
}
