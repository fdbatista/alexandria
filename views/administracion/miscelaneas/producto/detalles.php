<?php

use app\models\Producto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Producto */

$this->title = 'Detalles';
?>
<div class="producto-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/miscelaneas/producto/inicio')]) ?>
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

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'codigo',
            [
                'label' => 'Tipo de Producto',
                'attribute' => 'idTipoProducto.nombre',
            ],
            'titulo',
            'tomo',
            'volumen',
            'precio_venta',
            'precio_costo',
            'existencia',
            [
                'label' => 'Tipo de Literatura',
                'attribute' => 'idTipoLiteratura.nombre',
            ],
            [
                'label' => 'Editorial',
                'attribute' => 'idEditorial.nombre',
            ],
            'anho_edicion',
            [
                'label' => 'Género',
                'attribute' => 'idGenero.nombre',
            ],
            [
                'label' => 'Temática',
                'attribute' => 'idTematica.nombre',
            ],
            [
                'label' => 'Tipo de Público',
                'attribute' => 'idTipoPublico.nombre',
            ],
            'numero',
            'anho_revista',
            'observaciones',
        ],
    ])
    ?>

</div>
