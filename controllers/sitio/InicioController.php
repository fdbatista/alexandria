<?php

namespace app\controllers\sitio;

use app\controllers\StaticMembers;
use app\models\ConfigApp;
use app\models\LoginForm;
use app\models\MiPerfil;
use app\models\RecuperarContrasenha;
use app\models\RestablecerContrasenha;
use app\models\User;
use app\models\Usuario;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\Session;
use const YII_ENV_TEST;

class InicioController extends GenericoController {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionInicio() {
        if (StaticMembers::AccesoAModulo('sitio')) {
            return $this->render('principal');
        } else if (StaticMembers::AccesoAModulo('administracion')) {
            return $this->redirect(['administracion/inicio']);
        }
//        else if (StaticMembers::AccesoAModulo('reportes')) {
//            return $this->redirect(['reportes/inicio']);
//        } 
        else {
            throw new ForbiddenHttpException('No tiene permitido ejecutar esta acción');
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionAutenticar() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /* $permisos = Yii::$app->db->createCommand("select v.modulo_html, v.ruta from v_permiso v where id in (select id_permiso from rol_permiso where id_rol = :id_rol)")->bindValues([':id_rol' => Yii::$app->user->identity->id_rol])->queryAll();
              $modulos = [];
              $rutas = [];
              foreach ($permisos as $permiso) {
              $rutas[$permiso['ruta']] = 1;
              if (!in_array($permiso['modulo_html'], $modulos)) {
              $modulos[$permiso['modulo_html']] = 1;
              }
              }
              $datos_usuario = ['modulos' => $modulos, 'rutas' => $rutas];
              Yii::$app->session->set('datos_usuario', $datos_usuario); */
            return $this->goBack();
        }
        return $this->render('autenticar', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionSalir() {
        Yii::$app->user->logout();

        return $this->goHome();
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

    public function actionRecuperarContrasenha() {
        $model = new RecuperarContrasenha();
        //$msg = NU;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //$table = Usuario::find()->where("email:=email", [":email" => $model->email]);
                $table = Usuario::find()->where(['email' => $model->email]);
                if ($table->count() == 1) {
                    $session = new Session();
                    $session->open();
                    $session['recover'] = 'Alex' . rand(100000, 999999) . 'andria';
                    //$recover = $session['recover'];
                    //$table = Usuario::find()->where("email:=email", [":email" => $model->email]);
                    $table = Usuario::findOne(['email' => $model->email]);
                    $session['id_recover'] = $table->id;
                    $verification_code = 'Alex' . rand(1000, 9999) . 'andria';
                    $table->codigo_verificacion = $verification_code;
                    $table->save();

                    $subject = "Recuperar contraseña";
                    $body = "<p>Copie el siguiente código de verificación para restablecer su contraseña</p>";
                    $body .= "<strong>" . $verification_code . "</strong>";
                    $body .= "<p><a href='http://localhost/libreria/web/index.php?r=sitio/inicio/restablecer-contrasenha'>Restablecer contraseña</a></p>";

                    \Yii::$app->mailer->compose()
                            ->setTo($model->email)
                            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['title']])
                            ->setSubject($subject)
                            ->setTextBody($body)
                            ->send();
                    $model->email = NULL;
                    Yii::$app->session->setFlash('success', 'Le hemos enviado un mensaje a su cuenta de correo para que pueda recuperar su contraseña', false);
                } else {
                    Yii::$app->session->setFlash('danger', 'Ese usuario no existe', false);
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('recuperar-contrasenha', ['model' => $model]);
    }

    public function actionRestablecerContrasenha() {
        $model = new RestablecerContrasenha();
        //$msg = NULL;
        $session = new Session();
        $session->open();
        if (empty($session['recover']) || empty($session['id_recover'])) {
            return $this->redirect('sitio/inicio/autenticar');
        } else {
            $recover = $session['recover'];
            $model->recover = $recover;
            $id_recover = $session['id_recover'];
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($recover == $model->recover) {
                    $table = Usuario::findOne(['email' => $model->email, 'id' => $id_recover, 'verification_code' => $model->codigo_verificacion]);
                    $table->password = crypt($model->password, Yii::$app->params['salt']);
                    if ($table->save()) {
                        $session->destroy();
                        $model->email = NULL;
                        $model->password = NULL;
                        $model->password_repeat = NULL;
                        $model->recover = NULL;
                        $model->verification_code = NULL;
                        Yii::$app->session->setFlash('success', 'Contraseña restablecida correctamente', false);
                        //$msg .= "<meta http-equiv='refresh' content='5; ".Url::toRoute("sitio/autenticar")."' >";
                    } else {
                        Yii::$app->session->setFlash('danger', 'Lo sentimos, ha ocurrido un error', false);
                    }
                } else {
                    $model->getErrors();
                }
            }
        }
        return $this->render("Restablecer", ['class' => 'btn btn-primary']);
    }
    
}
