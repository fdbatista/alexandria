<?php

namespace app\controllers\sitio;

use app\models\Grafico;
use Yii;
use yii\web\Controller;

class GraficoController extends Controller {

    public function actionGenerarGrafico() {
        return $this->render('generar-grafico');
    }

    public function actionInicio() {
        $model = new Grafico();
        $res = ['titulos' => [], 'totales' => [], 'ingresos' => []];
        if ($model->load(Yii::$app->request->post())) {
            $model->generado = true;
        } else {
            $model->id_tipo_grafico = 'column';
            $model->generado = false;
        }
        return $this->render('inicio', ['model' => $model, 'res' => $res]);
    }

    public function actionIndex() {
        return $this->actionInicio();
    }

}
