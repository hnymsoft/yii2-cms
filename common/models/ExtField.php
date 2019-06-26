<?php

namespace common\models;

use Yii;

/**
 * Class ExtField
 * @package common\models
 */
class ExtField extends BaseModel
{
    /*
     * 字段类型
     */
    public static $input_type = [
        1 => '单行文本(varchar)',
        2 => '单行文本(char)',
        3 => '多行文本',
        4 => '整数类型',
        5 => '小数类型',
        6 => '时间类型',
        7 => '下拉框',
        8 => '单选框',
        9 => '复选框'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'am_ext_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'm_id', 'f_type', 'name', 'item'], 'required'],
            [['id', 'm_id', 'f_type', 'order'], 'integer'],
            [['name','item'], 'string', 'max' => 50],
            [['value', 'desc'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['item'],'match','pattern' => '/^[a-zA-Z]([_a-zA-Z]{3,10})$/','message' => '字段名称必须为字母、下划线等']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => '模型类型',
            'f_type' => '字段类型',
            'name' => '提示文字',
            'item' => '字段名称',
            'value' => '字段内容',
            'desc' => '字段描述',
            'order' => '排序',
        ];
    }

    /*
     * 一对一关系
     */
    public function getModules(){
        return $this->hasOne(Module::className(),['id' => 'm_id']);
    }

    /**
     * 字段处理
     * @param $type
     * @param $field_name
     * @param $field_value
     * @return string
     */
    public function fieldProcessing($type,$field_name, $field_value){
        $fields = '';
        switch ($type){
            case 1:
                $fields = " `$field_name` varchar(100) NOT NULL default '$field_value';";
                break;
            case 2:
                $fields = " `$field_name` char(100) NOT NULL default '$field_value';";
                break;
            case 3:
                $fields = " `$field_name` mediumtext;";
                break;
            case 4:
            case 6:
                if($field_value == '' || preg_match("#[^0-9-]#", $field_value)){
                    $field_value = 0;
                }
                $fields = " `$field_name` int(11) NOT NULL default '$field_value';";
                break;
            case 5:
                if($field_value == "" || preg_match("#[^0-9\.-]#", $field_value)){
                    $field_value = 0;
                }
                $fields = " `$field_name` float NOT NULL default '$field_value';";
                break;
            case 7:
            case 8:
                $field_value = str_replace(',', "','", $field_value);
                $field_value = "'".$field_value."'";
                $fields = " `$field_name` enum($field_value) DEFAULT NULL;";
                break;
            case 9:
                $fields = " `$field_name` SET($field_value) NULL;";
                break;
        }
        return $fields;
    }

    /**
     * 附加表增加列
     * @param $table
     * @param $filed_name
     * @param $filed_value
     * @param int $type
     * @param int $opt
     * @return bool
     * @throws \yii\db\Exception
     */
    public function setAttachTableField($table,$filed_name,$filed_value,$type = 1,$opt = 1){
        $field = $this->fieldProcessing($type,$filed_name,$filed_value);
        $sql = ($opt == 1) ? " ALTER TABLE `$table` ADD COLUMN $field " : " ALTER TABLE `$table` CHANGE COLUMN $field ";
        $res = Yii::$app->db->createCommand($sql)->execute();
        if($res){
            return true;
        }else{
            return false;
        }
    }
}
