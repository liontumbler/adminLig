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
        //cambiar apenas el logueo
        return $this->db->obtenerDescuentos(1);
    }

    public function crearDescuento($data) {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerDescuentos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->crearDescuento($data);
    }

    public function editarDescuento($data) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerDescuentos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->editarDescuento($data);
    }

    public function eliminarDescuento($id) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerDescuentos($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->eliminarDescuento($id);
    }


}
