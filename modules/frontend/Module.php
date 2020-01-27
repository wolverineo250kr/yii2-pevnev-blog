<?php

namespace wolverineo250kr\blog\modules\frontend;

use yii\base\BootstrapInterface;

/**
 * blog submodule definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface {

    public $controllerNamespace = 'wolverineo250kr\blog\modules\frontend\controllers';
	
	/**
     * Route can be set in app confic if needed
     * @var str
    */
    public $defaultRoute = 'blog';
 
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app) {
        $rules = [
            '/'.$this->defaultRoute => '/blog/default/index',
            '/'.$this->defaultRoute.'/<url:[\/\w\.\-]+$>' => '/blog/default/view',
        ];
        $app->getUrlManager()->addRules($rules, false);
    }

    public function init() {
        parent::init();

        // custom initialization code goes here
    }

}
