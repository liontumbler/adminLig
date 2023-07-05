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
        $sesionTrabajador = session()->get('SesionTrabajador');
        return $this->db->obtenerAllClienteNombre($sesionTrabajador['gimnasioId']);
    }
}
