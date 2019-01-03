<?php

use app\models\Transferencia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Transferencia */

$this->title = 'Modificar Transferencia ' . $model->numero;
$this->menu_activo = 'transferencia';
$this->params['breadcrumbs'][] = ['label' => 'Transferencias', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = ['label' => 'Transferencia ' . $model->numero, 'url' => ['detalles', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="transferencia-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/documentos/transferencia/inicio')]) ?>
    </p>

    <?= $this->render('_form', ['model' => $model, 'id_cuenta' => $id_cuenta]) ?>

</div>
