<?php

return [
    'up' => "ALTER TABLE pedidos ADD canal CHAR(1) NOT NULL DEFAULT 'T';",
    'down' => 'ALTER TABLE pedidos DROP COLUMN canal;',
];
