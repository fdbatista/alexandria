<?php

use app\models\Municipio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Municipio */

$this->title = 'Crear Municipio';
$this->menu_activo = 'municipio';
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="municipio-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/municipio/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
