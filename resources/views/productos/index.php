<?php

use App\Lib\View;

View::extends('layout/layout');
View::section('title');
echo 'Gestión de Productos';
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

    .btn-activate {
        background-color: #2ecc71;
        border: none;
        color: white;
    }

    .btn-edit:hover,
    .btn-delete:hover,
    .btn-activate:hover {
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

    .btn-group-actions {
        gap: 8px;
        display: flex;
        flex-wrap: wrap;
    }

    .btn-group-actions .btn {
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .price-column {
        font-weight: 600;
        color: #2ecc71;
    }

    .stock-column {
        font-weight: 500;
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
            <h1 class="h4 text-gray-800 mb-1">Gestión de Productos</h1>
            <p class="text-muted mb-0">Administra el catálogo de productos</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="btn-group-actions">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i>
                    Nuevo Producto
                </button>
                <button type="button" class="btn btn-danger" onclick="exportTableToPDF()">
                    <i class="fas fa-file-pdf"></i>
                    Exportar PDF
                </button>
                <button type="button" class="btn btn-success" onclick="exportTableToExcel('users', 'productos')">
                    <i class="fas fa-file-excel"></i>
                    Exportar Excel
                </button>
            </div>
        </div>
    </div>

    <div class="card table-container">
        <table id="users" class="table table-hover">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Detalles</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="ms-3">
                                    <h6 class="mb-0"><?= $producto['nombre'] ?></h6>
                                    <small class="text-muted"><?= $producto['categoria']['nombre'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted d-block"><?= $producto['descripcion'] ?></small>
                        </td>
                        <td class="price-column">$<?= number_format($producto['precio'], 2) ?></td>
                        <td class="stock-column">
                            <?php if ($producto['stock'] <= 10) : ?>
                                <span class="badge bg-warning text-dark"><?= $producto['stock'] ?> unidades</span>
                            <?php else : ?>
                                <?= $producto['stock'] ?> unidades
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($producto['estado']) : ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-action btn-edit" onclick="editarProducto(<?= $producto['id'] ?>)" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if ($producto['estado']) : ?>
                                    <button class="btn btn-action btn-delete" onclick="eliminarProducto(<?= $producto['id'] ?>,false)" title="Desactivar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php else : ?>
                                    <button class="btn btn-action btn-activate" onclick="activarProducto(<?= $producto['id'] ?>,true)" title="Activar">
                                        <i class="fas fa-check"></i>
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

<!-- Modal Agregar Producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="fas fa-box me-2 text-primary"></i>
                    Nuevo Producto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddProduct">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="nombre">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="categoria">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="">Seleccionar categoría</option>
                                <?php foreach ($categorias as $categoria) : ?>
                                    <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="precio">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProducto()">
                    <i class="fas fa-save me-2"></i>Guardar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<?php foreach ($productos as $producto) : ?>
    <div class="modal fade" id="editProductModal<?= $producto['id'] ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?= $producto['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel<?= $producto['id'] ?>">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Editar Producto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditProduct<?= $producto['id'] ?>">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="nombre<?= $producto['id'] ?>">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre<?= $producto['id'] ?>" name="nombre" value="<?= $producto['nombre'] ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="categoria<?= $producto['id'] ?>">Categoría</label>
                                <select class="form-select" id="categoria<?= $producto['id'] ?>" name="categoria" required>
                                    <option value="">Seleccionar categoría</option>
                                    <?php foreach ($categorias as $categoria) : ?>
                                        <option value="<?= $categoria['id'] ?>" <?= $producto['id_categoria'] == $categoria['id'] ? 'selected' : '' ?>><?= $categoria['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="descripcion<?= $producto['id'] ?>">Descripción</label>
                                <textarea class="form-control" id="descripcion<?= $producto['id'] ?>" name="descripcion" rows="3" required><?= $producto['descripcion'] ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="precio<?= $producto['id'] ?>">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="precio<?= $producto['id'] ?>" name="precio" value="<?= $producto['precio'] ?>" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="stock<?= $producto['id'] ?>">Stock</label>
                                <input type="number" class="form-control" id="stock<?= $producto['id'] ?>" name="stock" value="<?= $producto['stock'] ?>" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="updateProducto(<?= $producto['id'] ?>)">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
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
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF('landscape'); // Establecer la orientación horizontal (landscape)

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
        doc.text('Reporte de Productos', 297 / 2, 10, null, null, 'center'); // Título centrado en el documento

        doc.autoTable({
            head: [tableHeaders],
            body: tableData,
            margin: {
                top: 20
            },
            theme: 'striped', // Puedes cambiarlo a 'grid', 'plain', o 'striped'
            styles: {
                fontSize: 10, // Tamaño de la fuente
                cellPadding: 5, // Espaciado entre celdas
                halign: 'center', // Alineación horizontal (center, left, right)
                valign: 'middle', // Alineación vertical (top, middle, bottom)
                font: 'helvetica', // Tipo de letra
                lineColor: [44, 62, 80], // Color de la línea
                lineWidth: 0.5 // Grosor de la línea
            },
            headStyles: {
                fillColor: [44, 62, 80], // Color de fondo para los encabezados
                textColor: [255, 255, 255] // Color del texto en los encabezados
            },
            bodyStyles: {
                fillColor: [255, 255, 255], // Color de fondo de las filas (puedes alternarlo si deseas)
                textColor: [0, 0, 0] // Color de texto de las filas
            },
            columnStyles: {
                0: {
                    cellWidth: 40
                }, // Establece el ancho de la primera columna
                1: {
                    cellWidth: 'auto'
                }, // Ajuste automático para la segunda columna
                2: {
                    cellWidth: 50
                }, // Establece un ancho fijo para la tercera columna
                3: {
                    cellWidth: 30
                }, // Establece el ancho de la cuarta columna
                4: {
                    cellWidth: 30
                }, // Establece el ancho de la quinta columna
                5: {
                    cellWidth: 30
                }, // Establece el ancho de la sexta columna
                6: {
                    cellWidth: 40
                } // Establece el ancho de la séptima columna
            },
            showHead: 'everyPage', // Mostrar encabezado en todas las páginas (en caso de que se necesite más de una página)
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
            "pageLength": 5,
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
