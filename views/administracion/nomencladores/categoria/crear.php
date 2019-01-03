<?php

use app\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Categoria */

$this->title = 'Crear Categoría';
$this->menu_activo = 'categoria';
$this->params['breadcrumbs'][] = ['label' => 'Categorías', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/categoria/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
