<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Cliente
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function cargarDatos() {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerClientes($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        //cambiar apenas el logueo
        return $this->db->obtenerClientes(1);
    }

    public function editarCliente($data) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerClientes($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->editarCliente($data);
    }

    public function crearCliente($data) {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerClientes($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->crearCliente($data);
    }

    public function eliminarCliente($id) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerClientes($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->eliminarCliente($id);
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
