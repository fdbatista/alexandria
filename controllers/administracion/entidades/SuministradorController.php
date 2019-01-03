<?php

namespace app\controllers\administracion\entidades;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\search\SuministradorSearch;
use app\models\Suministrador;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * SuministradorController implements the CRUD actions for Suministrador model.
 */
class SuministradorController extends GenericoAdminController {

    /**
     * Lists all Suministrador models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new SuministradorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Suministrador::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Suministrador model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Suministrador model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Suministrador();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre);
            \Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Suministrador model.
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
     * Deletes an existing Suministrador model.
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
     * Finds the Suministrador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Suministrador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Suministrador::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
