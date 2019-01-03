<?php

use app\assets\SelectAsset;
use app\models\Coleccion;
use app\models\Editorial;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Coleccion */
/* @var $form ActiveForm */
SelectAsset::register($this);
?>

<div class="coleccion-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_editorial')->dropDownList(ArrayHelper::map(Editorial::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>            
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
