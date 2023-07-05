<?php
namespace App\Models;

use App\DB\ConsultasDB;

class HoraLiga
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function selectHoraligas() {
        $sesionTrabajador = session()->get('SesionTrabajador');
        return $this->db->obtenerAllHoraligaNombre($sesionTrabajador['gimnasioId']);
    }
}
