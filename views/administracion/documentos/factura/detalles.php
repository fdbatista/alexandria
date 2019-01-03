<?php

use app\models\Factura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Factura */

$this->title = 'Detalles';
$this->menu_activo = 'factura';
$this->params['breadcrumbs'][] = ['label' => 'Facturas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Factura ' . $model->numero, 'url' => ['detalles', 'id' => $model->id, 'id_devolucion' => $model->id_devolucion]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="factura-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/documentos/factura/inicio')]) ?>
        <?= Html::a('Modificar', ['actualizar', 'id' => $model->id, 'id_devolucion' => $model->id_devolucion], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('Eliminar', ['eliminar', 'id' => $model->id, 'id_devolucion' => $model->id_devolucion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Confirmar eliminación de este elemento',
                'method' => 'post',
            ],
        ])
        ?>
        <?= Html::tag('a', "<i class='glyphicon glyphicon-export'></i> Exportar", ['class' => 'btn btn-info', 'href' => Url::toRoute('administracion/documentos/factura/exportar-documento?id=' . $model->id)]) ?>
    </p>

    <table class="table table-bordered" style="border-left: 1px solid #aaa">
        <tr>
            <td colspan="8" class="text-center"><b>FACTURA</b></td>
        </tr>
        <tr>
            <td colspan="8" class="text-uppercase">SUMINISTRADOR: <?= $model->idSuministrador->nombre ?></td>
        </tr>
        <tr>
            <td colspan="8">CÓDIGO: <?= $model->idSuministrador->codigo ?></td>
        </tr>
        <tr>
            <td colspan="5">CÓDIGO NIT: <?= $model->idSuministrador->codigo_nit ?></td>
            <td colspan="3">FACTURA No.: <?= $model->numero ?></td>
        </tr>
        <tr>
            <td colspan="5">CUENTA BANCARIA: <?= $model->idSuministrador->cuenta_bancaria ?></td>
            <td colspan="3">FECHA: <?= Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']); ?></td>
        </tr>
        <tr>
            <td colspan="8">AGENCIA: <?= $model->idSuministrador->agencia ?></td>
        </tr>
        <tr>
            <td colspan="8" class="text-uppercase">DIRECCI&Oacute;N: <?= $model->idSuministrador->direccion ?></td>
        </tr>
        <tr>
            <td colspan="8" class="text-uppercase">RECEPTOR: <?= $model->idDevolucion->idEfectEntr->idReceptor->nombre ?></td>
        </tr>
        <tr>
            <td colspan="8" class="text-uppercase">EFECTIVO ENTREGA EN: <?= $model->idDevolucion->idEfectEntr->nombre ?></td>
        </tr>
        <tr>
            <td colspan="5">CÓDIGO: <?= $model->idDevolucion->idEfectEntr->idReceptor->codigo ?></td>
            <td colspan="3">CÓDIGO NIT: <?= $model->idDevolucion->idEfectEntr->idReceptor->codigo_nit ?></td>
        </tr>
        <tr>
            <td colspan="5">CUENTA BANCARIA: <?= $model->idDevolucion->idEfectEntr->idReceptor->cuenta_bancaria ?></td>
            <td colspan="3">AGENCIA: <?= $model->idDevolucion->idEfectEntr->idReceptor->agencia ?></td>
        </tr>
        <tr>
            <td colspan="8" class="text-uppercase">DIRECCI&Oacute;N: <?= $model->idDevolucion->idEfectEntr->idReceptor->direccion ?></td>
        </tr>
        <tr>
            <th>C&oacute;digo</th>
            <th>Descripci&oacute;n</th>
            <th>Unidad</th>
            <th>Cantidad Título</th>
            <th>Precio Mayor</th>
            <th>Precio Venta</th>
            <th>Importe Mayor</th>  
            <th>Importe Venta</th>
        </tr>
        <tbody class="text-center">
            <?php
            $i = 1;
            $importeVentaTotal = 0;
            $importeCostoTotal = 0;
            $cantidadTotal = 0;
            $productos = $model->idDevolucion->devolucionProductos;
            foreach ($productos as $producto) {
                $productoAux = $producto->idProducto;
                $importeVentaAux = $producto->precio_venta * $producto->cantidad;
                $importeCostoAux = $producto->precio_costo * $producto->cantidad;
                $importeCostoTotal += $importeCostoAux;
                $importeVentaTotal += $importeVentaAux;
                $cantidadTotal += $producto->cantidad;
                echo '<tr>';
                echo '<td>' . $productoAux->codigo . '</td>';
                echo '<td class="text-left">' . $productoAux->titulo . '</td>';
                echo '<td></td>';
                echo '<td>' . $producto->cantidad . '</td>';
                echo '<td>' . $producto->precio_costo . '</td>';
                echo '<td>' . $producto->precio_venta . '</td>';
                echo '<td>' . $importeCostoAux . '</td>';
                echo '<td>' . $importeVentaAux . '</td>';
                echo '</tr>';
            }
            for ($j = $i; $j < 25; $j++) {
                echo '<tr>';
                echo '<td></td>';
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
                <td colspan="2" class="text-right"><b>Total</b></td>
                <td></td>
                <td><?= $cantidadTotal ?></td>
                <td></td>
                <td></td>
                <td ><?= $importeCostoTotal ?></td>
                <td><?= $importeVentaTotal ?></td>
            </tr>
            <tr class="text-left">
                <td colspan="4">ENTREGADO. NOMBRE: </td>
                <td colspan="4">RECIBIDO: </td>
            </tr>
            <tr class="text-left">
                <td colspan="4">CARGO: </td>
                <td colspan="4">CARGO: </td>
            </tr>
            <tr class="text-left">
                <td colspan="4">FIRMA: </td>
                <td colspan="4">FIRMA: </td>
            </tr>
            <tr class="text-left">
                <td colspan="4">CI: </td>
                <td colspan="4">CI: </td>
            </tr>
        </tbody>

    </table>

</div>
