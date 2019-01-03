<?php

use app\models\Producto;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Producto */

$this->title = 'Detalles';
$this->menu_activo = 'producto';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <h2><?= Html::encode($this->title) ?></h2>

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
