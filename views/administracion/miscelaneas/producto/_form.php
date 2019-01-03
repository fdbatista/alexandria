<?php

use app\assets\SelectAsset;
use app\models\Cuenta;
use app\models\Editorial;
use app\models\Genero;
use app\models\Producto;
use app\models\Tematica;
use app\models\TipoLiteratura;
use app\models\TipoProducto;
use app\models\TipoPublico;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Producto */
/* @var $form ActiveForm */
SelectAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/ProductoController.js', ['depends' => 'app\assets\AngularJSAsset']);
?>

<div class="producto-form" ng-controller="ProductoController" ng-init="inicializar(
                        '<?= Yii::$app->homeUrl ?>',
                        '<?= $model->codigo ?>',
                        '<?= $model->anho_edicion ?>',
                        '<?= $model->existencia ?>',
                        '<?= $model->id ?>',
                        '<?= $model->id_editorial ?>',
                        '<?= $model->id_genero ?>',
                        '<?= $model->id_tematica ?>',
                        '<?= $model->id_tipo_literatura ?>',
                        '<?= $model->id_tipo_producto ?>',
                        '<?= $model->id_tipo_publico ?>',
                        '<?= $model->numero ?>',
                        '<?= $model->observaciones ?>',
                        '<?= $model->precio_costo ?>',
                        '<?= $model->precio_venta ?>',
                        '<?= $model->titulo ?>',
                        '<?= $model->tomo ?>',
                        '<?= $model->volumen ?>'
                        )">
    <br />
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-3">
            <div class="form-group field-producto-id_tipo_producto required">
                <label class="control-label" for="producto-id_cuenta">Cuenta</label>
                <?=
                Html::dropDownList('id_cuenta', $id_cuenta, ArrayHelper::map(Cuenta::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me',
                    'onchange' => '$.get( "' . Url::toRoute('/ajax/get-tipos-productos-por-cuenta') . '", { id: $(this).val() } )
                        .done(function(data) {
                            $( "#' . Html::getInputId($model, 'id_tipo_producto') . '").html( data );
                        }
                    );
                '])
                ?>
            </div>
        </div>

        <div class="col-lg-3">
            <?= $form->field($model, 'id_tipo_producto')->dropDownList(ArrayHelper::map(TipoProducto::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>

        <div class="col-lg-3">
            <?= $form->field($model, 'id_tipo_literatura')->dropDownList(ArrayHelper::map(TipoLiteratura::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'existencia')->textInput(['readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'precio_venta')->textInput(['readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'precio_costo')->textInput(['readonly' => 'readonly']) ?>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'tomo')->textInput() ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'volumen')->textInput() ?>
        </div>
        <div class="col-lg-offset-1 col-lg-2">
            <?= $form->field($model, 'numero')->textInput() ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'anho_edicion')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <?=
            $form->field($model, 'id_editorial')->dropDownList(ArrayHelper::map(Editorial::find()->all(), 'id', 'nombre'), [
                'prompt' => 'Seleccione...',
                'ng-model' => 'producto.id_editorial',
                'class' => 'form-control select2me'
            ])
            ?>
        </div>
      
    </div>


    <div class="row">
        <div class="col-lg-3">
<?= $form->field($model, 'id_genero')->dropDownList(ArrayHelper::map(Genero::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
        <div class="col-lg-3">
<?= $form->field($model, 'id_tematica')->dropDownList(ArrayHelper::map(Tematica::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
        <div class="col-lg-3">
<?= $form->field($model, 'id_tipo_publico')->dropDownList(ArrayHelper::map(TipoPublico::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me']) ?>
        </div>
    </div>

    <br />
    <div class="row">
        <div class="col-lg-9">
<?= $form->field($model, 'observaciones')->textArea(['maxlength' => true]) ?>
        </div>
    </div>

    <br />
    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
