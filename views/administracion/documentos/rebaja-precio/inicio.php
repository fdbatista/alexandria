<?php

use app\models\search\RebajaPrecioSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RebajaPrecioSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Rebaja de Precios';
$this->menu_activo = 'rebaja-precio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rebaja-precio-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('administracion/documentos/rebaja-precio/crear')]) ?>
        <?= Html::tag('a', "<i class='glyphicon glyphicon-export'></i> Exportar", ['class' => 'btn btn-info', 'href' => Url::toRoute('administracion/documentos/rebaja-precio/exportar-listado')]) ?>
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
                'label' => 'Producto',
                'attribute' => 'idProducto',
                'value' => 'idProducto.titulo'
            ],
            'precio_nuevo',
            'precio_anterior',
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
