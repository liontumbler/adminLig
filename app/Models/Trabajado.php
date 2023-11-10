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
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerEquipos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        //id trabajador
        return $this->db->obtenerSelectTrabajado(1);
    }
}
