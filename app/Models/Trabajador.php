<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Trabajador
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function loginTrabajador($data) {
        $res = $this->db->obtenerTrabajadorNickname($data['nickname']);
        if (empty($res)) {
            return $res;
        } else {
            $claveDb = $res['clave'];
            $idTrabajador = $res['id'];
            $idGimnasio = $res['idGimnasio'];
            $nombreTrabajador = $res['nombresYapellidos'];
            $nickname = $res['nickname'];
            $correo = $res['correo'];
            $telefono = $res['telefono'];

            $gimnasio = $this->db->obtenerGimnasioPorIdBasic($idGimnasio);

            $habilitado = $gimnasio['habilitado'];
            $nombreGim = $gimnasio['nombre'];
            $idPlan = $gimnasio['idPlan'];

            if ($habilitado) {
                if ($data['clave'] != '' && password_verify(sha1($data['clave']), $claveDb)) {
                    //si existe en registro en caja sin cerrar tomo la sesion que no a cerrado
                    $yaInicioCaja = $this->db->obtenerTrabajadoTrabajador($idGimnasio, $idTrabajador);//`fechaInicio` > '".date('Y-m-d')." 00:00:00' AND `fechaInicio` < '".date('Y-m-d')." 23:59:59'
                    //return $yaInicioCaja;
                    $ini = false;
                    $trabajadoId = '';
                    if (empty($yaInicioCaja)) {
                        $trabajado = [
                            'iniciCaja' => $data['caja'],
                            'idGimnasio' => $idGimnasio,
                            'idTrabajador' => $idTrabajador,
                        ];

                        $idInsert = $this->db->crearTrabajado($trabajado);
                        //return $idInsert;
                        if ($idInsert) {
                            $ini = true;
                            $work = $this->db->obtenerTrabajados($idGimnasio, null, $data['caja'], $idTrabajador);
                            $trabajadoId = $work[0]['id'];
                            //return $trabajadoId;
                        }
                    } else {//sesion ya iniciada
                        $trabajadoId = $yaInicioCaja['id'];
                        $ini = 600;
                    }

                    session()->regenerate();
                    session([
                        'SesionTrabajador' => array(
                            'trabajadorId' => $idTrabajador,
                            'nombre' => $nombreTrabajador,
                            'correo' => $correo,
                            'telefono' => $telefono,
                            'nickName' => $nickname,
                            'gimnasio' => $nombreGim,
                            'gimnasioId' => $idGimnasio,
                            'plan' => $idPlan,
                            'trabajadoId' => $trabajadoId
                        )
                    ]);

                    $medio = (!empty($telefono)) ? $telefono : $correo;
                    $updateTrabajador = $this->db->actualizarCaja($idTrabajador, $medio);
                    //return $updateTrabajador;
                    if ($updateTrabajador == 403) {
                        $ini = $updateTrabajador;
                    }elseif ($updateTrabajador == 35) {
                        $ini = $updateTrabajador;
                    }elseif ($updateTrabajador == 500) {
                        $ini = $updateTrabajador;
                    }

                    return $ini;
                }else{
                    return false;
                }
            } else {
                return 800;
            }
        }
    }

    public function cargadeVista() {
        if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            return $this->db->obtenerDatosMuestraTrabajador($sesionTrabajador['trabajadorId']);
        }else {
            return 602;
        }
    }

    public function getTrabajadores($id = null) {
        $sesionAdmin = session()->get('SesionAdmin');
        if (!empty($sesionAdmin)) {
            return $this->db->obtenerTrabajadores($sesionAdmin['gimnasioId'], $id);
        } else {
            return 602;
        }
    }

    public function selectTrabajador() {
        return $this->db->obtenerSelectTrabajador();
    }


}
