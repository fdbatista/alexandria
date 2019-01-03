<?php

use app\models\Autor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Autor */

$this->title = 'Crear Autor';
?>
<div class="autor-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/miscelaneas/autor/inicio')]) ?>
    </p>


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
