<?php

namespace core;

/**
 * core module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'core\controllers';

    /**
     * @inheritdoc
     */
    public $layout = '@backend/views/layouts/main-index2';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
