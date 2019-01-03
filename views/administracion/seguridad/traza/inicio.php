<?php

use app\models\search\TrazaSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel TrazaSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Trazas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traza-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Usuario',
                'attribute' => 'idUsuario',
                'value' => 'idUsuario.nombre_usuario'
            ],
            [
                'label' => 'Fecha y hora',
                'attribute' => 'fecha_hora',
                'value' => 'fecha_hora',
                'format' => ['date', 'php:d/m/Y' . ' - ' . 'h:m a']
            ],
            [
                'attribute' => 'descripcion',
                'format' => 'html',
                'value' => 'descripcion'
            ],
            [
                'attribute' => 'accion',
                'format' => 'html',
                'value' => 'accion'
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
