<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */

$this->title = 'Restablecer contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-recover">

    <h2><?= Html::encode($this->title) ?></h2>
    <br />

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <?php
    $form = ActiveForm::begin([
                'method' => 'post',
                'enableClientValidation' => true,
    ]);
    ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, "email")->input("email"); ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'password')->input('password'); ?>
        </div>        
        <div class="col-lg-4">
            <?= $form->field($model, 'password_repeat')->input('password'); ?>
        </div>        
        <div class="col-lg-4">
            <?= $form->field($model, 'verification_code')->input('text'); ?>
        </div>        
        <div class="col-lg-4">
            <?= $form->field($model, 'recover')->input('hidden')->label(false); ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>