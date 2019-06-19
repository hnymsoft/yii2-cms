<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Channel as ChannelModel;

/**
 * Channel represents the model behind the search form of `common\models\Channel`.
 */
class Channel extends ChannelModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'm_id', 'p_id', 'status', 'order', 'create_addtime', 'update_addtime'], 'integer'],
            [['name', 'list_tpl', 'content_tpl', 'out_url', 'seo_title', 'seo_keyword', 'seo_description', 'create_user', 'update_user'], 'safe'],
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
        $query = ChannelModel::find();

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
            'p_id' => $this->p_id,
            'status' => $this->status,
            'order' => $this->order,
            'create_addtime' => $this->create_addtime,
            'update_addtime' => $this->update_addtime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'list_tpl', $this->list_tpl])
            ->andFilterWhere(['like', 'content_tpl', $this->content_tpl])
            ->andFilterWhere(['like', 'out_url', $this->out_url])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'create_user', $this->create_user])
            ->andFilterWhere(['like', 'update_user', $this->update_user]);

        return $dataProvider;
    }
}
