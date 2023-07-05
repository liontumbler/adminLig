<?php
namespace App\DB;

use App\DB\Database;

class ConsultasDB
{
    private $cn;
    public function __construct()
    {
        //date_default_timezone_set("America/Bogota");
        $this->cn = new Database(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
    }

    public function test()
    {
        return $this->cn->test();
        //return 'hola mundo'.env('DB_HOST').''.env('DB_USERNAME').''.env('DB_PASSWORD').''.env('DB_DATABASE');
    }

    public function obtenerHorasLigasPorId(string $id)
    {
        $horaliga = $this->cn->read('horaliga', ['id' => $id], '`id`=:id', 'precio, horas');
        if (!empty($horaliga)) {
            return $horaliga[0];
        } else {
            return false;
        }
    }

    public function planLiga(string $plan, string $gimnasio)
    {
        $queryliga = $this->cn->read(
            'ligas',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio AND `fechaInicio` >= '.date('Y-m-01').' 00:00:00 AND `fechaInicio` <= '.date('Y-m-t').' 23:59:59',
            'COUNT(idGimnasio) AS Total'
        );
        return $queryliga;
        $countliga = 0;
        if (!empty($queryliga)) {
            $countliga = (int) $queryliga[0]['Total'];
        }


        $countPlanliga = $this->cn->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'ligas'
        )[0]['ligas'];

        if ($countliga <= $countPlanliga) {
            return true;
        }else{
            return false;
        }
    }

    public function obtenerTrabajadorNickname(string $trabajador)
    {
        //$sms = new EnvioSMSLM(USERSMS, KEY);
        //$sms->saldo()->credits;
        //return $sms->preciosXPais();
        $res = $this->cn->read(
            'trabajador',
            ['nickname' => $trabajador],
            'nickname=:nickname',
            'clave, id, idGimnasio, nombresYapellidos, nickname, correo, telefono'
        );
        if (!empty($res)) {
            return $res[0];
        }else{
            return false;
        }
    }

    public function obtenerAdminNickname(string $nickname)
    {
        $res = $this->cn->read(
            'gimnasio',
            ['nickname' => $nickname],
            'nickname=:nickname',
            'clave, id, nombre, nickname, correo, telefono, habilitado, idPlan'
        );
        if (!empty($res)) {
            return $res[0];
        }else{
            return false;
        }
    }

    public function obtenerGimnasioPorIdBasic(string $id)
    {
        $res = $this->cn->read('gimnasio', ['id' => $id], 'id=:id', 'habilitado, nombre, idPlan');
        if (!empty($res)) {
            return $res[0];
        }else{
            return false;
        }
    }

    public function obtenerTrabajadoTrabajador(string $gimnasio, string $trabajador)
    {
        $res = $this->cn->read(
            'trabajado',
            ['idGimnasio' => $gimnasio, 'idTrabajador' => $trabajador],
            "`idGimnasio`=:idGimnasio
            AND `idTrabajador`=:idTrabajador
            AND fechaFin is null;",
            'id, iniciCaja'
        );
        if (!empty($res)) {
            return $res[0];
        }else{
            return false;
        }
    }

    public function crearTrabajado(string $caja, string $gimnasio, string $trabajador)
    {
        $trabajado = [
            'iniciCaja' => $caja,
            'idGimnasio' => $gimnasio,
            'idTrabajador' => $trabajador,
        ];
        return $this->cn->create('trabajado', $trabajado);
    }

    public function crearCliente(array $data, string $gimnasio)
    {
        $cliente = [
            'nombresYapellidos' => $data['nombreYapellido'],
            'correo' => !empty($data['correo']) ? $data['correo'] : null,
            'telefono' => !empty($data['telefono']) ? $data['telefono'] : null,
            'documento' => !empty($data['documento']) ? $data['documento'] : null,
            'idEquipo' => !empty($data['equipo'])? $data['equipo'] : null,
            'idGimnasio' => $gimnasio
        ];

        return $this->cn->create('cliente', $cliente);
    }

    public function actualizarCaja(string $trabajador, string $medio)
    {
        $claveCajaNueva = rand(1000, 9999);
        $mj = 'AdminLig: El codigo para ingresar a la su caja el dia hoy '.date('Y-m-d H:i:s').' es '.$claveCajaNueva;

        if (is_numeric($medio)) {
            return 1;
            $sms = new EnvioSMSLM(USERSMS, KEY);
            $smsRes = $sms->enviarSMS($mj, $medio);
            if ($smsRes->code == '0') {
                $this->cn->update('trabajador', ['claveCaja' => $claveCajaNueva], $trabajador);
                return 1;
            }elseif ($smsRes->code == '403') {
                return 403;
            }elseif ($smsRes->code == '35') {
                return 35;
            }
        } else {
            //actualizar clave de caja  claveCaja, enviar codigo por correo
            return 'correo';
        }
    }
}
?>
