<?php

namespace common\models;

use Yii;

/**
 * Class AttachTable
 * @package common\models
 */
class AttachTable extends BaseModel
{
    public static $tableName = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return self::$tableName;
    }
}
