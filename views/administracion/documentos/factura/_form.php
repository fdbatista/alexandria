<?php

use app\assets\DatePickerAsset;
use app\assets\SelectAsset;
use app\models\Devolucion;
use app\models\Factura;
use app\models\Suministrador;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Factura */
/* @var $form ActiveForm */

DatePickerAsset::register($this);
SelectAsset::register($this);
?>

<div class="factura-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'fecha')->textInput([
                'class' => 'datetimepicker form-control', 
                'readonly' => 'readonly',
                'value' => Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y'])
                ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'numero')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'id_devolucion')->dropDownList(ArrayHelper::map(Devolucion::find()->all(), 'id', 'numero'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'id_suministrador')->dropDownList(ArrayHelper::map(Suministrador::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>

    </div>
    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
