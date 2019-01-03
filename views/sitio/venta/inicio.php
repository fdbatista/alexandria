<?php

use app\models\search\VentaSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel VentaSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Ventas';
$this->menu_activo = 'venta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>
    <?php 
    $f = getdate();
    $fechaPC = $f['year'] . '-' . $f['mon'] . '-' . ($f['mday']); ?>
    <p>
        <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('sitio/venta/crear')]) ?>
        <?= Html::tag('a', "<i class='glyphicon glyphicon-export'></i> Generar Desglose", ['class' => 'btn btn-info', 'href' => Url::toRoute('sitio/venta/exportar-listado?fecha=' . $fechaPC)]) ?>
    </p>
    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'value' => 'fecha',
                'format' => ['date', 'php:d/m/Y'],
            ],
                [
                'label' => 'Librero',
                'attribute' => 'idUsuario',
                'value' => 'idUsuario.nombre1',
            ],
            'cantidadTotal',
            'importeTotal',
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
