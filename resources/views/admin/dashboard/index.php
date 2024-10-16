<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Dashboard - Tu Aplicación';
View::endSection('title');

View::section('content');
?>

<h1 class="h3 mb-4 text-gray-800 text-center">Dashboard</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Productos</div>
                <div class="card-body">
                    <h5 class="card-title" id="totalProductos">Cargando...</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title" id="totalUsuarios">Cargando...</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Ventas</div>
                <div class="card-body">
                    <h5 class="card-title" id="totalVentas">Cargando...</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para obtener los totales desde el servidor
    function obtenerTotales() {
        fetch('/dashboard/obtener_totales')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('totalProductos').innerText = data.total_productos;
                    document.getElementById('totalUsuarios').innerText = data.total_usuarios;
                    document.getElementById('totalVentas').innerText = data.total_ventas;
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error al obtener los totales:', error);
            });
    }

    // Llamar a obtenerTotales cada 5 segundos (5000 ms)
    setInterval(obtenerTotales, 5000);

    // Llamada inicial para cargar los datos al cargar la página
    obtenerTotales();
</script>

<?php
View::endSection('content');
