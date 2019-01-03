<?php

use app\models\Municipio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Municipio */

$this->title = 'Vista previa';
$this->menu_activo = 'municipio';
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="municipio-view">

    <h2><?= Html::encode($this->title) ?></h2>    

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/municipio/inicio')]) ?>
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
        <?= Html::a('Regresar', ['inicio'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombre',
            [
                'label' => 'Provincia',
                'attribute' => 'idProvincia.nombre',
            ],
        ],
    ])
    ?>

</div>
