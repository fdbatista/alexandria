<?php

use app\models\Deterioro;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Deterioro */

$this->title = 'Crear Deterioro';
$this->menu_activo = 'deterioro';
$this->params['breadcrumbs'][] = ['label' => 'Deterioros', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deterioro-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?=
    $this->render('_form', [
        'model' => $model,
        'usuarios' => $usuarios,
        'esLibrero' => $esLibrero
    ])
    ?>

</div>
