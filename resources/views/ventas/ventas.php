<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Ventas';
View::endSection('title');

View::section('content');
?>
<style>
    :root {
        --primary: #4A90E2;
        --secondary: #6c757d;
        --success: #28a745;
        --danger: #dc3545;
        --card-radius: 12px;
        --border-color: #e9ecef;
    }

    .sales-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 1.5rem;
        padding: 1.5rem;
        max-width: 1800px;
        margin: 0 auto;
    }

    .panel {
        background: white;
        border-radius: var(--card-radius);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .panel-header {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .panel-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .panel-title i {
        color: var(--primary);
    }

    .panel-body {
        padding: 1.25rem;
    }

    .search-container {
        position: relative;
        margin-bottom: 1rem;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }


    /* Agregar estos estilos nuevos */
    .product-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .product-category {
        font-size: 0.8rem;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .product-stock {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .product-stock.low-stock {
        color: var(--danger);
    }

    .btn-add-cart {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: #357abd;
    }

    .item-quantity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-quantity {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-quantity:hover {
        background: #f3f4f6;
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-remove {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: white;
        color: var(--danger);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-remove:hover {
        background: #fee2e2;
        border-color: var(--danger);
    }

    .cart-empty {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .cart-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--secondary);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .product-card {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .product-info {
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .product-price {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .product-stock {
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .cart-panel {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 7rem);
        position: sticky;
        top: 1.5rem;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .item-price {
        color: var(--primary);
        font-size: 0.9rem;
    }

    .quantity-input {
        width: 70px;
        text-align: center;
        padding: 0.25rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }

    .cart-summary {
        padding: 1.25rem;
        border-top: 1px solid var(--border-color);
        background: #f8fafc;
        border-radius: 0 0 var(--card-radius) var(--card-radius);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .summary-row:last-child {
        margin-bottom: 1.25rem;
    }

    .summary-label {
        color: var(--secondary);
    }

    .summary-value {
        font-weight: 600;
    }

    .total-row {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
    }

    .no-results {
        text-align: center;
        padding: 2rem;
        color: var(--secondary);
        font-size: 1.1rem;
    }

    .discount-input {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Estilo para mostrar que no hay items en el carrito */
    .cart-items:empty::before {
        content: 'No hay productos en el carrito';
        display: block;
        text-align: center;
        padding: 2rem;
        color: var(--secondary);
    }

    .btn-primary-ventas {
        background: var(--primary);
        border: none;
        padding: 0.75rem 1.5rem;
        color: white;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary-ventas:hover {
        background: #357abd;
        transform: translateY(-1px);
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        background: #f8fafc;
        color: var(--danger);
    }

    @media (max-width: 1200px) {
        .sales-container {
            grid-template-columns: 1fr;
        }

        .cart-panel {
            height: auto;
            position: static;
        }
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }
</style>

<div class="sales-container">
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <i class="fas fa-box"></i>
                Productos Disponibles
            </h2>
        </div>
        <div class="panel-body">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Buscar productos...">
            </div>
            <div class="product-grid" id="productGrid">

            </div>
        </div>
    </div>
    <div class="cart-panel panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <i class="fas fa-shopping-cart"></i>
                Carrito de Venta
            </h2>
        </div>
        <div class="cart-items" id="selectedProductsContainer">

        </div>
        <div class="cart-summary">
            <div class="summary-row">
                <span class="summary-label">Subtotal</span>
                <span class="summary-value" id="subtotal">$0.00</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Descuento</span>
                <div class="discount-input">
                    <input type="number" id="discountInput" class="quantity-input" min="0" max="100" value="0">
                    <span class="summary-label">%</span>
                </div>
            </div>
            <div class="summary-row total-row">
                <span>Total</span>
                <span id="total">$0.00</span>
            </div>
            <button class="btn-primary-ventas" onclick="realizarVenta()">
                <i class="fas fa-check-circle"></i>
                Completar Venta
            </button>
        </div>
    </div>
    <template id="productTemplate">
    <div class="product-card">
        <div class="product-info">
            <div class="product-name">{nombre}</div>
            <div class="product-price">${precio}</div>
            <div class="product-stock">
                <i class="fas fa-layer-group"></i>
                Stock: {stock}
            </div>
        </div>
        <button class="btn-primary-ventas" onclick="agregarProducto({id})">
            <i class="fas fa-plus"></i>
            Agregar
        </button>
    </div>
</template>

<template id="cartItemTemplate">
    <div class="cart-item">
        <div class="item-details">
            <div class="item-name">{nombre}</div>
            <div class="item-price">${precio}</div>
        </div>
        <input type="number" class="quantity-input" value="{cantidad}"
            min="1" onchange="actualizarCantidad({id}, this.value)">
        <button class="btn-icon" onclick="eliminarProducto({id})">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</template>
</div>



<?php View::endSection('content');

View::section('scripts');
?>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    let productos = [];
    let productosSeleccionados = [];

    $(document).ready(function() {
        // Inicializar la búsqueda
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            buscarProductos(this.value);
        });

        // Inicializar el input de descuento
        const discountInput = document.getElementById('discountInput');
        discountInput.addEventListener('input', calcularTotal);

        // Mostrar mensaje inicial en el grid de productos
        document.getElementById('productGrid').innerHTML =
            '<div class="no-results">Ingrese al menos 4 caracteres para buscar productos.</div>';
    });

    function buscarProductos(value) {
        const productGrid = document.getElementById('productGrid');

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
                        productGrid.innerHTML = '<div class="no-results">No se encontraron productos.</div>';
                    }
                },
                error: function(error) {
                    console.error('Error en la petición AJAX:', error);
                    productGrid.innerHTML = '<div class="no-results">Error al buscar productos.</div>';
                }
            });
        } else {
            productGrid.innerHTML = '<div class="no-results">Ingrese al menos 4 caracteres para buscar.</div>';
        }
    }

    function verificarStock(producto, cantidad) {
        if (cantidad > producto.stock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stock insuficiente',
                text: `Solo hay ${producto.stock} unidades disponibles de ${producto.nombre}`
            });
            return false;
        }
        return true;
    }

    function renderProducts(products) {
        const productGrid = document.getElementById('productGrid');
        productGrid.innerHTML = '';

        if (!products || products.length === 0) {
            productGrid.innerHTML = `
            <div class="no-results">
                <i class="fas fa-search"></i>
                <p>No se encontraron productos</p>
            </div>
        `;
            return;
        }

        products.forEach(product => {
            productGrid.innerHTML += getProductTemplate(product);
        });
    }

    function actualizarTablaProductos() {
        const container = document.getElementById('selectedProductsContainer');

        if (productosSeleccionados.length === 0) {
            container.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>No hay productos en el carrito</p>
            </div>
        `;
            return;
        }

        container.innerHTML = productosSeleccionados.map(item =>
            getCartItemTemplate(item)
        ).join('');
    }

    function createElementFromTemplate(template, data) {
        const html = template
            .replace(/{(\w+)}/g, (match, key) => data[key] || '');
        const div = document.createElement('div');
        div.innerHTML = html.trim();
        return div.firstChild;
    }

    function getProductTemplate(product) {
        return `
        <div class="product-card">
            <div class="product-info">
                <div class="product-category">${product.categoria?.nombre || 'Sin categoría'}</div>
                <div class="product-name">${product.nombre}</div>
                <div class="product-price">$${parseFloat(product.precio).toFixed(2)}</div>
                <div class="product-stock ${product.stock < 5 ? 'low-stock' : ''}">
                    <i class="fas fa-layer-group"></i>
                    Stock: ${product.stock} unidades
                </div>
            </div>
            <button class="btn-add-cart" onclick="agregarProducto(${product.id})">
                <i class="fas fa-plus"></i>
                Agregar al carrito
            </button>
        </div>
    `;
    }


    function getCartItemTemplate(item) {
        return `
        <div class="cart-item">
            <div class="item-details">
                <div class="item-name">${item.nombre}</div>
                <div class="item-price">$${parseFloat(item.precio).toFixed(2)}</div>
            </div>
            <div class="item-quantity">
                <button class="btn-quantity" onclick="actualizarCantidad(${item.id}, ${item.cantidad - 1})">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="number" class="quantity-input" value="${item.cantidad}"
                       min="1" max="${item.stock}" 
                       onchange="actualizarCantidad(${item.id}, this.value)">
                <button class="btn-quantity" onclick="actualizarCantidad(${item.id}, ${item.cantidad + 1})">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <button class="btn-remove" onclick="eliminarProducto(${item.id})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    }

    function agregarProducto(id) {
        const producto = productos.find(p => p.id === id);
        if (!producto) return;

        const productoExistente = productosSeleccionados.find(p => p.id === id);
        const nuevaCantidad = productoExistente ? productoExistente.cantidad + 1 : 1;

        if (!verificarStock(producto, nuevaCantidad)) return;

        if (productoExistente) {
            productoExistente.cantidad = nuevaCantidad;
        } else {
            productosSeleccionados.push({
                ...producto,
                cantidad: 1
            });
        }

        actualizarTablaProductos();
        calcularTotal();

        // Mostrar notificación de éxito
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: 'Producto agregado al carrito'
        });
    }



    function actualizarCantidad(id, cantidad) {
        const producto = productosSeleccionados.find(p => p.id === id);
        if (!producto) return;

        cantidad = parseInt(cantidad) || 1;
        cantidad = Math.max(1, cantidad); // Asegurar que la cantidad sea al menos 1

        if (!verificarStock(producto, cantidad)) {
            actualizarTablaProductos();
            return;
        }

        producto.cantidad = cantidad;
        actualizarTablaProductos();
        calcularTotal();
    }

    function eliminarProducto(id) {
        productosSeleccionados = productosSeleccionados.filter(p => p.id !== id);
        actualizarTablaProductos();
        calcularTotal();
    }

    function calcularTotal() {
        const subtotal = productosSeleccionados.reduce((sum, p) => {
            return sum + (parseFloat(p.precio) * p.cantidad);
        }, 0);

        const descuento = Math.min(100, Math.max(0, parseFloat($('#discountInput').val()) || 0));
        $('#discountInput').val(descuento); // Normalizar el valor en el input

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

    function mostrarMensajeVentaExitosa() {
        Swal.fire({
            icon: 'success',
            title: 'Venta realizada',
            text: 'La venta ha sido procesada con éxito.'
        });
    }
</script>

<?php View::endSection('scripts'); ?>