<?php
/* @var $this View */
/* @var $form ActiveForm */
/* @var $model \common\models\LoginForm */

use app\models\ConfigApp;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$nombre_app = ConfigApp::findOne(1)->nombre_app;
$this->title = $nombre_app;

?>
<div class="site-login">
    
    <div class="login-form sombra">
        
        <?= /*Yii::$app->security->generatePasswordHash('a')*/'' ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="text-center etiqueta">
                    <h3>Bienvenido a <?= $nombre_app ?></h3>
                    <p>Por favor, introduzca sus credenciales<br />de usuario para continuar:</p><br />
                </div>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
                
            </div>
            <div class="col-lg-12">
                <button class="btn btn-primary form-control login-button" type="submit" name="login-button"><i class="fa fa-sign-in"></i> Aceptar</button>
            </div>
            <div class="col-lg-12">
                <?= Html::a("¿Olvid&oacute; su contrase&ntilde;a?", Url::toRoute('sitio/inicio/recuperar-contrasenha')) ?>
            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
