<?php

namespace app\controllers\administracion\miscelaneas;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Autor;
use app\models\HtmlHelpers;
use app\models\Producto;
use app\models\ProductoAutor;
use app\models\search\ProductoSearch;
use app\models\TipoProducto;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends GenericoAdminController {

    /**
     * Lists all Producto models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Producto::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Producto model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', ['model' => $this->findModel($id),]);
    }

    /**
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Producto();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->titulo);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            $atributos = json_encode($atributos_viejos);
            return $this->render('crear', ['model' => $model, 'id_cuenta' => '', 'atributos' => $atributos]);
        }
    }

    /**
     * Updates an existing Producto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->titulo);
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['detalles', 'id' => $model->id]);
        } else {
            $atributos = json_encode($atributos_viejos);
            return $this->render('actualizar', ['model' => $model, 'id_cuenta' => TipoProducto::findOne($model->id_tipo_producto)->id_cuenta, 'atributos' => $atributos]);
        }
    }

    /**
     * Deletes an existing Producto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->titulo);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    public function actionAutores($id) {
        $post = Yii::$app->request->post();
        if ($post) {
            $obj = new ProductoAutor();
            $obj->id_autor = $post['id_autor'];
            $obj->id_producto = $id;
            $obj->save();
        }
        $prodAutores = Producto::findOne($id)->productoAutors;
        $autores = Autor::find()->orderBy(['nombre1' => 'asc'])->all();
        return $this->render('autores', ['prodAutores' => $prodAutores, 'autores' => $autores]);
    }

    /**
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }


}
