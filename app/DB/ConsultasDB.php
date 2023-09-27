<?php
namespace App\DB;

use App\DB\Database;
use App\Mail\ClaveCajaMail;

use Illuminate\Support\Facades\Mail;

class ConsultasDB
{
    private $cn;
    public function __construct()
    {
        $this->cn = new Database();
    }

    /*CREAR*/
    public function crearLigas(array $data, string $gimnasio, string $trabajado, string $trabajador)
    {
        $ligas = [
            'total' => $data['total'],
            'tipoPago' => (empty($data['tipoPago']) ? 'debe': $data['tipoPago']),
            'fechaInicio' => !empty($data['fechaInicio']) ? $data['fechaInicio'] : null,
            'fechaFin' => !empty($data['fechaFin']) ? $data['fechaFin'] : null,
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $data['cliente']
        ];

        $res = $this->cn->create('ligas', $ligas);
        return ($res > 0) ? true : $res;
    }

    public function crearEquipo(array $data, string $gimnasio)
    {
        $equipo = [
            'nombre' => $data['nombre'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio
        ];

        $res = $this->cn->create('equipo', $equipo);
        return ($res > 0) ? true : $res;
    }

    public function crearDescuento(array $data, string $gimnasio, string $trabajador, string $trabajado)
    {
        $descuento = [
            'titulo' => $data['titulo'],
            'total' => $data['total'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador
        ];

        if (!empty($data['descripcion'])) {
            $descuento['descripcion'] = $data['descripcion'];
        }

        $res = $this->cn->create('descuento', $descuento);
        return ($res > 0) ? true : $res;
    }

    public function crearGimansio(array $data)
    {
        $gimnasio = [
            'correo' => $data['correo'],
            'nickname' => $data['nickname'],
            'nombre' => $data['nombre'],
            'clave' => password_hash(sha1($data['clave']), PASSWORD_BCRYPT, [
                'cost' => 11,
            ]),
            'telefono' => $data['telefono'],
            'idPlan' => $data['plan'],
            'fecha' => date('Y-m-d H:i:s')
        ];

        if (!empty($data['color'])) {
            $gimnasio['color'] = $data['color'];
        }

        if (!empty($data['background'])) {
            $gimnasio['background'] = $data['background'];
        }

        if (!empty($data['direccion'])) {
            $gimnasio['direccion'] = $data['direccion'];
        }

        if (!empty($data['descripcion'])) {
            $gimnasio['descripcion'] = $data['descripcion'];
        }

        if (!empty($data['habilitado'])) {
            $gimnasio['habilitado'] = $data['habilitado'];
        }

        if (!empty($data['minDeMasLiga'])) {
            $gimnasio['minDeMasLiga'] = $data['minDeMasLiga'];
        }

        $res = $this->cn->create('gimnasio', $gimnasio);
        return ($res > 0) ? true : $res;
    }

    public function crearPlan(array $data, string $gimnasio, string $trabajador, string $trabajado)
    {
        $descuento = [
            'nombre' => $data['nombre'],
        ];

        if (!empty($data['descripcion'])) {
            $descuento['descripcion'] = $data['descripcion'];
        }

        if (!empty($data['trabajadores'])) {
            $descuento['trabajadores'] = $data['trabajadores'];
        }

        if (!empty($data['numCampHora'])) {
            $descuento['numCampHora'] = $data['numCampHora'];
        }

        if (!empty($data['ligas'])) {
            $descuento['ligas'] = $data['ligas'];
        }

        if (!empty($data['tienda'])) {
            $descuento['tienda'] = $data['tienda'];
        }

        if (!empty($data['pagos'])) {
            $descuento['pagos'] = $data['pagos'];
        }

        if (!empty($data['productos'])) {
            $descuento['productos'] = $data['productos'];
        }

        if (!empty($data['descuentos'])) {
            $descuento['descuentos'] = $data['descuentos'];
        }

        if (!empty($data['equipos'])) {
            $descuento['equipos'] = $data['equipos'];
        }

        $res = $this->cn->create('descuento', $descuento);
        return ($res > 0) ? true : $res;
    }

    public function crearHoraLiga(array $data, string $gimnasio)
    {
        $horaliga = [
            'nombre' => $data['nombre'],
            'horas' => $data['horas'],
            'precio' => $data['precio'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio
        ];

        $res = $this->cn->create('horaliga', $horaliga);
        return ($res > 0) ? true : $res;
    }

    public function crearListaPagos(array $data)
    {
        $listapagos = [
            'pago' => $data['pago'],
            'id' => $data['id'],
            'idPagos' => $data['idPagos']
        ];

        $res = $this->cn->create('listapagos', $listapagos);
        return ($res > 0) ? true : $res;
    }

    public function crearPagos(array $data, string $gimnasio, string $trabajador, string $trabajado)
    {
        $pagos = [
            'tipoPago' => $data['tipoPago'],
            'total' => $data['total'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $data['cliente']
        ];

        if (!empty($data['descripcion'])) {
            $pagos['descripcion'] = $data['descripcion'];
        }

        $res = $this->cn->create('pagos', $pagos);
        return ($res > 0) ? true : $res;
    }

    public function crearProducto(array $data, string $gimnasio)
    {
        $producto = [
            'nombre' => $data['nombre'],
            'precio' => $data['precio'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio
        ];

        if (!empty($data['descripcion'])) {
            $producto['descripcion'] = $data['descripcion'];
        }

        $res = $this->cn->create('producto', $producto);
        return ($res > 0) ? true : $res;
    }

    public function crearTienda(array $data, string $gimnasio, string $trabajador, string $trabajado)
    {
        $tienda = [
            'cantidad' => $data['cantidad'],
            'total' => $data['total'],
            'tipoPago' => $data['tipoPago'],
            'idProducto' => $data['producto'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $data['cliente']
        ];

        $res = $this->cn->create('tienda', $tienda);
        return ($res > 0) ? true : $res;
    }

    public function crearTrabajador(array $data, string $gimnasio)
    {
        $trabajador = [
            'nombresYapellidos' => $data['nombresYapellidos'],
            'nickname' => $data['nickname'],
            'correo' => $data['correo'],
            'documento' => $data['documento'],
            'clave' => password_hash(sha1($data['clave']), PASSWORD_BCRYPT, [
                'cost' => 11,
            ]),
            'idGimnasio' => $gimnasio,
        ];

        if (!empty($data['telefono'])) {
            $trabajador['telefono'] = $data['telefono'];
        }

        if (!empty($data['claveCaja'])) {
            $trabajador['claveCaja'] = $data['claveCaja'];
        }

        $res = $this->cn->create('trabajador', $trabajador);
        return ($res > 0) ? true : $res;
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
            'idGimnasio' => $gimnasio
        ];

        if (!empty($data['correo'])) {
            $cliente['correo'] = $data['correo'];
        }

        if (!empty($data['telefono'])) {
            $cliente['telefono'] = $data['telefono'];
        }

        if (!empty($data['documento'])) {
            $cliente['documento'] = $data['documento'];
        }

        if (!empty($data['equipo'])) {
            $cliente['idEquipo'] = $data['equipo'];
        }

        return $this->cn->create('cliente', $cliente);
    }
    /*CREAR*/

























    /*VER*/
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
            '`idGimnasio`=:idGimnasio AND `fechaInicio` >= "'.date('Y-m-01').' 00:00:00" AND `fechaInicio` <= "'.date('Y-m-t').' 23:59:59"',
            'COUNT(idGimnasio) AS Total'
        );
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

    public function obtenerDatosMuestraGimnasio($gimnasio) {
        $petition = $this->cn->read('gimnasio', ['id' => $gimnasio], '`id`=:id', 'nombre, background, color');
        if (!empty($petition)) {
            return $petition[0];
        } else {
            return false;
        }
    }

    public function obtenerDatosMuestraTrabajador($trabajador) {
        $petition = $this->cn->read('trabajador', ['id' => $trabajador], '`id`=:id', 'nombresYapellidos');
        if (!empty($petition)) {
            return $petition[0];
        } else {
            return false;
        }
    }

    public function minDeMasLiga(string $gimnasio)
    {
        $petition = $this->cn->read('gimnasio', ['id' => $gimnasio], '`id`=:id', 'minDeMasLiga');
        if (!empty($petition)) {
            return $petition[0]['minDeMasLiga'];
        } else {
            return false;
        }
    }

    public function obtenerAllClienteNombre(string $gimnasio)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        $petition = $this->cn->read('cliente', $array, $consulta, 'id, nombresYapellidos');
        if (!empty($petition)) {
            return $petition;
        } else {
            return false;
        }
    }

    public function obtenerAllEquipoNombre(string $gimnasio)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        $petition = $this->cn->read('equipo', $array, $consulta, 'id, nombre');
        if (!empty($petition)) {
            return $petition;
        } else {
            return false;
        }
    }

    public function obtenerAllHoraligaNombre(string $gimnasio)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        $petition = $this->cn->read('horaliga', $array, $consulta, 'id, nombre');
        if (!empty($petition)) {
            return $petition;
        } else {
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

    public function obtenerDescuentosSelect(string $gimnasio = null)
    {
        $array = [];
        $consulta = '';
        if (!empty($gimnasio)) {
            $array = ['id' => $gimnasio];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'gimnasio',
            $array,
            $consulta,
            'id, nombre'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function obtenerDescuentos(string $gimnasio, string $id = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'descuento',
            $array,
            $consulta,
            'id, titulo, descripcion, total, fecha, estado, idGimnasio, idTrabajado, idTrabajador'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function obtenerLigas(string $gimnasio, string $id = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->read(
            'ligas',
            $array,
            $consulta,
            'id, total, tipoPago, fechaInicio, fechaFin, idCliente, idTrabajador'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function obtenerGimnasios(string $id = null)
    {
        $array = [];
        $consulta = '';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->read(
            'gimnasio',
            $array,
            $consulta,
            'id, correo, nickname, nombre, color, background, direccion, telefono, descripcion, habilitado, minDeMasLiga, idPlan'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function obtenerTrabajadores(string $gimnasio, string $id = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'trabajador',
            $array,
            $consulta
        );
        if (!empty($res)) {
            return $res;
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
    /*VER*/



























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
            try {
                Mail::to($medio)
                ->send(new ClaveCajaMail($claveCajaNueva));
                $this->cn->update('trabajador', ['claveCaja' => $claveCajaNueva], $trabajador);
                return 1;
            } catch (\Exception $e) {
                \Log::error('Error al enviar el correo: ' . $e->getMessage());
                return 500;
            }
        }
    }
}
?>
