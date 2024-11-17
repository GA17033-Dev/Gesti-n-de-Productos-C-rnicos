<?php
use App\Lib\View;

View::extends('layout/layout');
View::section('title');
echo 'Gestión de Usuarios';
View::endSection('title');

View::section('content');
?>
<style>
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .table-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
    }

    .table thead th {
        background-color: #f8f9fa;
        border: none;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 15px;
    }

    .table th {
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .badge {
        padding: 0.5em 0.75em;
    }

    .list-unstyled li:last-child {
        margin-bottom: 0 !important;
    }

    .btn-action {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-edit {
        background-color: #3498db;
        border: none;
        color: white;
    }

    .btn-edit:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    .modal-content {
        border: none;
        border-radius: 15px;
    }

    .modal-header {
        border-bottom: 1px solid #f1f1f1;
        padding: 20px 25px;
    }

    .modal-body {
        padding: 25px;
    }

    .form-label {
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #f1f1f1;
        padding: 20px 25px;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-secondary {
        background-color: #f8f9fa;
        border: none;
        color: #6c757d;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .page-item.active .page-link {
        background-color: #3498db;
        border-color: #3498db;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h4 text-gray-800 mb-0">Gestión de ventas</h1>
            <p class="text-muted mb-0">Listado de ventas realizadas</p>
        </div>
    </div>

    <div class="card table-container">
        <table id="users" class="table table-hover table-borderless align-middle">
            <thead class="bg-light">
                <tr class="table-primary text-dark">
                    <th class="fw-semibold">Usuario</th>
                    <th class="fw-semibold">Número de venta</th>
                    <th class="fw-semibold">Productos</th>
                    <th class="fw-semibold">Descuento</th>
                    <th class="fw-semibold">Total de venta</th>
                    <th class="fw-semibold">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td>
                            <?php if (isset($venta['usuario']) && $venta['usuario']): ?>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <?= strtoupper(substr($venta['usuario']->nombre ?? '', 0, 1)) ?>
                                    </div>
                                    <div class="ms-2">
                                        <span class="fw-medium">
                                            <?= htmlspecialchars($venta['usuario']->nombre ?? '') ?> 
                                            <?= htmlspecialchars($venta['usuario']->apellido ?? '') ?>
                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Usuario no disponible</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                <?= htmlspecialchars($venta['numero_venta'] ?? 'N/A') ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($venta['detalle_venta'])): ?>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($venta['detalle_venta'] as $detalle): ?>
                                        <li class="mb-1">
                                            <?php if (isset($detalle['producto']) && $detalle['producto']): ?>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-box me-2"></i>
                                                    <span class="me-2">
                                                        <?= htmlspecialchars($detalle['producto']->nombre ?? 'Producto sin nombre') ?>
                                                    </span>
                                                    <span class="badge bg-secondary">
                                                        <?= intval($detalle['cantidad']) ?> unidades
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    Producto no disponible - <?= intval($detalle['cantidad']) ?> unidades
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span class="badge bg-light text-dark">Sin detalles</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                <?= isset($venta['descuento']) ? number_format((float)$venta['descuento'], 1, '.', '') : '0' ?>%
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold text-success">
                                $<?= isset($venta['total_final']) ? number_format((float)$venta['total_final'], 2, '.', ',') : '0.00' ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-muted">
                                <?php 
                                try {
                                    echo isset($venta['fecha']) ? (new DateTime($venta['fecha']))->format('d/m/Y H:i') : 'Fecha no disponible';
                                } catch (Exception $e) {
                                    echo 'Fecha no disponible';
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php View::endSection('content'); ?>

<?php View::section('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#users').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "searchPlaceholder": "Buscar",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            "order": [[5, "desc"]],
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"]
            ],
            responsive: true,
            paginate: true,
        });
    });
</script>

<?php View::endSection('scripts'); ?>