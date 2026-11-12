<?php

// Migración histórica. La tabla `pedidos` ya no la alimenta el reporte mensual.
return [
    'up' => <<<SQL
        CREATE TABLE pedidos (
            folio VARCHAR(12) PRIMARY KEY,
            fecha DATE NOT NULL,
            cliente_rfc VARCHAR(13) NOT NULL,
            estatus CHAR(1) NOT NULL,
            total DECIMAL(12,2) NOT NULL,
            moneda CHAR(3) NOT NULL DEFAULT 'MXN'
        );
        SQL,
    'down' => 'DROP TABLE pedidos;',
];
