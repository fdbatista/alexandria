<?php

use app\models\Receptor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Receptor */

$this->title = 'Crear Receptor';
?>
<div class="receptor-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/receptor/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
