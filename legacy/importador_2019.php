<?php

// Importador original (2019). Ya no se ejecuta; se conserva por auditoría.
// Escribía en MySQL con mysqli. Requiere credenciales que ya no existen.

$db = @mysqli_connect('10.0.0.5', 'ventas', getenv('DB_PASS') ?: '', 'erp');
if (!$db) {
    die("Sin conexión\n");
}

$fh = fopen($argv[1], 'r');
fgetcsv($fh);
while ($r = fgetcsv($fh)) {
    $fecha = date('Y-m-d', strtotime($r[1]));
    $total = floatval(str_replace(',', '', $r[5]));
    mysqli_query($db, "INSERT IGNORE INTO pedidos VALUES ('{$r[0]}','{$fecha}','{$r[2]}','{$r[4]}',{$total},'{$r[6]}')");
}
echo "Listo\n";
