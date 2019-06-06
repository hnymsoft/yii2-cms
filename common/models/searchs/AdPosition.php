<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdPosition as AdPositionModel;

/**
 * AdPosition represents the model behind the search form of `common\models\AdPosition`.
 */
class AdPosition extends AdPositionModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_id', 'ad_width', 'ad_height'], 'integer'],
            [['position_name', 'position_desc', 'position_style'], 'safe'],
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
        $query = AdPositionModel::find();

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
            'position_id' => $this->position_id,
            'ad_width' => $this->ad_width,
            'ad_height' => $this->ad_height,
        ]);

        $query->andFilterWhere(['like', 'position_name', $this->position_name])
            ->andFilterWhere(['like', 'position_desc', $this->position_desc])
            ->andFilterWhere(['like', 'position_style', $this->position_style]);

        return $dataProvider;
    }
}
