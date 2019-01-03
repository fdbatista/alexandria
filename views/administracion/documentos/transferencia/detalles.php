<?php

use app\models\Transferencia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Transferencia */

$this->title = 'Detalles';
$this->menu_activo = 'transferencia';
$this->params['breadcrumbs'][] = ['label' => 'Transferencias', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Transferencia ' . $model->numero, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transferencia-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/documentos/transferencia/inicio')]) ?>
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
        <?= Html::tag('a', "<i class='glyphicon glyphicon-export'></i> Exportar", ['class' => 'btn btn-info', 'href' => Url::toRoute('administracion/documentos/transferencia/exportar-documento?id='.$model->id)]) ?>
    </p>

    <table class="table table-bordered " style="border-left: 1px solid #aaa">
        <tr>
            <th colspan="8" class="text-center">Transferencia</th>
        </tr>
        <tr>
            <th colspan="4">Proveedor: <?= $model->idAlmacen->nombre ?></th>
            <th colspan="4">No.: <?= $model->numero ?></th>

        </tr>
        <tr>
            <th colspan="4">Direcci&oacute;n: <?= $model->idAlmacen->direccion ?></th>
            <th colspan="4">Fecha: <?= Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']); ?></th>
        </tr>
        <tr>
            <th colspan="8">Cuenta: <?= $cuentaTransf ?></th>
        </tr>
        <tr>
            <th>C&oacute;digo</th>
            <th>T&iacute;tulo</th>
            <th>Cantidad</th>
            <th>Precio Venta</th>
            <th>Precio Costo</th>
            <th>Importe Venta</th>
            <th>Importe Costo</th>                        
        </tr>
        <tbody class="text-center">
            <?php
            $productos = $model->transferenciaProductos;
            $i = 1;
            $importeVentaTotal = 0;
            $importeCostoTotal = 0;
            $cantidadTotal = 0;
            foreach ($productos as $producto) {
                $productoAux = $producto->idProducto;
                $importeVentaAux = $producto->precio_venta * $producto->cantidad;
                $importeCostoAux = $productoAux->precio_costo * $producto->cantidad;
                $importeCostoTotal += $importeCostoAux;
                $importeVentaTotal += $importeVentaAux;
                $cantidadTotal += $producto->cantidad;
                echo '<tr>';
                echo '<td>' . $productoAux->codigo . '</td>';
                echo '<td class="text-left"> ' . $productoAux->titulo . '</td>';
                echo '<td>' . $producto->cantidad . '</td>';
                echo '<td>' . $producto->precio_venta . '</td>';
                echo '<td>' . $productoAux->precio_costo . '</td>';
                echo '<td>' . $importeVentaAux . '</td>';
                echo '<td>' . $importeCostoAux . '</td>';
                echo '</tr>';
            }
            for ($j = $i; $j < 19; $j++) {
                echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            ?>
            <tr style="font-weight: bold;">
                <td colspan="2" class="text-right">Total</td>
                <td><?= $cantidadTotal ?></td>
                <td></td>
                <td></td>
                <td><?= $importeVentaTotal ?></td>
                <td><?= $importeCostoTotal ?></td>
            </tr>
        </tbody>

    </table>

</div>
