<?php

namespace app\assets;

use yii\web\AssetBundle;

class HighChartsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/highcharts/css/highcharts.css',
    ];
    public $js = [
        'plugins/highcharts/js/highcharts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\AppAsset',
    ];
}
