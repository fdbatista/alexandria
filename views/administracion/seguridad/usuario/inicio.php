<?php

use app\models\search\UsuarioSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel UsuarioSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Usuarios';
$this->menu_activo = 'usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php Url::remember();?>
    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-plus'></i> $textoBoton", ['class' => 'btn btn-success', 'href' => Url::toRoute('administracion/seguridad/usuario/crear')]) ?>
    </p>
    <?=
    GridView::widget([
        'summary' => '',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre_usuario',
            'nombre_completo',
//            'nombre1',
//            'nombre2',
//            'apellido1',
//            'apellido2',
//            'habilitado_sala_comercial:boolean',
            [
                'label' => 'Rol',
                'attribute' => 'idRol',
                'value' => 'idRol.nombre'
            ],
            'email',
            'activo:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalles} {actualizar} {eliminar}',
                'buttons' =>
                [
                    'actualizar' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Modificar"><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                    'eliminar' => function ($key) {
                        return '<a href="' . $key . '" data-toggle="tooltip" data-placement="top" title="Eliminar" data-confirm="Confirmar eliminación de este usuario" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
                    },
                ]
            ],
        ],
    ]);
    ?> 
</div>
