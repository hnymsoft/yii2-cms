<?php

namespace common\models;

use Yii;

/**
 * Class AttachTable
 * @package common\models
 */
class AttachTable extends BaseModel
{
    public static $tableName = 'am_';

    public function __construct($table = '',array $config = [])
    {
        static::$tableName = $table;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return static::$tableName;
    }
}
