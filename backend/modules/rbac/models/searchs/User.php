<?php

namespace rbac\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rbac\models\User as UserModel;

/**
 * User represents the model behind the search form about `rbac\models\User`.
 */
class User extends UserModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * 用户列表（筛选）
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserModel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }
}
