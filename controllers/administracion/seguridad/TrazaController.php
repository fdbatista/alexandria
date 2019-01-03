<?php

namespace app\controllers\administracion\seguridad;

use app\controllers\administracion\GenericoAdminController;
use app\models\search\TrazaSearch;
use app\models\Traza;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * TrazaController implements the CRUD actions for Traza model.
 */
class TrazaController extends GenericoAdminController
{
    /**
     * Lists all Traza models.
     * @return mixed
     */
    public function actionInicio()
    {
        $searchModel = new TrazaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('inicio', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Traza model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id)
    {
        return $this->render('detalles', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Traza model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Traza the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Traza::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
}
