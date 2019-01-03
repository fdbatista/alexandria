<?php

namespace app\assets;

use yii\web\AssetBundle;

class TypeAheadAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/typeahead/typeahead.css',
    ];
    public $js = [
        'plugins/typeahead/typeahead.js',
        'plugins/typeahead/typeahead-init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
