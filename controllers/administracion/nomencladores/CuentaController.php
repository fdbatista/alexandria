<?php

namespace app\controllers\administracion\nomencladores;

use app\controllers\administracion\GenericoAdminController;
use app\models\Cuenta;
use app\models\HtmlHelpers;
use app\models\search\CuentaSearch;
use app\models\TipoProducto;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * CuentaController implements the CRUD actions for Cuenta model.
 */
class CuentaController extends GenericoAdminController {
    
    /**
     * Lists all Cuenta models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new CuentaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Cuenta::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Cuenta model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $tipos_productos = TipoProducto::find()->where(['id_cuenta' => $id])->orderBy(['nombre' => 'asc'])->all();
          return $this->render('detalles', ['model' => $this->findModel($id), 'tipos_productos' => $tipos_productos]);
    }

    /**
     * Creates a new Cuenta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Cuenta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionInicio();
        } else {
            return $this->render('crear', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing Cuenta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionInicio();
        } else {
            return $this->render('actualizar', ['model' => $model,]);
        }
    }

    /**
     * Deletes an existing Cuenta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Cuenta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cuenta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cuenta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
    
}
