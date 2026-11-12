<?php /** @var array $reporte @var int $anio @var int $mes */ ?>
<h1>Ventas de <?= htmlspecialchars(mes_nombre($mes)) ?> <?= $anio ?></h1>
<table>
    <thead><tr><th>RFC</th><th>Cliente</th><th>Pedidos</th><th>Total MXN</th></tr></thead>
    <tbody>
    <?php foreach ($reporte as $fila): ?>
        <tr>
            <td><?= htmlspecialchars($fila['rfc']) ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= $fila['pedidos'] ?></td>
            <td style="text-align:right"><?= $fila['total']->format() ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
