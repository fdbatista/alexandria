<?php

use app\models\TipoPublico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model TipoPublico */

$this->title = 'Crear Tipo de Público';
$this->menu_activo = 'tipo-publico';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Público', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-publico-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/nomencladores/tipo-publico/inicio')]) ?>
    </p>


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
