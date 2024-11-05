<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Sistema de Ventas';
View::endSection('title');

View::section('content');
?>
<style>
    body {
        background-color: #f0f4f8;
        color: #333;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #e3f2fd;
        border-bottom: none;
        border-radius: 15px 15px 0 0;
    }

    .btn-primary {
        background-color: #4a90e2;
        border-color: #4a90e2;
    }

    .btn-primary:hover {
        background-color: #357abd;
        border-color: #357abd;
    }

    .selected-products {
        max-height: 300px;
        overflow-y: auto;
    }

    .table {
        color: #333;
    }

    .form-control:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
    }
</style>

<h2 class="h3 mb-4 text-gray-800 text-center">Sistema de Ventas</h2>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 text-primary">Productos Disponibles</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light"><i class="fas fa-search text-primary"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar productos...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="productTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 text-primary">Productos Seleccionados</h5>
                </div>
                <div class="card-body selected-products">
                    <table class="table table-sm" id="selectedProductsTable">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-primary">Resumen de Venta</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Descuento:</span>
                        <div>
                            <input type="number" id="discountInput" class="form-control form-control-sm" style="width: 80px;" min="0" max="100" value="0">
                            <small class="text-muted">%</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="total">$0.00</strong>
                    </div>
                    <button class="btn btn-primary w-100" onclick="realizarVenta()">Realizar Venta</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    let productos = [];
    let productosSeleccionados = [];

    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            buscarProductos($(this).val());
        });
        $('#discountInput').on('input', calcularTotal);
    });

    function buscarProductos(value) {
        if (value.length > 3) {
            $.ajax({
                url: '/productos/buscar',
                type: 'POST',
                data: {
                    nombre: value
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Productos encontrados:', response.productos);
                        productos = response.productos;
                        renderProducts(response.productos);
                    } else {
                        console.error('Error en la búsqueda:', response.message);
                        $('#productTable tbody').html('<tr><td colspan="5" class="text-center">No se encontraron productos.</td></tr>');
                    }
                },
                error: function(error) {
                    console.error('Error en la petición AJAX:', error);
                    $('#productTable tbody').html('<tr><td colspan="5" class="text-center">Error al buscar productos.</td></tr>');
                }
            });
        } else {
            $('#productTable tbody').html('<tr><td colspan="5" class="text-center">Ingrese al menos 4 caracteres para buscar.</td></tr>');
        }
    }

    function renderProducts(products) {
        const productTableBody = $('#productTable tbody');
        productTableBody.empty();

        if (products.length === 0) {
            productTableBody.html('<tr><td colspan="5" class="text-center">No se encontraron productos.</td></tr>');
            return;
        }

        products.forEach(product => {
            const row = `
                <tr>
                    <td>${product.nombre}</td>
                    <td>$${parseFloat(product.precio).toFixed(2)}</td>
                    <td>${product.stock}</td>
                    <td>${product.categoria.nombre}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="agregarProducto(${product.id})">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </td>
                </tr>
            `;
            productTableBody.append(row);
        });
    }


    function agregarProducto(id) {
        const producto = productos.find(p => p.id === id);
        if (!producto) return;

        const productoExistente = productosSeleccionados.find(p => p.id === id);

        // Verificar que la cantidad seleccionada no supere el stock disponible
        if (productoExistente && productoExistente.cantidad >= producto.stock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock insuficiente',
                text: `No puedes agregar más unidades del producto ${producto.nombre}.`
            });
            return;
        }

        if (productoExistente) {
            productoExistente.cantidad++;
        } else {
            productosSeleccionados.push({
                ...producto,
                cantidad: 1
            });
        }

        actualizarTablaProductos();
        calcularTotal();
    }

    function actualizarTablaProductos() {
        const tabla = $('#selectedProductsTable tbody');
        tabla.empty();

        productosSeleccionados.forEach(producto => {
            const fila = `
            <tr>
                <td>${producto.nombre}</td>
                <td><input type="number" min="1" value="${producto.cantidad}" onchange="actualizarCantidad(${producto.id}, this.value)" class="form-control form-control-sm" style="width: 60px;"></td>
                <td>$${(parseFloat(producto.precio) * producto.cantidad).toFixed(2)}</td>
                <td><button class="btn btn-sm btn-outline-danger" onclick="eliminarProducto(${producto.id})"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
            tabla.append(fila);
        });
    }


    function actualizarCantidad(id, cantidad) {
        const producto = productosSeleccionados.find(p => p.id === id);
        if (producto) {
            cantidad = parseInt(cantidad);

            // Verificar que la nueva cantidad no supere el stock disponible
            if (cantidad > producto.stock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock insuficiente',
                    text: `No puedes seleccionar más unidades que el stock disponible (${producto.stock} unidades).`
                });
                actualizarTablaProductos(); // Restaurar a la cantidad anterior
                return;
            }

            producto.cantidad = cantidad;
            actualizarTablaProductos();
            calcularTotal();
        }
    }

    function eliminarProducto(id) {
        productosSeleccionados = productosSeleccionados.filter(p => p.id !== id);
        actualizarTablaProductos();
        calcularTotal();
    }

    function calcularTotal() {
        const subtotal = productosSeleccionados.reduce((sum, p) => sum + (parseFloat(p.precio) * p.cantidad), 0);
        const descuento = parseFloat($('#discountInput').val()) || 0;
        const total = subtotal * (1 - descuento / 100);
        $('#subtotal').text(`$${subtotal.toFixed(2)}`);
        $('#total').text(`$${total.toFixed(2)}`);
    }

    function realizarVenta() {
        if (productosSeleccionados.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No hay productos seleccionados para realizar la venta.'
            });
            return;
        }
        let stockExcedido = productosSeleccionados.some(producto => producto.cantidad > producto.stock);
        if (stockExcedido) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hay productos cuya cantidad seleccionada excede el stock disponible.'
            });
            return;
        }
        const venta = {
            productos: productosSeleccionados.map(producto => ({
                id: producto.id,
                cantidad: producto.cantidad
            })),
            subtotal: $('#subtotal').text(),
            descuento: $('#discountInput').val() + '%',
            total: $('#total').text()
        };

        console.log('Venta realizada:', venta);
        $.ajax({
            url: '/ventas/store',
            type: 'POST',
            data: {
                venta: JSON.stringify(venta)
            },
            success: function(response) {
                console.log('Venta realizada con éxito:', response.message);
                Swal.fire({
                    icon: 'success',
                    title: 'Venta realizada',
                    text: 'La venta ha sido procesada con éxito.',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                }).then(() => {
                    limpiarVenta();
                });

            },
            error: function(error) {
                console.error('Error en la petición AJAX:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la venta.'
                });
            }
        });


    }


    function limpiarVenta() {
        productosSeleccionados = [];
        actualizarTablaProductos();
        calcularTotal();
        $('#discountInput').val(0);
    }
    //mostrarMensajeVentaExitosa
    function mostrarMensajeVentaExitosa() {
        Swal.fire({
            icon: 'success',
            title: 'Venta realizada',
            text: 'La venta ha sido procesada con éxito.'
        });
    }
</script>

<?php
View::endSection('content');

View::section('scripts');
?>

<?php
View::endSection('scripts');
