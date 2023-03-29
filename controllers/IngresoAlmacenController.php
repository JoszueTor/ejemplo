<?php



namespace Controllers;

use Model\IngresoAlmacen;
use MVC\Router;
use Exception;

class IngresoAlmacenController
{

    public function index(Router $router)
    {
        $lote = IngresoAlmacen::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = IngresoAlmacen::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = IngresoAlmacen::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");
        $deptop = IngresoAlmacen::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");




        $router->render('IngresoAlmacen/index', [

            'lote' => $lote,
            'calibre' => $calibre,
            'movimiento' => $movimiento,
            'deptop' => $deptop,
        ]);


    }

    public function guardarAPI()
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
                'departamento' => '250'

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




        if ($total > 0) {

            try {


                $resultado = IngresoAlmacen::sql("UPDATE municion_ingresoalmacen set cantidad = $total where id = $id");

                $salida = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $salida->guardar();


                $historial = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'situacion' => '5'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $historial->guardar();

                $comando = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '1',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'situacion' => '2'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado1 = $comando->guardar();

                $ingreso = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '2',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'situacion' => '6',
        
        
                ]);
        
                // echo json_encode($ingreso);
                // exit;
        
                $resultado12 = $ingreso->guardar();

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

            $resultado = IngresoAlmacen::sql("UPDATE municion_ingresoalmacen set cantidad = $total, situacion = 0 where id = $id");

            try {

                $actualiza = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew


                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $actualiza->guardar();



                $salida = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'situacion' => '5'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado = $salida->guardar();

                $comando = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '1',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'situacion' => '2'

                ]);
                //     echo json_encode($ingreso);
                // exit;

                $resultado1 = $comando->guardar();

                $ingreso = new IngresoAlmacen([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '2',
                    'fecha' => $fechaActual,
                    'departamento' => $deptonew,
                    'situacion' => '6',
        
        
                ]);
        
                // echo json_encode($ingreso);
                // exit;
        
                $resultado12 = $ingreso->guardar();

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


                $resultado = IngresoAlmacen::sql("UPDATE municion_ingresoalmacen set cantidad = $total where id = $id");

                $salida = new IngresoAlmacen([
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


                $historial = new IngresoAlmacen([
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



                $salida = new IngresoAlmacen([
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
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
                "SELECT municion_ingresoalmacen.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresoalmacen, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresoalmacen.lote=municion_lote.id
                and municion_ingresoalmacen.calibre=municion_calibre.id
                and municion_ingresoalmacen.motivo=municion_situacion.id
                and municion_ingresoalmacen.departamento=mdep.dep_llave
                and municion_ingresoalmacen.movimiento=2
                and municion_ingresoalmacen.situacion=1"

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


    public function buscaringreso()
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
                and municion_ingresoalmacen.movimiento=1
                and municion_ingresoalmacen.situacion=1"
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
    public function buscarSalida()
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
                and municion_ingresoalmacen.movimiento=3
                and municion_ingresoalmacen.situacion=1"
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
    public function buscarRechazo()
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
                and municion_ingresoalmacen.situacion=1"
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
    public function historialFabrica()
    {
        getHeadersApi();



        try {
            $IngresoAlmacens = IngresoAlmacen::fetchArray(
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
                and municion_ingresoalmacen.situacion=5"
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

    public function modificarAPI()
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

    public function eliminarAPI()
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





    public function validarRegistro1()
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
    public function trasladarMunicion3()
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

}