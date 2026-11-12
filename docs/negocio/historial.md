# Historial de cambios del sistema de ventas

- **2019** — Primer importador (`legacy/importador_2019.php`). Escribía directo a MySQL.
- **2021** — Se crea la librería interna `Acme` para dejar de depender de paquetes externos en el servidor de producción (sin acceso a internet).
- **2022** — Se agrega canal de mayoreo (`M`). Se incorpora el cliente Sunbelt en USD.
- **2023** — Intento de reescribir el reporte (`src/Reportes/reporte_v2_NO_USAR.php`). Se abandonó porque no cuadraba con contabilidad.
- **2025** — Migración de la tienda en línea a nueva plataforma. Cambia el formato de exportación.
- **2026** — Contabilidad reporta diferencias en el reporte mensual de algunos clientes.
