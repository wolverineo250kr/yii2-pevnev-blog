<?php

namespace wolverineo250kr\blog\modules\frontend\assets;
 
use Yii;
use yii\web\AssetBundle;

class PevnevBlogGroupAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    public $css        = [
        'css/blog-index'.((YII_DEBUG) ? '' : '.min').'.css?v1.00',
		'css/font-awesome/css/font-awesome.css',
    ];
    public $js        = [
        'js/blog-index'.((YII_DEBUG) ? '' : '.min').'.js?v1.02',
    ];
    public $depends    = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset'
    ];
}
