<?php

namespace Model;

class Situaciones extends ActiveRecord
{


    protected static $tabla = 'municion_situacion'; //nombre de la tablaX
    protected static $columnasDB = ['ID', 'DESCRIPCION', 'SITUACION'];

    public $id;
    public $descripcion;

    public $situacion;




    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';

        $this->situacion = $args['situacion'] ?? '1';
    }


}