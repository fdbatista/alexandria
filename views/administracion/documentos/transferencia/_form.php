<?php

use app\assets\DatePickerAsset;
use app\assets\SelectAsset;
use app\models\Almacen;
use app\models\Cuenta;
use app\models\Transferencia;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Transferencia */
/* @var $form ActiveForm */

DatePickerAsset::register($this);
SelectAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/TransferenciaController.js', ['depends' => 'app\assets\AngularJSAsset']);
?>

<div class="transferencia-form" ng-controller="TransferenciaController" ng-init="inicializar('<?= Yii::$app->getHomeUrl() ?>', '<?= $model->id ?>', '<?= $model->numero ?>', '<?= $model->observaciones ?>', '<?= $model->id_almacen ?>', '<?= $model->fecha ?>', '<?= $id_cuenta ?>')">
    <br />
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'id_almacen')->dropDownList(ArrayHelper::map(Almacen::find()->all(), 'id', 'nombre'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me', 'ng-model' => 'transferencia.id_almacen']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'ng-model' => 'transferencia.numero']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'fecha')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', 'ng-model' => 'transferencia.fecha', 'ng-value' => "transferencia.fecha | date:'d/MM/y'"]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'observaciones')->textarea(['maxlength' => true, 'ng-model' => 'transferencia.observaciones']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
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
    <br>

    <div class="row">
        <div class="col-lg-12">                   
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 100px;">C&oacute;digo</th>
                        <th style="width: 520px;">T&iacute;tulo</th>
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
                        <td><b>Total</b></td>
                        <td style="font-weight: bold;" ng-bind-html="cantidad_total"></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold;" ng-bind-html="importe_venta_total"></td>
                        <td style="font-weight: bold;" ng-bind-html="importe_costo_total"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: none;" id="adicionar-producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="productoForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="gridModalLabel">Adicionar productos</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <label class="control-label" for="producto-tipo">Tipo</label>
                                <select id="producto-tipo" name="tipoProducto" class="form-control" ng-model="producto_tmp.id_tipo_producto" required>
                                    <option ng-repeat="elem in tiposDeProductos" ng-value="elem.id">{{elem.nombre}}</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label" for="producto-codigo">C&oacute;digo</label>
                                <input type="text" name="productoCodigo" class="form-control" ng-model="producto_tmp.codigo" required />
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label" for="producto-titulo">T&iacute;tulo</label>
                                <div angucomplete-alt
                                     id="titulo-autocomplete"
                                     pause="100"
                                     selected-object="titulo_tmp"
                                     local-data="todosLosProductos"
                                     search-fields="titulo"
                                     title-field="titulo"
                                     minlength="1"
                                     input-class="form-control form-control-small"
                                     match-class="highlight"
                                     input-changed="cambiarTitulo" required>
                                </div>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-lg-4">
                                <label class="control-label" for="producto-existencia">Cantidad</label>
                                <input type="text" class="form-control" ng-change="validarNumero('cantidad')" ng-model="producto_tmp.cantidad" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="producto-precio-venta">Precio de Venta</label>
                                <input type="text" class="form-control" ng-change="validarNumero('precio_venta')" ng-model="producto_tmp.precio_venta" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="control-label" for="producto-precio-venta">Precio de Costo</label>
                                <input type="text" class="form-control" ng-change="validarNumero('precio_costo')" ng-model="producto_tmp.precio_costo" required />
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="col-lg-1">
                            <div class="label label-danger">{{mensaje}}</div>
                        </div>
                        <button type="button" class="btn btn-success" ng-click="adicionarProducto()" ng-disabled="productoIncompleto()"><i class="fa fa-check"></i> Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
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
