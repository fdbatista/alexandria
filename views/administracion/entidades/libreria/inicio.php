<?php

use app\models\search\LibreriaSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel LibreriaSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Librerías';
?>
<div class="libreria-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>
    <?php Url::remember(); ?>
    <p>
        <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('administracion/entidades/libreria/crear')]) ?>
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
                'label' => 'Categoría',
                'attribute' => 'idCategoria',
                'value' => 'idCategoria.nombre'
            ],
            'direccion',
            'telefono',
                [
                'label' => 'Municipio',
                'attribute' => 'idMunicipio',
                'value' => 'idMunicipio.nombre'
            ],
                [
                'label' => 'Provincia',
                'attribute' => 'idMunicipio.idProvincia',
                'value' => 'idMunicipio.idProvincia.nombre'
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
