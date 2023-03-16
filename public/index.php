<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use Controllers\ProductoController;
use Controllers\LoteController;
use Controllers\CalibreController;
use Controllers\SituacionesController;
use MVC\Router;
use Controllers\AppController;

$router = new Router();
$router->setBaseURL('/ejemplo');

$router->get('/', [AppController::class, 'index']);

$router->get('/productos', [ProductoController::class, 'index']);
$router->post('/API/productos/guardar', [ProductoController::class, 'guardarAPI']);
$router->get('/API/productos/buscar', [ProductoController::class, 'buscarAPI']);
$router->post('/API/productos/modificar', [ProductoController::class, 'modificarAPI']);
$router->post('/API/productos/eliminar', [ProductoController::class, 'eliminarAPI']);

// lote

$router->get('/Lote', [LoteController::class, 'index']);
$router->post('/API/Lote/guardar', [LoteController::class, 'guardarAPI']);
$router->get('/API/Lote/buscar', [LoteController::class, 'buscarAPI']);
$router->post('/API/Lote/modificar', [LoteController::class, 'modificarAPI']);
$router->post('/API/Lote/eliminar', [LoteController::class, 'eliminarAPI']);


//calibre
$router->get('/Calibre', [CalibreController::class, 'index']);
$router->post('/API/Calibre/guardar', [CalibreController::class, 'guardarAPI']);
$router->get('/API/Calibre/buscar', [CalibreController::class, 'buscarAPI']);
$router->post('/API/Calibre/modificar', [CalibreController::class, 'modificarAPI']);
$router->post('/API/Calibre/eliminar', [CalibreController::class, 'eliminarAPI']);


//Situaciones
$router->get('/Situaciones', [SituacionesController::class, 'index']);
$router->post('/API/Situaciones/guardar', [SituacionesController::class, 'guardarAPI']);
$router->get('/API/Situaciones/buscar', [SituacionesController::class, 'buscarAPI']);
$router->post('/API/Situaciones/modificar', [SituacionesController::class, 'modificarAPI']);
$router->post('/API/Situaciones/eliminar', [SituacionesController::class, 'eliminarAPI']);





// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();