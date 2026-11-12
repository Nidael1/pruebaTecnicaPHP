<?php

declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $map = [
        'Acme\\' => __DIR__ . '/lib/Acme/',
        'App\\' => __DIR__ . '/src/',
    ];
    foreach ($map as $prefix => $dir) {
        if (str_starts_with($class, $prefix)) {
            $file = $dir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
            if (is_file($file)) {
                require $file;
            }

            return;
        }
    }
});

require __DIR__ . '/src/Support/helpers.php';
