<?php

namespace member;

/**
 * member module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'member\controllers';

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
