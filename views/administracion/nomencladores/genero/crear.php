<?php

use app\models\Genero;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Genero */

$this->title = 'Crear Género';
$this->menu_activo = 'genero';
$this->params['breadcrumbs'][] = ['label' => 'Géneros', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genero-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/genero/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
