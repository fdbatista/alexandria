<?php

namespace app\controllers\administracion\entidades;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Almacen;
use app\models\Municipio;
use app\models\Provincia;
use app\models\search\AlmacenSearch;
use app\models\Transferencia;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * AlmacenController implements the CRUD actions for Almacen model.
 */
class ProveedorController extends GenericoAdminController {
    
    /**
     * Lists all Almacen models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new AlmacenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Almacen::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Almacen model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $transferencias = Transferencia::find()->where(['id_almacen' => $id])->orderBy(['numero' => 'asc'])->all();
        return $this->render('detalles', ['model' => $this->findModel($id), 'transferencias' => $transferencias]);
    }

    /**
     * Creates a new Almacen model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Almacen();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre);
            \Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('crear', ['model' => $model, 'id_prov' => '', 'municipios' => [], 'provincias' => ArrayHelper::map(Provincia::find()->where(['id_pais' => 51])->all(), 'id', 'nombre')]);
        }
    }

    /**
     * Updates an existing Almacen model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre);
            \Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            $munic = Municipio::findOne($model->id_municipio);
            $prov = Provincia::findOne($munic->id_provincia);
            $munics = ArrayHelper::map(Municipio::findAll(['id_provincia' => $prov->id]), 'id', 'nombre');
            return $this->render('actualizar', ['model' => $model, 'id_prov' => $prov->id, 'municipios' => $munics, 'provincias' => ArrayHelper::map(Provincia::find()->where(['id_pais' => 51])->all(), 'id', 'nombre')]);
        }
    }

    /**
     * Deletes an existing Almacen model.
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
     * Finds the Almacen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Almacen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Almacen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
