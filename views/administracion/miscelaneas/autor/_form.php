<?php

use app\assets\SelectAsset;
use app\models\Autor;
use app\models\Pais;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Autor */
/* @var $form ActiveForm */
SelectAsset::register($this);
?>

<div class="autor-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre1')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre2')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'apellido1')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'apellido2')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'nombre_completo')->hiddenInput()->label(false) ?>    
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'sexo')->radioList(['Femenino' => 'Femenino', 'Masculino' => 'Masculino']) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'id_pais')->dropDownList(ArrayHelper::map(Pais::find()->orderBy(['nombre' => 'asc'])->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>
    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
