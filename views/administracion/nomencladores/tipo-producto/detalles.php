<?php

use app\models\TipoProducto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model TipoProducto */

$this->title = 'Vista previa';
$this->menu_activo = 'tipo-producto';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Productos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-producto-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/tipo-producto/inicio')]) ?>
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
                'label' => 'Cuenta',
                'attribute' => 'idCuenta.nombre',
            ],
        ],
    ])
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="h5 title-block-1"><b>Productos</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <?php
                        foreach ($productos as $producto) {
                            echo '<li><a href="' . Url::to(['/administracion/miscelaneas/producto/detalles', 'id' => $producto->id]) . '">' . $producto->titulo . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
