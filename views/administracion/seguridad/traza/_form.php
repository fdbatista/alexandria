<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Traza */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="traza-form">
<br />
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'fecha_hora')->textInput() ?>

    <?= $form->field($model, 'tipo_objeto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_objeto')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accion')->textInput(['maxlength' => true]) ?>

<br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
