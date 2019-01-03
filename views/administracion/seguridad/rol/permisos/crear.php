<?php

use app\models\RolPermiso;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model RolPermiso */

$this->title = 'Asignar Permiso';
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
$nombre_rol = $model->idRol ? $model->idRol->nombre : '';
?>
<div class="rol-permiso-create">

    <h2>Adicionar Permiso al Rol: <?= $nombre_rol ?></h2>

    <p>
        <?= Html::a('Regresar', ['permisos', 'id' => $model->id_rol], ['class' => 'btn btn-primary']) ?>
    </p>    

    <?= $this->render('_form', ['model' => $model, 'permisos' => $permisos]) ?>

</div>
