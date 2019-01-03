<?php

use app\models\Asociacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Asociacion */

$this->title = 'Vista previa';
$this->menu_activo = 'asociacion';
$this->params['breadcrumbs'][] = ['label' => 'Asociaciones', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asociacion-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/asociacion/inicio')]) ?>
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
            'nombre',
        ],
    ])
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="h5 title-block-1"><b>Editoriales</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <?php
                        foreach ($editoriales as $editorial) {
                            echo '<li><a href="' . Url::to(['/administracion/entidades/editorial/detalles', 'id' => $editorial->id]) . '">' . $editorial->nombre . '</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>
