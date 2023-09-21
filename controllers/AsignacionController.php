<?php

namespace Controllers;

use Model\Asignacion;
use MVC\Router;
use Exception;

class AsignacionController
{
    public function index(Router $router)
    {


        $usuario = 644112;
        $dependencias = Asignacion::fetchArray("SELECT * FROM MPER FULL OUTER JOIN morg ON per_plaza = org_plaza FULL OUTER JOIN mdep ON dep_llave = org_dependencia WHERE per_catalogo = $usuario");

        foreach ($dependencias as $key => $value) {

            $dependencia = $value['dep_desc_lg'];
            $org_dep = $value['org_dependencia'];
            // var_dump($org_dep);
        }

        $nombre = Asignacion::fetchArray("SELECT * from municion_organizacion where id_dependencia = $org_dep and jerarquia = 1 ");
        $batallon = Asignacion::fetchArray("SELECT * from municion_organizacion where id_dependencia = $org_dep ");
        $cia1 = Asignacion::fetchArray("SELECT * from municion_organizacion where id_dependencia = $org_dep and jerarquia between 110 and 120 ");

        // foreach ($depcomando as $key => $value) {

        //     $nombre = $value['nombre'];
        //     // $org_dep = $value['org_dependencia'];
        //     // var_dump($org_dep);
        // }

        $router->render('Asignacion/index', [


            'dependencia' => $dependencia,
            'org_dep' => $org_dep,
            'nombre' => $nombre,
            'batallon' => $batallon,
            'cia1' => $cia1,
        ]);


    }


    public function buscarComando()
    {
        // getHeadersApi();

        // echo json_encode($sql);
        $dependencianew = $_GET['buscarComando'];

        // echo json_encode($dependencianew);
        // exit;

        try {

            $sql = "SELECT * from municion_organizacion where id_dependencia = $dependencianew";
            $info = Asignacion::fetchArray($sql);
            // echo json_encode($info);
            // exit;
            $data = [];
            $i = 1;
            foreach ($info as $key) {
                $id = $key['id'];
                $jerarquia = $key['jerarquia'];
                $nombre = $key['nombre'];


                $arrayInterno = [
                    [
                        "contador" => $i,
                        "jerarquia" => $jerarquia,
                        "nombre" => $nombre,
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