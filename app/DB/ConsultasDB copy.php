<?php
namespace App\DB;

use App\DB\Database;

class ConsultasDB
{
    private $cn;
    public function __construct()
    {
        //date_default_timezone_set("America/Bogota");
        //parent::__construct(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
        $this->cn = new Database(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
    }




    public function obtenerProductoPrecio(string $producto)
    {
        $producto = $this->read('producto', ['id' => $producto], '`id`=:id', 'precio');
        if (!empty($producto)) {
            return $producto[0]['precio'];
        } else {
            return 0;
        }
    }

    public function obtenerProductoNombre(string $producto)
    {
        $producto = $this->read('producto', ['id' => $producto], '`id`=:id', 'nombre');
        if (!empty($producto)) {
            return $producto[0]['nombre'];
        } else {
            return 0;
        }
    }

    public function obtenerHoraligaPorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? 'idGimnasio=:idGimnasio' : 'idGimnasio=:idGimnasio '.'`id`=:id';
        return $this->read('horaliga', $array, $consulta, 'id, nombre, horas, precio, fecha');
    }

    public function obtenerHoraligaNombrePorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? 'idGimnasio=:idGimnasio' : 'idGimnasio=:idGimnasio '.'`id`=:id';
        return $this->read('horaliga', $array, $consulta, 'id, nombre, precio');
    }

    public function obtenerProductoPorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? 'idGimnasio=:idGimnasio' : 'idGimnasio=:idGimnasio '.'`id`=:id';
        return $this->read('producto', $array, $consulta, 'id, nombre, precio, fecha, descripcion');
    }

    public function obtenerProductoNombrePorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? 'idGimnasio=:idGimnasio' : 'idGimnasio=:idGimnasio '.'`id`=:id';
        return $this->read('producto', $array, $consulta, 'id, nombre, precio');
    }

    public function obtenerClaveCajaPorId(string $id)
    {
        return $this->read('trabajador', ['id' => $id], '`id`=:id', 'claveCaja');
    }

    public function planTrabajadores(string $plan, string $gimnasio)
    {
        $countTrabajadores = $this->read(
            'trabajador',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanTrabajadores = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'trabajadores'
        )[0]['trabajadores'];

        if ($countTrabajadores <= $countPlanTrabajadores) {
            return true;
        }else{
            return false;
        }
    }

    public function planEquipos(string $plan, string $gimnasio)
    {
        $countEquipos = $this->read(
            'trabajador',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanEquipos = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'equipos'
        )[0]['equipos'];

        if ($countEquipos <= $countPlanEquipos) {
            return true;
        }else{
            return false;
        }
    }

    public function planHoraLiga(string $plan, string $gimnasio)
    {
        $countHoraliga = $this->read(
            'horaliga',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanHoraliga = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'numCampHora'
        )[0]['numCampHora'];

        if ($countHoraliga <= $countPlanHoraliga) {
            return true;
        }else{
            return false;
        }
    }

    public function planTienda(string $plan, string $gimnasio)
    {
        $countTienda = $this->read(
            'tienda',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio AND `fecha` >= '.date('Y-m-01').' 00:00:00 AND `fecha` <= '.date('Y-m-t').' 23:59:59',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanTienda = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'tienda'
        )[0]['tienda'];

        if ($countTienda <= $countPlanTienda) {
            return true;
        }else{
            return false;
        }
    }

    public function planPagos(string $plan, string $gimnasio)
    {
        $countPagos = $this->read(
            'pagos',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio AND `fecha` >= '.date('Y-m-01').' 00:00:00 AND `fecha` <= '.date('Y-m-t').' 23:59:59',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanPagos = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'pagos'
        )[0]['pagos'];

        if ($countPagos <= $countPlanPagos) {
            return true;
        }else{
            return false;
        }
    }

    public function planProducto(string $plan, string $gimnasio)
    {
        $countProductos = $this->read(
            'producto',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanProductos = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'productos'
        )[0]['productos'];

        if ($countProductos <= $countPlanProductos) {
            return true;
        }else{
            return false;
        }
    }

    public function planDescuento(string $plan, string $gimnasio)
    {
        $countDescuento = $this->read(
            'descuento',
            ['idGimnasio' => $gimnasio],
            '`idGimnasio`=:idGimnasio AND `fecha` >= '.date('Y-m-01').' 00:00:00 AND `fecha` <= '.date('Y-m-t').' 23:59:59',
            'COUNT(idGimnasio) AS Total'
        )[0]['Total'];

        $countPlanDescuento = $this->read(
            'plan',
            ['id' => $plan],
            '`id`=:id',
            'descuentos'
        )[0]['descuentos'];

        if ($countDescuento <= $countPlanDescuento) {
            return true;
        }else{
            return false;
        }
    }

    public function obtenerGimnasioPorId(string $id)
    {
        return $this->read('gimnasio', ['id' => $id], '`id`=:id', 'id, correo, nickname, nombre, color, background, direccion, telefono, descripcion, habilitado, minDeMasLiga, idPlan');
    }

    /*public function obtenerTrabajadoPorId(stringg $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : '`id`=:id';
        return $this->read('trabajado', $array, $consulta);
    }

    public function obtenerClientePorId(stringg $id = null)
    {
        $array = empty($id) ? [] : ['id' => $id];
        $consulta = empty($id) ? '' : '`id`=:id';
        return $this->read('cliente', $array, $consulta, 'id, nombresYapellidos, documento');
    }*/

    public function obtenerClienteNombrePorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? '`idGimnasio`=:idGimnasio' : '`idGimnasio`=:idGimnasio '.'`id`=:id';
        return $this->read('cliente', $array, $consulta, 'id, nombresYapellidos');
    }

    public function obtenerNombreClientePorId(string $id)
    {
        return $this->read('cliente', ['id' => $id], '`id`=:id', 'nombresYapellidos')[0]['nombresYapellidos'];
    }

    public function obtenerNombreProductoPorId(string $id)
    {
        return $this->read('producto', ['id' => $id], '`id`=:id', 'nombre')[0]['nombre'];
    }

    public function obtenerNombreTrabajadorPorId(string $id)
    {
        return $this->read('trabajador', ['id' => $id], '`id`=:id', 'nombresYapellidos')[0]['nombresYapellidos'];
    }

    public function obtenerEquiposPorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? '`idGimnasio`=:idGimnasio' : '`idGimnasio`=:idGimnasio '.'`id`=:id';
        return $this->read('equipo', $array, $consulta, 'id, nombre, fecha');
    }

    public function obtenerEquiposNombrePorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? '`idGimnasio`=:idGimnasio' : '`idGimnasio`=:idGimnasio '.'`id`=:id';
        return $this->read('equipo', $array, $consulta, 'id, nombre');
    }



    public function obtenerClienteId(array $arr, string $cadena)
    {
        return $this->read('cliente', $arr, $cadena, 'id');
    }

    public function obtenerTiendaDefault(string $cliente)
    {
        return $this->read(
            'tienda',
            ['idCliente' => $cliente, 'tipoPago' => 'debe'],
            '`idCliente`=:idCliente AND `tipoPago`=:tipoPago',
            'id, fecha, tipoPago, idProducto, total, cantidad'
        );
    }

    public function obtenerTiendas(object $dta)
    {
        $array = array();
        $cadena = '';
        if (!empty($dta->cliente)) {
            $array['idCliente'] = $dta->cliente;
            $cadena .= '`idCliente`=:idCliente ';
        }

        if (!empty($dta->Trabajador)) {
            $array['idTrabajador'] = $dta->Trabajador;
            if (empty($cadena)) {
                $cadena = '`idTrabajador`=:idTrabajador ';
            } else {
                $cadena .= 'AND `idTrabajador`=:idTrabajador ';
            }
        }

        if (!empty($dta->Producto)) {
            $array['idProducto'] = $dta->Producto;
            if (empty($cadena)) {
                $cadena = '`idProducto`=:idProducto ';
            } else {
                $cadena .= 'AND `idProducto`=:idProducto ';
            }
        }

        if (!empty($dta->tipoPago)) {
            $array['tipoPago'] = $dta->tipoPago;
            if (empty($cadena)) {
                $cadena = '`tipoPago`=:tipoPago ';
            } else {
                $cadena .= 'AND `tipoPago`=:tipoPago ';
            }
        }

        if (!empty($dta->desde)) {
            $array['fecha'] = $dta->desde;
            if (empty($cadena)) {
                $cadena = '`fecha`>=:fecha ';
            } else {
                $cadena .= 'AND `fecha`>=:fecha ';
            }
        }

        if (!empty($dta->hasta)) {
            $array['fechah'] = $dta->hasta;
            if (empty($cadena)) {
                $cadena = '`fecha`<=:fechah ';
            } else {
                $cadena .= 'AND `fecha`<=:fechah ';
            }
        }

        //return $array;
        //return $cadena;

        return $this->read(
            'tienda',
            $array,
            $cadena,
            'id, cantidad, total, tipoPago, fecha, idProducto, idCliente, idTrabajador'
        );
    }

    public function obtenerLigas(object $dta)
    {
        $array = array();
        $cadena = '';
        if (!empty($dta->cliente)) {
            $array['idCliente'] = $dta->cliente;
            $cadena .= '`idCliente`=:idCliente ';
        }

        if (!empty($dta->Trabajador)) {
            $array['idTrabajador'] = $dta->Trabajador;
            if (empty($cadena)) {
                $cadena = '`idTrabajador`=:idTrabajador ';
            } else {
                $cadena .= 'AND `idTrabajador`=:idTrabajador ';
            }
        }

        if (!empty($dta->tipoPago)) {
            $array['tipoPago'] = $dta->tipoPago;
            if (empty($cadena)) {
                $cadena = '`tipoPago`=:tipoPago ';
            } else {
                $cadena .= 'AND `tipoPago`=:tipoPago ';
            }
        }

        if (!empty($dta->desde)) {
            $array['fechaInicio'] = $dta->desde;
            if (empty($cadena)) {
                $cadena = '`fechaInicio`>=:fechaInicio ';
            } else {
                $cadena .= 'AND `fechaInicio`>=:fechaInicio ';
            }
        }

        if (!empty($dta->hasta)) {
            $array['fechaHasta'] = $dta->hasta;
            if (empty($cadena)) {
                $cadena = '`fechaInicio`<=:fechaHasta ';
            } else {
                $cadena .= 'AND `fechaInicio`<=:fechaHasta ';
            }
        }

        //return $array;
        //return $cadena;

        return $this->read(
            'ligas',
            $array,
            $cadena,
            'id, total, tipoPago, fechaInicio, fechaFin, idCliente, idTrabajador'
        );
    }

    public function obtenerLigaDefault(string $cliente)
    {
        return $this->read(
            'ligas',
            ['idCliente' => $cliente, 'tipoPago' => 'debe'],
            '`idCliente`=:idCliente AND `tipoPago`=:tipoPago',
            'id, fechaInicio, tipoPago, total'
        );
    }

    public function obtenerLigaTrabajado(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado ORDER BY `ligas`.`fechaInicio` DESC',
            'id, fechaInicio, total, idCliente, fechaFin, tipoPago'
        );
    }

    public function obtenerLigaTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerLigaTrabajadoDebeTotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "debe"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerLigaTrabajadoPagoETotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "efectivo"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerLigaTrabajadoPagoDTotal(string $trabajado)
    {
        return $this->read(
            'ligas',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "digital"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoDebeTotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "debe"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoPagoETotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "efectivo"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerTiendaTrabajadoPagoDTotal(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "digital"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerPagosTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerPagosTrabajadoPagoETotal(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "efectivo"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerPagosTrabajadoPagoDTotal(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado AND tipoPago = "digital"',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerDescuentoTrabajadoTotal(string $trabajado)
    {
        return $this->read(
            'descuento',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'SUM(total) AS Total'
        )[0]['Total'];
    }

    public function obtenerDescuentoTrabajado(string $trabajado)
    {
        return $this->read(
            'descuento',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'id, titulo, descripcion, total, fecha'
        );
    }

    public function obtenerCajaTrabajado(string $trabajado)
    {
        $consulta = $this->read(
            'trabajado',
            ['id' => $trabajado],
            "`id`=:id",
            'iniciCaja'
        );

        return isset($consulta[0]['iniciCaja']) ? $consulta[0]['iniciCaja'] : null;
    }

    public function obtenerColorGimnasio(string $gimnasio)
    {
        return $this->read(
            'gimnasio',
            ['id' => $gimnasio],
            "`id`=:id",
            'color'
        )[0]['color'];
    }

    public function obtenerBackgroundGimnasio(string $gimnasio)
    {
        return $this->read(
            'gimnasio',
            ['id' => $gimnasio],
            "`id`=:id",
            'background'
        )[0]['background'];
    }

    public function obtenerPagosTrabajado(string $trabajado)
    {
        return $this->read(
            'pagos',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'id, tipoPago, total, descripcion, fecha, idCliente'
        );
    }

    public function obtenerLigaPorId(string $id)
    {
        return $this->read(
            'ligas',
            ['id' => $id],
            '`id`=:id',
            'id, fechaInicio, total, idCliente, fechaFin, tipoPago'
        );
    }

    public function obtenerTiendaPorId(string $id)
    {
        return $this->read(
            'tienda',
            ['id' => $id],
            '`id`=:id',
            'id, cantidad, total, tipoPago, idProducto, idCliente, fecha'
        );
    }

    public function obtenerTiendaTrabajado(string $trabajado)
    {
        return $this->read(
            'tienda',
            ['idTrabajado' => $trabajado],
            '`idTrabajado`=:idTrabajado',
            'id, cantidad, total, tipoPago, idProducto, idCliente, fecha'
        );
    }

    public function obtenerListaPagosId(string $id)
    {
        return $this->read(
            'listapagos',
            ['idPagos' => $id],
            '`idPagos`=:idPagos',
            'id, pago, idPagos'
        );
    }













    public function obtenerTrabajadorNombrePorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? '`idGimnasio`=:idGimnasio' : '`idGimnasio`=:idGimnasio '.'`id`=:id';
        return $this->read('trabajador', $array, $consulta, 'id, nombresYapellidos');
    }

    public function obtenerTrabajadorPorId(string $gimnasio, string $id = null)
    {
        $array = empty($id) ? ['idGimnasio' => $gimnasio] : ['id' => $id, 'idGimnasio' => $gimnasio];
        $consulta = empty($id) ? '`idGimnasio`=:idGimnasio' : '`idGimnasio`=:idGimnasio '.'`id`=:id';
        return $this->read('trabajador', $array, $consulta, 'id, nombresYapellidos, nickname, correo, telefono, documento, claveCaja');
    }

    public function obtenerLigaHoy(string $trabajador)///
    {
        return $this->read(
            'ligas',
            ['idTrabajador' => $trabajador, ''],
            '`idTrabajador`=:idTrabajador AND `fechaInicio` >= '.date('Y-m-d').' 00:00:00 AND `fechaInicio` <= '.date('Y-m-d').' 23:59:59',
            'id, fechaInicio, fechaFin, tipoPago, total'
        );
    }

    public function obtenerTiendaHoy(string $trabajador)///
    {
        return $this->read(
            'tienda',
            ['idTrabajador' => $trabajador, ''],
            '`idTrabajador`=:idTrabajador AND `fecha` >= '.date('Y-m-d').' 00:00:00 AND `fecha` <= '.date('Y-m-d').' 23:59:59',
            'id, cantidad, fecha, tipoPago, total, idProducto'
        );
    }



    public function crearTienda(object $data, string $idCliente, string $total, string $gimnasio, string $trabajado, string $trabajador)
    {
        $tienda = [
            'cantidad' => $data->cantidad,
            'total' => $total,
            'tipoPago' => (empty($data->tipoPago) ? 'debe': $data->tipoPago),
            'idProducto' => $data->producto,
            'idGimnasio' => $gimnasio,
            'idTrabajado' => $trabajado,
            'idTrabajador' => $trabajador,
            'idCliente' => $idCliente
        ];
        $resTienda = $this->create('tienda', $tienda);
        return ($resTienda > 0);
    }

    public function crearPagos(array $pagos, string $gimnasio, string $trabajado, string $trabajador)
    {
        $pagos['descripcion'] = (!empty($pagos['descripcion'])) ? $pagos['descripcion'] : null;
        $pagos['idGimnasio'] = $gimnasio;
        $pagos['idTrabajado'] = $trabajado;
        $pagos['idTrabajador'] = $trabajador;
        $pago = $this->create('pagos', $pagos);
        return ($pago > 0);
    }

    public function crearListapagos(array $value)
    {
        return $this->create('listapagos', $value);
    }

    public function crearProducto(object $data, string $gimnasio)
    {
        $producto = [
            'nombre' => $data->nombre,
            'descripcion' => $data->descripcion,
            'precio' => $data->precio,
            'idGimnasio' => $gimnasio
        ];

        $producto = $this->create('producto', $producto);
        return ($producto > 0);
    }



    public function crearDescuento(object $data, string $gimnasio, string $trabajado, string $trabajador)
    {
        $descuento = [];
        $descuento['titulo'] = $data->titulo;
        $descuento['descripcion'] = (!empty($data->descripcion)) ? $data->descripcion : null;
        $descuento['total'] = $data->total;
        $descuento['idGimnasio'] = $gimnasio;
        $descuento['idTrabajado'] = $trabajado;
        $descuento['idTrabajador'] = $trabajador;

        $resDescuento = $this->create('descuento', $descuento);
        return ($resDescuento > 0);
    }

    public function crearHoraliga(object $data, string $gimnasio)
    {
        $horaliga = [];
        $horaliga['nombre'] = $data->nombre;
        $horaliga['precio'] = $data->precio;
        $horaliga['horas'] = $data->horas;
        $horaliga['fecha'] = date('Y-m-d H:i:s');
        $horaliga['idGimnasio'] = $gimnasio;
        $horaL = $this->create('horaliga', $horaliga);
        return ($horaL > 0);
    }

    public function crearPlan(object $data)
    {
        $plan = [];
        $plan['nombre'] = $data->nombre;
        $plan['descripcion'] = $data->descripcion;
        $plan['trabajadores'] = $data->trabajadores;
        $plan['numCampHora'] = $data->numCampHora;
        $plan['ligas'] = $data->ligas;
        $plan['tienda'] = $data->tienda;
        $plan['pagos'] = $data->pagos;
        $plan['productos'] = $data->productos;
        $plan['descuento'] = $data->graficas;
        $pl = $this->create('plan', $plan);
        return ($pl > 0);
    }

    public function crearEquipo(string $nombre, string $gimnasio)
    {
        $equipo = [];
        $equipo['nombre'] = $nombre;
        $equipo['idGimnasio'] = $gimnasio;
        $equi = $this->create('equipo', $equipo);
        return ($equi > 0);
    }

    public function crearGimnasio(object $data)
    {
        $gimnasio = [];
        $gimnasio['correo'] = $data->correo;
        $gimnasio['nickname'] = $data->nickname;
        $gimnasio['nombre'] = $data->nombre;
        $gimnasio['clave'] = $data->clave;
        $gimnasio['color'] = $data->color;
        $gimnasio['background'] = $data->background;
        $gimnasio['direccion'] = $data->direccion;
        $gimnasio['telefono'] = $data->telefono;
        $gimnasio['descripcion'] = $data->descripcion;
        $gimnasio['habilitado'] = $data->habilitado;
        $gimnasio['minDeMasLiga'] = $data->minDeMasLiga;
        $gimnasio['idPlan'] = $data->idPlan;
        $gim = $this->create('gimnasio', $gimnasio);
        return ($gim > 0);
    }

    public function crearTrabajador(object $data, string $gimnasio)
    {
        $trabajador = [];
        $trabajador['nombresYapellidos'] = $data->nombresYapellidos;
        $trabajador['nickname'] = $data->nickname;
        $trabajador['correo'] = $data->correo;
        $trabajador['telefono'] = $data->telefono;
        $trabajador['documento'] = $data->documento;
        $trabajador['clave'] = $data->clave;
        $trabajador['claveCaja'] = empty($data->claveCaja)? null : $data->claveCaja;
        $trabajador['idGimnasio'] = $gimnasio;
        $trabaj = $this->create('trabajador', $trabajador);

        $respuesta = false;
        if (($trabaj > 0)) {
            return true;
        }elseif (($trabaj == -1) || ($trabaj == -2)) {
            return $trabaj;
        }

        return $respuesta;
    }


    public function updateHoraLiga($data)
    {
        $horaLiga = [];
        $horaLiga['nombre'] = $data->nombreEdit;
        $horaLiga['fecha'] = date('Y-m-d H:i:s');
        $horaLiga['horas'] = $data->horasEdit;
        $horaLiga['precio'] = $data->precioEdit;
        $prod = $this->update('horaliga', $horaLiga, $data->id);
        return ($prod > 0);
    }

    public function updateConfiguracion(string $id, $data)
    {
        $gimnasio = [];
        $gimnasio['correo'] = $data->correo;
        $gimnasio['nombre'] = $data->nombre;
        $gimnasio['color'] = $data->color;
        $gimnasio['background'] = $data->background;
        $gimnasio['direccion'] = $data->direccion;
        $gimnasio['telefono'] = $data->telefono;
        $gimnasio['minDeMasLiga'] = $data->minDeMasLiga;
        $gimnasio['descripcion'] = $data->descripcion;
        if (!empty($data->clave)) {
            $gimnasio['clave'] = $data->clave;
        }

        $prod = $this->update('gimnasio', $gimnasio, $id);
        return ($prod > 0);
    }

    public function updateProducto($data)
    {
        $producto = [];
        $producto['nombre'] = $data->nombreEdit;
        $producto['fecha'] = date('Y-m-d H:i:s');
        $producto['descripcion'] = $data->descripcionEdit;
        $producto['precio'] = $data->precioEdit;
        $prod = $this->update('producto', $producto, $data->id);
        return ($prod > 0);
    }

    public function updateEquipo(string $id, string $nombre)
    {
        $equipo = [];
        $equipo['nombre'] = $nombre;
        $equipo['fecha'] = date('Y-m-d H:i:s');
        $equi = $this->update('equipo', $equipo, $id);
        return ($equi > 0);
    }

    public function updateTrabajador($data)
    {
        $trabajador = [];
        $trabajador['nombresYapellidos'] = $data->nombresYapellidosEdit;
        $trabajador['correo'] = $data->correoEdit;
        $trabajador['documento'] = $data->documentoEdit;

        if (empty($data->telefonoEdit)) {
            $data->telefonoEdit = null;
        }
        $trabajador['telefono'] = $data->telefonoEdit;

        if (empty($data->claveCajaEdit)) {
            $data->claveCajaEdit = null;
        }
        $trabajador['claveCaja'] = $data->claveCajaEdit;

        if (!empty($data->clave)) {
            $trabajador['clave'] = $data->clave;
        }

        $traba = $this->update('trabajador', $trabajador, $data->id);
        return ($traba > 0);
    }

    public function actualizarFinCaja($finCaja, $trabajado)
    {
        return $this->update('trabajado', ['finCaja' => $finCaja, 'fechaFin' => date('Y-m-d H:i:s')], $trabajado);
    }
    //$arr = ['nombresYapellidos' => "%{$nombre}%", 'documento' => $documento];
    //$cadena = '`documento`=:documento AND `nombresYapellidos`LIKE :nombresYapellidos';
}
?>
