<?php

namespace Controllers;

use Model\Situaciones;
use MVC\Router;
use Exception;

class SituacionesController
{

    public function index(Router $router)
    {
        $router->render('Situaciones/index');
    }

    public function guardarAPI()
    {
        getHeadersApi();



        try {
            $Situaciones = new Situaciones($_POST);

            $resultado = $Situaciones->guardar();


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

    public function buscarAPI()
    {
        getHeadersApi();



        try {
            $Situacioness = Situaciones::where('situacion', '1');
            echo json_encode($Situacioness);
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
        $Situaciones = new Situaciones($_POST);

        $resultado = $Situaciones->guardar();

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
        $_POST['situacion'] = 0;
        $Situaciones = new Situaciones($_POST);

        $resultado = $Situaciones->guardar();

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
}