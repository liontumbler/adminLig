<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Ligas
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function crearLigaTrabajador($data) {
        $sesionTrabajador = session()->get('SesionTrabajador');
        $vencimiento = $this->db->planLiga($sesionTrabajador['plan'], $sesionTrabajador['gimnasioId']);
        if ($vencimiento) {
            $hl = $this->db->obtenerHorasLigasPorId($data['selectHora']);
            $horas = $hl['horas'];
            $minutos = $this->db->minDeMasLiga($sesionTrabajador['gimnasioId']);
            if (strpos($horas, '.') !== false) {
                $partes = explode('.', $horas);
                $horas = $partes[0];
                $minutos += $partes[1] * 60 / pow(10, strlen($partes[1]));
            }

            if (empty($data['fechaInicio'] )) {
                $data['fechaInicio'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $minutos . ' minutes'));
                $data['fechaFin'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $horas . ' hours +' . $minutos . ' minutes'));
            } else {
                $data['fechaFin'] = date('Y-m-d H:i:s', strtotime($data['fechaInicio'] . ' +' . $horas . ' hours'));
            }

            session()->regenerate();
            $data['total'] = $hl['precio'];
            return $this->db->crearLigasTrabajador($data, $sesionTrabajador['gimnasioId'], $sesionTrabajador['trabajadoId'], $sesionTrabajador['trabajadorId']);
        } else {
            return 601;
        }
    }

    public function getLigas($id = null) {
        $sesionTrabajador = session()->get('SesionTrabajador');
        if (!empty($sesionTrabajador)) {
            return $this->db->obtenerLigas($sesionTrabajador['gimnasioId'], $id);
        } else {
            return 602;
        }
    }

    public function cargarDatos() {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        //cambiar apenas el logueo
        $sesionTrabajador = session()->get('SesionTrabajador');
        return $this->db->obtenerLigas($sesionTrabajador['gimnasioId']);
    }

    public function crearLiga($data) {
        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->crearLiga($data);
    }

    public function editarLiga($data) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->editarLiga($data);
    }

    public function eliminarLiga($id) {

        /*if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerLigas($sesionTrabajador['gimnasioId']);
        }else {
            return 602;
        }*/
        return $this->db->eliminarLiga($id);
    }





}
