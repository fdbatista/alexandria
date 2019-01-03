<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ProductoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'precio_venta') ?>

    <?= $form->field($model, 'precio_costo') ?>

    <?php // echo $form->field($model, 'existencia') ?>

    <?php // echo $form->field($model, 'tomo') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'volumen') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'anho_revista') ?>

    <?php // echo $form->field($model, 'issn') ?>

    <?php // echo $form->field($model, 'isbn') ?>

    <?php // echo $form->field($model, 'anho_edicion') ?>

    <?php // echo $form->field($model, 'id_genero') ?>

    <?php // echo $form->field($model, 'id_tematica') ?>

    <?php // echo $form->field($model, 'id_tipo_literatura') ?>

    <?php // echo $form->field($model, 'id_tipo_publico') ?>

    <?php // echo $form->field($model, 'id_frecuencia') ?>

    <?php // echo $form->field($model, 'id_editorial') ?>

    <?php // echo $form->field($model, 'id_tipo_producto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
