<?php
/* @var $this View */
/* @var $content string */

use app\assets\AngularJSAsset;
use app\assets\AppAsset;
use app\controllers\StaticMembers;
use app\models\ConfigApp;
use yii\bootstrap\Html as Html2;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
AngularJSAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" type="image/png" href="<?= Yii::$app->homeUrl . 'img/favicon.png' ?>">
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap" ng-app="LibreriaApp">

            <?php
            $anonimo = Yii::$app->user->isGuest;
            $nombreLibreria = '';
            $categLibreria = '';
            $config_app = ConfigApp::findOne(1);
            if ($config_app) {
                $nombreLibreria = $config_app->idLibreria->nombre;
                $categLibreria = $config_app->idCategoria->nombre;
            }

            NavBar::begin([
                'brandLabel' => Html2::img(Yii::$app->homeUrl . 'img/logo.png') . ' Librería ' . $categLibreria . ' ' . $nombreLibreria,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                    'encodeLabels' => 'false',
                ],
            ]);

            $menuItems[] = ['label' => Html::tag('i', '', ['class' => 'fa fa-info-circle fa-navbar']) . ' Acerca de', 'url' => ['sitio/inicio/acerca-de']];

            if ($anonimo) {
                $menuItems[] = ['label' => Html::tag('i', '', ['class' => 'fa fa-sign-in fa-navbar']) . ' Iniciar sesi&oacute;n', 'url' => ['sitio/inicio/autenticar']];
            } else {
                if (StaticMembers::AccesoAModulo('administracion')) {
                    $menuItems[] = ['label' => Html::tag('i', '', ['class' => 'fa fa-gears fa-navbar']) . ' Administraci&oacute;n', 'url' => ['/administracion/inicio']];
                }
                $menuItems[] = [
                    'label' => '<i class="fa fa-user fa-navbar"></i> ' . Yii::$app->user->identity->nombre1 . ' ',
                    'items' => [
                        '<li class="dropdown-header">Mi cuenta</li>',
                        '<li><a href="' . Url::to(['/sitio/inicio/mi-perfil']) . '"><i class="fa fa-address-card"></i> Mi perfil</a></li>',
                        [
                            'label' => Html::tag('i', '', ['class' => 'fa fa-power-off']) . ' Cerrar sesi&oacute;n',
                            'url' => ['sitio/inicio/salir'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                    ],
                ];
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>
            
            <nav class="menu-derecho fa-mar <?= $anonimo ? 'hidden' : '' ?>">
                <ul id="menu-derecho-contenido">
                    <li class="<?= $this->menu_activo === 'producto' ? 'menu-activo' : '' ?> <?= !StaticMembers::TienePermisoRuta('sitio/producto/inicio') ? 'hidden' : '' ?>"><a href = "<?= Url::toRoute('/sitio/producto/inicio') ?>"><i class="fa fa-2x fa-shopping-cart fa-menu-derecho"></i><span class="nav-text">Productos</span></a></li>
                    <li class="<?= $this->menu_activo === 'venta' ? 'menu-activo' : '' ?> <?= !StaticMembers::TienePermisoRuta('sitio/venta/inicio') ? 'hidden' : '' ?>"><a href = "<?= Url::toRoute('/sitio/venta/inicio') ?>"><i class="fa fa-2x fa-dollar fa-menu-derecho"></i><span class="nav-text">Ventas</span></a></li>
                    <li class="<?= $this->menu_activo === 'devolucion' ? 'menu-activo' : '' ?> <?= !StaticMembers::TienePermisoRuta('sitio/devolucion/inicio') ? 'hidden' : '' ?>"><a href = "<?= Url::toRoute('/sitio/devolucion/inicio') ?>"><i class="fa fa-2x fa-arrow-left fa-menu-derecho"></i><span class="nav-text">Devoluciones</span></a></li>
                    <li class="<?= $this->menu_activo === 'deterioro' ? 'menu-activo' : '' ?> <?= !StaticMembers::TienePermisoRuta('sitio/deterioro/inicio') ? 'hidden' : '' ?>"><a href = "<?= Url::toRoute('/sitio/deterioro/inicio') ?>"><i class="fa fa-2x fa-trash fa-menu-derecho"></i><span class="nav-text">Deterioros</span></a></li>
                    <li class="<?= $this->menu_activo === 'grafico' ? 'menu-activo' : '' ?> <?= !StaticMembers::TienePermisoRuta('sitio/grafico/inicio') ? 'hidden' : '' ?>"><a href = "<?= Url::toRoute('/sitio/grafico/inicio') ?>"><i class="fa fa-2x fa-bar-chart fa-menu-derecho"></i><span class="nav-text">Gr&aacute;ficos</span></a></li>
                </ul>
            </nav>

            <div class="">
                <div id="div-contenedor-gral">
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                    <?= $content ?>
                </div>
            </div>
        </div>

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
