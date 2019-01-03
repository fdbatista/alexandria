<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre1') ?>

    <?= $form->field($model, 'nombre2') ?>

    <?= $form->field($model, 'apellido1') ?>

    <?= $form->field($model, 'apellido2') ?>

    <?php // echo $form->field($model, 'habilitado_sala_comercial')->checkbox() ?>

    <?php // echo $form->field($model, 'nombre_usuario') ?>

    <?php // echo $form->field($model, 'contrasenha') ?>

    <?php // echo $form->field($model, 'id_libreria') ?>

    <?php // echo $form->field($model, 'activo')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
