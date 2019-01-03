<?php

namespace app\controllers\administracion;

use app\models\ConfigApp;
use app\models\MiPerfil;
use app\models\Usuario;
use Yii;

class InicioController extends GenericoAdminController {

    public function actionInicio() {
        if (Yii::$app->user->identity->esAdmin()) {
            return $this->render('inicio');
        }
        return $this->redirect(['/sitio/inicio']);
    }

    public function actionError() {
        return $this->render('error');
    }

    public function actionMiPerfil() {
        $model = new MiPerfil();
        $usuario = Usuario::findOne(Yii::$app->user->identity->id);
        $model->setUsuario($usuario);
        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->security->validatePassword($model->contrasenhaActual, $model->usuario->contrasenha)) {
                $model->addError('contrasenhaActual', 'La contraseña actual no es la correcta');
            } else {
                $model->contrasenhaNueva = Yii::$app->security->generatePasswordHash($model->contrasenhaNueva);
                $model->contrasenhaConfirmacion = $model->contrasenhaNueva;
                $usuario->contrasenha = $model->contrasenhaNueva;
                $usuario->save();
                Yii::$app->session->setFlash('success', 'Su contraseña ha sido actualizada', false);
                $model = new MiPerfil();
                $usuario = Usuario::findOne(Yii::$app->user->identity->id);
                $model->setUsuario($usuario);
            }
        }
        return $this->render('mi-perfil', ['model' => $model]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAcercaDe() {
        $config_app = ConfigApp::findOne(1);
        $nombreApp = '';
        if ($config_app) {
            $nombreApp = $config_app->nombre_app;
        }
        return $this->render('acerca-de', ['nombreApp' => $nombreApp]);
    }

}
