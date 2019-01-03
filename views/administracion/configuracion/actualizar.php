<?php

use app\models\ConfigApp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model ConfigApp */

$this->title = 'Modificar Configuración';
?>
<div class="config-app-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/configuracion/detalles')]) ?>    
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
