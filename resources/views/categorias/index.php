<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Categorias - Tu Aplicación';
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
<h1 class="h3 mb-4 text-gray-800 text-center">Listado de Categorias</h1>
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0" data-bs-toggle="modal" data-bs-target="#addCategoryModal" title="Agregar Categoria">
                <i class="fas fa-plus"></i>
                Agregar Categoria
            </button>
        </div>
    </div>
    <div class="table table-bordered table-hover">
        <table id="users" class="table table-bordered table-hover mb-4 " style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) : ?>
                    <tr>
                        <td data-label="Nombre"><?= $categoria['nombre'] ?></td>
                        <td data-label="Descripcion"><?= $categoria['descripcion'] ?></td>
                        <td data-label="Acciones">
                            <button class="btn btn-sm btn-primary" onclick="editarCategoria(<?= $categoria['id'] ?>)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" href="#"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!--agregar categoria-->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Agregar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCategoria()">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--fin agregar categoria-->
<?php foreach ($categorias as $categoria) : ?>
    <!--editar categoria-->
    <div class="modal fade" id="editCategoryModal<?= $categoria['id'] ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel<?= $categoria['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel<?= $categoria['id'] ?>">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre<?= $categoria['id'] ?>" name="nombre" value="<?= $categoria['nombre'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="edit_descripcion<?= $categoria['id'] ?>" name="descripcion" required><?= $categoria['descripcion'] ?></textarea>
                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="updateCategoria(<?= $categoria['id'] ?>)">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--fin editar categoria-->
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

    const guardarCategoria = () => {
        //validar los campos que no esten vacios
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        if (nombre == '' || descripcion == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios',
            });
            return;
        }

        //enviar los datos al servidor

        $.ajax({
            url: '/categorias/store',
            type: 'POST',
            data: {
                nombre: nombre,
                descripcion: descripcion
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: response.message,
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
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
                    text: 'Ocurrio un error al guardar la categoria',
                });
            }
        });
    }
    const editarCategoria = (id) => {
        $('#editCategoryModal' + id).modal('show');
    }
    const updateCategoria = (id) => {
        //validar los campos que no esten vacios
        var nombre = $('#edit_nombre' + id).val();
        var descripcion = $('#edit_descripcion' + id).val();
        if (nombre == '' || descripcion == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios',
            });
            return;
        }

        $.ajax({
            url: '/categorias/update',
            type: 'POST',
            data: {
                id: id,
                nombre: nombre,
                descripcion: descripcion
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: response.message,
                    allowOutsideClick: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
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
                    text: 'Ocurrio un error al actualizar la categoria',
                });
            }
        });
    }
</script>
<?php
View::endSection('scripts');
