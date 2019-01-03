<?php

use app\assets\SelectAsset;
use app\models\search\AutorSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $searchModel AutorSearch */
/* @var $dataProvider ActiveDataProvider */
SelectAsset::register($this);
$this->title = 'Autores';
?>
<div class="autor-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/miscelaneas/producto/inicio')]) ?>
    </p>

    <br/>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= Html::dropDownList('id_autor', null, ArrayHelper::map($autores, 'id', 'nombreCompleto'), ['prompt' => 'Seleccione...', 'class' => 'form-control select2me', 'required']) ?>
        </div>
        <div class="col-lg-3">
            <?= Html::submitButton('Agregar', ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
    
    <br/>

    <?php ActiveForm::end(); ?>

    <table class="table table-bordered table-striped">
        <tr>
            <th>Autor</th>
            <th>Acciones</th>
        </tr>
        <?php
        foreach ($prodAutores as $prodAutor) {
            echo '<tr><td>' . $prodAutor->idAutor->getNombreCompleto() . '</td><td></td></tr>';
        }
        ?>
    </table>
</div>
