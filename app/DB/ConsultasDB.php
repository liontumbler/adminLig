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

    /*CRUD*/
    public function eliminarDescuento($id)
    {
        $res = $this->cn->delete('descuento', $id);
        return ($res == 1) ? true : $res;
    }

    public function crearDescuento($data)
    {
        //return $data;
        $array = [];
        $array['titulo'] = $data['titulo'];
        $array['total'] = $data['total'];
        $array['fecha'] = date('Y-m-d H:i:s');
        $array['idGimnasio'] = $data['idGimnasio'];
        $array['idTrabajado'] = $data['idTrabajado'];
        $array['idTrabajador'] = $data['idTrabajador'];
        $array['estado'] = $data['estado'];
        if (!empty($data['descripcion']))
            $array['descripcion'] = $data['descripcion'];

        $res = $this->cn->create('descuento', $array);
        return ($res > 0) ? true : $res;
    }

    public function editarDescuento($data)
    {
        $array = [];
        if (!empty($data['titulo']))
            $array['titulo'] = $data['titulo'];

        if (!empty($data['total']))
            $array['total'] = $data['total'];

        if (!empty($data['idGimnasio']))
            $array['idGimnasio'] = $data['idGimnasio'];

        if (!empty($data['idTrabajado']))
            $array['idTrabajado'] = $data['idTrabajado'];

        if (!empty($data['idTrabajador']))
            $array['idTrabajador'] = $data['idTrabajador'];

        if (!empty($data['descripcion']) || $data['descripcion'] == '')
            $array['descripcion'] = $data['descripcion'];

        if ($data['estado'] === false)
            $array['estado'] = 0;
        elseif ($data['estado'] === true) {
            $array['estado'] = 1;
        }

        return $this->cn->update('descuento', $array, $data['id']);
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

    public function eliminarCliente($id)
    {
        $res = $this->cn->delete('cliente', $id);
        return ($res == 1) ? true : $res;
    }

    public function crearCliente($data)//original
    {
        //return $data;
        $array = [];
        $array['nombresYapellidos'] = $data['nombresYapellidos'];
        $array['estado'] = $data['estado'];
        $array['idGimnasio'] = $data['idGimnasio'];

        if (!empty($data['correo']))
            $array['correo'] = $data['correo'];

        if (!empty($data['telefono']))
            $array['telefono'] = $data['telefono'];

        if (!empty($data['documento']))
            $array['documento'] = $data['documento'];

        if (!empty($data['idEquipo']))
            $array['idEquipo'] = $data['idEquipo'];

        $res = $this->cn->create('cliente', $array);
        return ($res > 0) ? true : $res;
    }

    public function editarCliente($data)
    {
        $array = [];
        if (!empty($data['correo']) || $data['correo'] == '')
            $array['correo'] = $data['correo'];

        if (!empty($data['telefono']) || $data['telefono'] == '')
            $array['telefono'] = $data['telefono'];

        if (!empty($data['nombresYapellidos']))
            $array['nombresYapellidos'] = $data['nombresYapellidos'];

        if (!empty($data['documento']) || $data['documento'] == '')
            $array['documento'] = $data['documento'];

        if ($data['estado'] === false)
            $array['estado'] = 0;
        elseif ($data['estado'] === true)
            $array['estado'] = 1;

        if (!empty($data['idGimnasio']))
            $array['idGimnasio'] = $data['idGimnasio'];

        if (!empty($data['idEquipo']) || $data['idEquipo'] == '')
            $array['idEquipo'] = $data['idEquipo'];

        return $this->cn->update('cliente', $array, $data['id']);
    }

    public function obtenerClientes(string $gimnasio, string $id = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'cliente',
            $array,
            $consulta,
            'id, correo, telefono, nombresYapellidos, documento, estado, idGimnasio, idEquipo'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function eliminarEquipo($id)
    {
        $res = $this->cn->delete('equipo', $id);
        return ($res == 1) ? true : $res;
    }

    public function crearEquipo($data)//original
    {
        //return $data;
        $array = [];
        $array['nombre'] = $data['nombre'];
        $array['fecha'] = date('Y-m-d H:i:s');
        $array['estado'] = $data['estado'];
        $array['idGimnasio'] = $data['idGimnasio'];

        $res = $this->cn->create('equipo', $array);
        return ($res > 0) ? true : $res;
    }

    public function editarEquipo($data)
    {
        $array = [];
        if (!empty($data['nombre']))
            $array['nombre'] = $data['nombre'];

        if ($data['estado'] === false)
            $array['estado'] = 0;
        elseif ($data['estado'] === true)
            $array['estado'] = 1;

        if (!empty($data['idGimnasio']))
            $array['idGimnasio'] = $data['idGimnasio'];

        return $this->cn->update('equipo', $array, $data['id']);
    }

    public function obtenerEquipos(string $gimnasio, string $id = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'equipo',
            $array,
            $consulta,
            'id, nombre, fecha, estado, idGimnasio'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function eliminarGimnasio($id)
    {
        $res = $this->cn->delete('gimnasio', $id);
        return ($res == 1) ? true : $res;
    }

    public function crearGimnasio($data)
    {
        //return $data;
        $array = [];
        $array['correo'] = $data['correo'];
        $array['nickname'] = $data['nickname'];
        $array['nombre'] = $data['nombre'];
        $array['clave'] = $data['clave'];
        $array['color'] = $data['color'];
        $array['background'] = $data['background'];
        $array['telefono'] = $data['telefono'];
        $array['habilitado'] = $data['habilitado'];
        $array['minDeMasLiga'] = $data['minDeMasLiga'];
        $array['superAdmin'] = $data['superAdmin'];
        $array['fecha'] = date('Y-m-d H:i:s');
        $array['estado'] = $data['estado'];
        $array['idPlan'] = $data['idPlan'];
        if (!empty($data['direccion']))
            $array['direccion'] = $data['direccion'];
        if (!empty($data['descripcion']))
            $array['descripcion'] = $data['descripcion'];

        $res = $this->cn->create('gimnasio', $array);
        return ($res > 0) ? true : $res;
    }

    public function editarGimnasio($data)
    {
        $array = [];
        if (!empty($data['correo']))
            $array['correo'] = $data['correo'];

        if (!empty($data['nickname']))
            $array['nickname'] = $data['nickname'];

        if (!empty($data['nombre']))
            $array['nombre'] = $data['nombre'];

        if (!empty($data['clave']))
            $array['clave'] = $data['clave'];

        if (!empty($data['color']))
            $array['color'] = $data['color'];

        if (!empty($data['background']))
            $array['background'] = $data['background'];

        if (!empty($data['telefono']))
            $array['telefono'] = $data['telefono'];

        if (!empty($data['habilitado']))
            $array['habilitado'] = $data['habilitado'];

        if (!empty($data['minDeMasLiga']))
            $array['minDeMasLiga'] = $data['minDeMasLiga'];

        if (!empty($data['superAdmin']))
            $array['superAdmin'] = $data['superAdmin'];

        if (!empty($data['fecha']))
            $array['fecha'] = $data['fecha'];

        if ($data['estado'] === false)
            $array['estado'] = 0;
        elseif ($data['estado'] === true)
            $array['estado'] = 1;

        if (!empty($data['idPlan']))
            $array['idPlan'] = $data['idPlan'];

        if (!empty($data['direccion']) || $data['direccion'] == '')
            $array['direccion'] = $data['direccion'];

        if (!empty($data['descripcion']) || $data['descripcion'] == '')
            $array['descripcion'] = $data['descripcion'];

        return $this->cn->update('gimnasio', $array, $data['id']);
    }

    public function obtenerGimnasios(string $id = null)
    {
        $array = [];
        $consulta = '';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'gimnasio',
            $array,
            $consulta,
            'id, correo, nickname, nombre, clave, color, background, direccion, telefono, descripcion, habilitado, minDeMasLiga, superAdmin, fecha, estado, idPlan'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function eliminarHoraLiga($id)
    {
        $res = $this->cn->delete('gimnasio', $id);
        return ($res == 1) ? true : $res;
    }

    public function crearHoraLiga($data)
    {
        //return $data;
        $array = [];
        $array['nombre'] = $data['nombre'];
        $array['horas'] = $data['horas'];
        $array['precio'] = $data['precio'];
        $array['estado'] = $data['estado'];
        $array['idGimnasio'] = $data['idGimnasio'];

        $res = $this->cn->create('horaliga', $array);
        return ($res > 0) ? true : $res;
    }

    public function editarHoraLiga($data)
    {
        $array = [];
        if (!empty($data['nombre']))
            $array['nombre'] = $data['nombre'];

        if (!empty($data['horas']))
            $array['horas'] = $data['horas'];

        if (!empty($data['precio']))
            $array['precio'] = $data['precio'];

        if ($data['estado'] === false)
            $array['estado'] = 0;
        elseif ($data['estado'] === true)
            $array['estado'] = 1;

        if (!empty($data['idGimnasio']))
            $array['idGimnasio'] = $data['idGimnasio'];

        return $this->cn->update('horaliga', $array, $data['id']);
    }

    public function obtenerHoraLigas(string $gimnasio, string $id = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array = ['id' => $id];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'horaliga',
            $array,
            $consulta,
            'id, nombre, horas, precio, fecha, estado, idGimnasio'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function eliminarTrabajado($id)
    {
        $res = $this->cn->delete('trabajado', $id);
        return ($res == 1) ? true : $res;
    }

    public function crearTrabajado($data)
    {
        //return $data;
        $array = [];
        $array['idTrabajador'] = $data['idTrabajador'];
        $array['fechaInicio'] = date('Y-m-d H:i:s');
        $array['iniciCaja'] = $data['iniciCaja'];
        $array['idGimnasio'] = $data['idGimnasio'];
        if (!empty($data['fechaFin']))
            $array['fechaFin'] = $data['fechaFin'];

        if (!empty($data['finCaja']))
            $array['finCaja'] = $data['finCaja'];

        $res = $this->cn->create('trabajado', $array);
        return ($res > 0) ? true : $res;
    }

    public function editarTrabajado($data)
    {
        $array = [];
        if (!empty($data['idTrabajador']))
            $array['idTrabajador'] = $data['idTrabajador'];

        if (!empty($data['fechaInicio']))
            $array['fechaInicio'] = $data['fechaInicio'];

        if (!empty($data['iniciCaja']))
            $array['iniciCaja'] = $data['iniciCaja'];

        if (!empty($data['idGimnasio']))
            $array['idGimnasio'] = $data['idGimnasio'];

        if (!empty($data['fechaFin']) || $data['fechaFin'] == '')
            $array['fechaFin'] = $data['fechaFin'];

        if (!empty($data['finCaja']) || $data['finCaja'] == '')
            $array['finCaja'] = $data['finCaja'];

        if ($data['estado'] === false)
            $array['estado'] = 0;
        elseif ($data['estado'] === true) {
            $array['estado'] = 1;
        }

        return $this->cn->update('trabajado', $array, $data['id']);
    }

    public function obtenerTrabajados(string $gimnasio, string $id = null, $iniciCaja = null, $idTrabajador = null)
    {
        $array = ['idGimnasio' => $gimnasio];
        $consulta = '`idGimnasio`=:idGimnasio';
        if (!empty($id)) {
            $array['id'] = $id;
            $consulta .= ' and id=:id';
        }

        if (!empty($iniciCaja)) {
            $array['iniciCaja'] = $iniciCaja;
            $consulta .= ' and iniciCaja=:iniciCaja';
        }

        if (!empty($idTrabajador)) {
            $array['idTrabajador'] = $idTrabajador;
            $consulta .= ' and idTrabajador=:idTrabajador';
        }
        $consulta .= " ORDER BY fechaInicio DESC";

        $res = $this->cn->read(
            'trabajado',
            $array,
            $consulta,
            'idTrabajador, fechaInicio, fechaFin, id, iniciCaja, finCaja, estado, idGimnasio'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }
    /*CRUD*/








































































































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

    public function crearEquipoF(array $data, string $gimnasio)
    {
        $equipo = [
            'nombre' => $data['nombre'],
            'fecha' => date('Y-m-d H:i:s'),
            'idGimnasio' => $gimnasio
        ];

        $res = $this->cn->create('equipo', $equipo);
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

    public function crearClienteF(array $data, string $gimnasio)
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
        $petition = $this->cn->read('horaliga', $array, $consulta, 'id, nombre, precio');
        if (!empty($petition)) {
            return $petition;
        } else {
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



    public function obtenerSelectTrabajador(string $trabajador = null)
    {
        $array = [];
        $consulta = '';
        if (!empty($trabajador)) {
            $array = ['id' => $trabajador];
            $consulta = 'id=:id';
        }
        $res = $this->cn->read(
            'trabajador',
            $array,
            $consulta,
            'id, nickname'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function obtenerSelectTrabajado(string $trabajador = null, string $trabajado = null)
    {
        $array = [];
        $consulta = '';
        if (!empty($trabajador)) {
            $array = ['idTrabajador' => $trabajador];
            $consulta = 'idTrabajador=:idTrabajador';
        }
        if (!empty($trabajado)) {
            $array = ['id' => $trabajado];
            $consulta = 'id=:id';
        }

        $res = $this->cn->read(
            'trabajado',
            $array,
            $consulta,
            'id, iniciCaja'
        );
        if (!empty($res)) {
            return $res;
        }else{
            return false;
        }
    }

    public function obtenerGimnasiosSelect(string $gimnasio = null)
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


    /*VER*/




























}
?>
