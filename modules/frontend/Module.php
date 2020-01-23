<?php

namespace wolverineo250kr\blog\modules\frontend;

use yii\base\BootstrapInterface;

/**
 * blog submodule definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'wolverineo250kr\blog\modules\frontend\controllers';
    public $defaultRoute        = 'blog';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $rules = [
             '/blog' => '/blog/default/index',
             '/blog/<url:[\/\w\.\-]+$>' => '/blog/default/view',
        ];
        $app->getUrlManager()->addRules($rules, false);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}