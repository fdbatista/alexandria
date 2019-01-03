<?php

use app\models\Devolucion;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Devolucion */

$this->title = 'Detalles';
$this->menu_activo = 'devolucion';
$this->params['breadcrumbs'][] = ['label' => 'Devoluciones', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Devolución ' . $model->numero, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devolucion-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

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
            <th colspan="8" class="text-center">Devolución de Punto de Venta al Almacén para Factura a <?= $model->idEfectEntr->nombre ?></th>
        </tr>
        <tr style="font-weight: bold;">
            <th colspan="4">Cuenta: <?= $cuentaDev ?></th>
            <td colspan="2">Dev: <?= $model->numero ?></td>
            <td colspan="2">Fecha: <?= Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']); ?></td>
        </tr>
        <tr>
            <th style="width: 20px;">No.</th>
            <th style="width: 100px;">C&oacute;digo</th>
            <th style="width: 500px;">T&iacute;tulo</th>
            <th style="width: 100px;">Cantidad</th>
            <th style="width: 150px;">Precio Venta</th>
            <th style="width: 150px;">Precio Costo</th>
            <th style="width: 150px;">Importe Venta</th>
            <th style="width: 150px;">Importe Costo</th>
        </tr>
        <tbody class="text-center">
            <?php
            $productos = $model->devolucionProductos;
            $i = 1;
            $importeVentaTotal = 0;
            $importeCostoTotal = 0;
            $cantidadTotal = 0;
            foreach ($productos as $producto) {
                $productoAux = $producto->idProducto;
                $importeVentaAux = $productoAux->precio_venta * $producto->cantidad;
                $importeCostoAux = $productoAux->precio_costo * $producto->cantidad;
                $importeVentaTotal += $importeVentaAux;
                $importeCostoTotal += $importeCostoAux;
                $cantidadTotal += $producto->cantidad;
                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $productoAux->codigo . '</td>';
                echo '<td class="text-left">' . $productoAux->titulo . '</td>';
                echo '<td>' . $producto->cantidad . '</td>';
                echo '<td>' . $productoAux->precio_venta . '</td>';
                echo '<td>' . $productoAux->precio_costo . '</td>';
                echo '<td>' . $importeVentaAux . '</td>';
                echo '<td>' . $importeCostoAux . '</td>';
                echo '</tr>';
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="3" class="text-right">Total</td>
                <td><?= $cantidadTotal ?></td>
                <td></td>
                <td></td>
                <td><?= $importeVentaTotal ?></td>
                <td><?= $importeCostoTotal ?></td>
            </tr>
            <tr class="text-left" style="font-weight: bold;">
                <td colspan="4">Entrega:  <?= $model->idUsuario->nombre1 . " " . $model->idUsuario->apellido1 . " " . $model->idUsuario->apellido2 ?></td>
                <td colspan="4">Recibe: </td>
            </tr>

        </tbody>

    </table>

</div>
