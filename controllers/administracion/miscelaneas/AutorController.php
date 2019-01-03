<?php

namespace app\controllers\administracion\miscelaneas;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Autor;
use app\models\search\AutorSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AutorController implements the CRUD actions for Autor model.
 */
class AutorController extends GenericoAdminController {

    /**
     * Lists all Autor models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new AutorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Autor::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Autor model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        /* $productos = Producto::find()->where(['id_autor' => $id])->orderBy(['titulo' => 'asc'])->all();
          return $this->render('detalles', ['model' => $this->findModel($id), 'productos' => $productos]); */
        return $this->render('detalles', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Autor model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Autor();
        $atributos_viejos = $model->attributes;

        if ($model->load(Yii::$app->request->post())) {
            $model->nombre_completo = $model->nombre1 . ' ' . $model->nombre2 . ' ' . $model->apellido1 . ' ' . $model->apellido2;
            if ($model->save()) {
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre1 . ' ' . $model->apellido1);
                Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
                return $this->redirect(['inicio']);
            }
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Autor model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre1 . ' ' . $model->apellido1);
            Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
            return $this->redirect(['inicio']);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Autor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $model->delete();
        $atributos_viejos = $model->attributes;
        StaticMembers::RegistrarTraza($model, $atributos_viejos, 'eliminar', $model->nombre1 . ' ' . $model->apellido1);
        Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
        return $this->redirect(['inicio']);
    }

    /**
     * Finds the Autor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Autor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Autor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
