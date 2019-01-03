<?php

use app\models\Receptor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Receptor */

$this->title = 'Detalles';
?>
<div class="receptor-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/receptor/inicio')]) ?>
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
            'codigo',
            'codigo_nit',
            'cuenta_bancaria',
            'agencia',
            'direccion',
            [
                'attribute' => 'descuento_comercial',
                'value' => $model->descuento_comercial . '%'
            ]
        ],
    ])
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="h5 title-block-1"><b>Efectivos Entrega</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <?php
                        foreach ($efectivos_entrega as $efectivo_entrega) {
                            echo '<li><a href="' . Url::to(['/administracion/entidades/efectivo-entrega/detalles', 'id' => $efectivo_entrega->id]) . '">' . $efectivo_entrega->nombre . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
