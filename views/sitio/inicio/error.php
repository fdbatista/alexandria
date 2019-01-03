<?php
/* @var $this View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Error';
if ($exception->getPrevious()) {
    $prevmsg = $exception->getPrevious()->getMessage();
    $first = substr($prevmsg, 9, 5);
    $this->registerJs("if (window.location.href.indexOf('administracion') != -1) {window.location.href = '" . Url::to(['/administracion/inicio/error', 'm' => $first]) . "';}", View::POS_BEGIN);
}
else{
    $this->registerJs("if (window.location.href.indexOf('administracion') != -1) {window.location.href = '" . Url::to(['/administracion/inicio/error', 'm' => '222']) . "';}", View::POS_BEGIN);
}
?>
<div class="site-error">
    <div class="alert alert-danger">
        <i class="fa fa-warning"></i> <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Contacte al administrador del sistema si considera que se trata de un error.
    </p>

</div>
