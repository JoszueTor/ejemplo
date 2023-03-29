<?php

namespace Model;

class helado extends ActiveRecord
{


    protected static $tabla = 'municion_helado'; //nombre de la tablaX
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