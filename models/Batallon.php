<?php

namespace Model;

class batallon extends ActiveRecord
{
    protected static $tabla = 'municion_batallon'; //nombre de la tablaX
    protected static $columnasDB = [
        'ID',
        'LOTE',
        'CALIBRE',
        'CANTIDAD',
        'MOTIVO',
        'DOCUMENTO',
        'OBSERVACIONES',
        'MOVIMIENTO',
        'FECHA',
        'DEPARTAMENTO',
        'BATALLON',
        'CATALOGO',
        'CATALOGOSALIDA',
        'SITUACION'
    ];

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
    public $batallon;
    public $catalogo;
    public $catalogosalida;
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
        $this->batallon = $args['batallon'] ?? '';
        $this->catalogo = $args['catalogo'] ?? '';
        $this->catalogosalida = $args['catalogosalida'] ?? '0';
        $this->situacion = $args['situacion'] ?? '1';
    }


}