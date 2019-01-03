<?php

use app\models\ConfigApp;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = 'Administración';
$nombre_app = ConfigApp::findOne(1)->nombre_app;
?>
<div class="site-index">
    
    <div class="body-content">
        <br/>
        <br/>
        
        <div class="row">
            <?php Url::remember();?>
            <div class= "col-lg-offset-3 col-lg-9 etiqueta">
                <h2>Bienvenido a <?= $nombre_app ?>,</h2>
            </div>
            <div class= "col-lg-offset-1 col-lg-11 etiqueta">
                <p class="lead">el Sistema Inform&aacute;tico para la Gesti&oacute;n y Control de Informaci&oacute;n de las Librer&iacute;as</p>
            </div>
            
        </div>
        
    </div>

</div>

