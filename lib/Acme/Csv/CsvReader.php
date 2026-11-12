<?php

declare(strict_types=1);

namespace Acme\Csv;

use Acme\Support\Collection;

final class CsvReader
{
    /**
     * Lee un CSV separado por comas. Quita el BOM y normaliza los ENCABEZADOS
     * (minúsculas, sin espacios). Los VALORES se entregan tal cual vienen.
     * Nunca lanza excepción: revisa Result::isOk().
     */
    public static function read(string $path): Result
    {
        if (!is_readable($path)) {
            return Result::fail("No se puede leer: {$path}");
        }

        $fh = fopen($path, 'rb');
        $header = fgetcsv($fh, null, ',', '"', '');
        if ($header === false) {
            fclose($fh);

            return Result::fail('Archivo vacío');
        }
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        $header = array_map(fn ($h) => strtolower(trim($h)), $header);

        $rows = [];
        while (($line = fgetcsv($fh, null, ',', '"', '')) !== false) {
            if ($line === [null]) {
                continue;
            }
            if (count($line) !== count($header)) {
                fclose($fh);

                return Result::fail('Fila con columnas incorrectas: ' . implode(',', $line));
            }
            $rows[] = array_combine($header, $line);
        }
        fclose($fh);

        return Result::ok(new Collection($rows));
    }
}
