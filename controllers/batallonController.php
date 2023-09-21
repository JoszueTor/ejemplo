<?php



namespace Controllers;

use Model\batallon;
use MVC\Router;
use Exception;

class batallonController
{

    public function index(Router $router)
    {
        // $usuario = 606871;
        $lote = batallon::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = batallon::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = batallon::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");


        // $usuario = 606871;
        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = user");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
            // var_dump($org_dep);
        }

        $deptop = batallon::fetchArray("SELECT org_plaza, org_jerarquia[1], org_plaza_desc, org_dependencia  FROM morg  WHERE org_dependencia = $org_dep and org_ceom = 'TITULO' AND org_jerarquia[2,10]= '000000000' AND org_situacion = 'A' and org_jerarquia[1] not in (0)");

        $compañia = batallon::fetchArray("SELECT * FROM municion_organizacion WHERE id_dependencia = $org_dep and jerarquia between 110 and 115 and situacion = 1");


        $router->render('batallon/index', [

            'lote' => $lote,
            'calibre' => $calibre,
            'movimiento' => $movimiento,
            'deptop' => $deptop,
            'dependencia' => $dependencia,
            'org_dep' => $org_dep,
            'compañia' => $compañia,
        ]);


    }

    public function guardarAPI()
    {
        getHeadersApi();

        try {
            date_default_timezone_set('America/Guatemala');

            $fechaActual = date('Y-m-d h:m');

            //$ingreso = new batallon($_POST);

            $ingreso = new batallon([
                'id' => null,
                'lote' => $_POST['lote'],
                'calibre' => $_POST['calibre'],
                'cantidad' => $_POST['cantidad'],
                'motivo' => $_POST['motivo'],
                'documento' => $_POST['documento'],
                'observaciones' => $_POST['observaciones'],
                'movimiento' => '1',
                'fecha' => $fechaActual,
                'departamento' => '250'

            ]);

            // echo json_encode($ingreso);
            // exit;

            $resultado = $ingreso->guardar();

            $historial = new batallon([
                'id' => null,
                'lote' => $_POST['lote'],
                'calibre' => $_POST['calibre'],
                'cantidad' => $_POST['cantidad'],
                'motivo' => $_POST['motivo'],
                'documento' => $_POST['documento'],
                'observaciones' => $_POST['observaciones'],
                'movimiento' => '1',
                'fecha' => $fechaActual,
                'departamento' => '250',
                'situacion' => '5'

            ]);

            $resultado = $historial->guardar();


            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    "resultado" => 1
                ]);

            } else {
                echo json_encode([
                    "resultado" => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }
    public function guardarTraslado()
    {
        getHeadersApi();

        date_default_timezone_set('America/Guatemala');
        $fechaActual = date('Y-m-d h:m');

        $id = $_POST['id1'];
        $lote = $_POST['idlote1'];
        $calibre = $_POST['idcalibre1'];
        $cantidad = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $total = $cantidad - $cantidad2;
        $motivo = $_POST['idmotivo1'];
        $documento = $_POST['documento1'];
        $observaciones = $_POST['observaciones1'];
        $batallon = $_POST['batallon'];
        $fecha = $fechaActual;
        $idcomando = $_POST['departamento1'];
        $catalogo = $_POST['catalogo1'];
        $catalogotraslado = $_POST['catalogoTraslado'];

        // echo json_encode($_POST);
        //     exit;

        if ($total > 0) {

            try {

                $insertHistorial = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 1, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");

                $insertMovimiento = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 2, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total where id = $id");

                $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 4, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $asignadoHistorial = "INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 4, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)";

                // echo json_encode($asignadoHistorial);
                // exit;

                $resultado = batallon::sql($asignadoHistorial);

                if ($resultado == 1) {
                    echo json_encode([
                        "resultado" => 1
                    ]);

                } else {
                    echo json_encode([
                        "resultado" => 0
                    ]);
                }

            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "Ocurrió  un error en base de datos.",

                    "codigo" => 4,
                ]);
            }
        }

        if ($total == 0) {

            try {

                $insertHistorial = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 1, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");

                $insertMovimiento = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 2, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $cantidad2, movimiento = 4, situacion = 5 where id = $id");

                $asignadoBatallon = "INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 4, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)";


                $resultado1234 = batallon::sql($asignadoBatallon);
                //  echo json_encode($resultado1234);
//         exit;

                // echo json_encode($resultado);
                // exit;


                if ($resultado1234 == 1) {
                    echo json_encode([
                        "resultado" => 1
                    ]);

                } else {
                    echo json_encode([
                        "resultado" => 0
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "Ocurrió  un error en base de datos.",
                    "codigo" => 4,
                ]);
            }
        }
    }
    public function guardarTrasladoRegreso()
    {
        getHeadersApi();

        date_default_timezone_set('America/Guatemala');
        $fechaActual = date('Y-m-d h:m');

        $id = $_POST['id1'];
        $lote = $_POST['idlote1'];
        $calibre = $_POST['idcalibre1'];
        $cantidad = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $total = $cantidad - $cantidad2;
        $motivo = $_POST['idmotivo1'];
        $documento = $_POST['documento1'];
        $observaciones = $_POST['observaciones1'];
        $batallon = $_POST['batallonSalida'];
        $fecha = $fechaActual;
        $idcomando = $_POST['departamento1'];
        $catalogo = $_POST['catalogo1'];
        $catalogotraslado = $_POST['catalogoTraslado'];

        // echo json_encode($_POST);
        // exit;
        $busqueda = "SELECT * from municion_batallon where departamento = $idcomando and batallon = $batallon and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1";
        $resultado = batallon::fetchArray($busqueda);



        // echo json_encode($resultado);
        //         exit;

        foreach ($resultado as $key => $value) {

            $cantidadBuscada = $value['cantidad'];

        }
        $cantidadTotal = $cantidadBuscada + $cantidad2;

        if ($resultado != '') {

            // echo json_encode($cantidadTotal);
            //     exit;

            if ($total > 0) {

                try {

                    // $sql = "UPDATE municion_batallon set cantidad = $cantidadTotal where departamento = $idcomando and batallon = $batallon and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1";

                    // echo json_encode($sql);
                    // exit;
                    // AQUI
                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total where id = $id");

                    $insertMovimiento = batallon::sql("UPDATE municion_batallon set cantidad = $cantidadTotal where departamento = $idcomando and batallon = $batallon and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1");

                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                    $asignadoHistorial = "INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)";


                    $resultado = batallon::sql($asignadoHistorial);

                    // echo json_encode($resultado);
                    // exit;

                    if ($resultado == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }

                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",

                        "codigo" => 4,
                    ]);
                }
            }

            if ($total == 0) {

                try {

                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total, movimiento = 5, batallon = $batallon, situacion =5 where id = $id");


                    $insertMovimiento = batallon::sql("UPDATE municion_batallon set cantidad = $cantidadTotal where departamento = $idcomando and batallon = $batallon and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1");

                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                    // echo json_encode($insertMovimiento);
                    // exit;

                    if ($insertMovimiento == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }
                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",
                        "codigo" => 4,
                    ]);
                }
            }
        } else {

            if ($total > 0) {

                try {
                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total where id = $id");

                    $insertMovimiento = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 2, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");


                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                    $asignadoHistorial = "INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)";

                    // echo json_encode($asignadoHistorial);
                    // exit;

                    $resultado = batallon::sql($asignadoHistorial);

                    if ($resultado == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }

                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",

                        "codigo" => 4,
                    ]);
                }
            }

            if ($total == 0) {

                try {

                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total, movimiento = 5, batallon = $batallon, situacion =5 where id = $id");

                    $insertHistorial = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                    $insertMovimiento = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");


                    $asignadoBatallon = "INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)";


                    $resultado1234 = batallon::sql($asignadoBatallon);
                    //  echo json_encode($resultado1234);
                    //         exit;

                    // echo json_encode($resultado1234);
                    // exit;


                    if ($resultado1234 == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }
                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",
                        "codigo" => 4,
                    ]);
                }
            }
        }

    }
    public function guardarTrasladoRegresoComando()
    {
        getHeadersApi();

        date_default_timezone_set('America/Guatemala');
        $fechaActual = date('Y-m-d h:m');

        $id = $_POST['id1'];
        $lote = $_POST['idlote1'];
        $calibre = $_POST['idcalibre1'];
        $cantidad = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $total = $cantidad - $cantidad2;
        $motivo = $_POST['idmotivo1'];
        $documento = $_POST['documento1'];
        $observaciones = $_POST['observaciones1'];
        $batallon = $_POST['batallonSalidaComando'];
        $fecha = $fechaActual;
        $idcomando = $_POST['departamento1'];
        $catalogo = $_POST['catalogo1'];
        $catalogotraslado = $_POST['catalogoTraslado'];

        // echo json_encode($_POST);
        // exit;
        $busqueda = "SELECT * from municion_almacencomando where departamento = $idcomando and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1";
        $resultado = batallon::fetchArray($busqueda);




        foreach ($resultado as $key => $value) {

            $cantidadBuscada = $value['cantidad'];

        }
        // echo json_encode($cantidadBuscada);
        //         exit;
        $cantidadTotal = $cantidadBuscada + $cantidad2;

        if ($resultado != '') {

            // echo json_encode($cantidadTotal);
            //     exit;

            if ($total > 0) {

                try {

                    // $sql = "UPDATE municion_batallon set cantidad = $cantidadTotal where departamento = $idcomando and batallon = $batallon and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1";

                    // echo json_encode($sql);
                    // exit;
                    // AQUI
                    $actualizarComando = batallon::sql("UPDATE municion_almacencomando set cantidad = $cantidadTotal where  departamento = $idcomando and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1");

                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total where id = $id");

                    // $insertMovimiento = batallon::sql("UPDATE municion_batallon set cantidad = $cantidadTotal where departamento = $idcomando and batallon = $batallon and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1");

                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 3, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                    $asignadoHistorial = "INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)";

                    $asignadoHistorialComando = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    $asignadoHistorialEntrada = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");


                    $resultado = batallon::sql($asignadoHistorial);

                    // echo json_encode($resultado);
                    // exit;

                    if ($resultado == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }

                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",

                        "codigo" => 4,
                    ]);
                }
            }

            if ($total == 0) {

                try {

                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total, movimiento = 5, batallon = $batallon, situacion =5 where id = $id");
                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 3, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");
                    $asignadoBatallonHistorial = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");


                    $asignadoHistorialComando = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    $asignadoHistorialEntrada = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    $actualizarComando = batallon::sql("UPDATE municion_almacencomando set cantidad = $cantidadTotal where  departamento = $idcomando and calibre = $calibre and lote = $lote and motivo = $motivo and movimiento = 2 and situacion = 1");
                    // echo json_encode($insertMovimiento);

                    // exit;

                    if ($asignadoBatallon == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }
                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",
                        "codigo" => 4,
                    ]);
                }
            }
        } else {

            if ($total > 0) {

                try {
                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total where id = $id");

                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 3, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                    $asignadoHistorial = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");

                    
                    $asignadoHistorialComando = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    
                    $asignadoHistorialEntrada = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    
                    $asignadoHistorialEntradaComando = "INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $catalogo, $catalogotraslado, 1)";

                    // echo json_encode($asignadoHistorial);
                    // exit;

                    $resultado = batallon::sql($asignadoHistorialEntradaComando);

                    if ($resultado == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }

                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",

                        "codigo" => 4,
                    ]);
                }
            }

            if ($total == 0) {

                try {

                    $resultadoAlmacen = batallon::sql("UPDATE municion_batallon set cantidad = $total, movimiento = 5, batallon = $batallon, situacion =5 where id = $id");
                    $asignadoBatallon = batallon::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',     '$observaciones', 3, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");
                    $asignadoHistorialComando = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 5, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    $asignadoHistorialEntrada = batallon::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)");
                    $asignadoHistorialEntradaComando = "INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 2, '$fecha', $idcomando, $catalogo, $catalogotraslado, 1)";


                    $resultado1234 = batallon::sql($asignadoHistorialEntradaComando);
                   

                    // echo json_encode($resultado1234);
                    // exit;


                    if ($resultado1234 == 1) {
                        echo json_encode([
                            "resultado" => 1
                        ]);

                    } else {
                        echo json_encode([
                            "resultado" => 0
                        ]);
                    }
                } catch (Exception $e) {
                    echo json_encode([
                        "detalle" => $e->getMessage(),
                        "mensaje" => "Ocurrió  un error en base de datos.",
                        "codigo" => 4,
                    ]);
                }
            }
        }

    }

    public function guardarAPIregreso()
    {
        getHeadersApi();

        date_default_timezone_set('America/Guatemala');

        $fechaActual = date('Y-m-d h:m');


        $id = $_POST['id1'];
        $cantidad1 = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $deptonew = $_POST['Deptop'];
        $total = $cantidad1 - $cantidad2;


        // $usuario = 606871;
        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        //   echo json_encode($_POST);
        // exit;


        if ($total > 0) {

            try {


                $resultado = batallon::sql("UPDATE municion_batallon set cantidad = $total where id = $id");

                $salida = new batallon([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '4',
                    'fecha' => $fechaActual,
                    'departamento' => $org_dep

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $salida->guardar();


                $historial = new batallon([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '4',
                    'fecha' => $fechaActual,
                    'departamento' => '250',
                    'situacion' => '5'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $historial->guardar();

                if ($resultado['resultado'] == 1) {
                    echo json_encode([
                        "resultado" => 1
                    ]);

                } else {
                    echo json_encode([
                        "resultado" => 0
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "Ocurrió  un error en base de datos.",

                    "codigo" => 4,
                ]);
            }




        }

        if ($total == 0) {

            try {

                $actualiza = new batallon([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '4',
                    'fecha' => $fechaActual,
                    'departamento' => '250'


                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $actualiza->guardar();



                $salida = new batallon([
                    'id' => $_POST['id1'],
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $total,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '4',
                    'fecha' => $fechaActual,
                    'departamento' => '250',
                    'situacion' => '5'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $salida->guardar();

                if ($resultado['resultado'] == 1) {
                    echo json_encode([
                        "resultado" => 1
                    ]);

                } else {
                    echo json_encode([
                        "resultado" => 0
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "Ocurrió  un error en base de datos.",

                    "codigo" => 4,
                ]);
            }




        }






    }

    public function buscarAPI()
    {
        getHeadersApi();



        try {

            // $usuario = 606871;

            $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }

            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASIGNADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, 
                    municion_batallon.batallon as idbatallon,
                    trim(morgani.nombre) as batallon, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            

                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento=$org_dep
                and municion_batallon.batallon between 10 and 15
                and morgani.id_dependencia = $org_dep
                and municion_batallon.movimiento=2
                and municion_batallon.situacion=1
                order by municion_batallon.fecha desc"
            );

            echo json_encode($batallons);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public function CompaniaTabla()
    {
        getHeadersApi();


        try {

            // $usuario = 606871;

            $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }

            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASIGNADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, municion_batallon.departamento as iddepartamento,
                    municion_batallon.batallon as idbatallon,
                    
                trim(morgani.nombre) as batallon,
                trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            


                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento=$org_dep
                and morgani.id_dependencia = $org_dep
                and municion_batallon.batallon between 110 and 150
                and municion_batallon.movimiento=2
                and municion_batallon.situacion=1
                order by municion_batallon.fecha desc"
            );

            echo json_encode($batallons);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public function PelotonTabla()
    {
        getHeadersApi();


        try {

            // $usuario = 606871;

            $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }

            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASIGNADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, municion_batallon.departamento as iddepartamento,
                    municion_batallon.batallon as idbatallon,
                    
                trim(morgani.nombre) as batallon,
                trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            


                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento=$org_dep
                and morgani.id_dependencia = $org_dep
                and municion_batallon.batallon between 1110 and 1500
                and municion_batallon.movimiento=2
                and municion_batallon.situacion=1
                order by municion_batallon.fecha desc"
            );

            echo json_encode($batallons);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }




    public function buscaringreso()
    {
        getHeadersApi();

        // $usuario = 606871;

        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {


            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones,
                (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(morgani.nombre) as batallon, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            
                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento = $org_dep
                and morgani.id_dependencia = $org_dep
                and municion_batallon.movimiento = 1
                and municion_batallon.situacion = 1"
            );

            echo json_encode($batallons);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public static function buscaringresoAsignado()
    {
        getHeadersApi();

        // $usuario = 606871;

        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");

        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }



        try {
            $query = "SELECT municion_asentamientobat.id as id,
            municion_lote.descripcion as lote, 
            municion_calibre.descripcion as calibre, 
            cantidad, 
           municion_situacion.descripcion as motivo,
            documento,
             observaciones,
              movimiento, 
              fecha, 
              mdep.dep_desc_md as departamento,
              morg.org_plaza_desc as batallon,
              (CASE municion_asentamientobat.cuatrimestre
                        WHEN 1 THEN 'PRIMER CUATRIMESTRE'
                        WHEN 2 THEN 'SEGUNDO CUATRIMESTRE'
                        WHEN 3 THEN 'TERCER CUATRIMESTRE'
                        END
                    ) as cuatrimestre 
           from municion_asentamientobat, municion_lote, municion_calibre, municion_situacion, mdep, morg 
           where municion_asentamientobat.lote=municion_lote.id
           and municion_asentamientobat.calibre=municion_calibre.id
           and municion_asentamientobat.motivo=municion_situacion.id
           and municion_asentamientobat.departamento=mdep.dep_llave
           and municion_asentamientobat.batallon=morg.org_plaza
           and municion_asentamientobat.departamento=$org_dep
           and morgani.id_dependencia = $org_dep
           and municion_asentamientobat.movimiento=4
           and municion_asentamientobat.situacion=7
           order by municion_asentamientobat.fecha desc";
            $batallons = batallon::fetchArray($query);




            echo json_encode($batallons);


        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }



    }
    public function buscarSalida()
    {
        getHeadersApi();

        // $usuario = 606871;

        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {
            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones,
                (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento,  trim(morgani.nombre) as batallon,  trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            
                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento=$org_dep
                and morgani.id_dependencia = $org_dep
                and municion_batallon.movimiento = 3
                and municion_batallon.situacion=1
                order by municion_batallon.fecha desc"
            );
            echo json_encode($batallons);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }



    public function buscarRechazo()
    {
        getHeadersApi();



        try {
            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_batallon, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.movimiento=4
                and municion_batallon.situacion=1"
            );
            echo json_encode($batallons);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public function historialFabrica()
    {
        getHeadersApi();

        // $usuario = 606871;

        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {
            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        WHEN 5 THEN 'DEVUELTO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(morgani.nombre) as batallon, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            


                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia,
                
                 municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento=$org_dep
                and morgani.id_dependencia = $org_dep
                and municion_batallon.situacion=5
                order by municion_batallon.fecha desc"
            );
            echo json_encode($batallons);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public function buscarSinoptico()
    {
        getHeadersApi();

        // $usuario = 606871;

        $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {
            $batallons = batallon::fetchArray(
                "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_batallon.movimiento
                        WHEN 1 THEN 'ENTRADA BATALLON'
                        WHEN 2 THEN 'INGRESO BATALLON'
                        WHEN 3 THEN 'SALIDA BATALLON'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, 
                    municion_batallon.batallon as idbatallon,
                    trim(morgani.nombre) as batallon, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida
            


                from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia,
                
                 municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_batallon.lote=municion_lote.id
                and municion_batallon.calibre=municion_calibre.id
                and municion_batallon.motivo=municion_situacion.id
                and municion_batallon.departamento=mdep.dep_llave
                and municion_batallon.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_batallon.departamento=$org_dep
                and morgani.id_dependencia = $org_dep
                and municion_batallon.movimiento=4
                and municion_batallon.situacion=1
                "
            );
            echo json_encode($batallons);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }


    public function modificarAPI()
    {
        getHeadersApi();
        $batallon = new batallon($_POST);

        $resultado = $batallon->guardar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                "resultado" => 1
            ]);

        } else {
            echo json_encode([
                "resultado" => 0
            ]);

        }
    }

    public function eliminarAPI()
    {
        getHeadersApi();

        try {
            $batallon = batallon::find($_POST['id']);
            $batallon->situacion = 0;
            $resultado = $batallon->guardar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    "resultado" => 1
                ]);

            } else {
                echo json_encode([
                    "resultado" => 0
                ]);


            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

            ]);
        }
    }





    public function validarRegistro1()
    {
        getHeadersApi();

        $id = $_POST['id'];




        $batallon = batallon::find($id);

        $batallon->movimiento = 2;
        // $batallon->situacion = 5;

        $resultado = $batallon->guardar();




        if ($resultado['resultado'] == 1) {
            echo json_encode([
                "resultado" => 1
            ]);

        } else {
            echo json_encode([
                "resultado" => 0
            ]);

        }
    }
    public function trasladarMunicion3()
    {
        getHeadersApi();


        $batallon = batallon::find($_POST['id']);
        $batallon->movimiento = 3;
        $resultado = $batallon->guardar();


        if ($resultado['resultado'] == 1) {
            echo json_encode([
                "resultado" => 1
            ]);

        } else {
            echo json_encode([
                "resultado" => 0
            ]);

        }
    }

    public function GenerarSalida1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {


            // $usuario = 606871;

            $dependencias = batallon::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }


            $id = $_POST['id'];

            $sql = "SELECT municion_batallon.id as id, municion_batallon.lote as  idlote, municion_lote.descripcion as lote, municion_batallon.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_batallon.motivo as idmotivo, municion_situacion.descripcion as motivo, documento, observaciones, departamento, batallon, catalogosalida
            from municion_batallon, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_batallon.lote=municion_lote.id
            and municion_batallon.calibre=municion_calibre.id
            and municion_batallon.motivo=municion_situacion.id
            and municion_batallon.departamento=mdep.dep_llave
            and municion_batallon.departamento=$org_dep
            and municion_batallon.movimiento=2
            and municion_batallon.situacion=1
            and municion_batallon.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = batallon::fetchArray($sql);
            $data = [];
            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $idlote = $key['idlote'];
                $lote = $key['lote'];
                $idcalibre = $key['idcalibre'];
                $calibre = $key['calibre'];
                $cantidad = $key['cantidad'];
                $idmotivo = $key['idmotivo'];
                $motivo = $key['motivo'];
                $documento = trim($key['documento']);
                $observaciones = trim($key['observaciones']);
                $departamento = $key['departamento'];
                $batallon = trim($key['batallon']);
                $catalogo = trim($key['catalogosalida']);



                $arrayInterno = [
                    [
                        "contador" => $i,
                        "id" => $id,
                        "idlote" => $idlote,
                        "lote" => $lote,
                        "idcalibre" => $idcalibre,
                        "calibre" => $calibre,
                        "cantidad" => $cantidad,
                        "idmotivo" => $idmotivo,
                        "motivo" => $motivo,
                        "documento" => $documento,
                        "observaciones" => $observaciones,
                        "departamento" => $departamento,
                        "batallon" => $batallon,
                        "catalogo" => $catalogo,


                    ]
                ];
                $i++;
                $data = array_merge($data, $arrayInterno);
            }

            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }
    public function buscarCompania1()
    {
        // hasPermissionApi(['RRMM_COMANDANCI','RRMM_ADMIN','RRMM_DEP_MIL']);

        // echo json_encode($_GET);
        // exit;
        $batallon = $_GET['batallon1'];
        $comando1 = $_GET['comando1'];
        $batallon1 = $batallon . '0';
        $batallon2 = $batallon . '5';

        $sql = "SELECT * FROM municion_organizacion WHERE id_dependencia = $comando1 and jerarquia between $batallon1 and $batallon2 and situacion = 1";
        $compañia = batallon::fetchArray($sql);

        echo json_encode($compañia);
        // exit;
    }
    public static function buscarCompaniaSalida()
    {
        // hasPermissionApi(['RRMM_COMANDANCI','RRMM_ADMIN','RRMM_DEP_MIL']);
        // echo json_encode($_GET);
        // exit;
        $batallon = $_GET['batallon1'];
        $comando1 = $_GET['comando1'];

        $batallonSindigito = floor($batallon / 10);


        $batallon1 = $batallonSindigito . '0';
        $batallon2 = $batallonSindigito . '5';

        $sql = "SELECT * FROM municion_organizacion WHERE id_dependencia = $comando1 and jerarquia =$batallonSindigito and situacion = 1";
        // echo json_encode($sql);
        // exit;
        $compañia = batallon::fetchArray($sql);
        echo json_encode($compañia);
    }
    public static function catalogo()
    {
        // hasPermissionApi(['RRMM_COMANDANCI','RRMM_ADMIN','RRMM_DEP_MIL']);

        $catalogo = $_GET['catalogo'];




        $informacion = batallon::fetchArray("SELECT trim(gra_desc_ct) as grado, trim(per_nom1) || ' ' || trim(per_nom2) || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) as nombre, ape_id, ape_dep,ape_catalogo  FROM mper inner join grados on per_grado = gra_codigo left join res_asig_per on ape_catalogo = per_catalogo where per_catalogo = $catalogo");

        echo json_encode($informacion);
    }
    public function GenerarRegreso1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = " SELECT municion_batallon.id as id, municion_batallon.lote as  idlote, municion_lote.descripcion as lote, municion_batallon.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_batallon.motivo as idmotivo, municion_situacion.descripcion as motivo
            from municion_batallon, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_batallon.lote=municion_lote.id
            and municion_batallon.calibre=municion_calibre.id
            and municion_batallon.motivo=municion_situacion.id
            and municion_batallon.departamento=mdep.dep_llave
            and municion_batallon.movimiento=2
            and municion_batallon.situacion=2
            and municion_batallon.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = batallon::fetchArray($sql);
            $data = [];
            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $idlote = $key['idlote'];
                $lote = $key['lote'];
                $idcalibre = $key['idcalibre'];
                $calibre = $key['calibre'];
                $cantidad = $key['cantidad'];
                $idmotivo = $key['idmotivo'];
                $motivo = $key['motivo'];



                $arrayInterno = [
                    [
                        "contador" => $i,
                        "id" => $id,
                        "idlote" => $idlote,
                        "lote" => $lote,
                        "idcalibre" => $idcalibre,
                        "calibre" => $calibre,
                        "cantidad" => $cantidad,
                        "idmotivo" => $idmotivo,
                        "motivo" => $motivo,
                    ]
                ];
                $i++;
                $data = array_merge($data, $arrayInterno);
            }

            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "ocurrio un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }


}