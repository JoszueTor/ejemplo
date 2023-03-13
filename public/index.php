<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use Controllers\ProductoController;
use Controllers\ClientesController;
use MVC\Router;
use Controllers\AppController;
$router = new Router();
$router->setBaseURL('/ejemplo');

$router->get('/', [AppController::class,'index']);

$router->get('/productos', [ProductoController::class , 'index']);
$router->get('/clientes', [ClientesController::class , 'index']);
$router->post('/API/productos/guardar', [ProductoController::class, 'guardarAPI'] );
$router->get('/API/productos/buscar', [ProductoController::class, 'buscarAPI'] );
$router->post('/API/productos/modificar', [ProductoController::class, 'modificarAPI'] );
$router->post('/API/productos/eliminar', [ProductoController::class, 'eliminarAPI'] );





// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
