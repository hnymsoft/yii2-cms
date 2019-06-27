<?php

namespace common\models;

use Yii;

/**
 * Class Module
 * @package common\models
 */
class Module extends BaseModel
{
    //默认主表
    public $main_table = 'content';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_modules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'list_tpl', 'content_tpl','attach_table'], 'required'],
            [['attach_table'],'match','pattern'=>'/^attach_\w{3,8}$/i','message'=>'附加表必须以attach_开头且后缀长度3-8位'],
            [['attach_table'],'customValidationAttachTableUnique','skipOnEmpty' => false, 'skipOnError' => false],
            [['status', 'is_system', 'create_addtime', 'update_addtime'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['list_tpl', 'content_tpl'], 'string', 'max' => 80],
            [['create_user', 'update_user'], 'string', 'max' => 10],
        ];
    }

    /**
     * 检测附加表唯一性
     * @param $attribute
     * @param $params
     */
    public function customValidationAttachTableUnique($attribute){
        $count = static::find()->where(['attach_table' => $this->attach_table])->count();
        if($count){
            $this->addError($attribute,"附加表已存在，请选择其它名称！");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '模型名称',
            'list_tpl' => '列表页模板',
            'content_tpl' => '内容页模版',
            'status' => '是否启用',
            'main_table' => '主表',
            'attach_table' => '附加表',
            'is_system' => '是否系统模型',
            'create_user' => '创建人',
            'update_user' => '修改人',
            'create_addtime' => '创建时间',
            'update_addtime' => '修改时间',
        ];
    }

    /**
     * 新建模型 数据表初始化
     * @param $table
     * @return bool
     * @throws \yii\db\Exception
     */
    public function createModelsTable($table = ''){
        if(!$table){
            return ajaxReturnFailure('附加表不存在！');
        }
        $sql = "DROP TABLE IF EXISTS `$table`; \r\nCREATE TABLE `$table`(\r\n `id` int(11) NOT NULL default '0',\r\n `p_id` int(11) NOT NULL default '0',\r\n `body` mediumtext NOT NULL,\r\n `templet` varchar(30) NOT NULL default '',\r\n ";
        $db = \Yii::$app->db;
        $mysql_ver = $db->createCommand('SELECT VERSION() AS ver;')->queryOne();
        if($mysql_ver < 4.1){
            $sql .= " PRIMARY KEY  (`id`), KEY `".$table."_index` (`type_id`)\r\n) TYPE=MyISAM; ";
        }else if($mysql_ver >= 5.1){
            $sql .= " PRIMARY KEY  (`id`), KEY `".$table."_index` (`type_id`)\r\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
        }else{
            $sql .= " PRIMARY KEY  (`id`), KEY `".$table."_index` (`type_id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
        }
        if($db->createCommand($sql)->execute()){
            return ajaxReturnSuccess('附加表创建成功！');
        }else{
            return ajaxReturnFailure('附加表创建成功！');
        }
    }

    /**
     * 新建模型数据表 删除
     * @param string $table
     * @return bool
     * @throws \yii\db\Exception
     */
    public function dropModelsTable($table = ''){
        if(!$table){
            return ajaxReturnFailure('附加表不存在！');
        }
        if(strpos($table,'attach_') === false){
            return ajaxReturnFailure('非附加表不允许删除！');
        }
        //系统模型不允许删除
        if(in_array($table,['attach_news','attach_image','attach_product','attach_special','attach_page'])){
            return ajaxReturnFailure('系统模型附加表不允许删除！');
        }
        $sql = "DROP TABLE IF EXISTS `$table`; ";

        $db = \Yii::$app->db;
        if($db->createCommand($sql)->execute()){
            return ajaxReturnSuccess('附加表删除成功');
        }else{
            return ajaxReturnFailure('附加表删除失败');
        }
    }
}
