<?php



namespace Controllers;

use Model\IngresoAlmacen;
use MVC\Router;
use Exception;

class IngresoAlmacenController
{
    public static function index(Router $router)
    {
        $lote = IngresoAlmacen::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = IngresoAlmacen::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = IngresoAlmacen::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");
        $deptop = IngresoAlmacen::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");
        $comando = IngresoAlmacen::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");
        $TrasladoCom = IngresoAlmacen::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");

        // echo var_dump($comando);



        $router->render('IngresoAlmacen/index', [

            'lote' => $lote,
            'calibre' => $calibre,
            'movimiento' => $movimiento,
            'deptop' => $deptop,
            'comando' => $comando,
            'TrasladoCom' => $TrasladoCom,
        ]);


    }

    public static function guardarAPI()
    {
        getHeadersApi();





        try {
            date_default_timezone_set('America/Guatemala');

            $fechaActual = date('Y-m-d h:m');
            ;
            //$ingreso = new IngresoAlmacen($_POST);

            $ingreso = new IngresoAlmacen([
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
                'catalogo' => $_POST['catalogo'],
                'catalogosalida' => '0',
                'situacion' => '1'

            ]);

            // echo json_encode($ingreso);
            // exit;

            $resultado = $ingreso->guardar();

            $historial = new IngresoAlmacen([
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
                'catalogo' => $_POST['catalogo'],
                'catalogosalida' => '0',
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
    public static function guardarAPITraslado()
    {
        getHeadersApi();

        date_default_timezone_set('America/Guatemala');
        $fechaActual = date('Y-m-d h:m');
        $id = $_POST['id1'];
        $cantidad1 = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $deptonew = $_POST['Deptop'];
        $total = $cantidad1 - $cantidad2;
        $lote = $_POST['idlote1'];
        $calibre = $_POST['idcalibre1'];
        $cantidad = $cantidad2;
        $motivo = $_POST['idmotivo1'];
        $documento = $_POST['documento1'];
        $observaciones = $_POST['observaciones1'];
        $catalogo = $_POST['catalogo1'];
        $catalogosalida = $_POST['catalogoTraslado'];
        $movimiento = '1';
        $fecha = $fechaActual;
        $departamento = '2260';
        $situacion = '1';


        // aqui me quede
        // echo json_encode($_POST);
        // exit;




        if ($total == 0) {

            // BUSCAR SALIDA

            try {

                $SalidaSMG = IngresoAlmacen::sql("UPDATE municion_ingresoalmacen set movimiento = 3, departamento = $deptonew, catalogo = $catalogo, catalogosalida= $catalogosalida where id = $id");

                $HistorialSalidaSMG = IngresoAlmacen::sql("INSERT INTO municion_ingresoalmacen VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew,  $catalogo, $catalogosalida, 5)");

                $HistorialSalidaSMG = IngresoAlmacen::sql("INSERT INTO municion_ingresoalmacen VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew,  $catalogo, $catalogosalida, 1)");

                $InsertAlmacenComando = IngresoAlmacen::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 1, '$fecha', $deptonew,  $catalogo, $catalogosalida, 5)");

                $HistorialAlmacenComando = "INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 1, '$fecha', $deptonew,  $catalogo, $catalogosalida, 1)";


                $resultado1234 = IngresoAlmacen::sql($HistorialAlmacenComando);
                //  echo json_encode($resultado1234);
//         exit;

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

        if ($total > 0) {

            try {


                $actualizoAlmacenActual = IngresoAlmacen::sql("UPDATE municion_ingresoalmacen set cantidad = $total where id = $id");

                $SalidaAlmacenActual = IngresoAlmacen::sql("INSERT INTO municion_ingresoalmacen VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew,  $catalogo, $catalogosalida, 5)");

                $SalidaAlmacenActual1 = IngresoAlmacen::sql("INSERT INTO municion_ingresoalmacen VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew,  $catalogo, $catalogosalida, 1)");

                $InsertAlmacenComando1 = IngresoAlmacen::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 1, '$fecha', $deptonew,  $catalogo, $catalogosalida, 5)");

                $HistorialAlmacenComando = "INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 1, '$fecha', $deptonew,  $catalogo, $catalogosalida, 1)";


                $resultado1234 = IngresoAlmacen::sql($HistorialAlmacenComando);


                // echo json_encode($ingreso);
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
    public static function guardarAPIregreso()
    {
        getHeadersApi();

        date_default_timezone_set('America/Guatemala');

        $fechaActual = date('Y-m-d h:m');

        // echo json_encode($_POST);
        // exit;


        $id = $_POST['id1'];
        $cantidad1 = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];

        $lote = $_POST['idlote1'];
        $calibre = $_POST['idcalibre1'];
        $motivo = $_POST['idmotivo1'];
        $documento = $_POST['documento1'];
        $observaciones = $_POST['observaciones1'];
        $movimientoSalida = '7';
        $fecha = $fechaActual;
        $deptonew = $_POST['Deptop'];
        $SMG = 1460;
        $total = $cantidad1 - $cantidad2;
        $situacionSalida = '1';

        echo json_encode($fecha);
        exit;

        //    

        if ($total > 0) {

            try {


                $sql = "INSERT INTO municion_ingresofab VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', $movimientoSalida, '$fecha', $SMG, $situacionSalida";

                $resultado = IngresoAlmacen::sql($sql);


                //   

                // $resultado = IngresoAlmacen::sql("UPDATE municion_ingresoalmacen set cantidad = $total where id = $id");



                // $salida1 = new IngresoAlmacen([
                //     'id' => null,
                //     'lote' => $_POST['idlote1'],
                //     'calibre' => $_POST['idcalibre1'],
                //     'cantidad' => $cantidad2,
                //     'motivo' => $_POST['idmotivo1'],
                //     'documento' => $_POST['documento1'],
                //     'observaciones' => $_POST['observaciones1'],
                //     'movimiento' => '7',
                //     'fecha' => $fechaActual,
                //     'departamento' => '250',
                //     'situacion' => '5'

                // ]);
                // echo json_encode($resultado);
                // exit;

                // $resultado = $salida1->guardar();

                // $registrosalida = new IngresoAlmacen([
                //     'id' => null,
                //     'lote' => $_POST['idlote1'],
                //     'calibre' => $_POST['idcalibre1'],
                //     'cantidad' => $cantidad2,
                //     'motivo' => $_POST['idmotivo1'],
                //     'documento' => $_POST['documento1'],
                //     'observaciones' => $_POST['observaciones1'],
                //     'movimiento' => '3',
                //     'fecha' => $fechaActual,
                //     'departamento' => '250'

                // ]);
                //     echo json_encode($ingreso);
                // exit;

                // $resultado = $registrosalida->guardar();


                // $historial = new IngresoAlmacen([
                //     'id' => null,
                //     'lote' => $_POST['idlote1'],
                //     'calibre' => $_POST['idcalibre1'],
                //     'cantidad' => $cantidad2,
                //     'motivo' => $_POST['idmotivo1'],
                //     'documento' => $_POST['documento1'],
                //     'observaciones' => $_POST['observaciones1'],
                //     'movimiento' => '4',
                //     'fecha' => $fechaActual,
                //     'departamento' => '250',
                //     'situacion' => '5'

                // ]);
                //     echo json_encode($ingreso);
                // exit;

                // $resultado = $historial->guardar();

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

                $actualiza = new IngresoAlmacen([
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

                $registrosalida = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => '250'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $registrosalida->guardar();

                $salida = new IngresoAlmacen([
                    'id' => $_POST['id1'],
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

    public static function buscarAPI()
    {
        getHeadersApi();



        try {
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo, 
                documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'SIN ASIGNAR' )as catalogosalida
            


                from municion_ingresoalmacen left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_ingresoalmacen.movimiento=2
                and municion_ingresoalmacen.situacion=1
                 order by municion_ingresoalmacen.fecha desc"

            );
            echo json_encode($IngresoAlmacens);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public static function comando()
    {
        getHeadersApi();

        $valor = $_GET['valor'];

        // echo json_encode($valor);
        // exit;


        if ($valor == 2090) {

            try {

                $sql = "SELECT municion_ingresofab.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo, 
                documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), '' )as catalogosalida
            


                from municion_ingresofab left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_ingresofab.lote=municion_lote.id
                and municion_ingresofab.calibre=municion_calibre.id
                and municion_ingresofab.motivo=municion_situacion.id
                and municion_ingresofab.departamento=mdep.dep_llave
                and municion_ingresofab.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_ingresofab.movimiento=2
                and municion_ingresofab.departamento = $valor
                and municion_ingresofab.situacion=1
                
                 order by municion_ingresofab.fecha desc";


                $IngresoAlmacens = IngresoAlmacen::fetchArray($sql);

                echo json_encode($IngresoAlmacens);
                // exit;

            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "Ocurrió  un error en base de datos.",

                    "codigo" => 4,
                ]);
            }

        }

        if ($valor != 2090) {


            try {

                $sql = "SELECT municion_almacencomando.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo, 
documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), '' )as catalogosalida



from municion_almacencomando left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
where municion_almacencomando.lote=municion_lote.id
and municion_almacencomando.calibre=municion_calibre.id
and municion_almacencomando.motivo=municion_situacion.id
and municion_almacencomando.departamento=mdep.dep_llave
and municion_almacencomando.catalogo=mper1.per_catalogo
and mper1.per_grado = grados1.gra_codigo
and municion_almacencomando.movimiento=2
and municion_almacencomando.departamento = $valor
and municion_almacencomando.situacion=1

 order by municion_almacencomando.fecha desc";

                $IngresoAlmacens = IngresoAlmacen::fetchArray($sql);
                echo json_encode($IngresoAlmacens);
                // exit;

            } catch (Exception $e) {
                echo json_encode([
                    "detalle" => $e->getMessage(),
                    "mensaje" => "Ocurrió  un error en base de datos.",

                    "codigo" => 4,
                ]);
            }
        }


    }


    public static function buscaringreso()
    {
        getHeadersApi();


        try {
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo, 
                documento, observaciones, (CASE municion_ingresoalmacen.movimiento
                        WHEN 1 THEN 'ENTRADA FABRICA'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'SIN ASIGNAR' )as catalogosalida
            


                from municion_ingresoalmacen left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_ingresoalmacen.movimiento=1
                and municion_ingresoalmacen.situacion=1
                order by municion_ingresoalmacen.fecha desc"
            );
            echo json_encode($IngresoAlmacens);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public static function buscarSalida()
    {
        getHeadersApi();



        try {
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, (CASE municion_ingresoalmacen.movimiento
                        WHEN 1 THEN 'ENTRADA FABRICA'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'SIN ASIGNAR' )as catalogosalida
            


                from municion_ingresoalmacen left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_ingresoalmacen.movimiento=3
                and municion_ingresoalmacen.situacion=1
                order by municion_ingresoalmacen.fecha desc"
            );
            echo json_encode($IngresoAlmacens);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public static function buscarRechazo()
    {
        getHeadersApi();


        try {
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.movimiento=4
                and municion_ingresoalmacen.situacion=1
                order by municion_ingresoalmacen.fecha desc"
            );
            echo json_encode($IngresoAlmacens);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
    public static function historialFabrica()
    {
        getHeadersApi();



        try {
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo, 
                documento, observaciones, (CASE municion_ingresoalmacen.movimiento
                        WHEN 1 THEN 'ENTRADA FABRICA'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'SIN ASIGNAR' )as catalogosalida
            


                from municion_ingresoalmacen left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_ingresoalmacen.situacion=5
                order by municion_ingresoalmacen.fecha desc;"
            );
            echo json_encode($IngresoAlmacens);
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }

    public static function modificarAPI()
    {
        getHeadersApi();
        $IngresoAlmacen = new IngresoAlmacen($_POST);

        $resultado = $IngresoAlmacen->guardar();

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

    public static function eliminarAPI()
    {
        getHeadersApi();

        try {
            $IngresoAlmacen = IngresoAlmacen::find($_POST['id']);
            $IngresoAlmacen->situacion = 0;
            $resultado = $IngresoAlmacen->guardar();

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





    public static function validarRegistro1()
    {
        getHeadersApi();




        $IngresoAlmacen = IngresoAlmacen::find($_POST['id']);

        $IngresoAlmacen->movimiento = 2;

        $resultado = $IngresoAlmacen->guardar();


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
    public static function trasladarMunicion3()
    {
        getHeadersApi();


        $IngresoAlmacen = IngresoAlmacen::find($_POST['id']);
        $IngresoAlmacen->movimiento = 3;
        $resultado = $IngresoAlmacen->guardar();


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

    public static function GenerarSalida1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = " SELECT municion_ingresoalmacen.id as id, municion_ingresoalmacen.lote as  idlote, municion_lote.descripcion as lote, municion_ingresoalmacen.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_ingresoalmacen.motivo as idmotivo, municion_situacion.descripcion as motivo, catalogo
            from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_ingresoalmacen.lote=municion_lote.id
            and municion_ingresoalmacen.calibre=municion_calibre.id
            and municion_ingresoalmacen.motivo=municion_situacion.id
            and municion_ingresoalmacen.departamento=mdep.dep_llave
            and municion_ingresoalmacen.movimiento=2
            and municion_ingresoalmacen.situacion=1
            and municion_ingresoalmacen.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = IngresoAlmacen::fetchArray($sql);
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
                $catalogo = $key['catalogo'];



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
    public static function GenerarRegreso1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = " SELECT municion_ingresoalmacen.id as id, municion_ingresoalmacen.lote as  idlote, municion_lote.descripcion as lote, municion_ingresoalmacen.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_ingresoalmacen.situacion as idmotivo, municion_situacion.descripcion as motivo
            from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_ingresoalmacen.lote=municion_lote.id
            and municion_ingresoalmacen.calibre=municion_calibre.id
            and municion_ingresoalmacen.motivo=municion_situacion.id
            and municion_ingresoalmacen.departamento=mdep.dep_llave
            and municion_ingresoalmacen.movimiento=2
            and municion_ingresoalmacen.situacion=1
            and municion_ingresoalmacen.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = IngresoAlmacen::fetchArray($sql);
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

    public static function catalogo()
    {
        // hasPermissionApi(['RRMM_COMANDANCI','RRMM_ADMIN','RRMM_DEP_MIL']);

        $catalogo = $_GET['catalogo'];


        $informacion = IngresoAlmacen::fetchArray("SELECT trim(gra_desc_ct) as grado, trim(per_nom1) || ' ' || trim(per_nom2) || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) as nombre, ape_id, ape_dep,ape_catalogo  FROM mper inner join grados on per_grado = gra_codigo left join res_asig_per on ape_catalogo = per_catalogo where per_catalogo = $catalogo");

        echo json_encode($informacion);
    }
    public static function catalogosalida()
    {
        // hasPermissionApi(['RRMM_COMANDANCI','RRMM_ADMIN','RRMM_DEP_MIL']);

        $catalogosalida = $_GET['catalogosalida'];


        $informacion = IngresoAlmacen::fetchArray("SELECT trim(gra_desc_ct) as grado, trim(per_nom1) || ' ' || trim(per_nom2) || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) as nombre, ape_id, ape_dep,ape_catalogo  FROM mper inner join grados on per_grado = gra_codigo left join res_asig_per on ape_catalogo = per_catalogo where per_catalogo = $catalogosalida");

        echo json_encode($informacion);
    }

    public static function GenerarSalidaMunicionDestinada()
    {
        getHeadersApi();

        // echo json_encode($sql);
        // exit;

        try {

            $id = $_POST['id'];


            $sql = " SELECT municion_ingresofab.id as id, municion_ingresofab.lote as  idlote, municion_lote.descripcion as lote, municion_ingresofab.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_ingresofab.motivo as idmotivo, municion_situacion.descripcion as motivo, documento, observaciones, catalogo
            from municion_ingresofab, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_ingresofab.lote=municion_lote.id
            and municion_ingresofab.calibre=municion_calibre.id
            and municion_ingresofab.motivo=municion_situacion.id
            and municion_ingresofab.departamento=mdep.dep_llave
            and municion_ingresofab.movimiento=2
            and municion_ingresofab.situacion=1
            and municion_ingresofab.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = IngresoAlmacen::fetchArray($sql);
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
                $catalogo = trim($key['catalogo']);



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
    public static function generarTraslado()
    {
        getHeadersApi();
        date_default_timezone_set('America/Guatemala');
        $fechaActual = date('Y-m-d h:m');
        $id = $_POST['id1'];
        $cantidad1 = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $deptonew = $_POST['TrasladoCom'];
        $total = $cantidad1 - $cantidad2;
        $lote = $_POST['idlote1'];
        $calibre = $_POST['idcalibre1'];
        $cantidad = $cantidad2;
        $motivo = $_POST['idmotivo1'];
        $documento = $_POST['documento1'];
        $observaciones = $_POST['observaciones1'];
        $catalogo = $_POST['catalogo1'];
        $catalogosalida = $_POST['catalogosalidatraslado'];

        $fecha = $fechaActual;

        // echo json_encode($_POST);
        // exit;


        if ($total == 0) {

            try {

                $ActualizaFabricaSalida = IngresoAlmacen::sql("UPDATE municion_ingresofab set movimiento = 3, departamento = $deptonew, catalogosalida = $catalogosalida where id = $id");

                $ActualizaFabricaHistorial = IngresoAlmacen::sql("INSERT INTO municion_ingresofab VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew, $catalogo, $catalogosalida, 5)");

                $ingresoAlmacen = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $lote,
                    'calibre' => $calibre,
                    'cantidad' => $cantidad2,
                    'motivo' => $motivo,
                    'documento' => $documento,
                    'observaciones' => $observaciones,
                    'movimiento' => '1',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'catalogo' => $catalogosalida,
                    'catalogosalida' => '0',
                    'situacion' => '1'

                ]);

                $resultad = $ingresoAlmacen->guardar();

                $ingresoAlmacenHistoria = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $lote,
                    'calibre' => $calibre,
                    'cantidad' => $cantidad2,
                    'motivo' => $motivo,
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '1',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'catalogo' => $catalogo,
                    'catalogosalida' => $catalogosalida,
                    'situacion' => '5'

                ]);

                $resultado1 = $ingresoAlmacenHistoria->guardar();

                if ($resultado1['resultado'] == 1) {
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
        // aqui estoy
        if ($total > 0) {

            try {
                $ActualizaFabricaSalida = IngresoAlmacen::sql("UPDATE municion_ingresofab set cantidad = $total where id = $id");
                $ActualizaFabricaHistorial = IngresoAlmacen::sql("INSERT INTO municion_ingresofab VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew, $catalogo, $catalogosalida, 5)");
                $ActualizaFabricaHistorial1 = IngresoAlmacen::sql("INSERT INTO municion_ingresofab VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', 3, '$fecha', $deptonew, $catalogo, $catalogosalida, 1)");


                $ingresoAlmacen = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $lote,
                    'calibre' => $calibre,
                    'cantidad' => $cantidad2,
                    'motivo' => $motivo,
                    'documento' => $documento,
                    'observaciones' => $observaciones,
                    'movimiento' => '1',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'catalogo' => $catalogosalida,
                    'catalogosalida' => '0',
                    'situacion' => '1'

                ]);

                $resultad = $ingresoAlmacen->guardar();

                $ingresoAlmacenHistoria = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $lote,
                    'calibre' => $calibre,
                    'cantidad' => $cantidad2,
                    'motivo' => $motivo,
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '1',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'catalogo' => $catalogo,
                    'catalogosalida' => $catalogosalida,
                    'situacion' => '5'

                ]);

                $resultado1 = $ingresoAlmacenHistoria->guardar();

                if ($resultado1['resultado'] == 1) {
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