<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Ligas
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function crearLiga($data) {
        $sesionTrabajador = session()->get('SesionTrabajador');
        if (!empty($sesionTrabajador)) {
            $vencimiento = $this->db->planLiga($sesionTrabajador['plan'], $sesionTrabajador['gimnasioId']);
            if ($vencimiento) {
                $hl = $this->db->obtenerHorasLigasPorId($data['selectHora']);
                if (empty($data['cliente'])) {
                    $idCliente = $this->db->crearCliente($data, $sesionTrabajador['gimnasioId']);
                } else {
                    $idCliente = $data['cliente'];
                }

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

                if ($idCliente > 0) {
                    session()->regenerate();
                    $data['cliente'] = $idCliente;
                    $data['total'] = $hl['precio'];
                    return $this->db->crearLigas($data, $sesionTrabajador['gimnasioId'], $sesionTrabajador['trabajadoId'], $sesionTrabajador['trabajadorId']);
                } elseif ($idCliente == -1) {
                    return $idCliente;
                }

                return false;
            } else {
                return 601;
            }
        } else {
            return 602;
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





}
