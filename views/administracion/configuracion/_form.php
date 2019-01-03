<?php

use app\assets\SelectAsset;
use app\models\Categoria;
use app\models\ConfigApp;
use app\models\Libreria;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ConfigApp */
/* @var $form ActiveForm */
SelectAsset::register($this);
?>

<div class="config-app-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'nombre_app')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'id_libreria')->dropDownList(ArrayHelper::map(Libreria::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me', 'ng-value' => 'Fulgencio Oroz']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'id_categoria')->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

</div>

<br />
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>




