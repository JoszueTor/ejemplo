<?php

namespace Controllers;

use Classes\ReportePDF;
use MVC\Router;
use Exception;
use Model\ActiveRecord;

class ReporteController
{

    public static function reportes(Router $router)
    {
     
        try {
            
      
               
            $userInfo = ActiveRecord::fetchArray("SELECT * from mper inner join morg on per_plaza = org_plaza inner join mdep on org_dependencia = dep_llave where per_catalogo = 615617 ");

           
           
            $reporte = new ReportePDF($router, $userInfo);
            $pdf = $reporte->generatePDF();

            $contenido = $router->load('Reporte/Reporte', [
                'user' => $userInfo,
              
              
            ]);
          

            $pdf->WriteHTML($contenido);
            


            $pdf->Output();
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
            exit;
        }
    }


    
}