<?php

use app\models\MiPerfil;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model MiPerfil */

$this->title = 'Mi Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <div class="row">

        <div class="col-lg-12">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Nombre completo',
                        'value' => $model->usuario->nombre1 . ' ' . $model->usuario->nombre2 . ' ' . $model->usuario->apellido1 . ' ' . $model->usuario->apellido2
                    ],
                    [
                        'label' => 'Nombre de usuario',
                        'attribute' => 'usuario.nombre_usuario',
                    ],
                    [
                        'label' => 'Rol',
                        'attribute' => 'usuario.idRol.nombre',
                    ],
                    [
                        'label' => 'Email',
                        'attribute' => 'usuario.email',
                    ],
                    [
                        'label' => 'Activo',
                        'value' => $model->usuario->activo === true ? 'Sí' : 'No'
                    ],
//                        [
//                        'label' => 'Habilitado Sala Comercial',
//                        'value' => $model->usuario->habilitado_sala_comercial === true ? 'Sí' : 'No'
//                    ],
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="h5 title-block-1"><b>Cambiar contrase&ntilde;a</b></div>
                </div>

                <div class="panel-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="col-lg-3">
                        <?= $form->field($model, 'contrasenhaActual')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('contrasenhaActual')])->label(false) ?>
                    </div>
                    <div class="col-lg-3">
                        <?= $form->field($model, 'contrasenhaNueva')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('contrasenhaNueva')])->label(false) ?>
                    </div>
                    <div class="col-lg-3">
                        <?= $form->field($model, 'contrasenhaConfirmacion')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('contrasenhaConfirmacion')])->label(false) ?>
                    </div>
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-refresh"></i> Cambiar contrase&ntilde;a</button>
                    </div>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

</div>

