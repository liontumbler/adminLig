<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Trabajado
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function selectTrabajado() {
        return $this->db->obtenerSelectTrabajado();
    }
}
