<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

use App\Reportes\VentasMensuales;

[$_, $archivo, $anio, $mes] = $argv + [null, null, null, null];
if ($archivo === null || $anio === null || $mes === null) {
    fwrite(STDERR, "Uso: php bin/reporte.php <archivo.csv> <año> <mes>\n");
    exit(1);
}

$reporte = (new VentasMensuales(require __DIR__ . '/../config/tasas.php'))
    ->generar($archivo, (int) $anio, (int) $mes);

printf("%-15s %-40s %8s %15s\n", 'RFC', 'Cliente', 'Pedidos', 'Total MXN');
foreach ($reporte as $fila) {
    printf("%-15s %-40s %8d %15s\n", $fila['rfc'], mb_strimwidth($fila['nombre'], 0, 40), $fila['pedidos'], $fila['total']->format());
}
