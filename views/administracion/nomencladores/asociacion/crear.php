<?php

use app\models\Asociacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Asociacion */

$this->title = 'Crear Asociación';
$this->menu_activo = 'asociacion';
$this->params['breadcrumbs'][] = ['label' => 'Asociaciones', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asociacion-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/asociacion/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
