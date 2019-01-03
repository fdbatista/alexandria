<?php

use app\models\Autor;
use app\models\ProductoAutor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Autor */

$this->title = 'Detalles';
?>
<div class="autor-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/miscelaneas/autor/inicio')]) ?>
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

            'nombre_completo',
            'sexo',
            [
                'label' => 'País',
                'attribute' => 'idPais.nombre',
            ],
        ],
    ])
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="h5 title-block-1"><b>Libros</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <?php
                        $productos = ProductoAutor::find()->where(['id_autor' => $model->id])->all();
                        foreach ($productos as $producto) {
                            echo '<li><a href="' . Url::to(['/administracion/miscelaneas/producto/detalles', 'id' => $producto->idProducto->id]) . '">' . $producto->idProducto->titulo . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>