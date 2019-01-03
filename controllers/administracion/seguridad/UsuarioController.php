<?php

namespace app\controllers\administracion\seguridad;

use app\controllers\administracion\GenericoAdminController;
use app\controllers\StaticMembers;
use app\models\search\UsuarioSearch;
use app\models\Usuario;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends GenericoAdminController {

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionInicio() {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cant = Usuario::find()->count();
        $texto = ($cant > 0) ? "Agregar" : "Crear";

        return $this->render('inicio', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'textoBoton' => $texto,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalles($id) {
        return $this->render('detalles', ['model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Usuario();
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contrasenha) {
                $model->contrasenha = Yii::$app->security->generatePasswordHash($model->contrasenha);
                $model->contrasenha_confirmacion = $model->contrasenha;
            }
            $model->nombre_completo = $model->nombre1 . ' ' . $model->nombre2 . ' ' . $model->apellido1 . ' ' . $model->apellido2;
            if ($model->save()) {
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre_usuario);
                \Yii::$app->session->setFlash('success', 'Elemento creado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                return $this->render('crear', ['model' => $model]);
            }
        } else {
            return $this->render('crear', ['model' => $model]);
        }
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $contrasenha_anterior = $model->contrasenha;
        $atributos_viejos = $model->attributes;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contrasenha) {
                if ($model->contrasenha === $model->contrasenha_confirmacion) {
                    $model->contrasenha = Yii::$app->security->generatePasswordHash($model->contrasenha);
                    $model->contrasenha_confirmacion = $model->contrasenha;
                } else {
                    $model->addError('contrasenha_confirmacion', 'La contraseña de confirmación no coincide');
                    return $this->render('actualizar', ['model' => $model]);
                }
            } else {
                $model->contrasenha = $contrasenha_anterior;
                $model->contrasenha_confirmacion = $model->contrasenha;
            }
            if ($model->save()) {
                StaticMembers::RegistrarTraza($model, $atributos_viejos, 'actualizar', $model->nombre_usuario);
                \Yii::$app->session->setFlash('success', 'Elemento actualizado correctamente', false);
                return $this->redirect(['inicio']);
            } else {
                return $this->render('actualizar', ['model' => $model]);
            }
        } else {
            return $this->render('actualizar', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id) {
        if ($id == Yii::$app->user->identity->id) {
            Yii::$app->session->setFlash('danger', 'No se puede eliminar la cuenta de usuario activa.', false);
            return $this->redirect(['inicio']);
        } else {
            $model = $this->findModel($id);
            $model->delete();
            $atributos_viejos = $model->attributes;
            StaticMembers::RegistrarTraza($model, $atributos_viejos, 'crear', $model->nombre_usuario);
            Yii::$app->session->setFlash('success', 'Elemento eliminado correctamente', false);
            return $this->redirect(['inicio']);
        }
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

}
