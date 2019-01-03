<?php

use app\models\Producto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Producto */

$this->title = 'Crear Producto';
?>
<div class="producto-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/miscelaneas/producto/inicio')]) ?>
    </p>

</div>

<?= $this->render('_form', ['model' => $model, 'id_cuenta' => '', 'atributos' => $atributos]) ?>

</div>
