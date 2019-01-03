<?php

namespace app\controllers\sitio;

use app\controllers\sitio\GenericoController;
use app\controllers\StaticMembers;
use app\models\Producto;
use app\models\search\VentaSearch;
use app\models\Usuario;
use app\models\Venta;
use app\models\VentaProducto;
use FPDF;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * VentaController implements the CRUD actions for Venta model.
 */
class VentaController extends GenericoController {

    /**
     * Lists all Venta models.
     * @return mixed
     */
    public function actionInicio() {
        $usuario = Usuario::findOne(Yii::$app->user->identity->id);
//        Yii::$app->session->setFlash('success', '$cant', false);
        if ($usuario->idRol->nombre == 'Librero') {
            $searchModel = new VentaSearch();
            $f = getdate();
            $fechaPC = $f['year'] . '-' . $f['mon'] . '-' . ($f['mday']);
            //Yii::$app->session->setFlash('success', $fechaPC, false);
            $dataProvider = $searchModel->search($usuario->id, $fechaPC, Yii::$app->request->queryParams);
            $cant = Venta::find()->count();
            $texto = ($cant > 0) ? "Agregar" : "Crear";

            return $this->render('inicio', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'textoBoton' => $texto,
            ]);
        } else {
            $searchModel = new VentaSearch();
            $f = getdate();
            $fechaPC = $f['year'] . '-' . $f['mon'] . '-' . ($f['mday']);
            //Yii::$app->session->setFlash('success', $fechaPC, false);
            $dataProvider = $searchModel->search(NULL, $fechaPC, Yii::$app->request->queryParams);
            $cant = Venta::find()->count();
            $texto = ($cant > 0) ? "Agregar" : "Crear";

            return $this->render('inicio', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'textoBoton' => $texto,
            ]);
        }
    }

    public function contarVentasUsuario($id) {
        $result = Venta::find()->where(['id_usuario' => $id])->count();
        return $result;
    }

    /**
     * Displays a single Venta model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Venta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $userActivo = Usuario::findOne(Yii::$app->user->identity->id);
        $model = new Venta();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->id);
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
     * Updates an existing Venta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $userActivo = Usuario::findOne(Yii::$app->user->identity->id);
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->id);
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
     * Deletes an existing Venta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);

        $productosVendidos = VentaProducto::find()->where(['id_venta' => $model->id])->all();
        foreach ($productosVendidos as $productoVendido) {
            $producto = Producto::findOne($productoVendido->id_producto);
            if ($producto) {
                $producto->existencia += $productoVendido->cantidad;
                $producto->save();
            }
        }
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->id);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Venta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Venta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Venta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function actionGuardar($venta) {
        $params = json_decode($venta, true);
        $paramsVenta = $params['venta'];

        if ($paramsVenta['id']) {
            $accion = 'actualizar';
            $msg = 'actualizado';

            $model = Venta::findOne($paramsVenta['id']);
            $productos = VentaProducto::find()->where(['id_venta' => $model->id])->all();
            foreach ($productos as $productoAux) {
                $producto = Producto::findOne($productoAux->id_producto);
                if ($producto) {
                    $producto->existencia += $productoAux->cantidad;
                    $producto->save();
                }
            }
            VentaProducto::deleteAll(['id_venta' => $model->id]);
        } else {
            $accion = 'crear';
            $msg = 'creado';
            $model = new Venta();
        }
        $atributos_viejos = $model->attributes;
        $model->setAttributes(['fecha' => $paramsVenta['fecha_hora'], 'id_usuario' => $paramsVenta['id_usuario']]);
        $model->save();

        $paramsProductos = $params['productos'];
        $nombresProductos = 'PRODUCTOS: ';
        foreach ($paramsProductos as $paramProd) {
            $producto = Producto::findOne(['titulo' => $paramProd['titulo'], 'precio_costo' => $paramProd['precio_costo']]);
            if ($producto) {
                $nombresProductos .= $producto->titulo . ' (' . $paramProd['cantidad'] . '), ';
                $ventaProd = new VentaProducto();
                $ventaProd->precio = $paramProd['precio_venta'];
                $ventaProd->cantidad = $paramProd['cantidad'];
                $ventaProd->id_venta = $model->id;
                $ventaProd->id_producto = $producto->id;
                $ventaProd->save();

                $producto->existencia -= $ventaProd->cantidad;
                $producto->save();
            }
        }
        StaticMembers::RegistrarTraza($model, $atributos_viejos, $accion, $model->id, $nombresProductos);
        Yii::$app->session->setFlash('success', 'Elemento ' . $msg . ' correctamente', false);
    }

    public function actionExportarListado($fecha) {
        define('FPDF_FONTPATH', 'fpdf181/font/');
        require('fpdf181/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Desglose de Venta Diaria ' . date('m/Y'), 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'No.', 1, 0, 'C');
        $pdf->Cell(80, 10, 'Producto', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Ejemplares', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Precio Venta', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Importe Venta', 1, 0, 'C');
        $pdf->Ln();
        $fechaVenta = Venta::find()->where(['fecha' => $fecha])->all();
        $i = 1;
        $cantTotal = 0;
        $impVentaTotal = 0;
        foreach ($fechaVenta as $value) {
            $ventas = VentaProducto::find()->where(['id_venta' => $value->id])->all();


            $pdf->SetFont('Arial', '', 12);
            foreach ($ventas as $venta) {
                $pdf->Cell(20, 10, $i++, 1, 0, 'C');
                $pdf->Cell(80, 10, $venta->idProducto->titulo, 1, 0, 'L');
                $pdf->Cell(30, 10, $venta->cantidad, 1, 0, 'C');
                $pdf->Cell(30, 10, $venta->idProducto->precio_venta, 1, 0, 'C');
                $pdf->Cell(35, 10, $venta->cantidad * $venta->idProducto->precio_venta, 1, 0, 'C');
                $pdf->Ln();
                $cantTotal = $cantTotal + $venta->cantidad;
                $impVentaTotal = $impVentaTotal + $venta->cantidad * $venta->idProducto->precio_venta;
            }
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 10, '', 1, 0, 'C');
        $pdf->Cell(80, 10, 'Total', 1, 0, 'R');
        $pdf->Cell(30, 10, $cantTotal, 1, 0, 'C');
        $pdf->Cell(30, 10, '-', 1, 0, 'C');
        $pdf->Cell(35, 10, $impVentaTotal, 1, 0, 'C');

        $pdf->Output('D', 'Desglose de Venta Diaria ' . date('m/Y') . '.pdf', '');
    }

}
