<?php

use app\models\Pais;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Pais */

$this->title = 'Modificar País: ' . $model->nombre;
$this->menu_activo = 'pais';
$this->params['breadcrumbs'][] = ['label' => 'País', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="pais-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/pais/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
