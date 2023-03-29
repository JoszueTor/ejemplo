<?php

namespace Controllers;

use Model\helado;
use MVC\Router;
use Exception;

class heladoController
{

    public function index(Router $router)
    {
        $router->render('helado/index');
    }

    public function guardarAPI()
    {
        getHeadersApi();



        try {
            $helado = new helado($_POST);

            $resultado = $helado->guardar();


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
            $helados = helado::where('situacion', '1');
            echo json_encode($helados);
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
        $helado = new helado($_POST);

        $resultado = $helado->guardar();

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
        $helado = new helado($_POST);

        $resultado = $helado->guardar();

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