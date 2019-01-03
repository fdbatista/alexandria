<?php

use app\models\Venta;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Venta */

$this->title = 'Detalles';
$this->menu_activo = 'venta';
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Venta ' . Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']), 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Modificar', ['actualizar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('Eliminar', ['eliminar', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Confirmar eliminación de este elemento',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <table class="table table-bordered " style="border-left: 1px solid #aaa">
        <tr>
            <th colspan="7" class="text-center">Venta <?= $model->id . " - " . Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']); ?></th>
        </tr>
<!--        <tr style="font-weight: bold;">
            <td colspan="7">Fecha: </?= Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']); ?></td>
        </tr>-->
        <tr>
            <th style="width: 20px;">No.</th>
            <th style="width: 100px;">C&oacute;digo</th>
            <th style="width: 500px;">T&iacute;tulo</th>
            <th style="width: 100px;">Cantidad</th>
            <th style="width: 150px;">Precio Venta</th>
            <th style="width: 150px;">Precio Costo</th>
            <th style="width: 150px;">Importe Venta</th>
        </tr>
        <tbody class="text-center">
            <?php
            $productos = $model->ventaProductos;
            $i = 1;
            $importeVentaTotal = 0;
            $cantidadTotal = 0;
            foreach ($productos as $producto) {
                $productoAux = $producto->idProducto;
                $importeVentaAux = $producto->precio * $producto->cantidad;
                $importeVentaTotal += $importeVentaAux;
                $cantidadTotal += $producto->cantidad;
                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $productoAux->codigo . '</td>';
                echo '<td class="text-left">' . $productoAux->titulo . '</td>';
                echo '<td>' . $producto->cantidad . '</td>';
                echo '<td>' . $producto->precio . '</td>';
                echo '<td>' . $productoAux->precio_costo . '</td>';
                echo '<td>' . $importeVentaAux . '</td>';
                echo '</tr>';
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="3" class="text-right">Total</td>
                <td><?= $cantidadTotal ?></td>
                <td></td>
                <td></td>
                <td><?= $importeVentaTotal ?></td>
            </tr>
            <tr class="text-left" style="font-weight: bold;">
                <td colspan="3">Entrega: <?= $model->idUsuario->nombre1 . " " . $model->idUsuario->apellido1 . " " . $model->idUsuario->apellido2 ?></td>
                <td colspan="5">Recibe: </td>
            </tr>

        </tbody>

    </table>

</div>
