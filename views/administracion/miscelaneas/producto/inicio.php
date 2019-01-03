<?php

use app\models\search\ProductoSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ProductoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Productos';
$this->menu_activo = 'producto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php
    include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php';
    Url::remember();
    ?>

    <p>
    <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('administracion/miscelaneas/producto/crear')]) ?>
    </p>
    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'codigo',
            'titulo',
            'existencia',
            'precio_venta',
            'precio_costo',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalles} {actualizar} {eliminar} {autores}',
                'buttons' =>
                [
                    'detalles' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Detalles"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                    'actualizar' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Modificar"><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                    'autores' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Autores"><span class="glyphicon glyphicon-user"></span></a>';
                    },
                    'eliminar' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Eliminar" data-confirm="Confirmar eliminación de este elemento" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
