<?php

use app\models\TipoLiteratura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model TipoLiteratura */

$this->title = 'Crear Tipo de Literatura';
$this->menu_activo = 'suministrador';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Literatura', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-literatura-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/tipo-literatura/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
