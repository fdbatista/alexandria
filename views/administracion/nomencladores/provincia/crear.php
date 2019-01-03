<?php

use app\models\Provincia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Provincia */

$this->title = 'Crear Provincia';
$this->menu_activo = 'provincia';
$this->params['breadcrumbs'][] = ['label' => 'Provincias', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provincia-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/provincia/inicio')]) ?>       
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
