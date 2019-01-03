<?php

use app\models\Suministrador;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Suministrador */

$this->title = 'Modificar Suministrador: ' . $model->nombre;
?>
<div class="suministrador-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/suministrador/inicio')]) ?>
    </p>

    <?= $this->render('_form', ['model' => $model,]) ?>

</div>
