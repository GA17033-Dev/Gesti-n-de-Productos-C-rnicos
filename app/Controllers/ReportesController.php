<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Lib\Database;
use App\Models\Categoria;
use App\Models\DetalleVenta;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ReportesController extends Controller
{
    public function index()
    {
        $pdo = Database::getInstance()->getPdo();
    
        // Inicializar variables
        $ventasPorTipo = [];
        $augeVentas = [];
        $categorias = Categoria::all();
    
        // Obtener filtros de tipo de carne y fechas
        $tipoCarne = $_GET['tipo_carne'] ?? null;
        $fechaInicio = $_GET['fecha_inicio'] ?? null;
        $fechaFin = $_GET['fecha_fin'] ?? null;
    
        // Construir la consulta para obtener total vendido por tipo de carne
        $queryCarne = "
            SELECT c.nombre AS tipo_carne, SUM(dv.cantidad) as total_vendido
            FROM detalle_ventas dv
            JOIN productos p ON dv.id_producto = p.id
            JOIN categorias c ON p.id_categoria = c.id
            JOIN ventas v ON dv.id_venta = v.id
            WHERE 1=1
        ";
    
        $paramsCarne = [];
        
        if ($tipoCarne) {
            $queryCarne .= " AND c.nombre = :tipo_carne";
            $paramsCarne['tipo_carne'] = $tipoCarne;
        }
        if ($fechaInicio) {
            $queryCarne .= " AND v.fecha >= :fecha_inicio";
            $paramsCarne['fecha_inicio'] = $fechaInicio;
        }
        if ($fechaFin) {
            $queryCarne .= " AND v.fecha <= :fecha_fin";
            $paramsCarne['fecha_fin'] = $fechaFin;
        }
    
        $queryCarne .= " GROUP BY c.nombre";
        
        $stmtCarne = $pdo->prepare($queryCarne);
        $stmtCarne->execute($paramsCarne);
        $ventasPorTipo = $stmtCarne->fetchAll(\PDO::FETCH_ASSOC);
    
        // Guardar los datos filtrados en la sesión para la exportación
        $_SESSION['ventasPorTipo'] = $ventasPorTipo;
        $_SESSION['augeVentas'] = $augeVentas;
    
        return $this->render('reportes/index', [
            'ventasPorTipo' => $ventasPorTipo,
            'augeVentas' => $augeVentas,
            'categorias' => $categorias,
            'tipoCarne' => $tipoCarne,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ]);
    }
    

    public function exportarReporte()
    {
        // Obtener datos filtrados de la sesión
        $ventasPorTipo = $_SESSION['ventasPorTipo'] ?? [];
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Configuración del título
        $sheet->setCellValue('A1', 'Reporte de Ventas por Tipo de Carne');
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(30); // Ajuste de altura de fila para el título
    
        // Encabezados
        $sheet->setCellValue('A3', 'Tipo de Carne');
        $sheet->setCellValue('B3', 'Total Vendido');
        $sheet->getStyle('A3:B3')->getFont()->setBold(true);
        $sheet->getStyle('A3:B3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFCCCCCC'); // Color gris claro para los encabezados
    
        // Agregar datos
        $row = 4;
        foreach ($ventasPorTipo as $venta) {
            $sheet->setCellValue("A{$row}", $venta['tipo_carne']);
            $sheet->setCellValue("B{$row}", $venta['total_vendido']);
            $row++;
        }
    
        // Establecer formato de bordes
        $sheet->getStyle("A3:B" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    
        // Ajuste de ancho de columna
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
    
        // Descargar archivo
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_ventas.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
