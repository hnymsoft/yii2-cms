<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ad as AdModel;

/**
 * Ad represents the model behind the search form of `common\models\Ad`.
 */
class Ad extends AdModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'position_id', 'media_type', 'start_time', 'end_time', 'click_count', 'status'], 'integer'],
            [['ad_name', 'ad_link', 'ad_code', 'link_man', 'link_email', 'link_phone'], 'safe'],
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
        $query = AdModel::find()->orderBy('id desc');

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
        $query->andFilterWhere(['position_id' => $this->position_id]);
        $query->andFilterWhere(['like', 'ad_name', $this->ad_name]);

        return $dataProvider;
    }
}
