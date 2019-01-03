<?php

namespace app\controllers\administracion\seguridad;

use app\controllers\administracion\GenericoAdminController;
use app\models\HtmlHelpers;
use app\models\Permiso;
use app\models\Rol;
use app\models\RolPermiso;
use app\models\search\RolPermisoSearch;
use app\models\search\RolSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * RolController implements the CRUD actions for Rol model.
 */
class RolController extends GenericoAdminController
{
    /**
     * Lists all Rol models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new RolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Rol::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Rol model.
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
     * Creates a new Rol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Rol();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['inicio', 'id' => $model->id]);
        } else {
            return $this->render('crear', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing Rol model.
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
     * Deletes an existing Rol model.
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
     * Finds the Rol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rol::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }
    
    //Permisos
    
    public function actionPermisos($id)
    {
        $searchModel = new RolPermisoSearch();
        $rol = Rol::findOne($id);
        if ($rol) {
            $searchModel->id_rol = $id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('permisos/inicio', ['searchModel' => $searchModel,'dataProvider' => $dataProvider,]);
        } else {
            return $this->redirect(['/rol']);
        }
    }
    
    public function actionDetallesPermiso($id) {
        return $this->render('permisos/detalles', ['model' => RolPermiso::findOne($id),]);
    }
    
    public function actionActualizarPermiso($id) {
        $model = RolPermiso::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['permisos', 'id' => $model->id_rol]);
        } else {
            $permisos = ArrayHelper::map(Permiso::find()->where(['entidad' => $model->idPermiso->entidad])->all(), 'id', 'nombre');
            return $this->render('permisos/actualizar', ['model' => $model, 'permisos' => $permisos]);
        }
    }
    
    public function actionAsignarPermiso($id) {
        $model = new RolPermiso();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['permisos', 'id' => $id]);
        } else {
            $rol = Rol::findOne($id);
            if ($rol) {
                $model->id_rol = $rol->id;
                return $this->render('permisos/crear', ['model' => $model, 'permisos' => []]);
            } else {
                return $this->redirect(['/administracion/seguridad/rol']);
            }
        }
    }
    
    public function actionEliminarPermiso($id) {
        $model = RolPermiso::findOne($id);
        $model->delete();
        return $this->redirect(['permisos', 'id' => $model->id_rol]);
    }
    
    public function actionPermisosPorEntidad($entidad_html) {
        echo HtmlHelpers::dropDownList(Permiso::className(), 'entidad_html', $entidad_html, 'id', 'nombre');
    }
    
}
