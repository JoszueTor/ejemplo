<?php

namespace Model;

class Lote extends ActiveRecord
{


    protected static $tabla = 'municion_lote'; //nombre de la tablaX
    protected static $columnasDB = ['LOTE_ID', 'LOTE_DESC', 'LOTE_SIT'];

    public $lote_id;
    public $lote_desc;

    public $lote_sit;




    public function __construct($args = [])
    {
        $this->lote_id = $args['lote_id'] ?? '0';
        $this->lote_desc = $args['lote_desc'] ?? '';

        $this->lote_sit = $args['lote_sit'] ?? '1';
    }


}