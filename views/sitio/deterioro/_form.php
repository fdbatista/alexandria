<?php

use app\assets\DatePickerAsset;
use app\assets\SelectAsset;
use app\models\Deterioro;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Deterioro */
/* @var $form ActiveForm */

DatePickerAsset::register($this);
SelectAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/DeterioroController.js', ['depends' => 'app\assets\AngularJSAsset']);
?>
<?php
if (count($usuarios) >= 1) {
    $idUsuario = $model->id_usuario;
} else {
    foreach ($usuarios as $key => $value) {
        $idUsuario = $key;
    }
}
?>
<div class="deterioro-form" ng-controller="DeterioroController" ng-init="inicializar('<?= Yii::$app->getHomeUrl() ?>', '<?= $model->id_producto ?>', '<?= $model->fecha ?>','<?= $idUsuario ?>', '<?= $model->cantidad ?>')">

    <br />
    <?php $form = ActiveForm::begin(['id' => 'frm-enviar']); ?>

    <div class="row" id="deterioro-id_producto-div">
        <div class="col-lg-4">
            <label class="control-label" for="deterioro-id_producto">Producto</label>
            <ui-select required id="id_producto" name="Deterioro[id_producto]" ng-change="actualizarProductoTmp()" ng-model="producto_tmp.contenido">
                <ui-select-match>
                    <span class="label-text" ng-bind="producto_tmp.titulo"></span>
                </ui-select-match>
                <ui-select-choices repeat="item in (todosLosProductos | filter: $select.search) track by item.id">
                    <img class="icono-select" src="<?= Yii::$app->homeUrl . 'img/favicon.png' ?>"/>
                    <div  ng-bind-html="item.titulo | highlight: $select.search"></div>
                    <small>
                        <span class="label label-default" ng-bind-html="'' + item.tipo_producto | highlight: $select.search"></span> 
                        Precio de Costo: <span ng-bind-html="'' + item.precio_costo | highlight: $select.search"></span>
                    </small>
                </ui-select-choices>
            </ui-select>

            <?= $form->field($model, 'id_producto')->hiddenInput()->label(false) ?>

        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'cantidad')->textInput() ?>            
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'fecha')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', 'ng-model' => "deterioro.fecha", 'ng-value' => "deterioro.fecha | date:'d/MM/y'"]); ?>
        </div>
        <div class="col-lg-3">
            <?= (!$esLibrero) ? $form->field($model, 'id_usuario')->dropDownList($usuarios, 
                    ['prompt' => 'Seleccione...', 
                        'class' => 'form-control select2me', 
                        'ng-model' => 'deterioro.id_usuario', 
                        'required']) : $form->field($model, 'id_usuario')->hiddenInput(
                                ['ng-value' => $idUsuario, 
                                    'ng-model' => 'deterioro.id_usuario', 
                                    'required' => 'required'])->label(false); ?>
        </div>
    </div>
</div>    
<br />
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning', 'ng-click' => 'validar()']) ?>
</div>

<?php ActiveForm::end(); ?>
