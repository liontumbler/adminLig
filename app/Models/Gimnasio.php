<?php
namespace App\Models;

use App\DB\ConsultasDB;

class Gimnasio
{
    private $db;
    function __construct() {
        $this->db = new ConsultasDB();
    }

    public function loginAdmin($data) {

        $res = $this->db->obtenerAdminNickname($data['nickname']);
        //return 'bien'.print_r($res).'$res';
        if (empty($res)) {
            return $res;
        } else {
            $claveDb = $res['clave'];
            $adminId = $res['id'];
            $nombre = $res['nombre'];
            $nickname = $res['nickname'];
            $correo = $res['correo'];
            $telefono = $res['telefono'];
            $habilitado = $res['habilitado'];
            $idPlan = $res['idPlan'];

            if ($habilitado) {
                if (!empty($data['clave']) && password_verify(sha1($data['clave']), $claveDb)) {
                    session()->regenerate();
                    session([
                        'SesionAdmin' => array(
                            'gimnasioId' => $adminId,
                            'plan' => $idPlan,
                            'nombre' => $nombre,
                            'correo' => $correo,
                            'telefono' => $telefono,
                            'nickName' => $nickname,
                        )
                    ]);

                    return true;
                }else{
                    return false;
                }
            } else {
                return 800;
            }
        }

        return 'no entro a nada';
    }

    public function cargadeVista() {
        $sesionTrabajador = session()->get('SesionTrabajador');
        return $this->db->obtenerDatosMuestraGimnasio($sesionTrabajador['gimnasioId']);
    }
}
