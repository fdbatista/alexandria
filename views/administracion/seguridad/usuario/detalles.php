<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Usuario */

$this->title = 'Vista previa';
$this->menu_activo = 'usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['inicio']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::tag('a', "<i class='fa fa-arrow-left'></i> Regresar", ['class' => 'btn btn-primary', 'href' => Url::toRoute('administracion/seguridad/usuario/inicio')]) ?>
        <?= Html::a('Modificar', ['actualizar', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre_completo',
            'nombre_usuario',
            [
                'label' => 'Rol',
                'attribute' => 'idRol.nombre',
            ],
            'email',
            'activo:boolean',
//            'habilitado_sala_comercial:boolean',
        ],
    ])
    ?>

</div>
