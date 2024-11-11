<?php

use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Listado de Productos';
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
<h1 class="h3 mb-4 text-gray-800 text-center">Listado de Productos</h1>
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0" data-bs-toggle="modal" data-bs-target="#addProductModal" title="Agregar Producto">
                <i class="fas fa-plus"></i>
                Agregar Producto
            </button>
            <!-- Botón para exportar a PDF -->
            <button type="button" class="btn btn-danger btn-sm flex-grow-1 flex-md-grow-0" onclick="exportTableToPDF()" title="Exportar a PDF">
                <i class="fas fa-file-pdf"></i>
                Exportar a PDF
            </button>
            <!--exportar en excel-->
            <button type="button" class="btn btn-success btn-sm flex-grow-1 flex-md-grow-0" onclick="exportTableToExcel('users', 'productos')" title="Exportar a Excel">
                <i class="fas fa-file-excel"></i>
                Exportar a Excel
            </button>
        </div>
    </div>
    <div class="table table-bordered table-hover">
        <table id="users" class="table table-bordered table-hover mb-4 " style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <td data-label="Nombre"><?= $producto['nombre'] ?></td>
                        <td data-label="Categoria"><?= $producto['categoria']['nombre'] ?></td>
                        <td data-label="Descripcion"><?= $producto['descripcion'] ?></td>
                        <td data-label="Precio"> $ <?= $producto['precio'] ?></td>
                        <td data-label="Stock"><?= $producto['stock'] ?></td>
                        <td data-label="Estado"><?= $producto['estado'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>' ?></td>
                        <td data-label="Acciones">
                            <button class="btn btn-sm btn-primary" onclick="editarProducto(<?= $producto['id'] ?>)"><i class="fas fa-edit"></i></button>
                            <?php if ($producto['estado']) : ?>
                                <button class="btn btn-sm btn-danger" onclick="eliminarProducto(<?= $producto['id'] ?>,false)" title="Eliminar"><i class="fas fa-trash"></i></button>
                            <?php else : ?>
                                <button class="btn btn-sm btn-success" onclick="activarProducto(<?= $producto['id'] ?>,true)" title="Activar"><i class="fas fa-check"></i></button>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
<!--pintar los usuarios-->
<!--modal addProductModal-->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="formAddProduct" class="container">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option value="">Seleccione una categoria</option>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarProducto()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--fin modal addProductModal-->
<?php foreach ($productos as $producto) : ?>
    <div class="modal fade" id="editProductModal<?= $producto['id'] ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?= $producto['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel<?= $producto['id'] ?>">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="formEditProduct" class="container">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre<?= $producto['id'] ?>" name="nombre" value="<?= $producto['nombre'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria<?= $producto['id'] ?>" name="categoria" required>
                                <option value="">Seleccione una categoria</option>
                                <?php foreach ($categorias as $categoria) : ?>
                                    <option value="<?= $categoria['id'] ?>" <?= $producto['id_categoria'] == $categoria['id'] ? 'selected' : '' ?>><?= $categoria['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="descripcion<?= $producto['id'] ?>" name="descripcion" required><?= $producto['descripcion'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio<?= $producto['id'] ?>" name="precio" value="<?= $producto['precio'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock<?= $producto['id'] ?>" name="stock" value="<?= $producto['stock'] ?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="updateProducto(<?= $producto['id'] ?>)">Guardar</button>
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
    const exportTableToPDF = () => {
        // Usar jsPDF para generar el PDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');  // Establecer la orientación horizontal (landscape)

        // Obtener los datos de la tabla
        const table = document.getElementById('users');
        const rows = Array.from(table.rows);

        const tableData = rows.map(row => {
            const columns = Array.from(row.cells).map(cell => cell.innerText);
            return columns;
        });

        // Excluir la fila de encabezado
        const tableHeaders = tableData.shift();

        // Añadir los encabezados al PDF
        doc.text('Reporte de Productos', 297 / 2, 10, null, null, 'center');  // Título centrado en el documento

        doc.autoTable({
            head: [tableHeaders],
            body: tableData,
            margin: { top: 20 },
            theme: 'striped',  // Puedes cambiarlo a 'grid', 'plain', o 'striped'
            styles: {
                fontSize: 10,              // Tamaño de la fuente
                cellPadding: 5,            // Espaciado entre celdas
                halign: 'center',          // Alineación horizontal (center, left, right)
                valign: 'middle',          // Alineación vertical (top, middle, bottom)
                font: 'helvetica',         // Tipo de letra
                lineColor: [44, 62, 80],   // Color de la línea
                lineWidth: 0.5             // Grosor de la línea
            },
            headStyles: {
                fillColor: [44, 62, 80],   // Color de fondo para los encabezados
                textColor: [255, 255, 255] // Color del texto en los encabezados
            },
            bodyStyles: {
                fillColor: [255, 255, 255], // Color de fondo de las filas (puedes alternarlo si deseas)
                textColor: [0, 0, 0]         // Color de texto de las filas
            },
            columnStyles: {
                0: { cellWidth: 40 },  // Establece el ancho de la primera columna
                1: { cellWidth: 'auto' }, // Ajuste automático para la segunda columna
                2: { cellWidth: 50 }, // Establece un ancho fijo para la tercera columna
                3: { cellWidth: 30 }, // Establece el ancho de la cuarta columna
                4: { cellWidth: 30 }, // Establece el ancho de la quinta columna
                5: { cellWidth: 30 }, // Establece el ancho de la sexta columna
                6: { cellWidth: 40 }  // Establece el ancho de la séptima columna
            },
            showHead: 'everyPage',  // Mostrar encabezado en todas las páginas (en caso de que se necesite más de una página)
        });

        // Descargar el archivo PDF
        doc.save('productos.pdf');
    }
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
    const guardarProducto = () => {
        const nombre = document.getElementById('nombre').value;
        const categoria = document.getElementById('categoria').value;
        const descripcion = document.getElementById('descripcion').value;
        const precio = document.getElementById('precio').value;
        const stock = document.getElementById('stock').value;

        if (nombre === '' || categoria === '' || descripcion === '' || precio === '' || stock === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos',
            });
            return;
        }

        $.ajax({
            url: '/productos/store',
            type: 'POST',
            data: {
                nombre,
                categoria,
                descripcion,
                precio,
                stock
            },
            success: function(response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: response.message,
                    allowOutsideClick: false,
                    //allowEscapeKey: false,
                    allowEscapeKey: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.responseJSON.message,
                });
            }
        });
    }
    const editarProducto = (id) => {
        $('#editProductModal' + id).modal('show');
    }
    const updateProducto = (id) => {
        const nombre = document.getElementById('nombre' + id).value;
        const categoria = document.getElementById('categoria' + id).value;
        const descripcion = document.getElementById('descripcion' + id).value;
        const precio = document.getElementById('precio' + id).value;
        const stock = document.getElementById('stock' + id).value;

        if (nombre === '' || categoria === '' || descripcion === '' || precio === '' || stock === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos',
            });
            return;
        }

        $.ajax({
            url: '/productos/update',
            type: 'POST',
            data: {
                id,
                nombre,
                categoria,
                descripcion,
                precio,
                stock
            },
            success: function(response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    text: response.message,
                    allowOutsideClick: false,
                    //allowEscapeKey: false,
                    allowEscapeKey: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.responseJSON.message,
                });
            }
        });
    }

    const eliminarProducto = (id, estado) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/productos/delete',
                    type: 'POST',
                    data: {
                        id,
                        estado
                    },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado!',
                            response.message,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.responseJSON.message,
                        });
                    }
                });
            }
        });
    }
    const exportTableToExcel = (tableID, filename = '') => {
        let tipo = 'excel';
        let tabla = tableID;
        $.ajax({
            url: '/exportar',
            type: 'POST',
            data: {
                tabla,
                tipo
            },
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(response) {
                const blob = new Blob([response], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                var name = new Date().toISOString().slice(0, 10);
                link.setAttribute('download', filename + name + '.xlsx');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al generar el archivo Excel.',
                });
            }
        });
    }
</script>
<?php
View::endSection('scripts');
