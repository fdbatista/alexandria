<?php
/* @var $this View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Url;
use yii\web\View;

$this->title = 'Error';
?>
<div class="site-error">
    <div class="alert alert-danger">
        <i class="fa fa-warning"></i> 
        <?php
            switch ($_GET['m']) {
                case '23503':
                    echo " <b>Error:</b> Este elemento no puede ser eliminado porque está siendo usado actualmente.";
                    break;
                case '15215':
                    echo " <b>Error:</b> Esta Transferencia no puede ser eliminada"
                    . " porque la cantidad de productos a eliminar es mayor que la existente.";
                    break;
                case '222':
                    echo "<b>Error:</b> No tiene acceso al recurso solicitado.";
                    break;
                default:
                    echo "<b>Error:</b> No se puede acceder al recurso solicitado.";
                    break;
            }
        ?>
    </div>
    <p>
        Contacte al administrador del sistema si considera que se trata de un error.
    </p>
    <a class="btn btn-primary" href="<?= Url::previous() ?>">Volver</a>
</div>
