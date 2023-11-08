<?php
namespace App\Models;

use App\DB\ConsultasDB;

class HoraLiga
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function cargarDatos() {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerHoraLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        //cambiar apenas el logueo
        return $this->db->obtenerHoraLigas(1);
    }

    public function crearHoraLiga($data) {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerHoraLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->crearHoraLiga($data);
    }

    public function editarHoraLiga($data) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerHoraLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->editarHoraLiga($data);
    }

    public function eliminarHoraLiga($id) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerHoraLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->eliminarHoraLiga($id);
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
