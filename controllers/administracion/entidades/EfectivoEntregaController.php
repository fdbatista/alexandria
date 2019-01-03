<?php

namespace app\controllers\administracion\entidades;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\Devolucion;
use app\models\EfectivoEntrega;
use app\models\search\EfectivoEntregaSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * EfectivoEntregaController implements the CRUD actions for EfectivoEntrega model.
 */
class EfectivoEntregaController extends GenericoAdminController {

    /**
     * Lists all EfectivoEntrega models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new EfectivoEntregaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = EfectivoEntrega::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single EfectivoEntrega model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        $devoluciones = Devolucion::find()->where(['id_efect_entr' => $id])->orderBy(['numero' => 'asc'])->all();
        return $this->render('detalles', ['model' => $this->findModel($id), 'devoluciones' => $devoluciones]);
    }

    /**
     * Creates a new EfectivoEntrega model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new EfectivoEntrega();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $efectivoEntrega = EfectivoEntrega::find()
                            ->where(['nombre' => $model->nombre])
                            ->andWhere(['id_receptor' => $model->id_receptor])->all();
            if (!$efectivoEntrega) {
                $model->save();
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre);
                Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                Yii::$app->session->setFlash('warning', 'Efectivo Entrega ya existente', false);
                return $this->render('crear', ['model' => $model,]);
            }
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EfectivoEntrega model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            $efectivoEntrega = EfectivoEntrega::find()
                            ->where(['nombre' => $model->nombre])
                            ->andWhere(['id_receptor' => $model->id_receptor])->all();
            if (!$efectivoEntrega) {
                $model->save();
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre);
                Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                Yii::$app->session->setFlash('warning', 'Efectivo Entrega ya existente', false);
                return $this->render('actualizar', ['model' => $model,]);
            }
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EfectivoEntrega model.
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
     * Finds the EfectivoEntrega model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EfectivoEntrega the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EfectivoEntrega::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
