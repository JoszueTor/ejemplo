<?php

namespace Model;

class IngresoFab extends ActiveRecord
{

    protected static $tabla = 'municion_IngresoFab'; //nombre de la tablaX
    protected static $columnasDB = ['ID', 'LOTE', 'CALIBRE','CANTIDAD', 'MOTIVO', 'DOCUMENTO', 'OBSERVACIONES', 'MOVIMIENTO', 'FECHA', 'DEPARTAMENTO',
'SITUACION'];

    public $id;
    public $lote;
    public $calibre;
    public $cantidad;
    public $motivo;
    public $documento;
    public $observaciones;
    public $movimiento;
    public $fecha;
    public $departamento;
    public $situacion;



    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->lote = $args['lote'] ?? '';
        $this->calibre = $args['calibre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->motivo = $args['motivo'] ?? '';
        $this->documento = $args['documento'] ?? '';
        $this->observaciones = $args['observaciones'] ?? '';
        $this->movimiento = $args['movimiento'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->departamento = $args['departamento'] ?? '';

        $this->situacion = $args['situacion'] ?? '1';
    }


}