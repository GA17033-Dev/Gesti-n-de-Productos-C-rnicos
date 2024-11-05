<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\DetalleVenta;
use App\Lib\Functions;
use App\Lib\Response;
use Exception;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        return $this->render('ventas/ventas');
    }

    //store

    public function store()
    {
        try {
            // Decode the JSON string from POST data
            $ventaData = json_decode($_POST['venta'], true);
            if (!$ventaData) {
                throw new Exception('Error al decodificar los datos de la venta');
            }

            // Parse the monetary values (remove $ symbol and convert to float)
            $subtotal = (float) str_replace(['$', ','], '', $ventaData['subtotal']);
            $total = (float) str_replace(['$', ','], '', $ventaData['total']);
            $descuento = (float) str_replace('%', '', $ventaData['descuento']);


            // Create new sale
            $venta = new Venta([
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'total_final' => $total,
                'id_usuario' => $_SESSION['user_id'] ?? null,
                'fecha' => date('Y-m-d H:i:s'),
                'numero_venta' => Functions::generateRandomString(8),
                'estado' => 1
            ]);

            if (!$venta->save()) {
                throw new Exception('Error al guardar la venta');
            }

            // Process each product
            foreach ($ventaData['productos'] as $producto) {
                $productoDb = Producto::find($producto['id']);

                if (!$productoDb) {
                    throw new Exception('Producto no encontrado: ID ' . $producto['id']);
                }

                // Validate stock
                if ($productoDb->stock < $producto['cantidad']) {
                    throw new Exception('Stock insuficiente para el producto: ' . $productoDb->nombre);
                }

                // Create sale detail
                $detalleVenta = new DetalleVenta([
                    'id_venta' => $venta->id,
                    'id_producto' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $productoDb->precio,
                    'subtotal' => $productoDb->precio * $producto['cantidad']
                ]);

                if (!$detalleVenta->save()) {
                    throw new Exception('Error al guardar el detalle de la venta');
                }

                // Update product stock
                $productoDb->stock -= $producto['cantidad'];

                if (!$productoDb->save()) {
                    throw new Exception('Error al actualizar el stock del producto');
                }
            }


            return Response::json([
                'success' => true,
                'message' => 'Venta realizada con éxito',
                'data' => [
                    'venta_id' => $venta->id,
                    'numero_venta' => $venta->numero_venta
                ]
            ]);
        } catch (Exception $e) {

            return Response::json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 500);
        }
    }
}
