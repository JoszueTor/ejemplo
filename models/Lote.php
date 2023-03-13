<?php

namespace Model;

class Lote extends ActiveRecord{

    protected static $tabla = 'municion_lote'; //nombre de la tablaX
    protected static $columnasDB = ['LOTE_ID','LOTE_DESC','LOTE_DEP','LOTE_SITUACION'];

    public $id;
    public $desc;
    public $dep;
    public $sit;


    public function __construct($args = []){
        $this->id = $args['lote_id'] ?? null;
        $this->desc = $args['lote_desc'] ?? '';
        $this->dep = $args['lote_dep'] ?? '';
        $this->sit = $args['lote_situaicon'] ?? '1';
    }

}