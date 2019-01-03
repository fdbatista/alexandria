<?php

use app\assets\DatePickerAsset;
use app\assets\HighChartsAsset;
use app\assets\SelectAsset;
use app\models\Grafico;
use app\models\TipoGrafico;
use app\models\TipoReporte;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Grafico */
/* @var $form ActiveForm */
DatePickerAsset::register($this);
HighChartsAsset::register($this);
SelectAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/GraficoController.js', ['depends' => 'app\assets\AngularJSAsset']);
$this->menu_activo = 'grafico';
?>

<div class="grafico-form" ng-controller="GraficoController" ng-init="inicializar('<?= Url::base(true) ?>', '<?= $model->id_tipo_grafico ?>', '<?= $model->id_tipo_reporte ?>', '<?= $model->getTipoReporte() ?>', '<?= $model->fecha_inicial ?>', '<?= $model->fecha_final ?>', '<?= $model->generado ?>')">
    <br />
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'id_tipo_grafico')->dropDownList(ArrayHelper::map(TipoGrafico::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'id_tipo_reporte')->dropDownList(ArrayHelper::map(TipoReporte::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'fecha_inicial')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', 'ng-model' => "fecha_inicial", 'ng-value' => "fecha_inicial | date:'d/MM/y'"]) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'fecha_final')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', 'ng-model' => "fecha_final", 'ng-value' => "fecha_final | date:'d/MM/y'"]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>Aceptar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div id="chart-container" style="display: none;"></div>
</div>
