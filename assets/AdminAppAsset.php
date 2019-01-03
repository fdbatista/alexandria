<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'plugins/admin/css/bootstrap.min.css',
        'plugins/admin/css/admin.css',
        'css/font-awesome.min.css',
        'css/estilo-plano.css',
    ];
    public $js = [
        //'plugins/admin/js/jquery.min.js',
        'plugins/admin/js/bootstrap.min.js',
        'plugins/admin/js/metisMenu.min.js',
        'plugins/admin/js/admin.js',
        'plugins/tooltip-init.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
