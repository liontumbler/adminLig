<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Equipo
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function selectEquipos() {
        if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerAllEquipoNombre($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }
    }

    public function crearEquipo($data) {
        $this->db->crearEquipo($data, $sesionTrabajador['gimnasioId']);
    }

}
