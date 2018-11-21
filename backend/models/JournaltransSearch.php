<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Journaltrans;

/**
 * JournaltransSearch represents the model behind the search form of `backend\models\Journaltrans`.
 */
class JournaltransSearch extends Journaltrans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'journal_id', 'product_id', 'journal_type_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty', 'line_amount'], 'number'],
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
        $query = Journaltrans::find();

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
            'journal_id' => $this->journal_id,
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'journal_type_status' => $this->journal_type_status,
            'line_amount' => $this->line_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
