<?php

declare(strict_types=1);

namespace Acme\Support;

/**
 * Dinero en centavos (entero). INMUTABLE: cada operación devuelve una instancia nueva.
 */
final class Money
{
    private function __construct(private readonly int $cents)
    {
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromCents(int $cents): self
    {
        return new self($cents);
    }

    /**
     * Acepta "1234.5", "1,234.50", "$1,234.50", " 1234 ".
     * Devuelve null si el texto no es un monto válido (NO lanza excepción).
     */
    public static function parse(string $value): ?self
    {
        $clean = str_replace(['$', ',', ' '], '', trim($value));
        if (!preg_match('/^(-?)(\d+)(?:\.(\d{1,2}))?$/', $clean, $m)) {
            return null;
        }
        $cents = ((int) $m[2]) * 100 + (int) str_pad($m[3] ?? '0', 2, '0');

        return new self($m[1] === '-' ? -$cents : $cents);
    }

    public function add(self $other): self
    {
        return new self($this->cents + $other->cents);
    }

    /** Factor como string decimal ("17.50"). Redondeo half-up al centavo. */
    public function multiply(string $factor): self
    {
        return new self((int) round($this->cents * (float) $factor, 0, PHP_ROUND_HALF_UP));
    }

    public function cents(): int
    {
        return $this->cents;
    }

    public function format(): string
    {
        return number_format($this->cents / 100, 2, '.', ',');
    }
}
