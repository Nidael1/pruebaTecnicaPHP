<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Catálogo de clientes. En producción viene de MySQL; aquí es un stub.
 */
final class Cliente
{
    public function __construct(
        public readonly string $rfc,
        public readonly string $nombre,
        public readonly string $moneda = 'MXN',
        public readonly int $diasCredito = 0,
    ) {
    }

    public static function buscar(string $rfc): ?self
    {
        foreach (self::todos() as $c) {
            if ($c->rfc === $rfc) {
                return $c;
            }
        }

        return null;
    }

    /** @return list<self> */
    public static function todos(): array
    {
        return [
            new self('GOMA850312KJ3', 'Papelería Gómez', 'MXN', 30),
            new self('SUN180101ZZ7', 'Sunbelt Supplies LLC', 'USD', 60),
            new self('DIS200617MN8', 'Distribuidora Norteña', 'MXN', 30),
        ];
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
