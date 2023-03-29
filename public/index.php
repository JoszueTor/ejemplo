<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use Controllers\ProductoController;
use Controllers\almacenComandoController;
use Controllers\LoteController;
use Controllers\IngresoAlmacenController;
use Controllers\CalibreController;
use Controllers\SituacionesController;
use Controllers\IngresoFabController;
use Controllers\heladoController;
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
//IngresoFabrica
$router->get('/IngresoFab', [IngresoFabController::class, 'index']);
$router->post('/API/IngresoFab/guardar', [IngresoFabController::class, 'guardarAPI']);
$router->post('/API/IngresoFab/guardarTraslado', [IngresoFabController::class, 'guardarAPITraslado']);
$router->get('/API/IngresoFab/buscar', [IngresoFabController::class, 'buscarAPI']);
$router->get('/API/IngresoFab/buscaringreso', [IngresoFabController::class, 'buscaringreso']);
$router->get('/API/IngresoFab/buscarSalida', [IngresoFabController::class, 'buscarSalida']);
$router->get('/API/IngresoFab/historialFabrica', [IngresoFabController::class, 'historialFabrica']);
$router->post('/API/IngresoFab/GenerarSalida', [IngresoFabController::class, 'GenerarSalida1']);
$router->post('/API/IngresoFab/modificar', [IngresoFabController::class, 'modificarAPI']);
$router->post('/API/IngresoFab/eliminar', [IngresoFabController::class, 'eliminarAPI']);
$router->post('/API/IngresoFab/validarRegistro', [IngresoFabController::class, 'validarRegistro1']);
$router->post('/API/IngresoFab/trasladarMunicion', [IngresoFabController::class, 'trasladarMunicion1']);
//IngresoAlmacen
$router->get('/IngresoAlmacen', [IngresoAlmacenController::class, 'index']);
$router->post('/API/IngresoAlmacen/guardar', [IngresoAlmacenController::class, 'guardarAPI']);
$router->post('/API/IngresoAlmacen/guardarTraslado', [IngresoAlmacenController::class, 'guardarAPITraslado']);
$router->post('/API/IngresoAlmacen/guardarRegreso', [IngresoAlmacenController::class, 'guardarAPIregreso']);
$router->get('/API/IngresoAlmacen/buscar', [IngresoAlmacenController::class, 'buscarAPI']);
$router->get('/API/IngresoAlmacen/buscaringreso', [IngresoAlmacenController::class, 'buscaringreso']);
$router->get('/API/IngresoAlmacen/buscarSalida', [IngresoAlmacenController::class, 'buscarSalida']);
$router->get('/API/IngresoAlmacen/buscarRechazo', [IngresoAlmacenController::class, 'buscarRechazo']);
$router->get('/API/IngresoAlmacen/historialFabrica', [IngresoAlmacenController::class, 'historialFabrica']);
$router->post('/API/IngresoAlmacen/GenerarSalida', [IngresoAlmacenController::class, 'GenerarSalida1']);
$router->post('/API/IngresoAlmacen/GenerarRegreso', [IngresoAlmacenController::class, 'GenerarRegreso1']);
$router->post('/API/IngresoAlmacen/modificar', [IngresoAlmacenController::class, 'modificarAPI']);
$router->post('/API/IngresoAlmacen/eliminar', [IngresoAlmacenController::class, 'eliminarAPI']);
$router->post('/API/IngresoAlmacen/validarRegistro', [IngresoAlmacenController::class, 'validarRegistro1']);
$router->post('/API/IngresoAlmacen/trasladarMunicion', [IngresoAlmacenController::class, 'trasladarMunicion1']);
//almacenComando
$router->get('/almacenComando', [almacenComandoController::class, 'index']);
$router->post('/API/almacenComando/guardar', [almacenComandoController::class, 'guardarAPI']);
$router->post('/API/almacenComando/guardarTraslado', [almacenComandoController::class, 'guardarAPITraslado']);
$router->post('/API/almacenComando/guardarRegreso', [almacenComandoController::class, 'guardarAPIregreso']);
$router->get('/API/almacenComando/buscar', [almacenComandoController::class, 'buscarAPI']);
$router->get('/API/almacenComando/buscaringreso', [almacenComandoController::class, 'buscaringreso']);
$router->get('/API/almacenComando/buscaringresoAsignado', [almacenComandoController::class, 'buscaringresoAsignado']);
$router->get('/API/almacenComando/buscarSalida', [almacenComandoController::class, 'buscarSalida']);
$router->get('/API/almacenComando/buscarRechazo', [almacenComandoController::class, 'buscarRechazo']);
$router->get('/API/almacenComando/historialFabrica', [almacenComandoController::class, 'historialFabrica']);
$router->post('/API/almacenComando/GenerarSalida', [almacenComandoController::class, 'GenerarSalida1']);
$router->post('/API/almacenComando/GenerarRegreso', [almacenComandoController::class, 'GenerarRegreso1']);
$router->post('/API/almacenComando/modificar', [almacenComandoController::class, 'modificarAPI']);
$router->post('/API/almacenComando/eliminar', [almacenComandoController::class, 'eliminarAPI']);
$router->post('/API/almacenComando/validarRegistro', [almacenComandoController::class, 'validarRegistro1']);
$router->post('/API/almacenComando/trasladarMunicion', [almacenComandoController::class, 'trasladarMunicion1']);




























//helado
$router->get('/helado', [heladoController::class, 'index']);
$router->post('/API/helado/guardar', [heladoController::class, 'guardarAPI']);
$router->get('/API/helado/buscar', [heladoController::class, 'buscarAPI']);
$router->post('/API/helado/modificar', [heladoController::class, 'modificarAPI']);
$router->post('/API/helado/eliminar', [heladoController::class, 'eliminarAPI']);






// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();