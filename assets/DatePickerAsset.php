<?php

namespace app\assets;

use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/datetimepicker/jquery.datetimepicker.css',
    ];
    public $js = [
        'plugins/datetimepicker/jquery.datetimepicker.full.min.js',
        'plugins/datetimepicker/init_date.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
