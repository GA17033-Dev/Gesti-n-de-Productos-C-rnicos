<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Listado de Roles - Tu Aplicación';
View::endSection('title');

View::section('content');
?>
<style>
    .table-group-divider tr td {
        border-top: 1px solid #dee2e6;
    }

    .table-group-divider tr:first-child td {
        border-top: 0;
    }

    .table-group-divider tr:last-child td {
        border-bottom: 0;
    }
</style>
<h1 class="h3 mb-4 text-gray-800 text-center">Listado de Roles</h1>
<div class="container-fluid">
    <div class="table table-bordered table-hover">
        <table id="users" class="table table-bordered table-hover mb-4 " style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<!--pintar los usuarios-->
<?php
View::endSection('content');

View::section('scripts');
?>

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
            "order": [
                [0, "desc"]
            ],
            "pageLength": 10,
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"]
            ],
            responsive: true,
            paginate: true,
        });
    });
</script>
<?php
View::endSection('scripts');
