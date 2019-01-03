<?php

namespace app\controllers\administracion\seguridad;

use app\controllers\administracion\GenericoAdminController;
use app\models\Permiso;
use app\models\search\PermisoSearch;
use app\models\views\VEntidad;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * PermisoController implements the CRUD actions for Permiso model.
 */
class PermisoController extends GenericoAdminController {

    /**
     * Lists all Permiso models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new PermisoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Permiso::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Permiso model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', ['model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Permiso model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Permiso();
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
     * Updates an existing Permiso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $vEntidad = VEntidad::findOne(['entidad' => $model->entidad]);
            if ($vEntidad) {
                $model->entidad_html = $vEntidad->entidad_html;
            }
            if ($model->save()) {
                return $this->actionInicio();
            }
        }
        return $this->render('actualizar', ['model' => $model,]);
    }

    /**
     * Finds the Permiso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Permiso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Permiso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
