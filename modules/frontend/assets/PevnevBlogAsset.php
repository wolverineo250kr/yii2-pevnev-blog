<?php

namespace wolverineo250kr\blog\modules\frontend\assets;

use Yii;
use yii\web\AssetBundle;

class PevnevBlogAsset extends AssetBundle {
    public $sourcePath = __DIR__;
    public $css = [
        'css/blog-view' . ((YII_DEBUG) ? '' : '.min') . '.css?v1.26',
        'css/font-awesome/css/font-awesome.css',
    ];
    public $js = [
        'js/blog-view' . ((YII_DEBUG) ? '' : '.min') . '.js?v1.12',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ];
}
