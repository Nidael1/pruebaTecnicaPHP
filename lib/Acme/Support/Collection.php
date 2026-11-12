<?php

declare(strict_types=1);

namespace Acme\Support;

/**
 * Colección interna de ACME. Inspirada en Illuminate\Support\Collection,
 * pero NO es compatible. Ver docs/acme-support.md.
 */
final class Collection implements \Countable, \IteratorAggregate
{
    /** @param array<mixed> $items */
    public function __construct(private array $items = [])
    {
    }

    public static function make(array $items = []): self
    {
        return new self($items);
    }

    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    /** Conserva llaves. */
    public function map(callable $fn): self
    {
        $out = [];
        foreach ($this->items as $k => $v) {
            $out[$k] = $fn($v, $k);
        }

        return new self($out);
    }

    /** Reindexa (a diferencia de Laravel). */
    public function filter(callable $fn): self
    {
        $out = [];
        foreach ($this->items as $k => $v) {
            if ($fn($v, $k)) {
                $out[] = $v;
            }
        }

        return new self($out);
    }

    public function reduce(callable $fn, mixed $initial = null): mixed
    {
        $acc = $initial;
        foreach ($this->items as $k => $v) {
            $acc = $fn($acc, $v, $k);
        }

        return $acc;
    }

    /**
     * Elimina duplicados por $key conservando la ÚLTIMA aparición
     * (Laravel conserva la primera). El orden resultante es el de esa última aparición.
     */
    public function unique(string $key): self
    {
        $last = [];
        foreach ($this->items as $i => $item) {
            $last[$item[$key]] = $i;
        }
        asort($last);

        $out = [];
        foreach ($last as $i) {
            $out[] = $this->items[$i];
        }

        return new self($out);
    }

    /** Agrupa por el valor CRUDO de $key (no normaliza). */
    public function groupBy(string $key): self
    {
        $out = [];
        foreach ($this->items as $item) {
            $out[$item[$key]][] = $item;
        }

        return new self(array_map(fn (array $g) => new self($g), $out));
    }

    public function pluck(string $key): self
    {
        return new self(array_map(fn ($i) => $i[$key], array_values($this->items)));
    }

    public function first(): mixed
    {
        return $this->items === [] ? null : $this->items[array_key_first($this->items)];
    }

    public function last(): mixed
    {
        return $this->items === [] ? null : $this->items[array_key_last($this->items)];
    }

    /** Ordena por $key con sort NO estable para empates. */
    public function sortBy(string $key): self
    {
        $items = $this->items;
        usort($items, fn ($a, $b) => strcmp((string) $a[$key], (string) $b[$key]) ?: random_int(-1, 1));

        return new self($items);
    }
}
