<?php
namespace Controllers;

use Model\almacenComando;
use MVC\Router;
use Exception;

class almacenComandoController
{

    public static function index(Router $router)
    {
        // $usuario = 606871;
        $lote = almacenComando::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = almacenComando::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = almacenComando::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");


        // $usuario = 606871;
        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_lg'];
            $org_dep = $value['org_dependencia'];
            // var_dump($org_dep);
        }

        $deptop = almacenComando::fetchArray("SELECT org_plaza, org_jerarquia[1], org_plaza_desc, org_dependencia  FROM morg  WHERE org_dependencia = $org_dep and org_ceom = 'TITULO' AND org_jerarquia[2,10]= '000000000' AND org_situacion = 'A' and org_jerarquia[1] not in (0)");

        $batallon = almacenComando::fetchArray("SELECT * FROM municion_organizacion WHERE id_dependencia = $org_dep and jerarquia between 10 and 15 and situacion = 1");

        $router->render('almacenComando/index', [

            'lote' => $lote,
            'calibre' => $calibre,
            'movimiento' => $movimiento,
            'deptop' => $deptop,
            'dependencia' => $dependencia,
            'org_dep' => $org_dep,
            'batallon' => $batallon,
        ]);


    }

    public static function guardarAPI()
    {
        getHeadersApi();

        try {
            date_default_timezone_set('America/Guatemala');

            $fechaActual = date('Y-m-d h:m');

            //$ingreso = new almacenComando($_POST);

            $ingreso = new almacenComando([
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

            $historial = new almacenComando([
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
    public static function guardarAPITraslado()
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
        $idcomando = $_POST['idcomando'];
        $catalogo = $_POST['catalogo1'];
        $catalogotraslado = $_POST['catalogoTraslado'];

        // echo json_encode($catalogotraslado);
        //     exit;

        if ($total > 0) {

            try {

                $insertHistorial = almacenComando::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 1, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");

                $seasignoHistorial = almacenComando::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 4, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $insertMovimiento = almacenComando::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 1, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $resultadoAlmacen = almacenComando::sql("UPDATE municion_almacencomando set cantidad = $total where id = $id");

                $asignadoBatallon = almacenComando::sql("INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 4, '$fecha', $idcomando, $catalogo, $catalogotraslado, 1)");

                $asignadoHistorial = "INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 4, '$fecha', $idcomando, $catalogo, $catalogotraslado, 5)";

                // echo json_encode($asignadoBatallon);
                // exit;

                $resultado = almacenComando::sql($asignadoHistorial);

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

        if ($total == 0) {

            try {

                $insertHistorial = almacenComando::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento', '$observaciones', 1, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 5)");

                $insertMovimiento = almacenComando::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 1, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $insertMovimiento = almacenComando::sql("INSERT INTO municion_batallon VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 4, '$fecha', $idcomando, $batallon, $catalogo, $catalogotraslado, 1)");

                $resultadoAlmacen = almacenComando::sql("UPDATE municion_almacencomando set cantidad = $cantidad2, movimiento = 3, situacion = 5 where id = $id");

                $sql = "INSERT INTO municion_almacencomando VALUES (0, $lote, $calibre, $cantidad2, $motivo, '$documento',' $observaciones', 4, '$fecha', $idcomando, $catalogo, $catalogotraslado, 1)";


                $resultado = almacenComando::sql($sql);
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
    }

    public static function guardarAPIregreso()
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
        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        //   echo json_encode($_POST);
        // exit;


        if ($total > 0) {

            try {


                $resultado = almacenComando::sql("UPDATE municion_almacenComando set cantidad = $total where id = $id");

                $salida = new almacenComando([
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


                $historial = new almacenComando([
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

                $actualiza = new almacenComando([
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



                $salida = new almacenComando([
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

    public static function buscarAPI()
    {
        getHeadersApi();



        try {

            $usuario = "SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER";

            $dependencias = almacenComando::fetchArray($usuario);
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }

            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_almacencomando.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_almacencomando.movimiento
                        WHEN 1 THEN 'ENTRADA A ALMACEN'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASIGNADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'FABRICA' )as catalogosalida
            

                from municion_almacencomando left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_almacencomando.lote=municion_lote.id
                and municion_almacencomando.calibre=municion_calibre.id
                and municion_almacencomando.motivo=municion_situacion.id
                and municion_almacencomando.departamento=mdep.dep_llave
                and municion_almacencomando.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_almacencomando.departamento=$org_dep
                and municion_almacencomando.movimiento=2
                and municion_almacencomando.situacion=1
                order by municion_almacencomando.fecha desc"
            );

            echo json_encode($almacenComandos);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }


    public static function buscaringreso()
    {
        getHeadersApi();

        // $usuario = 606871;

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo =USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {


            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_almacencomando.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones,
                (CASE municion_almacencomando.movimiento
                        WHEN 1 THEN 'ENTRADA A ALMACEN'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'FABRICA' )as catalogosalida
            
                from municion_almacencomando left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_almacencomando.lote=municion_lote.id
                and municion_almacencomando.calibre=municion_calibre.id
                and municion_almacencomando.motivo=municion_situacion.id
                and municion_almacencomando.departamento=mdep.dep_llave
                and municion_almacencomando.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_almacencomando.departamento=$org_dep
                and municion_almacencomando.movimiento=1
                and municion_almacencomando.situacion=1
                order by municion_almacencomando.fecha desc"
            );

            echo json_encode($almacenComandos);

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

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");

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
           and municion_asentamientobat.movimiento=4
           and municion_asentamientobat.situacion=7
           order by municion_asentamientobat.fecha desc";
            $almacenComandos = almacenComando::fetchArray($query);




            echo json_encode($almacenComandos);


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

        // $usuario = 606871;

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {
            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_almacencomando.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones,
                (CASE municion_almacencomando.movimiento
                        WHEN 1 THEN 'ENTRADA A ALMACEN'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento,  trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'FABRICA' )as catalogosalida
            
                from municion_almacencomando left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_almacencomando.lote=municion_lote.id
                and municion_almacencomando.calibre=municion_calibre.id
                and municion_almacencomando.motivo=municion_situacion.id
                and municion_almacencomando.departamento=mdep.dep_llave
                and municion_almacencomando.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_almacencomando.departamento=$org_dep
                and municion_almacencomando.movimiento between 3 and 4 
                and municion_almacencomando.situacion=1
                order by municion_almacencomando.fecha desc"
            );
            echo json_encode($almacenComandos);
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
            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_almacenComando.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_almacenComando, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_almacenComando.lote=municion_lote.id
                and municion_almacenComando.calibre=municion_calibre.id
                and municion_almacenComando.motivo=municion_situacion.id
                and municion_almacenComando.departamento=mdep.dep_llave
                and municion_almacenComando.movimiento=4
                and municion_almacenComando.situacion=1"
            );
            echo json_encode($almacenComandos);
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

        // $usuario = 606871;

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {
            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_almacencomando.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, (CASE municion_almacencomando.movimiento
                        WHEN 1 THEN 'ENTRADA A ALMACEN'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'ASGINADO A BATALLON'
                        END
                    ) as movimiento, fecha, mdep.dep_desc_md as departamento, trim(grados1.gra_desc_ct) as grado, 
                trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
                nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
                nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'FABRICA' )as catalogosalida
            


                from municion_almacencomando left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo, municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
                where municion_almacencomando.lote=municion_lote.id
                and municion_almacencomando.calibre=municion_calibre.id
                and municion_almacencomando.motivo=municion_situacion.id
                and municion_almacencomando.departamento=mdep.dep_llave
                and municion_almacencomando.catalogo=mper1.per_catalogo
                and mper1.per_grado = grados1.gra_codigo
                and municion_almacencomando.departamento=$org_dep
                
                and municion_almacencomando.situacion=5
                order by municion_almacencomando.fecha desc"
            );
            echo json_encode($almacenComandos);
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
        $almacenComando = new almacenComando($_POST);

        $resultado = $almacenComando->guardar();

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
            $almacenComando = almacenComando::find($_POST['id']);
            $almacenComando->situacion = 0;
            $resultado = $almacenComando->guardar();

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

        $id = $_POST['id'];


        $almacenComando = almacenComando::find($id);

        $almacenComando->movimiento = 2;
        // $almacenComando->situacion = 5;

        $resultado = $almacenComando->guardar();




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


        $almacenComando = almacenComando::find($_POST['id']);
        $almacenComando->movimiento = 3;
        $resultado = $almacenComando->guardar();


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


            // $usuario = 606871;

            $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = USER");
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }


            $id = $_POST['id'];

            // 


            // 

            $sql = "SELECT municion_almacencomando.id as id, municion_almacencomando.lote as  idlote, municion_lote.descripcion as lote, municion_almacencomando.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_almacencomando.motivo as idmotivo, municion_situacion.descripcion as motivo, documento, observaciones, catalogosalida
            from municion_almacencomando, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_almacencomando.lote=municion_lote.id
            and municion_almacencomando.calibre=municion_calibre.id
            and municion_almacencomando.motivo=municion_situacion.id
            and municion_almacencomando.departamento=mdep.dep_llave
            and municion_almacencomando.departamento=$org_dep
            and municion_almacencomando.movimiento=2
            and municion_almacencomando.situacion=1
            and municion_almacencomando.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = almacenComando::fetchArray($sql);
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
    public static function catalogo()
    {
        // hasPermissionApi(['RRMM_COMANDANCI','RRMM_ADMIN','RRMM_DEP_MIL']);

        $catalogo = $_GET['catalogo'];




        $informacion = almacenComando::fetchArray("SELECT trim(gra_desc_ct) as grado, trim(per_nom1) || ' ' || trim(per_nom2) || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) as nombre, ape_id, ape_dep,ape_catalogo  FROM mper inner join grados on per_grado = gra_codigo left join res_asig_per on ape_catalogo = per_catalogo where per_catalogo = $catalogo");

        echo json_encode($informacion);
    }
    public static function GenerarRegreso1()
    {
        getHeadersApi();

        // echo json_encode($sql);

        try {

            $id = $_POST['id'];


            $sql = " SELECT municion_almacencomando.id as id, municion_almacencomando.lote as  idlote, municion_lote.descripcion as lote, municion_almacencomando.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_almacencomando.motivo as idmotivo, municion_situacion.descripcion as motivo
            from municion_almacencomando, municion_lote, municion_calibre, municion_situacion, mdep 
            where municion_almacencomando.lote=municion_lote.id
            and municion_almacencomando.calibre=municion_calibre.id
            and municion_almacencomando.motivo=municion_situacion.id
            and municion_almacencomando.departamento=mdep.dep_llave
            and municion_almacencomando.movimiento=2
            and municion_almacencomando.situacion=2
            and municion_almacencomando.id = $id";
            // echo json_encode($sql);
            // exit;
            $info = almacenComando::fetchArray($sql);
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