<?php

use app\models\Almacen;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Almacen */

$this->title = 'Detalles';
?>
<div class="almacen-view">

    <h2><?= Html::encode($this->title) ?></h2>    

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/proveedor/inicio')]) ?>
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
            'direccion',
            [
                'label' => 'Municipio',
                'attribute' => 'idMunicipio.nombre',
            ],
            [
                'label' => 'Provincia',
                'attribute' => 'idMunicipio.idProvincia.nombre',
            ],
        ],
    ])
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="h5 title-block-1"><b>Transferencias</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <?php
                        foreach ($transferencias as $transferencia) {
                            echo '<li><a href="' . Url::to(['/administracion/documentos/transferencia/detalles', 'id' => $transferencia->id]) . '">Transferencia ' . $transferencia->numero . ' - ' . Yii::$app->formatter->format($transferencia->fecha, ['date', 'php:d/m/Y']) . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
