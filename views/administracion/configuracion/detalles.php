<?php

use app\models\ConfigApp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model ConfigApp */

$this->title = 'Configuración General';
?>
<div class="config-app-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-refresh'></i> Modificar", ['class' => 'btn btn-warning', 'href' => Url::toRoute('administracion/configuracion/actualizar')]) ?>    
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre_app',
            [
                'label' => 'Librería',
                'attribute' => 'idLibreria.nombre',
            ],
            [
                'label' => 'Categoría de la Librería',
                'attribute' => 'idCategoria.nombre',
            ],
        ],
    ])
    ?>

</div>
