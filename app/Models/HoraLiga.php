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
        if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerAllHoraligaNombre($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }
    }
}
