<?php

use app\models\TipoProducto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model TipoProducto */

$this->title = 'Crear Tipos de Productos';
$this->menu_activo = 'tipo-producto';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Productos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-producto-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/tipo-producto/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
