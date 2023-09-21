<?php



namespace Controllers;

use Model\inspectoriaG;
use MVC\Router;
use Exception;

class inspectoriaGController
{
      public function index(Router $router)
    {
        $comando = inspectoriaG::fetchArray("SELECT * FROM mdep where dep_llave between 2010 and 4030 order by dep_desc_md asc;");




        $router->render('inspectoriaG/index', [

            'comando' => $comando,
        ]);


    }

    public function buscarSinoptico()
    {
        getHeadersApi();

        $valor = $_GET['valor'];

        

        try {

            $sql = "SELECT municion_batallon.id as id, municion_lote.descripcion as lote, municion_calibre.descripcion as calibre, cantidad, municion_situacion.descripcion as motivo,
documento, observaciones, (CASE municion_batallon.movimiento
        WHEN 1 THEN 'ENTRADA BATALLON'
        WHEN 2 THEN 'INGRESO BATALLON'
        WHEN 3 THEN 'SALIDA BATALLON'
        WHEN 4 THEN 'ASGINADO A BATALLON'
        END
    ) as movimiento, fecha, mdep.dep_desc_md as departamento, 
    municion_batallon.batallon as idbatallon,
    trim(morgani.nombre) as batallon, trim(grados1.gra_desc_ct) as grado, 
trim(mper1.per_nom1) || ' ' || trim(mper1.per_nom2) || ' ' || trim(mper1.per_ape1) || ' ' || trim(mper1.per_ape2) as catalogo, 
nvl(trim(grados2.gra_desc_ct), '') as gradosalida, 
nvl(trim(mper2.per_nom1) || ' ' || trim(mper2.per_nom2) || ' ' || trim(mper2.per_ape1) || ' ' || trim(mper2.per_ape2), 'BATALLON' )as catalogosalida



from municion_batallon left join mper mper2 on catalogosalida = mper2.per_catalogo left join grados grados2 on mper2.per_grado = grados2.gra_codigo inner join municion_organizacion morgani on batallon = morgani.jerarquia,

 municion_lote, municion_calibre, municion_situacion, mdep, mper mper1, grados grados1
where municion_batallon.lote=municion_lote.id
and municion_batallon.calibre=municion_calibre.id
and municion_batallon.motivo=municion_situacion.id
and municion_batallon.departamento=mdep.dep_llave
and municion_batallon.catalogo=mper1.per_catalogo
and mper1.per_grado = grados1.gra_codigo
and municion_batallon.departamento=$valor
and morgani.id_dependencia = $valor
and municion_batallon.movimiento=4
and municion_batallon.situacion=1
";


            $batallons = inspectoriaG::fetchArray($sql);
            echo json_encode($batallons);
            // exit;
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }


    }
}