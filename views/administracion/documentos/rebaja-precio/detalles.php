<?php

use app\models\RebajaPrecio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model RebajaPrecio */

$this->title = 'Detalles';
$this->menu_activo = 'rebaja-precio';
$this->params['breadcrumbs'][] = ['label' => 'Rebaja de Precios', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Rebaja de Precio ' . $model->fecha, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rebaja-precio-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/documentos/rebaja-precio/inicio')]) ?>
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
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => ['date', 'php:d/m/Y']
            ],
            'precio_anterior',
            'precio_nuevo',
        ],
    ])
    ?>

</div>
