<?php

use app\models\RolPermiso;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model RolPermiso */

$this->title = 'Modificar Permiso';
$this->params['breadcrumbs'][] = ['label' => 'Rol Permisos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
$nombre_rol = $model->idRol ? $model->idRol->nombre : '';
?>
<div class="rol-permiso-update">

    <h2>Modificar Permiso del Rol: <?= $nombre_rol ?></h2>

    <p>
        <?= Html::a('Regresar', ['permisos', 'id' => $model->id_rol], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', ['model' => $model, 'permisos' => $permisos]) ?>

</div>
