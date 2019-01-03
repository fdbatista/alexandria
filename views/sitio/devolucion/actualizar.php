<?php

use app\models\Devolucion;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Devolucion */

$this->title = 'Modificar Devolución ' . $model->numero;
$this->menu_activo = 'devolucion';
$this->params['breadcrumbs'][] = ['label' => 'Devoluciones', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Devolución ' . $model->numero, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="devolucion-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', ['model' => $model,'id_cuenta' => $id_cuenta,'usuarios' => $usuarios, 'descomercial' => $descomercial, 'esLibrero' => $esLibrero]) ?>

</div>
