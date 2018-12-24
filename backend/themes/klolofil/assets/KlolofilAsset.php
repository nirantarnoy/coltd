<?php
namespace backend\themes\klolofil\assets;

use yii\web\AssetBundle;

class KlolofilAsset extends AssetBundle
{
    public $sourcePath = '@klolofil/dist';
    public $css = [
    'vendor/bootstrap/css/bootstrap.min.css',
	'vendor/font-awesome/css/font-awesome.min.css',
	'vendor/linearicons/style.css',
	'vendor/chartist/css/chartist-custom.css',
	'css/main.css',
	'css/demo.css',
	'img/apple-icon.png',
	'img/favicon.png'
    ];

    public $js = [
    //'vendor/jquery/jquery.js',
    //'vendor/jquery/jquery.min.js',
    'vendor/bootstrap/js/bootstrap.min.js',
	'vendor/jquery-slimscroll/jquery.slimscroll.min.js',
	'vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js',
	'vendor/chartist/js/chartist.min.js',
	'scripts/klorofil-common.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'agency\assets\FontAwesomeAsset'
    ];
}