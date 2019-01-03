<?php

namespace app\controllers\administracion\documentos;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Producto;
use app\models\RebajaPrecio;
use app\models\search\RebajaPrecioSearch;
use FPDF;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * RebajaPrecioController implements the CRUD actions for RebajaPrecio model.
 */
class RebajaPrecioController extends GenericoAdminController {

    /**
     * Lists all RebajaPrecio models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new RebajaPrecioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = RebajaPrecio::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single RebajaPrecio model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RebajaPrecio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new RebajaPrecio();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $producto = Producto::findOne($model->id_producto);
            $producto->precio_venta = $model->precio_nuevo;
            $producto->save();
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $producto->titulo);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('crear', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing RebajaPrecio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * 
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $producto = Producto::findOne($model->id_producto);
            $producto->precio_venta = $model->precio_nuevo;
            $producto->save();
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $producto->titulo);
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RebajaPrecio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        $model->delete();
        $producto = $model->idProducto;
        $producto->precio_venta = $model->precio_anterior;
        $producto->save();
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $producto->titulo);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the RebajaPrecio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RebajaPrecio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RebajaPrecio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function actionExportarListado() {
        define('FPDF_FONTPATH', 'fpdf181/font/');
        require('fpdf181/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Listado de Rebajas de Precios ' . date('m/Y'), 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'No.', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Fecha', 1, 0, 'C');
        $pdf->Cell(80, 10, 'Producto', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Precio nuevo', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Precio anterior', 1, 0, 'C');
        $pdf->Ln();
        $rebajas = RebajaPrecio::find()->all();
        $i = 1;
        $pdf->SetFont('Arial', '', 12);
        foreach ($rebajas as $rebaja) {
            $pdf->Cell(20, 10, $i++, 1, 0, 'C');
            $pdf->Cell(30, 10, Yii::$app->formatter->format($rebaja->fecha, ['date', 'php:d/m/Y']), 1, 0, 'C');
            $pdf->Cell(80, 10, $rebaja->idProducto->titulo, 1, 0, 'L');
            $pdf->Cell(30, 10, $rebaja->precio_nuevo, 1, 0, 'C');
            $pdf->Cell(35, 10, $rebaja->precio_anterior, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output('D', 'Listado de Rebajas de Precios ' . date('m/Y') . '.pdf', '');
    }

}
