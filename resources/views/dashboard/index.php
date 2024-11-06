<?php
use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Dashboard - Administración';
View::endSection('title');

View::section('styles');
?>
<style>
    .dashboard-card {
        transition: transform 0.2s ease-in-out;
        height: 100%;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
    }
    
    .chart-container {
        position: relative;
        min-height: 300px;
        margin-bottom: 1rem;
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .summary-table td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    @media (max-width: 768px) {
        .stat-value {
            font-size: 2rem;
        }
        
        .chart-container {
            min-height: 250px;
        }
    }
</style>
<?php View::endSection('styles');

View::section('content');
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gray-800 text-center">Panel de Control</h1>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card dashboard-card stat-card text-white bg-primary h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="icon-box mb-3">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h5 class="card-title">Total Productos</h5>
                    <div class="stat-value" id="totalProductos">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card dashboard-card stat-card text-white bg-success h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="icon-box mb-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5 class="card-title">Total Usuarios</h5>
                    <div class="stat-value" id="totalUsuarios">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card dashboard-card stat-card text-white bg-warning h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="icon-box mb-3">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                    <h5 class="card-title">Total Ventas</h5>
                    <div class="stat-value" id="totalVentas">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card dashboard-card stat-card text-white bg-info h-100">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="icon-box mb-3">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h5 class="card-title">Ventas Última Semana</h5>
                    <div class="stat-value" id="ventasUltimaSemana">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="card dashboard-card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>Ventas Mensuales
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ventasMensualesChart"></canvas>
                        <div class="loading-overlay" id="loadingVentasMensuales">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-xl-6">
            <div class="card dashboard-card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Ventas por Categoría
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ventasPorCategoriaChart"></canvas>
                        <div class="loading-overlay" id="loadingVentasCategoria">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-xl-6">
            <div class="card dashboard-card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Productos Más Vendidos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="productosMasVendidosChart"></canvas>
                        <div class="loading-overlay" id="loadingProductos">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-xl-6">
            <div class="card dashboard-card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt me-2"></i>Resumen de Ventas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table summary-table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-dollar-sign fa-2x text-success me-3"></i>
                                            <div>
                                                <h6 class="mb-0">Monto Total Ventas</h6>
                                                <small class="text-muted">Ingresos totales del período</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end" id="montoTotalVentas">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-chart-line fa-2x text-primary me-3"></i>
                                            <div>
                                                <h6 class="mb-0">Promedio Venta Diaria</h6>
                                                <small class="text-muted">Promedio de ventas por día</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end" id="promedioVentaDiaria">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php View::endSection('content');

View::section('scripts');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let ventasMensualesChart;
    let ventasPorCategoriaChart;
    let productosMasVendidosChart;
    
    function formatCurrency(value) {
        return new Intl.NumberFormat('es-PE', {
            style: 'currency',
            currency: 'PEN'
        }).format(value);
    }
    
    function toggleLoadingOverlay(show) {
        const overlays = document.querySelectorAll('.loading-overlay');
        overlays.forEach(overlay => {
            overlay.style.display = show ? 'flex' : 'none';
        });
    }

    function initializeCharts() {
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                    }
                }
            }
        };

        // Ventas Mensuales Chart
        ventasMensualesChart = new Chart(document.getElementById('ventasMensualesChart'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Cantidad de Ventas',
                    borderColor: 'rgb(75, 192, 192)',
                    data: [],
                    fill: false,
                    tension: 0.4
                }, {
                    label: 'Monto de Ventas',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [],
                    fill: false,
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Ventas'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Monto de Ventas'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });

        // Ventas por Categoría Chart
        ventasPorCategoriaChart = new Chart(document.getElementById('ventasPorCategoriaChart'), {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ]
                }]
            },
            options: {
                ...commonOptions,
                cutout: '70%'
            }
        });

        // Productos Más Vendidos Chart
        productosMasVendidosChart = new Chart(document.getElementById('productosMasVendidosChart'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateCharts(data) {
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        // Actualizar Ventas Mensuales
        
        // Actualizar Ventas Mensuales
        const labels = data.ventasMensuales.map(item => meses[item.mes - 1]);
        const cantidades = data.ventasMensuales.map(item => item.total);
        const montos = data.ventasMensuales.map(item => item.monto);

        ventasMensualesChart.data.labels = labels;
        ventasMensualesChart.data.datasets[0].data = cantidades;
        ventasMensualesChart.data.datasets[1].data = montos;
        ventasMensualesChart.update();

        // Actualizar Ventas por Categoría
        ventasPorCategoriaChart.data.labels = data.ventasPorCategoria.map(item => item.nombre);
        ventasPorCategoriaChart.data.datasets[0].data = data.ventasPorCategoria.map(item => item.total);
        ventasPorCategoriaChart.update();

        // Actualizar Productos Más Vendidos
        productosMasVendidosChart.data.labels = data.productosMasVendidos.map(item => 
            item.nombre.length > 20 ? item.nombre.substring(0, 20) + '...' : item.nombre
        );
        productosMasVendidosChart.data.datasets[0].data = data.productosMasVendidos.map(item => item.total_vendido);
        productosMasVendidosChart.update();
    }

    function actualizarDatos() {
        toggleLoadingOverlay(true);
        
        $.ajax({
            url: '/obtener_totales',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    // Actualizar cards con animación
                    const cards = {
                        totalProductos: data.totalProductos,
                        totalUsuarios: data.totalUsuarios,
                        totalVentas: data.totalVentas,
                        ventasUltimaSemana: data.ventasUltimaSemana
                    };

                    Object.entries(cards).forEach(([id, value]) => {
                        const element = $(`#${id}`);
                        const currentValue = parseInt(element.text()) || 0;
                        $({ value: currentValue }).animate(
                            { value: value },
                            {
                                duration: 1000,
                                step: function(now) {
                                    element.text(Math.round(now));
                                }
                            }
                        );
                    });
                    
                    // Actualizar tabla de resumen con animación
                    $('#montoTotalVentas').html(`
                        <span class="text-success fw-bold">
                            ${formatCurrency(data.montoTotalVentas)}
                        </span>
                    `);
                    
                    $('#promedioVentaDiaria').html(`
                        <span class="text-primary fw-bold">
                            ${formatCurrency(data.promedioVentaDiaria)}
                        </span>
                    `);
                    
                    // Actualizar gráficos
                    updateCharts(data);
                    
                    // Mostrar mensaje de actualización
                    showToast('Datos actualizados correctamente');
                } else {
                    showError('Error al cargar los datos');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener datos:', error);
                showError('Error al cargar los datos');
            },
            complete: function() {
                toggleLoadingOverlay(false);
            }
        });
    }

    function showToast(message) {
        const toast = $(`
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <strong class="me-auto">Notificación</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(toast);
        const toastElement = new bootstrap.Toast(toast.find('.toast')[0]);
        toastElement.show();
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    function showError(message) {
        const alert = $(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        
        $('.container-fluid').prepend(alert);
        
        setTimeout(() => {
            alert.alert('close');
        }, 5000);
    }

    // Inicializar cuando el documento esté listo
    $(document).ready(function() {
        initializeCharts();
        actualizarDatos();
        
        // Actualizar datos cada 30 segundos
        setInterval(actualizarDatos, 30000);
        
        // Añadir tooltip a los iconos de actualización
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

<?php View::endSection('scripts'); ?>