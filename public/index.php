<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use Controllers\ProductoController;
use Controllers\LoteController;
use MVC\Router;
use Controllers\AppController;

$router = new Router();
$router->setBaseURL('/ejemplo');

$router->get('/', [AppController::class, 'index']);

$router->get('/productos', [ProductoController::class, 'index']);
$router->post('/API/productos/guardar', [ProductoController::class, 'guardar']);
$router->get('/API/productos/buscar', [ProductoController::class, 'buscar']);
$router->post('/API/productos/modificar', [ProductoController::class, 'modificar']);
$router->post('/API/productos/eliminar', [ProductoController::class, 'eliminar']);

// lote

$router->get('/Lote', [LoteController::class, 'index']);

$router->post('/API/Lote/guardar', [LoteController::class, 'guardarAPI']);
$router->get('/API/Lote/buscar', [LoteController::class, 'buscar']);
$router->post('/API/Lote/modificar', [LoteController::class, 'modificar']);
$router->post('/API/Lote/eliminar', [LoteController::class, 'eliminar']);





// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();