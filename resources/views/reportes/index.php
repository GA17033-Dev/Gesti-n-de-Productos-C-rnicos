<?php
use App\Lib\View;

View::extends('layout/layout');

View::section('title');
echo 'Reportes de Ventas por Tipo de Carne';
View::endSection('title');

View::section('content');
?>
<h1 class="h3 mb-4 text-gray-800 text-center">Reportes de Ventas por Tipo de Carne</h1>

<div class="container-fluid">
    <!-- Filtros -->
    <form method="GET" action="/reportes" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <label for="tipo_carne" class="form-label">Tipo de Carne:</label>
                <select id="tipo_carne" name="tipo_carne" class="form-select">
                    <option value="">Seleccione un tipo</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['nombre'] ?>" <?= isset($_GET['tipo_carne']) && $_GET['tipo_carne'] === $categoria['nombre'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='/reportes'">Limpiar Filtros</button>
        </div>
    </form>

    <!-- Botones de exportación -->
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-danger me-2" onclick="exportTableToPDF()" title="Exportar a PDF">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </button>
        <!-- Botón para exportar a Excel -->
        <a href="/reportes/exportarReporte" class="btn btn-success">Exportar a Excel</a>
    </div>

    <!-- Tabla de Reporte -->
    <table id="reportTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Tipo de Carne</th>
                <th>Total Vendido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventasPorTipo as $venta): ?>
                <tr>
                    <td><?= htmlspecialchars($venta['tipo_carne']) ?></td>
                    <td><?= htmlspecialchars($venta['total_vendido']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
View::endSection('content');

View::section('scripts');
?>
<script>
    const exportTableToPDF = () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text('Reporte de Ventas por Tipo de Carne', 105, 10, null, null, 'center');
        doc.autoTable({ html: '#reportTable', startY: 20, theme: 'striped' });
        doc.save('reporte_ventas.pdf');
    }

    const exportTableToExcel = (tableID, filename) => {
        let tipo = 'excel';
        let tabla = tableID;
        $.ajax({
            url: '/reportes/exportar_xlsx',
            type: 'POST',
            data: { tabla, tipo },
            xhrFields: { responseType: 'blob' },
            success: function(response) {
                const url = window.URL.createObjectURL(response);
                const link = document.createElement('a');
                link.href = url;
                link.download = filename + '.xlsx';
                link.click();
                window.URL.revokeObjectURL(url);
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo generar el archivo Excel.' });
            }
        });
    }
</script>
<?php
View::endSection('scripts');
