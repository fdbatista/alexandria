<?php

use app\models\Permiso;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Permiso */

$this->title = 'Vista previa';
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/permiso/inicio')]) ?>
        <?= Html::a('Modificar', ['actualizar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'entidad',
            [
                'format' => 'html',
                'attribute' => 'entidad_html',
            ],
            'nombre',
        ],
    ])
    ?>

</div>
