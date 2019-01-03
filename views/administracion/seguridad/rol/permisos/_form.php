<?php

use app\assets\SelectAsset;
use app\models\RolPermiso;
use app\models\views\VEntidad;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model RolPermiso */
/* @var $form ActiveForm */
SelectAsset::register($this);
$entidad = $model->idPermiso ? $model->idPermiso->entidad : '';
?>

<div class="rol-permiso-form">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'id_rol')->hiddenInput()->label(false)->error(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group field-producto-id_tipo_producto required">
                <label class="control-label" for="producto-id_cuenta">Entidad</label>
                <?=
                Html::dropDownList('entidad', $entidad, ArrayHelper::map(VEntidad::find()->all(), 'entidad_html', 'entidad'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me',
                    'onchange' => '$.get( "' . Url::toRoute('ajax/get-permisos-por-entidad') . '", { entidad_html: $(this).val() } )
                        .done(function(data) {
                            $( "#' . Html::getInputId($model, 'id_permiso') . '").html( data );
                        }
                    );
                '])
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'id_permiso')->dropDownList($permisos, ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <br />
    <div class="row">
        <div class="col-lg-3 form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        </div>
    </div>

</div>

<?php ActiveForm::end(); ?>

</div>
