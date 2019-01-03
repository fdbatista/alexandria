<?php

use app\models\Venta;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Venta */

$this->title = 'Crear Venta';
$this->menu_activo = 'venta';
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', ['model' => $model, 'usuarios' => $usuarios, 'esLibrero' => $esLibrero]) ?>

</div>
