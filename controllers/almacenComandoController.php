<?php



namespace Controllers;

use Model\almacenComando;
use MVC\Router;
use Exception;

class almacenComandoController
{



    public function index(Router $router)
    {
        $usuario = 644112;
        $lote = almacenComando::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = almacenComando::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = almacenComando::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = $usuario");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        $deptop = almacenComando::fetchArray("SELECT org_plaza, org_jerarquia[1], org_plaza_desc, org_dependencia  FROM morg  WHERE org_dependencia = $org_dep and org_ceom = 'TITULO' AND org_jerarquia[2,10]= '000000000' AND org_situacion = 'A'");


        $router->render('almacenComando/index', [

            'lote' => $lote,
            'calibre' => $calibre,
            'movimiento' => $movimiento,
            'deptop' => $deptop,
            'dependencia' => $dependencia,
            'org_dep' => $org_dep,
        ]);


    }

    public function guardarAPI()
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
    public function guardarAPITraslado()
    {
        getHeadersApi();


        date_default_timezone_set('America/Guatemala');

        $fechaActual = date('Y-m-d h:m');


        $id = $_POST['id1'];
        $cantidad1 = $_POST['cantidad1'];
        $cantidad2 = $_POST['cantidadnew1'];
        $deptonew = $_POST['Deptop'];
        $total = $cantidad1 - $cantidad2;


        //  echo json_encode($_POST);
        //             exit;

        if ($total > 0) {

            try {


                $resultado = almacenComando::sql("UPDATE municion_ingresoalmacen set cantidad = $total where id = $id");

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
                    'departamento' => '2940',
                    'batallon' => $_POST['Deptop'],
                    'cuatrimestre' => $_POST['cuatrimestre'],
                    'situacion' => '2'

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

        if ($total == 0) {

            $resultado = almacenComando::sql("UPDATE municion_almacenComando set cantidad = $total, situacion = 1 where id = $id");

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
                    'departamento' => '2940',
                    'batallon' => $_POST['Deptop'],
                    'cuatrimestre' => $_POST['cuatrimestre'],
                    'situacion' => '2'


                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $actualiza->guardar();



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
                    'departamento' => '250'

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

    public function buscarAPI()
    {
        getHeadersApi();



        try {

            $usuario = 644112;

            $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = $usuario");
            foreach ($dependencias as $key => $value) {

                $dependencia = $value['dep_desc_ct'];
                $org_dep = $value['org_dependencia'];
            }

            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.departamento=$org_dep
                and municion_ingresoalmacen.movimiento=2
                and municion_ingresoalmacen.situacion=2"

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


    public function buscaringreso()
    {
        getHeadersApi();

        $usuario = 644112;

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = $usuario");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {


            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.departamento=$org_dep
                and municion_ingresoalmacen.movimiento=1
                and municion_ingresoalmacen.situacion=2"
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

        $usuario = 644112;

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = $usuario");

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
              cuatrimestre   
           from municion_asentamientobat, municion_lote, municion_calibre, municion_situacion, mdep, morg 
           where municion_asentamientobat.lote=municion_lote.id
           and municion_asentamientobat.calibre=municion_calibre.id
           and municion_asentamientobat.motivo=municion_situacion.id
           and municion_asentamientobat.departamento=mdep.dep_llave
           and municion_asentamientobat.batallon=morg.org_plaza
           and municion_asentamientobat.departamento=$org_dep
           and municion_asentamientobat.movimiento=4
           and municion_asentamientobat.situacion=2";
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
    public function buscarSalida()
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
                and municion_almacenComando.movimiento=3
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
    public function buscarRechazo()
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
    public function historialFabrica()
    {
        getHeadersApi();

        $usuario = 644112;

        $dependencias = almacenComando::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = $usuario");
        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_ct'];
            $org_dep = $value['org_dependencia'];
        }

        try {
            $almacenComandos = almacenComando::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, (CASE municion_ingresoalmacen.movimiento
                        WHEN 1 THEN 'ENTRADA FABRICA'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        WHEN 4 THEN 'RECHAZO SMG'
                        END
                    ) as movimiento, municion_ingresoalmacen.situacion as situacion,
                 fecha, mdep.dep_desc_md as departamento
                from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                
                and municion_ingresoalmacen.departamento= $org_dep
                and municion_ingresoalmacen.situacion=6"
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

    public function modificarAPI()
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

    public function eliminarAPI()
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





    public function validarRegistro1()
    {
        getHeadersApi();






        $almacenComando = almacenComando::find($_POST['id']);

        $almacenComando->movimiento = 2;

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
    public function trasladarMunicion3()
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

    public function GenerarSalida1()
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
            and municion_ingresoalmacen.situacion=2
            and municion_ingresoalmacen.id = $id";
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
    public function GenerarRegreso1()
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
            and municion_ingresoalmacen.situacion=2
            and municion_ingresoalmacen.id = $id";
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