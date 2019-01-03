<?php

namespace app\controllers\administracion\documentos;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\DevolucionProducto;
use app\models\Factura;
use app\models\search\FacturaSearch;
use FPDF;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * FacturaController implements the CRUD actions for Factura model.
 */
class FacturaController extends GenericoAdminController {

    /**
     * Lists all Factura models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new FacturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Factura::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";
        return $this->render('inicio', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'textoBoton' => $texto,]);
    }

    /**
     * Displays a single Factura model.
     * @param integer $id
     * @param integer $id_devolucion
     * @return mixed
     */
    public function actionDetalles($id, $id_devolucion) {
        return $this->render('detalles', [
                    'model' => $this->findModel($id, $id_devolucion),
        ]);
    }

    /**
     * Creates a new Factura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Factura();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->numero);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio', 'id' => $model->id, 'id_devolucion' => $model->id_devolucion]);
        } else {
            return $this->render('crear', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing Factura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_devolucion
     * @return mixed
     */
    public function actionActualizar($id, $id_devolucion) {
        $model = $this->findModel($id, $id_devolucion);
        //$atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->numero);
            \Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio', 'id' => $model->id, 'id_devolucion' => $model->id_devolucion]);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Factura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_devolucion
     * @return mixed
     */
    public function actionEliminar($id, $id_devolucion) {
        $model = $this->findModel($id, $id_devolucion);
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->numero);
        \Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Factura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_devolucion
     * @return Factura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_devolucion) {
        if (($model = Factura::findOne(['id' => $id, 'id_devolucion' => $id_devolucion])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function actionExportarDocumento($id) {
        define('FPDF_FONTPATH', 'fpdf181/font/');
        require('fpdf181/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'FACTURA', 0, 1, 'C');

        $factura = Factura::findOne($id);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'SUMINISTRADOR: ' . $factura->idSuministrador->nombre, 0, 1, 'L');
        $pdf->Cell(0, 6, 'CODIGO: ' . $factura->idSuministrador->codigo, 0, 1, 'L');
        $pdf->Cell(125.9, 6, 'CODIGO NIT: ' . $factura->idSuministrador->codigo_nit, 0, 0, 'L');
        $pdf->Cell(70, 6, 'FACTURA No.: ' . $factura->numero, 0, 1, 'L');
        $pdf->Cell(125.9, 6, 'CUENTA BANCARIA: ' . $factura->idSuministrador->cuenta_bancaria, 0, 0, 'L');
        $pdf->Cell(70, 6, 'FECHA: ' . Yii::$app->formatter->format($factura->fecha, ['date', 'php:d/m/Y']), 0, 1, 'L');
        $pdf->Cell(0, 6, 'AGENCIA: ' . $factura->idSuministrador->agencia, 0, 1, 'L');
        $pdf->Cell(0, 6, 'DIRECCION: ' . $factura->idSuministrador->direccion, 0, 1, 'L');

        $pdf->Cell(0, 6, 'RECEPTOR: ' . $factura->idDevolucion->idEfectEntr->idReceptor->nombre, 0, 1, 'L');
        $pdf->Cell(0, 6, 'EFECTIVO ENTREGA: ' . $factura->idDevolucion->idEfectEntr->nombre, 0, 1, 'L');
        $pdf->Cell(125.9, 6, 'CODIGO: ' . $factura->idDevolucion->idEfectEntr->idReceptor->codigo, 0, 0, 'L');
        $pdf->Cell(70, 6, 'CODIGO NIT: ' . $factura->idDevolucion->idEfectEntr->idReceptor->codigo_nit, 0, 1, 'L');
        $pdf->Cell(125.9, 6, 'CUENTA BANCARIA: ' . $factura->idDevolucion->idEfectEntr->idReceptor->cuenta_bancaria, 0, 0, 'L');
        $pdf->Cell(70, 6, 'AGENCIA: ' . $factura->idDevolucion->idEfectEntr->idReceptor->agencia, 0, 1, 'L');
        $pdf->Cell(0, 6, 'DIRECCION: ' . $factura->idDevolucion->idEfectEntr->idReceptor->direccion, 0, 1, 'L');


        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 6, 'Codigo', 1, 0, 'C');
        $pdf->Cell(57, 6, 'Titulo', 1, 0, 'C');
        $pdf->Cell(10, 6, 'U/M', 1, 0, 'C');
        $pdf->Cell(17.9, 6, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(23, 6, 'Precio Venta', 1, 0, 'C');
        $pdf->Cell(23, 6, 'Precio Costo', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Importe Venta', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Importe Costo', 1, 1, 'C');


        $fact = Factura::findOne($id);
        $idDevFact = $fact->id_devolucion;
        $devProd = DevolucionProducto::findAll(['id_devolucion' => $idDevFact]);
        $pdf->SetFont('Arial', '', 10);
        foreach ($devProd as $fila) {
            $pdf->Cell(15, 6, $fila->idProducto->codigo, 1, 0, 'C');
            $pdf->Cell(57, 6, $fila->idProducto->titulo, 1, 0, 'L');
            $pdf->Cell(10, 6, '', 1, 0, 'L');
            $pdf->Cell(17.9, 6, $fila->cantidad, 1, 0, 'C');
            $pdf->Cell(23, 6, $fila->precio_venta, 1, 0, 'C');
            $pdf->Cell(23, 6, $fila->precio_costo, 1, 0, 'C');
            $pdf->Cell(25, 6, $fila->importe_venta, 1, 0, 'C');
            $pdf->Cell(25, 6, $fila->importe_costo, 1, 0, 'C');
            $pdf->Ln();
        }
        $i = 0;
        for ($j = $i; $j < 23; $j++) {
            $pdf->Cell(15, 6, '', 1, 0);
            $pdf->Cell(57, 6, '', 1, 0);
            $pdf->Cell(10, 6, '', 1, 0);
            $pdf->Cell(17.9, 6, '', 1, 0);
            $pdf->Cell(23, 6, '', 1, 0);
            $pdf->Cell(23, 6, '', 1, 0);
            $pdf->Cell(25, 6, '', 1, 0);
            $pdf->Cell(25, 6, '', 1, 1);
        }
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(99.9, 6, 'ENTREGADO. NOMBRE: ', 1, 0, 'L');
        $pdf->Cell(96, 6, 'RECIBIDO. NOMBRE: ', 1, 1, 'L');
        $pdf->Cell(99.9, 6, 'CARGO: ', 1, 0, 'L');
        $pdf->Cell(96, 6, 'CARGO: ', 1, 1, 'L');
        $pdf->Cell(99.9, 6, 'CI: ', 1, 0, 'L');
        $pdf->Cell(96, 6, 'CI: ', 1, 1, 'L');
        $pdf->Cell(99.9, 6, 'FIRMA: ', 1, 0, 'L');
        $pdf->Cell(96, 6, 'FIRMA: ', 1, 0, 'L');

        $pdf->Output('D', 'Factura ' . $factura->numero . '.pdf', TRUE);
    }

}
