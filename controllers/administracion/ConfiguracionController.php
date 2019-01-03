<?php

namespace app\controllers\administracion;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\ConfigApp;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ConfigAppController implements the CRUD actions for ConfigApp model.
 */
class ConfiguracionController extends GenericoAdminController {
    
    /**
     * Lists all ConfigApp models.
     * @return mixed
     */
    public function actionInicio() {
        return $this->render('detalles', ['model' => $this->findModel(1),]);
    }

    /**
     * Displays a single ConfigApp model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles() {
        return $this->render('detalles', ['model' => $this->findModel(1),
        ]);
    }

    /**
     * Updates an existing ConfigApp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar() {
        $model = $this->findModel(1);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', 'configuracion');
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['detalles']);
        } else {
            return $this->render('actualizar', ['model' => $model,]);
        }
    }

    /**
     * Finds the ConfigApp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfigApp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ConfigApp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
