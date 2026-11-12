<?php

// Corte de caja diario por sucursal (2020). No relacionado con el reporte mensual.

function corte(array $tickets): array
{
    $porSucursal = [];
    foreach ($tickets as $t) {
        $porSucursal[$t['sucursal']] = ($porSucursal[$t['sucursal']] ?? 0) + $t['importe'];
    }
    arsort($porSucursal);

    return $porSucursal;
}
