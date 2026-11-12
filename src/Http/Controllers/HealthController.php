<?php

declare(strict_types=1);

namespace App\Http\Controllers;

final class HealthController
{
    public function __invoke(): array
    {
        return [
            'status' => 'ok',
            'php' => PHP_VERSION,
            'time' => date('c'),
        ];
    }
}
