<?php

use app\assets\SelectAsset;
use app\models\Libreria;
use app\models\Rol;
use app\models\Usuario;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Usuario */
/* @var $form ActiveForm */
SelectAsset::register($this);
$this->registerJs('$( "#' . Html::getInputId($model, 'contrasenha') . '").val("");', View::POS_END);
$this->registerJs('$( "#' . Html::getInputId($model, 'contrasenha_confirmacion') . '").val("");', View::POS_END);
?>

<div class="usuario-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>    
        </div>
    </div>

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
            <?= $form->field($model, 'nombre_usuario')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'contrasenha')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'contrasenha_confirmacion')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 <?= $model->id == Yii::$app->user->identity->id ? ' hidden' : '' ?>">
            <?= $form->field($model, 'id_rol')->dropDownList(ArrayHelper::map(Rol::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'activo')->checkbox() ?>
        </div>
    </div>
    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
