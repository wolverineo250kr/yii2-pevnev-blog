<?php

namespace wolverineo250kr\blog;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'wolverineo250kr\blog\controllers';
    public $defaultRoute        = 'default';

    public function bootstrap($app)
    {

    }

public function init()
    {
        parent::init();
    }
}