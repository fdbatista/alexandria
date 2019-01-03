<?php

use app\models\RebajaPrecio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model RebajaPrecio */

$this->title = 'Modificar Rebaja de Precio ' . Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']);
$this->menu_activo = 'rebaja-precio';
$this->params['breadcrumbs'][] = ['label' => 'Rebaja de Precios', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Rebaja de Precio ' . $model->fecha, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="rebaja-precio-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/documentos/rebaja-precio/inicio')]) ?>
    </p>


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
