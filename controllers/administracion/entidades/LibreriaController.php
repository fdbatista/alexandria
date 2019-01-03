<?php

namespace app\controllers\administracion\entidades;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Libreria;
use app\models\Municipio;
use app\models\Provincia;
use app\models\search\LibreriaSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * LibreriaController implements the CRUD actions for Libreria model.
 */
class LibreriaController extends GenericoAdminController {

    /**
     * Lists all Libreria models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new LibreriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Libreria::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Libreria model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Libreria model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Libreria();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $libreria = Libreria::find()
                            ->where(['nombre' => $model->nombre])
                            ->andWhere(['id_municipio' => $model->id_municipio])->all();
            if (!$libreria) {
                $model->save();
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre);
                Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                Yii::$app->session->setFlash('warning', 'Librería ya existente', false);
                return $this->render('crear', ['model' => $model, 'id_prov' => '', 'municipios' => [], 'provincias' => ArrayHelper::map(Provincia::find()->where(['id_pais' => 51])->all(), 'id', 'nombre')]);
            }
        } else {
            return $this->render('crear', ['model' => $model, 'id_prov' => '', 'municipios' => [], 'provincias' => ArrayHelper::map(Provincia::find()->where(['id_pais' => 51])->all(), 'id', 'nombre')]);
        }
    }

    /**
     * Updates an existing Libreria model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $libreria = Libreria::find()
                            ->where(['nombre' => $model->nombre])
                            ->andWhere(['id_municipio' => $model->id_municipio])->all();
            if (!$libreria) {
                $model->save();
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre);
                Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                Yii::$app->session->setFlash('warning', 'Librería ya existente', false);
                return $this->render('crear', ['model' => $model, 'id_prov' => '', 'municipios' => [], 'provincias' => ArrayHelper::map(Provincia::find()->where(['id_pais' => 51])->all(), 'id', 'nombre')]);
            }
        } else {
            $munic = Municipio::findOne($model->id_municipio);
            $prov = Provincia::findOne($munic->id_provincia);
            $munics = ArrayHelper::map(Municipio::findAll(['id_provincia' => $prov->id]), 'id', 'nombre');
            return $this->render('actualizar', ['model' => $model, 'id_prov' => $prov->id, 'municipios' => $munics, 'provincias' => ArrayHelper::map(Provincia::find()->where(['id_pais' => '51'])->all(), 'id', 'nombre')]);
        }
    }

    /**
     * Deletes an existing Libreria model.
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
     * Finds the Libreria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Libreria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Libreria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
