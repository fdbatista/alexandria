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
class AngularJSAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/angularjs/angucomplete-alt/angucomplete-alt.css',
        'plugins/angularjs/lib/angular-ui/select.css',
    ];
    public $js = [
        'plugins/angularjs/lib/angular.min.js',
        'plugins/angularjs/lib/angular-route.min.js',
        'plugins/angularjs/lib/angular-resource.min.js',
        'plugins/angularjs/lib/angular-sanitize.min.js',
        'plugins/angularjs/lib/angular-ui/select.min.js',
        'plugins/angularjs/angucomplete-alt/angucomplete-alt.js',
        'plugins/angularjs/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
