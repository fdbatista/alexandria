<?php

namespace app\controllers\administracion\nomencladores;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Producto;
use app\models\search\TipoLiteraturaSearch;
use app\models\TipoLiteratura;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * TipoLiteraturaController implements the CRUD actions for TipoLiteratura model.
 */
class TipoLiteraturaController extends GenericoAdminController {

    /**
     * Lists all TipoLiteratura models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new TipoLiteraturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = TipoLiteratura::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single TipoLiteratura model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $productos = Producto::find()->where(['id_tipo_literatura' => $id])->orderBy(['titulo' => 'asc'])->all();
        return $this->render('detalles', ['model' => $this->findModel($id), 'productos' => $productos]);
    }

    /**
     * Creates a new TipoLiteratura model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new TipoLiteratura();
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
     * Updates an existing TipoLiteratura model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre);
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TipoLiteratura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->nombre);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the TipoLiteratura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoLiteratura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TipoLiteratura::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
