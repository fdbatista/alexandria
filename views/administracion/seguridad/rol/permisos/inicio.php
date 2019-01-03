<?php

use app\models\search\RolPermisoSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RolPermisoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Permisos del rol: ' . $searchModel->idRol->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-permiso-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Agregar', ['asignar-permiso', 'id' => $searchModel->id_rol], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Regresar', ['inicio', 'id' => $searchModel->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Permiso',
                'attribute' => 'idPermiso',
                'value' => function ($model, $key) {
                    return $model->idPermiso->entidad . ' - ' . $model->idPermiso->nombre;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalles-permiso} {actualizar-permiso} {eliminar-permiso}',
                'buttons' =>
                [
                    'actualizar-permiso' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Modificar"><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                    'eliminar-permiso' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Eliminar" data-confirm="Confirmar eliminación de este elemento" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
