<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * QuotationSearch represents the model behind the search form of `backend\models\Quotation`.
 */
class QueryinboundSearch extends Queryinbound
{
    public $globalSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_date', 'permit_date', 'transport_in_date'], 'safe'],
            [['supplier_id', 'line_qty'], 'integer'],
            [['line_price', 'currency_rate'], 'number'],
            [['invoice_no', 'docin_no', 'permit_no', 'transport_in_no', 'name', 'currency_name', 'unit_name'], 'string', 'max' => 255],
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
        $query = Queryinbound::find();

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
