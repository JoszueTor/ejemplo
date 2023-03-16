<?php

namespace Model;

class Lote extends ActiveRecord
{


    protected static $tabla = 'municion_lote'; //nombre de la tablaX
    protected static $columnasDB = ['ID', 'DESCRIPCION', 'SITUACION'];

    public $id;
    public $descripcion;

    public $situacion;




    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '0';
        $this->descripcion = $args['descripcion'] ?? '';

        $this->situacion = $args['situacion'] ?? '1';
    }


}