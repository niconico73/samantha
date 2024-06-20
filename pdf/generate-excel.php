<?php
// Incluir la biblioteca PhpSpreadsheet
require 'vendor/autoload.php';

// Verificar si se han proporcionado los parámetros GET necesarios
if(isset($_GET['fi']) && isset($_GET['ff']) && isset($_GET['usuario_id'])) {
    // Crear una instancia de la clase Spreadsheet
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Seleccionar la hoja activa
    $sheet = $spreadsheet->getActiveSheet();

    // Establecer los encabezados de las columnas
    $sheet->setCellValue('A1', 'Producto');
    $sheet->setCellValue('B1', 'Cantidad vendida');
    $sheet->setCellValue('C1', 'Precio de venta');
    $sheet->setCellValue('D1', 'Total');

    // Obtener los parámetros enviados por GET
    $fecha_inicio = $_GET['fi'];
    $fecha_final = $_GET['ff'];
    $usuario_id = $_GET['usuario_id'];

    // Aquí deberías agregar el código para obtener los datos de la base de datos
    // y llenar las filas del reporte en Excel. Utiliza la misma lógica que usaste
    // para generar el reporte en PDF.

    // Establecer el tipo de contenido y el nombre del archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_ventas_' . $fecha_inicio . '_a_' . $fecha_final . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Crear un objeto Writer para guardar el archivo
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    // Guardar el archivo en la salida (output)
    $writer->save('php://output');

    // Finalizar el script
    exit;
} else {
    // Si faltan parámetros GET, redirigir o mostrar un mensaje de error
    echo "Faltan parámetros GET necesarios.";
}
?>
