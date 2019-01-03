<?php

use app\models\EfectivoEntrega;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model EfectivoEntrega */

$this->title = 'Detalles';
?>
<div class="efectivo-entrega-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/efectivo-entrega/inicio')]) ?>
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
                'label' => 'Receptor',
                'attribute' => 'idReceptor.nombre',
            ],
        ],
    ])
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="h5 title-block-1"><b>Devoluciones</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <?php
                        foreach ($devoluciones as $devolucion) {
                            echo '<li><a href="' . Url::to(['/sitio/devolucion/detalles', 'id' => $devolucion->id]) . '">Devolución ' . $devolucion->numero . ' - ' . Yii::$app->formatter->format($devolucion->fecha, ['date', 'php:d/m/Y']) . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
