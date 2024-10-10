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
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0" data-bs-toggle="modal" data-bs-target="#addRoleModal" title="Agregar Rol">
                <i class="fas fa-plus icon"></i> Agregar Rol
            </button>
        </div>
    </div>
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
                <?php foreach ($roles as $role) : ?>
                    <tr>
                        <td data-label="Nombre"><?= $role['nombre'] ?></td>
                        <td data-label="Descripcion"><?= $role['descripcion'] ?></td>
                        <td data-label="Estado"><?= $role['estado'] == 1 ? '<span class="badge bg-success"><i class="fas fa-check"></i> Activo</span>' : '<span class="badge bg-danger"><i class="fas fa-times"></i> Inactivo</span>' ?></td>
                        <td data-label="Acciones">
                            <button class="btn btn-sm btn-primary" href="#"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" href="#"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
<!--crear modal-->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Agregar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre del Rol">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required placeholder="Descripcion del Rol"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="addRole()">Guardar</button>
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

    function addRole() {
        let nombre = $('#nombre').val();
        let descripcion = $('#descripcion').val();
        if (nombre == '' || descripcion == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios',
            });
            return;
        }
        $.ajax({
            url: '/roles/add',
            type: 'POST',
            data: {
                nombre: nombre,
                descripcion: descripcion
            },
            success: function(response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Rol Guardado',
                    text: 'El rol se guardo correctamente',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });

            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrio un error al guardar el rol',
                });
            }
        });

        //cerrar el modal
    }
</script>
<?php
View::endSection('scripts');
