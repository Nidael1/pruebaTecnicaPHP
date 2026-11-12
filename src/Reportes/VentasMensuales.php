<?php

declare(strict_types=1);

namespace App\Reportes;

use Acme\Csv\CsvReader;
use Acme\Support\Date;
use Acme\Support\Money;

/**
 * Reporte de ventas mensuales por cliente (con IVA, en MXN).
 * Fuente: exportación diaria del ERP (data/pedidos_*.csv).
 */
final class VentasMensuales
{
    /** @param array<string, string> $tasas  moneda => tipo de cambio a MXN */
    public function __construct(private readonly array $tasas)
    {
    }

    /**
     * @return array<string, array{rfc: string, nombre: string, pedidos: int, total: Money}>
     */
    public function generar(string $archivo, int $anio, int $mes): array
    {
        $resultado = CsvReader::read($archivo);
        if (!$resultado->isOk()) {
            throw new \RuntimeException($resultado->error());
        }

        $pedidos = $resultado->rows()
            ->unique('folio') // la última línea del folio es la vigente (ver glosario)
            ->filter(fn (array $r) => trim($r['estatus']) !== 'C');

        $porCliente = [];
        foreach ($pedidos as $r) {
            $fecha = Date::parse($r['fecha']);
            if ($fecha === null) {
                continue;
            }
            if ((int) $fecha->format('Y') !== $anio || (int) $fecha->format('n') !== $mes) {
                continue;
            }

            $monto = Money::parse($r['total']);
            if ($monto === null) {
                continue;
            }

            $moneda = strtoupper(trim($r['moneda']));
            if ($moneda !== 'MXN') {
                $monto = $monto->multiply($this->tasas[$moneda]);
            }

            $rfc = $r['cliente_rfc'];
            $porCliente[$rfc] ??= [
                'rfc' => $rfc,
                'nombre' => $r['cliente_nombre'],
                'pedidos' => 0,
                'total' => Money::zero(),
            ];
            $porCliente[$rfc]['pedidos']++;
            $porCliente[$rfc]['total'] = $porCliente[$rfc]['total']->add($monto);
        }

        ksort($porCliente);

        return $porCliente;
    }
}
