<?php

use app\models\Traza;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Traza */

$this->title = 'Vista previa';
$this->menu_activo = 'traza';
$this->params['breadcrumbs'][] = ['label' => 'Trazas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traza-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/traza/inicio')]) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Usuario',
                'attribute' => 'idUsuario.nombre_usuario',
            ],
            [
                'label' => 'Fecha y hora',
                'attribute' => 'fecha_hora',
                'format' => ['date', 'php:d/m/Y' . ' - ' . 'h:m a']
            ],
            'tipo_objeto',
            [
                'attribute' => 'descripcion',
                'format' => 'html',
                'value' => $model->descripcion
            ],
            [
                'attribute' => 'accion',
                'format' => 'html',
                'value' => $model->accion
            ],
        ],
    ])
    ?>

</div>
