<?php

require __DIR__ . '/../src/bootstrap.php';

// Simula datos para la tabla
$rows = [
    ['a' => 'Uno', 'b' => 'Alpha'],
    ['a' => 'Dos', 'b' => 'Beta'],
];

$pdf = new Cezpdf('A4');
$pdf->ezText('Ejemplo de reporte mPDF con API ezPDF', 16);
$pdf->ezTable($rows, [
    'Columna A' => 'a',
    'Columna B' => 'b',
], 'Tabla de ejemplo', ['border' => 1, 'cellPadding' => 4]);
$pdf->ezStream('reporte.pdf');
