<?php

use app\models\Devolucion;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Devolucion */

$this->title = 'Crear Devolución';
$this->menu_activo = 'devolucion';
$this->params['breadcrumbs'][] = ['label' => 'Devoluciones', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devolucion-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', ['model' => $model,'id_cuenta' => '','usuarios' => $usuarios, 'descomercial' => $descomercial, 'esLibrero' => $esLibrero]) ?>

</div>
