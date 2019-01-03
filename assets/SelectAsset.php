<?php

namespace app\assets;

use yii\web\AssetBundle;

class SelectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/select2/css/select2.css',
    ];
    public $js = [
        'plugins/select2/js/select2.js',
        'plugins/select2/init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
