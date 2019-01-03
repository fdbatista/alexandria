<?php

use app\models\Pais;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Pais */

$this->title = 'Crear País';
$this->menu_activo = 'pais';
$this->params['breadcrumbs'][] = ['label' => 'País', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pais-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/pais/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
