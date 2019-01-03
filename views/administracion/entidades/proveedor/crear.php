<?php

use app\models\Almacen;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Almacen */

$this->title = 'Crear Proveedor';
?>
<div class="almacen-create">

    <h2><?= Html::encode($this->title) ?></h2>
    
    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/proveedor/inicio')]) ?>
    </p>


    <?= $this->render('_form', ['model' => $model, 'id_prov' => $id_prov, 'municipios' => $municipios, 'provincias' => $provincias]) ?>

</div>
