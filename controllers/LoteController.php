<?php

namespace Controllers;

use Exception;
use Model\Lote;
use MVC\Router;

class LoteController
{

    public function index(Router $router)
    {
        $router->render('Lote/index');
    }

    public function guardarAPI()
    {
        getHeadersApi();

        try {


            $Lote = new Lote($_POST);

            $resultado = $Lote->guardar();
            // echo json_encode($resultado);
            // exit;

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    "resultado" => 1,
                    "mensaje" => "El registro se guardo",
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


    public function buscar()
    {
        getHeadersApi();
        $sql = "SELECT * from municion_lote";
        $Lotes = Lote::fetchArray($sql);
        echo json_encode($Lotes);
    }

    public function modificarAPI()
    {
        getHeadersApi();
        $Lote = new Lote($_POST);

        $resultado = $Lote->guardar();

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

    public function eliminar()
    {
        getHeadersApi();
        $_POST['lote_sit'] = 0;
        $Lote = new Lote($_POST);

        $resultado = $Lote->guardar();

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