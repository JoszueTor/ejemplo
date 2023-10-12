<?php



namespace Controllers;

use Model\busqueda;
use MVC\Router;
use Exception;

class busquedaController
{
    public static function index(Router $router)
    {
        $lote = busqueda::fetchArray("SELECT * FROM municion_lote WHERE situacion = 1");
        $calibre = busqueda::fetchArray("SELECT * FROM municion_calibre WHERE situacion = 1");
        $movimiento = busqueda::fetchArray("SELECT * FROM municion_situacion WHERE situacion = 1");
        $deptop = busqueda::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");
        $comando = busqueda::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");
        $TrasladoCom = busqueda::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");

        // echo var_dump($comando);



        $router->render('busqueda/index', [

            'lote' => $lote,
            'calibre' => $calibre,
            'movimiento' => $movimiento,
            'deptop' => $deptop,
            'comando' => $comando,
            'TrasladoCom' => $TrasladoCom,
        ]);


    }



    public static function buscarAPI()
    {
        getHeadersApi();

        $lotebuscado=$_POST['lote'];
        $calibrebuscado=$_POST['calibre'];
        $motivobuscado =$_POST['motivo'];
        $catalogobuscado =$_POST['catalogo'];
        $comandobuscado =$_POST['comando'];

            //  echo json_encode($_POST);
            // exit;

     

       
               $sql = "  SELECT lote, municion_lote.descripcion as loted, calibre, municion_calibre.descripcion as calibred, sum(cantidad) as cantidad, motivo, municion_situacion.descripcion 
               as motivod, departamento, mdep.dep_desc_ct as departamentod
                FROM municion_batallon, municion_lote, municion_calibre, municion_situacion, mdep, mper
                       where municion_lote.id = municion_batallon.lote
                       and municion_calibre.id = municion_batallon.calibre
                       and municion_situacion.id = municion_batallon.motivo
                       and mdep.dep_llave = municion_batallon.departamento
                       and mper.per_catalogo = municion_batallon.catalogosalida
                       and municion_batallon.movimiento = 2
                       and municion_batallon.situacion = 1 
                       ";

                if($lotebuscado != ''){
                    $sql .= " and municion_batallon.lote = $lotebuscado";
                }
                if($calibrebuscado !=''){
                    $sql .= " and municion_batallon.calibre = $calibrebuscado";
                } 
                if($motivobuscado !=''){
                    $sql .= " and municion_batallon.motivo = $motivobuscado";
                } 
                if($catalogobuscado!=''){
                    $sql .= " and municion_batallon.catalogosalida = $catalogobuscado";
                }
                if($comandobuscado!=''){
                    $sql .= " and municion_batallon.departamento = $comandobuscado";
                }

                $sql .= " group by lote, loted, calibre, calibred, motivo, motivod, departamento, departamentod";

                $result = busqueda::fetchArray($sql);
                echo json_encode($result);
            
               


            


    }
    
}