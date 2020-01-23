<?php

namespace wolverineo250kr\blog\modules\frontend\assets;

use Yii;
use yii\web\AssetBundle;

class PevnevBlogAsset extends AssetBundle
{
    public $sourcePath     = __DIR__;
    public $css        = [
        'css/blog-view'.((YII_DEBUG) ? '' : '.min').'.css?v1.05',
					'css/font-awesome/css/font-awesome.css',
    ];
	    public $js        = [
        'js/blog-view'.((YII_DEBUG) ? '' : '.min').'.js?v1.10',
    ];
    public $cssOptions = [
        'onload' => "if(media!='all') media='all'"
    ];
    public $depends    = [
	    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset'		
    ];

}
