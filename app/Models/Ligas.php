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
        $vencimiento = $this->db->planLiga($sesionTrabajador['plan'], $sesionTrabajador['gimnasioId']);
        if ($vencimiento) {
            $hl = $this->db->obtenerHorasLigasPorId($data['selectHora']);
            if (empty($data['cliente'])) {
                //verificar primero si existe para crearlo
                $idCliente = $this->db->crearCliente($data, $sesionTrabajador['gimnasioId']);
            } else {
                $idCliente = $data['cliente'];
            }
            return $idCliente;

            $horas = $hl['horas'];
            $minutos = $this->minDemas()['minDeMasLiga'];
            if (strpos($horas, '.') !== false) {
                $partes = explode('.', $horas);
                $horas = $partes[0];
                $minutos += $partes[1] * 60 / pow(10, strlen($partes[1]));
            }

            if (empty($data['fechaInicio'] )) {
                $fechaInicio = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $minutos . ' minutes'));
                $fechaFin = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +' . $horas . ' hours +' . $minutos . ' minutes'));
                $data['fechaInicio'] = $fechaInicio;
                $data['fechaFin'] = $fechaFin;
            } else {
                $fechaFin = date('Y-m-d H:i:s', strtotime($data['fechaInicio'] . ' +' . $horas . ' hours'));
                $data['fechaFin'] = $fechaFin;
            }

            if ($idCliente > 0) {
                return $this->crearLigas($data, $idCliente, $hl['precio'], $sesionTrabajador['gimnasioId'], $sesionTrabajador['trabajadoId'], $sesionTrabajador['trabajadorId']);
            } elseif ($idCliente == -1) {
                return $idCliente;
            }

            return false;
        } else {
            return 601;
        }
    }





}
