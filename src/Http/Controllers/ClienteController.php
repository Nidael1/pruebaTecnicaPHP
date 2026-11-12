<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cliente;

final class ClienteController
{
    public function show(string $rfc): array
    {
        $cliente = Cliente::buscar(normaliza_rfc($rfc));
        if ($cliente === null) {
            http_response_code(404);

            return ['error' => 'Cliente no encontrado'];
        }

        return $cliente->toArray();
    }

    public function index(): array
    {
        return array_map(fn (Cliente $c) => $c->toArray(), Cliente::todos());
    }
}
