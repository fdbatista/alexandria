<?php

namespace app\controllers\sitio;

use app\controllers\StaticMembers;
use app\models\Devolucion;
use app\models\DevolucionProducto;
use app\models\Producto;
use app\models\search\DevolucionSearch;
use app\models\Usuario;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * DevolucionController implements the CRUD actions for Devolucion model.
 */
class DevolucionController extends GenericoController {

    /**
     * Lists all Devolucion models.
     * @return mixed
     */
    public function actionInicio() {
        $usuario = Usuario::findOne(Yii::$app->user->identity->id);
        if ($usuario->idRol->nombre == 'Librero') {
            $searchModel = new DevolucionSearch();
            $dataProvider = $searchModel->datosXId($usuario->id, Yii::$app->request->queryParams);
            $cant = Devolucion::find()->count();
            $texto = ($cant > 0) ? "Agregar" : "Crear";

            return $this->render('inicio', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'textoBoton' => $texto,
            ]);
        } else {
            $searchModel = new DevolucionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $cant = Devolucion::find()->count();
            $texto = ($cant > 0) ? "Agregar" : "Crear";

            return $this->render('inicio', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'textoBoton' => $texto,
            ]);
        }
    }

    /**
     * Displays a single Devolucion model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $cuentaDev = DevolucionProducto::findOne(['id_devolucion' => $id])->idProducto->idTipoProducto->idCuenta->nombre;
                return $this->render('detalles', ['model' => $this->findModel($id), 'cuentaDev' => $cuentaDev]);
    }

    /**
     * Creates a new Devolucion model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $userActivo = Usuario::findOne(Yii::$app->user->identity->id);
        $model = new Devolucion();
        $atributos_viejos = $model->attributes;
        $descomercial = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->numero);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            if ($userActivo->idRol->nombre == 'Librero') {
                $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id = ' . $userActivo->id)->all(), 'id', 'nombreCompleto');
                $esLibrero = true;
                return $this->render('crear', ['model' => $model, 'usuarios' => $usuarios, 'descomercial' => $descomercial, 'cuenta' => '', 'esLibrero' => $esLibrero]);
            } else {
                $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id_rol = 1')->all(), 'id', 'nombreCompleto');
               $esLibrero = false;
                return $this->render('crear', ['model' => $model, 'usuarios' => $usuarios, 'descomercial' => $descomercial, 'cuenta' => '', 'esLibrero' => $esLibrero]);
            }
        }
    }

    /**
     * Updates an existing Devolucion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    ///revisar que no guarda los productos
    //revisar si hay que pasarle a las vistas crear y actualizar los valores de cuenta y usuarios
    public function actionActualizar($id) {
        $userActivo = Usuario::findOne(Yii::$app->user->identity->id);
        $descuentoComercial = Devolucion::findOne(['id'=>$id])->idEfectEntr->idReceptor->descuento_comercial;
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        $prods = $model->devolucionProductos;
        $id_cuenta = Producto::findOne($prods[0]->id_producto)->idTipoProducto->id_cuenta;
        if ($userActivo->idRol->nombre == 'Librero') {
            $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id = ' . $userActivo->id)->all(), 'id', 'nombreCompleto');
            $esLibrero = true;
            return $this->render('actualizar', ['model' => $model, 'usuarios' => $usuarios, 'id_cuenta' => $id_cuenta, 'descomercial' => $descuentoComercial, 'esLibrero' => $esLibrero]);
        } else {
            $usuarios = ArrayHelper::map(Usuario::findBySql('select * from usuario where activo = true and id_rol = 1')->all(), 'id', 'nombreCompleto');
            $esLibrero = false;
            return $this->render('actualizar', ['model' => $model, 'usuarios' => $usuarios, 'id_cuenta' => $id_cuenta, 'descomercial' => $descuentoComercial, 'esLibrero' => $esLibrero]);
        }
    }

    /**
     * Deletes an existing Devolucion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        //para ver si actualiza la existencia de producto al eliminar una devolucion
        $productosDev = DevolucionProducto::find()->where(['id_devolucion' => $model->id])->all();
        foreach ($productosDev as $productoDev) {
            $producto = Producto::findOne($productoDev->id_producto);
            if ($producto) {
                $producto->existencia += $productoDev->cantidad;
                $producto->save();
            }
        }

        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->numero);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Devolucion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Devolucion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Devolucion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function actionGuardar($devolucion) {
        $params = json_decode($devolucion, TRUE);
        $paramsDev = $params['devolucion'];

        if ($paramsDev['id']) {
            $accion = 'actualizar';
            $msg = 'actualizado';
            $model = Devolucion::findOne($paramsDev['id']);

            $productos = DevolucionProducto::find()->where(['id_devolucion' => $model->id])->all();
            foreach ($productos as $productoAux) {
                $producto = Producto::findOne($productoAux->id_producto);
                if ($producto) {
                    $producto->existencia -= $productoAux->cantidad;
                    $producto->save();
                }
            }
            DevolucionProducto::deleteAll(['id_devolucion' => $model->id]);
        } else {
            $accion = 'crear';
            $msg = 'creado';
            $model = new Devolucion();
        }
        $atributos_viejos = $model->attributes;
        $model->setAttributes([
            'numero' => $paramsDev['numero'],
            //'presupuesto_receptor' => $paramsDev['presupuesto_receptor'],
            'id_usuario' => $paramsDev['id_usuario'],
            'fecha' => $paramsDev['fecha'],
            //'descuento' => $paramsDev['descuento'],
            'id_efect_entr' => $paramsDev['id_efect_entr'],
        ]);

        if ($model->save()) {
            $paramsProductos = $params['productos'];
            $nombresProductos = 'PRODUCTOS: ';
            foreach ($paramsProductos as $paramProd) {
                $producto = Producto::findOne([
                            'titulo' => $paramProd['titulo'],
                            'precio_costo' => $paramProd['precio_costo'],
                ]);

                if ($producto) {
                    $producto->existencia -= $paramProd['cantidad'];

                    $producto->save();


//                    $inventario = Inventario::findOne(['id_usuario' => $model->id_usuario, 'id_producto' => $producto->id]);
//                    if (!$inventario) {
//                        $inventario = new Inventario(['cantidad' => 0]);
//                    }
//                    $inventario->setAttributes(['id_usuario' => $model->id_usuario, 'id_producto' => $producto->id, 'cantidad' => $inventario->cantidad + $paramProd['cantidad'], 'id_devolucion' => $model->id]);
//                    $inventario->save();

                    $nombresProductos .= $producto->titulo . ' (' . $paramProd['cantidad'] . '), ';
                    $devProd = new DevolucionProducto();
                    $devProd->cantidad = $paramProd['cantidad'];
                    $devProd->id_devolucion = $model->id;
                    $devProd->id_producto = $producto->id;
                    $devProd->importe_costo = $producto->precio_costo * $paramProd['cantidad'];
                    $devProd->importe_venta = $producto->precio_venta * $paramProd['cantidad'];
                    $devProd->precio_costo = $producto->precio_costo;
                    $devProd->precio_venta = $producto->precio_venta;
                    $devProd->save();

                    StaticMembers::RegistrarTraza($model, $atributos_viejos, $accion, $model->id, $nombresProductos);
                    Yii::$app->session->setFlash('success', 'Elemento ' . $msg . ' correctamente', false);
                }
            }
        } else {
            Yii::$app->session->setFlash('danger', 'No se guardaron los cambios realizados en la Devolución', false);
        }
    }

}
