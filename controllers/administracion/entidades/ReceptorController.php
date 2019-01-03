<?php

namespace app\controllers\administracion\entidades;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\EfectivoEntrega;
use app\models\Receptor;
use app\models\search\ReceptorSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ReceptorController implements the CRUD actions for Receptor model.
 */
class ReceptorController extends GenericoAdminController {

    /**
     * Lists all Receptor models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new ReceptorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Receptor::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Receptor model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $efectivos_entrega = EfectivoEntrega::find()->where(['id_receptor' => $id])->orderBy(['nombre' => 'asc'])->all();
        return $this->render('detalles', ['model' => $this->findModel($id), 'efectivos_entrega' => $efectivos_entrega]);
    }

    /**
     * Creates a new Receptor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Receptor();
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
     * Updates an existing Receptor model.
     * If update is successful, the browser will be redirected to the 'view' page.
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
     * Deletes an existing Receptor model.
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
     * Finds the Receptor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receptor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Receptor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
