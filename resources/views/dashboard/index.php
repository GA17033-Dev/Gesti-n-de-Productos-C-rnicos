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
        <!-- Columna izquierda para los cards del dashboard -->
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        <i class="bi bi-box"></i> Total Productos
                    </h5>
                    <h2 class="card-text text-center" id="totalProductos">Cargando...</h2>
                </div>
            </div>
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        <i class="bi bi-person-fill"></i> Total Usuarios
                    </h5>
                    <h2 class="card-text text-center" id="totalUsuarios">Cargando...</h2>
                </div>
            </div>
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        <i class="bi bi-cart"></i> Total Ventas
                    </h5>
                    <h2 class="card-text text-center" id="totalVentas">Cargando...</h2>
                </div>
            </div>
        </div>

        <!-- Columna derecha para el gráfico -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Gráfico de Totales</h5>
                    <!-- Contenedor con alto fijo para el gráfico -->
                    <div style="height: 300px;">
                        <canvas id="graficoTotales"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
View::endSection('content');

View::section('scripts');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de incluir jQuery -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Incluye Chart.js -->
<!-- Incluir Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    function actualizarDatos() {
        $.ajax({
            url: '/obtener_totales',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Actualizar los valores en los cards
                $('#totalProductos').text(data.totalProductos);
                $('#totalUsuarios').text(data.totalUsuarios);
                $('#totalVentas').text(data.totalVentas);

                // Crear o actualizar el gráfico con los nuevos datos
                actualizarGrafico(data.totalProductos, data.totalVentas);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener datos: ', error);
                alert('Ocurrió un error al obtener los datos.'); // Mensaje de error para el usuario
            }
        });
    }

    // Función para actualizar el gráfico con los datos obtenidos
    function actualizarGrafico(totalProductos, totalVentas) {
        var ctx = document.getElementById('graficoTotales').getContext('2d');
        
        // Si el gráfico ya existe, lo destruye y crea uno nuevo con los datos actualizados
        if (window.grafico) {
            window.grafico.destroy();
        }

        window.grafico = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: ['Ventas', 'Productos'], // Eje X
                datasets: [{
                    data: [totalVentas, totalProductos], // Datos para el eje Y
                    backgroundColor: ['#ffcc00', '#007bff'], // Colores para las barras
                    borderColor: ['#e6b800', '#0069d9'], // Colores de los bordes
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Hacemos que el gráfico sea responsivo
                maintainAspectRatio: false, // Permite que el gráfico se ajuste al tamaño del contenedor
                scales: {
                    y: {
                        beginAtZero: true, // El eje Y empieza en 0
                        title: {
                            display: true,
                            text: 'Cantidad' // Título del eje Y
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Categorías' // Título del eje X
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false, // Ocultamos la leyenda
                    }
                }
            }
        });
    }

    // Llamar a la función al cargar la página
    $(document).ready(function() {
        actualizarDatos(); // Inicializa la carga de datos

        // Actualizar datos cada 10 segundos
        setInterval(actualizarDatos, 10000);
    });
</script>

<?php
View::endSection('scripts');
