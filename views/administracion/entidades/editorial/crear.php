<?php

use app\models\Editorial;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Editorial */

$this->title = 'Crear Editorial';
?>
<div class="editorial-create">

    <h2><?= Html::encode($this->title) ?></h2>
    
    <?php include_once Yii::$app->getBasePath() . '/views/sitio/inicio/flashes.php'; ?>
    
    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/entidades/editorial/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
