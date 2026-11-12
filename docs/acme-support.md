# Librería interna `Acme`

Librería propia del equipo (2021). Su API se parece a Laravel a propósito, pero **no es Laravel**. No uses `illuminate/*` ni Carbon en este proyecto.

## `Acme\Csv\CsvReader`

```php
$resultado = CsvReader::read($ruta);   // nunca lanza excepción
if (!$resultado->isOk()) { ... $resultado->error() ... }
$filas = $resultado->rows();           // Acme\Support\Collection de arrays asociativos
```

- Quita el BOM y normaliza **solo los encabezados** (minúsculas, sin espacios alrededor).
- Los **valores** se entregan exactamente como vienen en el archivo.
- No convierte el encoding.

## `Acme\Support\Collection`

| Método | Diferencia contra Laravel |
|---|---|
| `filter(fn)` | Reindexa el resultado. |
| `unique('campo')` | Conserva la **última** aparición, no la primera. |
| `groupBy('campo')` | Agrupa por el valor crudo; no normaliza. |
| `sortBy('campo')` | **No estable**: los empates quedan en orden aleatorio. |
| `sum()`, `where()`, `keyBy()` | No existen. Usa `reduce()` o `filter()`. |

## `Acme\Support\Date`

```php
Date::parse('03/10/2026');                        // 3 de octubre (d/m/Y por omisión)
Date::parse('2026-10-03');                        // null: no coincide con d/m/Y
Date::parse($valor, 'd/m/Y', 'Y-m-d');            // prueba los formatos en orden
```

Devuelve `?DateTimeImmutable`. Nunca lanza excepción. **No uses `strtotime()`**: interpreta `03/10/2026` como 10 de marzo (m/d/Y).

## `Acme\Support\Money`

Montos en centavos (`int`). **Inmutable**: cada operación devuelve una instancia nueva.

```php
$total = Money::zero();
$total->add($monto);            // ❌ no hace nada: el resultado se pierde
$total = $total->add($monto);   // ✅
```

- `Money::parse('$1,234.50')` acepta `$`, comas y espacios; devuelve `null` si no es válido.
- `multiply('17.50')` recibe el factor como string; redondea half-up al centavo.
- Nunca uses `float` para sumar dinero.
