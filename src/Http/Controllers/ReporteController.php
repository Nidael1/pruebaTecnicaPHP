<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Reportes\VentasMensuales;

final class ReporteController
{
    public function ventas(array $query): string
    {
        $anio = (int) ($query['anio'] ?? date('Y'));
        $mes = (int) ($query['mes'] ?? date('n'));
        $archivo = sprintf('%s/../../../data/pedidos_%d_%02d.csv', __DIR__, $anio, $mes);

        $reporte = (new VentasMensuales(require __DIR__ . '/../../../config/tasas.php'))
            ->generar($archivo, $anio, $mes);

        ob_start();
        require __DIR__ . '/../../../resources/views/reportes/ventas.php';

        return (string) ob_get_clean();
    }
}
