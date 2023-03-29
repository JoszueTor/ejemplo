<?php



namespace Controllers;

use Model\IngresoFab;
use MVC\Router;
use Exception;

class IngresoFabController
{

    public function index(Router $router)
    {
        $lote = IngresoFab::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = IngresoFab::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = IngresoFab::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");
        $deptop = IngresoFab::fetchArray("SELECT * FROM mdep ");




        $router->render('IngresoFab/index', [

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
            //$ingreso = new IngresoFab($_POST);

            $ingreso = new IngresoFab([
                'id' => null,
                'lote' => $_POST['lote'],
                'calibre' => $_POST['calibre'],
                'cantidad' => $_POST['cantidad'],
                'motivo' => $_POST['motivo'],
                'documento' => $_POST['documento'],
                'observaciones' => $_POST['observaciones'],
                'movimiento' => '1',
                'fecha' => $fechaActual,
                'departamento' => '1090'

            ]);

            // echo json_encode($ingreso);
            // exit;

            $resultado = $ingreso->guardar();

            $historial = new IngresoFab([
                'id' => null,
                'lote' => $_POST['lote'],
                'calibre' => $_POST['calibre'],
                'cantidad' => $_POST['cantidad'],
                'motivo' => $_POST['motivo'],
                'documento' => $_POST['documento'],
                'observaciones' => $_POST['observaciones'],
                'movimiento' => '1',
                'fecha' => $fechaActual,
                'departamento' => '1090',
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
        //   echo json_encode($_POST);
//             exit;

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
        $movimiento = '1';
        $fecha = $fechaActual;
        $departamento = '1090';
        $situacion = '1';




        if ($total > 0) {

            try {


                $actualiza1 = IngresoFab::sql("UPDATE municion_ingresofab set cantidad = $total where id = $id");

              
                $almacen = IngresoFab::sql("INSERT INTO municion_ingresoalmacen VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', $movimiento, '$fecha', 1090, $situacion)");

                $salida = new IngresoFab([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => '1090'

                ]);
               
                $resultado1 = $salida->guardar();


                $historial=new IngresoFab([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => '1090',
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

                $almacen = IngresoFab::sql("INSERT INTO municion_ingresoalmacen VALUES (0, $lote, $calibre, $cantidad, $motivo, '$documento', '$observaciones', $movimiento, '$fecha', 1090, $situacion)");

              

                $actualiza1 = IngresoFab::sql("UPDATE municion_ingresofab set cantidad = $total, situacion = 5 where id = $id");

                $actualiza = new IngresoFab([
                    'id' => null,
                    'lote' => $_POST['idlote1'],
                    'calibre' => $_POST['idcalibre1'],
                    'cantidad' => $cantidad2,
                    'motivo' => $_POST['idmotivo1'],
                    'documento' => $_POST['documento1'],
                    'observaciones' => $_POST['observaciones1'],
                    'movimiento' => '3',
                    'fecha' => $fechaActual,
                    'departamento' => '1090'


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

    public function buscarAPI()
    {
        getHeadersApi();



        try {
            $IngresoFabs = IngresoFab::fetchArray(
                "SELECT municion_ingresofab.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
                documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresofab, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresofab.lote=municion_lote.id
                and municion_ingresofab.calibre=municion_calibre.id
                and municion_ingresofab.motivo=municion_situacion.id
                and municion_ingresofab.departamento=mdep.dep_llave
                and municion_ingresofab.movimiento=2
                and municion_ingresofab.situacion=1"

            );
            echo json_encode($IngresoFabs);
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
            $IngresoFabs = IngresoFab::fetchArray(
                "SELECT municion_ingresofab.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresofab, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresofab.lote=municion_lote.id
                and municion_ingresofab.calibre=municion_calibre.id
                and municion_ingresofab.motivo=municion_situacion.id
                and municion_ingresofab.departamento=mdep.dep_llave
                and municion_ingresofab.movimiento=1
                and municion_ingresofab.situacion=1"
            );
            echo json_encode($IngresoFabs);
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
            $IngresoFabs = IngresoFab::fetchArray(
                "SELECT municion_ingresofab.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, movimiento, fecha, mdep.dep_desc_md as departamento   
                from municion_ingresofab, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresofab.lote=municion_lote.id
                and municion_ingresofab.calibre=municion_calibre.id
                and municion_ingresofab.motivo=municion_situacion.id
                and municion_ingresofab.departamento=mdep.dep_llave
                and municion_ingresofab.movimiento=3
                and municion_ingresofab.situacion=1"
            );
            echo json_encode($IngresoFabs);
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
            $IngresoFabs = IngresoFab::fetchArray(
                "SELECT municion_ingresofab.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, 
                municion_situacion.descripcion as motivo, documento, observaciones, (CASE municion_ingresofab.movimiento
                        WHEN 1 THEN 'ENTRADA FABRICA'
                        WHEN 2 THEN 'INGRESO FABRICA'
                        WHEN 3 THEN 'SALIDA FABRICA'
                        END
                    ) as movimiento, municion_ingresofab.situacion as situacion,
                 fecha, mdep.dep_desc_md as departamento
                from municion_ingresofab, municion_lote, municion_calibre, municion_situacion, mdep 
                where municion_ingresofab.lote=municion_lote.id
                and municion_ingresofab.calibre=municion_calibre.id
                and municion_ingresofab.motivo=municion_situacion.id
                and municion_ingresofab.departamento=mdep.dep_llave
                and municion_ingresofab.situacion=5"
            );
            echo json_encode($IngresoFabs);
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
        $IngresoFab = new IngresoFab($_POST);

        $resultado = $IngresoFab->guardar();

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
            $IngresoFab = IngresoFab::find($_POST['id']);
            $IngresoFab->situacion = 0;
            $resultado = $IngresoFab->guardar();

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



        $IngresoFab = IngresoFab::find($_POST['id']);

        $IngresoFab->movimiento = 2;

        $resultado = $IngresoFab->guardar();




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


        $IngresoFab = IngresoFab::find($_POST['id']);
        $IngresoFab->movimiento = 3;
        $resultado = $IngresoFab->guardar();


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


            $sql = " SELECT municion_ingresofab.id as id, municion_ingresofab.lote as  idlote, municion_lote.descripcion as lote, municion_ingresofab.calibre as idcalibre, municion_calibre.descripcion as calibre, cantidad, municion_ingresofab.situacion as idmotivo, municion_situacion.descripcion as motivo
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
            $info = IngresoFab::fetchArray($sql);
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