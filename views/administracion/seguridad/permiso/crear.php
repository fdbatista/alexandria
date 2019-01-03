<?php

use app\models\Permiso;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Permiso */

$this->title = 'Crear Permiso';
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/permiso/inicio')]) ?>

    </p>

    <?=
    $this->render('_form', ['model' => $model,
    ])
    ?>

</div>
