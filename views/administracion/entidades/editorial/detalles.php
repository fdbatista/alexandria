<?php

use app\models\Editorial;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Editorial */

$this->title = 'Detalles';
?>
<div class="editorial-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/editorial/inicio')]) ?>
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
            //'id',
            'nombre',
            [
                'label' => 'Asociación',
                'attribute' => 'idAsociacion.nombre',
            ],
            [
                'label' => 'Provincia',
                'attribute' => 'idProvincia.nombre',
            ],
            'direccion',
            [
                'label' => 'País',
                'attribute' => 'idPais.nombre',
            ],
        ],
    ])
    ?>

    

</div>
