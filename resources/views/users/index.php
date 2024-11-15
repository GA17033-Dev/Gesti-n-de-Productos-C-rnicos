<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Listado de Usuarios';
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

<h1 class="h3 mb-4 text-gray-800 text-center">Listado de Usuarios</h1>
<div class="container-fluid">
    <div class="table table-bordered table-hover">
        <table id="users" class="table table-bordered table-hover mb-4 " style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Nombre de Usuario</th>
                    <th>Rol de Usuario</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td data-label="Nombre"><?= $user['nombre'] . ' ' . $user['apellido'] ?></td>
                        <td data-label="Email"><?= $user['email'] ?? '' ?></td>
                        <td data-label="Usuario"><?= $user['username'] ?? '' ?></td>
                        <td data-label="Rol"><?= $user['rol'] ? $user['rol']->nombre : 'Sin Rol' ?></td>
                        <td data-label="Telefono"><?= $user['telefono'] ?? '' ?></td>
                        <td data-label="Acciones">
                            <button class="btn btn-sm btn-primary" onclick="editUser(<?= $user['id'] ?>)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" href="#"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!--pintar los usuarios-->
<?php foreach ($users as $user) : ?>
    <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModal<?= $user['id'] ?>Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModal<?= $user['id'] ?>Label">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/users/update" method="POST">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre<?= $user['id'] ?>" name="nombre" value="<?= $user['nombre'] ?>">
                        </div>
                        <div class="form-group mt-2">
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" id="apellido<?= $user['id'] ?>" name="apellido" value="<?= $user['apellido'] ?>">
                        </div>
                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email<?= $user['id'] ?>" name="email" value="<?= $user['email'] ?>">
                        </div>
                        <div class="form-group mt-2">
                            <label for="username">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username<?= $user['id'] ?>" name="username" value="<?= $user['username'] ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label for="direccion">Direccion</label>
                            <input type="text" class="form-control" id="direccion<?= $user['id'] ?>" name="direccion" value="<?= $user['direccion'] ?>">
                        </div>
                        <div class="form-group mt-2">
                            <label for="rol">Rol</label>
                            <select class="form-select" id="rol<?= $user['id'] ?>" name="rol">
                                <option value="">Seleccionar Rol</option>
                                <?php foreach ($roles as $rol) : ?>
                                    <option value="<?= $rol['id'] ?>" <?= $user['rol'] && $user['rol']->id == $rol['id'] ? 'selected' : '' ?>><?= $rol['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="form-group mt-2">
                            <label for="telefono">Telefono</label>
                            <input type="text" class="form-control" id="telefono<?= $user['id'] ?>" name="telefono" value="<?= $user['telefono'] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="saveUser(<?= $user['id'] ?>)">Guardar</button>
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
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

<script>
    var itiMovil;
    $(document).ready(function() {
        $('#users').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado - lo siento",
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
        //telefono



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
</script>
<?php
View::endSection('scripts');
