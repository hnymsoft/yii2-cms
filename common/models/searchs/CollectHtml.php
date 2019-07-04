<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CollectHtml as CollectHtmlModel;

/**
 * CollectHtml represents the model behind the search form of `common\models\CollectHtml`.
 */
class CollectHtml extends CollectHtmlModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'c_id', 'p_id', 'create_addtime', 'is_down', 'is_export'], 'integer'],
            [['title', 'url', 'hash', 'content'], 'safe'],
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
        $query = CollectHtmlModel::find();

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
            'c_id' => $this->c_id,
            'p_id' => $this->p_id,
            'create_addtime' => $this->create_addtime,
            'is_down' => $this->is_down,
            'is_export' => $this->is_export,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'hash', $this->hash])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
