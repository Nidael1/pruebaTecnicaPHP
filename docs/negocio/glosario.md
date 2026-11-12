# Glosario de negocio — Ventas

Documento mantenido por Operaciones. Última revisión: marzo 2026.

## Folios

- El prefijo indica el canal: `T` tienda física, `W` tienda en línea, `M` mayoreo.
- El folio es único por pedido. Si aparece más de una vez en la exportación, **la última línea del archivo es la vigente** (el ERP exporta en orden de captura).
- Los folios `T-009xxx` están reservados para pruebas de caja.

## Estatus

| Clave | Significado | ¿Cuenta como venta? |
|---|---|---|
| `A` | Activo | Sí |
| `P` | Pendiente de pago (crédito a 30 días) | **Sí**. Contabilidad lo registra al facturar. |
| `R` | Reexpedido: sustituye a todas las líneas anteriores del mismo folio. Puede corregir monto o fecha. | Sí |
| `C` | Cancelado | No |

## Fechas

- La tienda física y mayoreo capturan en formato `dd/mm/aaaa`.
- La tienda en línea (folios `W`) exporta en ISO `aaaa-mm-dd` desde la migración de plataforma de 2025.
- El mes de la venta es el de la fecha **vigente** del pedido (ver reexpedidos).

## Clientes

- El RFC identifica al cliente. La tienda en línea lo captura tal como lo escribe el cliente: puede venir en minúsculas, con espacios o con guiones. Usar `normaliza_rfc()` antes de comparar o agrupar.
- El nombre del cliente puede venir con caracteres raros en pedidos viejos de caja; es solo informativo, el reporte se agrupa por RFC.

## Montos

- Todos los montos incluyen IVA.
- Mayoreo internacional se cobra en USD. Para el cierre se usa el tipo de cambio fijo de `config/tasas.php`, aplicado **por pedido**.
- Los montos pueden venir con `$` y separador de miles.

## Otros términos

- **Corte**: cierre diario de caja por sucursal.
- **Devolución**: no se refleja en esta exportación; va en `devoluciones_*.csv` (no aplica a este reporte).
- **Mostrador**: venta de tienda física sin cliente registrado (RFC genérico `XAXX010101000`).
