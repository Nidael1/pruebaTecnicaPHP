# Prueba técnica — Reporte de ventas mensuales

## Contexto

ACME vende por tres canales (tienda física, tienda en línea y mayoreo). Cada mes se genera un reporte de ventas por cliente a partir de la exportación del ERP.

Contabilidad reporta que **el reporte de octubre 2026 no cuadra** para algunos clientes:

- `GOMA850312KJ3`: según contabilidad son **27 pedidos por $353,047.32**.
- `MERJ881122QW9`: no aparece en el reporte, y según contabilidad son **21 pedidos por $330,759.61**.
- `DIS200617MN8` sí cuadra.

## Tu tarea

1. Encuentra la causa raíz de las diferencias y corrígela.
2. Deja pasando `php tests/run.php`.
3. Escribe un `ENTREGA.md` (máximo media página) con la causa raíz, qué cambiaste y por qué.

## Reglas

- Puedes usar las herramientas que quieras, incluida la IA.
- Este repositorio es un sistema en producción: **haz el cambio mínimo necesario**. Una reescritura no se considera una solución.
- No agregues dependencias (el servidor de producción no tiene acceso a internet ni Composer).
- No modifiques `data/`, `tests/` ni `lib/`.
- Tiempo sugerido: 90 minutos.

## Cómo correrlo

```bash
php bin/reporte.php data/pedidos_2026_10.csv 2026 10
php tests/run.php
```

Requiere PHP 8.2 o superior. La documentación está en `docs/`.
