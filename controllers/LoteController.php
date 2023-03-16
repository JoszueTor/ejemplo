<?php

namespace Controllers;

use Model\Lote;
use MVC\Router;
class LoteController{

    public function index(Router $router)
    {
        $router->render('Lote/index');
    }

    public function guardarAPI(){
        getHeadersApi();

        try{
            $Lote = new Lote($_POST);
        
            $resultado = $Lote->guardar();


            if($resultado['resultado'] == 1){
                echo json_encode([
                    "resultado" => 1
                ]);
                
            }else{
                echo json_encode([
                    "resultado" => 0
                ]);
            }
        }
       

       
      
    catch (Exception $e) {
        echo json_encode([
            "detalle" => $e->getMessage(),       
            "mensaje" => "Ocurrió  un error en base de datos.",

            "codigo" => 4,
        ]);
    }
      
        
      
    }

    public function buscarAPI(){
        getHeadersApi();



        try{
            $Lotes = Lote::where('situacion', '1');
            echo json_encode($Lotes);
        }catch(Exception $e){
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
        
        
       
    }

    public function modificarAPI(){
        getHeadersApi();
        $Lote = new Lote($_POST);
        
        $resultado = $Lote->guardar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 1
            ]);
            
        }else{
            echo json_encode([
                "resultado" => 0
            ]);

        }
    }

    public function eliminarAPI(){
        getHeadersApi();
        $_POST['situacion'] = 0;
        $Lote = new Lote($_POST);
        
        $resultado = $Lote->guardar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 1
            ]);
            
        }else{
            echo json_encode([
                "resultado" => 0
            ]);

        }
    }
} 

