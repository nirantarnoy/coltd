<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * QuotationSearch represents the model behind the search form of `backend\models\Quotation`.
 */
class QuerypickingSearch extends Querypicking
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['picking_date', 'inv_date', 'kno_out_date', 'transport_out_date'], 'safe'],
            [['customer_country'], 'integer'],
            [['qty', 'price'], 'number'],
            [['unit_name', 'inv_no', 'trans_out_no', 'kno_out_no', 'transport_out_no', 'customer_name'], 'string', 'max' => 255],
            [['country_name'], 'string', 'max' => 100],
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
        $query = Querypicking::find();

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
           // 'id' => $this->id,
            //'sale_no' => $this->sale_no,
           // 'product_id' => $this->product_id,
            //'picking_date' => $this->picking_date,
           // 'transport_in_no' => $this->transport_in_no,
           // 'product_group' => $this->product_group,
           // 'qty'=> $this->qty,
           // 'permit_no' => $this->permit_no,
           // 'customer_name' => $this->customer_name,
           // 'currency_name' => $this->currency_name

        ]);

//        if($this->globalSearch !='') {
//            $query->orFilterWhere(['like', 'quotation_no', $this->globalSearch])
//                ->orFilterWhere(['like', 'customer_ref', $this->globalSearch])
//                ->orFilterWhere(['like', 'note', $this->globalSearch]);
//        }
        return $dataProvider;
    }
}
