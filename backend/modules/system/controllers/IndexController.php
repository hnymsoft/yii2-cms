<?php

namespace system\controllers;

use backend\controllers\BaseController;
use common\models\Content;
use common\models\Guestbook;
use common\models\Member;
use common\models\Module;

/**
 * Class IndexController
 * @package system\controllers
 */
class IndexController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionWelcome()
    {
        //模型
        $model = Module::find()->select('id,name')->where(['status'=>1])->limit(8)->asArray()->all();
        foreach ($model as $key => $val){
            $model[$key]['count'] = 0;
            $count = Content::find()->where(['m_id'=>$val['id']])->count();
            if($count){
                $model[$key]['count'] = $count;
            }
        }

        $sdt = strtotime(date('Y-m-d 00:00:00'));
        $edt = strtotime(date('y-m-d 23:59:59'));
        $arc_count = Content::find()->where('1=1')->andFilterWhere(['BETWEEN','create_addtime',$sdt, $edt])->count();

        //待审核内容统计
        $arc_audit_count = Content::find()->where(['status'=>0])->count();

        //最新留言
        $gb_count = Guestbook::find()->where('1=1')->andFilterWhere(['BETWEEN','addtime',$sdt, $edt])->count();

        //待审核留言
        $gb_audit_count = Guestbook::find()->where(['status' => 0])->count();

        //最新文章数
        $list = Content::find()->orderBy('id desc')->limit(6)->all();

        //系统信息
        $system_info = [
            'os' => PHP_OS,
            'ip' => $_SERVER['SERVER_ADDR'],
            'web_server' => $_SERVER['SERVER_SOFTWARE'],
            'php_ver' => PHP_VERSION,
            'mysql_ver' => \Yii::$app->db->getServerVersion(),
            'zlib' => function_exists('gzclose') ? 'Yes' : 'No',
            'safe_mode' => (boolean) ini_get('safe_mode') ? 'Yes' : 'No',
            'safe_mode_gid' => (boolean) ini_get('safe_mode_gid') ? 'Yes' : 'No',
            'time_zone' => function_exists("date_default_timezone_get")?date_default_timezone_get():'no_timezone',
            'socket' => function_exists('fsockopen') ? 'Yes' : 'No',
            'gd' => function_exists('gd_info') ? 'Yes' : 'No',
            'max_filesize' => ini_get('upload_max_filesize')
        ];
        return $this->render('welcome',[
            'model' => $model,
            'sysinfo' => $system_info,
            'arc_count' => $arc_count,
            'arc_audit_count' => $arc_audit_count,
            'gb_count' => $gb_count,
            'gb_audit_count' => $gb_audit_count,
            'list' => $list,
        ]);
    }

    /**
     * 文章发布数量统计
     * @return string
     */
    public function actionAjaxarticlecount(){
        $days = $this->getDays(7);

        $sdt = strtotime(date('Y-m-d 00:00:00',strtotime("-1 week +1 day"))); //最近一周
        $edt = strtotime(date('Y-m-d 23:59:59'));
        $model = Content::find()
                ->select(['count(1) AS count,FROM_UNIXTIME(`create_addtime`,"%Y-%m-%d") AS date'])
                ->andFilterWhere(['BETWEEN','create_addtime',$sdt,$edt])
                ->groupBy('date')
                ->asArray()
                ->all();
        if(!$model){
            return ajaxReturnFailure('数据不存在');
        }
        foreach ($days AS $key => $val){
            $data['date'][$key] = $val;
            $data['count'][$key] = 0;
            foreach ($model AS $key2 => $val2){
                if($val == $val2['date']){
                    $data['count'][$key] = $val2['count'];
                }
            }
        }
        return ajaxReturnSuccess('一切正常',$data);
    }

    /**
     * 模型发布数量统计
     * @return string
     */
    public function actionAjaxmodelcount(){
        $model = Module::find()
            ->alias('m')
            ->select('COUNT(c.m_id) AS count,m.name')
            ->leftJoin(Content::tableName().' AS c','c.m_id = m.id')
            ->where(['m.status'=>1])
            ->groupBy('c.m_id')
            ->orderBy('m.id')
            ->asArray()
            ->all();
        if(!$model){
            return ajaxReturnFailure('数据不存在');
        }
        $data = [];
        foreach ($model AS $key => $val){
            $data['name'][] = $val['name'];
            $data['count'][] = $val['count'];
        }
        return ajaxReturnSuccess('一切正常',$data);
    }

    /**
     * 会员注册数量统计
     * @return string
     */
    public function actionAjaxusercount(){
        $days = $this->getDays(7);
        $sdt = strtotime(date('Y-m-d 00:00:00',strtotime("-1 week +1 day"))); //最近一周
        $edt = strtotime(date('Y-m-d 23:59:59'));
        $model = Member::find()
            ->select(['count(1) AS count,FROM_UNIXTIME(`created_at`,"%Y-%m-%d") AS date'])
            ->andFilterWhere(['BETWEEN','created_at',$sdt,$edt])
            ->groupBy('date')
            ->asArray()
            ->all();
        if(!$model){
            return ajaxReturnFailure('数据不存在');
        }
        foreach ($days AS $key => $val){
            $data['date'][$key] = $val;
            $data['count'][$key] = 0;
            foreach ($model AS $key2 => $val2){
                if($val == $val2['date']){
                    $data['count'][$key] = $val2['count'];
                }
            }
        }
        return ajaxReturnSuccess('一切正常',$data);
    }

    /**
     * 获取给定天数的日期
     * @param int $day
     * @return array
     */
    protected function getDays($day = 1){
        $day = ($day - 1);
        for ($i = $day;$i >= 0;$i--){
            $days[] = date('Y-m-d',strtotime("-{$i} Day"));
        }
        return $days;
    }
}
