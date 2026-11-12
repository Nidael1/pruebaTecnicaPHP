<?php

declare(strict_types=1);

namespace Acme\Support;

final class Date
{
    /**
     * Intenta los formatos en orden. Si no se pasa ninguno, usa 'd/m/Y'.
     * Devuelve null si ningún formato coincide EXACTAMENTE (NO lanza excepción).
     */
    public static function parse(string $value, string ...$formats): ?\DateTimeImmutable
    {
        $value = trim($value);
        if ($formats === []) {
            $formats = ['d/m/Y'];
        }

        foreach ($formats as $format) {
            $date = \DateTimeImmutable::createFromFormat('!' . $format, $value);
            if ($date !== false && $date->format($format) === $value) {
                return $date;
            }
        }

        return null;
    }
}
