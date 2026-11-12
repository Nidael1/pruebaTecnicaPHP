<?php

// NO USAR — intento de 2023, abandonado. Se deja como referencia.
// TODO(mario): revisar por qué no cuadra con contabilidad

namespace App\Reportes;

class ReporteV2
{
    public function generar(string $archivo, int $anio, int $mes): array
    {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        array_shift($lineas);

        $vistos = [];
        $totales = [];
        foreach ($lineas as $linea) {
            [$folio, $fecha, $rfc, $nombre, $estatus, $total, $moneda] = str_getcsv($linea);

            if (isset($vistos[$folio])) {
                continue;
            }
            $vistos[$folio] = true;

            if ($estatus !== 'A') {
                continue;
            }

            $ts = strtotime($fecha);
            if (date('Y', $ts) != $anio || date('n', $ts) != $mes) {
                continue;
            }

            $monto = (float) str_replace(['$', ','], '', $total);
            if (strtoupper($moneda) === 'USD') {
                $monto *= 17.5;
            }

            $rfc = strtoupper(trim($rfc));
            $totales[$rfc] = ($totales[$rfc] ?? 0) + $monto;
        }

        ksort($totales);

        return $totales;
    }
}
