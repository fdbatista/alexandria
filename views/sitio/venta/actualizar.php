<?php

use app\models\Venta;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Venta */

$this->title = 'Modificar Venta';
$this->menu_activo = 'venta';
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Venta ' . Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y']), 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="venta-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', ['model' => $model, 'usuarios' => $usuarios, 'esLibrero' => $esLibrero]) ?>

</div>
