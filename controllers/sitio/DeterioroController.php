<?php

namespace app\controllers\sitio;

use app\controllers\StaticMembers;
use app\models\Deterioro;
use app\models\Producto;
use app\models\search\DeterioroSearch;
use app\models\Usuario;
use FPDF;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * DeterioroController implements the CRUD actions for Deterioro model.
 */
class DeterioroController extends GenericoController {

    /**
     * Lists all Deterioro models.
     * @return mixed
     */
    public function actionInicio() {
        $usuario = Usuario::findOne(Yii::$app->user->identity->id);

        if ($usuario->idRol->nombre == 'Librero') {
            $searchModel = new DeterioroSearch();
            $dataProvider = $searchModel->datosXId($usuario->id, Yii::$app->request->queryParams);
            $cant = Deterioro::find()->count();
            $texto = ($cant > 0) ? "Agregar" : "Crear";
            $classActivo = "hidden";
            return $this->render('inicio', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'textoBoton' => $texto,
                'classActivo' => $classActivo,
            ]);
        } else {
            $searchModel = new DeterioroSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $cant = Deterioro::find()->count();
            $texto = ($cant > 0) ? "Agregar" : "Crear";
             $classActivo = " ";
            return $this->render('inicio', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'textoBoton' => $texto,
                'classActivo' => $classActivo,
            ]);
        }
    }

    /**
     * Displays a single Deterioro model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', ['model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Deterioro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $userActivo = Usuario::findOne(Yii::$app->user->identity->id);
        $model = new Deterioro();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $impVenta = $model->cantidad * $model->idProducto->precio_venta;
            $impCosto = $model->cantidad * $model->idProducto->precio_costo;
            $model->importe_venta = $impVenta;
            $model->importe_costo = $impCosto;
            $model->save();
            $producto = Producto::findOne($model->id_producto);
            $producto->existencia -= $model->cantidad;
            $producto->save();
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->idProducto->titulo);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            if ($userActivo->idRol->nombre == 'Librero') {
                $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id = ' . $userActivo->id)->all(), 'id', 'nombreCompleto');
                $esLibrero = true;
                return $this->render('crear', ['model' => $model, 'usuarios' => $usuarios, 'esLibrero' => $esLibrero]);
            } else {
                $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id_rol = 1')->all(), 'id', 'nombreCompleto');
                $esLibrero = false;
                return $this->render('crear', ['model' => $model, 'usuarios' => $usuarios, 'esLibrero' => $esLibrero]);
            }
        }
    }

    /**
     * Updates an existing Deterioro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $userActivo = Usuario::findOne(Yii::$app->user->identity->id);
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $difCantidad = $model->cantidad - $atributos_viejos['cantidad'];
            $producto = Producto::findOne($model->id_producto);
            if ($difCantidad < 0) {
                $producto->existencia += $difCantidad * -1;
                $producto->save();
            } else if ($difCantidad > 0) {
                $producto->existencia -= $difCantidad;
                $producto->save();
            }
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->idProducto->titulo . ' (' . $model->cantidad . ' ejemplares)');
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            if ($userActivo->idRol->nombre == 'Librero') {
                $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id = ' . $userActivo->id)->all(), 'id', 'nombreCompleto');
                 $esLibrero = true;
                return $this->render('actualizar', ['model' => $model, 'usuarios' => $usuarios, 'esLibrero' => $esLibrero]);
            } else {
                $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id_rol = 1')->all(), 'id', 'nombreCompleto');
                $esLibrero = false;
                return $this->render('actualizar', ['model' => $model, 'usuarios' => $usuarios, 'esLibrero' => $esLibrero]);
            }
        }
    }

    /**
     * Deletes an existing Deterioro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $model->delete();
        $atributos_viejos = $model->attributes;

        $producto = Producto::findOne($model->id_producto);
        $producto->existencia += $model->cantidad;
        $producto->save();

        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->idProducto->titulo);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Deterioro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deterioro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Deterioro::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    //Metodo no terminado, no guarda las trazas
    //ni elimina producto
    public function exportarDocumento() {
        define('FPDF_FONTPATH', 'fpdf181/font/');
        require('fpdf181/fpdf1.php');

        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 8, 'Deterioro ' . date('m/Y'), 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9.5, 8, 'No.', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Codigo', 1, 0, 'C');
        $pdf->Cell(115, 8, 'Titulo', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Precio Venta', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Precio Costo', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Importe Venta', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Importe Costo', 1, 1, 'C');

        $deterioros = Deterioro::find()->all();
        $i = 1;
        $cantTotal = 0;
        $impVentaTotal = 0;
        $impCostoTotal = 0;
        $pdf->SetFont('Arial', '', 10);

        foreach ($deterioros as $value) {
            $pdf->Cell(9.5, 8, $i++, 1, 0, 'C');
            $pdf->Cell(15, 8, $value->idProducto->codigo, 1, 0, 'C');
            $pdf->Cell(115, 8, $value->idProducto->titulo, 1, 0, 'L');
            $pdf->Cell(20, 8, $value->cantidad, 1, 0, 'C');
            $pdf->Cell(25, 8, $value->idProducto->precio_venta, 1, 0, 'C');
            $pdf->Cell(25, 8, $value->idProducto->precio_costo, 1, 0, 'C');
            $pdf->Cell(25, 8, $value->importe_venta, 1, 0, 'C');
            $pdf->Cell(25, 8, $value->importe_costo, 1, 1, 'C');

            $cantTotal = $cantTotal + $value->cantidad;
            $impVentaTotal = $impVentaTotal + $value->importe_venta;
            $impCostoTotal = $impCostoTotal + $value->importe_costo;
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(9.5, 8, '', 1, 0, 'C');
        $pdf->Cell(15, 8, '', 1, 0, 'C');
        $pdf->Cell(115, 8, 'Total', 1, 0, 'R');
        $pdf->Cell(20, 8, $cantTotal, 1, 0, 'C');
        $pdf->Cell(25, 8, '-', 1, 0, 'C');
        $pdf->Cell(25, 8, '-', 1, 0, 'C');
        $pdf->Cell(25, 8, $impVentaTotal, 1, 0, 'C');
        $pdf->Cell(25, 8, $impCostoTotal, 1, 1, 'C');

        $pdf->Output('D', 'Deterioro ' . date('m/Y') . '.pdf', TRUE);
    }

    public function actionEjecutar() {
        $this->exportarDocumento();

//        $modelos = Deterioro::find()->all();
//        foreach ($modelos as $model) {
//            $atributos_viejos = $model->attributes;
//            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'ejecutar', $model->idProducto->titulo);
//            $model->delete();
//        }
        Deterioro::deleteAll();
//        Yii::$app->session->setFlash('success', 'Listado de Deterioro ejecutado correctamente', false);
        //return $this->redirect('inicio');
    }

}
