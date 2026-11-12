<?php

declare(strict_types=1);

namespace Acme\Csv;

use Acme\Support\Collection;

final class Result
{
    private function __construct(
        private readonly ?Collection $rows,
        private readonly ?string $error,
    ) {
    }

    public static function ok(Collection $rows): self
    {
        return new self($rows, null);
    }

    public static function fail(string $error): self
    {
        return new self(null, $error);
    }

    public function isOk(): bool
    {
        return $this->error === null;
    }

    public function rows(): Collection
    {
        if ($this->rows === null) {
            throw new \LogicException('Result sin filas: revisa isOk() antes de rows()');
        }

        return $this->rows;
    }

    public function error(): ?string
    {
        return $this->error;
    }
}
