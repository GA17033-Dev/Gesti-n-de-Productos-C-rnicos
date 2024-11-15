<?php

use App\Lib\View;

View::extends('layout/layout');
View::section('title');
echo 'Gestión de Roles';
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

    .table td {
        padding: 15px;
        vertical-align: middle;
        border: none;
        color: #495057;
    }

    .table tbody tr {
        border-bottom: 1px solid #f1f1f1;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
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
        margin: 0 3px;
    }

    .btn-edit {
        background-color: #3498db;
        border: none;
        color: white;
    }

    .btn-delete {
        background-color: #e74c3c;
        border: none;
        color: white;
    }

    .btn-recover {
        background-color: #2ecc71;
        border: none;
        color: white;
    }

    .btn-edit:hover,
    .btn-delete:hover,
    .btn-recover:hover {
        transform: translateY(-2px);
        color: white;
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

    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #f1f1f1;
        padding: 20px 25px;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 500;
    }

    .badge i {
        font-size: 0.75rem;
        margin-right: 4px;
    }

    .description-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* DataTables customization */
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
            <h1 class="h4 text-gray-800 mb-1">Gestión de Roles</h1>
            <p class="text-muted mb-0">Administra los roles del sistema</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="fas fa-plus me-2"></i>
                Nuevo Rol
            </button>
        </div>
    </div>

    <div class="card table-container">
        <table id="users" class="table table-hover">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Descripción</th>
                    <th width="100">Estado</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role) : ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded-circle p-2 me-3">
                                    <i class="fas fa-user-shield text-primary"></i>
                                </div>
                                <h6 class="mb-0"><?= $role['nombre'] ?></h6>
                            </div>
                        </td>
                        <td class="description-cell"><?= $role['descripcion'] ?></td>
                        <td>
                            <?php if ($role['estado'] == 1) : ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Activo
                                </span>
                            <?php else : ?>
                                <span class="badge bg-danger">
                                    <i class="fas fa-times"></i> Inactivo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-action btn-edit" onclick="editRole(<?= $role['id'] ?>)" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if ($role['estado'] == 1) : ?>
                                    <button class="btn btn-action btn-delete" onclick="deleteRole(<?= $role['id'] ?>)" title="Deshabilitar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if ($role['estado'] == 0) : ?>
                                    <button class="btn btn-action btn-recover" onclick="recoverRole(<?= $role['id'] ?>)" title="Habilitar">
                                        <i class="fas fa-recycle"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Rol -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">
                    <i class="fas fa-user-shield me-2 text-primary"></i>
                    Nuevo Rol
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label" for="nombre">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del rol" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingrese la descripción del rol" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="addRole()">
                            <i class="fas fa-save me-2"></i>Guardar Rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Rol -->
<?php foreach ($roles as $role) : ?>
    <div class="modal fade" id="editRoleModal<?= $role['id'] ?>" tabindex="-1" aria-labelledby="editRoleModalLabel<?= $role['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel<?= $role['id'] ?>">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Editar Rol
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="edit_nombre<?= $role['id'] ?>">Nombre del Rol</label>
                            <input type="text" class="form-control" id="edit_nombre<?= $role['id'] ?>" name="edit_nombre" value="<?= $role['nombre'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit_descripcion<?= $role['id'] ?>">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion<?= $role['id'] ?>" name="edit_descripcion" rows="3" required><?= $role['descripcion'] ?></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="saveRole(<?= $role['id'] ?>)">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
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
