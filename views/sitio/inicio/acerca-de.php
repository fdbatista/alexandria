<?php
/* @var $this View */

use yii\helpers\Html;
use yii\web\View;

$this->title = 'Acerca de ' . $nombreApp;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="titulo">
    <h2><?= Html::encode($this->title) ?> 1.0</h2>
    <h4 class="etiqueta"><i class="fa fa-info-circle"></i> Sistema Inform&aacute;tico para la Gesti&oacute;n y Control de Informaci&oacute;n de las Librer&iacute;as</h4>
    <p class="etiqueta">&copy; <?= date('Y') ?> Eileen Claudia P&eacute;rez Meneses</p>
    <!--<p class="etiqueta"><i class="fa fa-phone"></i> +53 5 476 7075</p>-->
</div>
