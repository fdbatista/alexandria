<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Usuario */

$this->title = 'Crear Usuario';
$this->menu_activo = 'usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/usuario/inicio')]) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
