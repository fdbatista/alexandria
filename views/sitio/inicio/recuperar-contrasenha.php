<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model \common\models\RecuperarContrasenha */

$this->title = 'Recuperar contraseña';
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
            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('email')]) ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i> Enviar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>