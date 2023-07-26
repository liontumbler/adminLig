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
        $sesionTrabajador = session()->get('SesionTrabajador');
        return $this->db->obtenerAllEquipoNombre($sesionTrabajador['gimnasioId']);
    }

    public function crearEquipo($data) {
        $this->db->crearEquipo($data, $sesionTrabajador['gimnasioId']);
    }

}
