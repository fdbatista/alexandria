<?php

use app\assets\SelectAsset;
use app\models\Permiso;
use app\models\views\VEntidad;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Permiso */
/* @var $form ActiveForm */
SelectAsset::register($this);
?>

<div class="permiso-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'entidad')->dropDownList(ArrayHelper::map(VEntidad::find()->all(), 'entidad', 'entidad_html'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

</div>

<br />
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
