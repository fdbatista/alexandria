<?php

use app\models\Permiso;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Permiso */

$this->title = 'Modificar Permiso: ' . $model->nombre . ' ' . $model->entidad_html;
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="permiso-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/permiso/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
