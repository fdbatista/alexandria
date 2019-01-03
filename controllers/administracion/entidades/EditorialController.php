<?php

namespace app\controllers\administracion\entidades;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Editorial;
use app\models\HtmlHelpers;
use app\models\Provincia;
use app\models\search\EditorialSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * EditorialController implements the CRUD actions for Editorial model.
 */
class EditorialController extends GenericoAdminController {

    /**
     * Lists all Editorial models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new EditorialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Editorial::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Editorial model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new Editorial model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Editorial();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $editorial = Editorial::find()
                            ->where(['nombre' => $model->nombre])
                            ->andWhere(['id_provincia' => $model->id_provincia])->all();
            if (!$editorial) {
                $model->save();
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre);
                Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                Yii::$app->session->setFlash('warning', 'Editorial ya existente', false);
                return $this->render('crear', ['model' => $model,]);
            }
        } else {
            return $this->render('crear', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing Editorial model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $editorial = Editorial::find()
                            ->where(['nombre' => $model->nombre])
                            ->andWhere(['id_provincia' => $model->id_provincia])->all();
            if (!$editorial) {
                $model->save();
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre);
                Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                Yii::$app->session->setFlash('warning', 'Editorial ya existente', false);
                return $this->render('actualizar', ['model' => $model,]);
            }
        } else {
            return $this->render('actualizar', ['model' => $model,]);
        }
    }

    /**
     * Deletes an existing Editorial model.
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
     * Finds the Editorial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Editorial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Editorial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function actionProvinciasPorPais($id) {
        echo HtmlHelpers::dropDownList(Provincia::className(), 'id_pais', $id, 'id', 'nombre');
    }

}
