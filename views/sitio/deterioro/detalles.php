<?php

use app\models\Deterioro;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Deterioro */

$this->title = 'Detalles';
$this->menu_activo = 'deterioro';
$this->params['breadcrumbs'][] = ['label' => 'Deterioros', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Deterioro ' . Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']), 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deterioro-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Modificar', ['actualizar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('Eliminar', ['eliminar', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Confirmar eliminación de este elemento',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Título',
                'attribute' => 'idProducto.titulo',
            ],
            'cantidad',
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => ['date', 'php:d/m/Y']
            ],
        ],
    ])
    ?>

</div>
