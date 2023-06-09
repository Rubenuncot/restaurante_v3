<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Comanda;
use App\Models\LineasComanda;
use App\Models\Mesa;
use App\Models\MesaProducto;
use App\Models\Producto;
use App\Models\Restaurante;
use App\Models\Sala;
use App\Models\Ticket;
use App\Models\TipoProducto;
use App\Models\User;
use App\Models\Version;
use Illuminate\Http\Request;
/*
 * Objetos:
 * Sala, Mesa, Producto, MesaProducto, Comanda, Reserva,
 * LineaComanda, Usuario
 */

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'Para recibir datos use el método show. Ruta: http://localhost:8000/api/getResources/show',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $nuevaLinea = new LineasComanda();
        $nuevaLinea->id = $request->id;
        $nuevaLinea->idMesa = $request->idMesa;
        $nuevaLinea->idTrabajador = $request->idTrabajador;
        $nuevaLinea->cantidad = $request->cantidad;
        $nuevaLinea->idProducto = $request->idProducto;
        $nuevaLinea->enviado = 1;

        $nuevaLinea->save();

        return response()->json([
            'message' => 'Linea creada correctamente.',
            'info' => 'Datos enviados: id = ' . $request->id . ', idMesa = ' . $request->idMesa . ', trabajador = ' . $request->idTrabajador
            . ', cantidad = ' . $request->cantidad . ', idProducto = ' . $request->idProducto
        ]);
    }

    /**
     * 1-salas
     * 2-mesas
     * 3-productos
     * 4-comandas
     * 5-usuarios (con la imagen del qr codificada en UTF-8)
     * 6-mesasProducto
     * 7-lineasComanda
     * 8-reservas
     * 9-restaurante
     * 10-tipo
     * 11-ticket
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        /* Variables */
        $usuariosQr = [];

        switch ($request->type){
            case 0:
                $version = Version::all();
                return response()->json([
                    'version'=> $version,
                ]);
            case 1:
                $salas = Sala::all();
                return response()->json([
                    'salas'=> $salas,
                ]);
            case 2:
                $mesas = Mesa::all();
                return response()->json([
                    'mesas' => $mesas,
                ]);
            case 3:
                $productos = Producto::all();
                return response()->json([
                    'productos' => $productos,
                ]);
            case 4:
                $comandas = Comanda::all();
                return response()->json([
                    'comandas' => $comandas,
                ]);
            case 5:
                $usuarios = User::all();
                $usuariosQr = $this->getArr($usuarios, $usuariosQr);
                return response()->json([
                    'usuarios' => $usuariosQr,
                ]);
            case 6:
                $mesaProducto = MesaProducto::all();
                return response()->json([
                    'mesasProductos' => $mesaProducto,
                ]);
            case 7:
                $lineasComanda = LineasComanda::all();
                return response()->json([
                    'lineaComanda' => $lineasComanda
                ]);
            case 8:
                $reservas = Reserva::all();
                return response()->json([
                    'reservas' => $reservas
                ]);
            case 9:
                $restaurante = Restaurante::all();
                return response()->json([
                    'restaurante' => $restaurante
                ]);
            case 10:
                $tipo = TipoProducto::all();
                return response()->json([
                    'tipoProductos' => $tipo
                ]);
            case 11:
                $ticket = Ticket::all();
                return response()->json([
                    'tickets' => $ticket
                ]);
            default:
                $salas = Sala::all();
                $mesas = Mesa::all();
                $productos = Producto::all();
                $comandas = Comanda::all();
                $usuarios = User::all();
                $mesaProducto = MesaProducto::all();
                $lineasComanda = LineasComanda::all();
                $reservas = Reserva::all();
                $restaurante = Restaurante::all();
                $tipo = TipoProductos::all();
                $ticket = Ticket::all();

                $usuariosQr = $this->getArr($usuarios, $usuariosQr);
                return response()->json([
                    'salas'=> $salas,
                    'mesas' => $mesas,
                    'productos' => $productos,
                    'comandas' => $comandas,
                    'usuarios' => $usuariosQr,
                    'mesasProductos' => $mesaProducto,
                    'lineaComandas' => $lineasComanda,
                    'reservas' => $reservas,
                    'restaurante' => $restaurante,
                    'tipoProductos' => $tipo,
                    'tickets' => $ticket
                ]);
        }
    }
    /**
     * Update the specified resource in storage.
     * @throws \Throwable
     */
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $success = false;


        switch ($request->type){
            case 1:
                $type = 'LineaComanda';
                if(LineasComanda::where('id', $request->id)->first()->updateOrFail([$request->param => $request->value]) > 0) $success = true;
                break;
            case 2:
                $type = 'Mesa';
                if(Mesa::where('id', $request->id)->first()->updateOrFail([$request->param => $request->value]) > 0) $success = true;
        }


        if($success){
            return response()->json([
                'message' => 'Elemento con id ' . $request->id . ' actualizado correctamente de la tabla ' . $type . '. Elementos actualizados: ' . $request->param . ' : ' . $request->value
            ]);
        } else {
            return response()->json([
                'message' => 'No ha sido posible actualizar el elemento ' . $request->id . ' de la tabla ' . $type
            ]);
        }
    }

    /**
     * Se hace delete del registro en cuestion dependiendo
     * del tipo de dato, se hace en una tabla o en otra distinta.
     *
     * Tipos:
     * 1-Comandas
     * 2-lineasComanda
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $success = false;
        $tipo = 'LineaComanda';
        if(LineasComanda::destroy($request->id) > 0) $success = true;

        if($success){
            return response()->json([
                'message' => 'Elemento con id ' . $request->id . ' eliminado correctamente de la tabla ' . $tipo
            ]);
        } else {
            return response()->json([
                'message' => 'No se ha podido borrar el elemento con id ' . $request->id . ' de la tabla ' . $tipo
            ]);
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $usuarios
     * @param array $usuariosQr
     * @return array
     */
    public function getArr(\Illuminate\Database\Eloquent\Collection $usuarios, array $usuariosQr): array
    {
        foreach ($usuarios as $usuario) {
            $qr_data = $usuario->imagenQr;
            $usuarioArr = array(
                'id' => $usuario->id,
                'name' => $usuario->name,
                'apellidos' => $usuario->apellidos,
                'telefono' => $usuario->telefono,
                'dni' => $usuario->dni,
                'rol' => $usuario->idRol,
                'email' => $usuario->email,
                'codigoQr' => $usuario->codigoQr,
                'imagenQr' => utf8_encode($qr_data)
            );

            $usuariosQr[] = $usuarioArr;
        }
        return $usuariosQr;
    }
}
