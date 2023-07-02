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
        return $res;
        if (!$res || empty($res)) {
            return $res;
        } else {
            $claveDb = $res[0]['clave'];
            $adminId = $res[0]['id'];
            $nombre = $res[0]['nombre'];
            $nickname = $res[0]['nickname'];
            $correo = $res[0]['correo'];
            $telefono = $res[0]['telefono'];
            $habilitado = $res[0]['habilitado'];
            $idPlan = $res[0]['idPlan'];

            if ($habilitado) {
                if ($clave != '' && password_verify(sha1($clave), $claveDb)) {

                    $_SESSION['SesionAdmin'] = array(
                        'gimnasioId' => $adminId,
                        'plan' => $idPlan,
                        'nombre' => $nombre,
                        'correo' => $correo,
                        'telefono' => $telefono,
                        'nickName' => $nickname,
                    );

                    return true;
                }
            } else {
                return 800;
            }
        }

        return false;
    }
}
