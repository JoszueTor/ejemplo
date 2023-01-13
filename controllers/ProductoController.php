<?php

namespace Controllers;
use Model\Producto;
use MVC\Router;

class ProductoController{
    public static function inicio(Router $router ){
        $productos = Producto::where('situacion', 1);
        $router->render('productos/index', [
            'productos' => $productos
        ]);
    }

    public static function productosAPI(){
        getHeadersApi();
        $id = $_GET['id'];
        $productos = Producto::find($id);

        echo json_encode($productos);
    }

}

