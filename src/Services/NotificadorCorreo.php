<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Envía el reporte mensual a contabilidad. Deshabilitado en desarrollo.
 */
final class NotificadorCorreo
{
    public function __construct(private readonly bool $habilitado = false)
    {
    }

    public function enviar(string $para, string $asunto, string $cuerpo): bool
    {
        if (!$this->habilitado) {
            log_info("Correo omitido (dev): {$asunto} -> {$para}");

            return true;
        }

        return mail($para, $asunto, $cuerpo);
    }
}
