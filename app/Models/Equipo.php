<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Equipo
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function cargarDatos() {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerEquipos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        //cambiar apenas el logueo
        return $this->db->obtenerEquipos(1);
    }

    public function editarEquipo($data) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerEquipos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->editarEquipo($data);
    }

    public function crearEquipo($data) {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerEquipos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->crearEquipo($data);
    }

    public function eliminarEquipo($id) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerEquipos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->eliminarEquipo($id);
    }

    public function selectEquipos() {
        if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerAllEquipoNombre($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }
    }

    public function crearEquipoF($data) {
        $this->db->crearEquipoF($data, $sesionTrabajador['gimnasioId']);
    }

}
