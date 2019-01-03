<?php

use app\models\RolPermiso;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model RolPermiso */

$this->title = 'Vista previa';
$this->params['breadcrumbs'][] = ['label' => 'Rol Permisos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-permiso-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Modificar', ['actualizar-permiso', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('Eliminar', ['eliminar-permiso', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Confirmar eliminación de este elemento',
                'method' => 'post',
            ],
        ])
        ?>
        <?= Html::a('Regresar', ['permisos', 'id' => $model->id_rol], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_permiso',
                'value' => $model->idPermiso->nombre . ' ' . $model->idPermiso->entidad_html
            ],
        ],
    ])
    ?>

</div>
