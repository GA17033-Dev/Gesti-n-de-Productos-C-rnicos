<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Dashboard - Administración';
View::endSection('title');

View::section('content');
?>
<h1 class="h3 mb-4 text-gray-800 text-center">Dashboard</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Productos</h5>
                    <h2 class="card-text text-center" id="totalProductos">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Usuarios</h5>
                    <h2 class="card-text text-center" id="totalUsuarios">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Ventas</h5>
                    <h2 class="card-text text-center" id="totalVentas">0</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
View::endSection('content');

View::section('scripts');
?>

<script>
    function actualizarDatos() {
        $.ajax({
            url: '/obtener_totales',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#totalProductos').text(data.totalProductos);
                $('#totalUsuarios').text(data.totalUsuarios);
                $('#totalVentas').text(data.totalVentas);
            }
        });
    }

    // Actualizar datos cada 5 segundos
    setInterval(actualizarDatos, 5000);

    // Cargar datos al inicio
    actualizarDatos();
</script>

<?php
View::endSection('scripts');
