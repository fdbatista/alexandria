<?php

use app\assets\SelectAsset;
use app\models\Categoria;
use app\models\Libreria;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Libreria */
/* @var $form ActiveForm */
SelectAsset::register($this);
?>

<div class="libreria-form">
    <br />
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_categoria')->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'telefono')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <label class="control-label" for="libreria-provincia">Provincia</label>

            <?=
            Html::dropDownList('provincia', $id_prov, $provincias, [
                'class' => 'form-control select2me',
                'prompt' => 'Seleccione...',
                'onchange' => '
                    $.get( "' . Url::toRoute('/ajax/get-municipios-por-prov') . '", { id: $(this).val() } )
                        .done(function(data) {
                            $( "#' . Html::getInputId($model, 'id_municipio') . '").html( data );
                        }
                    );
                '
            ])
            ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_municipio')->dropDownList($municipios, ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>    

</div>
<br />
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
