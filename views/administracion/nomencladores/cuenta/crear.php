<?php

use app\models\Cuenta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Cuenta */

$this->title = 'Crear Cuenta';
?>
<div class="cuenta-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/cuenta/inicio')]) ?>
    </p>


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
