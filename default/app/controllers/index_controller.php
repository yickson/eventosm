<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class IndexController extends AppController
{

    function before_filter()
    {
      $asientos = (New Configuracion)->find(1)->cupos;
      Session::set('asientos', $asientos);
      View::template('eventosm');
    }

    public function index()
    {
      $this->programa = (New Programa)->find(1);
      $this->config = (New Configuracion)->find_by_sql("SELECT nombre, subtitulo, precio, cupos, fecha, date_format(hora_inicio, '%H:%i') as hora_inicio, date_format(hora_final, '%H:%i') as hora_final, lugar, latitud, longitud, objetivo FROM configuracion");
      $this->conf = (New Conferencistas)->find("order: nombre");

      //Funcionalidad de bloquear compra de más entradas
    }

    public function expositoras()
    {

    }

    public function sorteo()
    {
      //Vista con todos los nombres de los inscritos
      $this->usuarios = (New Usuarios)->find();
    }

    public function sorteo2()
    {
      //Vista con todos los nombres de los inscritos
      View::template('sorteosm');
      $this->usuarios = (New Usuarios)->find();
    }

    //Método Ajax para mejorar los flujos de interacción

    public function incribir_usuario()
    {
      View::select(null, 'json');
    }

    public function sorteo_usuario()
    {
      $dato = (New Usuarios)->sorteo();
      $this->data = $dato;
      View::select(null, 'json');
    }
}
