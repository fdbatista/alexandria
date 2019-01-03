<?php

use app\models\EfectivoEntrega;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model EfectivoEntrega */

$this->title = 'Crear Efectivo Entrega';
?>
<div class="efectivo-entrega-create">

    <h2><?= Html::encode($this->title) ?></h2>
    
    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/efectivo-entrega/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
