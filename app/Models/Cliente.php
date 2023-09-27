<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Cliente
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function selectClientes() {
        if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerAllClienteNombre($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }
    }
}
