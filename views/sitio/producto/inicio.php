<?php

use app\models\search\ProductoSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' =>
        [
            ['class' => 'yii\grid\SerialColumn'],
            'codigo',
            'titulo',
            'existencia',
            'precio_venta',
            'precio_costo',
            [
                'label' => 'Tipo de Literatura',
                'attribute' => 'idTipoLiteratura',
                'value' => 'idTipoLiteratura.nombre'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalles}',
                'buttons' =>
                [
                    'detalles' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Detalles"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
