<?php

use app\assets\DatePickerAsset;
use app\assets\SelectAsset;
use app\models\Cuenta;
use app\models\Devolucion;
use app\models\EfectivoEntrega;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Devolucion */
/* @var $form ActiveForm */

DatePickerAsset::register($this);
SelectAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/DevolucionController.js', ['depends' => 'app\assets\AngularJSAsset']);
?>
<?php
if (count($usuarios) > 1) {
    $idUsuario = $model->id_usuario;
} else {
    foreach ($usuarios as $key => $value) {
        $idUsuario = $key;
    }
}
?>
<div class="devolucion-form" ng-controller="DevolucionController" ng-init="inicializar('<?= Yii::$app->getHomeUrl() ?>', '<?= $model->id ?>', '<?= $model->numero ?>', '<?= $model->fecha ?>', '<?= $idUsuario ?>', '<?= $model->id_efect_entr ?>', '<?= $id_cuenta ?>', '<?= $descomercial ?>')">
    <br />
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'numero')->textInput(['ng-model' => 'devolucion.numero']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'fecha')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', 'ng-model' => "devolucion.fecha", 'ng-value' => "devolucion.fecha | date:'d/MM/y'"]) ?>
        </div>
        <div class="col-lg-3">
            <div id="usuario-div" class="form-group required">
                <?= (!$esLibrero) ? $form->field($model, 'id_usuario')->dropDownList($usuarios, ['prompt' => 'Seleccione...', 'class' => 'form-control select2me', 'ng-model' => 'devolucion.id_usuario', 'required']) : $form->field($model, 'id_usuario')->hiddenInput(['ng-value' => $idUsuario, 'ng-model' => 'devolucion.id_usuario', 'required' => 'required'])->label(false); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?=
                    $form->field($model, 'id_efect_entr')
                    ->dropDownList(ArrayHelper::map(EfectivoEntrega::find()->all(), 'id', 'nombre'), [
                        'prompt' => 'Seleccione...',
                        'class' => 'form-control select2me',
                        'ng-model' => 'devolucion.id_efect_entr',
                        'ng-change' => 'actualizarDescomercial()'
            ]);
            ?>
        </div>
        <div class="col-lg-2">
            <label for="descomercial">Descuento comercial</label>
            <input type="text" id="descomercial" class="form-control" ng-model="descuento_comercial" ng-value="{{descuento_comercial}}" readonly />

        </div>

    </div>
    <br />

    <div class="row">
        <div class="col-lg-2">
            <div id="cuenta-div" class="form-group required">
                <label class="control-label" for="id_cuenta">Cuenta</label>
                <?= Html::dropDownList('id_cuenta', $id_cuenta, ArrayHelper::map(Cuenta::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me', 'ng-model' => 'id_cuenta', 'ng-change' => 'actualizarObjetosPorIdCuenta()', 'required']) ?>
                <div id="div-cuenta-errormsg" class="help-block hidden">Este campo es obligatorio</div>
            </div>
        </div>
        <div class="col-lg-2 col-lg-offset-1">
            <div class="form-group" style="margin-top: 25px;">
                <button type="button" class="btn btn-info" data-toggle="modal" ng-click='mostrarVentana("adicionar", -1)'><i class="fa fa-plus"></i> Agregar productos</button>
            </div>
        </div>
    </div>
    <br />

    <div class="row">
        <div class="col-lg-12">                   
            <table class="table">
                <thead>
                <thead>
                    <tr>
                        <th style="width: 20px;">No.</th>
                        <th style="width: 100px;">C&oacute;digo</th>
                        <th style="width: 500px;">T&iacute;tulo</th>
                        <th style="width: 100px;">Cantidad</th>
                        <th style="width: 150px;">Precio Venta</th>
                        <th style="width: 150px;">Precio Costo</th>
                        <th style="width: 150px;">Importe Venta</th>
                        <th style="width: 150px;">Importe Costo</th>
                        <th style="width: 70px;">Acciones</th>
                    </tr>
                </thead>

                <tbody id="grid-content">
                    <tr ng-cloak ng-repeat="(i, item) in productos">
                        <td ng-bind-html="i + 1"></td>
                        <td ng-bind-html="item.codigo"></td>
                        <td ng-bind-html="item.titulo"></td>
                        <td ng-bind-html="item.cantidad"></td>
                        <td ng-bind-html="item.precio_venta"></td>
                        <td ng-bind-html="item.precio_costo"></td>
                        <td ng-bind-html="item.importe_venta"></td>
                        <td ng-bind-html="item.importe_costo"></td>
                        <td>
                            <button type="button" ng-click="mostrarVentana('actualizar', i)" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Modificar"><i class="fa fa-pencil"></i></button>
                            <button type="button" ng-click="mostrarVentana('eliminar', i)" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>Total</b></td>
                        <td style="font-weight: bold;" ng-bind-html="cantidad_total"></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold;" ng-bind-html="importe_venta_total"></td>
                        <td style="font-weight: bold;" ng-bind-html="importe_costo_total"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b>Total a pagar</b></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td style="font-weight: bold;" ng-bind-html="getTotalAPagar()"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: none;" id="adicionar-producto" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="productoForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="gridModalLabel">Adicionar Productos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <label class="control-label" for="producto-titulo">T&iacute;tulo</label>
                                <ui-select required id="producto-id" ng-change="actualizarProductoTmp()" ng-model="producto_tmp.contenido">
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
                                <div class="label label-danger" ng-show="!producto_tmp.titulo">Este dato es obligatorio</div>
                            </div>
                            <div class="col-lg-5">
                                <label class="control-label" for="producto-cantidad">Cantidad</label>
                                <input type="text" class="form-control" ng-change="actualizarImporte()" ng-model="producto_tmp.cantidad" required />
                                <div class="label label-danger" ng-show="mensaje !== ''">{{mensaje}}</div>
                            </div>
                        </div>

                        <br />
                        <div class="row">
                            <div class="col-lg-5">
                                <label class="control-label" for="producto-precio">Precio Venta</label>
                                <input type="text" class="form-control" ng-model="producto_tmp.precio_venta" required readonly />
                            </div>
                            <div class="col-lg-offset-2 col-lg-5">
                                <label class="control-label" for="producto-precio">Precio Costo</label>
                                <input type="text" class="form-control" ng-model="producto_tmp.precio_costo" required readonly />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5">
                                <label class="control-label" for="producto-importe">Importe Venta</label>
                                <input type="text" class="form-control" ng-model="producto_tmp.importe_venta" required readonly />
                            </div>
                            <div class="col-lg-offset-2 col-lg-5">
                                <label class="control-label" for="producto-importe">Importe Costo</label>
                                <input type="text" class="form-control" ng-model="producto_tmp.importe_costo" required readonly />   
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btn-act-prod" class="btn btn-success" ng-click="adicionarProducto()" ng-disabled="productoIncompleto()"><i class="fa fa-check"></i> Aceptar</button>
                        <button type="button" class="btn btn-danger" ng-click="cerrarVentana()"><i class="fa fa-times"></i> Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="display: none;" id="eliminar-producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="productoForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="gridModalLabel">Eliminar producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <p>¿Confirma que desea eliminar el producto <b><span ng-bind-html="producto_a_eliminar"></span></b>?</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" ng-click="eliminarProducto()" ><i class="fa fa-trash-o"></i> S&iacute;</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <br />
    <div class="form-group">
        <button type="button" ng-click="guardar()" ng-disabled="entidadIncompleta()" id="btn-submit" class="btn <?= $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning' ?>"><i id="btn-submit-fa" class="fa fa-check"></i> <?= $model->isNewRecord ? 'Crear' : 'Actualizar' ?></button>
    </div>


    <?php ActiveForm::end(); ?>

</div>
