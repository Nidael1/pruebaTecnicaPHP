<?php

declare(strict_types=1);

namespace App\Models;

use Acme\Support\Money;

/**
 * Modelo de pedido usado por la API de seguimiento. El reporte mensual NO lo usa:
 * trabaja directo sobre la exportación CSV del ERP.
 */
final class Pedido
{
    public function __construct(
        public readonly string $folio,
        public readonly \DateTimeImmutable $fecha,
        public readonly string $rfc,
        public readonly string $estatus,
        public readonly Money $total,
    ) {
    }

    public function esVenta(): bool
    {
        return $this->estatus !== 'C';
    }
}
