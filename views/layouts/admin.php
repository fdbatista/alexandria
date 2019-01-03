<?php
/* @var $this View */
/* @var $content string */

use app\assets\AdminAppAsset;
use app\assets\AngularJSAsset;
use app\controllers\StaticMembers;
use app\models\ConfigApp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

AdminAppAsset::register($this);
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

        <div ng-app="LibreriaApp">

            <?php
            $anonimo = Yii::$app->user->isGuest;
            $es_admin = $anonimo ? false : Yii::$app->user->identity->id_rol === 3;
            $es_admon = $anonimo ? false : Yii::$app->user->identity->id_rol === 2;
            $nombreLibreria = '';
            $categLibreria = '';
            $config_app = ConfigApp::findOne(1);
            if ($config_app) {
                $nombreLibreria = $config_app->idLibreria->nombre;
                $categLibreria = $config_app->idCategoria->nombre;
            }
            ?>

            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-admin" href="<?= Url::to(['/administracion/inicio']) ?>"><img class="icono-navbar" src="<?= Yii::$app->homeUrl . 'img/logo.png' ?>"/><?= ' Librería ' . $categLibreria . ' ' . $nombreLibreria ?></a>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-right navbar-top-links">
                    <li><a href="<?= Url::to(['administracion/inicio/acerca-de']) ?>"><i class="fa fa-info-circle fa-navbar"></i> Acerca de</a></li>
                    <li class="<?= !StaticMembers::AccesoAModulo('sitio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/sitio/inicio']) ?>"><i class="fa fa-home fa-fw fa-navbar"></i> Puntos de Venta</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw fa-navbar"></i><?= Yii::$app->user->identity->nombre1 ?><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li class="dropdown-header">Mi cuenta</li>
                            <li><a href="<?= Url::to(['/administracion/inicio/mi-perfil']) ?>"><i class="fa fa-address-card"></i> Mi perfil</a></li>
                            <li><a href="<?= Url::to(['/sitio/inicio/salir']) ?>" data-method="post"><i class="fa fa-power-off"></i> Cerrar sesi&oacute;n</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">

                        <ul class="nav" id="side-menu">
                            <li class="<?= !StaticMembers::TienePermisoRuta('administracion/configuracion/inicio') ? 'hidden' : '' ?>">
                                <a href="<?= Url::to(['/administracion/configuracion']) ?>"><i class="fa fa-gears"></i> Configuraci&oacute;n General</a>
                            </li>

                            <li class="<?= $es_admin ? 'hidden' : '' ?>">
                                <a href="#"><i class="fa fa-archive"></i> Documentos<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/documentos/transferencia/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/documentos/transferencia']) ?>"><i class="fa fa-file-o"></i> Transferencias</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/documentos/factura/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/documentos/factura']) ?>"><i class="fa fa-file-o"></i> Facturas</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/documentos/rebaja-precio/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/documentos/rebaja-precio']) ?>" ><i class="fa fa-file-o"></i> Rebajas de Precios</a></li>
                                </ul>
                            </li>

                            <li class="<?= $es_admin ? 'hidden' : '' ?>">
                                <a href="#"><i class="fa fa-bank"></i> Entidades<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/entidades/editorial/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/entidades/editorial']) ?>"><i class="fa fa-building-o"></i> Editoriales</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/entidades/efectivo-entrega/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/entidades/efectivo-entrega']) ?>" ><i class="fa fa-building-o"></i> Efectivos Entrega</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/entidades/libreria/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/entidades/libreria']) ?>"><i class="fa fa-building-o"></i> Librer&iacute;as</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/entidades/proveedor/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/entidades/proveedor']) ?>"><i class="fa fa-building-o"></i> Proveedores</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/entidades/receptor/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/entidades/receptor']) ?>"><i class="fa fa-building-o"></i> Receptores</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/entidades/suministrador/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/entidades/suministrador']) ?>"><i class="fa fa-building-o"></i> Suministradores</a></li>
                                </ul>
                            </li>
                            
                            <li class="<?= $es_admin ? 'hidden' : '' ?>">
                                <a href="#"><i class="fa fa-arrows-alt"></i> Misceláneas<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/miscelaneas/autor/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/miscelaneas/autor']) ?>"><i class="fa fa-address-card"></i> Autores</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/miscelaneas/producto/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/miscelaneas/producto']) ?>"><i class="fa fa-shopping-cart"></i> Productos</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="#"><i class="fa fa-list-ol"></i> Nomencladores<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/asociacion/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/asociacion']) ?>" ><i class="fa fa-list"></i> Asociaciones</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/categoria/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/categoria']) ?>" ><i class="fa fa-list"></i> Categor&iacute;as</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/cuenta/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/cuenta']) ?>" ><i class="fa fa-list"></i> Cuentas</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/genero/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/genero']) ?>" ><i class="fa fa-list"></i> G&eacute;neros</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/municipio/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/municipio']) ?>" ><i class="fa fa-list"></i> Municipios</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/provincia/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/provincia']) ?>" ><i class="fa fa-list"></i> Provincias</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/pais/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/pais']) ?>" ><i class="fa fa-list"></i> Pa&iacute;ses</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/tematica/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/tematica']) ?>" ><i class="fa fa-list"></i> Tem&aacute;ticas</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/tipo-literatura/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/tipo-literatura']) ?>" ><i class="fa fa-list"></i> Tipos de Literatura</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/tipo-producto/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/tipo-producto']) ?>" ><i class="fa fa-list"></i> Tipos de Producto</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/nomencladores/tipo-publico/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/nomencladores/tipo-publico']) ?>" ><i class="fa fa-list"></i> Tipos de P&uacute;blico</a></li>
                                </ul>
                            </li>

                            <li class="<?= $es_admon ? 'hidden' : '' ?>">
                                <a href="#"><i class="fa fa-shield"></i> Seguridad<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/seguridad/permiso/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/seguridad/permiso']) ?>"><i class="fa fa-key"></i> Permisos</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/seguridad/rol/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/seguridad/rol']) ?>"><i class="fa fa-user-circle"></i> Roles</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/seguridad/usuario/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/seguridad/usuario']) ?>"><i class="fa fa-users"></i> Usuarios</a></li>
                                    <li class="<?= !StaticMembers::TienePermisoRuta('administracion/seguridad/traza/inicio') ? 'hidden' : '' ?>"><a href="<?= Url::to(['/administracion/seguridad/traza']) ?>"><i class="fa fa-search"></i> Trazas</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>

            </nav>

            <div id="page-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <br />
                        </div>
                    </div>

                    <div id="div-contenedor-gral">
                        <?= $content ?>
                    </div>

                </div>
            </div>

        </div>

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
