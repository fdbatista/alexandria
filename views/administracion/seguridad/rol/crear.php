<?php

use app\models\Rol;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Rol */

$this->title = 'Crear Rol';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/rol/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
