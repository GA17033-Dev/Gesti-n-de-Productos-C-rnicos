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
                            <button class="btn btn-sm btn-primary" onclick="editRole(<?= $role['id'] ?>)" href="#"><i class="fas fa-edit"></i></button>
                            <?php if ($role['estado'] == 1) : ?>
                                <button class="btn btn-sm btn-danger" onclick="deleteRole(<?= $role['id'] ?>)" href="#"><i class="fas fa-trash"></i></button>
                            <?php endif; ?>
                            <?php if ($role['estado'] == 0) : ?>
                                <!--recuperar-->
                                <button class="btn btn-sm btn-success" onclick="recoverRole(<?= $role['id'] ?>)" href="#"><i class="fas fa-recycle"></i></button>
                            <?php endif; ?>
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
<?php foreach ($roles as $role) : ?>
    <!--editar modal-->
    <div class="modal fade" id="editRoleModal<?= $role['id'] ?>" tabindex="-1" aria-labelledby="editRoleModalLabel<?= $role['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel<?= $role['id'] ?>">Editar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">
                            <!--edit_nombre + id-->
                            <label for="edit_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre<?= $role['id'] ?>" name="edit_nombre" required placeholder="Nombre del Rol" value="<?= $role['nombre'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="edit_descripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="edit_descripcion<?= $role['id'] ?>" name="edit_descripcion" required placeholder="Descripcion del Rol"><?= $role['descripcion'] ?></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="saveRole(<?= $role['id'] ?>)">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


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
    }

    const editRole = (id) => {
        $('#editRoleModal' + id).modal('show');
    }
    const saveRole = (id) => {
        let nombre = $('#edit_nombre' + id).val();
        let descripcion = $('#edit_descripcion' + id).val();

        if (nombre == '' || descripcion == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios',
            });
            return;
        }
        let data = {
            id: id,
            nombre: nombre,
            descripcion: descripcion
        };
        console.log('data', data);
        $.ajax({
            url: '/roles/edit',
            type: 'POST',
            data: data,
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
    }

    const deleteRole = (id) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "El rol se deshabilitara y no podra ser utilizado",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deshabilitar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/roles/delete',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deshabilitado!',
                            'El rol ha sido deshabilitado.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrio un error al deshabilitar el rol',
                        });
                    }
                });
            }
        });
        
    }

    const recoverRole = (id) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "El rol se habilitara y podra ser utilizado",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, habilitar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/roles/recover',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        Swal.fire(
                            'Habilitado!',
                            'El rol ha sido habilitado.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrio un error al habilitar el rol',
                        });
                    }
                });
            }
        });
    }
</script>
<?php
View::endSection('scripts');
