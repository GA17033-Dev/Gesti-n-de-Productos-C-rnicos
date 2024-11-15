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

    /* Estilos para el input de teléfono */
    .iti {
        width: 100%;
    }

    .iti__flag-container:hover {
        cursor: pointer;
    }

    /* Estilos para DataTables */
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">


<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h4 text-gray-800 mb-0">Gestión de Usuarios</h1>
            <p class="text-muted mb-0">Administra los usuarios del sistema</p>
        </div>
    </div>

    <div class="card table-container">
        <table id="users" class="table table-hover">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Información de Contacto</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= $user['nombre'] . ' ' . $user['apellido'] ?></h6>
                                    <small class="text-muted">@<?= $user['username'] ?? '' ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="mb-1"><i class="fas fa-envelope text-muted me-2"></i><?= $user['email'] ?? '' ?></div>
                                <div><i class="fas fa-phone text-muted me-2"></i><?= $user['telefono'] ?? '' ?></div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <?= $user['rol'] ? $user['rol']->nombre : 'Sin Rol' ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-action btn-edit" onclick="editUser(<?= $user['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php foreach ($users as $user) : ?>
    <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editUserModal<?= $user['id'] ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModal<?= $user['id'] ?>Label">
                        <i class="fas fa-user-edit me-2 text-primary"></i>
                        Editar Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/users/update" method="POST">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nombre<?= $user['id'] ?>">Nombre</label>
                                <input type="text" class="form-control" id="nombre<?= $user['id'] ?>" name="nombre" value="<?= $user['nombre'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="apellido<?= $user['id'] ?>">Apellido</label>
                                <input type="text" class="form-control" id="apellido<?= $user['id'] ?>" name="apellido" value="<?= $user['apellido'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email<?= $user['id'] ?>">Email</label>
                            <input type="email" class="form-control" id="email<?= $user['id'] ?>" name="email" value="<?= $user['email'] ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="username<?= $user['id'] ?>">Nombre de Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="username<?= $user['id'] ?>" name="username" value="<?= $user['username'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="direccion<?= $user['id'] ?>">Dirección</label>
                            <input type="text" class="form-control" id="direccion<?= $user['id'] ?>" name="direccion" value="<?= $user['direccion'] ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="rol<?= $user['id'] ?>">Rol</label>
                            <select class="form-select" id="rol<?= $user['id'] ?>" name="rol">
                                <option value="">Seleccionar Rol</option>
                                <?php foreach ($roles as $rol) : ?>
                                    <option value="<?= $rol['id'] ?>" <?= $user['rol'] && $user['rol']->id == $rol['id'] ? 'selected' : '' ?>>
                                        <?= $rol['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="telefono<?= $user['id'] ?>">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono<?= $user['id'] ?>" name="telefono" value="<?= $user['telefono'] ?>">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="saveUser(<?= $user['id'] ?>)">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php View::endSection('content'); ?>

<?php

View::section('scripts');
?>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

<script>
    var itiMovil;
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
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"]
            ],
            responsive: true,
            paginate: true,
        });
    });
    const editUser = (id) => {
        itiMovil = window.intlTelInput(document.querySelector("#telefono" + id), {
            hiddenInput: "full_number",
            initialCountry: "sv",
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
        });
        $('#editUserModal' + id).modal('show');
    }

    const saveUser = (id) => {
        const nombre = $('#nombre' + id).val();
        const apellido = $('#apellido' + id).val();
        const email = $('#email' + id).val();
        const username = $('#username' + id).val();
        const direccion = $('#direccion' + id).val();
        const rol = $('#rol' + id).val();
        const telefono = itiMovil.getNumber();
        if (!nombre || !apellido || !email || !username || !direccion || !rol || !telefono) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos',
            });
            return;
        }
        const data = {
            id,
            nombre,
            apellido,
            email,
            username,
            direccion,
            rol,
            telefono
        };

        Swal.fire({
            icon: 'info',
            title: 'Procesando',
            text: "Espere un momento por favor",
            showConfirmButton: false,
            allowOutsideClick: false,
            heightAuto: false,
            scrollbarPadding: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(() => {
            $.ajax({
                url: '/users/update',
                type: 'POST',
                data,
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: "Éxito",
                        text: response.message,
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        heightAuto: false,
                        scrollbarPadding: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                },
                error: function(error) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud',
                    });
                }
            });
        }, 1000);
    }

    // const deleteUser = (id) => {
    //     Swal.fire({
    //         title: '¿Estás seguro?',
    //         text: "¡No podrás revertir esto!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Sí, eliminarlo!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             Swal.fire({
    //                 icon: 'info',
    //                 title: 'Procesando',
    //                 text: "Espere un momento por favor",
    //                 showConfirmButton: false,
    //                 allowOutsideClick: false,
    //                 heightAuto: false,
    //                 scrollbarPadding: false,
    //                 willOpen: () => {
    //                     Swal.showLoading();
    //                 }
    //             });
    //             setTimeout(() => {
    //                 $.ajax({
    //                     url: '/users/delete',
    //                     type: 'POST',
    //                     data: {
    //                         id
    //                     },
    //                     success: function(response) {
    //                         Swal.close();
    //                         Swal.fire({
    //                             icon: 'success',
    //                             title: "Éxito",
    //                             text: response.message,
    //                             confirmButtonText: "Aceptar",
    //                             allowOutsideClick: false,
    //                             allowEscapeKey: false,
    //                             heightAuto: false,
    //                             scrollbarPadding: false
    //                         }).then((result) => {
    //                             if (result.isConfirmed) {
    //                                 location.reload();
    //                             }
    //                         });
    //                     },
    //                     error: function(error) {
    //                         Swal.close();
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error',
    //                             text: 'Ocurrió un error al procesar la solicitud',
    //                         });
    //                     }
    //                 });
    //             }, 1000);
    //         }
    //     });
    // }
</script>
<?php
View::endSection('scripts');
