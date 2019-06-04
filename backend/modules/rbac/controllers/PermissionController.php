<?php

namespace rbac\controllers;

use rbac\components\ItemController;
use yii\rbac\Item;

/**
 * 权限
 * @package rbac\controllers
 */
class PermissionController extends ItemController
{

    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'Item' => 'Permission',
            'Items' => 'Permissions',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_PERMISSION;
    }
}
