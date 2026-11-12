<?php

declare(strict_types=1);

/*
 * Helpers globales del proyecto. Se cargan desde bootstrap.php.
 */

if (!function_exists('normaliza_rfc')) {
    /** "  xaxx-010101-000 " => "XAXX010101000" */
    function normaliza_rfc(string $rfc): string
    {
        return strtoupper(preg_replace('/[\s\-]/', '', $rfc));
    }
}

if (!function_exists('folio_sucursal')) {
    /** T = tienda física, W = tienda en línea, M = mayoreo */
    function folio_sucursal(string $folio): string
    {
        return match (substr(trim($folio), 0, 1)) {
            'T' => 'tienda',
            'W' => 'web',
            'M' => 'mayoreo',
            default => 'desconocida',
        };
    }
}

if (!function_exists('mes_nombre')) {
    function mes_nombre(int $mes): string
    {
        return ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
            'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'][$mes - 1];
    }
}

if (!function_exists('log_info')) {
    function log_info(string $msg): void
    {
        file_put_contents(__DIR__ . '/../../storage/logs/app.log', date('c') . " {$msg}\n", FILE_APPEND);
    }
}
