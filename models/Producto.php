<?php

namespace Model;

class Producto extends ActiveRecord{

    protected static $tabla = 'docker_productos'; //nombre de la tablaX
    protected static $columnasDB = ['ID','NOMBRE','PRECIO','SITUACION'];

    public $id;
    public $nombre;
    public $precio;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}