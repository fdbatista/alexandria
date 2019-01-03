<?php

use app\models\Tematica;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Tematica */

$this->title = 'Crear Temática';
$this->menu_activo = 'tematica';
$this->params['breadcrumbs'][] = ['label' => 'Temáticas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tematica-create">

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
