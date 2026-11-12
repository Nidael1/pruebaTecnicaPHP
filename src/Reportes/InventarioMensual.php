<?php

declare(strict_types=1);

namespace App\Reportes;

use Acme\Csv\CsvReader;
use Acme\Support\Collection;

/**
 * Existencias al cierre de mes por almacén. No relacionado con ventas.
 */
final class InventarioMensual
{
    public function generar(string $archivo): Collection
    {
        $resultado = CsvReader::read($archivo);
        if (!$resultado->isOk()) {
            throw new \RuntimeException($resultado->error());
        }

        return $resultado->rows()
            ->filter(fn (array $r) => (int) $r['existencia'] > 0)
            ->groupBy('almacen')
            ->map(fn (Collection $g) => $g->reduce(fn ($acc, $r) => $acc + (int) $r['existencia'], 0));
    }
}
