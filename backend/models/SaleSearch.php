<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Sale;

/**
 * SaleSearch represents the model behind the search form of `backend\models\Sale`.
 */
class SaleSearch extends Sale
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'revise', 'require_date', 'customer_id', 'delvery_to', 'currency', 'sale_id', 'quotation_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['sale_no', 'customer_ref', 'note'], 'safe'],
            [['disc_amount', 'disc_percent', 'total_amount'], 'number'],
            [['globalSearch'],'string'],
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
        $query = Sale::find();

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
            'revise' => $this->revise,
            'require_date' => $this->require_date,
            'customer_id' => $this->customer_id,
            'delvery_to' => $this->delvery_to,
            'currency' => $this->currency,
            'sale_id' => $this->sale_id,
            'disc_amount' => $this->disc_amount,
            'disc_percent' => $this->disc_percent,
            'total_amount' => $this->total_amount,
            'quotation_id' => $this->quotation_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'sale_no', $this->globalSearch])
                ->orFilterWhere(['like', 'customer_ref', $this->globalSearch])
                ->orFilterWhere(['like', 'note', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
