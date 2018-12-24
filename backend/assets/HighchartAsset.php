<?php
namespace backend\assets;
use yii\web\AssetBundle;

class HighchartAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'highcharts\highcharts.js',
        'highcharts\highcharts-more.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
