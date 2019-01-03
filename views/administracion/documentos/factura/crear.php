<?php

use app\models\Factura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Factura */

$this->title = 'Crear Factura';
$this->menu_activo = 'factura';
$this->params['breadcrumbs'][] = ['label' => 'Facturas', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="factura-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/documentos/factura/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
