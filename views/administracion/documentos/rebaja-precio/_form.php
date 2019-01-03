<?php

use app\assets\DatePickerAsset;
use app\models\RebajaPrecio;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model RebajaPrecio */
/* @var $form ActiveForm */

DatePickerAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/RebajaPrecioController.js', ['depends' => 'app\assets\AngularJSAsset']);
?>

<div class="rebaja-precio-form" ng-controller="RebajaPrecioController" ng-init="inicializar('<?= Yii::$app->getHomeUrl() ?>', '<?= $model->id_producto ?>', '<?= $model->fecha ?>')">
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'fecha')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', /*'value' => Yii::$app->formatter->format($model->fecha, ['date', 'php:d/m/Y'])*/ 'ng-model' => 'transferencia.fecha', 'ng-value' => "fecha | date:'d/MM/y'"]) ?>
        </div>
        <div class="col-lg-5" id="rebajaprecio-id_producto-div">
            <label class="control-label" for="rebajaprecio-id_producto">Producto</label>
            <ui-select required id="id_producto" name="RebajaPrecio[id_producto]" ng-change="actualizarProductoTmp()" ng-model="producto_tmp.contenido">
                <ui-select-match>
                    <span class="label-text" ng-bind="producto_tmp.titulo"></span>
                </ui-select-match>
                <ui-select-choices repeat="item in (todosLosProductos | filter: $select.search) track by item.id">
                    <img class="icono-select" src="<?= Yii::$app->homeUrl . 'img/favicon.png' ?>"/>
                    <div ng-bind-html="item.titulo | highlight: $select.search"></div>
                    <small>
                        <span class="label label-default" ng-bind-html="'' + item.tipo_producto | highlight: $select.search"></span> 
                        Precio de Costo: <span ng-bind-html="'' + item.precio_costo | highlight: $select.search"></span>
                    </small>
                </ui-select-choices>
            </ui-select>

            <?= $form->field($model, 'id_producto')->hiddenInput()->label(false) ?>

        </div>
    </div>    
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'precio_anterior')->textInput(['ng-model' => 'producto_tmp.precio_anterior', 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'precio_nuevo')->textInput() ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning', 'ng-click' => 'validar()']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
