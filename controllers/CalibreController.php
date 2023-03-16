<?php

namespace Controllers;

use Model\Calibre;
use MVC\Router;
use Exception;

class CalibreController
{

    public function index(Router $router)
    {
        $router->render('Calibre/index');
    }

    public function guardarAPI()
    {
        getHeadersApi();



        try {
            $Calibre = new Calibre($_POST);

            $resultado = $Calibre->guardar();


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
            $Calibres = Calibre::where('situacion', '1');
            echo json_encode($Calibres);
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
        $Calibre = new Calibre($_POST);

        $resultado = $Calibre->guardar();

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
        $Calibre = new Calibre($_POST);

        $resultado = $Calibre->guardar();

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