<?php

use app\assets\DatePickerAsset;
use app\assets\SelectAsset;
use app\models\Venta;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Venta */
/* @var $form ActiveForm */

DatePickerAsset::register($this);
SelectAsset::register($this);
$this->registerJsFile('@web/plugins/angularjs/controllers/VentaController.js', ['depends' => 'app\assets\AngularJSAsset']);
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
<div class="venta-form" ng-controller="VentaController" ng-init="inicializar('<?= Yii::$app->getHomeUrl() ?>', '<?= $model->id ?>', '<?= $model->fecha ?>', '<?= $idUsuario ?>')">
    <br />
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'fecha')->textInput(['class' => 'datetimepicker form-control', 'readonly' => 'readonly', 'ng-model' => 'venta.fecha_hora', 'ng-value' => "venta.fecha_hora | date:'d/MM/y'", 'required']) ?>
        </div>
        <div class="col-lg-3">
            <?= (!$esLibrero) ? $form->field($model, 'id_usuario')
            ->dropDownList($usuarios, [
                'prompt' => 'Seleccione...', 
                'class' => 'form-control select2me', 
                'ng-model' => 'venta.id_usuario', 
                'required']) : $form->field($model, 'id_usuario')->hiddenInput(['ng-value' => $idUsuario, 'ng-model' => 'venta.id_usuario', 'required' => 'required'])->label(false); ?>
        </div>
    </div>

    <br />
    <div class="row">
        <div class="col-lg-12">

            <div class="form-group">
                <button type="button" data-toggle="modal" backdrop="static" class="btn btn-info" ng-click='mostrarVentana("adicionar")'><i class="fa fa-plus"></i> Adicionar productos</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;"><a>No.</a></th>
                        <th style="width: 300px;"><a>T&iacute;tulo</a></th>
                        <th style="width: 100px;"><a>Cantidad</a></th>
                        <th style="width: 100px;"><a>Precio</a></th>
                        <th style="width: 100px;"><a>Importe</a></th>
                        <th style="width: 70px;"><a>Acciones</a></th>
                    </tr>
                </thead>

                <tbody id="grid-content">
                    <tr ng-cloak ng-repeat="(i, item) in productos">
                        <td ng-bind-html="i + 1"></td>
                        <td ng-bind-html="item.titulo"></td>
                        <td ng-bind-html="item.cantidad"></td>
                        <td ng-bind-html="item.precio_venta"></td>
                        <td ng-bind-html="item.importe_venta"></td>
                        <td>
                            <button type="button" data-toggle="modal" data-backdrop="static" ng-click="mostrarVentana('actualizar', i)" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Actualizar"><i class="fa fa-pencil"></i></button>
                            <button type="button" ng-click="mostrarVentana('eliminar', i)" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Total</b></td>
                        <td style="font-weight: bold;" ng-bind-html="cantidad_total"></td>
                        <td></td>
                        <td style="font-weight: bold;" ng-bind-html="importe_total"></td>
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

                            <div class="col-lg-8">
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
                                <div class="label label-danger" ng-show="!producto_tmp.titulo">Este campo es obligatorio</div>
                            </div>

                            <div class="col-lg-4">
                                <label class="control-label" for="producto-precio">Precio</label>
                                <input type="text" class="form-control" ng-model="producto_tmp.precio_venta" required readonly />
                            </div>

                        </div>
                        <br />
                        <div class="row">

                            <div class="col-lg-4">
                                <label class="control-label" for="producto-cantidad">Cantidad</label>
                                <input type="text" class="form-control" ng-change="actualizarImporte()" ng-model="producto_tmp.cantidad" required />
                                <div class="label label-danger" ng-show="mensaje !== ''">{{mensaje}}</div>
                            </div>

                            <div class="col-lg-offset-4 col-lg-4">
                                <label class="control-label" for="producto-importe">Importe</label>
                                <input type="text" class="form-control" ng-model="producto_tmp.importe_venta" required readonly />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btn-act-prod" class="btn btn-success" ng-click="adicionarProducto()" ng-disabled="productoInvalido()"><i class="fa fa-check"></i> Aceptar</button>
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
                        <h4 class="modal-title" id="gridModalLabel">Eliminar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <p>¿Confirma que desea eliminar el producto <span class="label label-danger" ng-bind-html="producto_a_eliminar"></span>?</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" ng-click="eliminarProducto()" ><i class="fa fa-trash-o"></i> S&Iacute;</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> NO</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="chart-container"></div>

    <div class="form-group">
        <button type="button" ng-click="guardar()" ng-disabled="entidadIncompleta()" id="btn-submit" class="btn <?= $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning' ?>"><i id="btn-submit-fa" class="fa fa-check"></i> <?= $model->isNewRecord ? 'Crear' : 'Actualizar' ?></button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
