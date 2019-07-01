<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Collect as CollectModel;

/**
 * Collect represents the model behind the search form of `common\models\Collect`.
 */
class Collect extends CollectModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'm_id', 'num', 'status', 'create_addtime', 'update_addtime'], 'integer'],
            [['name', 'encoding', 'baseconfig', 'listconfig', 'arcconfig', 'create_user', 'update_user'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CollectModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'm_id' => $this->m_id,
            'num' => $this->num,
            'status' => $this->status,
            'create_addtime' => $this->create_addtime,
            'update_addtime' => $this->update_addtime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'encoding', $this->encoding])
            ->andFilterWhere(['like', 'baseconfig', $this->baseconfig])
            ->andFilterWhere(['like', 'listconfig', $this->listconfig])
            ->andFilterWhere(['like', 'arcconfig', $this->arcconfig])
            ->andFilterWhere(['like', 'create_user', $this->create_user])
            ->andFilterWhere(['like', 'update_user', $this->update_user]);

        return $dataProvider;
    }
}
