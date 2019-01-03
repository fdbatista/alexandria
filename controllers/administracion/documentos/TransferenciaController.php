<?php

namespace app\controllers\administracion\documentos;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Producto;
use app\models\search\TransferenciaSearch;
use app\models\Transferencia;
use app\models\TransferenciaProducto;
use FPDF;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * TransferenciaController implements the CRUD actions for Transferencia model.
 */
class TransferenciaController extends GenericoAdminController {

    /**
     * Lists all Transferencia models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new TransferenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Transferencia::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";
        return $this->render('inicio', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'textoBoton' => $texto,]);
    }

    /**
     * Displays a single Transferencia model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $cuentaTransf = TransferenciaProducto::findOne(['id_transferencia' => $id])->idProducto->idTipoProducto->idCuenta->nombre;
                return $this->render('detalles', ['model' => $this->findModel($id), 'cuentaTransf' => $cuentaTransf]);
    }

    /**
     * Creates a new Transferencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Transferencia();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->numero);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['detalles']);
        } else {
            return $this->render('crear', ['model' => $model]);
        }
    }

    /**
     * Updates an existing Transferencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        $prods = $model->transferenciaProductos;
        $id_cuenta = '';
        if (count($prods) > 0) {
            $id_cuenta = Producto::findOne($prods[0]->id_producto)->idTipoProducto->id_cuenta;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->numero);
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['detalles', 'id' => $model->id]);
        } else {
            return $this->render('actualizar', ['model' => $model, 'id_cuenta' => $id_cuenta]);
        }
    }

    /**
     * Deletes an existing Transferencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);

        $productos = TransferenciaProducto::find()->where(['id_transferencia' => $model->id])->all();
        foreach ($productos as $productoAux) {
            $producto = Producto::findOne($productoAux->id_producto);
            if ($producto) {
                if ($producto->existencia >= $productoAux->cantidad) {
                    $producto->existencia -= $productoAux->cantidad;
                    $producto->save();
                } else {
                    return $this->redirect(Url::base(true) . '/administracion/inicio/error?m=15215');
                }
            }
        }
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->id);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Transferencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transferencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Transferencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function actionGuardar($transferencia) {
        $params = json_decode($transferencia, true);
        $paramsTransf = $params['transferencia'];

        if ($paramsTransf['id']) {
            $accion = 'actualizar';
            $msg = 'actualizado';
            $model = Transferencia::findOne($paramsTransf['id']);

            $productos = TransferenciaProducto::find()->where(['id_transferencia' => $model->id])->all();
            foreach ($productos as $productoAux) {
                $producto = Producto::findOne($productoAux->id_producto);
                if ($producto) {
                    $producto->existencia -= $productoAux->cantidad;
                    $producto->save();
                }
            }
            TransferenciaProducto::deleteAll(['id_transferencia' => $model->id]);
        } else {
            $accion = 'crear';
            $msg = 'creado';
            $model = new Transferencia();
        }
        $atributos_viejos = $model->attributes;
        $model->setAttributes(['numero' => $paramsTransf['numero'], 'observaciones' => $paramsTransf['observaciones'], 'id_almacen' => $paramsTransf['id_almacen'], 'fecha' => $paramsTransf['fecha']]);

        if ($model->save()) {
            $paramsProductos = $params['productos'];
            $nombresProductos = 'PRODUCTOS: ';
            foreach ($paramsProductos as $paramProd) {
                $producto = Producto::findOne(['titulo' => $paramProd['titulo'], 'precio_costo' => $paramProd['precio_costo']]);

                if ($producto) {
                    $producto->id_tipo_producto = $paramProd['id_tipo_producto'];
                    $producto->codigo = $paramProd['codigo'];
                    $producto->existencia += $paramProd['cantidad'];
                    $producto->precio_venta = $paramProd['precio_venta'];
                    $producto->precio_costo = $paramProd['precio_costo'];
                    $producto->save();
                } else {
                    $producto = new Producto([
                        'id_tipo_producto' => $paramProd['id_tipo_producto'],
                        'codigo' => $paramProd['codigo'],
                        'existencia' => $paramProd['cantidad'],
                        'precio_venta' => $paramProd['precio_venta'],
                        'precio_costo' => $paramProd['precio_costo'],
                        'titulo' => $paramProd['titulo'],]
                    );
                    $producto->save(false);
                }
                $nombresProductos .= $producto->titulo . ' (' . $paramProd['cantidad'] . '), ';
                $transfProd = new TransferenciaProducto();
                $transfProd->cantidad = $paramProd['cantidad'];
                $transfProd->precio_venta = $paramProd['precio_venta'];
                $transfProd->importe_costo = $transfProd->cantidad * $producto->precio_costo;
                $transfProd->importe_venta = $transfProd->cantidad * $transfProd->precio_venta;
                $transfProd->id_transferencia = $model->id;
                $transfProd->id_producto = $producto->id;
                $transfProd->save();
            }
            StaticMembers::RegistrarTraza($model, $atributos_viejos, $accion, $model->id, $nombresProductos);
            Yii::$app->session->setFlash('success', 'Elemento ' . $msg . ' correctamente', false);
        }
    }

    public function actionExportarDocumento($id) {
        define('FPDF_FONTPATH', 'fpdf181/font/');
        require('fpdf181/fpdf.php');

        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'TRANSFERENCIA', 1, 1, 'C');

        $transferencia = Transferencia::findOne($id);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(159.5, 7, 'Proveedor: ' . $transferencia->idAlmacen->nombre, 1, 0, 'L');
        $pdf->Cell(100, 7, 'Numero: ' . $transferencia->numero, 1, 1, 'L');
        $pdf->Cell(159.5, 7, 'Direccion: ' . $transferencia->idAlmacen->direccion, 1, 0, 'L');
        $pdf->Cell(100, 7, 'Fecha: ' . Yii::$app->formatter->format($transferencia->fecha, ['date', 'php:d/m/Y']), 1, 1, 'L');
        $pdf->Cell(0, 7, 'Cuenta: ' . TransferenciaProducto::findOne(['id_transferencia' => $id])->idProducto->idTipoProducto->idCuenta->nombre, 1, 1, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, 'Codigo', 1, 0, 'C');
        $pdf->Cell(109.5, 6, 'Titulo', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Precio Venta', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Precio Costo', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Importe Venta', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Importe Costo', 1, 1, 'C');

        $transf = TransferenciaProducto::find()->where(['id_transferencia' => $id])->all();
        $a = 0;
        $cantTotal = 0;
        $impVentaTotal = 0;
        $impCostoTotal = 0;
        $pdf->SetFont('Arial', '', 10);
        foreach ($transf as $fila) {
            $pdf->Cell(30, 6, $fila->idProducto->codigo, 1, 0, 'C');
            //$pdf->Cell(109.5, 6, $fila->idProducto->titulo, 1, 0, 'L');
			$pdf->Cell(109.5, 6, iconv('UTF-8', 'windows-1252', $fila->idProducto->titulo), 1, 0, 'L');
            $pdf->Cell(20, 6, $fila->cantidad, 1, 0, 'C');
            $pdf->Cell(25, 6, $fila->precio_venta, 1, 0, 'C');
            $pdf->Cell(25, 6, $fila->idProducto->precio_costo, 1, 0, 'C');
            $pdf->Cell(25, 6, $fila->importe_venta, 1, 0, 'C');
            $pdf->Cell(25, 6, $fila->importe_costo, 1, 0, 'C');
            $pdf->Ln();
            $cantTotal = $cantTotal + $fila->cantidad;
            $impVentaTotal = $impVentaTotal + $fila->importe_venta;
            $impCostoTotal = $impCostoTotal + $fila->importe_costo;
        }
        for ($j = $a; $j < 18; $j++) {
            $pdf->Cell(30, 6, '', 1, 0, 'C');
            $pdf->Cell(109.5, 6, '', 1, 0, 'L');
            $pdf->Cell(20, 6, '', 1, 0, 'C');
            $pdf->Cell(25, 6, '', 1, 0, 'C');
            $pdf->Cell(25, 6, '', 1, 0, 'C');
            $pdf->Cell(25, 6, '', 1, 0, 'C');
            $pdf->Cell(25, 6, '', 1, 0, 'C');
            $pdf->Ln();
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 7, '', 1, 0, 'C');
        $pdf->Cell(109.5, 7, 'TOTAL', 1, 0, 'R');
        $pdf->Cell(20, 7, $cantTotal, 1, 0, 'C');
        $pdf->Cell(25, 7, '-', 1, 0, 'C');
        $pdf->Cell(25, 7, '-', 1, 0, 'C');
        $pdf->Cell(25, 7, $impVentaTotal, 1, 0, 'C');
        $pdf->Cell(25, 7, $impCostoTotal, 1, 1, 'C');

        $pdf->Cell(139.5, 7, 'ENTREGADO', 1, 0, 'C');
        $pdf->Cell(120, 7, 'RECIBIDO', 1, 1, 'C');
        $pdf->Cell(139.5, 7, 'Nombre y apellidos:', 1, 0, 'L');
        $pdf->Cell(120, 7, 'Nombre y apellidos:', 1, 1, 'L');
        $pdf->Cell(139.5, 7, 'Firma:', 1, 0, 'L');
        $pdf->Cell(120, 7, 'Firma:', 1, 1, 'L');


        $pdf->Output('D', 'Transferencia ' . $transferencia->numero . '.pdf', TRUE);
    }

}
