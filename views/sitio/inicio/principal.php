<?php

use app\models\ConfigApp;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
$nombre_app = ConfigApp::findOne(1)->nombre_app;
$this->title = $nombre_app;
?>
<div class="site-index">

    <div class="jumbotron etiqueta">
        <h2>Bienvenido a <?= $nombre_app ?>,</h2>
        <p class="lead">el Sistema Inform&aacute;tico para la Gesti&oacute;n y Control de Informaci&oacute;n de las Librer&iacute;as</p>
        <br/>
                        
    </div>

    <!--<div class="body-content">

        <div class="row etiqueta">
            <div class="col-lg-4 text-center">
                <h1><i class="fa fa-bar-chart fa-2x"></i></h1>
                <p>
                    Obtenga informaci&oacute;n detallada sobre su librer&iacute;a.
                </p>
                <p><a class="btn btn-success" href="<?= Url::to(['/reportes/inicio']) ?>">Ir a Reportes &raquo;</a></p>
            </div>
            <div class="col-lg-4 text-center col-lg-offset-4">
                <h1 class="etiqueta "><i class="fa fa-gears fa-2x"></i></h1>
                <p>
                    Modifique la configuraci&oacute;n general de la aplicaci&oacute;n.
                </p>
                <p><a class="btn btn-success" href="<?= Url::to(['/administracion/inicio']) ?>">Ir a Administraci&oacute;n &raquo;</a></p>
            </div>
        </div>

    </div>-->
</div>
