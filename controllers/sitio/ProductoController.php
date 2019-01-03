<?php

namespace app\controllers\sitio;

use app\models\Producto;
use app\models\search\ProductoSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends GenericoController {

    /**
     * Lists all Producto models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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
