<?php

namespace app\controllers\administracion\nomencladores;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Producto;
use app\models\search\TipoPublicoSearch;
use app\models\TipoPublico;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * TipoPublicoController implements the CRUD actions for TipoPublico model.
 */
class TipoPublicoController extends GenericoAdminController {

    /**
     * Lists all TipoPublico models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new TipoPublicoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = TipoPublico::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single TipoPublico model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $productos = Producto::find()->where(['id_tipo_publico' => $id])->orderBy(['titulo' => 'asc'])->all();
        return $this->render('detalles', ['model' => $this->findModel($id), 'productos' => $productos]);
    }

    /**
     * Creates a new TipoPublico model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new TipoPublico();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre);
            Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TipoPublico model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre);
            \Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TipoPublico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->nombre);
        \Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the TipoPublico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoPublico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TipoPublico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
