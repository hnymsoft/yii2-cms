<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Flink as FlinkModel;

/**
 * Flink represents the model behind the search form of `common\models\Flink`.
 */
class Flink extends FlinkModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'typeid', 'order', 'status', 'addtime'], 'integer'],
            [['webname', 'linkurl', 'logo', 'introduce'], 'safe'],
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
        $query = FlinkModel::find();

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
            'typeid' => $this->typeid,
            'order' => $this->order,
            'status' => $this->status,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'webname', $this->webname])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'introduce', $this->introduce]);

        return $dataProvider;
    }
}
