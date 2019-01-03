<?php

namespace app\controllers\administracion\nomencladores;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\HtmlHelpers;
use app\models\Municipio;
use app\models\search\MunicipioSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * MunicipioController implements the CRUD actions for Municipio model.
 */
class MunicipioController extends GenericoAdminController {

    /**
     * Lists all Movimiento models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new MunicipioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Municipio::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Municipio model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Municipio model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Municipio();
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
     * Updates an existing Municipio model.
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
     * Deletes an existing Municipio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) 
    {
        $model = $this->findModel($id);
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->nombre);
        \Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Municipio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Municipio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Municipio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
