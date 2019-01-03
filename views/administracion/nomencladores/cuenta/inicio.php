<?php

use app\models\search\CuentaSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CuentaSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Cuentas';
?>
<div class="cuenta-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('administracion/nomencladores/cuenta/crear')]) ?>
    </p>
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
                'template' => '{detalles} {actualizar} {eliminar}',
                'buttons' =>
                [
                    'detalles' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Detalles"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                    'actualizar' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Modificar"><span class="glyphicon glyphicon-pencil"></span></a>';
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
