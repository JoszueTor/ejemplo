<?php

namespace Model;


class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['ID','CATALOGO','EMAIL','PASSWORD','TOKEN','NOMBRE','APELLIDO','CONFIRMADO'];

    public $id;
    public $catalogo;
    public $email;
    public $password;
    public $token;
    public $nombre;
    public $apellido;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->catalogo = $args['catalogo'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->confirmado = $args['confimado'] ?? '0';
    }

   

}