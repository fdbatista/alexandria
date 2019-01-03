<?php

use app\models\search\PermisoSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PermisoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Permisos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'attribute' => 'entidad',
                'label' => 'Entidad',
            ],
            'nombre',
            /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalles} {actualizar}',
                'buttons' =>
                [
                    'detalles' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Detalles"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                    'actualizar' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Modificar"><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                ]
            ],*/
        ],
    ]);
    ?>
</div>
