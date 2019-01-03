<?php

use app\assets\SelectAsset;
use app\models\Asociacion;
use app\models\Editorial;
use app\models\Pais;
use app\models\Provincia;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Editorial */
/* @var $form ActiveForm */
SelectAsset::register($this);
?>

<div class="editorial-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'id_asociacion')->dropDownList(ArrayHelper::map(Asociacion::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'id_pais')->dropDownList(ArrayHelper::map(Pais::find()->all(), 'id', 'nombre'), [
                'prompt' => 'Seleccione...',
                'class' => 'form-control select2me',
                'onchange' => '
                    $.get( "' . Url::toRoute('/ajax/get-provincias-por-pais') . '", { id: $(this).val() } )
                        .done(function(data) {
                        $( "#' . Html::getInputId($model, 'id_provincia') . '").html( data );
                            }
                    );
            ']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'id_provincia')->dropDownList(ArrayHelper::map(Provincia::find()->where(['id_pais' => $model->id_pais])->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <?= $form->field($model, 'direccion')->textArea(['maxlength' => true]) ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
