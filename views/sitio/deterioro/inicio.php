<?php

use app\controllers\StaticMembers;
use app\models\search\DeterioroSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel DeterioroSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Deterioros';
$this->menu_activo = 'deterioro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deterioro-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('sitio/deterioro/crear')]) ?>
        <?= Html::tag('a', "<i class='fa fa-times'></i> Ejecutar", ['class' => "btn btn-danger $classActivo", 'href' => Url::toRoute('sitio/deterioro/ejecutar'), 'data-confirm' => "¿Confirma que desea ejecutar este Listado de Deterioro?", 'data-method' => "post"]) ?>
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
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'label' => 'Título',
                'attribute' => 'idProducto',
                'value' => 'idProducto.titulo'
            ],
            [
                'label' => 'Librero',
                'attribute' => 'idUsuario',
                'value' => 'idUsuario.nombre1'
            ],
            'cantidad',
            [
                'label' => 'Importe Venta',
                'value' => 'importe_venta',
            ],
            [
                'label' => 'Importe Costo',
                'value' => 'importe_costo',
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{actualizar} {eliminar}',
                'buttons' =>
                [
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
