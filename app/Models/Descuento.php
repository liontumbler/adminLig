<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Descuento
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function cargarDatos() {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerDescuentos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->obtenerDescuentos(1);
    }
}
