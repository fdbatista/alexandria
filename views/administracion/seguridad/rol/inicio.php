<?php

use app\models\search\RolSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RolSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php Url::remember();?>
    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{permisos}',
                'buttons' => [
                    'permisos' => function ($key) {
                        return '&nbsp;<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Permisos" data-pjax="0"><span class="glyphicon glyphicon-lock"></span></a>';
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
