<?php

declare(strict_types=1);

/*
 * Pruebas mínimas (sin PHPUnit). Uso: php tests/run.php
 * Totales confirmados por contabilidad para octubre 2026.
 */

require __DIR__ . '/../bootstrap.php';

use App\Reportes\VentasMensuales;

$reporte = (new VentasMensuales(require __DIR__ . '/../config/tasas.php'))
    ->generar(__DIR__ . '/../data/pedidos_2026_10.csv', 2026, 10);

$casos = [
    // rfc => [pedidos, total en centavos]
    'DIS200617MN8' => [27, 40456037],
    'GOMA850312KJ3' => [27, 35304732],
    'MERJ881122QW9' => [21, 33075961],
];

$fallas = 0;
foreach ($casos as $rfc => [$pedidos, $centavos]) {
    $fila = $reporte[$rfc] ?? null;
    $ok = $fila !== null && $fila['pedidos'] === $pedidos && $fila['total']->cents() === $centavos;
    $obtenido = $fila ? "{$fila['pedidos']} pedidos / {$fila['total']->cents()}" : 'no aparece';
    printf("[%s] %s  esperado %d pedidos / %d  obtenido %s\n", $ok ? 'OK' : 'FALLA', $rfc, $pedidos, $centavos, $obtenido);
    $fallas += $ok ? 0 : 1;
}

exit($fallas === 0 ? 0 : 1);
